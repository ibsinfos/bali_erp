<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('manage_daily_attendance'); ?> </h4></div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php?school_admin/dashboard');?>"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active"><?php echo get_phrase('daily_attendance_report'); ?></li>
        </ol>
    </div>
</div>

<div class="col-md-12 white-box">
    <?php echo form_open(base_url('index.php?teacher/subjectwise_attendance')); ?>
    <div class="row">
        <div class="col-sm-3 form-group" data-step="5" data-intro="<?php echo get_phrase('Select a Class from here!');?>" data-position='top'>
            <label for="field-1"><?php echo get_phrase('Select_Class');?><span class="error mandatory"> *</span></label>
            <select class="selectpicker" data-style="form-control" name="class_id" id="class_id" data-live-search="true" 
                onchange="get_class_sections_by_teacher(<?php echo $this->session->userdata('teacher_id');?>);">
                <option value=""><?php echo get_phrase('select_class'); ?></option>
                <?php foreach($classes as $cls){?>
                    <option value="<?php echo $cls->class_id;?>" <?php echo $cls->class_id==$class_id?'selected':''?>>
                        <?php echo get_phrase('class').' '.$cls->name;?>
                    </option>
                <?php };?>
            </select> 
            <label class="mandatory"> <?php echo form_error('class_id'); ?></label>
        </div>    

        <div class="col-sm-3 form-group" data-step="6" data-intro="<?php echo get_phrase('Select a section from here!');?>" data-position='top'>
            <label for="field-1"><?php echo get_phrase('select_section');?><span class="error mandatory"> *</span></label>       
            <select name="section_id" data-style="form-control" data-live-search="true" class="selectpicker" id="section_selector_holder"
                onchange="get_class_subjects_by_teachers(<?php echo $this->session->userdata('teacher_id');?>);">
                <option value=""><?php echo get_phrase('select_section'); ?></option>
                
                <?php foreach($sections as $sec){?>
                    <option value="<?php echo $sec->section_id;?>" <?php echo $sec->section_id==$section_id?'selected':''?>><?php echo get_phrase('section').' '.$sec->name;?></option>
                <?php };?>
            </select> 
            <label class="mandatory"> <?php echo form_error('section_id'); ?></label>
        </div>

        <div class="col-sm-3 form-group" data-step="6" data-intro="<?php echo get_phrase('Select a section from here!');?>" data-position='top'>
            <label for="field-1"><?php echo get_phrase('select_subject');?><span class="error mandatory"> *</span></label>       
            <select name="subject_id" class="selectpicker" data-style="form-control" data-live-search="true" id="subject_holder">
                <option value=""><?php echo get_phrase('select_subject');?></option>
                <?php foreach($subjects as $sub){?>
                    <option value="<?php echo $sub->subject_id?>" <?php echo $sub->subject_id==$subject_id?'selected':''?>><?php echo $sub->name?></option>    
                <?php }?>
            </select> 
            <label class="mandatory"><?php echo form_error('subject_id'); ?></label>
        </div>
        
        <div class="col-sm-3 form-group" data-step="7" data-intro="<?php echo get_phrase('Select a section from here!');?>" data-position='top'>               
            <label for="field-1"><?php echo get_phrase('select_date');?><span class="error mandatory"> *</span></label>
            <div class="input-group">
                <span class="input-group-addon"><i class="icon-calender"></i></span>
            <input type="text" id="mydatepicker_holiday_disable" class="form-control" name="date" value="<?php echo date('m/d/Y',strtotime($date))?>" 
            placeholder="<?php echo get_phrase('select_date');?>">             
            </div>  
            <label class="mandatory"> <?php echo form_error('timestamp'); ?></label>
        </div>      
    </div>                
    
    <div class="row">    
        <input type="hidden" name="year" value="<?php //echo $running_year; ?>">
        <div class="col-xs-12">
            <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" data-step="8" 
            data-intro="<?php echo get_phrase('On the click on button, you will get list of attendance!');?>" 
            data-position='top'><?php echo get_phrase('MANAGE_ATTENDANCE'); ?></button>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
