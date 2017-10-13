    <div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('All Parents'); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);"  onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>index.php?school_admin/Dashboard">
                    <?php echo get_phrase('Parents'); ?>
                </a>
            </li>
            <li class="active">
                <?php echo get_phrase('student_Information'); ?>
            </li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>

<?php 
$attributes = array('name' => 'parent_misc_report_advance_filter', 'id' => 'parent_misc_report_advance_filter',"onsubmit"=>'return validateSubmition();');
echo form_open(base_url()."index.php?admin_report/parent_misc_report_advance_filter_submit", $attributes);
?>

<!--<div class="row">
     <div class="col-md-4 col-sm-6 col-xs-12">
        <label for="first name" <?php if(isset($search_condition['first_name']) && $search_condition['first_name']!=''){echo 'class="SearchText"';}?> ><?php echo get_phrase('first_name'); ?></label>
            <div class="form-group">
               <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter First Name" value="<?php if(isset($search_condition['first_name']) && $search_condition['first_name']!=''){echo $search_condition['first_name'];}?>">
            </div>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12">
        <label for="middle name" <?php if(isset($search_condition['middle_name']) && $search_condition['middle_name']!=''){echo 'class="SearchText"';}?> ><?php echo get_phrase('middle_name'); ?></label>
            <div class="form-group">          
                <input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="Enter Middle Name" value="<?php if(isset($search_condition['middle_name']) && $search_condition['middle_name']!=''){echo $search_condition['middle_name'];}?>">
            </div>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12">
         <label for="last name" <?php if(isset($search_condition['last_name']) && $search_condition['last_name']!=''){echo 'class="SearchText"';}?> ><?php echo get_phrase('last_name'); ?></label>
            <div class="form-group">
                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter Last Name" value="<?php if(isset($search_condition['last_name']) && $search_condition['last_name']!=''){echo $search_condition['last_name'];}?>">
            </div>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12">
        <label for="profession" <?php if(isset($search_condition['profession']) && $search_condition['profession']!=''){echo 'class="SearchText"';}?> ><?php echo get_phrase('profession'); ?></label>
            <div class="form-group">          
                <input type="text" class="form-control" id="profession" name="profession" placeholder="Enter Profession" value="<?php if(isset($search_condition['profession']) && $search_condition['profession']!=''){echo $search_condition['profession'];}?>">
            </div>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12">
        <label for="enroll code" <?php if(isset($search_condition['enroll_code']) && $search_condition['enroll_code']!=''){echo 'class="SearchText"';}?> ><?php echo get_phrase('student_enroll_code'); ?></label>
            <div class="form-group">
                <input type="text" class="form-control" id="enroll_code" name="enroll_code" placeholder="Enter Student Enroll Code" value="<?php if(isset($search_condition['enroll_code']) && $search_condition['enroll_code']!=''){echo $search_condition['enroll_code'];}?>">
            </div>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12">
        <label for="gender" <?php if(isset($search_condition['sex']) && $search_condition['sex']!=''){echo 'class="SearchText"';}?> ><?php echo get_phrase('gender'); ?></label>
            <div class="form-group">          
                <select name="sex" class="form-control" >
                    <option value=""><?php echo get_phrase('select'); ?></option>
                    <option value="Male" <?php if(isset($search_condition['sex']) && $search_condition['sex']=='Male'){echo 'selected';}?> ><?php echo get_phrase('male'); ?></option>
                    <option value="Female" <?php if(isset($search_condition['sex']) && $search_condition['sex']=='Female'){echo 'selected';}?> ><?php echo get_phrase('female'); ?></option>
                </select>
            </div>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12">
        <label for="email" <?php if(isset($search_condition['email']) && $search_condition['email']!=''){echo 'class="SearchText"';}?> ><?php echo get_phrase('email'); ?></label>
            <div class="form-group">
               <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email Id" value="<?php if(isset($search_condition['email']) && $search_condition['email']!=''){echo $search_condition['email'];}?>">
            </div>
    </div>
   <div class="col-md-4 col-sm-6 col-xs-12">
        <label for="mobile No." <?php if(isset($search_condition['cell_phone']) && $search_condition['cell_phone']!=''){echo 'class="SearchText"';}?> ><?php echo get_phrase('mobile_no'); ?></label>
            <div class="form-group">
                <input type="text" class="form-control numeric" id="cell_phone" name="cell_phone" placeholder="Enter Mobile No" maxlength="12" value="<?php if(isset($search_condition['cell_phone']) && $search_condition['cell_phone']!=''){echo $search_condition['cell_phone'];}?>" />
            </div>
        </div>        
 
    <div class="col-md-4 col-sm-6 col-xs-12">
        <label for="city" <?php if(isset($search_condition['city']) && $search_condition['city']!=''){echo 'class="SearchText"';}?> ><?php echo get_phrase('city'); ?></label>
            <div class="form-group">
                <input type="text" class="form-control" id="city" name="city" placeholder="Enter City" value="<?php if(isset($search_condition['city']) && $search_condition['city']!=''){echo $search_condition['city'];}?>">
            </div>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12">
        <label for="state" <?php if(isset($search_condition['state']) && $search_condition['state']!=''){echo 'class="SearchText"';}?> ><?php echo get_phrase('state'); ?></label>
            <div class="form-group">          
               <input type="text" class="form-control" id="state" name="state" placeholder="Enter State" value="<?php if(isset($search_condition['state']) && $search_condition['state']!=''){echo $search_condition['state'];}?>">
            </div>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12">
        <label for="country" <?php if(isset($search_condition['country']) && $search_condition['country']!=''){echo 'class="SearchText"';}?> ><?php echo get_phrase('country:'); ?></label>
            <div class="form-group">
                <input type="text" class="form-control" id="country" name="country" placeholder="Enter Country" value="<?php if(isset($search_condition['country']) && $search_condition['country']!=''){echo $search_condition['country'];}?>">
            </div>
    </div>
      
    <div class="col-md-4 col-sm-6 col-xs-12 go_top">
        <button class="btn-info btn pull-right"><?php echo get_phrase('Submit'); ?></button>
