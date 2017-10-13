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




<?php echo form_open(base_url() . 'index.php?school_admin/exam_routine/get_subjects',array('class' => 'validate', 'id'=>'exam_routine_form'));?>

    <div class="col-sm-12 white-box">
	<div class="col-sm-4 form-group">
	    <div class="form-group col-sm-12 p-0" data-step="5" data-intro=" <?php echo get_phrase('Select a exam, for which you want to create exam routine.');?>" data-position='right'>
		<label class="control-label" ><?php echo get_phrase('exam');?></label><span class="error" style="color: red;"> *</span>
			<select name="exam_id" class="selectpicker" data-style="form-control" onchange="select_classes_for_exam(this.value)" data-live-search="true" required="required">

            <option value="">
                <?php echo get_phrase('select_exam');?>
            </option>
				<?php
                
				foreach($exams as $row):
				?>
                    <option value="<?php echo $row['exam_id'];?>"
                        <?php if((isset($exam_id)) && $exam_id == $row['exam_id']){ echo 'selected="selected"';}?> > <?php echo $row['name'];?>
                    </option>
				<?php endforeach; ?>
			</select>
	    </div>
		
	</div>

	<div class="col-sm-4 form-group">
	    <div class="form-group col-sm-12 p-0" data-step="6" data-intro="<?php echo get_phrase('Select a class, for which you want to create exam routine.');?>" data-position='right'>
		<label class="control-label" ><?php echo get_phrase('class');?></label><span class="error" style="color: red;"> *</span>
		<select name="class_id" class="selectpicker" data-style="form-control" data-live-search="true" id="class_id" required="required">
				<option value="">
                    <?php echo get_phrase('select_class');?>
                </option>
				<?php
                if(isset($exam_id)){
                    foreach($classes as $row):
                ?>
                    <option value="<?php echo $row['class_id'];?>">
                        <?php echo $row['name'];?>
                    </option>
                <?php endforeach; }?>
			</select>
	    </div>
	</div>

        <div class="col-sm-4 form-group">
	    <div class="form-group col-sm-12 p-0" data-step="7" data-intro="<?php echo get_phrase('Select a section, for which you want to create exam routine.');?>" data-position='left'>
                <label class="control-label" ><?php echo get_phrase('section');?></label><span class="error" style="color: red;"> *</span>
                        <select name="section_id" id="section_id" class="selectpicker" data-style="form-control" data-live-search="true" required="required">
                            <option value=""><?php echo get_phrase('select_section');?></option>    
                            <?php 
                                //foreach($sections as $row):
                                ?>
                            <!-- <option value="<?php echo $row['section_id'];?>" 
                                <?php if($section_id == $row['section_id']) echo 'selected';?>>
                                    <?php echo $row['name'];?>
                            </option> -->
                                <?php //endforeach;?>
                        </select>
	    </div>   
        </div>
    
        <div class="text-right col-xs-12">
	    
            <button type="button" data-step="8" data-intro="<?php echo get_phrase('Click here to create a exam routine.');?>" data-position='left'class="fcbtn btn btn-danger btn-outline btn-1d" onclick="get_class_subjects()"><?php echo get_phrase('manage_exam_routine');?></button>
       </div>
	
    </div>

<?php echo form_close();?>

<div class="form-group col-sm-12 p-0" data-step="9" data-intro="<?php echo get_phrase('From here you can manage the class routine.');?>" data-position='top'>
    <div id="exam_subjects">
	
    </div>
</div>
<script type="text/javascript">
        $("#class_id").change(get_class_section);
	function get_class_section() {	
        var class_id = $(this).val();    
	$.ajax({
            url: '<?php echo base_url();?>index.php?school_admin/get_class_section/' + class_id ,
            success: function(response)
            {
                jQuery('#section_id').html(response).selectpicker('refresh');
            }
        });

	}
        
        function get_class_subjects()
        {
           
          $.ajax({
            url: '<?php echo base_url();?>index.php?school_admin/get_exam_subject/',
           type: "POST",
            data:$("#exam_routine_form").serialize(),
            success: function(response)
            {
                
                jQuery('#exam_subjects').html(response);
            }
        });
        
        }

        
        function select_classes_for_exam(exam_id) {
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?Ajax_controller/get_class_by_exams/' + exam_id,
            success:function (response){//alert(response);
                jQuery('#class_id').html(response).selectpicker('refresh');
            }
        });
    }
</script>
