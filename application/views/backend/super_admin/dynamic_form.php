<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<style>
</style>
<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('manage_form');?></h4>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour"  class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?super_admin/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li><?php echo get_phrase('manage_form'); ?></li>
        </ol>
    </div>
</div>
<div class="white-box">        
    <section>
    <div class="sttabs tabs-style-flip">
        <nav>
            <ul>
                <li id="section1">
                    <a href="#section-flip-1" class="sticon fa fa-list "data-step="5" data-intro="Here you can see class list." data-position='right'><span>
                    <?php echo get_phrase('form_list'); ?></span></a>
                </li>
                <li id="section2">
                    <a href="#section-flip-2" class="sticon fa fa-plus" data-step="6" data-intro="From here you can add a class." data-position='left'><span>
                    <?php echo get_phrase('add_form'); ?></span></a>
                </li>
            </ul>
        </nav>                                    
        <div class="content-wrap">
            <section id="section-flip-1">
                <table class="custom_table table display" cellspacing="0" width="100%" id="example23">
                    <thead>
                        <tr>
                            <th><div><?php echo get_phrase('no'); ?></div></th>
                            <th><div><?php echo get_phrase('form_name'); ?></div></th>
                            <th><div><?php echo get_phrase('staus'); ?></div></th>
                            <th><div><?php echo get_phrase('action'); ?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count = 1;
                        foreach ($fileds_data as $row):
                            if($row['is_enable']=="NO"){
                                $status = 'Disabled';
                                $action = 'Enable';
                            }else{
                                 $status = 'Enabled';
                                $action = 'Disable'; 
                            }
                            ?>
                            <tr>
                                <td><?php echo $count++; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $status; ?></td>
                                <td><div class="btn-group"><button type="button" data-toggle="dropdown" class="btn btn-default btn-outline dropdown-toggle waves-effect waves-light"><?php echo get_phrase('view_details'); ?><span class="caret"></span></button><ul class="dropdown-menu dropdown-default pull-right pos-static" role="menu"><li> <a href="javascript: void(0);" onclick="confirm_print('<?php echo base_url(); ?>index.php?super_admin/dynamic_form/status_change/<?php echo $row['id']; ?>/<?php echo $row['is_enable']; ?>', 'Are you sure to execute this action ?');"><i class="fa fa-trash-o"></i><?php echo " ".$action;?></a></li></ul></div></td>
                                <td>
                                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_edit_form/<?php echo $row['id']; ?>');" ><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil-square-o"></i></button></a>
                                    <!--delete-->
                                   <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>index.php?super_admin/dynamic_form/delete/<?php echo $row['id']; ?>');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-trash-o"></i></button></a>
                                </td>
                            </tr>
    <?php endforeach; ?>
                    </tbody>
                </table>
            </section>

            <section id="section-flip-2">
                <?php echo form_open(base_url() . 'index.php?super_admin/dynamic_form/create', array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top')); ?>
                <div class="row">          
                    <div class="col-xs-12 col-md-offset-3 col-md-6">
                        <label for="field-1"><?php echo get_phrase('name'); ?><span class="mandatory"> *</span></label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-users"></i></div>
                            <input type="text" class="form-control" data-validate="required"  name="form_name" placeholder="Form Name" required=""> 
                        </div>
                        <label class="mandatory"> <?php echo form_error('form_name'); ?></label>
                    </div> 
                </div>
                <div class="text-right">
                    <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('submit'); ?></button>
                </div>
                <?php echo form_close(); ?> 
            </section>             
        </div>
    </div>
    </section>
</div>