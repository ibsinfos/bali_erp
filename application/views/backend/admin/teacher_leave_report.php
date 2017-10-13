<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('view_teacher_leave_report'); ?> </h4></div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?admin/dashboard"><?php echo get_phrase('Student RTE Report'); ?></a></li>
            <li class="active"><?php echo get_phrase('view_teacher_leave_report'); ?></li>
        </ol>
    </div>
</div>


 
<div class="row">
<div class="col-sm-12 white-box">    
       
<table id="example23" class="display nowrap" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th><div><?php echo get_phrase('sl_no.');?></div></th>
            <th><div><?php echo get_phrase('Department Name'); ?></div></th> 
            <th><div><?php echo get_phrase('Teacher Name'); ?></div></th> 
            <th><div><?php echo get_phrase('Reporting Manager'); ?></div></th> 
            <th><div><?php echo get_phrase('Approver Comment'); ?></div></th>                            
            <th><div><?php echo get_phrase("Leave Type"); ?></div></th> 
            <th><div><?php echo get_phrase("No: Of Days"); ?></div></th> 
            <th><div><?php echo get_phrase('From'); ?></div></th>
            <th><div><?php echo get_phrase('To'); ?></div></th>
        </tr>
    </thead>
    <tbody><?php
    $n = 1;
//department_name,user_name,reason,approver_comments,leavetype_name,no_of_days,from_date,to_date   
    if(count($teacher_records)>0){
        foreach ($teacher_records as $row){   ?>
            <tr>
                <td><?php echo $n++;?></td>
                <td><?php echo $row['department_name']; ?></td>
                <td><?php echo $row['user_name'];?></td>
                <td><?php echo $row['reason'];?></td>
                <td><?php echo ($row['approver_comments']);?></td>
                <td><?php echo ($row['leavetype_name']);?></td>
                <td><?php echo ($row['no_of_days']);?></td>
                <td><?php echo ($row['from_date']);?></td>
                <td><?php echo ($row['to_date']);?></td>

        </tr><?php }
    } else {?> 
        <tr><td colspan="5" align="center">No data Available</td>
    <?php }?>
    </tbody>

</table>
</div>                     
</div>
<script type="text/javascript">
    
//    function select_department(school_id) { 
//        $.ajax({
//            url: '<?php echo base_url(); ?>index.php?Ajax_controller/get_class_by_school/' + school_id,
//            success:function (response){//alert(response);
//                jQuery('#class_holder').html(response);
//            }
//        });
//    }
</script>