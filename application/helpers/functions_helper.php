<?php

//require 'config.php';
//$this->load->helper("config");

/* ========================================================================================================== */
/* ===================================== ANTI SQL INJECTION Function ======================================== */
/* ========================================================================================================== */

function antiSQLInjection($texto) {
    // Words for search
    $check[1] = chr(34); // simbol "
    $check[2] = chr(39); // simbol '
    $check[3] = chr(92); // simbol /
    $check[4] = chr(96); // simbol `
    $check[5] = "drop table";
    $check[6] = "update";
    $check[7] = "alter table";
    $check[8] = "drop database";
    $check[9] = "drop";
    $check[10] = "select";
    $check[11] = "delete";
    $check[12] = "insert";
    $check[13] = "alter";
    $check[14] = "destroy";
    $check[15] = "table";
    $check[16] = "database";
    $check[17] = "union";
    $check[18] = "TABLE_NAME";
    $check[19] = "1=1";
    $check[20] = 'or 1';
    $check[21] = 'exec';
    $check[22] = 'INFORMATION_SCHEMA';
    $check[23] = 'like';
    $check[24] = 'COLUMNS';
    $check[25] = 'into';
    $check[26] = 'VALUES';

    // Cria se as vari�veis $y e $x para controle no WHILE que far� a busca e substitui��o
    $y = 1;
    $x = sizeof($check);
    // Faz-se o WHILE, procurando alguma das palavras especificadas acima, caso encontre alguma delas, este script substituir� por um espa�o em branco " ".
    while ($y <= $x) {
        $target = strpos($texto, $check[$y]);
        if ($target !== false) {
            $texto = str_replace($check[$y], "", $texto);
        }
        $y++;
    }
    // Retorna a vari�vel limpa sem perigos de SQL Injection
    return $texto;
}

/* ========================================================================================================== */
/* ========================================= EVENT Functions ================================================ */
/* ========================================================================================================== */

