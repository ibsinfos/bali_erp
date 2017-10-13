<?php echo form_open_multipart(base_url().'index.php?student/upload_document/'.$param2);?>
    <!--file upload-->
    <div class="col-sm-12 ol-md-12 col-xs-12">
        <div class="white-box"><input type="file" name="userfile" id="input-file-now" class="dropify" />
        <span class="error mandatory">Allow types are: pdf, docx, doc, txt, jpg, jpeg, png.</span>
        </div>
    </div>
    <!--end here-->    
    <div class="text-right">
        <input type="submit" value="upload" class="fcbtn btn btn-danger btn-outline btn-1d"/>
    </div>
</form>

<script type="text/javascript">
    (function() {
        [].slice.call(document.querySelectorAll('.sttabs')).forEach(function(el) {
            new CBPFWTabs(el);
        });
    })();
</script>