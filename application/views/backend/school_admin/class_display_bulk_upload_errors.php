
<div class="row" style="padding: 20px 0;">
    <div class="col-md-12">
        <button type="button" class="btn btn-success" onclick="location.href='<?php echo base_url().'index.php?school_admin/download_class_bulk_upload_error_file';?>';">Download Excel File</button>
    </div>
</div>

<table class="table table-bordered" id="">
    <thead>
        <tr>
            <th width="80"><div><?php echo get_phrase('#'); ?></div></th>                            
            <th><div><?php echo get_phrase('errors_found_while_uploading'); ?></div></th>
        </tr>
    </thead>  
      
    <tbody>
        <?php 
        $count = 1;

        foreach($messages as $msg){            
        ?>
        <tr>
            <td><div><label><?php echo $count++ ;?></label></div></td>
            <td><div><label><span class="error" style="color: red;"> <?php echo $msg;?></span></label></div></td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<div class="row">
    <div class="col-md-12">
        <button type="button" class="btn btn-success" onclick="location.href='<?php echo base_url().'index.php?school_admin/download_class_bulk_upload_error_file';?>';">Download Excel File</button>
    </div>
</div>

