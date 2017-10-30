<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('attendance_report'); ?> </h4></div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" target="_blank" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        
    </div>
</div>
<?php echo form_open(base_url() . 'index.php?teacher/attendance_report_selector/'); ?>
<div class="col-md-12 white-box">
    <div class="col-sm-4 form-group">
        <label for="field-1"><?php echo get_phrase('Select_Class');?><span class="error" style="color: red;"> *</span></label>
        <select class="selectpicker" data-style="form-control" name="class_id" id="class_id" data-live-search="true" onchange="return get_class_sections_by_teacher();">
            <option value=""><?php echo get_phrase('select_class'); ?></option>
            <?php foreach($classes as $row):?>
            <option value="<?php echo $row['class_id'];?>"><?php echo get_phrase('class'); ?>&nbsp;<?php echo $row['name'];?></option>
            <?php endforeach;?>
        </select> 
        <label style="color:red;"> <?php echo form_error('class_id'); ?></label>
    </div>
    <?php if($class_id != ''): ?>
    <div class="col-sm-4 form-group">
        <label for="field-1"><?php echo get_phrase('select_section');?><span class="error" style="color: red;"> *</span></label>       
        <select name="section_id" data-style="form-control" data-live-search="true" class="selectpicker" id="section_holder">
            <option value=""><?php echo get_phrase('select_section'); ?></option>
        </select> 
        <label style="color:red;"> <?php echo form_error('section_id'); ?></label>
    </div>
    <?php endif; ?>
    <div class="col-sm-4 form-group">
        <label for="field-1"><?php echo get_phrase('select_month');?><span class="error" style="color: red;"> *</span></label>
        <select data-style="form-control" data-live-search="true" class="selectpicker" name="month" data-live-search="true">
            <option value=""><?php echo get_phrase('select_month'); ?></option>
            <option value="1"><?php echo get_phrase('January'); ?></option>
            <option value="2"><?php echo get_phrase('February'); ?></option>
            <option value="3"><?php echo get_phrase('March'); ?></option>
            <option value="4"><?php echo get_phrase('April'); ?></option>
            <option value="5"><?php echo get_phrase('May'); ?></option>
            <option value="6"><?php echo get_phrase('June'); ?></option>
            <option value="7"><?php echo get_phrase('July'); ?></option>
            <option value="8"><?php echo get_phrase('August'); ?></option>
            <option value="9"><?php echo get_phrase('September'); ?></option>
            <option value="10"><?php echo get_phrase('October'); ?></option>
            <option value="11"><?php echo get_phrase('November'); ?></option>
            <option value="12"><?php echo get_phrase('December'); ?></option>            
        </select> 
        <label style="color:red;"> <?php echo form_error('month'); ?></label>
    </div>    
    
    <input type="hidden" name="year" value="<?php echo $running_year;?>">
    <div class="text-right col-xs-12">
        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('VIEW REPORT');?></button>
    </div>
</div>

<?php echo form_close(); ?>







<script type="text/javascript">
    function get_class_sections_by_teacher() {
          var class_id = $("#class_id option:selected").val();
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?Ajax_controller/get_sections_by_class/' + class_id,
            success: function (response){
                jQuery('#section_holder').html(response).selectpicker('refresh');
            }
        });
    }
</script>
