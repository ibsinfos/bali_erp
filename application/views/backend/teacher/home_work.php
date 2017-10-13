    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
            <a href="javascript: void(0);"  onclick="javascript:introJs().start();" id="take-tour"  class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>

<?php if($this->uri->segment(2)=='update_homework'){?>
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url(); ?>index.php?teacher/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
                <li><a href="<?php echo base_url(); ?>index.php?teacher/home_works"><?php echo get_phrase('Home Works'); ?></a></li>
                <li class="active"><?php echo get_phrase('update_homework'); ?></li>
            </ol>
<?php }else{?>            
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url(); ?>index.php?teacher/dashboard"><?php echo get_phrase('dashboard'); ?></a></li>

    <?php $BRC = get_bread_crumb(); if (strpos($BRC, '^') !== false) { $ExpBrd = explode('^', $BRC);?>
                <li>
                    <?php echo get_phrase(@$ExpBrd[0]); ?>
                    <?php echo @$ExpBrd[1]; ?>
                </li> <?php }else{ $ExpBrd[2] = $BRC;}?>
                <li class="active">
                    <?php echo get_phrase(@$ExpBrd[2]); ?>
                </li>
            </ol> <?php }?>
        </div>
    </div>
           
  
     <?php
     $msg=$this->session->flashdata('flash_message_error');
     if ($msg) { ?>        
        <div class="alert alert-danger">
            <?php echo $msg; ?>
        </div>
    <?php } 
    
    if(!isset($sel_class_id))
        $sel_class_id = '';
    if(!isset($sel_section_id))
        $sel_section_id = '';
    if(!isset($sel_subject_id))
        $sel_subject_id = '';
    ?>
        <div class="col-md-12">
            <div class="white-box">
                <div class="row">

                    <div class="form-group col-md-4">
                        <label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('select_class');?></label>
                        <select id="class_holder" name="class_id" data-style="form-control" data-live-search="true" class="selectpicker" onchange="return onclasschange(this);">
                            <option value="">Select Class</option>
                            <?php foreach ($classes as $row): ?>
                            <option  value="<?php echo $row['class_id']; ?>" <?php if($sel_class_id == $row['class_id']) echo "selected";?>>
                            <?php echo get_phrase('class'); ?>&nbsp;<?php echo $row['class_name']; ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group col-md-4" style="padding: 10">
                        <label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('select_section');?></label>
                        <select id="section_holder" name="section_id" data-style="form-control" data-live-search="true" class="selectpicker" onchange="onsectionchange(this.value);">
                            <option value="">Select Section</option>
                                <?php foreach ($section_list as $sec): ?>
                                    <option  value="<?php echo $sec['section_id']; ?>" <?php if($sel_section_id == $sec['section_id']) echo "selected";?>>
                                    <?php echo get_phrase('section'); ?>&nbsp;<?php echo $sec['name']; ?>
                                    </option>
                                <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-xs-12 col-md-4">
                        <div class="form-group">
                        <label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('subject');?></label>
                            <select id="subject_holder" name="subject_id" data-style="form-control" data-live-search="true" class="selectpicker">
                              <option value="">Select subject</option>
                              <?php foreach ($subject_list as $sub): ?>
                                    <option  value="<?php echo $sub['section_id']; ?>" <?php if($sel_subject_id == $sub['subject_id']) echo "selected";?>>
                                    <?php echo get_phrase('subject'); ?>&nbsp;<?php echo $sub['name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                </div>
        </div>
    </div>
<?php

    if(!empty($sel_class_id) && (!empty($sel_section_id)))
    {
        ?>
         
    <div class="col-md-12">
        <div class="white-box">        
            <section>
                <div class="sttabs tabs-style-flip">
                    <nav>
                        <ul>
                            <li id="section1">
                                <a href="#section-flip-1" class="sticon fa fa-list "data-step="5" data-intro="You can see list of home work you created." data-position='right'><span><?php echo get_phrase('home_work_types'); ?></span></a></li>
                            <li id="section2">
                                <a href="#section-flip-2" class="sticon fa fa-plus" data-step="6" data-intro="Form here you will add a home work." data-position='left'><span><?php echo get_phrase('add_home_work'); ?></span></a></li>
                           <li id="section3">
                                <a href="#section-flip-3" class="sticon fa fa-list" data-step="7" data-intro="Form here you will add a home work." data-position='left'><span><?php echo get_phrase('home_work_done'); ?></span></a></li>

                        </ul>
                    </nav>                                    
                    <div class="content-wrap">
                        <section id="section-flip-1">

                        <table id="example23" class="table display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th><div><?php echo get_phrase('no'); ?></div></th>
                                    <th><div><?php echo get_phrase('name'); ?></div></th>
                                    <th><div><?php echo get_phrase('start_date'); ?></div></th>
                                    <th><div><?php echo get_phrase('end_date'); ?></div></th>
                                    <th><div><?php echo get_phrase('options'); ?></div></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                if(!empty($teacher_home_works)) {
                                    $count  =   1;
                                    foreach($teacher_home_works as $key=>$row) { ?>
                                    <tr>
                                        <td><?php echo $count++; ?></td>
                                        <td><?php echo $row['hw_name'];?></td>
                                        <td><?php echo $row['start_date'];?></td>
                                        <td><?php echo $row['end_date'];?></td>
                                        <td>
                                            <a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/modal_view_hw_details/<?php echo $row['home_work_id']; ?>');">
                                                <button class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="View"><i class="fa fa-eye"></i></button>
                                            </a>
                                                
                                            <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>index.php?teacher/home_works/<?php echo $sel_class_id ;?>/<?php echo $sel_section_id ;?>/<?php echo $sel_subject_id ;?>/<?php echo $row['home_work_id']; ?>');">
                                                <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-trash"></i></button>
                                            </a>
                                        </td>
                                    </tr>
                                <?php    
                                    }
                                } else { ?>


                               <?php  }
                               ?>
                            </tbody>
                        </table>

                        </section>

                        <section id="section-flip-2">
                            <?php echo form_open(base_url() . 'index.php?teacher/home_works_actions/create', array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top', "onsubmit" => "return validate_form()")); ?>
                            <div class="row">          
                                <div class="col-xs-12 col-md-offset-3 col-md-6">
                                    <label for="field-1"><?php echo get_phrase('home_work_type'); ?><span class="mandatory"> *</span></label>
                                    <div class="input-group">
                                        <input type="hidden" name="hw_class_id" value="<?php echo $sel_class_id;?>" >
                                        <input type="hidden" name="hw_section_id" value="<?php echo $sel_section_id;?>" >
                                        <input type="hidden" name="hw_subject_id" value="<?php echo $sel_subject_id;?>" >
                                        <div class="input-group-addon"><i class="fa fa-cutlery"></i></div>
                                        <select id="homework_type" name="homework_type" data-style="form-control" data-live-search="true" class="selectpicker">
                                            <option value="">Select type</option>
                                            <?php foreach($homework_types as $hw_types) { ?>
                                            <option value="<?php echo $hw_types['homework_typeid'];?>"><?php echo $hw_types['type_name'];?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                     <label class="mandatory"> <?php echo form_error('name'); ?></label>
                                </div> 
                            </div>
                            <div class="row">          
                                <div class="col-xs-12 col-md-offset-3 col-md-6">
                                    <label for="field-1"><?php echo get_phrase('home_work_name'); ?><span class="mandatory"> *</span></label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-cutlery"></i></div>
                                        <input type="text" class="form-control"  data-validate="required"  name="name" id='name' placeholder="<?php echo get_phrase('name'); ?>"> 
                                    </div>
                                     <label class="mandatory"> <?php echo form_error('name'); ?></label>
                                </div> 
                            </div>
                            <div class="row">          
                                <div class="col-xs-12 col-md-offset-3 col-md-6">
                                    <label for="field-1"><?php echo get_phrase('start_date'); ?><span class="mandatory"> *</span></label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-cutlery"></i></div>
                                        <input type="text" class="form-control mydatepicker"  data-validate="required"  name="start_date" id ='start_date' > 
                                    </div>
                                     <label class="mandatory"> <?php echo form_error('start_date'); ?></label>
                                </div> 
                            </div>
                            <div class="row">          
                                <div class="col-xs-12 col-md-offset-3 col-md-6">
                                    <label for="field-1"><?php echo get_phrase('end_date'); ?><span class="mandatory"> *</span></label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-cutlery"></i></div>
                                        <input type="text" class="form-control mydatepicker"  data-validate="required"  name="end_date" id ='end_date'> 
                                    </div>
                                     <label class="mandatory"> <?php echo form_error('end_date'); ?></label>
                                </div> 
                            </div>
                            <div class="row">          
                                <div class="col-xs-12 col-md-offset-3 col-md-6">
                                    <label for="field-1"><?php echo get_phrase('duration'); ?>
                                        (<?php echo get_phrase('minutes'); ?>)<span class="mandatory"> *</span></label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-cutlery"></i></div>
                                        <input type="tel"   data-validate="required" id ='duration'  name="duration" > 
                                    </div>
                                     <label class="mandatory"> <?php echo form_error('duration'); ?></label>
                                </div> 
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-md-offset-3 col-md-6">
                                    <label for="poll_content">
                                    <?php echo get_phrase('home_work_description'); ?>:<span class="error mandatory"> *</span></label>
                                    <textarea class='summernote'  name="hw_description" id="hw_description"></textarea>
                                    <label> <?php echo form_error('description'); ?></label>
                                </div>
                            </div>
                            
                            <div class="text-right">
                                <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('submit'); ?></button>
                            </div>
                            <?php echo form_close(); ?> 
                        </section>             
           
            <section id="section-flip-3">

                        <table id="example23" class="table display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th><div><?php echo get_phrase('no'); ?></div></th>
                                    <th><div><?php echo get_phrase('student_name'); ?></div></th>
                                    <th><div><?php echo get_phrase('homework_name'); ?></div></th>
                                    <th><div><?php echo get_phrase('start_date'); ?></div></th>
                                    <th><div><?php echo get_phrase('end_date'); ?></div></th>
                                     <th><div><?php echo get_phrase('submitted_on'); ?></div></th>
                                      <th><div><?php echo get_phrase('marks_given'); ?></div></th>
                                    <th><div><?php echo get_phrase('options'); ?></div></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                               
                                if(!empty($homework_done)) {
                                    $count  =   1;
                                    foreach($homework_done as $key=>$row) { ?>
                                    <tr>
                                        <td><?php echo $count++; ?></td>
                                        <td><?php echo $row['homework'];?></td>
                                        <td><?php echo $row['name']. " ".$row['lname'];?></td>
                                        <td><?php echo $row['start_date'];?></td>
                                        <td><?php echo $row['end_date'];?></td>
                                        <td><?php echo $row['updated_date'];?></td>
                                         <td><?php  if(empty($row['marks']))
                                                        echo get_phrase("assign_marks");
                                                     else
                                                         echo get_phrase("marks_assigned");
                                         
                                         
                                         ?></td>
                                        <td>
                                            <a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/modal_view_hw_details_submitted/<?php echo $row['home_work_id']; ?>');">
                                                <button class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="View"><i class="fa fa-eye"></i></button>
                                            </a>
                                                
                                            <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>index.php?school_admin/home_works/delete/<?php echo $row['home_work_id']; ?>');">
                                                <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-trash"></i></button>
                                            </a>
                                        </td>
                                    </tr>
                                <?php    
                                    }
                                } else { ?>


                               <?php  }
                               ?>
                            </tbody>
                        </table>
                 </section>

                       
        </div>
    </div>
            </section>
 <?php
    }
    ?>
<script>
    $(document).ready(function(){

    });
    
    function onclasschange(class_id){
        jQuery('#section_holder').html('<option value="">Select Section</option>');
        $.ajax({
            url: '<?php echo base_url();?>index.php?teacher/get_teacher_section/' + class_id.value,
            success: function (response)
            {
                jQuery('#section_holder').append(response).selectpicker('refresh');
            }
        });
        $('#section_holder').trigger("chosen:updated");
    }
    
    function onsectionchange(section_id){
        jQuery('#subject_holder').html('<option value="">Select Subject</option>');
        $.ajax({
            url: '<?php echo base_url();?>/index.php?teacher/get_teacher_subject/' + section_id,
            success: function (response){
                jQuery('#subject_holder').append(response).selectpicker('refresh');
            }
        });
        $('#subject_holder').trigger("chosen:updated");
    }
    
    jQuery("#subject_holder").change(function () {
        var section=$("#section_holder option:selected").val();
        var subject=$("#subject_holder option:selected").val();
        var classname=$("#class_holder option:selected").val();
        location.href = "<?php echo base_url(); ?>index.php?teacher/home_works/"+classname+"/"+section+"/"+subject;
    });
</script>
<script type="text/javascript">
    
    function validate_form()
    {
        
        var obj1 = document.getElementById('homework_type');
        var name = document.getElementById('name');
        var start_date = document.getElementById('start_date'); 
        var end_date = document.getElementById('end_date');
        var duration = document.getElementById('duration');
       var description = document.getElementById('hw_description');   
        if(obj1.value == "")
        {
            alert("select homework_type");
            obj1.focus();
            return false;
        }
        if(name.value == "")
        {
            alert("Enter Name");
            name.focus();
            return false;
        } 
        if(start_date.value == "")
        {
            alert("Enter Start Date");
            start_date.focus();
            return false;
        } 
        if(end_date.value == "")
        {
            alert("Enter End date");
            end_date.focus();
            return false;
        } 
        if(duration.value == "")
        {
            alert("Enter Duration");
            duration.focus();
            return false;
        }
        
        if(description.value == '<p><br></p>')
        {
            alert("Enter Description");
            description.focus();
            return false;
        }
        
        return true;
        
        
    }
    function trimAll(sString)
{
    while (sString.substring(0,1) == ' ')
    {
        sString = sString.substring(1, sString.length);
    }
    while (sString.substring(sString.length-1, sString.length) == ' ')
    {
        sString = sString.substring(0,sString.length-1);
    }
return sString;
}

</script>