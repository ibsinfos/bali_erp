<div class="container-fluid">
    <div class="row">
        <div class="box_upload">
            <div class="form_box">
                <?php if ($check_approve == 0) : ?>
                    <i class="fa fa-upload" aria-hidden="true"></i>
                    <form id="image_form" action="<?= base_url(); ?>index.php?bus_driver/stop_trip/upload" method="post" enctype='multipart/form-data'>
                        <div class="fileUpload">
                            <span>Upload</span>
                            <input id="file_name" type="file" name="file_name[]" class="upload" multiple="multiple" />
                        </div>
                    </form>
                <?php else : ?>
                    <div class="alert alert-danger" role="alert">
                        <h4>Waiting for admin approval for the uploaded images.</h4>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        if ($('#file_name').length) {
            document.getElementById('file_name').onchange = function () {
                document.getElementById('image_form').submit();
            }
        }
        
        <?php if ($check_approve == 1) : ?>
        setInterval(function () {
            $.post('<?= base_url(); ?>index.php?bus_driver/check_trip_status/', function (response) {
                if (response === 'go') {
                    window.location = '<?= base_url(); ?>index.php?bus_driver/trip_complete';
                }
            });
        }, 100);
        <?php endif; ?>
    });
</script>    