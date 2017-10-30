<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('manage_drop_attendance'); ?> </h4></div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php?bus_driver/dashboard');?>"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active"><?php echo get_phrase('manage_attendance'); ?></li>
        </ol>
    </div>
</div>

<div class="col-md-12 white-box">
    <?php echo form_open(base_url('index.php?bus_driver/manage_drop_attendance')); ?>
    <div class="col-sm-6 form-group" data-step="5" data-intro="Select a bust from here!" data-position='bottom'>
        <label for="field-1"><?php echo get_phrase('Select_bus');?><span class="error mandatory"> *</span></label>
        <select class="selectpicker" data-style="form-control" data-live-search="true" name="bus_id" >
            <option value=" "><?php echo get_phrase('select_bus'); ?></option>            
            <?php foreach($buses as $row1):?>
            <option value="<?php echo $row1['bus_id'];?>" <?php if($bus_id == $row1['bus_id']){ echo "selected";} ?>><?php echo $row1['bus_name'];?></option>
            <?php endforeach;?>
        </select> 
        <label class="mandatory"> <?php echo form_error('bus_id'); ?></label>
    </div>
       
    <div class="col-sm-6 form-group" data-step="7" data-intro="Select date!" data-position='top'>               
        <label for="field-1"><?php echo get_phrase('select_date');?><span class="error mandatory"> *</span></label>
        <div class="input-group">
            <span class="input-group-addon"><i class="icon-calender"></i></span>
            <input type="text" class="form-control" name="timestamp" id="today_date" value="<?php echo date('d/m/Y',strtotime($date));?>" <?php echo 'disabled'?>> 
            <label class="mandatory"> <?php echo form_error('date'); ?></label>
        </div>         
    </div>       
    
    <div class="text-right col-xs-12">
        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" data-step="8" 
        data-intro="On the click on button, you will get list of attendance!" 
        data-position='top'><?php echo get_phrase('MANAGE ATTENDANCE');?></button>
    </div>
    <?php echo form_close(); ?>
</div>
<div class="col-md-12 white-box" data-step="9" data-intro="Shows the student details!!" data-position='top'>
    <div class="text-center">
        <!--<h3><?php //echo get_phrase('attendance_for_class').' '.$class_name.' '.get_phrase('section').''.$section_name.' on '.date("d-m-Y", $date);?></h3>-->
        <h3><?php echo get_phrase('drop_attendance_on').' '.date('d M Y',strtotime($date));?></h3>
    </div>
    
    <div class="row mt10 mb20">
        <div class="col-md-3 pull-right">            
            <input type="text" class="form-control rfid-attn" placeholder="RFID">
        </div>
    </div>
    <table id="dt_table" class="display nowrap" cellspacing="0" width="100%">
        <thead>
            <tr>
                <!-- <th><div><?php //echo get_phrase('no:');?></div></th> -->
                <th class="text-center" style="width:30%"><div><?php echo get_phrase('photo'); ?></div></th>
                <!-- <th><div><?php //echo get_phrase('student'); ?></div></th> -->
                <!-- <th><div><?php //echo get_phrase('REID'); ?></div></th> -->
                <th class="text-center"><div><?php echo get_phrase('drop_in');?></div></th>              
                <th class="text-center"><div><?php echo get_phrase('drop_out');?></div></th>
                <!-- <th><div><?php //echo get_phrase('drop_time_in'); ?></div></th>
                <th><div><?php //echo get_phrase('drop_time_out'); ?></div></th>     -->     
            </tr>
        </thead>
        <tbody>
            <?php $count = 1;
                foreach ($stu_attendance as $row): ?>
                <tr>
                    <!-- <td><?php //echo $count++;?></td> -->
                    <td class="text-center">
                        <input type="hidden" class="at-row" data-rfid="<?php echo $row->card_id?>" data-stu-id="<?php echo $row->student_id?>" 
                            data-class-id="<?php echo $row->class_id?>" data-bus-id="<?php echo $row->bus_id?>" data-route-id="<?php echo $row->route_id?>"
                            data-date="<?php echo date('Y-m-d',strtotime($date))?>">  
                        <?php 
                        if($row->stud_image !='' && file_exists(BASEPATH.'../uploads/student_image/'.$row->stud_image)){
                            $image_url = base_url('uploads/student_image/'.$row->stud_image);
                        }else{
                            $image_url = base_url('uploads/user.png');
                        }?>
                        <img src="<?php echo $image_url?>" class="img-circle" style="width:60px;height:60px;"/>
                        <h4><?php echo $row->name.' '.$row->lname;?></h4>
                    </td>
                    <!-- <td><?php //echo $row->name.' '.$row->lname;?></td> -->
                    <!-- <td><?php //echo $row->card_id;?></td> -->
                    <td class="text-center">
                        <input type="checkbox" value="1" name="in-switch" class="js-switch in-<?php echo $row->student_id?>" 
                        data-size="small" <?php echo $row->drop_in?'checked':''?> <?php echo $row->drop_in?'disabled':''?>>
                    </td>
                    <td class="text-center">
                        <input type="checkbox" value="1" name="out-switch" class="js-switch out-<?php echo $row->student_id?>" 
                        data-size="small" <?php echo $row->drop_out?'checked':''?> <?php echo $row->drop_out?'disabled':''?>>
                    </td>
                    <!-- <td class="time-in"><?php //echo $row->drop_in?date('H:i A',strtotime($row->drop_in_time)):'N/A';?></td>
                    <td class="time-out"><?php //echo $row->drop_out?date('H:i A',strtotime($row->drop_out_time)):'N/A';?></td> -->
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <!-- <div class="text-right col-xs-12 p-t-20">
        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" ><?php echo get_phrase('UPDATE ATTENDANCE');?></button>
    </div> -->
