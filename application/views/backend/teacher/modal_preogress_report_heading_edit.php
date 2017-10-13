<!--to be deleted-->
<?php 
$edit_data		= $this->db->get_where('progress_report_heading' , array('heading_id' => $param2))->result_array();
foreach ($edit_data as $row):
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"><?php echo get_phrase('edit_assessment'); ?></h4>
            </div>
<div class="panel-body">
				
                <?php echo form_open(base_url() . 'index.php?teacher/progress_report_heading_setting_function/do_update/'.$row['heading_id'].'/'.$row['class_id'], array('class' => 'form-material form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
                		     <div class="form-group"> 
                <div class="col-md-6 m-b-20">
                    <textarea class="form-control" rows="5" id="heading" name="heading" data-validate="required" placeholder="Enter Heading" data-message-required="<?php echo get_phrase('value_required'); ?>"><?php echo $row['heading_description'];  ?></textarea>
			
                </div>	
                                     </div>
					
                <div class="form-group">
                            <div class="col-xs-12 text-right">
                                <!--<button type="submit" class="btn btn-info waves-effect" data-dismiss="modal">Save</button>-->
                                <input  type="submit" name="edit_hostel_room" id="edit_hostel_room" class="fcbtn btn btn-danger btn-outline btn-1d" value="Update"/>
                                <!--<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancel</button>-->
                            </div>
                </div>
                    
                <?php echo form_close();?>
            </div>
        </div>
    </div>
</div>

<?php
endforeach;
?>


