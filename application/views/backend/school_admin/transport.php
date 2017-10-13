<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('manage_transport'); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
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
<div class="row m-0">
    <div class="col-md-12 white-box">
        <div class="sttabs tabs-style-flip">
            <nav>
                <ul>
                    <li class="active" data-step="5" data-intro="<?php echo get_phrase('It Shows Transport List');?>" data-position='bottom'>
                        <a href="#list" class="sticon fa fa-list"><span class="hidden-xs"><?php echo get_phrase('transport_list'); ?></span>
                        </a>
                    </li>
                    <li data-step="6" data-intro="<?php echo get_phrase('you can Add New Transport from here');?>" data-position='bottom'>
                        <a href="#add" class="sticon fa fa-plus-circle">
                            <span class="hidden-xs"><?php echo get_phrase('add_transport'); ?></span>
                        </a>
                    </li>
                </ul>
            </nav>
            <div class="content-wrap">     	
                <section id="list">  
                    <!--TABLE LISTING STARTS-->           
                    <table class= "custom_table table display" cellspacing="0" width="100%" id="example23">
                        <thead>
                            <tr>
                                <th><div><?php echo get_phrase('no'); ?></div></th>
                                <th><div><?php echo get_phrase('route_name'); ?></div></th>
                                <th><div><?php echo get_phrase('no_of_buses'); ?></div></th>
                                <th><div><?php echo get_phrase('description'); ?></div></th>
<!--                    		<th><div><?php // echo get_phrase('route_fare'); ?></div></th>   -->
                                <th><div data-step="7" data-intro="<?php echo get_phrase('You can view bus stops of route from here');?>" data-position='left'><?php echo get_phrase('options'); ?></div></th>
                                <th><div data-step="8" data-intro="<?php echo get_phrase('You can do edit ,Delete and see students in this route from here by clicking on specific iconava');?>" data-position='left'><?php echo get_phrase('action'); ?></div></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count = 1;
                            foreach ($transports as $row): ?>
                                <tr>
                                    <td><?php echo $count++; ?></td>
                                    <td><?php echo $row['route_name']; ?></td>
                                    <td><?php
                                        if ($row['number_of_vehicle'] == '') {
                                            echo get_phrase('bus_not_alloted');
                                        } else {
                                            echo $row['number_of_vehicle'];
                                        }
                                        ?></td>
                                    <td><?php echo $row['description']; ?></td>
    <!--                                <td><?php echo $row['route_fare']; ?></td>-->
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" data-toggle="dropdown" class="btn btn-default btn-outline dropdown-toggle waves-effect waves-light">
    <?php echo get_phrase('Option'); ?> <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-default pull-right pos-static" role="menu">

                                                <!-- STUDENT AVERAGE LINK -->
                                                <li>
                                                    <a href="javascript: void(0);"  onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_route_bus_stops/<?php echo $row['transport_id']; ?>');">
                                                        <i class="fa fa-bus"></i>
    <?php echo get_phrase('view_bus_stops'); ?>
                                                    </a>
                                                </li>

                                            </ul>
                                        </div>


                                    <td>
                                        <a href="javascript: void(0);"  onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_transport_student/<?php echo $row['transport_id']; ?>');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Students"><i class="fa fa-users"></i></button></a>

                                        <a href="javascript: void(0);" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_edit_transport/<?php echo $row['transport_id']; ?>');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil-square-o"></i></button></a>
                                        <!--delete-->
                                        <?php if ($row['transaction'] == 1) {
                                            ?>
                                            <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 disabled" ><i class="fa fa-trash-o"></i></button>
                                        <?php
                                        } else if ($row['transaction'] == 0) {
                                            ?>                 
                                            <a href="javascript: void(0);" onclick="confirm_modal('<?php echo base_url(); ?>index.php?school_admin/transport/delete/<?php echo $row['transport_id']; ?>');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-trash-o"></i></button></a>
    <?php } ?>        
                                    </td>
                                </tr>
<?php endforeach; ?>
                        </tbody>
                    </table>
                </section>
                <!--TABLE LISTING ENDS-->


                <!--CREATION FORM STARTS-->
                <section id="add">  
<?php echo form_open(base_url() . 'index.php?school_admin/transport/create', array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top')); ?>
                    <div class="row">          
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="field-1"><?php echo get_phrase('route_name'); ?><span class="error" style="color: red;">*</span></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-road"></i></div>
                                <input type="text" class="form-control" name="route_name" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>" required="required"/> </div>
                        </div> 
                    </div>
                    <br>

                    <div class="row">          
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="field-1"><?php echo get_phrase('description'); ?><span class="error mandatory">*</span></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-book"></i></div>
                                <input type="text" class="form-control" required="required" name="description"/>
                            </div> 
                        </div>
                    </div>

                    <br>
                    <div class="form-group">
                        <div class="text-right">
                            <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('add'); ?></button>
                        </div>
                    </div>

                    </form>    
                </section>                
            </div>
        </div>
    </div>
</div>
