<style type="text/css">
    .dropdown-menu{
        position: relative !important;
    }
</style>

<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('manage_bus_stop'); ?> </h4></div>
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
            <li class="active" data-step="5" data-intro="<?php echo get_phrase('List the bus stops');?>" data-position='bottom'>
                <a href="#list" class="sticon fa fa-list"><span><?php echo get_phrase('list_of_bus_stops'); ?></span>
                </a>
            </li>
            <li data-step="6" data-intro="<?php echo get_phrase('New bus stop can be add from here');?>" data-position='bottom'>
                <a href="#add" class="sticon fa fa-plus-circle" >
                    <span><?php echo get_phrase('add_bus_stop'); ?></span>
                </a>
            </li>
        </ul>
     </nav>
   <div class="content-wrap">     	
            <section id="list">  
                <table class= "custom_table table display" cellspacing="0" width="100%" id="example23">
                    <thead>
                        <tr>
                            <th><div><?php echo get_phrase('no'); ?></div></th>
                            <th><div><?php echo get_phrase('route_name'); ?></div></th>
                            <!--<th><div><?php // echo get_phrase('number_of_stops'); ?></div></th>-->
                            <th><div><?php echo get_phrase('bus_stop_from'); ?></div></th>
                            <th><div><?php echo get_phrase('bus_stop_to'); ?></div></th>
                            <th><div><?php echo get_phrase('route_fare'); ?></div></th>                                
                            <th><div><?php echo get_phrase('action'); ?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $count = 1;
                        foreach ($details as $row): ?>
                            <tr>
                                <td><?php echo $count++; ?></td>
                                <td><?php echo $row['route_name']; ?></td>
                                <!--<td><?php // echo $row['no_of_stops'];?></td>-->
                                <td><?php echo $row['route_from'];?></td>
                                <td><?php echo $row['route_to']; ?></td>
                                <td><?php echo $row['route_fare']; ?></td>

                                <td>
                                     <a href="javascript: void(0);" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_edit_bus_stops/<?php echo $row['route_bus_stop_id']; ?>');"> <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil-square-o"></i></button></a>
      <?php
        $transaction = $row['transaction'];
        if(intval($transaction)>0)
        {    
             echo '<button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 disabled"  data-placement="top" data-original-title="'.get_phrase('delete_class').'" title="'.get_phrase('delete_class').'"><i class="fa fa-trash-o"></i> </button>';
                            }
                            else
                            {
                                ?>
        
      <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>index.php?school_admin/route_bus_stop/delete/<?php echo $row['route_bus_stop_id']; ?>');">
                                             <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-trash-o"></i></button></a>
                                  <?php
                            }
                            ?>
                                    </div>
                                </td>
                            </tr>
<?php endforeach; ?>
                    </tbody>
                </table>
            </section>
            
            <!--TABLE LISTING ENDS-->


            <!--CREATION FORM STARTS-->
            <section id="add">
                                <?php echo form_open(base_url() . 'index.php?school_admin/route_bus_stop/create', array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top')); ?>
                   <div class="row">  
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                                        <label for="field-2"><?php echo get_phrase('route_name'); ?></label>
                            <select class="selectpicker" data-style="form-control" data-live-search="true" id="route_id" name="route_id" required="required">
                                <option value=""><?php echo get_phrase('select_option'); ?></option>
                                <?php foreach ($routes as $value):
                                    ?>
                                <option value="<?php echo $value['transport_id']; ?>"><?php echo $value['route_name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                <br>
                    <div class="row">          
                                    <div class="col-xs-12 col-md-offset-3 col-md-6">
                                        <label for="field-1"><?php echo get_phrase('bus_stop_from'); ?><span class="error mandatory"> *</span></label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-road"></i></div>
                                        <input type="text" class="form-control" name="route_from" required="required">
                                        </div>
                                    </div> 
                    </div>
                <br>
                    <div class="row">          
                                    <div class="col-xs-12 col-md-offset-3 col-md-6">
                                        <label for="field-1"><?php echo get_phrase('bus_stop_to'); ?><span class="error mandatory"> *</span></label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-road"></i></div>
                            <input type="text" class="form-control" name="route_to" required="required">
                        </div>
                    </div>
                    </div>
<!--                <br>
                        <div class="row">          
                                    <div class="col-xs-12 col-md-offset-3 col-md-6">
                                        <label for="field-1"><?php // echo get_phrase('number_of_stops'); ?><span class="error mandatory"> *</span></label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-ban"></i></div>
                            <input type="text" class="form-control numeric" name="number_of_stops" required="required">
                       </div>
                    </div>
                    </div>-->
                <br>
                    <div class="row">  
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="field-2"><?php echo get_phrase('route_fare'); ?><span class="error mandatory"> *</span></label>
                            <?php if(sett('new_fi')){?>
                                <input type="number" min="1" class="form-control" name="route_fare" placeholder="<?php echo get_phrase('route_fare');?>" required/>
                            <?php }else{?>
                                <select class="selectpicker" data-style="form-control" data-live-search="true" id="route_fare" name="route_fare" required="required" data-max-options="2" >
                                    <option value=""><?php echo get_phrase('select_option'); ?></option>
                                    <?php foreach ($charges as $charge):?>
                                        <option value="<?php echo $charge['sales_price'] . '|' .
                                        $charge['id']; ?>"><?php echo $charge['sales_price'] . "------" . $charge['name']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            <?php }?>    
                        </div>
                    </div>
                <br>
                    <div class="text-right">
                            <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('add'); ?></button>
                   </div>                  
                    </form>                
            </section>
    </div>
</div>
</div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function () {
        $(".numeric").numeric();
    });
</script>