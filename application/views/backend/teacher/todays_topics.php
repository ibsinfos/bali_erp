<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('add_subject_details'); ?></h4>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?teacher/dashboard"><?php echo get_phrase('dashboard'); ?></a></li>

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
</div>

<div class="col-md-12 white-box">
    <?php echo form_open(base_url() . 'index.php?teacher/todays_topics/create', array('class' => 'validate', 'enctype' => 'multipart/form-data')); ?>
    <div class="row" data-step="6" data-intro="<?php echo get_phrase('You can add the topic details here');?>" data-position='top'>
        <div class="col-xs-12 col-md-6 form-group">
            <label for="field-ta"><?php echo get_phrase('class'); ?><span class="error mandatory"> *</span></label>
            <select name="class_id" id="class_id" data-style="form-control" data-live-search="true" class="selectpicker" onchange="return onclasschange(this.value);" required>
                <option value="0"><?php echo get_phrase('select_class'); ?></option>
                <?php
                foreach ($classes_data as $row):
                    ?>
                    <option value="<?php echo $row['class_id']; ?>"><?php echo $this->crud_model->get_class_name($row['class_id']); ?></option>
                <?php endforeach; ?>
            </select> 
        </div>

        <div class="col-xs-12 col-md-6 form-group">
            <label for="field-ta"><?php echo get_phrase('section'); ?><span class="error mandatory"> *</span></label>
            <select name="section_id" id="section_holder" data-style="form-control" data-live-search="true" class="selectpicker" onchange="onsectionchange(this.value);" required >
                <option value="0"><?php echo get_phrase('select_section'); ?></option>		
            </select> 
        </div>

        <div class="col-xs-12 col-md-6 form-group">
            <label for="field-ta" ><?php echo get_phrase('subject'); ?><span class="error mandatory"> *</span></label>
            <select name="subject_id" id="subject_holder" data-style="form-control" data-live-search="true" class="selectpicker" required>
                <option value="0"><?php echo get_phrase('select_section_first'); ?></option>		
            </select>
        </div>
        <div class="col-xs-12 col-md-6 form-group ">
            <label for="feild"> <?php echo get_phrase('Topic_title'); ?> </label>
            <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-user"></i></div>
                <input type="text" class="form-control" id="sellerName" placeholder="Topic Title" name="title" value=" " required="required">
            </div>
            <span class="mandatory"> <?php echo form_error('title'); ?></span>
        </div>
        <div class="col-xs-12 col-md-12 form-group ">
            <label for="feild">  <?php echo get_phrase('description:'); ?> </label>
            <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-address-book"></i></div>
                <textarea class="form-control"  name="description" rows="4" cols="50" required></textarea>
            </div>
            <span class="mandatory"> <?php echo form_error('sellerAddress'); ?></span>
        </div>

        <div class="text-right col-xs-12 p-t-10">
            <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d">
                <?php echo get_phrase('add'); ?>
            </button>             
        </div>
    </div>
</div>

<script type="text/javascript">
    function onclasschange(class_id) {
        jQuery('#section_holder').html('<option value="">Select Section</option>');
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?teacher/get_teacher_section/' + class_id,
            success: function (response)
            {
                jQuery('#section_holder').append(response).selectpicker('refresh');
            }
        });
        $('#section_holder').trigger("chosen:updated");
    }
    function onsectionchange(section_id) {
        jQuery('#subject_holder').html('<option value="">Select Subject</option>');
        $.ajax({
            url: '<?php echo base_url(); ?>/index.php?teacher/get_teacher_subject/' + section_id,
            success: function (response)
            {
                jQuery('#subject_holder').append(response).selectpicker('refresh');
            }
        });
        $('#subject_holder').trigger("chosen:updated");
    }
    $('#tab_logic').hide();
    function showform() {
        $('#tab_logic').show();
    }
</script>