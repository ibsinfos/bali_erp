<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('student_Information'); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>index.php?teacher/Dashboard">
                    <?php echo get_phrase('Dashboard'); ?>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url(); ?>index.php?teacher/student_information">
                    <?php echo get_phrase('Student_information'); ?>
                </a>
            </li>
            <li class="active">
                <?php echo get_phrase('student_profile'); ?>
            </li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>

<?php if (!empty($student_personal_info))
    {
        ?>

    <div class="row">
        <div class="col-md-12">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne" data-step="5" data-intro="<?php echo get_phrase('Here, You can see basic information of student like photo,class details, section, previous school, course etc. you can collapse this tab and see others to the click on arrow. Like that only you can see class routine, progress report, library information, Transport information, dormitory information, Medical record, Attendance report, Marksheet.');?>" data-position='bottom'>
                        <h4 class="panel-title">
                            <a class="head" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <b><?php echo get_phrase('General_information');?></b>
                            </a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body">
                            <table class="table table-bordered margin-no-bottom">
                                <div class="row">
                                    <div class="el-element-overlay col-lg-2 col-md-4 col-sm-6">
                                        <div class="el-card-item">
                                            <?php
                                                    $image_url   =   ($student_personal_info->stud_image !=''?base_url().'uploads/student_image/'.$student_personal_info->stud_image:base_url() . 'uploads/user.jpg');
                                               ?>
                                                <div class="el-overlay-1">
                                                    <img src="<?php echo $image_url;?>" />
                                                    <div class="el-overlay">
                                                        <ul class="el-info">
                                                            <li>
                                                                <a class="btn default btn-outline image-popup-vertical-fit" href="<?php echo $image_url;?>">
                                                                    <i class="fa fa-search-plus"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                        </div>

                                    </div>

                                    <div class="col-lg-10 col-md-8 col-sm-6 top-name">
                                        <h2 class="stu-name-margin"><?php echo $student_personal_info->name ." ". ($student_personal_info->mname!=''?$student_personal_info->mname:'') ." ". $student_personal_info->lname; ?></h2>
                                    </div>


                                </div>

                                <tr>
                                    <th><b><?php echo get_phrase('class_ : '); ?></b></th>
                                    <td>
                                        <?php echo $student_personal_info->class_name; ?>
                                    </td>
                                </tr>

                                <tr>
                                    <th><b><?php echo get_phrase('section_ : '); ?></b></th>
                                    <td>
                                        <?php echo $student_personal_info->section_name ?>
                                    </td>
                                </tr>

                                <tr>
                                    <th><b><?php echo get_phrase('roll_ : '); ?></b></th>
                                    <td>
                                        <?php echo $student_personal_info->enroll_code; ?>
                                    </td>
                                </tr>

                                <tr>
                                    <th><b><?php echo get_phrase('birthday_ : '); ?></b></th>
                                    <td>
                                        <?php echo $student_personal_info->birthday; ?>
                                    </td>
                                </tr>

                                <tr>
                                    <th><b><?php echo get_phrase('gender_ : '); ?></b></th>
                                    <td>
                                        <?php echo $student_personal_info->sex; ?>
                                    </td>
                                </tr>

                                <tr>
                                    <th><b><?php echo get_phrase('phone_ : '); ?></b></th>
                                    <td>
                                        <?php echo $student_personal_info->phone; ?>
                                    </td>
                                </tr>

                                <tr>
                                    <th><b><?php echo get_phrase('email_ : '); ?></b></th>
                                    <td>
                                        <?php echo $student_personal_info->email; ?>
                                    </td>
                                </tr>

                                <tr>
                                    <th><b><?php echo get_phrase('address_ : '); ?></b></th>
                                    <td>
                                        <?php echo $student_personal_info->address; ?>
                                    </td>
                                </tr>

                                <tr>
                                    <th><b><?php echo get_phrase('country_ : '); ?></b></th>
                                    <td>
                                        <?php echo $student_personal_info->country; ?>
                                    </td>
                                </tr>

                                <tr>
                                    <th><b><?php echo get_phrase('nationality_:  '); ?></b></th>
                                    <td>
                                        <?php echo $student_personal_info->nationality; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><b><?php echo get_phrase('place_of_birth_ : '); ?></b></th>
                                    <td>
                                        <?php echo $student_personal_info->place_of_birth; ?>
                                    </td>
                                </tr>

                                <tr>
                                    <th><b><?php echo get_phrase('previous_school_ : '); ?></b></th>
                                    <td>
                                        <?php echo $student_personal_info->previous_school; ?>
                                    </td>
                                </tr>

                                <tr>
                                    <th><b><?php echo get_phrase('course_ : '); ?></b></th>
                                    <td>
                                        <?php echo $student_personal_info->course; ?>
                                    </td>
                                </tr>

                                <tr>
                                    <th><b><?php echo get_phrase('parent_ : '); ?></b></th>
                                    <td>
                                        <?php
                                        echo $student_personal_info->father_name;
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><b><?php echo get_phrase('parent_phone_ : '); ?></b></th>
                                    <td>
                                        <?php echo $student_personal_info->cell_phone; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><b><?php echo get_phrase('emergency_contact_number_ : '); ?></b></th>
                                    <td>
                                        <?php echo $student_personal_info->emergency_contact_number; ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingTwo">
                        <h4 class="panel-title">
                            <a class="collapsed head" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <b><?php echo get_phrase('Class_Routine');?></b>
                            </a>
                        </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                        <div class="panel-body">
                            <?php echo get_phrase('class');?> -
                                <?php if($class_id!=NULL){echo $class_name;}else{echo " ";}?> :
                                    <?php echo get_phrase('section');?> -
                                        <?php  if(!empty($section_id)){
                        
                    if(!empty($section_name)){
                        echo $section_name;
                    }else{
                        echo " ";
                    }                    
                    }else{echo "";}
                    
                    ?>
                        </div>
                        <div class="panel-body panel_for_child">

                            <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered m-b-0">
                                <tbody>
                                    <?php echo $routine_data;
                        ?>                                       
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingThree">
                        <h4 class="panel-title">
                            <a class="collapsed head" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                               <b><?php echo get_phrase('Progress_report');?></b>
                            </a>
                        </h4>
                    </div>
                    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                        <div class="panel-body">
                                <div class="sttabs tabs-style-flip">
                                          <nav>
                                        <ul>  
<?php foreach ($subjects as $row2):?>
                                                  <li class="active">                                            
                            <a href="#subject_<?php echo $row2['subject_id'];?>" class="sticon fa fa-list"><span><?php echo $row2['name'];?></span></a></li>
<?php endforeach;?>
                                        </ul>
                                        </nav>
                                <div class="content-wrap">
                                    <?=$report_data?>        
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingThree">
                        <h4 class="panel-title">
                            <a class="collapsed head" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseThree">
                                <b><?php echo get_phrase('library_information');?></b>
                            </a>
                        </h4>
                    </div>
                    <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                        <div class="panel-body">
                            <table class="table table-bordered margin-no-bottom">
 <?php if(!empty($issue_log)){ ?>
                                <thead>
                                    <tr>
                                        <th><b><?php echo get_phrase('book_name'); ?></b></th>
                                        <th><b><?php echo get_phrase('issue_date'); ?></b></th>
                                        <!--<th><div><?php //echo get_phrase('issue_by'); ?></div></th>-->
                                        <th><b><?php echo get_phrase('return_date'); ?></b></th>
                                        <!--<th><div><?php //echo get_phrase('return_to'); ?></div></th>-->
                                        <th><b><?php echo get_phrase('current_status'); ?></b></th>
                                        <th><b><?php echo get_phrase('fine_amount'); ?></b></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php  
                                foreach ($issue_log as $issue_logs):
                            ?>
                                <tr>
                                    <td><?php echo empty($issue_logs['title']) ? "" : $issue_logs['title']; ?></td>
                                    <td><?php echo empty($issue_logs['issue_date']) || $issue_logs['issue_date'] == "0000-00-00" ? "" : date("d-m-Y", strtotime($issue_logs['issue_date'])); ?></td>
                                    <td><?php echo empty($issue_logs['return_date']) || $issue_logs['return_date'] == "0000-00-00" ? "" : date("d-m-Y", strtotime($issue_logs['return_date'])); ?></td>
                                    <td><?php if($issue_logs['is_returned']==1) echo "Yes"; else echo "No"; ?></td>
                                    <td><?php echo $issue_logs['fine_amount']; ?></td>
                                </tr>
                                <?php
                 endforeach;
                        }else{  ?>
                           
                                <tbody><tr><td><?php echo get_phrase('no_data_available'); ?></td></tr></tbody>  
                    <?php     }
        ?>
                        
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>

                <!--                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingThree">
                        <h4 class="panel-title">
                            <a class="collapsed head" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseThree">
                               Fee & Charges Information
                            </a>
                        </h4>
                    </div>
                    <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                        <div class="panel-body">
                            <table class="table table-bordered margin-no-bottom">

                            <tr>
                                 <th><b><?php // echo get_phrase('class_ : '); ?></b></th>
                                 <td>class name</td>
                            </tr>
                           <tr>
                                 <th><b><?php// echo get_phrase('class_ : '); ?></b></th>
                                 <td>class name</td>
                            </tr>

                            <tr>
                                 <th><b><?php //echo get_phrase('class_ : '); ?></b></th>
                                 <td>class name</td>
                            </tr>
                        
                            <tr>
                                 <th><b><?php //echo get_phrase('class_ : '); ?></b></th>
                                 <td>class name</td>
                            </tr>
                            </table> 
                        </div>
                    </div>
                </div>-->

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingThree">
                        <h4 class="panel-title">
                            <a class="collapsed head" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="false" aria-controls="collapseThree">
                               <b><?php echo get_phrase('Transport_information');?></b>
                            </a>
                        </h4>
                    </div>
                    <div id="collapseSix" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                        <div class="panel-body">
                            <table class="table table-bordered margin-no-bottom">

                                <?php 
                            if(!empty($transports)){ ?>
                                <tr>
                                        <th><b><?php echo get_phrase('bus_name'); ?></b></th>
                                        <td>
                                            <?php echo ucfirst($transports[0]['bus_name']);  ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><b><?php echo get_phrase('bus_no'); ?></b></th>
                                        <td>
                                            <?php echo $transports[0]['bus_unique_key'];  ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th><b><?php echo get_phrase('route_name'); ?></b></th>
                                        <td>
                                            <?php echo ucfirst($transports[0]['route_from']).' To '.ucfirst($transports[0]['route_to'])  ;  ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><b><?php echo get_phrase('bus_driver_name'); ?></b></th>
                                        <td>
                                            <?php echo ucfirst($transports[0]['bus_driver_name']);  ?>
                                        </td>
                                    </tr>

                                    <?php
                            }else{ echo get_phrase('no_data_available'); }?>

                            </table>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingThree">
                        <h4 class="panel-title">
                            <a class="collapsed head" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSeven" aria-expanded="false" aria-controls="collapseThree">
                               <b><?php echo get_phrase('Dormitory_information');?></b>
                            </a>
                        </h4>
                    </div>
                    <div id="collapseSeven" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                        <div class="panel-body">
                            <table class="table table-bordered margin-no-bottom">

                                <?php if(!empty($student_infoh)){
                      foreach ($student_infoh as $row) { ?>
                                    <tr>
                                        <th><b><?php echo get_phrase('hostel_name:'); ?></b></th>
                                        <td>
                                            <?php echo $row['hostel_name']  ;  ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th><b><?php echo get_phrase('type:'); ?></b></th>
                                        <td>
                                            <?php echo $row['hostel_type']  ;?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th><b><?php echo get_phrase('floor_name:'); ?></b></th>
                                        <td>
                                            <?php echo $row['floor_name']  ;?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th><b><?php echo get_phrase('room_no:'); ?></b></th>
                                        <td>
                                            <?php echo $row['room_no']  ; ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th><b><?php echo get_phrase('food:'); ?></b></th>
                                        <td>
                                            <?php echo $row['food']  ; ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th><b><?php echo get_phrase('register_date:'); ?></b></th>
                                        <td>
                                            <?php echo $row['register_date']  ; ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th><b><?php echo get_phrase('vacating_date:'); ?></b></th>
                                        <td>
                                            <?php echo $row['vacating_date']  ; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><b><?php echo get_phrase('transfer_date:'); ?></b></th>
                                        <td>
                                            <?php echo $row['transfer_date']  ; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><b><?php echo get_phrase('status:'); ?></b></th>
                                        <td>
                                            <?php echo $row['status']  ; ?>
                                        </td>
                                    </tr>
                                    <?php }
                  
    }else{
                                echo get_phrase('no_data_available ');
                            }?>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingThree">
                        <h4 class="panel-title">
                            <a class="collapsed head" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseEight" aria-expanded="false" aria-controls="collapseThree">
                               <b><?php echo get_phrase('medical_record');?></b> 
                            </a>
                        </h4>
                    </div>
                    <div id="collapseEight" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                        <div class="panel-body">
                            <table class="table table-bordered margin-no-bottom">

                                <tbody>
                                    <?php 
                            if(!empty($medical_records)){ ?>
                                        <thead>
                                            <th><b><?php echo get_phrase('no_ '); ?></b></th>
                                            <th><b><?php echo get_phrase('desease_ '); ?></b></th>
                                            <th><b><?php echo get_phrase('date_ '); ?></b></th>
                                            <th><b><?php echo get_phrase('description_ '); ?></b></th>

                                        </thead>
                                        <?php   $c = 1; foreach($medical_records as $med_rec): ?>
                                            <tr>
                                                <td>
                                                    <?php echo $c++;?>
                                                </td>
                                                <td>
                                                    <?php echo $med_rec['desease_title'];?>
                                                </td>
                                                <td>
                                                    <?php echo $med_rec['consult_date'];?>
                                                </td>
                                                <td>
                                                    <?php echo $med_rec['description'];?>
                                                </td>
                                            </tr>
                                            <?php                                    
            endforeach;
                            }
                            else{
                                echo get_phrase('no_data_available ');
                            }
        ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingThree">
                        <h4 class="panel-title">
                            <a class="collapsed head" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseNine" aria-expanded="false" aria-controls="collapseThree">
                              <b><?php echo get_phrase('Attendance_record');?></b>
                            </a>
                        </h4>
                    </div>
                    <div id="collapseNine" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                        <div class="panel-body">

                            <?php if ($class_id != '' && $section_id != '' && $month != ''): 
?>   <h4>
    <?php echo get_phrase('class') . ' ' . $class_name; ?> : <?php echo get_phrase('section');?> <?php echo $section_name; ?><br>
    <?php // echo $m;?>
                </h4>
                <table class="table table-bordered margin-no-bottom">
                    <thead>
                    <th>Month Name</th>
                    <th>Total Days</th>
                    <th>Attendance</th>

                    </thead>

                    <tbody>
                        <?=$attendance_report?>
                    </tbody>
                </table>
                <?php endif; ?>
                </div>
            </div>
        </div>

                <div class="panel">
                    <div class="panel-heading" role="tab" id="headingThree">
                        <h4 class="panel-title">
                            <a class="collapsed head" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTen" aria-expanded="false" aria-controls="collapseThree">
                               <b><?php echo get_phrase('marksheets');?></b>
                            </a>
                        </h4>
                    </div>
                    <div id="collapseTen" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                        <div class="panel-body">
                            <?php       
                                foreach ($student_info as $row1):
                                    foreach ($marks_data as $row2):
                                    $row2 = $row2['marks'];
                                        ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="panel panel-danger block6" data-collapsed="0">
                                            <div class="panel-heading">
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
                                                                    <th class="text-center">Obtained marks</th>
                                                                    <th class="text-center">Highest mark</th>
                                                                    <th class="text-center">Grade</th>
                                                                    <th class="text-center">Comment</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                        $total_marks = 0;
                                        $total_grade_point = 0;

                                        foreach ($row2['subject'] as $row3):
                                            ?>
                                                                    <tr>
                                                                        <td class="text-center">
                                                                            <?php echo $row3['name']; ?>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <?php
//                                                    
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
                                                                        <td class="text-center">
                                                                            <?php
                                                                           if(isset($row3['highest_mark'])) {
                                                    $highest_mark = $row3['highest_mark'];
                                                                           echo $highest_mark; }
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
                                                            echo $grade['name'];
                                                            $total_grade_point += $grade['grade_point'];
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
                                </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <?php 

    }
else{
 echo get_phrase('student_detail_not_available');
}