</div>
<script>
$(document).ready(function () {
    $('.rfid-attn').focus();
    $('#today_date').datepicker({format: "dd/mm/yyyy"});

    $('#dt_table').DataTable({
        dom: 'frtip',
        //responsive: true,
        columnDefs: [{ orderable: false, targets:-1 }],
        order: [[ 0, 'asc' ]]
    });

    $('#dt_table').on( 'draw.dt', function () {
        $('.selectpicker').selectpicker('refresh');
    });

    function changeSwitch(switch_id,active) {
        var check = document.querySelector(switch_id);
        //console.log("check",switch_id,check.checked,"to",active);
        if ( !check.checked && active ){
            var c = $(check).next('span').attr("class").replace("switchery ","");
            var l = {"switchery-large":"26px","switchery-small":"13px","switchery-default":"20px"}; 
            $(check).prop("checked",true).next('span').attr("style","box-shadow: rgb(112, 124, 210) 0px 0px 0px 16px inset;border-color: rgb(112, 124, 210);background-color: rgb(112, 124, 210);; transition: border 0.4s, box-shadow 0.4s, background-color 1.2s;").find('small').attr("style","left: "+l[c]+"; transition: background-color 0.4s, left 0.2s; background-color: rgb(255, 255, 255);");
        }else if ( check.checked && !active ){
            $(check).prop("checked",false).next('span').attr("style","box-shadow: rgb(223, 223, 223) 0px 0px 0px 0px inset; border-color: rgb(223, 223, 223); background-color: rgb(255, 255, 255); transition: border 0.4s, box-shadow 0.4s;").find('small').attr("style","left: 0px; transition: background-color 0.4s, left 0.2s;");
        }
    }

    $('.rfid-attn').bind('change', function(e) {
        var Box = $(this);
        var RFID = Box.val()!=''?parseInt(Box.val(), 10):false;
        if(RFID==false || RFID.length>15){
            swal('Error','<?php echo get_phrase('invalid_rfid_detail!')?>','error');    
            return false;
        }  

        AtRec = [];
        exTable = $('#dt_table').DataTable();
        exTable.rows().eq(0).each( function ( index ) {
            var row = exTable.row( index );
            var data = row.data();
			rowHtml = $('<div/>');
            rowHtml.html(data[0]);
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
                url:'<?php echo base_url('index.php?ajax_controller/update_student_bus_drop_attendance')?>',
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

                        if(res.type=='in'){
                            ele = '.in-'+AtRec.data('stu-id');
                            //changeSwitch(ele,true);
                            $(ele).prop('checked',true);
                            $(ele).attr('disabled','disabled');
                            enableSwitchery();

                            tr.find('td.time-in').html(res.time);
                        }else{
                            ele = '.out-'+AtRec.data('stu-id');
                            //changeSwitch(ele,true);
                            $(ele).prop('checked',true);
                            $(ele).attr('disabled','disabled');
                            enableSwitchery();
                            tr.find('td.time-out').html(res.time);
                        }
                        
                        $('.selectpicker').selectpicker('refresh');
                    }
                    $.toast({heading: res.status, text: res.msg,icon: res.status});  
                }
            });
        }else{
            //Box.val('');
            swal('Error','<?php echo get_phrase('RFID_not_assigned!')?>','error');    
            return false;
        }
    });
});

//Toggle Update
$(document).on('change','input[name="in-switch"],input[name="out-switch"]',function(event){
    $obj = this;
    row = $(this).closest('tr');
    AtRec = row.find('.at-row');

    if(AtRec.data('stu-id')!=undefined){
        $('body').loading('start');
        $.ajax({
            type:'POST',
            url:'<?php echo base_url('index.php?ajax_controller/update_student_bus_drop_attendance')?>',
            data:{class_id:AtRec.data('class-id'),
                bus_id:AtRec.data('bus-id'),
                route_id:AtRec.data('route-id'),
                date:AtRec.data('date'),
                stu_id:AtRec.data('stu-id')},
            dataType:'json',
            success:function(res){
                $('body').loading('stop');
                if(res.status=='success'){
                    if(res.type=='in'){
                        ele = '.in-'+AtRec.data('stu-id');
                        $(ele).prop('checked',true);
                        $(ele).attr('disabled','disabled');
                        enableSwitchery();

                        row.find('td.time-in').html(res.time);
                    }else{
                        ele = '.out-'+AtRec.data('stu-id');
                        $(ele).prop('checked',true);
                        $(ele).attr('disabled','disabled');
                        enableSwitchery();

                        row.find('td.time-out').html(res.time);
                    }
                }else{
                    $($obj).prop('checked',false);
                    enableSwitchery();
                }
                $.toast({heading: res.status, text: res.msg,icon: res.status});   
            }
        });
    }else{
        swal('Error','<?php echo get_phrase('attendance_updated')?>','error');    
        return false;
    }
});
</script>


