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
					<th>Subjects:</th>
					<th colspan="3" align="center">Term-1(100 marks)</th>
					<th colspan="3" align="center">Term-2(100 marks)</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Sub Name</td> 
					<td>Internal</td> 
					<td>External</td> 
					<td>Total</td> 
					
					<td>Internal</td> 
					<td>External</td> 
					<td>Total</td> 
					
				</tr>

				<?php foreach($subjects as $sub){ 
						$Total = 0;
					?>
				<tr>
					<td><?php echo $sub['name']; ?></td>
				<?php if(count($marks[$sub['subject_id']])>0) { 
						for($m=0;$m<count($marks[$sub['subject_id']]);$m++) {
					?>
					<td>
					<?php 
					if(isset($marks[$sub['subject_id']][$m]['mark_obtained'])){
						$mark = $marks[$sub['subject_id']][$m]['mark_obtained'];
					}else{
						$mark = 'NA';
					}
					if($mark!=''){
						echo $mark;
					}
					else{
						echo 'NA';
					}
					$Total+=$mark;
					?></td>
					<?php } } else { 
						for($n=0;$n<4;$n++) {
							$flag=1;
					?>
					<td>&nbsp;</td>
					<?php } } ?>
				</tr>
				<?php } ?>
				</tbody>
		</table>
	</div>
</div>
<?php
	}

?>