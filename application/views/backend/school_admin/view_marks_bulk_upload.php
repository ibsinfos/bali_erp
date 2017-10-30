<div class="row bg-title"> 
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active"><?php echo get_phrase($page_title); ?></li>
        </ol>
    </div>
</div>
<div class="panel panel-danger block6" data-step="5" data-intro="<?php echo get_phrase('Instructions_to_be_followed_before_uploading_a_file');?>" data-position='bottom'>
    <div class="panel-heading"> The following instructions are to be followed for Marksheet Bulk Upload.
        <div class="pull-right"><a href="#" data-perform="panel-collapse"><i class="ti-minus"></i></a> <a href="#" data-perform="panel-dismiss"><i class="ti-close"></i></a> </div>
    </div>
    <div class="panel-wrapper collapse in" aria-expanded="true">
        <div class="panel-body">
            <ol>
                <li>No changes are to be made in the first row at all.</li>
                <li>No changes are to be made in the first column(Column A) at all.</li>
                <li>In the second row fill the maximum marks in each cell corresponding to the subjects present in the row just above this row. Don't fill maximum marks for those cells above which Subject_name_comments is present.</li>
                <li>In the third row fill the marks of the student present in third row corresponding to the subjects present in the columns.</li>
                <li>No changes are to be made in the name of the worksheet.</li>
            </ol>
        </div>
    </div>
