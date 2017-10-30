<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('manage_daily_attendance'); ?> </h4></div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?bus_driver/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active"><?php echo get_phrase('manage_attendance'); ?></li>
        </ol>
    </div>
</div>

<div class="col-md-12 white-box">
    <?php echo form_open(base_url() . 'index.php?bus_driver/manage_attendance/'); ?>
    <div class="col-sm-6 form-group" data-step="5" data-intro="Select a Class from here!" data-position='bottom'>
        <label for="field-1"><?php echo get_phrase('Select_bus');?><span class="error mandatory"> *</span></label>
        <select class="selectpicker" data-style="form-control" data-live-search="true" name="bus_id" >
            <option value=" "><?php echo get_phrase('select_class'); ?></option>            
            <?php foreach($buses as $row1):?>
            <option value="<?php echo $row1['bus_id'];?>" <?php if($bus_id == $row1['bus_id']){ echo "selected";} ?>><?php echo $row1['bus_name'];?></option>
            <?php endforeach;?>
        </select> 
        <label class="mandatory"> <?php echo form_error('class_id'); ?></label>
    </div>
       
    <div class="col-sm-6 form-group" data-step="7" data-intro="Select date!" data-position='top'>               
        <label for="field-1"><?php echo get_phrase('select_date');?><span class="error mandatory"> *</span></label>
        <div class="input-group">
            <span class="input-group-addon"><i class="icon-calender"></i></span>
            <input type="text" class="form-control" name="timestamp" id ="today_date" value="<?php echo date('d/m/Y',strtotime($date));?>"
                <?php echo @$mark_today?'disabled':''?>> 
            <label class="mandatory"> <?php echo form_error('date'); ?></label>
        </div>         
    </div>       
    
    <input type="hidden" name="year" value="<?php echo $running_year;?>">
    <div class="text-right col-xs-12">
        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" data-step="8" data-intro="On the click on button, you will get list of attendance!" data-position='top'><?php echo get_phrase('MANAGE ATTENDANCE');?></button>
    </div>
    <?php echo form_close(); ?>
</div>
<div class="col-md-12 white-box" data-step="9" data-intro="Shows the student details!!" data-position='top'>
    <div class="text-center">
        <!--<h3><?php //echo get_phrase('attendance_for_class').' '.$class_name.' '.get_phrase('section').''.$section_name.' on '.date("d-m-Y", $date);?></h3>-->
        <h3><?php echo get_phrase('attendance_on').' '.date('d/m/Y',strtotime($date));?></h3>
    </div>
    
    <div class="row mt10 mb20">
        <div class="col-md-3 pull-right">            
            <input type="text" class="form-control rfid-attn" placeholder="RFID">
        </div>
    </div>
    <?php echo form_open(base_url() . 'index.php?bus_driver/attendance_update/'.$bus_id.'/'. $date); ?>
        <table id="ex" class="display nowrap" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th><div><?php echo get_phrase('no:'); ?></div></th>
                    <th><div><?php echo get_phrase('bus'); ?></div></th>
                    <th><div><?php echo get_phrase('student'); ?></div></th>
                    <th><div><?php echo get_phrase('class'); ?></div></th>
                    <th><div><?php echo get_phrase('section'); ?></div></th> 
                    <th><div><?php echo get_phrase('REID'); ?></div></th>
                    <th><div><?php echo get_phrase('parent_phone');?></div></th>              
                    <th><div><?php echo get_phrase('status');?></div></th>
                    <th><div><?php echo get_phrase('time_in'); ?></div></th>
                    <th><div><?php echo get_phrase('time_out'); ?></div></th>         
                </tr>
            </thead>
            <tbody>
                <?php $count = 1;
                    foreach ($stu_attendance as $row): ?>
                    <tr>
                        <td><?php echo $count++;?></td>
                        <td><?php echo $row->bus_name;?></td>
                        <td><?php echo $row->name.' '.$row->lname;?></td>
                        <td><?php echo $row->class_name;?></td>
                        <td><?php echo $row->section_name;?></td>
                        <td><?php echo $row->card_id;?></td>
                        <td><?php echo $row->parent_phone;?></td>
                        <td>
                            <select class="selectpicker" data-style="form-control" name="atten[<?php echo $row->student_id?>]">
                                <option value="0" <?php echo $row->att_st == 0?'selected':'';?>><?php echo get_phrase('undefined'); ?></option>
                                <option value="1" <?php echo $row->att_st == 1?'selected':'';?>><?php echo get_phrase('present'); ?></option>
                                <option value="2" <?php echo $row->att_st == 2?'selected':'';?>><?php echo get_phrase('absent'); ?></option>
                            </select>
                            <input type="hidden" name="has_atten[<?php echo $row->student_id?>]" value="<?php echo $row->bus_attendence_id;?>">	
                            <input type="hidden" class="at-row" data-rfid="<?php echo $row->card_id?>" data-stu-id="<?php echo $row->student_id?>" 
                            data-class-id="<?php echo $row->class_id?>" data-bus-id="<?php echo $row->bus_id?>" data-route-id="<?php echo $row->route_id?>"
                            data-date="<?php echo date('Y-m-d',strtotime($date))?>">
                        </td>
                        <td class="time-in"><?php echo $row->bus_in?date('H:i A',strtotime($row->in_time)):'N/A';?></td>
                        <td class="time-out"><?php echo $row->bus_out?date('H:i A',strtotime($row->in_time)):'N/A';?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <!-- <div class="text-right col-xs-12 p-t-20">
            <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" ><?php echo get_phrase('UPDATE ATTENDANCE');?></button>
        </div> -->
    <?php echo form_close(); ?>
