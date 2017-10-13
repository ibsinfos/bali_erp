<div class="row bg-title"> 
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>

<?php $BRC = get_bread_crumb(); if (strpos($BRC, '^') !== false) { $ExpBrd = explode('^', $BRC);?>
            <li>
                <?php echo get_phrase(@$ExpBrd[0]); ?>
                <?php echo @$ExpBrd[1]; ?>
            </li> <?php }else{ $ExpBrd[2] = $BRC;}?>
            <li class="active">
                <?php echo get_phrase(@$ExpBrd[2]); ?>
            </li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>





<div class="row">
    <?php echo form_open(base_url() . 'index.php?school_admin/exam_marks_sms/get_list'); ?>

    <div class="col-md-12 white-box">
        <div class="col-sm-3 form-group">
	    <div class="form-group col-sm-12 p-0" data-step="5" data-intro=" <?php echo get_phrase('Select a exam, for which you want to send exam marks.');?>" data-position='right'>
            <label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('exam'); ?></label><span class="error" style="color: red;"> *</span>
            <select name="exam_id" class="selectpicker" data-style="form-control" data-live-search="true">
                <?php
                
                foreach ($exams as $row):
                    ?>
                    <option value="<?php echo $row['exam_id']; ?>"><?php echo $row['name']; ?></option>
                <?php endforeach; ?>
            </select>
	    </div></div>



        <div class="col-sm-3 form-group">
	    <div class="form-group col-sm-12 p-0" data-step="6" data-intro=" <?php echo get_phrase('Select a class, for which you want to send exam marks.');?>" data-position='right'>
            <label class="control-label"><?php echo get_phrase('class'); ?></label>
            <select name="class_id" class="selectpicker" data-style="form-control" data-live-search="true" onchange="get_class_section(this.value)">
                <option value=""><?php echo get_phrase('select_class'); ?></option>
                <?php
                
                foreach ($classes as $row):
                    ?>
                    <option value="<?php echo $row['class_id']; ?>"><?php echo $row['name']; ?></option>
                <?php endforeach; ?>
            </select>
	    </div></div>


        <div class="col-sm-3 form-group">
	    <div class="form-group col-sm-12 p-0" data-step="7" data-intro=" <?php echo get_phrase('Select a section, for which you want to send exam marks.');?>" data-position='right'>
            <label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('section'); ?></label>
            <select id="section_holder" name="section_id" class="selectpicker" data-style="form-control" data-live-search="true">
                <option value="">Select Section</option>

            </select>
	    </div></div>


        <div class="col-sm-3 form-group">
	    <div class="form-group col-sm-12 p-0" data-step="8" data-intro=" <?php echo get_phrase('Select a receiver, to whom you want to send exam marks.');?>" data-position='bottom'>
            <label class="control-label"><?php echo get_phrase('receiver'); ?></label>
            <select name="receiver" class="selectpicker" data-style="form-control" data-live-search="true" id="receiver">
                <option value=""><?php echo get_phrase('select_receiver'); ?></option>
                <option value="student"><?php echo get_phrase('students'); ?></option>
                <option value="parent"><?php echo get_phrase('parents'); ?></option>
            </select>
	    </div></div>


    <div class="text-right col-xs-12">
    <button type="button" onclick="get_detail_list()" class="fcbtn btn btn-danger btn-outline btn-1d">	
	<?php echo get_phrase('send_marks_via_sms'); ?> 
    </button>
    </div>
            <?php echo form_close(); ?>
    </div>
</div>
    <div class="row">
        
    
        <div id="detail_holder">
            
        
      
         </div>
    
</div>




<script type="text/javascript">

    function get_class_section(class_id) {
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?school_admin/get_class_section/' + class_id,
            success: function (response)
            {
                jQuery('#section_holder').html(response).selectpicker('refresh');
            }
        });
        $('#section_holder').trigger("chosen:updated");
    }
    function get_detail_list()
    {
        $.ajax({
            type: "post",
            url: "<?php echo base_url() . 'index.php?school_admin/exam_marks_sms/get_list'; ?>",
            data: $("form").serialize(),
            contentType: "application/x-www-form-urlencoded",
            success: function (responseData, textStatus, jqXHR) {
                $("#detail_holder").html(responseData);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    $("form").submit(function (event) {

        var receiver = $('#receiver').val();
        if (receiver == '') {
            toastr.error('<?php echo get_phrase('please_select_receiver'); ?>');
            event.preventDefault();
        } else {

            return true;
        }

    });
</script>