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
    <?php echo form_open(base_url('index.php?teacher/manage_attendance')); ?>
    <div class="col-sm-4 form-group" data-step="5" data-intro="<?php echo get_phrase('Select a Class from here!');?>" data-position='bottom'>
        <label for="field-1"><?php echo get_phrase('Select_Class'); ?><span class="error mandatory"> *</span></label>
        <select class="selectpicker" data-style="form-control" data-live-search="true" name="class_id"  onchange="select_section(this.value)">
            <option value=" "><?php echo get_phrase('select_class'); ?></option>            
            <?php foreach ($classes as $row1){
                    if(in_array($row1['class_id'],$class_ids)){?>
                <option value="<?php echo $row1['class_id'];?>" <?php echo($class_id == $row1['class_id'])?'selected':''?>>
                    <?php echo get_phrase('class').' '.$row1['name']; ?>
                </option>
            <?php }}?>
        </select> 
        <label class="mandatory"> <?php echo form_error('class_id'); ?></label>
    </div>

    <div class="col-sm-4 form-group" data-step="6" data-intro="<?php echo get_phrase('Select Section from here!');?>" data-position='top'>
        <label for="field-1"><?php echo get_phrase('select_section'); ?><span class="error mandatory"> *</span></label>       
        <select name="section_id" data-style="form-control" data-live-search="true" class="selectpicker" id="section_holder">
            <?php
            $selected = '';
            foreach ($sections as $key => $section) {
                $selected = ($section_id == $section->section_id ? 'selected' : '' );
                ?>
                <option <?php echo $selected ?> value="<?php echo $section->section_id; ?>"><?php echo $section->name; ?></option>
            <?php } ?>
        </select> 
        <label class="mandatory"> <?php echo form_error('section_id'); ?></label>
    </div>  

    <div class="col-sm-4 form-group" data-step="7" data-intro="<?php echo get_phrase('Select date!');?>" data-position='top'>               
        <label for="field-1"><?php echo get_phrase('select_date'); ?><span class="error mandatory"> *</span></label>
        <div class="input-group">
            <span class="input-group-addon"><i class="icon-calender"></i></span>
            <input type="text" class="form-control" id="mydatepicker_holiday_disable" name="timestamp" value="<?php echo date("m/d/Y", strtotime($date)); ?>"> 
            <label class="mandatory"> <?php echo form_error('date'); ?></label>
        </div>         
    </div>       

    <input type="hidden" name="year" value="<?php echo $running_year; ?>">
    <div class="text-right col-xs-12">
        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" data-step="8" 
        data-intro="<?php echo get_phrase('On the click on button, you will get list of attendance!');?>" 
        data-position='top'><?php echo get_phrase('MANAGE ATTENDANCE'); ?></button>
    </div>
    <?php echo form_close(); ?>
