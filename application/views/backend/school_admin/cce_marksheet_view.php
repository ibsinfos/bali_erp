<?php	
$system_name = $this->db->get_where('settings' , array('type'=>'system_name'))->row()->description;	
if (!empty($student_info)) {
?>
<div class="row">
	<div class="col-md-12 white-box">
		<table id="example23" class="display nowrap new_tabulation">
			<tr>
				<td colspan="10"><h3 style="font-weight: 100;"><?php echo $system_name;?></h3></td>
				<td colspan="12"><img src="uploads/logo.png" style="max-height : 60px;"></td>
			</tr>
			<tr>
				<td colspan="13" align="center">
					<b>Academic Session : <?php echo $student_info->academic_year  ?></b>
				</td>
			</tr>
			<tr>
				<td colspan="13" align="center">
					<b>Report Card for class : <?php echo strtoupper($class_name) ;?></b>
				</td>
			</tr>
			<tr>
				<th align="left">Roll No. :</th>
				<td colspan="12"><?php echo $student_info->roll;  ?></td>
			</tr>
			<tr>
				<th align="left">Student's Name :</th>
				<td colspan="12"><?php echo $student_info->name.' '.$student_info->lname; ?></td>
			</tr>
			<tr>
				<th align="left">Father’s Name:</th>
				<td colspan="12"><?php echo $student_info->father_name.' '. $student_info->father_mname.' '.$student_info->father_lname;  ?></td>
			</tr>
			<tr>
				<th align="left">Mother’s Name:</th>
				<td colspan="12"><?php echo $student_info->mother_name.' '.$student_info->mother_mname.' '.$student_info->mother_lname;  ?></td>
			</tr>
			<tr>
				<th align="left">Date of Birth:</th>
				<td colspan="12"><?php echo $student_info->birthday;  ?></td>
			</tr>
			<tr>
				<th align="left">Class:</th>
				<td colspan="12"><?php echo $class_name ; ?></td>
			</tr>
			
		</table>
	</div>
</div>

<div class="row">
	<div class="col-md-12 white-box">
		<table class="table table-bordered responsive">
			<thead>
				<tr>
					<th>Scholastic Areas:</th>
					<th colspan="6" align="center">Term-1(100 marks)</th>
					<th colspan="6" align="center">Term-2(100 marks)</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Sub Name</td>
					<?php foreach ($subjAssessData as $assessment){ ?> 
					<td><?php echo $assessment['assessment_name'] ?></td>
					<?php } ?> 
					<!-- <td>Note Book(5)</td> 
					<td>Sub Enrichment(5)</td> --> 
					<td>Half Yearly Exam(80)</td> 
					<td style="text-align: center;">Marks obtained (100)</td> 
					<td>Grade</td>

					<?php foreach ($subjAssessData as $assessment){ ?> 
					<td><?php echo $assessment['assessment_name'] ?></td>
					<?php } ?>
					<td>Yearly Exam(80)</td> 
					<td>Marks obtained (100)</td> 
					<td>Grade</td> 
				</tr>

				<?php 
					//pre($subjects);
					foreach($subjects as $sub):
						$RowSum_1 = 0;
						$RowSum_2 = 0;
						$naFlag = '';
				?>
				<tr>
					<?php //if($sub['term'] == 1){ ?>
					<td><?php echo ucwords($sub['name']); ?></td>
					<td>
						<?php echo @$sub['mark_obtained'][0]; 
						 $RowSum_1+= @$sub['mark_obtained'][0]; 
						?>
					</td>
					<td>
						<?php echo @$sub['mark_obtained'][1]; 
						 $RowSum_1+= @$sub['mark_obtained'][1];
						?>
					</td>
					<td>
						<?php echo @$sub['mark_obtained'][2]; 
					     $RowSum_1+= @$sub['mark_obtained'][2];
					    ?>
					</td>
					<td>
						<?php echo @$sub['mark_obtained'][3]; 
					     $RowSum_1+= @$sub['mark_obtained'][3];
					    ?>
					</td>
					<td style="text-align: center;">
						<strong><?php echo round($RowSum_1, 2); ?></strong>
					</td>
					<?php
						if($RowSum_1<=100 && $RowSum_1>=91)
						{
							$grade='A1';
						}
						elseif($RowSum_1<=90 && $RowSum_1>=81)
						{
							$grade='A2';
						}
						elseif($RowSum_1<=80 && $RowSum_1>=71)
						{
							$grade='B1';
						}
						elseif($RowSum_1<=70 && $RowSum_1>=61)
						{
							$grade='B2';
						}
						elseif($RowSum_1<=60 && $RowSum_1>=51)
						{
							$grade='C1';
						}
						elseif($RowSum_1<=50 && $RowSum_1>=41)
						{
							$grade='C2';
						}
						elseif($RowSum_1<=40 && $RowSum_1>=33)
						{
							$grade='D';
						}
						elseif($RowSum_1<=32 && $RowSum_1>=0 && $naFlag != 'N/A')
						{
							$grade='E';
						} else {
							$grade = "N/A";
						}
					?>
					<td><strong><?php echo $grade; ?></strong></td>
					<?php //} ?>
					<td>
						<?php echo @$sub['mark_obtained'][4]; 
						 $RowSum_2+= @$sub['mark_obtained'][4]; 
						?>
					</td>
					<td>
						<?php echo @$sub['mark_obtained'][5]; 
						 $RowSum_2+= @$sub['mark_obtained'][5];
						?>
					</td>
					<td>
						<?php echo @$sub['mark_obtained'][6]; 
					     $RowSum_2+= @$sub['mark_obtained'][6];
					    ?>
					</td>
					<td>
						<?php echo @$sub['mark_obtained'][7]; 
					     $RowSum_2+= @$sub['mark_obtained'][7];
					    ?>
					</td>
					<td style="text-align: center;">
						<strong><?php echo round($RowSum_2, 2); ?></strong>
					</td>
					<?php
						if($RowSum_2<=100 && $RowSum_2>=91)
						{
							$grade='A1';
						}
						elseif($RowSum_2<=90 && $RowSum_2>=81)
						{
							$grade='A2';
						}
						elseif($RowSum_2<=80 && $RowSum_2>=71)
						{
							$grade='B1';
						}
						elseif($RowSum_2<=70 && $RowSum_2>=61)
						{
							$grade='B2';
						}
						elseif($RowSum_2<=60 && $RowSum_2>=51)
						{
							$grade='C1';
						}
						elseif($RowSum_2<=50 && $RowSum_2>=41)
						{
							$grade='C2';
						}
						elseif($RowSum_2<=40 && $RowSum_2>=33)
						{
							$grade='D';
						}
						elseif($RowSum_2<=32 && $RowSum_2>=0 && $naFlag != 'N/A')
						{
							$grade='E';
						} else {
							$grade = "N/A";
						}
					?>
					<td><strong><?php echo $grade; ?></strong></td> 
					
				</tr>
					<?php
						endforeach;
					?>
					
				</tbody>

		</table>
		<div class="text-right col-xs-12 p-t-20">
		<a href="<?php echo base_url(); ?>index.php?school_admin/cce_report_card" class="fcbtn btn btn-danger btn-outline btn-1d" id="submit_button"><?php echo get_phrase('other_report_cards');?></a>

            <a href="<?php echo base_url(); ?>index.php?school_admin/exam_settings" class="fcbtn btn btn-danger btn-outline btn-1d" id="submit_button"><?php echo get_phrase('back_to_exam_settings');?></a>
        </div>
	</div>
</div>
<?php
	}

?>