<div class="col-md-12 white-box" data-step="9" data-intro="<?php echo get_phrase('Shows the student details!!');?>" data-position='top'>
    <div class="text-center">
        <h3><?php echo get_phrase('subject_attendance_for_class').' '.$class_name.'-'.get_phrase('section').' '.$section_name.' on '.date("d M Y", strtotime($date));?></h3>
    </div>
    
    <div class="row mt10 mb20">
        <div class="col-md-3 pull-right">            
            <input type="text" class="form-control rfid-attn" placeholder="RFID">
        </div>
    </div>

    <?php echo form_open(base_url('index.php?teacher/subjectwise_attendance_update/'.$class_id.'/'.$section_id.'/'.$subject_id.'/'.$date)); ?>
    <div id="desktop-view">
        <table id="desk-table" class="display nowrap" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th><div><?php echo get_phrase('no:');?></div></th>
                    <th><div><?php echo get_phrase('roll_no');?></div></th>
                    <th><div><?php echo get_phrase('student');?></div></th>
                    <th><div><?php echo get_phrase('status');?></div></th>
                </tr>
            </thead>
            <tbody class="att-body">
                <?php $count = 1;
                foreach($attendance as $att): ?>
                    <tr>
                        <td><?php echo $count++;?>
                            <input type="hidden" class="at-row" data-rfid="<?php echo $att->card_id?>" data-stu-id="<?php echo $att->student_id?>" 
                            data-class-id="<?php echo $att->class_id?>" data-section-id="<?php echo $att->section_id?>" 
                            data-subject-id="<?php echo $subject_id?>" data-date="<?php echo date('Y-m-d',strtotime($date))?>"/>
                        </td>
                        <td><?php echo $att->roll;?></td>
                        <td><?php echo $att->name.' '.$att->lname; ?></td>  
                        <td>
                            <select class="selectpicker pos-static AtdStatus" data-style="form-control" name="atten[<?php echo $att->student_id?>]"
                                name="status_<?php echo $att->attendance_id;?>">
                                <option value="0" <?php echo $att->att_status == 3?'selected':'';?>><?php echo get_phrase('undefined'); ?></option>
                                <option value="1" <?php echo $att->att_status == 1 || $att->att_status == ''?'selected':'';?>><?php echo get_phrase('present'); ?></option>
                                <option value="2" <?php echo $att->att_status == 2?'selected':'';?>><?php echo get_phrase('absent'); ?></option>
                            </select>
                            <input type="hidden" name="has_atten[<?php echo $att->student_id?>]" value="<?php echo $att->attendance_id;?>">	
                        </td>
                    </tr>
                <?php endforeach;?>
            </tbody>
        </table>
        
        <div class="text-right col-xs-12 p-t-20 p-r-0">
            <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" ><?php echo get_phrase('UPDATE_ATTENDANCE'); ?></button>
        </div>
    </div>
    <?php echo form_close(); ?>

    <div id="mobile-view">
        <table id="mobile-table" class="display nowrap" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th class="text-center" style="width:30%;"><div><?php echo get_phrase('student');?></div></th>
                    <th class="text-center"><div><?php echo get_phrase('status');?></div></th>         
                </tr>
            </thead>
            <tbody class="att-body">
                <?php $count = 1;
                foreach($attendance as $att): ?>
                    <tr>
                        <td class="text-center"> 
                            <input type="hidden" class="at-row" data-rfid="<?php echo $att->card_id?>" data-stu-id="<?php echo $att->student_id?>"  
                                data-class-id="<?php echo $att->class_id?>" data-section-id="<?php echo $att->section_id?>" 
                                data-subject-id="<?php echo $subject_id?>" data-date="<?php echo date('Y-m-d',strtotime($date))?>" />     
                            <?php 
                            if($att->stud_image !='' && file_exists(BASEPATH.'../uploads/student_image/'.$att->stud_image)){
                                $image_url = base_url('uploads/student_image/'.$att->stud_image);
                            }else{
                                $image_url = base_url('uploads/user.png');
                            }?>
                            <img src="<?php echo $image_url?>" class="img-circle" style="width:30px;height:30px;"/>
                            <h5><?php echo $att->name.' '.$att->lname;?></h5>
                        </td>
                        <td class="text-center">
                            <input type="checkbox" value="1" name="att-switch" class="js-switch st-<?php echo $att->student_id?>" 
                            data-size="small" <?php echo $att->att_status==1 || $att->att_status==''?'checked':''?>/>
                        </td>
                    </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>
    
</div>
<?php 
$harr = array();
foreach($holidays as $key=>$holiday){
    $harr[] = date('m/d/Y',strtotime($holiday));
}
$hstring = implode("','",$harr);
$hstring = "'".$hstring."'";
?>
<script type="text/javascript">
function select_section(class_id) {
    $.ajax({
        url: '<?php echo base_url(); ?>index.php?Ajax_controller/get_sections_by_class/' + class_id,
        success: function (response) {
            jQuery('#section_holder').html(response).selectpicker('refresh');
        }
    });
}

function get_class_subjects_by_teachers(teacher_id) {        
    var class_id = $('#class_id').val(); 
    var section_id = $('select[name=section_id]').val();
    $.ajax({
        url: '<?php echo base_url('index.php?ajax_controller/get_class_subjects_by_teachers/');?>/'+teacher_id+'/'+class_id+'/'+section_id,
        success: function (response) {
            $('#subject_holder').html(response)
            $('.selectpicker').selectpicker('refresh');
        }     
    });
}

