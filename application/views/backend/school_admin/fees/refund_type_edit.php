<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('refund_types'); ?> </h4></div>
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
            <div class="content-wrap">     	
                <!--CREATION FORM STARTS-->
                <div>  
                    <?php echo form_open(base_url('index.php?fees/refund/refund_type_edit/'.$type_id), array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top')); ?>
                    <div class="row">
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="running_session"><?php echo get_phrase("running_session"); ?><span class="error" style="color: red;">*</span>
                            </label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-sellsy"></i></div>
                                <select name="running_year" class="selectpicker" data-style="form-control" data-live-search="true" required="required">
                                      <option value=""><?php echo get_phrase('select_running_session');?></option>
                                      <?php $last_year = date('Y',strtotime('-1 year'));
                                            for($i = 0; $i < 10; $i++){
                                                $grp_year = ($last_year+$i).'-'.($last_year+($i+1));?>
                                    <option value="<?php echo $grp_year?>" <?php echo $grp_year==$refund_type_data['running_year']?'selected':'';?>>
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
                            <label for="field-1"><?php echo get_phrase('type_name'); ?><span class="error" style="color: red;">*</span></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-road"></i></div>
                                <input type="text" class="form-control" name="name" required="required" value="<?php echo @$refund_type_data['name']; ?>" /> 
                            </div>
                        </div> 
                    </div>
                    <br/>

                    <div class="row">          
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="field-1"><?php echo get_phrase('description'); ?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-book"></i></div>
                                <input type="text" class="form-control" name="description" value="<?php echo @$refund_type_data['description']; ?>" />
                            </div> 
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="text-right">
                            <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('submit'); ?></button>
                        </div>
                    </div>
                    </form>    
                </div>                
            </div>
        </div>
    </div>
</div>