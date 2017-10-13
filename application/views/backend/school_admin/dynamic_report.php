<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<style>
</style>
<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('manage_report'); ?></h4>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour"  class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li><?php echo get_phrase('manage_report'); ?></li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-md-10 form-group">
        <div class="form-group col-sm-6 p-0" data-step="5" data-intro="Select a class, then you will get a list of all students with their all information." data-position='right'>
            <label class="control-label"> Select Report </label>
            <select class="selectpicker" data-style="form-control" name="class_id" id="class_id" data-live-search="true" onchange="window.location = this.options[this.selectedIndex].value">
                <option value="">Select Report</option>
                <?php
                foreach ($dynamic_report_name as $row):
                    ?>
                    <option <?php
                    if ($report_name_id == $row['id']) {
                        echo 'selected';
                    }
                        ?> value="<?php echo base_url(); ?>index.php?admin_report/dynamic_report/<?php echo $row['id']; ?>">
                            <?php echo $row['report_caption']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="white-box">
            <?php echo form_open(base_url() . 'index.php?admin_report/dynamic_report/create', array('class' => ' form-groups-bordered validate', 'target' => '_top')); ?>

            <table class="custom_table table display" cellspacing="0" width="100%">

            <div class="col-xs-12 col-md-6 form-group">
            <label for="field-1"><?php echo get_phrase('report_name'); ?><span class="error mandatory"> *</span></label>
            <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-book"></i></div>
                <input type="text" class="form-control" data-validate="required" required="required" id="exampleInputuname" placeholder="Report Name" name="report_name" data-message-required="<?php echo get_phrase('please_enter_required_value'); ?>"> 
            </div>                                        
        </div> 
               <table class="custom_table table display" cellspacing="0" width="100%">

                <thead>
                    <tr>
                        <th><div><?php echo get_phrase('s._no.'); ?></div></th>
                        <th><div><?php echo get_phrase('action'); ?></div></th>
                        <th width="5%"><div><?php echo get_phrase('caption'); ?></div></th>
                        <th><div><?php echo get_phrase('condition'); ?></div></th>
                        <th><div><?php echo get_phrase('value'); ?></div></th>
  
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 1;
                    foreach ($dynamic_report_list as $row):
                        $id = $row['id'];
                        $field = $row['field'];
                        ?>
                        <tr>
                            <td><?php echo $count++; ?></td>
                            <td><input type="checkbox" name="field[<?php echo $field; ?>]" value="<?php echo $field; ?>"></td>

                            <td width="5%"><input type="text" value="<?php echo get_phrase($field); ?>" name="caption[<?php echo $field; ?>]" style="width: 130px;">

                            <td width="5%"><input type="text" value="<?php echo get_phrase($row['caption']); ?>" name="caption[<?php echo $field; ?>]" style="width: 130px;">

                            </td>
                            <td><select id="condition<?php echo $field; ?>" name="condition[<?php echo $field; ?>]" class="form-control " data-style="form-control" data-live-search="true">
                                    <option value=""><?php echo get_phrase('select_condition'); ?></option>
                                    <option value=">"> Greater Than </option>
                                    <option value="<"> Less Than </option>
                                    <option value="=<"> Equal to Less Than </option>
                                    <option value="=>"> Equal to Greater Than </option>
                                    <option value="=="> Equal to </option>
                                    <option value="%"> Like as </option>
                                </select>
                            </td>
                            <td><input type="text" value="" name="field_value[<?php echo $field; ?>]" style="width: 160px;"></td>
                            
                                    <input type="hidden"  name="join_table[<?php echo $field; ?>]" style="width: 130px;"></div>
                                    <input type="hidden"  name="join_field[<?php echo $field; ?>]" style="width: 130px;"></div>
                                    <input type="hidden"  name="join_type[<?php echo $field; ?>]" style="width: 130px;"></div>
                                    <input type="hidden"  name="join_static[<?php echo $field; ?>]" style="width: 130px;"></div>
                          </tr>
<?php endforeach; ?>
                </tbody>
            </table>
            <div class="text-right">
                <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('submit'); ?></button>
            </div>
<?php echo form_close(); ?>

        </div>    
    </div>
</div>