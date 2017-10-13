<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('manage_parent_teacher_meeting'); ?></h4>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        
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
        </ol>
    </div>
</div>

<input type="hidden" id='selected_class' value="<?php echo $class_id ?>">
<input type="hidden" id='selected_section' value="<?php echo $section_id ?>">
<input type="hidden" id='selected_exam' value="<?php echo $exam_id ?>">

<div class="col-md-12 white-box" data-step="5" data-intro="<?php echo get_phrase('From here you can class, selection and exam.');?>" data-position='top'>
    <div class="col-sm-4 form-group">  
        <?php echo form_open(base_url() . 'index.php?teacher/set_ptm_time', array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data', 'id' => 'setPtmform', 'method' => 'POST')); ?>
        <label for="field-1"><?php echo get_phrase('Select_Class');?><span class="error mandatory"> *</span></label>             
        <select name="class_name" id = "class_id" class="selectpicker" data-style="form-control" data-live-search="true" onchange="return get_class_sections_by_teacher(<?php echo $this->session->userdata('teacher_id');?>)" data-validate="required" data-message-required ="Please select a class" >                            
            <option value=" "><?php echo get_phrase('select_class'); ?></option>
            <?php                
            foreach ($classes as $row):
             $selected='';
            if($row['class_id']==$class_id ){
                $selected="selected";
            }
            ?>

            <option value="<?php echo $row['class_id']; ?>"<?php echo $selected; ?>><?php echo $row['class']; ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="col-sm-4 form-group">            
        <label for='field-1'><?php echo get_phrase('select_section'); ?><span class="error mandatory"> *</span></label>
        <select name="section_id" class="form-control" data-style="form-control" data-live-search="true" id="section_selector_holder" data-validate="required" data-message-required ="Please select a section" onchange="return get_examList(this.value);">
            <option value=""><?php echo get_phrase('select_section'); ?></option>
            <?php 
//                $selected               =   '';
                foreach($sections as $values) {
                $selected              =   ($section_id == $values['section_id'] ? 'selected' : '' ); ?>
                <option <?php echo $selected ?> value="<?php echo $values['section_id']; ?>"><?php echo $values['name']; ?></option>
            <?php  } ?>
        </select>           
    </div>
    
    
    <div class="col-sm-4 form-group">            
        <label for='field-1'><?php echo get_phrase('select_exam'); ?><span class="error mandatory"> *</span></label>
        <select name="exam_holder" class="form-control" data-style="form-control" data-live-search="true"  id="exam_holder" data-validate="required" data-message-required ="Please select an exam">
            <option value=""><?php echo get_phrase('select_exam'); ?></option>
            <?php 
            foreach ($exam as $row):
             $selected='';
            if($row['exam_id']==$exam_id ){
                $selected="selected";
            }?>
            <option value="<?php echo $row['exam_id']; ?>"<?php echo $selected; ?>><?php echo $row['name']; ?></option>
            <?php endforeach; ?>
        </select>           
    </div> 
    
    
    <div class="text-right col-xs-12">     
        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" id="view_list" name="view_details1" value="view_details" data-step="6" data-intro="<?php echo get_phrase('After your click on this button, you will get a list.');?>" data-position='left'><?php echo get_phrase('view_students'); ?></button>
    </div>
       <?php echo form_close(); ?>
</div>

    <?php if (!empty($student_details)) {?>
    <?php if(!empty($exam_id)){?>
    <div class="col-sm-12 white-box" data-step="7" data-intro="<?php echo get_phrase('This is the list that is showing list of PTM.');?>" data-position='top'> 
    <h4 class="text-center m-b-20"><?php echo "<b>".get_phrase('exam_name')."</b>"." : ". $exam_name." - "."<b>".get_phrase('meeting_date')."</b>"." : ". $date;?></h4>
        <table id="table" class="table display" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th width="50"><div><?php echo get_phrase('no'); ?></div></th>  
                    <th><div><?php echo get_phrase('student_name'); ?></div></th>
                    <th><div><?php echo get_phrase('class/section'); ?></div></th>                          
                    <th><div><?php echo get_phrase('set_time'); ?></div></th>
                    <th data-step="8" data-intro="<?php echo get_phrase('Here is a Action to Edit and Save.');?>" data-position='top'><div><?php echo get_phrase('action'); ?></div></th>
                    <th data-step="9" data-intro="<?php echo get_phrase('Here you can see status like Already Sent or Not Sent.');?>" data-position='left'><div><?php echo get_phrase('status'); ?></div></th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
    </div>
    <?php } 
//    else { ?>
<!--        <table cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th><div></div></th> 
                <tr>
            </thead>
            <tbody>
                <tr>
                    <td><div><label><?php echo get_phrase('Admin has not assigned PTM date for this class for this exam!!'); ?></label></div></td>
                </tr>
            </tbody>
        </table>-->
    <?php // } ?>
    
    <?php } ?>
    
   

<script>
  function get_class_sections_by_teacher(teacher_id) {
        var class_id = $('#class_id').val(); 
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?ajax_controller/get_class_sections_by_teachers/' + teacher_id +'/'+class_id,
            success: function (response) {
                jQuery('#section_selector_holder').html(response).selectpicker('refresh');
            }     
        });
    }
    
    $( document ).ready(function() {
    triggerTimePicker();
        $(".time-pick-edit").click(function() {
            $(this).addClass("clockpicker");
            triggerTimePicker($(this).val());
        });
    });
    
    function triggerTimePicker(def_val) {
        
        if(def_val) 
            var default_value   =   def_val;
        else 
            var default_value   =   '08.00';
        $('.clockpicker').clockpicker({
        donetext: 'Done',
    }).find('input.clockpicker').change(function() {
        console.log(this.value);
    });
//    $('.timepicker').timepicker({
//        timeFormat: 'h:mm p',
//        interval: 15,
//        minTime: '6',
//        maxTime: '6:00pm',
//        defaultTime: default_value,
//        startTime: '6:00',
//        dynamic: false,
//        dropdown: true,
//        scrollbar: true
//    });
    }
    function get_examList(section_id) {
        var class_id = $('#class_id').val(); 
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?ajax_controller/get_exams/' + section_id +'/'+class_id,
            success: function (response) {
                jQuery('#exam_holder').html(response).selectpicker('refresh');
            }     
        });
    }
    