</div>    
 </div>-->
<div class="row white-box" data-step="5" data-intro="<?php echo get_phrase('From here you can advance filter search the parent records.');?>" data-position='top'>
<div class="row">
    <div class="col-md-4 form-group">
	<div class="form-group">
	    <label for="first name" <?php if(isset($search_condition['first_name']) && $search_condition['first_name']!=''){echo 'class="SearchText"';}?> ><?php echo get_phrase('first_name'); ?></label>
	    <div class="input-group">
		<div class="input-group-addon"><i class="ti-user"></i></div>
		<input type="text" class="form-control" id="first_name" name="first_name" placeholder="Father's First Name" value="<?php if(isset($search_condition['first_name']) && $search_condition['first_name']!=''){echo $search_condition['first_name'];}?>">
	    </div>
	</div>
    </div>
    
    <div class="col-md-4 form-group">
	<div class="form-group">
	     <label for="middle name" <?php if(isset($search_condition['middle_name']) && $search_condition['middle_name']!=''){echo 'class="SearchText"';}?> ><?php echo get_phrase('middle_name'); ?></label>
	    <div class="input-group">
		<div class="input-group-addon"><i class="ti-user"></i></div>
	    <input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="Father's Middle Name" value="<?php if(isset($search_condition['middle_name']) && $search_condition['middle_name']!=''){echo $search_condition['middle_name'];}?>" >
	</div>
	</div>
    </div>
    
    <div class="col-sm-4 form-group">
	<div class="form-group">
	   <label for="last name" <?php if(isset($search_condition['last_name']) && $search_condition['last_name']!=''){echo 'class="SearchText"';}?> ><?php echo get_phrase('last_name'); ?></label>
	    <div class="input-group">
		<div class="input-group-addon"><i class="ti-user"></i></div>
	    <input type="text" class="form-control" id="last_name" name ="last_name" placeholder="Father's Last Name" value="<?php if(isset($search_condition['last_name']) && $search_condition['last_name']!=''){echo $search_condition['last_name'];}?>" > 
	</div>
    </div>
