<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('view_bus_report'); ?> </h4></div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?admin/dashboard"><?php echo get_phrase('Bus Detail Report'); ?></a></li>
            <li class="active"><?php echo get_phrase('view_bus_report'); ?></li>
        </ol>
    </div>
</div>
<div class="col-md-12 white-box">
<?php echo form_open(base_url() . 'index.php?admin/bus_detail_report/'); ?>
<div class="col-sm-4 form-group" data-step="5" data-intro="Select a route want to see bus report" data-position='right'>
    <label for="field-1" class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('Select_Route');?><span class="error" style="color: red;"> *</span></label>
    <select  id="route_id" name="route_id" data-style="form-control" class="selectpicker" required onchange="select_bus(this.value)">
        <option value=""><?php echo get_phrase('select_route'); ?></option>            
        <?php foreach($routes as $row1):?>
            <option value="<?php echo $row1['transport_id'];?>"<?php if($row1['transport_id'] == $route_id)echo "selected";?>><?php echo get_phrase('route'); ?>&nbsp;<?php echo $row1['route_name'];?></option>
            <?php if($route_id !="")?>
        <?php endforeach;?>
    </select> 
    <label style="color:red;"> <?php echo form_error('route_id'); ?></label>
</div>

<input type="hidden" name="year" value="<?php echo $running_year;?>">
<div class="text-right col-xs-12" >
    <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" data-step="8" data-intro="Click to view report" data-position='left'><?php echo get_phrase('VIEW REPORT');?></button>
</div>
<?php echo form_close(); ?>
</div>
<div class="row">
<div class="col-sm-12 white-box">    
          
<table id="example23" class="display nowrap" cellspacing="0" width="100%">
    <thead>
        <tr>
                            <th><div><?php echo get_phrase('sl_no.');?></div></th>
                            <th><div><?php echo get_phrase('Bus Name'); ?></div></th>                            
                            <th><div><?php echo get_phrase('Bus Driver'); ?></div></th>                            
                            <th><div><?php echo get_phrase("Purchase Date"); ?></div></th>                            
                            <th><div><?php echo get_phrase('Service Date'); ?></div></th>
                            <th><div><?php echo get_phrase('Return_service Date'); ?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(count($bus_details) > 0){
                                $n = 1;
                            foreach($bus_details as $key => $value){?>
                                <tr>
                                    <td><div><?php echo $n++;?></div></td>
                                    <td><div><?php echo $value['name'];?></div></td>
                                    <td><div><?php echo $value['driver_name'];?></div></td>
                                    <td><div><?php echo $value['purchase_date'];?></div></td>
                                    <td><div><?php echo $value['service_date'];?></div></td>
                                    <td><div><?php echo $value['service_return_date'];?></div></td>
                                </tr>
                            <?php }
                        }?>
                    </tbody>
                </table>
</div>                     
</div>
<script type="text/javascript">
    
    function select_bus(route_id) { 
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?Ajax_controller/get_class_by_school/' + school_id,
            success:function (response){//alert(response);
                jQuery('#class_holder').html(response).selectpicker('refresh');
            }
        });
    }
</script>