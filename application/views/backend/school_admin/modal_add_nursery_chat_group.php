<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title" >
                    <i class="entypo-plus-circled"></i>
                    <?php echo get_phrase('add_kindergarden_nursery_chat_group'); ?>
                </div>
            </div>
            <div class="panel-body">
                <?php echo form_open(base_url() . 'index.php?school_admin/manage_nursery_chat_group/create', array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top')); ?>
                <div class="form-group">
                    <label for="categoriesName" class="col-sm-4 control-label">Chat Group Name: </label>
                    <label class="col-sm-1 control-label">: </label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="group_name" placeholder="Enter chat group name" name="group_name" autocomplete="off" required="required">
                        </div>
                </div> 
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-5">
                        <button type="submit" class="btn btn-info"><?php echo get_phrase('add_group'); ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