</div>
</div>


<div class="row">
     <div class="col-md-4 form-group">
	<div class="form-group">
	    <label for="profession" <?php if(isset($search_condition['profession']) && $search_condition['profession']!=''){echo 'class="SearchText"';}?> ><?php echo get_phrase('profession'); ?></label>
<div class="input-group">
		<div class="input-group-addon"><i class="fa fa-briefcase"></i></div>
	    <input type="text" class="form-control" id="profession" name="profession" placeholder="Enter Profession" value="<?php if(isset($search_condition['profession']) && $search_condition['profession']!=''){echo $search_condition['profession'];}?>" >
	</div></div>
    </div>


    <div class="col-sm-4 form-group">

                                        <label for="enroll code" <?php if(isset($search_condition['enroll_code']) && $search_condition['enroll_code']!=''){echo 'class="SearchText"';}?> ><?php echo get_phrase('student_enroll_code'); ?></label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-id-badge"></i></div>
                                            <input type="text" class="form-control" name="card_id" value="<?php if(isset($search_condition['enroll_code']) && $search_condition['enroll_code']!=''){echo $search_condition['enroll_code'];}?>" placeholder="Enter Student Enroll Code" data-message-required="Please enter your RFID number">
                                        </div>

                                    </div>
    
     <div class="col-sm-4 form-group">
                                         <label for="gender" <?php if(isset($search_condition['sex']) && $search_condition['sex']!=''){echo 'class="SearchText"';}?> ><?php echo get_phrase('gender'); ?></label>

                                        <select name="sex" class="selectpicker" data-style="form-control" data-live-search="true" data-message-required="Please select your gender">
                                            <option value="">
                                                <?php echo get_phrase('select'); ?>
                                            </option>
                                            <option value="Male"<?php if(isset($search_condition['sex']) && $search_condition['sex']=='Male'){echo 'selected';}?> ><?php echo get_phrase('male'); ?>
                                            </option>
                                            <option value="Female"<?php if(isset($search_condition['sex']) && $search_condition['sex']=='Female'){echo 'selected';}?> ><?php echo get_phrase('female'); ?>
                                            </option>
                                        </select>

                                    </div>

</div>

<div class="row">
    <div class="col-sm-4 form-group">
	<div class="form-group">
	    <label for="email" <?php if(isset($search_condition['email']) && $search_condition['email']!=''){echo 'class="SearchText"';}?> ><?php echo get_phrase('email'); ?></label>
 <div class="input-group">
		<div class="input-group-addon"><i class="fa fa-envelope""></i></div>
	    <input type="email" class="form-control" id="email" name="email" placeholder="Enter a valid email" value="<?php if(isset($search_condition['email']) && $search_condition['email']!=''){echo $search_condition['email'];}?>" >       
	    <span id="parent_email_error" style="color: red;" ></span>
	</div></div>
    </div>
    
    <div class="col-md-4 form-group">
	<div class="form-group">
	    <label for="mobile No." <?php if(isset($search_condition['cell_phone']) && $search_condition['cell_phone']!=''){echo 'class="SearchText"';}?> ><?php echo get_phrase('mobile_no'); ?></label>
	    <div class="input-group">
		<div class="input-group-addon"><i class="fa fa-mobile"></i></div>
	    <input type="tel" class="form-control numeric" id="phone" name="phone" placeholder="Mobile Number" value="<?php if(isset($search_condition['cell_phone']) && $search_condition['cell_phone']!=''){echo $search_condition['cell_phone'];}?>" maxlength="10" >       
	    </div></div></div>
    

    
    <div class="col-md-4 form-group">
	<div class="form-group">
	    <label for="city" <?php if(isset($search_condition['city']) && $search_condition['city']!=''){echo 'class="SearchText"';}?> ><?php echo get_phrase('city'); ?></label>
	    <div class="input-group">
		<div class="input-group-addon"><i class="fa fa-globe"></i></div>
	    <input type="text" class="form-control" id="city" name="city" placeholder="Current City" value="<?php if(isset($search_condition['city']) && $search_condition['city']!=''){echo $search_condition['city'];}?>" >       
	    </div></div></div>

    
