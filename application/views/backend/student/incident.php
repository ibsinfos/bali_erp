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
            <li><a href="<?php echo base_url(); ?>index.php?student/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active"><?php echo get_phrase($page_title); ?></li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>

   <div class="col-md-12 white-box" > 
        <div class="text-center m-b-20" data-step="8" data-intro="<?php echo get_phrase('Here you can see the list of incident.');?>" data-position='top'>
             <h3><?php echo get_phrase('incident');?></h3>
        </div>
<table class= "custom_table table display" cellspacing="0" width="100%" id="example23">
    <thead>
        <tr>
            <th><div><?php echo get_phrase('No'); ?></div></th>                               
            <th><div><?php echo get_phrase('violation_type'); ?></div></th>
            <th><div><?php echo get_phrase('section_teacher'); ?></div></th>
            <th><div><?php echo get_phrase('violation_description'); ?></div></th>
            <th><div><?php echo get_phrase('class'); ?></div></th>
            <th><div><?php echo get_phrase('section'); ?></div></th>
            <th><div><?php echo get_phrase('parent_appeal'); ?></div></th>
            <th><div><?php echo get_phrase('student_name'); ?></div></th>
            <th><div><?php echo get_phrase('parent_statement'); ?></div></th>
            <th><div><?php echo get_phrase('verdict'); ?></div></th>
            <th><div><?php echo get_phrase('reporting_teacher'); ?></div></th>
            <th><div><?php echo get_phrase('corrective_action'); ?></div></th>
            <th><div><?php echo get_phrase('date_of_occurrence'); ?></div></th>
            <th><div><?php echo get_phrase('expiry_date'); ?></div></th>
        </tr>
    </thead>
    <tbody>
    <?php $count = 1; foreach ($details as $row):  ?>
        <tr>
            <td><?php echo $count++; ?></td>
            <td><?php echo $row['type']; ?></td>
            <td><?php echo $row['raised_by']; ?></td>
            <td><?php echo $row['description']; ?></td>
            <td><?php echo $row['class_name']; ?></td>
            <td><?php echo $row['section_name']; ?></td>
            <td><?php echo $row['parent_appeal']; ?></td>
            <td><?php echo $row['student_name']; ?></td>
            <td><?php echo $row['parent_statement']; ?></td>
            <td><?php echo $row['verdict']; ?></td>
            <td><?php echo $row['reporting_teacher']; ?></td>
            <td><?php echo $row['corrective_action']; ?></td>
            <td><?php echo $row['date_of_occurrence']; ?></td>
            <td><?php echo $row['expiry_date']; ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>