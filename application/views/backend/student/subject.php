<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12"><h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();"  class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?student/Dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active"><?php echo get_phrase('subject'); ?></li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>
<div class="row m-0">
<div class="col-md-12 white-box">	
            <table class= "custom_table table display" cellspacing="0" width="100%" id="example23" data-step="5" data-intro="Subject list will show here" data-position='top'>
                    	<thead>
                		<tr>
                    		<th><div><?php echo get_phrase('s._no.');?></div></th>
                    		<th><div><?php echo get_phrase('subject_name');?></div></th>
                    		<th><div><?php echo get_phrase('teacher');?></div></th>
                                <th><div><?php echo get_phrase('class');?></div></th>
                                <th><div><?php echo get_phrase('section');?></div></th>
						</tr>
					</thead>
                    <tbody>
                    	<?php $count = 1;foreach($subjects as $row):?>
                        <tr>
							<td><?php echo $count++;?></td>
							<td><?php echo $row['name'];?></td>
							<td><?php echo $row['teacher_name'];?></td>
                                                        <td><?php echo $row['class_name'];?></td>
                                                        <td><?php echo $row['section_name'];?></td>
							
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
<!----TABLE LISTING ENDS-->
</div>
</div>



<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->                      