</div>
<script>
$(document).ready(function () {
    $('#today_date').datepicker({format: "dd/mm/yyyy"});

    $('.rfid-attn').focus();
    
    $('.AtdStatus').change(function () {
        var MyVal = $(this).val();
        if (MyVal != '0') {
            var MyName = $(this).attr('name');
            var AtdId = MyName.split('_');
            $("input[name$='update_attendance_" + AtdId[1] + "']").val(MyVal);
        }
    });

    $('.rfid-attn').bind('change', function(e) {
        var Box = $(this);
        var RFID = Box.val()!=''?parseInt(Box.val(), 10):false;
        if(RFID==false || RFID.length>15){
            swal('Error','<?php echo get_phrase('invalid_rfid_detail!')?>','error');    
            return false;
        }  

        AtRec = [];
        $('#ex').DataTable().rows().eq(0).each( function ( index ) {
            var row = exTable.row( index );
            var data = row.data();
			rowHtml = $('<div/>');
            rowHtml.html(data[7]);
            if(AtRec.length==0){
                AtRec = rowHtml.find('.at-row[data-rfid='+RFID+']');
                AtRec.rowIndex = index;
                //console.log(RFID,AtRec.data('stu-id'),AtRec.rowIndex,$($('#ex').dataTable().fnGetNodes()[AtRec.rowIndex]));
            }
        });

        Box.val('');
        if (RFID !=false && AtRec.data('stu-id')!=undefined){//AtRec.length>0){
            //Box.val('');
            $('body').loading('start');
            $.ajax({
                type:'POST',
                url:'<?php echo base_url('index.php?ajax_controller/update_student_bus_attendance')?>',
                data:{class_id:AtRec.data('class-id'),
                      bus_id:AtRec.data('bus-id'),
                      route_id:AtRec.data('route-id'),
                      date:AtRec.data('date'),
                      stu_id:AtRec.data('stu-id')},
                dataType:'json',
                success:function(res){
                    $('body').loading('stop');
                    if(res.status=='success'){
                        tr = $($('#ex').dataTable().fnGetNodes()[AtRec.rowIndex]);
                        tr.find('select').val(1);
                        //tr.attr('style',res.time_st.style);
                        /* tr.find('select').val(1);
                        infoHtml = '<a class="tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="'+res.time_st.info+'"'+ 
                                    'title="'+res.time_st.info+'" style="'+res.time_st.style+'"><i class="fa fa-question-circle"></i></a>';
                        td = tr.find('td:eq(0)');
                        td.html(td.text()+infoHtml);*/

                        if(res.type=='in'){
                            tr.find('td.time-in').html(res.time);
                        }else{
                            tr.find('td.time-out').html(res.time);
                        }
                        
                        $('.selectpicker').selectpicker('refresh');
                        //tr.tooltip({selector:'[data-toggle="tooltip"]'});
                        swal('Success',res.msg,'success');    
                    }
                }
            });
        }else{
            //Box.val('');
            swal('Error','<?php echo get_phrase('RFID_not_assigned!')?>','error');    
            return false;
        }
    });
});
</script>


