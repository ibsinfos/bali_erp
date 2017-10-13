<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12"><h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?parents/Dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active"><?php echo get_phrase($page_title); ?></li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>

<div class="row text-right">
    <div class="col-md-12">  
        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" onclick="showAjaxModal('<?php echo base_url() . 'index.php?modal/update_student_info_by_parent/' . $student_details->student_id; ?>');"><?php echo get_phrase('update_information'); ?></button>
    </div>
</div>
<div class="clearfix">&nbsp;</div>

<?php
if ($student_details->stud_image != "" && file_exists('uploads/student_image/' . $student_details->stud_image)) {
    $student_image = $student_details->stud_image;
} else {
    $student_image = '';
}
?>
<div class="row m-0" data-step="5" data-intro="<?php echo get_phrase('Student Information');?>" data-position='top'>
    <div class="col-xs-12 white-box">
        <div class="col-xs-12 col-sm-2">
            <a href="#"><img src="<?php echo ($student_image != "" ? 'uploads/student_image/' . $student_image : 'uploads/user.jpg') ?>" width="100px" height="100px"/></a>
        </div>

        <div class="col-xs-12 col-sm-10">
            <div>
                <h3><?php if(isset($student_details->name) && isset($student_details->lname)) { echo $student_details->name . " " . $student_details->lname; } ?></h3>
                <p><?php echo get_phrase('Class') . ' : ' . $student_details->class_name . '<br>' . get_phrase('Section') . ' : ' . $student_details->section_name; ?></p>
            </div>
        </div>
    </div>
</div>

<div class="row m-0" data-step="6" data-intro="<?php echo get_phrase('Desease Details');?>" data-position='top'>
    <span class="pull-right"></span>
    <div class="col-sm-12 white-box">

        <table id="example23" class="display nowrap new_tabulation" cellspacing="0" width="100%">
            <thead>
            <th>No.</th>
            <th>Desease</th>
            <th>Date</th>
            <th>Discription</th>
            <th data-step="7" data-intro="<?php echo get_phrase('More Desease Details');?>" data-position='top'> Options</th>
            </thead><?php $c = 1;
foreach ($medical_records as $med_rec): ?>

                <tbody>
                <td><?php echo $c++; ?></td>
                <td><?php echo $med_rec['desease_title']; ?></td>
                <td><?php echo $med_rec['consult_date']; ?></td>
                <td><?php echo $med_rec['description']; ?></td>
                <td>
                    <a href="javascript: void(0);" onclick="showAjaxModal('<?php echo base_url() . 'index.php?modal/view_medical_record/' . $med_rec['id']; ?>');">
                        <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger tooltip-danger" data-toggle="tooltip" 
                                data-placement="top" data-original-title="<?php echo get_phrase('view_details'); ?>" title="<?php echo get_phrase('view'); ?>">
                            <i class="fa fa-eye"></i>
                        </button>
                    </a>

                </td>
                </tbody><?php endforeach; ?>
        </table>

    </div>
</div>