</div>
<div class="col-md-12 white-box" data-step="9" data-intro="<?php echo get_phrase('Shows the student details!!');?>" data-position='top'>
    <div class="text-center">
        <h3><?php echo get_phrase('attendance_for_class').' '.$class_name.'-'.get_phrase('section').' '.$section_name.' on '.date("d M Y", strtotime($date));?></h3>
    </div>
    
    <div class="row mt10 mb20">
        <div class="col-md-3 pull-right">            
            <input type="text" class="form-control rfid-attn" placeholder="RFID">
        </div>
    </div>

    <?php echo form_open(base_url('index.php?teacher/attendance_update/'.$class_id.'/'.$section_id.'/'.$date)); ?>
    <table id="dtable" class="display nowrap" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th><div><?php echo get_phrase('no:');?></div></th>
                <th><div><?php echo get_phrase('roll_no');?></div></th>
                <th><div><?php echo get_phrase('student_name');?></div></th>
                <th><div><?php echo get_phrase('REID'); ?></div></th>
                <th><div><?php echo get_phrase('parent_phone');?></div></th>
                <th><div><?php echo get_phrase('status'); ?></div></th>
                <th><div><?php echo get_phrase('time_in'); ?></div></th>
                <th><div><?php echo get_phrase('time_out'); ?></div></th>
            </tr>
        </thead>
        <tbody class="att-body">
            <?php $count = 1;
            foreach($attendance as $att): 
                $time_st = get_timing_st_color($att->timing_status,$att->status,$att->closed,$att->custom_updated);?>
                <tr style="<?php echo $time_st['style']?>">
                    <td><?php echo $count++;?>
                        <?php if($time_st['info']){?> 
                            <a class="tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo $time_st['info']?>" 
                            title="<?php echo $time_st['info']?>" style="<?php echo $time_st['style']?>"><i class="fa fa-question-circle"></i></a>
                        <?php }?>
                    </td>
                    <td><?php echo $att->roll;?></td>
                    <td><?php echo $att->name.' '.$att->lname; ?></td>  
                    <td><?php echo $att->card_id;?></td> 
                    <td><?php echo $att->parent_phone;?></td> 
                    <td>
                        <select class="selectpicker pos-static AtdStatus" data-style="form-control" name="atten[<?php echo $att->student_id?>]">
                            <option value="0" <?php echo $att->status == 0?'selected':'';?>><?php echo get_phrase('undefined'); ?></option>
                            <option value="1" <?php echo $att->status == 1?'selected':'';?>><?php echo get_phrase('present'); ?></option>
                            <option value="2" <?php echo $att->status == 2?'selected':'';?>><?php echo get_phrase('absent'); ?></option>
                        </select>
                        <input type="hidden" name="has_atten[<?php echo $att->student_id?>]" value="<?php echo $att->attendance_id;?>">	
                        <input type="hidden" class="at-row" data-rfid="<?php echo $att->card_id?>" data-stu-id="<?php echo $att->student_id?>" 
                        data-class-id="<?php echo $att->class_id?>" data-section-id="<?php echo $att->section_id?>" 
                        data-date="<?php echo date('Y-m-d',strtotime($date))?>">
                    </td>
                    <td><?php echo $att->has_in?date('h:i A',strtotime($att->in_time)):'N/A';?></td> 
                    <td><?php echo $att->has_out?date('h:i A',strtotime($att->out_time)):'N/A';?></td> 
                </tr>
            <?php endforeach;?>
        </tbody>
    </table>
    <div class="text-right col-xs-12 p-t-20 p-r-0">
        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" ><?php echo get_phrase('UPDATE ATTENDANCE'); ?></button>
    </div>

    <?php echo form_close(); ?>
</div>
<?php 
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

$(document).ready(function () {
    dTable = $('#dtable');
    dTable.DataTable({
        dom: 'frtip',
        //responsive: true,
        paging: false,
        columnDefs: [{ orderable: false, targets:-1 }],
        order: [[ 0, 'asc' ]]
    });
    
    $('.rfid-attn').focus();
    $('.rfid-attn').bind('change', function(e) {
        var Box = $(this);
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
            rowHtml.html(data[5]);
            if(AtRec.length==0){
                AtRec = rowHtml.find('.at-row[data-rfid='+RFID+']');
                AtRec.rowIndex = index;
            }
        });

        Box.val('');
        if (RFID !=false && AtRec.data('stu-id')!=undefined){
            $('body').loading('start');
            $.ajax({
                type:'POST',
                url:'<?php echo base_url('index.php?ajax_controller/update_student_attendance')?>',
                data:{class_id:AtRec.data('class-id'),
                      section_id:AtRec.data('section-id'),
                      date:AtRec.data('date'),
                      stu_id:AtRec.data('stu-id')},
                dataType:'json',
                success:function(res){
                    $('body').loading('stop');
                    if(res.status=='success'){
                        tr = $(dTable.dataTable().fnGetNodes()[AtRec.rowIndex]);
                        tr.attr('style',res.time_st.style);
                        tr.find('select').val(1);
                        $('.selectpicker').selectpicker('refresh');

                        infoHtml = '<a class="tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="'+res.time_st.info+'"'+ 
                                    'title="'+res.time_st.info+'" style="'+res.time_st.style+'"><i class="fa fa-question-circle"></i></a>';
                        td = tr.find('td:eq(0)');
                        td.html(td.text()+infoHtml);
                        tr.tooltip({selector:'[data-toggle="tooltip"]'});
                    }
                    swal(res.status,res.msg,res.status);    
                }
            });
        }else{
            swal('Error','<?php echo get_phrase('RFID_not_assigned!')?>','error');    
            return false;
        }
    });
});
</script>