</div>

<div class="row">
    
    <div class="col-md-4 form-group">
	<div class="form-group">
	    <label for="state" <?php if(isset($search_condition['state']) && $search_condition['state']!=''){echo 'class="SearchText"';}?> ><?php echo get_phrase('state'); ?></label>
	    <div class="input-group">
		<div class="input-group-addon"><i class="fa fa-globe"></i></div>
	    <input type="text" class="form-control" id="state" name="state" placeholder="Current State" value="<?php if(isset($search_condition['state']) && $search_condition['state']!=''){echo $search_condition['state'];}?>" >
	    </div></div></div>

    <div class="col-md-4 form-group">
	<div class="form-group">
	    <label for="state" <?php if(isset($search_condition['country']) && $search_condition['country']!=''){echo 'class="SearchText"';}?> ><?php echo get_phrase('country'); ?></label>
	    <div class="input-group">
		<div class="input-group-addon"><i class="fa fa-globe"></i></div>
	    <input type="text" class="form-control" id="country" name= "country" placeholder="Country" value="<?php if(isset($search_condition['city']) && $search_condition['country']!=''){echo $search_condition['country'];}?>" > 
	    </div></div></div>

    
</div>

	<div class="text-right col-xs-12 p-t-20">
	<button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d">Submit</button>
	</div>

	</div>


<div class="row" data-step="6" data-intro="<?php echo get_phrase('Here you can view the list the parents.');?>" data-position='top'>
     <div class="col-sm-12">    
        <div class="white-box" > 
<table id="example23" class="display nowrap" cellspacing="0" width="100%">
    <thead>
        <tr>
                            <th>#</th>
                            <th><?php echo get_phrase('student_enroll_code'); ?></th>
                            <th><?php echo get_phrase('parent_name'); ?></th>
                            <th><?php echo get_phrase('profession'); ?></th>            
                            <th><?php echo get_phrase('phone'); ?></th>
                            <th><?php echo get_phrase('email'); ?>></th>
                            <th><?php echo get_phrase('status'); ?></th>
                            <th><?php echo get_phrase('options'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count = 1;
                        foreach ($parent_all as $row): 
                            ?>
                        <tr>
                            <td><?php echo $count++; ?></td>
                            <td><?php echo $row['enroll_code'];?></td>
                            <td><?php echo "Mr. ".$row['father_name']. " " . $row['father_mname'] . " " . $row['father_lname'] ; ?></td>
                            <td><?php echo $row['father_profession']; ?></td>
                            <td><?php echo $row['cell_phone']; ?></td>
                            <td><?php echo $row['parent_email']; ?></td>
                            <td><?php echo ($row['isActive']==1) ? 'Active' : 'Deleted'; ?></td>
                            <td>

                               <div class="btn-group">
                                        <button type="button" data-toggle="dropdown" class="btn btn-default btn-outline dropdown-toggle waves-effect waves-light">
                                            <?php echo get_phrase('View_Details '); ?> <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-default pull-right pos-static" role="menu">

                                            <!-- STUDENT AVERAGE LINK -->
                                            <li>
                                                <a  href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_parent_view/<?php echo $row['parent_id']; ?>');" >
                                                    <i class="fa fa-area-chart"></i>
                                                    <?php echo get_phrase('view'); ?>
                                                </a>
                                            </li>
                                            <!-- STUDENT Documents LINK -->
                                            <li>
                                                <a href="<?php echo base_url(); ?>index.php?school_admin/regenerate_passcode_parent/<?php echo $row['parent_id']; ?>">
                                                    <i class="fa fa-folder-open-o"></i>
                                                    <?php echo get_phrase('regenerate_passcode'); ?>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>

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
                      columns: [ 1, 2,3,4, 5 ,6 ]
                }
            },
            {
                extend: 'pdf',
                exportOptions: {
                    columns: [ 1, 2,3,4, 5 ,6 ]
                }
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: [ 1, 2,3,4, 5,6 ]
                }
            },
        ]
       
    } );
     
} );




</script>