</div>
<?php //pre($exams);?>
<div class="col-md-12 white-box">
    <div class="box-content">
        <div class="row">
            <div class="form-group col-sm-6">
                <label class="control-label"><?php echo get_phrase('Select_Exam'); ?></label>
                <select class="selectpicker" data-style="form-control" onchange="get_class_by_exam(this.value);" id="exam_id" name="exam_id" data-live-search="true">
                    <option value="">Select</option>
                    <?php foreach ($exams As $k): ?>
                        <option value="<?php echo $k['exam_id'];?>"><?php echo $k['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group col-sm-6">
                <label class="control-label"><?php echo get_phrase('Select_Class'); ?></label>
                <select class="selectpicker" data-style="form-control" onchange="return get_section_subject_by_class(this.value);" id="class_data_holder" name="class_id" data-live-search="true">
                    <option value=""><?php echo get_phrase('select_section'); ?></option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 text-center"><input type="button" name="download_mark_template" id="download_mark_template" value="Download Mark Upload Template" class="fcbtn btn btn-danger btn-outline btn-1d"/></div>    
        </div>
    </div>
</div>

<div  class="col-sm-12 white-box">
    <div class="row">
        <?php echo form_open(base_url() . 'index.php?school_admin/mark_bulk_upload/', array('id' => 'form-upload', 'class' => 'validate', 'enctype' => 'multipart/form-data')); ?>
        <div class="col-md-8">
            <div class="form-group" data-step="7" data-intro="<?php echo get_phrase('Upload_the_template');?>" data-position='bottom'>
                <input type="file" name="userfile" id="userfile" class="form-control bor_no_here required" required>
            </div>
        </div>
        <!--            <div class="col-md-4 form-group">
                        <div class="progress" style="display:none;">
                            <div id="progress-bar" class="progress-bar progress-bar-success progress-bar-striped " role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 30%;">
                                20%
                            </div>
                        </div>
                    </div>-->

        <div class="col-md-4 text-right">
            <input type="button" name="upload-btn" id="upload-btn" value="Upload Mark Upload Template" class="fcbtn btn btn-danger btn-outline btn-1d"/>

        </div>
        <?php echo form_close(); ?>
    </div> 

</div>
<script>myJsMain = window.myJsMain || {};</script>
<!--Slimscroll JavaScript For custom scroll-->
<script src="<?php echo base_url(); ?>assets/js/old_js/sharad-common.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/babel-core/5.8.34/browser.js"></script>

<script src="<?php echo base_url(); ?>assets/js/jquery.file.ajax.upload.min.js"></script> 

<script type="text/javascript">
    $(document).ready(function () {
        $('#download_mark_template').on('click', function () {
            var flag = 0;
            //EliminaTipo2('kkk','success');
            var exam_id = $('#exam_id').val();
            var class_id = $('#class_data_holder').val();
            //var section_id=$('#section__holder').val();
            //var subject_id=$('#subject__holder').val();
            console.log('class_id : ' + exam_id);
            console.log('class_id : ' + class_id);
            //console.log('section_id : '+section_id);
            //console.log('subject_id : '+subject_id);

            if (exam_id == "") {
                EliminaTipo2("Please select exam to get the mark template for bulk upload.", 'error');
            }

            if (class_id == "") {
                EliminaTipo2("Please select class to get the mark template for bulk upload.", 'error');
            }
            
            $.ajax({
                url: '<?php echo base_url(); ?>index.php?Ajax_controller/check_exam_routine_set/' + exam_id+'/'+class_id,
                success:function (response){
                    if(response == 1){
                        flag = 1;
                    }
                }
            });

            /*if(section_id==""){
             EliminaTipo2("Please select section to get the mark template for bulk upload.",'error');
             }
             
             if(subject_id==""){
             EliminaTipo2("Please select subject to get the mark template for bulk upload.",'error');
             }*/
            //goForDownload(exam_id,class_id,section_id,subject_id);
            //location.href='<?php //echo base_url();       ?>index.php?ajax_controller/download_mark_bulk_upload_template/'+exam_id+'/'+class_id+'/'+section_id+'/'+subject_id+'/';
            if(flag == 1) {
                location.href = '<?php echo base_url(); ?>index.php?ajax_controller/download_mark_bulk_upload_template/' + exam_id + '/' + class_id;
            } else {
                message_modal('You need to add exam routine first.');
            }
        });
    });

    function goForDownload(exam_id, class_id, section_id, subject_id) {

    }
    function get_class_by_exam($exam_id) {
        //jQuery('#class_data_holder').html('<option value="sahoo">jduhisthira</option><option value="sahoo">subhransu</option>'); return false;
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?ajax_controller/get_class_by_exams/',
            data: 'exam_id=' + $exam_id,
            type: 'POST',
            //dataType: 'json',
            success: function (msg) {
                $('#class_data_holder').html(msg);
                $('.selectpicker').selectpicker('refresh');
//                jQuery.each(msg, function (index, item) {
//                    alert(index);
//                    //if (index == 'classOption') { //console.log("jduhi");
//                        jQuery('#class_data_holder').html(index);
//                    //}
////                    if (index == 'subjectOption') {
////                        jQuery('#subject__holder').html(item);
////                    }
//                    $('.selectpicker').selectpicker('refresh');
//                });
            }

        });
    }
    function get_class_by_exam1($exam_id) {
    //alert(41);
        //jQuery('#class_data_holder').html('<option value="sahoo">jduhisthira</option><option value="sahoo">subhransu</option>'); return false;
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?ajax_controller/get_class_by_exams/',
            data: 'exam_id=' + $exam_id,
            type: 'POST',
            dataType: 'json',
            success: function (msg) {
                console.log(msg);
                jQuery.each(msg, function (index, item) {
                    if (index == 'classOption') { //console.log("jduhi");
                        jQuery('#class_data_holder1').html(item).selectpicker('refresh');
                    }
                    if (index == 'subjectOption') {
                        jQuery('#subject__holder').html(item).selectpicker('refresh');
                    }
                });
            }

        });
    }

    function get_section_subject_by_class(class_id) {
        //jQuery('#class_data_holder').html('<option value="sahoo">jduhisthira</option><option value="sahoo">subhransu</option>'); return false;
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?ajax_controller/get_section_subject_by_class/',
            data: 'class_id=' + class_id,
            type: 'POST',
            dataType: 'json',
            success: function (msg) {
                //console.log(msg.length);
                jQuery.each(msg, function (index, item) {
                    if (index == 'sectionOption') { //console.log("jduhi");
                        jQuery('#section__holder').html(item).selectpicker('refresh');
                    }
                    if (index == 'subjectOption') {
                        jQuery('#subject__holder').html(item).selectpicker('refresh');
                    }
                });
            }

        });
    }

    function get_section_subject_by_class1(class_id) {
        //jQuery('#class_data_holder').html('<option value="sahoo">jduhisthira</option><option value="sahoo">subhransu</option>'); return false;
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?ajax_controller/get_section_subject_by_class/',
            data: 'class_id=' + class_id,
            type: 'POST',
            dataType: 'json',
            success: function (msg) {
                //console.log(msg.length);
                jQuery.each(msg, function (index, item) {
                    if (index == 'sectionOption') { //console.log("jduhi");
                        jQuery('#section__holder1').html(item).selectpicker('refresh');
                    }
                    if (index == 'subjectOption') {
                        jQuery('#subject__holder1').html(item).selectpicker('refresh');
                    }
                });
            }

        });
    }
</script>