<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('view_attendance_report'); ?> </h4></div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
       <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?bus_driver/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>

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
    <?php echo form_open(base_url() . 'index.php?bus_driver/attendance_report/'); ?>

    <div class="col-sm-6 form-group" data-step="5" data-intro="Select a Bus from here!" data-position='top'>
        <label for="field-1"><?php echo get_phrase('select_bus');?><span class="error mandatory"> *</span></label>
        <select  class="selectpicker" data-style="form-control" data-live-search="true" name="bus_id">
            <option value=""><?php echo get_phrase('select_bus'); ?></option>
            <?php foreach($busses as $row):?>
                <option value="<?php echo $row['bus_id'];?>"><?php echo $row['bus_name'];?></option>
            <?php endforeach;?>
        </select> 
        <label class="mandatory"> <?php echo form_error('bus_id'); ?></label>
    </div>    

    <div class="col-sm-6 form-group" data-step="7" data-intro="<?php echo get_phrase('Select a month for which you want to see the attendance report.');?>" data-position='top'>
        <label for="field-1" class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('select_month');?><span class="error" style="color: red;"> *</span></label>
        <select class="selectpicker" data-style="form-control" data-live-search="true" name="month" required>
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
    <div class="text-right col-xs-12" >
        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" data-step="8" data-intro="<?php echo get_phrase('Click here to view the report of selected class and month.');?>" data-position='left'><?php echo get_phrase('VIEW REPORT');?></button>
    </div>
<?php echo form_close(); ?>
</div>

<script type="text/javascript">
    function select_section(class_id) {
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?ajax_controller/get_sections_by_class/' + class_id,
            success:function (response){//alert(response);
                jQuery('#section_holder').html(response);
            }
        });
    }
</script>