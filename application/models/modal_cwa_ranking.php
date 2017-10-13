<?php
   // $cce_record = $this->class_model->get_fa_settings(array("parent_id" => $param2));
   $row = 1;
    if (!empty($row))
    {
        ?>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary" data-collapsed="0">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-plus-circled"></i>
                            <?php echo get_phrase('set_cwa_ranking_level'); ?>
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php echo form_open(base_url() . 'index.php?admin/cce_settings/fa_max' ); ?>

                        <div class="form-group">
                            <label for="field-1" class="col-sm-1 control-label"><?php echo get_phrase("maximum_marks"); ?></label>
                            <div class="col-sm-3" >
                                <input type="text" class="form-control" name="maxmarks" value="<?php echo $param2;?>" required>
                            </div>
                           
                        </div>
                
                
                        
                        <div class="row">
                            <div class="form-group">
                            <div class="col-sm-offset-5 col-sm-5" style="margin: 20px 0px 15px 10px;">
                                <button type="submit" class="btn btn-primary" style="height: 40px; width: 100px;"><?php echo get_phrase('save');?></button>
                            </div>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>