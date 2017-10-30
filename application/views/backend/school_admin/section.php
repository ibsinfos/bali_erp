<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('manage_sections'); ?> </h4></div>  
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);"   onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>

<?php $BRC = get_bread_crumb(); if (strpos($BRC, '^') !== false) { $ExpBrd = explode('^', $BRC);?>
            <li>
                <?php echo get_phrase(@$ExpBrd[0]); ?>
                <?php echo @$ExpBrd[1]; ?>
            </li> <?php }else{ $ExpBrd[2] = $BRC;}?>
            <li class="active">
                <?php echo get_phrase(@$ExpBrd[2]); ?>
            </li>
        </ol>
    </div>
</div>

   <?php if ($this->session->flashdata('flash_message_error')) { ?>        
                <div class="alert alert-danger">
                    <?php echo $this->session->flashdata('flash_message_error'); ?>
                </div>
            <?php } ?>
<div class="row visible-xs">
<div class="col-xs-12 m-b-10 ">      
       <a  href="javascript: void(0);" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/section_add/');"  class="btn btn-primary btn-circle btn-lg pull-right tooltip-danger" data-step="6" data-intro="<?php echo get_phrase('By clicking here, you will be get a form for add section.');?>" data-position='left' data-toggle="tooltip" data-placement="left" title="" data-original-title="Add New Section"> 
	   <i class="fa fa-plus"></i>
       </a>        
</div>
</div>
<div class="row">
    <div class="col-md-12">
    <div class="col-md-6 form-group no-padding"  data-step="5" data-intro="<?php echo get_phrase('Select a class, for which you want to see the sections.');?>" data-position='right'>
	
            <label class="control-label">Select Class</label>
            <select class="selectpicker" data-style="form-control" data-live-search="true" onchange="window.location = this.options[this.selectedIndex].value">
                <option value="">Select Class</option>                       
                <?php 
                        foreach ($classes as $row):?>
                        <option <?php if ($class_id == $row['class_id']) { echo 'selected';} ?> value="<?php echo base_url(); ?>index.php?school_admin/section/<?php echo $row['class_id']; ?>">
                        <?php echo get_phrase('class').' '.$row['name']; ?> 
                        </option>
                    <?php endforeach; ?>
            </select>
             
    </div>         
    
    
    <div class="m-b-20 hidden-xs">      
       <a  href="javascript: void(0);" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/section_add/');"  class="btn btn-primary btn-circle btn-lg pull-right tooltip-danger" data-step="6" data-intro="<?php echo get_phrase('By_clicking_here,_you_will_get_a_form_for_add_section.');?>" data-position='left' data-toggle="tooltip" data-placement="left" title="" data-original-title="Add New Section"> 
	   <i class="fa fa-plus"></i>
       </a>        
   </div>
    </div>
</div>

<div class="row">
<div class="col-md-4">
<div class="badge badge-danger p-10 m-b-20 badge-stu-name " data-step="7" data-intro="<?php echo get_phrase('Here_you_can_see_the_information_of_maximum_seats_and_students_allotted.');?>" data-position='top'>

        <?php if(!empty($capacity)){?>
        <?php echo get_phrase('maximum_seats:_'). '<span class="p-r-20">' . $capacity .'</span>'  ; ?>
        <?php } else { ?>
        <?php echo get_phrase('Maximum_seats_not_mentioned '). '</br>'; ?>
    
        <?php } ?> 
        <?php if(!empty($student_alloted)){?>
        <?php echo get_phrase('students_alloted:_'). '<span>' .$student_alloted.'</span>' ; ?>
        <?php } else { ?>
        <?php echo get_phrase('no_students_alloted!!'); ?>
        <?php } ?>


</div>
</div>
</div>
   <div class="col-md-12 white-box" > 
        <div class="text-center m-b-20" data-step="8" data-intro="<?php echo get_phrase('Here_you_can_see_the_list_of_section.');?>" data-position='top'>
             <h3><?php echo get_phrase('section_details_of_class_'.$class_name);?></h3>
        </div>
<table class= "custom_table table display" cellspacing="0" width="100%" id="example23">
    <thead>
        <tr>
            <th><div>No.</div></th>
            <th><div><?php echo get_phrase('section_name'); ?></div></th>                                
            <th><div><?php echo get_phrase('teacher'); ?></div></th>
            <th><div><?php echo get_phrase('description'); ?></div></th>
            <th><div><?php echo get_phrase('room_no'); ?></div></th>
            <th><div><?php echo get_phrase('maximum_capacity'); ?></div></th>
            <th><div><?php echo get_phrase('no._students_alloted'); ?></div></th>
            <th data-step="9" data-intro="<?php echo get_phrase('Here_you_can_see_the_options_like_edit_and_delete.');?>" data-position='left'><div><?php echo get_phrase('action'); ?></div></th>                                
        </tr>
    </thead>
    <tbody>
    <?php $count = 1; foreach ($sections as $row):  ?>
        <tr>
            <td><?php echo $count++; ?></td>
            <td><?php echo $row['name']; ?></td>                                    
            <td><?php echo $row['teacher_name'] ." ". ($row['middle_name']!=''?$row['middle_name']:'') ." ". $row['last_name']; ?></td>
            <td><?php echo $row['nick_name']; ?></td>
            <td><?php echo $row['room_no']; ?></td>
            <td><?php echo $row['max_capacity']; ?></td>
            <td><?php echo $row['count']; ?></td>
            <td>
                <div class="btn-group">
                <a href="javascript: void(0);" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/section_edit/<?php echo $row['section_id']; ?>');">
                <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" 
                   data-placement="top" data-original-title="<?php echo get_phrase('edit_section'); ?>" >
                    <i class="fa fa-pencil-square-o"></i>
                </button>
                </a>
                <?php if($row['transaction'] == 0) {?>
                    <a href="javascript: void(0);" onclick="confirm_modal('<?php echo base_url(); ?>index.php?school_admin/sections/delete/<?php echo $row['section_id'].'/'.$class_id; ?>');">
                    <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" 
                      data-placement="top" data-original-title="<?php echo get_phrase('delete') ?>">
                       <i class="fa fa-trash-o"></i>
                    </button>
                    </a>
                <?php } else {?> 
                    <a href="javascript: void(0);" onclick="confirm_modal('<?php echo base_url(); ?>index.php?school_admin/sections/delete/<?php echo $row['section_id'].'/'.$class_id; ?>');">
                    <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 disabled" >
                       <i class="fa fa-trash-o"></i>
                    </button>
                    </a>
                <?php } ?>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>



        
