<div class="row bg-title"> 
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
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
</div>



<div class="col-md-12 white-box">
	<?php echo form_open(base_url() . 'index.php?school_admin/tabulation_sheet');?>
    <div class="col-sm-4 form-group">
    <div class="form-group col-sm-12 p-0" data-step="5" data-intro="<?php echo get_phrase('Here you select class for which you want to see tabulation sheet.');?>" data-position='top'>
    <label class="control-label"><?php echo get_phrase('class');?></label><span class="error mandatory"> *</span>
    <select name="class_id" onchange="return onclasschange(this.value);" class="selectpicker" data-style="form-control"  data-live-search="true">
        <option value=" "><?php echo get_phrase('select_class');?></option>
        <?php 
        foreach($classes as $row): ?>
            <option value="<?php echo $row['class_id'];?>">           
                        <?php echo $row['name'];?>
            </option>
        <?php
        endforeach; ?>
    </select>
    </div>
    </div>

    <div class="col-sm-4 form-group">
	<div class="form-group col-sm-12 p-0"  data-step="6" data-intro="<?php echo get_phrase('Here you section section for which you want to see tabulation sheet.');?>" data-position='top'>

        <label class="control-label"><?php echo get_phrase('select_section');?></label><span class="error mandatory"> *</span>
        <select id="section_holder" name="section_id" class="selectpicker" data-style="form-control" data-live-search="true">
        <option value=" ">Select Section</option>
            <?php if(isset($formSubmit)) {  $selected       =   ''; 
            foreach($sections as $key) { 
                $selected = ($section_id == $key['section_id'] ? 'selected' : '' ); ?>
            <option <?php echo $selected ?> value="<?php echo $key['section_id']; ?>"><?php echo $key['name']; ?></option> 
            <?php } } else { ?>
            <option value=""><?php echo get_phrase('select_class_first'); ?></option><?php } ?>
        </select>
	</div>
    </div>
    
    <div class="col-sm-4 form-group">
	<div class="form-group col-sm-12 p-0"  data-step="7" data-intro="<?php echo get_phrase('Here you select exam for which you want to see tabulation sheet.');?>" data-position='top'>
	<label class="control-label"><?php echo get_phrase('exam');?></label><span class="error mandatory"> *</span>
	<select name="exam_id" class="selectpicker" data-style="form-control"  data-live-search="true">
            <option value=""><?php echo get_phrase('select_exam');?></option>
            <?php foreach($exams as $row):?>
                <option value="<?php echo $row['exam_id'];?>"><?php echo $row['name'];?> </option>
            <?php endforeach;?>
        </select>
        </div>
    </div>

    <input type="hidden" name="operation" value="selection">
    <div class="text-right col-xs-12">
    <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" ><?php echo get_phrase('view_tabulation_sheet');?></button>
    </div>
<?php echo form_close();?>

</div>


<?php if (!empty($class_id)):?>

    <div class="col-md-12 white-box">
        <div class="text-center">
            <h3>
        <?php  echo get_phrase('tabulation_sheet');  ?>
        <?php echo get_phrase('class') . ' ' . $class_name[0]->name.'-'.$section_name;?> : <?php echo $exam_name;?>
           </h3> </div>
		<table id="example23" class="display nowrap new_tabulation">
			<thead>
				<tr>
				<td class="text-center">
                                    <?php echo get_phrase('students');?> <i class="entypo-down-thin"></i> | <?php echo get_phrase('subjects');?> <i class="entypo-right-thin"></i>
				</td>
				<?php 
                                foreach($subjects as $row):
				?>
				<td class="text-center"><?php echo $row['name'];?></td>
				<?php endforeach;?>
				<td class="text-center"><?php echo get_phrase('total');?></td>
                                <td class="text-center"><?php echo get_phrase('maximum_marks');?></td>
				<td class="text-center"><?php echo get_phrase('average_grade_point');?></td>
				</tr>
			</thead>
			<tbody>
			<?php
				if(count($students)):
                    foreach($students as $row):
			?>
				<tr>
					<td class="text-center">
						<?php 
                                                
                        $student_id = $row['student_id'];
                        echo $arrStudentName[$student_id]." ";
                        ?>
					</td>
				<?php
					$total_marks = 0;
					$total_grade_point = 0; 
                    $maximum_marks=0;
                    //pre($subjects); die();
                    if(count($subjects)):
					foreach($subjects as $row2):
                        $stu_id = $student_id;
                        $sub_id = $row2['subject_id'];
                ?>
					<td class="text-center">
						<?php 
						    $obtained_mark_query = $arrStudentMarks[$stu_id][$sub_id];
                            //pre($obtained_mark_query); die();
                            //echo count($obtained_mark_query); die();
                            if ( count($obtained_mark_query) > 0) {
                                $obtained_marks = $obtained_mark_query[0]['mark_obtained'];
                                echo $obtained_marks;
                                $max_marks=$obtained_mark_query[0]['mark_total'];
                                
                                if ($obtained_marks >= 0 && $obtained_marks != '') {
                                        $grade = $this->crud_model->get_grade($obtained_marks);
                                         //pre($grade);
                                        //foreach ($grade as $row){
                                           
                                            if ($obtained_marks >= $grade['mark_from'] && $obtained_marks <= $grade['mark_upto']){

                                                $total_grade_point = $grade['grade_point'];
                                            }
                                       // }
                                        //echo $this->db->last_query(); die();
                                        $total_grade_point += $grade['grade_point'];
                                }
                                $total_marks += $obtained_marks;
                                $maximum_marks+= $max_marks;
                            }
						?>
					</td>
				<?php endforeach; endif;?>
				<td class="text-center"><?php echo $total_marks;?></td>
                                <td class="text-center"><?php echo $maximum_marks?></td>
				<td class="text-center">
					<?php 
                                            $this->db->where('class_id' , $class_id);
                                            $this->db->where('year' , $running_year);
                                            $this->db->from('subject');
                                            $number_of_subjects = $this->db->count_all_results();
                                            //echo $number_of_subjects;
                                            //echo $total_grade_point;
                                            echo ($total_grade_point / $number_of_subjects);
					?>
				</td>
				</tr>

			<?php endforeach; endif;?>

			</tbody>
		</table>

</div>


<?php endif;?>
<script>
function onclasschange(class_id)
{
    //alert(class_id.value);
    jQuery('#section_holder').html('');
    $.ajax({
            url: '<?php echo base_url();?>index.php?school_admin/get_class_section/' + class_id,
            success: function (response)
            {
                jQuery('#section_holder').append(response).selectpicker('refresh');
            }
        });
           $('#section_holder').trigger("chosen:updated");
}    
    
</script>