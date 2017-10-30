<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('Advance_Filter'); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);"  onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/Dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active"><?php echo get_phrase('Advance_filter'); ?></li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>

<script type="text/javascript" src="assets/new_assets/js/datatable.js"></script>
<?php 
$attributes = array('name' => 'student_misc_report_advance_filter', 'id' => 'student_misc_report_advance_filter',"onsubmit"=>'return validateSubmition();');
echo form_open(base_url()."index.php?admin_report/student_misc_report_advance_filter_submit", $attributes);
?>
    <div class="row">
        <div class="white-box col-sm-12"  data-step="5" data-intro="<?php echo get_phrase('From_here_you_can_advance_filter_the_students.');?>" data-position='top'>
            
        <div class="col-md-4 form-group">
            <label for="date of birth"><?php echo get_phrase('date_of_birth'); ?></label>
            <div class="input-group">
                <div class="input-group-addon"><i class="icon-calender"></i></div>
                <input type="text" class="form-control mydatepicker" placeholder="mm/dd/yyyy" id="DOB" name="DOB">
            </div>
        </div>
        
        <div class="col-md-4 form-group">
            <label for="pwd"><?php echo get_phrase('Passport'); ?></label>
            <div class="input-group">
                <div class="input-group-addon"><i class="ti-user"></i></div>
                <input type="text" class="form-control" id="passport" name="passport" placeholder="Enter passport no.">
            </div>
        </div>
        
        <div class="col-md-4 form-group">
            <label for="first name"><?php echo get_phrase('first_name'); ?></label>
            <div class="input-group">
                <div class="input-group-addon"><i class="ti-user"></i></div>
                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter First Name">
            </div>
        </div>
        
        <div class="col-md-4 form-group">
            <label for="last_name"><?php echo get_phrase('last_name'); ?></label>
            <div class="input-group">
                <div class="input-group-addon"><i class="ti-user"></i></div>
                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter Last Name">
            </div>
        </div>
        
        <div class="col-md-4 form-group">
            <label for="father's full name"><?php echo get_phrase('father_full_name'); ?></label>
            <div class="input-group">
                <div class="input-group-addon"><i class="ti-user"></i></div>
                <input type="text" class="form-control" id="father_name" name="father_name" placeholder="Enter Father Full Name ">
            </div>
        </div>
        <div class="col-sm-4 form-group">
            <label for="field-2">
                <?php echo get_phrase('gender'); ?></label>
            <select name="sex" class="selectpicker" data-style="form-control" data-live-search="true" data-validate="required" data-message-required="Please select your gender">
                <option value="">
                    <?php echo get_phrase('select'); ?>
                </option>
                <option value="Male">
                    <?php echo get_phrase('male'); ?>
                </option>
                <option value="Female">
                    <?php echo get_phrase('female'); ?>
                </option>
            </select>

        </div>
        
        <!--        <div class="col-md-4 form-group">
            <h5 class="m-t-30 m-b-10"><?php echo get_phrase('gender'); ?></h5>
            <select name="sex" class="col-md-4 selectpicker" data-style="form-control">
                <option value=""><?php echo get_phrase('select'); ?></option>
                <option value="Male"><?php echo get_phrase('male'); ?></option>
                <option value="Female"><?php echo get_phrase('female'); ?></option>
            </select>
        </div>-->
        
        <div class="col-md-4 col-sm-6 col-xs-12">
            <label for="religion"><?php echo get_phrase('religion'); ?></label>
                <div class="form-group">
                   <input type="text" class="form-control" id="religion" name="religion" placeholder="Select Religion">
                </div>
        </div>

