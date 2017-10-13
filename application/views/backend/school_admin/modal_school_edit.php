
<!--//$rs=$this->db->get_where('device',array("Device_ID" => $param2))->result();-->
<div class="modal-body">
<?php if(!empty($details)){ ?>

    <?php echo form_open(base_url() . 'index.php?school_admin/add_school/do_update/'.$details->id , array('class' => 'validate', 'enctype' => 'multipart/form-data'));?>
    <div class="form-horizontal form-material">
        <div class="form-group">
            <div class="col-md-12 m-b-20">
            <label>School Name</label>
            <input type="text" class="form-control" name="school_name" required value="<?php echo $details->school_name; ?>" >
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12 m-b-20">
            <label>Database Name</label>
            <input type="text" class="form-control" name="db_name" required value="<?php echo $details->db_name; ?>">
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12 m-b-20">
            <label>Allot SMS</label>
            <input type="text" class="form-control" name="allot_sms" required value="<?php echo $details->allot_sms; ?>">
            </div>
        </div>
        
        <div class="text-right">
            <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('update');?></button>
        </div>
    </div>
    <?php echo form_close();?>
<?php } else{echo "No Data Availble";} ?>
</div>

