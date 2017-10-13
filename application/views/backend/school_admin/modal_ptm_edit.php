<?php
    $ptm_data = $this->db->get_where('parrent_teacher_meeting_date',array('parrent_teacher_meeting_date_id' => $param2))->result_array();    
    $ptm_class = $this->db->get_where('class', array('class_id'=>$ptm_data[0]['class_id']))->row()->name;
    $ptm_section = $this->db->get_where('section', array('section_id'=>$ptm_data[0]['section_id']))->row()->name;  
       
?>
<script type="text/javascript" src="http://jonthornton.github.io/jquery-timepicker/jquery.timepicker.js"></script>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title" >
                    <i class="entypo-plus-circled"></i>
                    <?php echo get_phrase('edit_PTM_date'); ?>
                </div>
            </div>
            <div class="panel-body">
                <?php echo form_open(base_url() . 'index.php?school_admin/ptm_settings/edit/' . $param2, array('class' => 'form-horizontal form-groups-bordered', 'enctype' => 'multipart/form-data')); ?>
                <div class="form-group">                    
                    <label class="col-sm-3 control-label"><?php echo get_phrase('class'); ?></label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="class" value="<?php echo $ptm_class;?>" readonly/>
                    </div>
                </div>
                <div class="form-group">                    
                    <label class="col-sm-3 control-label"><?php echo get_phrase('section'); ?></label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="section" value="<?php echo $ptm_section;?>" readonly/>
                    </div>
                </div>
                <div class="form-group">                    
                    <label class="col-sm-3 control-label"><?php echo get_phrase('select_date'); ?></label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control datepicker"  name="date_select" value="<?php echo $ptm_data[0]['meeting_date'];?>" placeholder="Pick a date" data-validate="required" data-message-required ="Please pick a date">
                    </div>
                </div>
                
                <div class="form-group">
                        <div class="offset-sm-5 col-sm-10">                        
                            <button type="submit" name= "edit_ptm" value="submit_ptm" class="btn btn-success"   id="edit_ptm"><i class="fa fa-edit"></i> Edit</button>
                        
                        </div>
                    </div>
                
               <?php echo form_close(); ?>
            </div>
        </div>   
    </div>
</div>
    