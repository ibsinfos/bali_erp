<link rel="stylesheet" href="<?php echo base_url();?>assets/bower_components/dropify/dist/css/dropify.min.css">
<script src="<?php echo base_url();?>assets/bower_components/dropify/dist/js/dropify.min.js"></script>
<?php echo form_open_multipart(base_url().'index.php?student/upload_document/'.$param2);?>
    <!--file upload-->
    <div class="col-sm-12 ol-md-12 col-xs-12">
        <div class="white-box">
            <!--<label class=" fcbtn btn btn-danger btn-outline btn-1d" for="userfile"><i class="fa fa-upload"></i> Browse</label>-->
            <input type="file" style="" name="userfile" id="input-file-now" class="dropify"/><br/>
            <span class="error mandatory">Allow types are: pdf, docx, doc, txt, jpg, jpeg, png.</span>
        </div>
    </div>
    <!--end here-->    
    <div class="text-center">
        <input type="submit" value="Upload Document" class="fcbtn btn btn-danger btn-outline btn-1d"/>
    </div>
</form>

<script type="text/javascript">
    (function() {
        [].slice.call(document.querySelectorAll('.sttabs')).forEach(function(el) {
            new CBPFWTabs(el);
        });
    })();
</script>