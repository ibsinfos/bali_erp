<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?></h4>
    </div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?student/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li><a href="<?php echo base_url(); ?>index.php?student/my_exam"><?php echo get_phrase('my_exam'); ?></a></li>
            <li class="active">
                <?php echo get_phrase($page_title); ?>
            </li>
        </ol>
    </div>
</div>
<div class="col-md-12 white-box">
    <table class = "custom_table table display" cellspacing="0" width="100%" id="ex">
        <thead>
            <tr>
                <th><div><?php echo get_phrase('s._no.'); ?></div></th>
                <th><div><?php echo get_phrase('name'); ?></div></th>
                <th><div><?php echo get_phrase('obtained_percentage'); ?></div></th>
                <th><div><?php echo get_phrase('passing_percentage'); ?></div></th> 
                <th><div><?php echo get_phrase('result'); ?></div></th> 
            </tr>
        </thead>
        <tbody>
            <?php $count = 1;
            foreach ($details as $row):
                ?>
                <tr>
                    <td><?php echo $count++; ?></td>
                    <td><?php echo $row['exam_name']; ?></td>
                    <td><?php  if($row['result'] < 0){ echo "percentage is in negative"; }else{echo $row['result']; }?></td>
                    <td><?php echo $row['passing_percent']; ?></td>
                    <td><?php if($row['result'] ==  "Exam_not_attempted"){echo "no result";}else if($row['result'] >= $row['passing_percent']){echo "Pass";}else{ echo "Fail";}?></td>
                    
                </tr>
<?php endforeach; ?>
        </tbody>
    </table>
</div>   