// Write javascript with events listing without the need of getting it from external file
function listEvents() {
    //$sql = mysql_query("select * from events");
    $ci = & get_instance();

    $events = $ci->db->get_where('events',array('school_id'=>$ci->session->userdata('school_id')))->result_array();//this will get list of all events
    ///pre($events);
    $exam_routines = $ci->db->get_where('exam_routine',array('school_id'=>$ci->session->userdata('school_id')))->result_array();
    //pre($exam_routines);die;
    //echo "down";
    // echo "here";
    //exit;
    // $row=$events[0];
    $i = 0;

    //this will add javacript to page and will treat div with id calender as full calender
    //to show events inside calednder use events feature of full calender  
    echo " 
                    <script type='text/javascript'>		
                    $(document).ready(function() {
                            $('#eventcalendar').fullCalendar({
                                    defaultDate: '" . date("Y-m-d") . "',
                                    editable: true,
                                    eventLimit: true,
                                    displayEventTime: false,
                                    header: {
                                                            left: 'prev,next today',
                                                            center: 'title',
                                                            right: 'month,agendaWeek,agendaDay,listMonth'
                                                    },

                                    eventClick:  function(event, jsEvent, view) {	
                                         showAjaxModal(\"" . base_url() . "index.php?modal/popup/modal_event_view/\"+event.id);
                                            return false;

                                    },
                                    droppable: true,
                                    drop: function(date) {
                                        //console.log($(this).text().trim());
                                        $('#add-event').find('#event-type').val($(this).text().trim());

                                        var startDate = moment(date.format(), 'YYYY-MM-DD');
                                        var endDate = moment(date.format(), 'YYYY-MM-DD').add(1, 'days');
                                        $('#add-event').find('#datetimepicker_1').val(startDate.format('YYYY-MM-DD HH:mm'));
                                        $('#add-event').find('#datetimepicker_2').val(endDate.format('YYYY-MM-DD HH:mm'));
                                        $('#add-event').modal('show');
                                           
                                    },
                                    eventDrop: function(event, delta, revertFunc) {
                                        if (confirm('Are you sure about this change?')) {
                                            $.ajax({
                                                type: 'POST',
                                                url: '".base_url()."index.php?school_admin/event/update/' + event.id,
                                                data:{startTime:event.start.format('YYYY-MM-DD HH:mm'),endTime:event.end.format('YYYY-MM-DD HH:mm')},
                                                success: function (response) {
                                                    window.location = window.location;
                                                }
                                            });
                                        }
                                    },
                                    eventResize: function(event, delta, revertFunc) { 
                                        if (confirm('Are you sure about this change?')) {
                                            $.ajax({
                                                type: 'POST',
                                                url: '".base_url()."index.php?school_admin/event/update/' + event.id,
                                                data:{startTime:event.start.format('YYYY-MM-DD HH:mm'),endTime:event.end.format('YYYY-MM-DD HH:mm')},
                                                success: function (response) {
                                                    window.location = window.location;
                                                }
                                            });
                                        }
                                    },
                                    events: [
                                           ";
    if (!empty($events)) {
        foreach ($events as $row) {
            $row['title'] = str_replace("'"," ",$row['title']);
            $row['description'] = str_replace("'"," ",$row['description']);
            $i++;
            echo "
                                            {
                                                    id: '" . $row['id'] . "',
                                                    title: '" . trim($row['description'],"'") . "',                                                                                                          start: '" . $row['start'] . "',
                                                    image: 'assets/uploads/" . $row['image'] . "',
                                                    description: '" . strip_slashes($row['title']) . "',
                                                    end: '" . $row['end'] . "',
                                                    url: '" . $row['url'] . "',
                                                    color: '" . $row['color'] . "',
                                                    allDay: false
                                            },";
        }
    };
  
    echo "
                                    ],			
                            });	
                    });			
            </script>
            ";
}

// Display events information inside a modal box
function modalEvents() {

    echo "	
	<div id='fullCalModal' class='modal fade'>
		<div class='modal-dialog'>
			<div class='modal-content'>
				<div class='modal-header'>
					<button type='button' class='close' data-dismiss='modal'><span aria-hidden='true'>&times;</span> <span class='sr-only'>close</span></button>
					<h4><i class='fa fa-calendar' aria-hidden='true'></i> EVENT DETAILS</h4>
				</div>
				
				<div class='modal-body'>
					<div class='table-responsive'>
						<div class='col-md-12'>
							<h4><i class='fa fa-calendar' aria-hidden='true'></i> <span id='modalTitle'></span></h4>
							<p><i class='fa fa-clock-o' aria-hidden='true'></i> <span id='startTime'></span> to <span id='endTime'></span></p>
						</div>
						<div class='col-md-12'>	
							<div id='imageDiv'> </div>
							<br/>
							<h4><i class='fa fa-globe'></i> DESCRIPTION:</h4>
							 <p id='modalBody'></p>
						</div>
					</div>
				</div>
				<div class='modal-footer'>
					<button type='button' class='btn btn-primary' data-dismiss='modal'>CLOSE</button>
					<a class='btn btn-success' id='eventUrl' target='_blank' role='button'>VIEW LINK</a>					
				</div>
			</div>
		</div>
	</div> 
";
}

// Display all events
function listAllEvents() {
    //$sql = mysql_query("select * from events ORDER BY start ASC");
    //$row = mysql_fetch_assoc($sql);
    $ci = & get_instance();
    $events = $ci->db->get_where('events',array('school_id' => $ci->session->userdata('school_id')))->result_array();

    echo "<table class='table table-striped table-bordered table-hover' id='dataTables-example'>";
    echo "  <thead>
                <tr>	
                  <th>TITLE</th>
				  <th>LINK</th>
				  <th>START DATE</th>
				  <th>END DATE</th>
				  <th></th>
                </tr>
              </thead>";
    foreach ($events as $row) {
        echo "<tr><td>";
        echo $row['title'];
        echo "</td><td>";
        echo $row['url'];
        echo "</td><td>";
        echo $row['start'];
        echo "</td><td>";
        echo $row['end'];
        echo "</td><td class='r'>		
			<a href='javascript:EliminaEvento(" . $row['id'] . ")'class='btn btn-danger btn-sm' role='button'><i class='fa fa-fw fa-trash'></i> DELETE</a></td>";
    }

    echo "</table>";
}

// Display all Types (sort of category for Events)
function listAllTypes() {
    //$sql = mysql_query("select * from type ORDER BY id ASC");
    //$row = mysql_fetch_assoc($sql);
    $ci = & get_instance();
    $types = $ci->db->get_where('type',array('school_id' => $ci->session->userdata('school_id')))->result_array();

    echo "<table class='table table-striped table-bordered table-hover' id='dataTables-example'>";
    echo "  <thead>
                <tr>
					<th>ID</th>				
					<th>TITLE</th>					
					<th></th>
                </tr>
              </thead>";

    foreach ($types as $row) {
        // Print out the contents of each row into a table
        echo "<tr><td>";
        echo $row['id'];
        echo "</td>";
        echo "<td>";
        echo $row['title'];
        echo "</td>";
        echo "<td class='r'>		
			<a href='javascript:EliminaTipo(" . $row['id'] . ")'class='btn btn-danger btn-sm' role='button'><i class='fa fa-fw fa-trash'></i> DELETE</a></td>";
        echo "</tr>";
    }

    echo "</table>";
}

//array function
function fetch_parl_key_rec($arr=array(),$key=false,$parl=array()){
    if(!$arr){
        $ci = &get_instance();
        $arr = $ci->db->get_where('settings',array('school_id' => $ci->session->userdata('school_id')))->result_array();
    }

    $f_key = 'type';
    $f_val = 'description';
    if($parl){
        $f_key = $parl[0];
        $f_val = $parl[1];
    }

    $array = array();
    foreach($arr as $r){
        $array[strtolower($r[$f_key])] = $r[$f_val];
    }

    $val = false;
    if($array && $key && isset($array[$key])){
        $val = $array[strtolower($key)];
    }
    return $val;
}

//array function
function sett($key=false,$arr=array(),$parl=array()){
    if(!$arr){
        $ci = &get_instance();
        $arr = $ci->db->get_where('settings',array('school_id' => $ci->session->userdata('school_id')))->result_array();
    }

    $f_key = 'type';
    $f_val = 'description';
    if($parl){
        $f_key = $parl[0];
        $f_val = $parl[1];
    }

    $array = array();
    foreach($arr as $r){
        $array[strtolower($r[$f_key])] = $r[$f_val];
    }

    $val = false;
    if($array && $key && isset($array[$key])){
        $val = $array[strtolower($key)];
    }
    return $val;
}

function decrypt_salary($string)
{
    $key = "chitgoks_hrms";
    $result = '';
    $string = base64_decode($string);

    for($i=0; $i<strlen($string); $i++) {
        $char = substr($string, $i, 1);
        $keychar = substr($key, ($i % strlen($key))-1, 1);
        $char = chr(ord($char)-ord($keychar));
        $result.=$char;
    }

    return $result;
}

function _sess($param=false){
    $CI=&get_instance();
    $key = $param?$param:'running_year';
    return $CI->session->userdata($key);
}

function _getYear(){
    $CI=&get_instance();
    return $CI->session->userdata('running_year');
}
function _getSchoolid(){
    $CI=&get_instance();
    return $CI->session->userdata('school_id');
}

function fi_collection_closed(){
    _school_cond();
    _year_cond();
    $ci = &get_instance();
    $close_rec = $ci->db->get_where('fi_day_end_process',array('DATE(date)'=>date('Y-m-d')))->row();
    return $close_rec?true:false;
}

function get_timing_st_color($st=false,$at_st=false,$closed=false,$custom=false,$is_admin=false){
    $return = array('style'=> '','info'=>false);
    if($st==1){
        //1.Entry-Exit Right
        $return['info'] = 'Entry-Exit Right';
        $return['style'] = 'color: #0EB736;font-weight: bold;';    
    } else if($st==2){
        //2.Entry Right-Exit Early
        $return['info'] = 'Entry Right-Exit Early';
        $return['style'] = 'color: #0EB736;'; 
    }else if($st==3){
        //3.Entry Right-Exit Late
        $return['info'] = 'Entry Right-Exit Late';
        $return['style'] = 'color: #7bb70b;font-weight: bold;';
    }else if($st==4){
        //4.Entry Late-Exit Right
        $return['info'] = 'Entry Late-Exit Right';
        $return['style'] = 'color: #7bb70b;';
    }else if($st==5){
        //5.Entry Late-Exit Early
        $return['info'] = 'Entry Late-Exit Early';
        $return['style'] = 'color: #7bb70b;';
    }else if($st==6){
        //6.Entry Late-Exit Late
        $return['info'] = 'Entry Late-Exit Late';
        $return['style'] = 'color: #7bb70b;font-weight: bold;';
    }else if($st==7){
        //7.No Entry-But Exit
        $return['info'] = 'No Entry-But Exit';
        $return['style'] = 'color: #7bb70b;';
    }else if($st==8){
        //8.Entry-No Exit - Att Open
        $return['info'] = 'Present';
        $return['style'] = 'color: #0EB736;';
        if($st==8 && $closed){
            //8.Entry-No Exit - Att Closed
            $return['info'] = 'Entry- But No Exit';
            $return['style'] = 'color: #ef970f;font-weight: bold;';
        }
    }
    
    //9.No Record / But Present
    if((!$st || $st==9) && $at_st==1){
        $return['info'] = 'Present';
        if($custom){
            $return['info'] = 'Present, Marked by '.($is_admin?'admin':'teacher');
        }
        $return['style'] = 'color: #0EB736;';
    }else if($at_st==2){
        //Absent
        $return['info'] = 'Absent';
        if($custom){
            $return['info'] = 'Absent, Marked by '.($is_admin?'admin':'teacher');
        }
        $return['style'] = 'color: #f50404;';
    }
    return $return;
}

