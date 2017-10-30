<div class="modal-body">
    <?php echo form_open(base_url().'index.php?school_admin/campus_updates_management/create', array('class' =>'validate','id'=>'addCampusupdates', 'method' => 'POST'));?>
    <div class="form-horizontal form-material">
        <div class="form-group">
            <div class="col-md-12 m-b-20">
            <label>Add New Campus Updates</label>
            <textarea class="form-control" rows="3" name="notification"></textarea>                      
            </div>
        </div>
        <div class="text-right">
            <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" id="sa-success" name="save_details"><?php echo get_phrase('add_campus_update');?></button>
        </div>
    </div>
    <?php echo form_close();?>
</div>
