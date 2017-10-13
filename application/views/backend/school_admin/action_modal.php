<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title" >
                    <i class="entypo-plus-circled"></i>
                    <?php echo get_phrase('add_new_incident'); ?>
                </div>
            </div>
            <a href="add_category.php"></a>
            <div class="panel-body">

                <?php echo form_open(base_url() . 'index.php?school_admin/disipline/create/', array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data','target' => '_top')); ?>

                <div class="form-group">
                    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Designation_of_person'); ?></label>
                    <div class="col-sm-5">
                          <input type="text" class="form-control" name="room_no"  data-validate="required" value="" >
                    </div>
                    
                </div>
                <div class="form-group">
                    <label for="field-2" class="col-sm-3 control-label" style="padding-top:0px;"><?php echo get_phrase('Method'); ?></label>

                    <div class="col-sm-2">
                        <input type="checkbox" name="vehicle" value=""> Verbal
                         
                    </div> 
                    <div class="col-sm-3">
                        <input type="checkbox" name="vehicle" value=""> Application</div>
                   
                </div>
                
                <div class="form-group">
                    <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('Parent_need_to_be_notify'); ?></label>

                    <div class="col-sm-5">
                        
                        <input type="text" class="form-control" name="room_no"  data-validate="required" value="" >
                        
                    </div> 
                    
                </div>
                
                 <div class="form-group">
                    <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('Judgement'); ?></label>

                    <div class="col-sm-5 form-group">
                      
                    <input type="file" name="userfile" id="userfile" class="form-control bor_no_here required" data-validate="required">
                   
           
                    </div> 
                </div>

               <div class="form-group">
                    <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('Status'); ?></label>
                    <div class="col-sm-5">
                        <select  class="selectpicker" data-style="form-control" data-live-search="true">
                            <option>Select</option>
                            <option>Open</option>
                            <option>Close</option>
                        </select>
                    </div>
           
                </div>
                <div class="form-group">
                    <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('Investigation_Comment'); ?></label>
                    <div class="col-sm-5"><textarea></textarea></div>
           
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-5">
                        <button type="submit" class="btn btn-info"><?php echo get_phrase('action'); ?></button>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>