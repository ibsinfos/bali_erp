<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Automatic_timetable_ajax_controller extends CI_Controller {

    public $globalSettingsSMSDataArr = array();
    public $globalSettingsLocation = "";
    public $globalSettingsAppPackageName = "";
    public $globalSettingsRunningYear = "";
    public $globalSettingsSystemName = "";
    public $globalSettingsSystemEamil = "";
    public $globalSettingsSystemFCMServerrKey = "";
    public $globalSettingsTextAlign = "";
    public $globalSettingsActiveSmsService = "";
    public $globalSettingsSkinColour = "";
    public $globalSettingsSystemTitle = "";
    private $_daysArr = array();
    function __construct() {
        parent::__construct();
        $this->globalSettingsSMSDataArr = get_data_generic_fun('settings', 'description', array('condition_type' => 'in', 'condition_in_col' => 'type', 'condition_in_data' => 'location,app_package_name,running_year,system_name,system_email,fcm_server_key,system_title,text_align,skin_colour,active_sms_service'));
        $this->globalSettingsLocation = $this->globalSettingsSMSDataArr[7]->description;
        $this->globalSettingsAppPackageName = $this->globalSettingsSMSDataArr[8]->description;
        $this->globalSettingsRunningYear = $this->globalSettingsSMSDataArr[6]->description;
        $this->globalSettingsSystemTitle = $this->globalSettingsSMSDataArr[1]->description;
        $this->globalSettingsSystemName = $this->globalSettingsSMSDataArr[0]->description;
        $this->globalSettingsSystemEmail = $this->globalSettingsSMSDataArr[2]->description;
        $this->globalSettingsSystemFCMServerrKey = $this->globalSettingsSMSDataArr[9]->description;
        $this->globalSettingsSkinColour = $this->globalSettingsSMSDataArr[5]->description;
        $this->globalSettingsTextAlign = $this->globalSettingsSMSDataArr[4]->description;
        $this->globalSettingsActiveSmsService = $this->globalSettingsSMSDataArr[3]->description;
        $this->session->set_userdata(array(
            'running_year' => $this->globalSettingsRunningYear,
        ));

        $this->load->helper("email_helper");
        $this->load->helper("send_notifications");
        $this->load->model("Librarian_model");
        $this->load->model("Admin_model");
        $this->_daysArr = ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'];
    }

    public function getYears() {
        $query = $this->db->query("select distinct year from subject WHERE school_id='".$this->session->userdata('school_id')."'");
        echo json_encode($query->result_array());
    }

    function getTeacherData($tid) {
        $sql = "SELECT concat(name,' ',last_name) name FROM teacher WHERE teacher_id=$tid AND school_id='".$this->session->userdata('school_id')."'";
        $query = $this->db->query($sql);
        return array('tid' => $tid, 'name' => $query->result_array()[0]['name']);
    }

    function getClassData($sid) {
        $sql = "SELECT s.subject_id id, c.name class_name, sc.name section_name, s.name subject_name FROM subject s, class c, section sc WHERE s.subject_id = $sid AND s.class_id = c.class_id AND sc.section_id = s.section_id AND c.school_id='".$this->session->userdata('school_id')."'";
        $query = $this->db->query($sql);

        $row = $query->result_array()[0];

        return $row;
    }

    public function getSchedulesYear() {
        $PARAMS = $_POST;
        if (isset($PARAMS['year'])) {
            $year = $PARAMS['year'];
            $sql = "SELECT subject_id FROM subject WHERE year = '$year' AND school_id='".$this->session->userdata('school_id')."'";
            $keys = $this->db->query($sql)->result_array();
            $result = array();
            foreach ($keys as $key) {
                $result[$key['subject_id']] = array();
            }

            $sql = "SELECT su.subject_id subject_id, c.name class_name, sec.name section_name, su.name subject_name, su.class_id class_id, su.section_id section_id FROM class c, section sec, subject su WHERE c.class_id = su.class_id AND sec.section_id = su.section_id AND year = '$year' AND s.school_id='".$this->session->userdata('school_id')."'";
            $data = $this->db->query($sql)->result_array();

            foreach ($data as $row) {
                $subject_id = $row['subject_id'];
                //$section_name = $row['section_name'];
                //$subject_name = $row['subject_name'];

                $result[$subject_id]['class_name'] = $row['class_name'];
                $result[$subject_id]['section_name'] = $row['section_name'];
                $result[$subject_id]['subject_name'] = $row['subject_name'];
                $result[$subject_id]['restriction_info_id'] = -1;
                $result[$subject_id]['section_id'] = $row['section_id'];
                $result[$subject_id]['class_id'] = $row['class_id'];
            }

            foreach ($result as $key => $row) {
                if (count($row) == 0)
                    unset($result[$key]);
            }

            $sql = "SELECT schedule_id,subject_id FROM schedule_restriction_info WHERE year = '$year' AND school_id='".$this->session->userdata('school_id')."'";
            $data = $this->db->query($sql)->result_array();
            foreach ($data as $row) {
                $subject_id = $row['subject_id'];
                $result[$subject_id]['restriction_info_id'] = $row['schedule_id'];
                ;
            }

            $finalResult = array();
            foreach ($result as $key => $value) {
                $value['subject_id'] = $key;
                array_push($finalResult, $value);
            }


            echo json_encode($finalResult);
        } else {
            //$this->missing();
        }
    }

    public function getTeacherClasses() {
        //if(true)
        if (isset($_POST['list']) && isset($_POST['year'])) {
            //print_r( $_POST['list']);
            //return;
            //$list = $_POST['list'];
            $year = $_POST['year'];
            $list = $_POST['list'];
            //$list = array(array(13,8), array(13,10), array(1,19), array(1,7), array(3,1), array(2,15), array(4,32), array(7,26));
            //$year = '2017-2018';

            $result = array();
            $last_tid = -1;
            foreach ($list as $row) {
                $tid = $row[0];
                $sid = $row[1];

                if ($tid != $last_tid) { // new teacher
                    if ($last_tid != -1) {
                        array_push($result, array('teacher' => $teacher, 'classes' => $classes));
                    }
                    $teacher = $this->getTeacherData($tid);
                    $classes = array();
                    $last_tid = $tid;
                }

                $new_class = $this->getClassData($sid);
                array_push($classes, $new_class);
            }
            array_push($result, array('teacher' => $teacher, 'classes' => $classes));

            $id_list = $list[0][0];
            $last_id = $list[0][0];
            $list2 = "(" . $list[0][0] . "," . $list[0][1] . ")";

            for ($i = 1; $i < count($list); $i++) {
                if ($list[$i][0] != $last_id) {
                    $id_list = $id_list . "," . $list[$i][0];
                    $last_id = $list[$i][0];
                }
                $list2 = $list2 . ",(" . $list[$i][0] . "," . $list[$i][1] . ")";
            }


            $sql = "select t.teacher_id teacher_id,  s.subject_id subject_id, concat(t.name, ' ', t.last_name) name, c.name class_name, s.name subject_name from teacher_preference tp, teacher t, subject s, class c where t.teacher_id=tp.teacher_id AND tp.year='$year' and tp.teacher_id not in ($id_list) AND s.subject_id = tp.subject_id AND c.class_id = tp.class_id AND c.school_id='".$this->session->userdata('school_id')."'";

            $teachers_no_class = $this->db->query($sql)->result_array();

            for ($i = 0; $i < count($teachers_no_class); $i++) {
                $list2 = $list2 . ",(" . $teachers_no_class[$i]['teacher_id'] . "," . $teachers_no_class[$i]['subject_id'] . ")";
            }

            $sql = "SELECT tp.teacher_id teacher_id, tp.subject_id subject_id, concat(t.name, ' ', t.last_name) name,  s.name subject_name, c.name class_name FROM teacher_preference tp, teacher t, subject s, class c WHERE tp.year = '$year' AND (tp.teacher_id,tp.subject_id) NOT IN ($list2) AND t.teacher_id=tp.teacher_id AND s.subject_id = tp.subject_id AND tp.class_id = c.class_id AND c.school_id='".$this->session->userdata('school_id')."'";

            $remaining_classes = $this->db->query($sql)->result_array();

            $result = array('class' => $result, 'no_class' => $teachers_no_class, 'remaining' => $remaining_classes);

            echo json_encode($result);
        } else {
            $this->missing();
        }
    }

    public function getClassesFromList() {
        if (isset($_POST['list'])) {
            $list = $_POST['list'];
            $ids = $list[0];
            for ($i = 1; $i < count($list); $i++) {
                $ids = $ids . ", " . $list[$i];
            }
            $sql = "SELECT c.name class_name, s.name subject_name FROM subject s,class c,section sc WHERE s.class_id=c.class_id AND s.section_id=sc.section_id AND s.subject_id IN ($ids) AND c.school_id='".$this->session->userdata('school_id')."'";
            $query = $this->db->query($sql);
            echo json_encode($query->result_array());
        } else {
            $this->missing();
        }
    }

    public function getClassRoutine() {
        if (isset($_POST['year'])) {
            $years = $_POST['year']; //"2017-2018";
            $sql = "select class_routine_id id, s.name,section.nick_name,day, time_start,time_start_min, time_end, time_end_min from class_routine cr, subject s, section where cr.year='$years' and cr.subject_id = s.subject_id and cr.section_id = section.section_id AND s.school_id='".$this->session->userdata('school_id')."' order by day,time_start,time_start_min";

            $query = $this->db->query($sql);
            echo json_encode($query->result_array());
        } else {
            echo "Missing parameter";
        }
    }

    public function setScheduleRestriction() {
        
        $PARAMS = $_POST;
        //echo '<pre>';print_r($PARAMS);die;
        if (isset($PARAMS['subject_id']) && isset($PARAMS['year'])) {
            $sid = $PARAMS['subject_id'];
            $year = $PARAMS['year'];
            $sTime = $PARAMS['sTime'];
            $eTime = $PARAMS['eTime'];
            $tStep = $PARAMS['tStep'];
            $nBlocks = $PARAMS['nBlocks'];
            $bSize = $PARAMS['bSize'];
            $week = $PARAMS['week'];

            $sql = "DELETE FROM schedule_restriction_info WHERE subject_id=$sid AND year = '$year' AND school_id='".$this->session->userdata('school_id')."'";
            $query = $this->db->query($sql);

            $sql = "DELETE FROM schedule_restriction WHERE schedule_id IN (SELECT schedule_id FROM schedule_restriction_info WHERE subject_id=$sid AND year = '$year' AND school_id='".$this->session->userdata('school_id')."') AND school_id='".$this->session->userdata('school_id')."'";
            $query = $this->db->query($sql);

            $sql = "SELECT newScheduleRestrictionInfo($sid, '$year', $sTime, $eTime, $tStep, $nBlocks, $bSize) id";

            $query = $this->db->query($sql);

            $sid = $query->result_array()[0]['id'];
            
            $nRows = count($week);
            //pre($week);die;
            for ($day = 0; $day < count($this->_daysArr); $day++) {
                for ($i = 0; $i < $nRows; $i++) {
                    // find first available cell
                    if ($week[$i][$day] == "true") {
                        $blockIni = $i;
                        while ($i < $nRows && $week[$i][$day] == "true") {
                            $i++;
                        }
                        $i = $i - 1;

                        $time0 = $sTime * 60 + $tStep * ($blockIni);
                        $time1 = $sTime * 60 + $tStep * ($i + 1);
                        $sql = "INSERT INTO schedule_restriction (schedule_id, day, start_time, end_time,school_id) value ($sid, $day, $time0, $time1,".$this->session->userdata('school_id').")";
                        $query = $this->db->query($sql);
                    }
                }
            }
            die("ok");
        } else {
            //$this->missing();
            die("not");
        }
    }

    function subject_section_in($subjects_in_slot, $section_id) {
        //	print_r($subjects_in_slot);
        foreach ($subjects_in_slot as $info) {
            if ($info['section_id'] == $section_id)
                return true;
        }
        return false;
    }

    /*
      Compute a schedule for given year based on the restrictions
     */

    public function generateSchedule() {
        $PARAMS = $_POST;
        if (isset($PARAMS['year'])) {
            $year = $PARAMS['year'];
            //die($year);
            // first we need to process every section
            $sql = "select s.subject_id,s.section_id from schedule_restriction_info sri, subject s where sri.subject_id = s.subject_id AND sri.year='$year' AND s.school_id='".$this->session->userdata('school_id')."'";
            $data = $this->db->query($sql)->result_array();
            //pre($sql);die;
            $sections = array();
            $section_map = array();
            foreach ($data as $row) {
                $subject_id = $row['subject_id'];
                $section_id = $row['section_id'];
                $section_map[$subject_id] = $section_id;
                $sections[$section_id] = array();
            }

            $sql = "SELECT subject_id, time_step, nBlocks, block_size FROM schedule_restriction_info WHERE year='$year' AND school_id='".$this->session->userdata('school_id')."'";
            $data = $this->db->query($sql)->result_array();
            //pre($sql);
            $subject = array();
            foreach ($data as $row) {
                $subject_id = $row['subject_id'];
                $time_step = $row['time_step'];
                $nBlocks = $row['nBlocks'];
                $block_size = $row['block_size'];

                $subject[$subject_id] = array('time_step' => $time_step, 'nBlocks' => $nBlocks, 'block_size' => $block_size, 'blocks' => array());
            }

            $sql = "SELECT subject_id, sum(sr.end_time-sr.start_time) time FROM schedule_restriction sr, schedule_restriction_info sri  WHERE sri.year='$year' AND sr.schedule_id = sri.schedule_id AND sri.school_id='".$this->session->userdata('school_id')."' group by (subject_id) order by time";
            $data = $this->db->query($sql)->result_array();

            $order = array(); // processing order
            foreach ($data as $row) {
                array_push($order, $row['subject_id']);
            }

            $mintime = 60 * 24;
            $maxtime = 0;

            $sql = "SELECT sri.subject_id, day , sr.start_time, sr.end_time FROM schedule_restriction sr, schedule_restriction_info sri WHERE sri.year='$year' AND sr.schedule_id = sri.schedule_id AND sri.school_id='".$this->session->userdata('school_id')."'";
            $data = $this->db->query($sql)->result_array();
            foreach ($data as $row) {
                $subject_id = $row['subject_id'];
                $day = $row['day'];
                $start_time = $row['start_time'];
                $end_time = $row['end_time'];
                if ($start_time < $mintime)
                    $mintime = $start_time;
                if ($end_time > $maxtime)
                    $maxtime = $end_time;
                array_push($subject[$subject_id]['blocks'], array('day' => $day, 'start_time' => $start_time, 'end_time' => $end_time)
                );
            }
            
            foreach ($order as $subject_id) {
                $section_id = $section_map[$subject_id];
                $days = array(array(), array(), array(), array(), array(), array());
                foreach ($subject[$subject_id]['blocks'] as $entry) {
                    array_push($days[$entry['day']], $entry);
                }
                //print_r($days);
                //return;
                $data = array('subject_id' => $subject_id, 'data' => $days); //$subject[$subject_id]['blocks']);
                array_push($sections[$section_id], $data);
                //echo "$subject_id:  $section_id\n";
                //print_r();
            }
            
            $sql = "SELECT DISTINCT(time_step) FROM schedule_restriction_info WHERE year='$year' AND school_id='".$this->session->userdata('school_id')."'";
            $time_steps = $this->db->query($sql)->result_array();

            if (count($time_steps) == 1)
                $time_step = $time_steps[0]['time_step'];
            else
                $time_step = 30;  // TODO: compute GCD

            $totaltime = $maxtime - $mintime;
            $rows = $totaltime / $time_step;

            $tt = array();  // the time table
            for ($i = 0; $i < $rows; $i++) {
                $tt[$i] = array(array(), array(), array(), array(), array(), array());
            }

            //pre($sections);die;
            //return;

            foreach ($sections as $section_id => $section) {
                foreach ($section as $subject_row) {
                    $subject_id = $subject_row['subject_id'];
                    $blocks = $subject_row['data'];

                    $nBlocks = $subject[$subject_id]['nBlocks'];
                    $block_size = $subject[$subject_id]['block_size'];
                    $time_step0 = $subject[$subject_id]['time_step'];

                    $block_size0 = $nBlocks;

                    $block_size *= $time_step0 / $time_step;

                    //	echo "$subject_id $nBlocks $block_size $block_size0 $time_step $time_step0\n";
                    //return;
                    //print_r($blocks);die;
                    // get a random permutation of days

                    $day_perm = array(0, 1, 2, 3, 4, 5);
                    for ($i = 0; $i < count($this->_daysArr); $i++) {
                        $other = rand($i + 1, 5);
                        $tmp = @$day_perm[$other];
                        $day_perm[$other] = $day_perm[$i];
                        $day_perm[$i] = $tmp;
                    }

                    //print_r($day_perm);

                    foreach ($day_perm as $day) {
                        if ($nBlocks == 0)
                            break;  // subject is done!
                        $day_blocks = @$subject_row['data'][$day];
                        if(!empty($day_blocks)){
                            foreach ($day_blocks as $block) {
                                if ($nBlocks == 0)
                                    break;
                                $start_time = $block['start_time'];
                                $end_time = $block['end_time'];
                                $i0 = ($start_time - $mintime) / $time_step;
                                $i1 = ($end_time - $mintime) / $time_step;
                                //echo "$subject_id $i0 $i1 $mintime $start_time $end_time\n";

                                $blockAssigned = false;
                                for ($i = $i0; $i < $i1; $i++) {
                                    // find a free block
                                    $subjects_in_slot = $tt[$i][$day];
                                    if (!$this->subject_section_in($subjects_in_slot, $section_id)) {
                                        $n = 0;
                                        while ($i < $i1 && !$this->subject_section_in($subjects_in_slot, $section_id) && $n < $block_size) {
                                            $i++;
                                            $n++;
                                            $subjects_in_slot = @$tt[$i][$day];
                                        }
                                        if ($n == $block_size) {
                                            $init = $i - $n;
                                            for ($j = 0; $j < $n; $j++){
                                                $rsTeacherPriority=array();
                                                $sqlTeacherPriority="SELECT t.teacher_id,t.name FROM teacher_preference AS tp JOIN teacher as t ON(tp.teacher_id=t.teacher_id) WHERE tp.section_id='$section_id' AND tp.subject_id='$subject_id' ORDER BY tp.priority ASC LIMIT 0,1";
                                                generate_log($sqlTeacherPriority,"att_schedule_time_table.log");
                                                $rsTeacherPriority=$this->db->query($sqlTeacherPriority)->result_array();
                                                //pre($rsTeacherPriority);die;
                                                if(!empty($rsTeacherPriority)){
                                                    array_push($tt[$init + $j][$day], array('section_id' => $section_id, 'subject_id' => $subject_id,'teacher_id'=>$rsTeacherPriority[0]['teacher_id'],'teacher_name'=>$rsTeacherPriority[0]['name']));
                                                }else{
                                                    array_push($tt[$init + $j][$day], array('section_id' => $section_id, 'subject_id' => $subject_id,'teacher_id'=>0,'teacher_name'=>'No teacher set'));
                                                    generate_log("no teacher find for section_id : $section_id with subject_id : $subject_id in priority table","att_schedule_time_table.log");
                                                }
                                            }

                                            //	echo "block found ($init) for $section_id $subject_id! Day: $day\n";
                                            //print_r($tt);
                                            $nBlocks--;
                                            $i = $init;
                                            $blockAssigned = true;
                                            break;
                                            //print_r($tt);
                                            //return;
                                        }
                                    }
                                }
                                if ($blockAssigned)
                                    break;  // next day!
                            }
                        }
                    }

                    //print_r($block);

                    /*
                      foreach($blocks as $block)
                      {
                      if($nBlocks == 0) break;  // subject is done!
                      if($block['day'] != $lastDay)  // cannot assign two blocks on the same day
                      {
                      print_r($block);

                      $start_time = $block['start_time'];
                      $end_time = $block['end_time'];

                      //	$i0 = $start_time

                      }
                      } */
                }
            }

            $tt = array('min' => $mintime, 'max' => $maxtime, 'time_step' => $time_step, 'data' => $tt);

            print_r(json_encode($tt));

            //echo "$mintime $maxtime $totaltime $rows\n";
            //print_r($tt);
        }
        else {
            $this->missing();
        }
    }

    public function create_structure() {
        $PARAMS = $_POST;
        if (isset($PARAMS['year'])) {
            $year = $PARAMS['year'];
            $data = $PARAMS['data'];

            $sql = "DELETE FROM class_routine WHERE year='$year' AND school_id='".$this->session->userdata('school_id')."'";
            $this->db->query($sql);


            //$days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
            $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
            //pre($data);die;
            foreach ($data as $row) {
                $class_id = $row['class_id'];
                $section_id = $row['section_id'];
                $subject_id = $row['subject_id'];
                $time_start = $row['time_start'];
                $time_end = $row['time_end'];
                $d = $row['day'];

                $time_start_min = $time_start % 60;
                $time_start = floor($time_start / 60);
                $time_end_min = $time_end % 60;
                $time_end = floor($time_end / 60);
                $day = $days[$d];
                
                $dataArray=array('class_id'=>$class_id,'section_id'=>$section_id,'subject_id'=>$subject_id,
                        'time_start'=>$time_start,'time_end'=>$time_end,'time_start_min'=>$time_start_min,
                    'time_end_min'=>$time_end_min,'day'=>$day,'year'=>$year,'isActive'=>'1',
                    'school_id'=>$this->session->userdata('school_id'));
                $sqlTeacherPriority="SELECT t.teacher_id,t.name FROM teacher_preference AS tp JOIN teacher as t ON(tp.teacher_id=t.teacher_id) WHERE tp.section_id='$section_id' AND tp.subject_id='$subject_id' ORDER BY tp.priority ASC LIMIT 0,1";
                $rsTeacherPriority=$this->db->query($sqlTeacherPriority)->result_array();
                if(!empty($rsTeacherPriority)){
                    $dataArray['teacher_id']=$rsTeacherPriority[0]['teacher_id'];
                }else {
                    $dataArray['teacher_id']="0";
                }
              /*$sql = "INSERT INTO class_routine ("
                      . "class_id, section_id, subject_id, time_start, time_end, time_start_min, time_end_min, day, "
                      . "year, teacher_id, isActive,school_id) values ($class_id, $section_id, $subject_id, "
                      . "$time_start, $time_end, $time_start_min, $time_end_min, '$day', '$year',0, '1','".$this->session->userdata('school_id')."')";*/
                $this->db->insert('class_routine', $dataArray);
            }

            //	$sql = "UPDATE class_routine SET isActive=1 WHERE year='$year'";
            //	$this->db->query($sql);
            //echo $sql;
            //print_r($data);
        } else {
            $this->missing();
        }
    }

    public function getSectionsFromYear() {
        $PARAMS = $_POST;
        //pre($PARAMS);die;
        if (isset($PARAMS['year'])) {
            $year = $PARAMS['year'];
            $sql = "SELECT distinct(s.section_id) section_id,c.name class_name, sc.name section_name FROM subject s, section sc, class c  WHERE c.class_id = s.class_id AND sc.section_id = s.section_id AND s.subject_id in (SELECT subject_id FROM schedule_restriction_info WHERE year='$year') AND s.school_id='".$this->session->userdata('school_id')."'";
            //echo $sql;die;
            $query = $this->db->query($sql)->result_array();

            echo json_encode($query);
        } else {
            $this->missing();
        }
    }

    public function getSubjectsFromYear() {
        $PARAMS = $_POST;
        if (isset($PARAMS['year'])) {
            $year = $PARAMS['year'];
            $sql = "SELECT s.subject_id subject_id,c.name class_name, sc.name section_name, s.name subject_name, s.section_id section_id, s.class_id class_id FROM subject s, section sc, class c WHERE c.class_id = s.class_id AND sc.section_id = s.section_id AND s.subject_id in (SELECT subject_id FROM schedule_restriction_info WHERE year='$year' AND school_id='".$this->session->userdata('school_id')."')";
            $query = $this->db->query($sql)->result_array();

            echo json_encode($query);
        } else {
            $this->missing();
        }
    }

    /*
      Returns the schedule restrictions for a given subject/year
     */

    public function getScheduleRestriction() {
        if (isset($_POST['subject_id']) && isset($_POST['year'])) {
            $sid = $_POST['subject_id'];
            $year = $_POST['year'];
            $sql = "SELECT schedule_id, start_time, end_time, time_step, nBlocks, block_size FROM schedule_restriction_info WHERE subject_id=$sid AND year = '$year' AND school_id='".$this->session->userdata('school_id')."'";
            //die($sql);
            $query = $this->db->query($sql);
            if (count($query->result_array()) == 0) {
                echo json_encode(['info' => []]);
            } else {
                $info = $query->result_array();
                $sid = $query->result_array[0]['schedule_id'];
                $sql = "SELECT day, start_time, end_time FROM schedule_restriction WHERE schedule_id=$sid AND school_id='".$this->session->userdata('school_id')."'";
                $query = $this->db->query($sql);
                echo json_encode(['info' => $info, 'data' => $query->result_array()]);
            }
        } else {
            missing();
        }
    }

    /*
      Returns all classes
     */

    public function getClasses() {
        $sql = "SELECT class_id id, name FROM class";
        $query = $this->db->query($sql);
        echo json_encode($query->result_array());
    }

    /*
      Returns all sections
     */

    public function getSections() {
        if (isset($_POST['class_id'])) {
            $class_id = $_POST['class_id'];
            $sql = "SELECT section_id id, nick_name name FROM section WHERE class_id=" . $class_id." AND school_id='".$this->session->userdata('school_id')."'";
            $query = $this->db->query($sql);
            echo json_encode($query->result_array());
        } else {
            echo "Missing parameter";
        }
    }

    /*
      Returns all subjects
     */

    public function getSubjects() {
        if (isset($_POST['class_id']) && isset($_POST['section_id'])) {
            $class_id = $_POST['class_id'];
            $section_id = $_POST['section_id'];
            $sql = "SELECT subject_id id, name FROM subject WHERE class_id=$class_id and section_id=$section_id AND school_id='".$this->session->userdata('school_id')."'";
            $query = $this->db->query($sql);
            echo json_encode($query->result_array());
        } else {
            echo "Missing parameter";
        }
    }

    /*
      Returns subjects given a class
     */

    public function getSubjectsFromClass() {
        if (isset($_POST['class_id'])) {
            $class_id = $_POST['class_id'];
            $sql = "SELECT subject_id,name FROM subject WHERE class_id = $class_id AND school_id='".$this->session->userdata('school_id')."'";
            //echo $sql; return;
            $query = $this->db->query($sql);
            echo json_encode($query->result_array());
        } else {
            missing();
        }
    }

    function missing() {
        echo "Missing parameter";
    }

    /* inserts a new teacher priority */

    public function deleteTeacherPriority() {
        if (isset($_POST['teacher_preference_id'])) {
            $teacher_preference_id = $_POST['teacher_preference_id'];
            $sql = "DELETE FROM teacher_preference WHERE teacher_preference_id = $teacher_preference_id AND school_id='".$this->session->userdata('school_id')."'";
            $this->db->query($sql);
        } else {
            $this->missing();
        }
    }

    /* updates a time table */

    public function updateTimeTable() {
        if (isset($_POST['insert'])) {
            $insert = $_POST['insert'];
            foreach ($insert as $new_class_routine) {
                print_r($new_class_routine);
                $class_id = $new_class_routine['class_id'];
                $section_id = $new_class_routine['section_id'];
                $subject_id = $new_class_routine['subject_id'];
                $time_start = $new_class_routine['time_start'];
                $time_end = $new_class_routine['time_end'];
                $time_start_min = $new_class_routine['time_start_min'];
                $time_end_min = $new_class_routine['time_end_min'];
                $day = $new_class_routine['day'];
                $year = $new_class_routine['year'];
                $sql = "INSERT INTO class_routine(class_id, section_id, subject_id, time_start, time_end, time_start_min, time_end_min, day, year, teacher_id, isActive,teacher_id) VALUES ($class_id, $section_id, $subject_id, $time_start, $time_end, $time_start_min, $time_end_min, '$day', '$year',0,1,AND school_id='".$this->session->userdata('school_id')."')";
                $query = $this->db->query($sql);
            }
        }

        if (isset($_POST['delete'])) {
            $deleteList = '(';
            $i = 0;
            foreach ($_POST['delete'] as $id) {
                if ($i > 0)
                    $deleteList = $deleteList . ",";
                $deleteList = "$deleteList $id";
                $i++;
            }
            $deleteList = "$deleteList)";
            $sql = "DELETE FROM class_routine WHERE class_routine_id IN $deleteList AND school_id='".$this->session->userdata('school_id')."'";
            $query = $this->db->query($sql);
        }
    }

    /* returns all classes still needing teachers for the given year */

    public function getMissingClasses() {
        if (isset($_POST['year'])) {
            $year = $_POST['year'];
            $sql = "SELECT class.class_id class_id,class.name class_name,subject.subject_id subject_id, subject.name subject_name FROM (SELECT distinct class_id,  subject_id FROM class_routine WHERE class_routine_id NOT IN (SELECT DISTINCT class_routine_id FROM class_routine c, teacher_preference tp WHERE c.year='$year' AND tp.year='$year'AND c.class_id=tp.class_id AND c.subject_id=tp.subject_id )) cr, class, subject WHERE cr.class_id=class.class_id AND cr.subject_id=subject.subject_id AND school_id='".$this->session->userdata('school_id')."'";
            $query = $this->db->query($sql);
            echo json_encode($query->result_array());
        } else {
            $this->missing();
        }
    }

    /* inserts a new teacher priority */

    public function addTeacherPriority() {

        if (isset($_POST['teacher_id']) &&
                isset($_POST['year']) &&
                isset($_POST['class_id']) &&
                isset($_POST['subject_id']) &&
                isset($_POST['priority'])
        ) {
            // check if teacher_priority exists already
            $teacherId = $_POST['teacher_id'];
            $year = $_POST['year'];
            $class_id = $_POST['class_id'];
            $subject_id = $_POST['subject_id'];
            $priority = $_POST['priority'];
            $sql = "SELECT COUNT(1) c FROM teacher_preference WHERE teacher_id=$teacherId AND class_id=$class_id and subject_id=$subject_id AND year='$year' AND school_id='".$this->session->userdata('school_id')."'";
            $query = $this->db->query($sql);

            $exists = $query->result_array()[0]['c'];
            if ($exists == '0') { // it doesn't exist
                $sql = "INSERT INTO teacher_preference(teacher_id, class_id, subject_id, priority, year) VALUES ($teacherId, $class_id, $subject_id, $priority, '$year')";
                $this->db->query($sql);
                //	echo "I";
            } else {
                //	echo $sql;
                $sql = "UPDATE teacher_preference SET priority = $priority WHERE teacher_id=$teacherId AND class_id=$class_id AND subject_id=$subject_id AND year='$year' AND school_id='".$this->session->userdata('school_id')."'";
                $this->db->query($sql);
                //	echo "U";
            }
            return;
        } else {
            echo "Missing parameter";
        }
    }

    /* returns all teachers */

    public function getTeachers() {
        $sql = "SELECT teacher_id, concat(name,' ', last_name)name FROM teacher";
        $query = $this->db->query($sql);
        echo json_encode($query->result_array());
    }

    /* returns teacher priorities for a given teacher and year */
    public function getTeacherPriority() {
        if (isset($_POST['teacher_id']) && isset($_POST['year'])) {
            $teacher_id = $_POST['teacher_id'];
            $year = $_POST['year'];
            $sql = "SELECT teacher_preference_id, c.name class, s.name subject, tp.priority, c.class_id class_id, s.subject_id subject_id FROM teacher_preference tp,  class c, subject s WHERE  tp.class_id = c.class_id AND tp.subject_id = s.subject_id AND tp.teacher_id=$teacher_id AND tp.year='$year' AND school_id='".$this->session->userdata('school_id')."'";
            $query = $this->db->query($sql);
            echo json_encode($query->result_array());
        } else {
            echo "Missing parameter";
        }
    }
    
    
    function test(){
        $name='judhi here';
        return $name;
    }

}