<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('fee_categories'); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?<?php echo $this->session->userdata('login_type');?>/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>

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
                    <li class="active" data-step="5" data-intro="<?php echo get_phrase('From here you can view categories of fees');?>" data-position='right'>
                        <a href="#list" class="sticon fa fa-list"><span class="hidden-xs"><?php echo get_phrase('categories_list'); ?></span></a>
                    </li>
                    <li data-step="5" data-intro="<?php echo get_phrase('From here you can add new category of fee');?>" data-position='right'>
                        <a href="#add" class="sticon fa fa-plus-circle">
                            <span class="hidden-xs"><?php echo get_phrase('add_fee_category'); ?></span>
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
                                <th><div><?php echo get_phrase('category_name'); ?></div></th>
                                <th><div><?php echo get_phrase('description'); ?></div></th>
                                <th><div><?php echo get_phrase('action'); ?></div></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count = 1;
                            foreach ($fee_categories as $row): ?>
                                <tr>
                                    <td><?php echo $count++; ?></td>
                                    <td><?php echo $row->cat_name; ?></td>
                                    <td><?php echo $row->cat_desc; ?></td>
                                    <td>
                                        <a href="javascript: void(0);" 
                                        onclick="showAjaxModal('<?php echo base_url('index.php?fees/fees/category_edit/'.$row->cat_id);?>')">
                                            <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" 
                                                data-toggle="tooltip" data-placement="top" data-original-title="Edit">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </button>
                                         </a>
                                         <?php if($row->trans){?>
                                            <a class="disabled">
                                                <button disabled type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-trash-o"></i></button>
                                            </a>
                                         <?php }else{ ?>
                                            <a href="javascript:void(0)" onclick="confirm_act('<?php echo base_url('index.php?fees/fees/category_delete/'.$row->cat_id);?>')">
                                                <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-trash-o"></i></button>
                                            </a>
                                         <?php }?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </section>
                <!--TABLE LISTING ENDS-->


                <!--CREATION FORM STARTS-->
                <section id="add">  
                    <?php echo form_open(base_url('index.php?fees/fees/categories'), array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top')); ?>
                    <div class="row">
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="running_session"><?php echo get_phrase("running_session"); ?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-sellsy"></i></div>
                                <select name="running_year" class="selectpicker" data-style="form-control" data-live-search="true">
                                      <option value=""><?php echo get_phrase('select_running_session');?></option>
                                      <?php $last_year = date('Y',strtotime('-1 year'));
                                            for($i = 0; $i < 10; $i++){
                                                $grp_year = ($last_year+$i).'-'.($last_year+($i+1));?>
                                            <option value="<?php echo $grp_year?>" <?php echo $grp_year==set_value('running_year',$running_year)?'selected':'';?>>
                                                <?php echo $grp_year?>
                                            </option>
                                      <?php }?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <br/>
                    <div class="row">          
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="field-1"><?php echo get_phrase('category_name'); ?><span class="error" style="color: red;">*</span></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-road"></i></div>
                                <input type="text" class="form-control" name="cat_name" data-validate="required" 
                                data-message-required="<?php echo get_phrase('value_required');?>" required="required"/> 
                            </div>
                        </div> 
                    </div>
                    <br/>

                    <div class="row">          
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="field-1"><?php echo get_phrase('description'); ?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-book"></i></div>
                                <input type="text" class="form-control" name="cat_desc"/>
                            </div> 
                        </div>
                    </div>
                    <br>

                    <div class="form-group">
                        <div class="text-right">
                            <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('submit'); ?></button>
                        </div>
                    </div>
                   <?php echo form_close()?>   
                </section>                
            </div>
        </div>
    </div>
</div>
<script>
</script>