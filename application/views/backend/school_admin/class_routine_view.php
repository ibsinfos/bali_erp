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


<div class="row">    
<div class="col-md-12 no-padding select_container">
    <div class="col-md-10">
    <div class="form-group col-md-5 no-padding" data-step="5" data-intro="<?php echo get_phrase('Select a class, for which you want to see class routine.');?>" data-position='right'>
    <label class="control-label">Select Class</label>
    <select class="selectpicker" data-style="form-control" data-live-search="true" onchange="window.location = this.options[this.selectedIndex].value">
	<option value="">Select Class</option>
	<?php foreach ($classes as $row): ?>
	    <option <?php if ($class_id == $row['class_id']) {
	    echo 'selected';
	} ?> value="<?php echo base_url(); ?>index.php?school_admin/show_timetable/<?php echo $row['class_id']; ?>">
	    <?php echo get_phrase('class'); ?>&nbsp;<?php echo $row['name']; ?>
	    </option>
    <?php endforeach; ?>
    </select>
    </div>
    </div>

    <div class="col-md-2 hidden-sm"> 
        <a href="<?php echo base_url(); ?>index.php?school_admin/class_routine_add"
       class="btn btn-primary btn-circle btn-lg pull-right tooltip-danger" data-toggle="tooltip" data-placement="left" title="" data-original-title="Add Timetable" data-step="6" data-intro="<?php echo get_phrase('You can add new class routine from here.');?>" data-position='left'> 
	   <i class="fa fa-plus"></i>
       </a>    
    </div>
</div>
</div>

<?php     
    if($this->session->flashdata('flash_message_error')) {?>        
    <div class="alert alert-danger">
    <?php echo $this->session->flashdata('flash_message_error'); ?>
    </div>
    <?php } ?>

<div class="col-md-12 white-box" data-collapsed="0" data-step="7" data-intro="<?php echo get_phrase('From here you can see the class timetable of selected class and take print also.');?>" data-position='top'>
<?php
foreach ($routines as $array_name => $array1) {
    foreach ($array1 as $key1 => $array) {
        ?>
                <div class="panel panel-default">
                  
                  <div><span><b>
                            <?php echo get_phrase('class'); ?>&nbsp;
                            <?php echo $class_name; ?> : 
        <?php echo get_phrase('section'); ?> - <?php echo $array_name; ?></b></span>
                            <a href="<?php echo base_url(); ?>index.php?school_admin/class_routine_print_view/<?php echo $class_id; ?>/<?php echo $key1; ?>" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-b-20" target="_blank">
                                <i class="fa fa-print"></i> <?php echo get_phrase('print'); ?>
                            </a>
                 </div>
                 
                    <div class="panel-body">
                        <table cellpadding="0" cellspacing="0" border="0"  class="table table-bordered">
                            <tbody>
                                <?php
                                foreach ($array as $key => $value) {
                                    ?>
                                    <tr class="gradeA">
                                        <td width="100"><?php echo strtoupper($key); ?></td>
                                        <td>
                                            <?php
                                            foreach ($value as $keys => $row2) {
                                                ?>
                                                <div class="btn-group btn-bottom">
                                                    <!--<button class="btn btn-default dropdown-toggle btn_whitespace" data-toggle="dropdown">-->
                                                    <button class="btn btn-default btn_whitespace">
                                                <?php echo $row2['subject_name'];?>
                                                <?php echo '('.$row2['teacher_name'].')';?>
                                                        <?php
                                                        if ($row2['time_start_min'] == 0 && $row2['time_end_min'] == 0)
                                                            echo '(' . $row2['time_start'] . '-' . $row2['time_end'] . ')';
                                                        if ($row2['time_start_min'] != 0 || $row2['time_end_min'] != 0)
                                                            echo '(' . $row2['time_start'] . ':' . $row2['time_start_min'] . '-' . $row2['time_end'] . ':' . $row2['time_end_min'] . ')';
                                                        ?>
                                                        <!--<span class="caret"></span>-->
                                                    </button>
                                                    <?php /*<ul class="dropdown-menu">
                                                        <li>
                                                            <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_edit_class_routine/<?php echo $row2['class_routine_id']; ?>');">
                                                                <i class="entypo-pencil"></i>
                <?php echo get_phrase('edit'); ?>
                                                            </a>
                                                        </li>

                                                        <li>
                                                            <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>index.php?school_admin/class_routine/delete/<?php echo $row2['class_routine_id']; ?>');">
                                                                <i class="entypo-trash"></i>
                <?php echo get_phrase('delete'); ?>
                                                            </a>
                                                        </li>
                                                    </ul>*/?>
                                                </div>
            <?php } ?>

                                        </td>
                                    </tr>
        <?php } ?>

                            </tbody>
                        </table>

                    </div>
                </div>

    <?php }
}
?>
<?php
// endif;?>
</div>