<!--                                    <div class="col-sm-4 form-group">
                                        <div class="form-group">
                                            <label for="field-1" class="control-label">
                                                <?php echo get_phrase('phone'); ?><span class="error mandatory"> *</span></label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-phone"></i></div>
                                                <input type="tel" class="form-control numeric" name="phone" value="<?=set_value('phone')?>" data-validate="required" title="" data-message-required="Please enter a valid phone number" maxlength="10">
                                                <span id="error_phone mandatory"></span>
                                            </div>
                                        </div>
                                    </div>-->
               <div class="col-md-4 col-sm-6 col-xs-12">
            <label for="mobile No."><?php echo get_phrase('mobile_no'); ?></label>
                <div class="form-group">
                    <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-phone"></i></div>
                    <input type="tel" class="form-control numeric" id="cell_phone" name="phone" value="<?=set_value('phone')?>" placeholder="Enter Mobile No" maxlength="10"/>
                </div>
            </div>
               </div>

             <!--<div class="col-md-6">
             <div class="form-group">
                  <label class="control-label col-sm-4" for="bloodgroup">Blood  Group:</label>
                  <div class="col-sm-8">          
                      <select name="blood_group" id="blood_group">
                        <option value="">Select Blog Group</option>
                        <option value="a+">A+</option>
                        <option value="a-">A-</option>
                        <option value="b+">B+</option>
                        <option value="b-">B-</option>
                        <option value="ab+">AB+</option>
                        <option value="ab-">AB-</option>
                        <option value="o+">O+</option>
                        <option value="o-">O-</option>

                     </select>
                  </div>
                </div>
            </div> -->

        <div class="col-md-4 col-sm-6 col-xs-12">
            <label for="city"><?php echo get_phrase('city'); ?></label>
                <div class="form-group">
                    <input type="text" class="form-control" id="city" name="city" placeholder="Enter City">
                </div>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12">
            <label for="admiassion date"><?php echo get_phrase('admission_date'); ?></label>
            <div class="form-group">          
                <input type="text" readonly class="form-control datepicker" id="admission_date" name="admission_date" placeholder="Enter Admission Date">
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12">
            <label for="RFID ccard"><?php echo get_phrase('rfid_card_no:'); ?></label>
                <div class="form-group">
                    <input type="number" class="form-control" id="card_no" name="card_no" placeholder="Enter RFID Card No.">
                </div>
        </div>

        <div class="col-md-4 col-sm-6 col-xs-12">
            <label for="city"><?php echo get_phrase('category'); ?></label>
            <div class="form-group">
                <select class="selectpicker" data-style="form-control" data-live-search="true" name='category' id ='category'>
                    <option value=''>Select Category</option>
                    <option value='GENERAL'>GENERAL</option>
                    <option value='OBC'>OBC</option>
                    <option value='ST'>ST</option>
                    <option value='SC'>SC</option>
                </select>
            </div>
        </div>    

             <div class="text-right">
                                    <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('Submit'); ?></button>
                                </div>

<!--        <div class="col-md-12 col-sm-6 col-xs-12 go_top">
            <button class="btn-info btn pull-right"><?php echo get_phrase('Submit'); ?></button>
    </div>    -->
    </div>
    </div>

<div class="row">
	<div class="col-sm-12">    
        <div class="white-box" data-step="6" data-intro="<?php echo get_phrase('Here_you_can_view_the_list_of_students.');?>" data-position="top"> 
<table id="example23" class="display nowrap" cellspacing="0" width="100%">
    <thead>
        <tr>
                            <th width="80"><div><?php echo get_phrase('roll_no'); ?></div></th>                            
                            <th><div><?php echo get_phrase('name'); ?></div></th>                            
                            <th><div><?php echo get_phrase("father's_Name"); ?></div></th>
                            <th><div><?php echo get_phrase("student_card_no"); ?></div></th>
                            <th><div><?php echo get_phrase('gender'); ?></div></th>
                            <th><div><?php echo get_phrase('date_of_birth'); ?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                      
                        foreach ($student_all as $row): 
                            ?>
                        <tr class="tr_<?=$row['student_id'];?>" >
                                <td><?php echo $row['roll']; ?></td>
                                <td>
                                    <?php
                                    echo ucfirst($row['name'])." ".ucfirst($row['lname']);
                                    ?>
                                </td>                             
                                                          
                               
                                    <td>
                                        <?php
                                           echo ucfirst($row['father_name']);
                                           ?>
                                    </td>
                                
                                    
                                    <td>
                                        <?php
                                           echo $row['icard_no'];
                                           ?>
                                    </td>                                
                                    
                                <td>
                                    <?php
                                     echo ucfirst($row['sex']);
                                        
                                    ?>
                                </td><td>
                                    <?php
                                 
                                       echo $row['birthday'];
                                        ?>
                                   
                                </td>
                                
                                
                                
                            </tr>
<?php endforeach; ?>
                          
                    </tbody>
                </table>

            </div>
            
         
        </div>
    </div>
</div>



<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->                      
<script type="text/javascript">
    
$(document).ready(function() {
    jQuery('.datepicker').datepicker({
        autoclose: true
    });
    $(".numeric").numeric(); 
} );


$(document).ready(function() {
    var datatable = $("#table_export").dataTable({
        
        rowReorder: {
                        selector: 'td:nth-child(2)'
			},
		responsive: true,
          "sPaginationType": "bootstrap",
        dom: 'Bfrtip',
        buttons: [
            'pageLength',
            {
                
                
                extend: 'excel',
                exportOptions: {
                      columns: [  0, 1, 2,3,4, 5 ,6 ]
                }
            },
            {
                extend: 'pdf',
                exportOptions: {
                    columns: [  0, 1, 2,3,4, 5 ,6 ]
                }
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: [ 0, 1, 2,3,4, 5,6 ]
                }
            },
        ]
       
    } );
     
} );




</script>
