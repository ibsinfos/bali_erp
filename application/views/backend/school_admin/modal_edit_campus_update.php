<div class="modal-body">
    <?php echo form_open(base_url().'index.php?school_admin/campus_updates_management/edit/'.$row['notification_id'], array('class' =>'form-horizontal validate','id'=>'editCampusUpdateId', 'method' => 'POST'));?>
    <from class="form-horizontal form-material">
        <div class="form-group">
            <label class="col-md-12">Description</label>
            <div class="col-md-12 m-b-20">
                <textarea class="form-control" rows="2" placeholder="Add Campus Updates" name="notification"><?php echo $row['notification'];?></textarea>
            </div>                       
        </div>
        <div class="text-right">
            <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" name="save_details"><?php echo get_phrase('Update');?></button>
        </div>
    </from>     
    <?php echo form_close();?>
</div> 