</script>

<script>
    
    
    function save_time(studentId,action){   
        var time = $("#std_id"+studentId).val(); 
        var exam_id = $("#exam_id").val();
        if(action == 10) { 
            var action_url  =   '<?php echo base_url(); ?>index.php?teacher/set_ptm_time/edit_time/' + studentId +'/' + exam_id;
        } else { //alert("hereeee");
            var action_url  =   '<?php echo base_url(); ?>index.php?teacher/set_ptm_time/save_time/' + studentId +'/' + exam_id;
        }
                    $.ajax({
                        method      : "POST",
                        dataType    :   "json", 
                            url     :   action_url, 
                        data: {time:time,studentId:studentId, exam_id:exam_id},
                        success: function (response)
                        {    
                            if(response.status == "success") {
                                $("#std_id"+studentId).prop('disabled', true); 
                                $("#status"+studentId).css({"background-color":"green","color":"white"});                    
                                $("#status"+studentId).html("");
                                $("#save_time"+studentId).prop('disabled', true);
                                window.location = window.location;
                                //toastr.success('time set');
                            } else {
                                window.location = window.location;
                            }
                        },
                        error: function(response){
                            toastr.error('time not set');
                        }
                    });
            
        }
    
</script>    

<script type='text/javascript'> 
  
       var class_id = $("#selected_class").val();
       var section_id = $("#selected_section").val();
       var exam_id = $("#selected_exam").val();

    var table;
    $(document).ready(function() {
        table = $('#table').DataTable({ 
            "dom": 'Bfrtip',
            "responsive": true,
            "buttons": [
                "pageLength",
                'copy', 'excel', 'pdf', 'print'
            ],

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
           
            "ajax": {
                "url": "<?php echo base_url(); ?>index.php?ajax_controller/set_ptm_time_list/",
                "type": "POST",
                data : { class_id:class_id,section_id:section_id, exam_id:exam_id },
                "dataSrc": function (data) {
                    setTimeout(function () {
                        $('[data-toggle="tooltip"]').tooltip();
                    }, 0);
                    return data.data;
            }
            },

            //Set column definition initialisation properties.
            "columnDefs": [
                { "targets": [0,4,5], "orderable": false },                 
            ],

        });
    }); 
</script>

<style>
    .par-accepted {
        color: #FFF;
        background: green;

    }
    .par-accepted:hover { 
        color: #FFF !important;
        background: green !important;
        /*text-decoration: none;*/
    }
</style>