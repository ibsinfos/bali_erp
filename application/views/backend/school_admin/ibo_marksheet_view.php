<?php	
$system_name = $this->db->get_where('settings' , array('type'=>'system_name'))->row()->description;	
if (!empty($student_info)) {
?>
<div class="row">
	<div class="col-md-12 white-box">
		<table id="example23" class="display nowrap new_tabulation">
			<tr>
				<td><h3 style="font-weight: 100;"><?php echo $system_name;?></h3></td>
				<td><img src="uploads/logo.png" style="max-height : 60px;"></td>
			</tr>
			<tr>
				<td>
					<table>
						<tr>
							<td>
							<b>Class - <?php echo strtoupper($class_name) ;?> / Report Card</b>
							</td>
						</tr>
						<tr>
							<td>
							<b>Academic Year : <?php echo $student_info->academic_year  ?></b>
							</td>
						</tr>
					</table>
				</td>
				<td>
					<table>
						<tr>
							<td>
							<b>Student's Name : <?php echo $student_info->name.' '.$student_info->lname; ?></b>
							</td>
						</tr>
						<tr>
							<td>
							<b>Teacher Name </b>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<p>
						PERFORMANCE INDICATORS        The purpose of the report card is to communicate to students, parents, and staff the progress each student is making toward accomplishing performance-based standards.
					</p>
					<p>
						3+      =     Exceeds Standards - In addition to the 3, makes applications and interferences beyond expectations. <br/>
						3        =     Meeting Standards - Consistently and independently. <br/>
						2        =     Progressing towards meeting standards. <br/>	                                                
						1        =     Limited progress or does not meet standards. <br/>
						NA = Not assessed at this time. <br/>
						Q=Quarter<br/>

					</p>
				</td>
			</tr>

			<?php 
			foreach($subjects as $sub){ 
					$sub_id = $sub['subject_id'];
			?>
			<tr>
				<td colspan="2">
					<table class="table table-bordered responsive">
						<thead>
							<tr>
								<th width="40%"><?php echo ucwords($sub['name']); ?></th>
								<th width="15%">Q1</th>
								<th width="15%">Q2</th>
								<th width="15%">Q3</th>
								<th width="15%">Q4</th>
							</tr>
						</thead>
						<tbody>
						<?php //pre($subjAssessData).'<hr>'; //die();
						if(count(@$sub['asses_name'])){
							foreach($sub['asses_name'] as $k2 => $AssData){
						?>
							<tr>
								<td><?php echo ucwords($AssData); ?></td>
								<td><?php echo @$sub['MarksData'][$k2]; ?></td>
								<td>Q2</td>
								<td>Q3</td>
								<td>Q4</td>
							</tr>
						<?php } } 
?>
						</tbody>
					</table>
				</td>

				<!-- <td>
					<table class="table table-bordered responsive">
						<thead>
							<tr>
								<td><?php echo $sub['name']; ?></td>
								<td>Q1</td>
								<td>Q2</td>
								<td>Q3</td>
								<td>Q4</td>
							</tr>
						</thead>
					</table>
				</td> -->
			</tr>
			<?php } ?>
		</table>
	</div>
</div>


<?php
	}

?>
<!-- <div class="row">
	<div class="col-md-12 white-box">
		
	</div>
</div> -->