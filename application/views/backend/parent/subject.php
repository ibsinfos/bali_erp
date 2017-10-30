<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12"><h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?parents/Dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active"><?php echo get_phrase($page_title); ?></li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>
<div class="row m-0"> 
        <div class=" col-md-12 p-0">
          <div class="panel panel-danger block6" data-step="5" data-intro="<?php echo get_phrase('For Information');?>" data-position='bottom'>
    <div class="panel-heading"> Teacher Information
        <div class="pull-right"><a href="#" data-perform="panel-collapse"><i class="ti-minus"></i></a> <a href="#" data-perform="panel-dismiss"><i class="ti-close"></i></a> </div>
    </div>
    <div class="panel-wrapper collapse in" aria-expanded="true">
        <div class="panel-body">
            <?php if(!empty($class_teacher_name)){?>
<h4><?php echo get_phrase('class_teacher_:_').$class_teacher_name." </br></br> ". get_phrase('email_:_')." ".$class_teacher_email;?></h4>
<?php } else { echo 'No teacher assigned for this class'; }?>

<?php if(!empty($class_name) || !empty($section_name)){?>

<?php }?>
        </div>
    </div>
</div>  
            
    
            </div>
        </div> 


<div class="row m-0"> 
        <div class=" col-md-12 white-box" data-step="6" data-intro="<?php echo get_phrase('List of subject,teacher and teacher\'s email_id ');?> <?php if(!empty($class_name) || !empty($section_name)){?>
<?php echo "of".get_phrase('class_:_').$class_name. " ". get_phrase('section:_').$section_name;?>
<?php }?>" data-position='top'>           
                  <table class= "custom_table table display" cellspacing="0" width="100%" id="ex">
                    <thead>
                        <tr>
                            <th width="10%"><div><?php echo get_phrase('s._no.'); ?></div></th>
                            <th width="30%"><div><?php echo get_phrase('subject_name'); ?></div></th>
                            <th width="30%"><div><?php echo get_phrase('teacher'); ?></div></th>
                            <th width="20%"><div><?php echo get_phrase('contact'); ?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count = 1;
                        if (!empty($subjects)) {
                            foreach ($subjects as $row):
                                ?>
                                <tr>
                                    <td><?php echo $count++; ?></td>
                                    <td><?php echo $row['name']; ?></td>
                                    <td><?php echo $row['teacher_name']." ".$row['last_name']; ?></td>
                                    <td><?php echo $row['email']; ?></td>
                                </tr>
                        <?php endforeach; } ?>
                    </tbody>
                </table>
        </div>
</div>
 


