<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('manage_daily_attendance'); ?> </h4></div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php?bus_driver/dashboard');?>"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active"><?php echo get_phrase('manage_attendance'); ?></li>
        </ol>
    </div>
</div>

<?php echo form_open(base_url('index.php?bus_driver/manage_drop_attendance'));?>
<div class="col-md-12 white-box">
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

    <div class="col-sm-6 form-group" data-step="7" data-intro="Select a date from here!" data-position='top'>               
        <label for="field-1"><?php echo get_phrase('select_date');?><span class="error mandatory"> *</span></label>
        <div class="input-group">
            <span class="input-group-addon"><i class="icon-calender"></i></span>
          <input type="text" class="form-control" id="today_date" name="timestamp" value="<?php echo date('d/m/Y');?>" <?php echo 'disabled'?>>             
        </div>  
        <label class="mandatory"> <?php echo form_error('timestamp'); ?></label>
    </div> 
   
    <div class="text-right col-xs-12">
        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" data-step="8" 
        data-intro="On the click of button, you will get a list of attendance." 
        data-position='top'><?php echo get_phrase('MANAGE ATTENDANCE');?></button>
    </div> 
</div>
<?php echo form_close();?>
<script>
    $(document).ready(function () {
        $('#today_date').datepicker({
            format: "dd/mm/yyyy"
        });
    });
</script>