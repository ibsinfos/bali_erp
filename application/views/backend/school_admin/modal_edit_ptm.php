<div class="modal-body">  
    <?php echo form_open(base_url(). 'index.php?school_admin/ptm_settings/edit/'.$edit_data[0]['parrent_teacher_meeting_date_id'] , array('class' => ' validate','target'=>'_top'));?>
    <from class="form-horizontal form-material">
        <div class="form-group">            
                    
            <div class="col-sm-12 m-b-20">
                <label>Select Class</label>
                <select class="selectpicker" data-style="form-control" data-live-search="true" disabled>
                    <option value=""><?php echo get_phrase('select_class'); ?></option>
                        <?php foreach ($classes as $row): 
                        if(!empty($edit_data[0]['class_id'])){?>
                        <option value="<?php echo $row['class_id']; ?>"<?php if ($edit_data[0]['class_id'] == $row['class_id']){echo 'selected';}?>><?php echo $row['name']; ?></option>
                        <?php } else{ ?>
                        <option value="<?php echo $row['class_id']; ?>"><?php echo $row['name']; ?></option>
                        <?php } endforeach; ?>
                </select>
            </div>
            <div class="col-sm-12 m-b-20">
                <label>Select Section</label>
                <select class="selectpicker" data-style="form-control" data-live-search="true" disabled >
                    <option value=""><?php echo get_phrase('select_section'); ?></option>
                        <?php foreach ($sections as $row): 
                        if(!empty($edit_data[0]['class_id'])){?>
                        <option value="<?php echo $row['section_id']; ?>"<?php if ($edit_data[0]['section_id'] == $row['section_id']){echo 'selected';}?>><?php echo $row['name']; ?></option>
                        <?php } else{ ?>
                        <option value="<?php echo $row['section_id']; ?>"><?php echo $row['name']; ?></option>
                        <?php } endforeach; ?>
                </select>
            </div>
            <div class="col-sm-12 m-b-20">
                <label>Select Exam</label>
                <select  class="selectpicker1" data-style="form-control" data-live-search="true" disabled>
                    <option value=""><?php echo get_phrase('select_exam'); ?></option>
                        <?php foreach ($exams as $row): 
                        if(!empty($edit_data[0]['exam_id'])){?>
                        <option value="<?php echo $row['exam_id']; ?>"<?php if ($edit_data[0]['exam_id'] == $row['exam_id']){echo 'selected';}?>><?php echo $row['name']; ?></option>
                        <?php } else{ ?>
                        <option value="<?php echo $row['exam_id']; ?>"><?php echo $row['name']; ?></option>
                        <?php } endforeach; ?>
                </select>
            </div>
            <div class="col-md-12 m-b-20">
                <label>Select Date</label>
                <input type="text" id = "ptm_date" class="form-control mydatepicker"  name="date_select" value="<?php echo $edit_data[0]['meeting_date'];?>" data-validate="required" data-message-required="Please pick a date">
            </div> 
        </div>
        <div class="text-center">
            <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" name="save_details"><?php echo get_phrase('update');?></button>
        </div>
        
    </from>
    <?php echo form_close();?>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#ptm_date').datepicker({
            format: "yyyy-mm-dd"
        });
   });
</script>