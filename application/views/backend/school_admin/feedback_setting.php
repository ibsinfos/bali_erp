<div class="row bg-title"> 
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
         
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
    <!-- /.breadcrumb -->
</div>
    <!------CONTROL TABS START------>
   <div class="col-md-12 white-box">
       <div class="text-right"><input type="checkbox" value="all" id="CheckAll" class="js-switch" data-color="#99d683" />
    <label>All</label>
           </div>   
    </div>
    <form name="myform" id="myform" action="<?php echo base_url(); ?>index.php?school_admin/setting_feedback/status_change/all/N'" >
<div class="col-md-12 white-box" data-step="7" data-intro="<?php echo get_phrase('This shows list of Teacher.');?>" data-position='top'>        
                                <table class= "custom_table table display" cellspacing="0" width="100%" id="example23">
                                    <thead>
                                        <tr>
                                            <th><div><?php echo get_phrase('s_no.'); ?></div></th>
                                            <th><div><?php echo get_phrase('teacher_name'); ?></div></th>
                                            <th  data-step="8" data-intro="<?php echo get_phrase('From here you can edit and delete the subject.')?>" data-position='top'><div><?php echo get_phrase('action'); ?></div></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $count=1; foreach($list as $row):  
                                             if($row['feedback_status']=='Y'){
                                      $button_show =  '<button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" rel="tooltip" data-toggle="tooltip" data-placement="top" data-color="#99d683" style="color:#64bd63;" data-original-title="Enable"  title="Enable"><i class="fa fa-toggle-on"></i></button>';
        } else {
                                      $button_show =  '<button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" rel="tooltip" data-toggle="tooltip" data-placement="top" data-original-title="Disable"  title="Disable"><i class="fa fa-toggle-off"></i></button>';
                                     }
                                            ?>
                                        <tr>
                                            <td><?php echo $count++;  ?></td>
                                            <td><?php echo $row['name'] ." ". ($row['middle_name']!=''?$row['middle_name']:'') ." ". $row['last_name'];  ?></td>
                                            <td><a href="javascript: void(0);" onclick="confirm_print('<?php echo base_url(); ?>index.php?school_admin/setting_feedback/status_change/<?php echo $row['teacher_id']; ?>/<?php echo $row['feedback_status']; ?>', 'Are you sure to execute this action ?');"><?php echo $button_show ?></a></td>
                                        </tr>  
                                     <?php   endforeach; ?>
                                    
                                    <input type="text" class="js-check-change-field hide" id="switchbutton_value">
                                    <input type="text" name="feedback_status" class="hide" value="" id="feedback_status" >
                                    </tbody>
                                </table>
</div>    
        </form>   
        
    <script>
    var changeCheckbox = document.querySelector('.js-switch')
  , changeField = document.querySelector('#switchbutton_value');
changeCheckbox.onchange = function() {
  changeField.value = changeCheckbox.checked;
  switch_on_off();
};
//showdiv2

function switch_on_off(){  
var switch_on_off = document.getElementById("switchbutton_value").value;
    if(switch_on_off == "true"){
   window.location = '<?php echo base_url(); ?>index.php?school_admin/setting_feedback/status_change/all/Y'; 
}
if(switch_on_off == "false"){
    window.location = '<?php echo base_url(); ?>index.php?school_admin/setting_feedback/status_change/all/N';
}
} 

var status = "<?php echo $status_check;  ?>";
    if(status=='Y'){
$('#CheckAll').attr('checked', 'checked');
}else{
$('#CheckAll').removeAttr('checked');    
}
</script>