<style type="text/css">
	.document_preview{min-width: 100%; min-height:768px;}	
</style>

<?php if($file_type=='image'){ ?>

<div class="modal-body">
    <iframe src='<?php echo $url;?>' frameborder='0' class="document_preview"></iframe>
</div><?php }else{ ?>

<div class="modal-body">
    <?php if($file_name!='' && file_exists($filepath)) { ?>
    <iframe src='https://docs.google.com/viewer?url=<?php echo $url;?>&embedded=true' frameborder='0' class="document_preview"></iframe>
    <?php } else { ?>
    <h3>Document doesn't exist.</h3>
    <?php } ?>
</div><?php }?>