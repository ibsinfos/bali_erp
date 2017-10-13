<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12"><h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?teacher/dashboard"><?php echo get_phrase('dashboard'); ?></a></li>

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

<?php echo form_open(base_url() . 'index.php?teacher/marks_report_selector', array(
        'class' => 'form-control-bordered validate', 'target' => '_top', 'enctype' => 'multipart/form-data'
    ));?>

	    <div class="col-md-12 white-box">
			<div class="col-sm-3 form-group" data-step="5" data-intro="<?php echo get_phrase('Please Select Your Exam');?> " data-position='bottom'>
				<label class="control-label"><?php echo get_phrase('exam');?></label><span class="mandatory">*</span>	
				<select name="exam_id" data-style="form-control" data-live-search="true" class="selectpicker" required>
<?php if(count($exams)){ foreach($exams as $row): ?>
					<option value="<?php echo $row['exam_id'];?>"><?php echo $row['name'];?></option><?php endforeach; }?>
				</select>
			</div>	

			<div class="col-sm-3 form-group">
				<div class="form-group" data-step="6" data-intro="<?php echo get_phrase('Please Select Your Class ');?>" data-position='bottom'>
					<label class="control-label"><?php echo get_phrase('class');?></label><span class="mandatory">*</span>			
                                        <select name="class_id" data-style="form-control" data-live-search="true" class="selectpicker" onchange="return onclasschange(this.value);" required="required">
						<option value=""><?php echo get_phrase('select_class');?></option>
<?php if(count($classes)){ foreach($classes as $row):?>
						<option value="<?php echo $row['class_id'];?>"><?php echo $this->crud_model->get_class_name($row['class_id']);?></option>
						<?php endforeach; }?>
					</select>
				</div>
			</div>

			<div id="col-md-6 subject_holder">
				<div class="col-md-3 col-sm-6 col-xs-12">
					<div class="form-group" data-step="7" data-intro="<?php echo get_phrase('Please Select Your Section');?> " data-position='bottom'>
						<label class="control-label"><?php echo get_phrase('section');?></label><span class="mandatory">*</span>
                                                <select name="section_id" data-style="form-control" data-live-search="true" class="selectpicker" id="section_holder" onchange="onsectionchange(this.value);" required="required">
							<option value=""><?php echo get_phrase('select_class_first');?></option>
						</select>
					</div>
				</div>
			    
				<div class="col-md-3 col-sm-6 col-xs-12">
					<div class="form-group" data-step="8" data-intro="<?php echo get_phrase('Please Select Your Subject');?>" data-position='bottom'>
						<label class="control-label"><?php echo get_phrase('subject');?></label><span class="mandatory">*</span>
						<select name="subject_id" id="subject_holder" data-style="form-control" data-live-search="true" class="selectpicker" required="required">
							<option value=""><?php echo get_phrase('select_section_first');?></option>		
						</select>
					</div>
				</div>
				
			</div>
		
	        <div class="text-right col-xs-12">
		        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('view_report');?></button>		
		   </div>  
		
		</div>


<?php echo form_close();?>




<script type="text/javascript">
	function onclasschange(class_id)
{
    jQuery('#section_holder').html('<option value="">Select Section</option>');
    $.ajax({
            url: '<?php echo base_url();?>index.php?teacher/get_teacher_section/' + class_id,
            success: function (response)
            {
                jQuery('#section_holder').append(response).selectpicker('refresh');
            }
        });
           $('#section_holder').trigger("chosen:updated");
}
function onsectionchange(section_id)
{
    jQuery('#subject_holder').html('<option value="">Select Subject</option>');
    $.ajax({
            url: '<?php echo base_url();?>/index.php?teacher/get_teacher_subject/' + section_id,
            success: function (response)
            {
                jQuery('#subject_holder').append(response).selectpicker('refresh');
            }
        });
           $('#subject_holder').trigger("chosen:updated");
}

</script>