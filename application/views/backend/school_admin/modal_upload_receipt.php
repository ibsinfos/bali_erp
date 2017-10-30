<?php echo form_open_multipart(base_url().'index.php?school_admin/product_upload_receipt/create');?>
    <!--file upload-->
    <div class="col-sm-12 ol-md-12 col-xs-12">
        <div class="white-box"><input type="hidden" name="product_id" id="product_id" value="<?php echo $productArr->product_id; ?>">
            <input type="hidden" name="teacher_id" id="teacher_id" value="<?php echo $productArr->teacher_id; ?>">
            <input type="file" name="prodct_receipt" id="input-file-now" class="dropify" />
        <span class="error mandatory">Allow types are: pdf, docx, doc, txt, jpg, jpeg, png.</span>
        </div>
    </div>
    <!--end here-->    
    <div class="text-center">
        <input type="submit" value="upload" class="fcbtn btn btn-danger btn-outline btn-1d"/>        
    </div>
<?php echo form_close();  ?>

<script type="text/javascript">
    (function() {
        [].slice.call(document.querySelectorAll('.sttabs')).forEach(function(el) {
            new CBPFWTabs(el);
        });
    })();
</script>