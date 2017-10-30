<?php foreach ($holiday as $row): ?>    
<div class="row">
    <div class="col-md-12">
        <div class="panel-body content-wrap">
            <?php echo form_open(base_url('index.php?school_admin/edit_holiday/').$row['id'], 
                array('class' => 'form-horizontal form-material form-groups-bordered validate', 'target' => '_top')); ?>
                <div class="row">          
                    <div class="col-xs-12 col-md-offset-3 col-md-6">
                        <label>
                            <?php echo get_phrase('title'); ?>
                            <span class="mandatory"> *</span>
                        </label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-book"></i></div>
                            <input type="text" class="form-control" name="title" value="<?php echo $row['title']; ?>" data-validate="required" data-message-required="<?php echo get_phrase('please_enter_required_value'); ?>"/>
                        </div>
                        <label class="mandatory"> <?php echo form_error('name'); ?></label>
                    </div> 
                </div>

                <div class="row">          
                    <div class="col-xs-12 col-md-offset-3 col-md-6">
                        <label>
                            <?php echo get_phrase('start_date'); ?>
                            <span class="error" style="color: red;"> *</span>
                        </label>
                        <div class="input-group">
                            <div class="input-group-addon" id="exam_date"><i class="fa fa-calendar"></i></div>
                            <input type="text" required="required" class="form-control datepicker" name="date_start" data-validate="required" 
                            value="<?php echo date('m/d/Y',strtotime($row['date_start']));?>"
                            data-message-required="<?php echo get_phrase('please_enter_required_value');?>"/>
                        </div>
                        <label class="mandatory"> <?php echo form_error('date'); ?></label>
                    </div>
                </div>

                <div class="row">          
                    <div class="col-xs-12 col-md-offset-3 col-md-6">
                        <label>
                            <?php echo get_phrase('end_date');?> <span class="error" style="color: red;"> *</span>
                        </label>
                        <div class="input-group">
                            <div class="input-group-addon" id="end_date"><i class="fa fa-calendar"></i></div>
                            <input type="text" required="required" class="form-control datepicker" name="end_date" data-validate="required"  
                            value="<?php echo date('m/d/Y',strtotime($row['date_end']));?>" 
                            data-message-required="<?php echo get_phrase('please_enter_required_value');?>"/>
                        </div>
                        <label class="mandatory"> <?php echo form_error('end_date'); ?></label>
                    </div>
                </div>
                
                <!-- <div class="row">          
                    <div class="col-xs-12 col-md-offset-3 col-md-6">
                        <label>
                            <?php //echo get_phrase('number_of_days'); ?>
                        </label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-comment"></i></div>
                            <input type="text" class="form-control" name="number_of_days" value="<?php //echo $row['number_of_days']; ?>" data-validate="required" data-message-required="<?php echo get_phrase('please_enter_required_value'); ?>"/>
                        </div>
                    </div>
                </div> -->
                <div class="text-right">
                    <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d">
                        <?php echo get_phrase('update_holiday'); ?>
                    </button>
                </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<?php endforeach; ?>
<script type="text/javascript">
$(function() {
    $(".datepicker").datepicker({
        startDate: new Date(),
        todayHighlight: true,
        autoclose: true
    });
});
</script>