function adjView(type){
    $('#desk-table,#mobile-table').DataTable().destroy();
    if(window.innerWidth>700){
        $('#desktop-view').show();
        $('#mobile-view').hide();
    }else{
        $('#desktop-view').hide();
        $('#mobile-view').show();
    }
    
    $('#desk-table,#mobile-table').DataTable({
        dom: 'frtip',
        //responsive: true,
        paging: false,
        columnDefs: [{ orderable: false, targets:-1 }],
        order: [[ 0, 'asc' ]]
    });
}

$(document).ready(function () {
    $(window).on('resize',adjView);

    $('#desk-table,#mobile-table').on( 'draw.dt', function () {
        $('.selectpicker').selectpicker('refresh');
    });

    $('.rfid-attn').focus();
    $('.rfid-attn').bind('change', function(e) {
        var Box = $(this);
        dTable = (window.innerWidth>700)?$('#desk-table'):$('#mobile-table');
        var RFID = Box.val()!=''?parseInt(Box.val(), 10):false;
        if(RFID==false || RFID.length>15){
            swal('Error','<?php echo get_phrase('invalid_rfid_detail!')?>','error');    
            return false;
        }  

        AtRec = [];
        rowIndex = false;
        dTable.DataTable().rows().eq(0).each( function ( index ) {
            rowIndex = index;
            var row = dTable.DataTable().row( index );
            var data = row.data();
            rowHtml = $('<div/>');
            rowHtml.html(data[0]);
            if(AtRec.length==0){
                AtRec = rowHtml.find('.at-row[data-rfid='+RFID+']');
                AtRec.rowIndex = index;
                //console.log(AtRec.data('stu-id'),index,$($('#ex').dataTable().fnGetNodes()[rowIndex]));
            }
        });

        Box.val('');
        if (RFID !=false && AtRec.data('stu-id')!=undefined){
            $('body').loading('start');
            $.ajax({
                type:'POST',
                url:'<?php echo base_url('index.php?ajax_controller/update_student_subject_attendance')?>',
                data:{class_id:AtRec.data('class-id'),
                      section_id:AtRec.data('section-id'),
                      subject_id:AtRec.data('subject-id'),
                      date:AtRec.data('date'),
                      stu_id:AtRec.data('stu-id'),
                      status:1},
                dataType:'json',
                success:function(res){
                    $('body').loading('stop');
                    if(res.status=='success'){
                        tr = $(dTable.dataTable().fnGetNodes()[AtRec.rowIndex]);
                        tr.find('select').val(1);
                        $('.selectpicker').selectpicker('refresh');
                        
                        $('.st-'+AtRec.data('stu-id')).prop('checked',true);
                        enableSwitchery();
                    }
                    $.toast({heading: res.status,text: res.msg,icon: res.status});
                }
            });
        }else{
            swal('Error','<?php echo get_phrase('RFID_not_assigned!')?>','error');    
            return false;
        }
    });

    //Toggle Update
    $(document).on('change','input[name="att-switch"]',function(event){
        $obj = this;
        //console.log($($obj).prop('checked'));
        dTable = (window.innerWidth>700)?$('#desk-table'):$('#mobile-table');
        row = $(this).closest('tr');
        AtRec = row.find('.at-row');
        status = $($obj).prop('checked')?1:2;

        if(AtRec.data('stu-id')!=undefined){
            $('body').loading('start');
            $.ajax({
                type:'POST',
                url:'<?php echo base_url('index.php?ajax_controller/update_student_subject_attendance')?>',
                data:{class_id:AtRec.data('class-id'),
                      section_id:AtRec.data('section-id'),
                      subject_id:AtRec.data('subject-id'),
                      date:AtRec.data('date'),
                      stu_id:AtRec.data('stu-id'),
                      status:status},
                dataType:'json',
                success:function(res){
                    $('body').loading('stop');
                    if(res.status=='success'){
                        tr = $(dTable.dataTable().fnGetNodes()[AtRec.rowIndex]);
                        tr.find('select').val(status);
                        $('.selectpicker').selectpicker('refresh');

                        //ele = '.st-'+AtRec.data('stu-id');
                        //$(ele).prop('checked',true);
                        //$(ele).attr('disabled','disabled');
                        enableSwitchery();
                    }else{
                        $($obj).prop('checked',(status==1?false:true));
                        enableSwitchery();
                    }

                    $.toast({heading: res.status,text: res.msg,icon: res.status});
                }
            });
        }else{
            swal('Error','<?php echo get_phrase('attendance_updated')?>','error');    
            return false;
        }
    });
});
</script>