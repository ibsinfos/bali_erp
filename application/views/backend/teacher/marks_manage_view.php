<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12"><h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?teacher/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active">
                <?php echo get_phrase('manage_marks'); ?>
            </li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>
     
<input type='hidden' id='selected_class' value="<?php echo $class_id; ?>">
       <input type='hidden' id='selected_section' value="<?php echo $section_id; ?>">
       <input type='hidden' id='selected_exam' value="<?php echo $exam_id; ?>">
       <input type='hidden' id='selected_subject' value="<?php echo $subject_id; ?>">
<?php echo form_open(base_url() . 'index.php?teacher/marks_selector');?>
	    <div class="col-md-12 white-box">	
			<div class="col-sm-3 form-group" data-step="5" data-intro="<?php echo get_phrase('Please Select Your Exam ');?>" data-position='bottom'>
				<label class="control-label"><?php echo get_phrase('exam');?></label><span class="mandatory">*</span>
				<select name="exam_id" data-style="form-control" data-live-search="true" class="selectpicker" required>
	<?php if(count($exams)){ foreach($exams as $row):?>
					<option value="<?php echo $row['exam_id'];?>"
						<?php if($exam_id == $row['exam_id']) echo 'selected';?>><?php echo $row['name'];?></option>
					<?php endforeach; }?>
				</select>		
			</div>

			<div class="col-sm-3 form-group" data-step="6" data-intro="<?php echo get_phrase('Please Select Your Class ');?>" data-position='bottom'>
				<label class="control-label"><?php echo get_phrase('class');?></label><span class="mandatory">*</span>
				<select name="class_id" data-style="form-control" data-live-search="true" class="selectpicker" onchange="get_class_subject(this.value)">
					<option value=""><?php echo get_phrase('select_class');?></option>
<?php if(count($classes)){ foreach($classes as $row): ?>
					<option value="<?php echo $row['class_id'];?>"
						<?php if($class_id == $row['class_id']) echo 'selected';?>><?php echo $row['name'];?></option><?php endforeach; }?>
				</select>
			</div>

			<div id="col-md-6">
				<div class="col-md-3 col-sm-6 col-xs-12">
					<div class="form-group" data-step="7" data-intro="<?php echo get_phrase('Please Select Your Section ');?>" data-position='bottom'>				<label class="control-label"><?php echo get_phrase('section');?></label><span class="mandatory">*</span>					        <select name="section_id" id="section_id" data-style="form-control" data-live-search="true" class="selectpicker">
<?php if(count($sections)){ foreach($sections as $row): ?>
					<option value="<?php echo $row->section_id; ?>" <?php if($section_id == $row->section_id) echo 'selected';?>><?php echo $row->name;?></option>
							<?php endforeach; }?>
						</select>
					</div>
				</div>
		    
				<div class="col-md-3 col-sm-6 col-xs-12">
					<div class="form-group" data-step="8" data-intro="<?php echo get_phrase('Please Select Your Subject');?>" data-position='bottom'>				    
						<label class="control-label"><?php echo get_phrase('subject');?></label><span class="mandatory">*</span>				
						<select name="subject_id" id="subject_id" class="selectpicker" data-style="form-control">
<?php if(count($sections)){ foreach($subjects as $row): ?>
							<option value="<?php echo $row->subject_id;?>" <?php if($subject_id == $row->subject_id) echo 'selected';?>> <?php echo $row->name;?></option><?php endforeach; }?>
						</select>
					</div>
				</div>
		    </div>
		    
			<div class="text-right col-xs-12">
				<button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('manage_marks');?></button>
			</div>
		</div>

<?php echo form_close();?>

<?php echo form_open(base_url() . 'index.php?teacher/marks_update/'.$exam_id.'/'.$class_id.'/'.$section_id.'/'.$subject_id);?>
	    <div class="col-md-12 no-padding">
			<div class="col-md-3 no-padding m-b-10" data-step="9" data-intro="<?php echo get_phrase('Maximum Marks');?>" data-position='bottom'>
				<label class="control-label"><?php  echo get_phrase('maximum_marks'); ?></label>
	    		<input type="text" class="form-control" name="maximum_marks" value="<?php if(!empty($marks_of_students)){ echo $marks_of_students[0]['mark_total'];}else{echo 0;} ?>" data-validate="required" data-message-required ="Please select maximum marks">
			</div>	
	    </div>               	
	
	    <div class="col-md-12 white-box" data-step="10" data-intro="<?php echo get_phrase('Manage Marks of Students');?>" data-position='top'>
	    	 <div class="text-center m-b-20">
             <h3><?php echo get_phrase('marks_for_').$exam_name.get_phrase(' class ').$class_name.' : '.get_phrase(' section ').$section_name.get_phrase(' subject ').' : '.$subject_name;?></h3>
            </div>
                 <table id="table" class="table display" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th><div><?php echo get_phrase('serial_no.');?></div></th>
						<th><div><?php echo get_phrase('roll');?></div></th>
						<th><div><?php echo get_phrase('name');?></div></th>
						<th class="marks"><div><?php echo get_phrase('marks_obtained');?></div></th>
						<th class="comments"><div><?php echo get_phrase('comment');?></div></th>
					</tr>
				</thead>
				<tbody>
				</tbody>
		    </table>

			<div class="text-right col-xs-12 p-t-20">
				<button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" id="submit_button">
					<i class="entypo-check"></i> <?php echo get_phrase('save_changes');?>
				</button>
			</div>		
		</div>

<?php echo form_close();?>
<script type="text/javascript">
	function get_class_subject(class_id) {
		
		$.ajax({
            url: '<?php echo base_url();?>index.php?teacher/marks_get_subject/' + class_id ,
            success: function(response)
            {
                jQuery('#subject_holder').html(response).selectpicker('refresh');
            }
        });

	}

	
</script>
<script type='text/javascript'> 
       var class_id = $("#selected_class").val();
       var section_id = $("#selected_section").val();
       var exam_id = $("#selected_exam").val();
       var subject_id = $("#selected_subject").val();

    var table;
    $(document).ready(function() {
        table = $('#table').DataTable({ 
            "dom": 'Bfrtip',
            "responsive": true,
            "buttons": [
                "pageLength",
                'copy', 'excel', 'pdf', 'print'
            ],

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
           
            "ajax": {
                "url": "<?php echo base_url(); ?>index.php?ajax_controller/marks_manage_list_teacher_login/",
                "type": "POST",
                data : { class_id:class_id,section_id:section_id, exam_id:exam_id, subject_id:subject_id},
                "dataSrc": function (data) {
                    setTimeout(function () {
                        $('[data-toggle="tooltip"]').tooltip();
                    }, 0);
                    return data.data;
            }
            },

            //Set column definition initialisation properties.
            "columnDefs": [
                { "targets": [0,3,4], "orderable": false },                 
            ],

        });
        table.$('tr').tooltip( {selector: '[data-toggle="tooltip"]'});
        
    }); 
</script>