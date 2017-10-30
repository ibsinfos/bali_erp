<div class="row bg-title"> 
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active"><?php echo get_phrase($page_title); ?></li>
        </ol>
    </div>
</div>


<div class="col-sm-12 white-box"> 
<table class = "custom_table table display" cellspacing="0" width="100%" id="ex">
    <thead>
        <tr>
            <th><div><?php echo get_phrase('s._No.'); ?></div></th>
            <th><div><?php echo get_phrase('enroll_code'); ?></div></th>
            <th><div><?php echo get_phrase('student_name'); ?></div></th>
            <th><div><?php echo get_phrase('class_name'); ?></div></th>
            <th><div><?php echo get_phrase('section_name'); ?></div></th>
            <th><div><?php echo get_phrase('route'); ?></div></th>
            <th><div><?php echo get_phrase('bus'); ?></div></th>
            
            
        </tr>
    </thead>
    <tbody>
        <?php $count = 1; 
        foreach ($student_details as $value){
            ?>
            <tr>
                <td><?php echo $count++; ?></td>
                <td><?php echo $value['enroll_code']; ?></td>
                <td><?php echo $value['name']." ".$value['mname']." ".$value['lname']; ?></td>
                <td><?php echo $value['class_name']; ?></td>
                <td><?php echo $value['section_name'] ?></td>
                <td><?php echo $value['route_name']; ?></td>
                <td><?php echo $value['bus_name']; ?></td>
                
                
            </tr>
        <?php } ?>
    </tbody>
</table>
</div>

        


