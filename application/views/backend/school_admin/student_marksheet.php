<div class="row bg-title"> 
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('student_marksheet'); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li><?php echo get_phrase('student'); ?>
                <ul>                    
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/student_information"><?php echo get_phrase('student_information'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/student_promotion"><?php echo get_phrase('student_promotion'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/map_students_id"><?php echo get_phrase('map_students_id'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/student_fee_configuration"><?php echo get_phrase('student_fee_setting'); ?></a></li>
                </ul>
            </li>
            <li class="active">
                <?php echo get_phrase('student_marksheet'); ?>
            </li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>

<?php    
$k=5;   
        foreach ($student_info as $row1):
            foreach ($marks_data as $row2):
            $row2 = $row2['marks'];
                ?>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-danger block6" data-collapsed="0">
                    <div class="panel-heading" data-step="<?php echo $k++; ?>" data-intro="<?php echo get_phrase('marksheet_of_exam_'.$row2['name']); ?>" data-position="top">
                        <?php echo $row2['name']; ?>
                    </div>
                    <?php
 $exam_types = array("FA1", "FA2", "SA1", "FA3","FA4", "SA2");
 if(!in_array(strtoupper ($row2['name']),$exam_types)){?>
<div class="panel-body">
<div class="table-responsive">
<table class="table-bordered table">
    <thead>
        <tr>
            <th class="text-center">Subject</th>
            <th class="text-center">Obtained Marks</th>
            <th class="text-center">Maximum Marks</th>
            <th class="text-center">Grade</th>
            <th class="text-center">Comment</th>
        </tr>
    </thead>
    <tbody>
        <?php
$total_marks = 0;
$total_grade_point = 0;
//pre($row2['subject']);
foreach ($row2['subject'] as $row3):
?>
            <tr>
                <td class="text-center">
                    <?php echo $row3['name']; ?>
                </td>
                <td class="text-center">
                    <?php
                                                  
               if(isset($row3['obtained'])){     
                    if (count($row3['obtained']) > 0)
                    {
                        foreach ($row3['obtained'] as $row4)
                        {
                            echo $row4['mark_obtained'];
                            $total_marks += $row4['mark_obtained'];
                        }
                    }
               }
            ?>
                </td>
                <!-- <td class="text-center">
                    <?php
                   if(isset($row3['highest_mark'])) {
                    $highest_mark = $row3['highest_mark'];
                   echo $highest_mark; }
?>
                </td> -->
                <td class="text-center">
                    <?php
                                                  
               if(isset($row3['obtained'])){     
                    if (count($row3['obtained']) > 0)
                    {
                        foreach ($row3['obtained'] as $row4)
                        {
                            echo $row4['mark_total'];
                        }
                    }
               }
            ?>
                </td>
                <td class="text-center">
                    <?php
                    if(isset($row4['grade'])){     
                        if (count($row4['grade']) > 0)
                        {
                            if ($row4['grade'] >= 0 || $row4['grade'] != '')
                            {
                                
                                $grade = $row4['grade'];
                                echo $grade['grade_point'];
                                //$total_grade_point += $grade['grade_point'];
                            }
                        }
                    }
                    ?>
                </td>
                <td class="text-center">
                    <?php
                    if(isset($row3['obtained'])){  
                        if (count($row3['obtained']) > 0)
                        echo $grade['comment'];
                    }
                    ?>
                </td>
            </tr>
            <?php endforeach; ?>
    </tbody>
</table>
</div>

<div class="col-md-12 p-0">

<b><?php echo get_phrase('total_marks'); ?></b> :
<?php echo $total_marks; ?>
    <br/>
    <b><?php echo get_phrase('average_grade_point'); ?></b> :
    <?php

echo ($total_grade_point / $row3['tot_subjects']);
?>

</div>
<div class="text-right">
<a href="<?php echo base_url(); ?>index.php?school_admin/student_marksheet_print_view/<?php echo $student_id; ?>/<?php echo $row2['exam_id']; ?>" class="fcbtn btn btn-danger btn-outline btn-1d">
    <?php echo get_phrase('print_marksheet'); ?>
</a>
</div>


<div class="col-md-6">
<div id="chartdiv<?php echo $row2['exam_id']; ?>" class="exam_chart">
</div>
<script type="text/javascript">
    var chart <?php echo $row2['exam_id']; ?> = AmCharts.makeChart("chartdiv<?php echo $row2['exam_id']; ?>", {
        "theme": "none",
        "type": "serial",
        "dataProvider": [
            <?php
foreach ($subjects as $subject) :
?> {
                "subject": "<?php echo $subject['name']; ?>",
                "mark_obtained": <?php
$obtained_mark = $this->crud_model->get_obtained_marks($row2['exam_id'], $class_id, $subject['subject_id'], $row1['student_id']);
echo $obtained_mark;
?>,
                "mark_highest": <?php
$highest_mark = $this->crud_model->get_highest_marks($row2['exam_id'], $class_id, $subject['subject_id']);
echo $highest_mark;
?>
            },
            <?php
endforeach;
?>

        ],
        "valueAxes": [{
            "stackType": "3d",
            "unit": "%",
            "position": "left",
            "title": "Obtained Mark vs Highest Mark"
        }],
        "startDuration": 1,
        "graphs": [{
            "balloonText": "Obtained Mark in [[category]]: <b>[[value]]</b>",
            "fillAlphas": 0.9,
            "lineAlpha": 0.2,
            "title": "2004",
            "type": "column",
            "fillColors": "#7f8c8d",
            "valueField": "mark_obtained"
        }, {
            "balloonText": "Highest Mark in [[category]]: <b>[[value]]</b>",
            "fillAlphas": 0.9,
            "lineAlpha": 0.2,
            "title": "2005",
            "type": "column",
            "fillColors": "#34495e",
            "valueField": "mark_highest"
        }],
        "plotAreaFillAlphas": 0.1,
        "depth3D": 20,
        "angle": 45,
        "categoryField": "subject",
        "categoryAxis": {
            "gridPosition": "start"
        },
        "exportConfig": {
            "menuTop": "20px",
            "menuRight": "20px",
            "menuItems": [{
                "format": 'png'
            }]
        }
    });
</script>
</div>

</div>
        <?php }?>
</div>


                                        <!--2nd table-->

                                        <?php
            $exam_types = array("FA1", "FA2", "SA1", "FA3","FA4", "SA2");
            if(in_array(strtoupper ($row2['name']),$exam_types)){?>
                                            <div class="panel panel-danger block6">
                                                <div class="panel-heading">
                                                    <?php echo get_phrase('cce_consolidated_marksheet') ?>
                                                </div>
                                                <div class="panel-body">
                                                    <div class="col-md-12 table-responsive no-padding">
                                                        <table class="table table-bordered">
                                                            <tr>
                                                                <th>subject</th>
                                                                <th colspan="5">term1</th>
                                                                <th colspan="5">term2</th>
                                                                <th colspan="2">term1+term2</th>
                                                            </tr>
                                                            <tr>
                                                                <td></td>
                                                                <td>fa1</td>
                                                                <td>fa2</td>
                                                                <td>total
                                                                    <br>(fa)</td>
                                                                <td>sa1</td>
                                                                <td>total
                                                                    <div>(fa+sa1)</td>
                                                                <td>fa3</td>
                                                                <td>fa4</td>
                                                                <td>total
                                                                    <br>(fa) </td>
                                                                <td>sa2</td>
                                                                <td>total
                                                                    <br>(fa+sa2)</td>
                                                                <td>total</td>
                                                                <td>grade point</td>
                                                            </tr>
<?php //$subjects = $this->db->get_where('subject', array('class_id' => $class_id, 'year' => $running_year))->result_array();
                                        foreach ($row2['subject'] as $row3):
                                            ?>
                                                                <tr>
                                                                    <td class="text-center">
                                                                        <?php echo $row3['name']; ?>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <?php
                                                   // $exam_id=$this->db->get_where('exam', array('UPPER(name)'=>"FA1"));
                                                   //echo $this->db->last_query();
                                                   // exit;
//                                                     If($exam_id->num_rows() > 0)
//                                                            {
//                                                               
//                                                                $exam_id =$exam_id->row()->exam_id;
//                                                    $obtained_mark_query = $this->db->get_where('mark', array(
//                                                        'subject_id' => $row3['subject_id'],
//                                                        'exam_id' => $exam_id,
//                                                        'class_id' => $class_id,
//                                                        'student_id' => $student_id,
//                                                        'year' => $running_year));
//                                                    if ($obtained_mark_query->num_rows() > 0)
//                                                    {
//                                                        $marks = $obtained_mark_query->result_array();
//                                                        foreach ($marks as $row5)
//                                                        {
//                                                            $grade=$this->crud_model->get_grade_new($row5['mark_obtained'],"FA");
//                                                            print_r($grade[0]['name']);
//                                                            $total_marks += $row5['mark_obtained'];
//                                                        }
//                                                    }
//                                                    }
                                                                        
                                                                       if(isset($row3['obtained'])){     
                                                    if (count($row3['obtained']) > 0)
                                                    {
                                                        foreach ($row3['obtained'] as $row4)
                                                        {
                                                            echo $row4['mark_obtained'];
                                                            $total_marks += $row4['mark_obtained'];
                                                        }
                                                    }
                                                                       } else {
                                                                           
                                                                           echo "NA";
                                                                       }
                                                    ?>
                                                                    </td>
                                                                    <td>
                                                                      
                                                                    </td>
                                                                    <td>
                                                                      
                                                                    </td>
                                                                    <td>
                                                                    
                                                                    </td>
                                                                    <td>
                                                                        <?php if(isset($fa)&&isset($row7['mark_obtained']))
                                                 {
                                                    $fa_weightage= $this->db->get('cce_settings')->row()->fa_weightage_first;
                                                    $sa_weightage=$this->db->get('cce_settings')->row()->sa_weightage_first;
                                                 $fa1=($fa*2*$fa_weightage+$row7['mark_obtained']*$sa_weightage)/(2*$fa_weightage+$sa_weightage);
                                                 $grade=$this->crud_model->get_grade_new($fa1,"SA");
                                                 print_r($grade[0]['name']);
                                                 $fa=NULL;
                                                 $row7['mark_obtatined']=NULL;
                                                 //echo $fa1;
                                                 }?>
                                                                    </td>
                                                                    <td>
                                                                        <?php
                                                    $exam_id=$this->db->get_where('exam', array('UPPER(name)'=>"FA3"));
                                                            If($exam_id->num_rows() > 0)
                                                            {
                                                                
                                                                $exam_id =$exam_id->row()->exam_id;
                                                    $obtained_mark_query = $this->db->get_where('mark', array(
                                                        'subject_id' => $row3['subject_id'],
                                                        'exam_id' => $exam_id,
                                                        'class_id' => $class_id,
                                                        'student_id' => $student_id,
                                                        'year' => $running_year));
                                                    if ($obtained_mark_query->num_rows() > 0)
                                                    {
                                                        $marks = $obtained_mark_query->result_array();
                                                        foreach ($marks as $row9)
                                                        {
                                                            //echo $row4['mark_obtained'];
                                                             $grade=$this->crud_model->get_grade_new($row9['mark_obtained'],"FA");
                                                             print_r($grade[0]['name']);
                                                            $total_marks += $row9['mark_obtained'];
                                                        }
                                                    }
                                                    }
                                                    else{
                                                        echo "NA";
                                                    }
                                                    ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php
                                                    $exam_id=$this->db->get_where('exam', array('UPPER(name)'=>"FA4"));
                                                            If($exam_id->num_rows() > 0)
                                                            {
                                                                
                                                                $exam_id =$exam_id->row()->exam_id;
                                                    $obtained_mark_query = $this->db->get_where('mark', array(
                                                        'subject_id' => $row3['subject_id'],
                                                        'exam_id' => $exam_id,
                                                        'class_id' => $class_id,
                                                        'student_id' => $student_id,
                                                        'year' => $running_year));
                                                    if ($obtained_mark_query->num_rows() > 0)
                                                    {
                                                        $marks = $obtained_mark_query->result_array();
                                                        foreach ($marks as $row8)
                                                        {
                                                            //echo $row4['mark_obtained'];
                                                             $grade=$this->crud_model->get_grade_new($row8['mark_obtained'],"FA");
                                                             print_r($grade[0]['name']);
                                                            $total_marks += $row8['mark_obtained'];
                                                        }
                                                    }
                                                    }
                                                    else{
                                                        echo "NA";
                                                    }
                                                    ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php
                                                 if(isset($row8['mark_obtained'])&&isset($row9['mark_obtained']))
                                                 {
                                                 $fa_sec=($row8['mark_obtained']+$row9['mark_obtained'])/2;
                                                 $grade=$this->crud_model->get_grade_new($fa_sec,"FA");
                                                 print_r($grade[0]['name']);
                                                 $row8['mark_obtained']=NULL;
                                                 $row9['mark_obtained']=NULL;
                                                 }?>
                                                                    </td>
                                                                    <td>
                                                                        <?php
                                                    $exam_id=$this->db->get_where('exam', array('UPPER(name)'=>"SA2"));
                                                            If($exam_id->num_rows() > 0)
                                                            {
                                                                
                                                                $exam_id =$exam_id->row()->exam_id;
                                                    $obtained_mark_query = $this->db->get_where('mark', array(
                                                        'subject_id' => $row3['subject_id'],
                                                        'exam_id' => $exam_id,
                                                        'class_id' => $class_id,
                                                        'student_id' => $student_id,
                                                        'year' => $running_year));
                                                    if ($obtained_mark_query->num_rows() > 0)
                                                    {
                                                        $marks = $obtained_mark_query->result_array();
                                                        foreach ($marks as $row10)
                                                        {
                                                           // echo $row4['mark_obtained'];
                                                             $grade=$this->crud_model->get_grade_new($row10['mark_obtained'],"SA");
                                                             print_r($grade[0]['name']);
                                                            $total_marks += $row10['mark_obtained'];
                                                        }
                                                    }
                                                    }
                                                    else{
                                                        echo "NA";
                                                    }
                                                    ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php if(isset($fa_sec)&&isset($row10['mark_obtained']))
                                                 {
                                                    $fa_weightage= $this->db->get('cce_settings')->row()->fa_weightage_second;
                                                    $sa_weightage=$this->db->get('cce_settings')->row()->sa_weightage_second;
                                                 $fa1=($fa_sec*2*$fa_weightage+$row10['mark_obtained']*$sa_weightage)/(2*$fa_weightage+$sa_weightage);
                                                 $grade=$this->crud_model->get_grade_new($fa1,"SA");
                                                 print_r($grade[0]['name']);
                                                 $fa_sec=NULL;
                                                 $row10['mark_obtatined']=NULL;
                                                 //echo $fa1;
                                                 }?>
                                                                    </td>
                                                                    <td></td>
                                                                    <td></td>
                                                                </tr>
                                                                <?php endforeach; ?>
                                                        </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php break;}?>
                                            </div>
                                    </div>
                                    <?php
        endforeach;
    endforeach;
    ?>