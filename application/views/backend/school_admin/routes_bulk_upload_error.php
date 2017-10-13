
<div class ="row"> 
<div class="col-md-12">
<blockquote class="blockquote-danger">
    <p>
        <strong>Error While Uploading the Data: </strong>
        The current Route bulk upload has some invalid data, please click on the below link to get the error details.
    </p>
</blockquote>
</div>
  </div>
<?php echo form_open(base_url().'index.php?school_admin/routes_display_bulk_upload_errors', array('class' =>'form-group','id'=>'displayBulkUploadErrorsId'));?>
<div class ="row">
    <div class="form-group row">
        <div class="col-md-12">
            <button type="submit" class="btn btn-success">Display Errors</button>
            <a href="<?php echo base_url(); ?>index.php?school_admin/bulk_upload" class="btn btn-primary">
                     <i class="entypo-plus-circled"></i>
                     <?php echo get_phrase('go_to_bulk_upload'); ?>
            </a> 
        </div>

<div class ="row">
    <div class="col-md-12" style="margin-top: 30px"></div>    
<div class="col-md-12">
<blockquote class="blockquote-danger">
    <p style="font-size: 20px;">
        
        <strong>Error While Uploading the Data: </strong>
    </p>
</blockquote>
</div>
    <div class="col-md-12 alert alert-info" style="margin-top: 50px;margin-left: 15px;">
        <i class="fa fa-info-circle" aria-hidden="true"></i> 
        The current route bulk upload has some invalid data, please click on the below link to get the error details.</div>    
  </div>
<?php echo form_open(base_url().'index.php?school_admin/routes_display_bulk_upload_errors', array('class' =>'form-group','id'=>'displayBulkUploadErrorsId'));?>
<div class ="row">
    <div class="col-md-12"><button type="submit" class="btn btn-success">Display Errors</button></div>
</div>
<div class="row">
    <div class="col-md-12" style="padding: 20px 15px;">
        <button type="button" class="btn btn-success" onclick="location.href='<?php echo base_url().'index.php?school_admin/download_routes_bulk_upload_error_file';?>';">Download Excel File</button>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <a href="<?php echo base_url(); ?>index.php?school_admin/bulk_upload" class="btn btn-primary">
            <i class="entypo-plus-circled"></i>
            <?php echo get_phrase('go_to_bulk_upload'); ?>
        </a>

    </div>
</div>
<?php echo form_close();?>




