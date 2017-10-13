<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
    <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);"  onclick="javascript:introJs().start();" id="take-tour"  class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/dashboard"><?php echo get_phrase('dashboard'); ?></a></li>

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

<div class="row text-right">
    <div class="col-md-12">   
        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" onclick="confirm_create_schedule();"><?php echo get_phrase('create_schedule'); ?></button>
    </div>
</div>
<div class="clearfix">&nbsp;</div>
<div class="col-xs-12 white-box">
    <input type="hidden" name="running_year" id="running_year" value="<?php echo $running_year;?>">
    <form class="pure-form pure-form-aligned">
        
    </form>
    
    <div class="row">
        <div class="col-sm-12">    
            <div class="white-box" data-step="9" data-intro="<?php echo get_phrase('Here you can view here priority details');?>" data-position="top">
                <table id="ex_att" class="display nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th><div>Class</div></th>
                            <th><div>Section</div></th>
                            <th><div>Subject</div></th>
                            <th><div>Schedule restrictions</div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $notDefined=0;
                        foreach($schedules_year_data_arr AS $k){ //pre($k);die;
                            $td_action="";
                            if($k['restriction_info_id']=='-1'){
                                $cColor='red';
                                $td_action = "<a href='#' class='btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger' data-toggle='tooltip' data-placement='top' data-original-title='Not defined.' onclick='addClass(".$k["subject_id"].",".$k["section_id"].",".$k["class_id"].",\"add\")'><i class='fa fa-check'></i></a>";
                                $notDefined++;
                            }else{
                                $cColor='green';
                                $td_action = "<a href='#' class='btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger' data-toggle='tooltip' data-placement='top' data-original-title='Modify' onclick='addClass(".$k["subject_id"].",".$k["section_id"].",".$k["class_id"].",\"edit\")'><i class='fa fa-pencil'></i></a>";
                            }?>
                        <tr>
                            <td><?php echo $k["class_name"];?></td>
                            <td><?php echo $k["section_name"];?></td>
                            <td><?php echo $k["subject_name"];?></td>
                            <td><?php echo $td_action;?></td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div> 
        </div> 
        
    </div>
    
</div>

<script type="text/javascript">
function addClass(subject_id, section_id, class_id,type) {
    var url = '<?php echo base_url();?>index.php?school_admin/automatic_timetable_add_class/'+subject_id+'/'+section_id+'/'+class_id+'/'+type;
    window.location.href = url;
}

function confirm_create_schedule(){
    var notDefined='<?php echo $notDefined;?>';
    if(notDefined>0){
        var confirmMessage="There are still " + notDefined + " classes without a schedule restrictions defined. Continue?";
    }else{
        var confirmMessage="Are you sure to continue ?";
    }
    swal({
        title: confirmMessage,
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes!",
        cancelButtonText: "Cancel",
        closeOnConfirm: true
    }, function(isConfirm){
      if (isConfirm) {
          location.href='<?php echo base_url();?>index.php?school_admin/automatic_timetable_create_schedule';
        } else {
        return false;
      }
    });
    
}
</script>


