<div class="row bg-title"> 
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/add_school"><?php echo get_phrase('Manage_school'); ?></a></li>
            <li class="active"> <span><?php echo get_phrase($page_title); ?></span></li>
            
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>            

<div class="col-md-12 white-box">
    <div class="row">
    <div class="col-md-12 white-box">
 <div class="sttabs tabs-style-flip">
    <nav>
        <ul>
            <li class="active">
                <a href="#section-flip-1" class="sticon fa fa-list"><span><?php echo get_phrase('all_machine');?></span>
                </a>
            </li>
            <li><a href="#add" class="sticon fa fa-plus-circle">
                <span><?php echo get_phrase('add_machine');?></span>
                </a>
            </li>
        </ul>
    </nav>
        <div class="content-wrap">
              <section id="section-flip-1">    
                  <table class= "custom_table table display" cellspacing="0" width="100%" id="example23">
                    <thead>
                        <tr>
                            <th><div><?php echo get_phrase('s.no');?></div></th>
                            <!--<th><div><?php // echo get_phrase('school_name');?></div></th>-->
                             <th><div><?php echo get_phrase('school_database_name');?></div></th>
                             <th><div><?php echo get_phrase('IMEI');?></div></th>
                            <th><div><?php echo get_phrase('options');?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        
                    </tbody>
                  </table>
               </section>
    
            <section id="add">
    <?php echo form_open(base_url() . 'index.php?school_admin/machine_allot/create', array('class' => ' form-groups-bordered validate', 'target' => '_top')); ?>
                                <div class="row">          
                                    <div class="col-xs-12 col-md-offset-3 col-md-6">
                                        <label for="field-1"><?php echo get_phrase('school_name'); ?><span class="error mandatory"> *</span></label>
                                        <select class="selectpicker" data-style="form-control" data-live-search="true" id="school_name" name="school_name" required="required">
	<option value="">~~SELECT SCHOOL~~</option>
        <?php if(!empty($school_detail)):
        foreach($school_detail as $row): ?>
             <option value="<?php echo $row['school_db_id'] ?>"><?php echo $row['school_name'];?></option>
        <?php endforeach;
        ?>
        <?php endif; ?>
       
	</select>                                       
                                    </div> 
                                </div>
    <br>
    <div class="row">
                                    <div class="col-xs-12 col-md-offset-3 col-md-6">
                                        <label for="field-2"><?php echo get_phrase('IMEI_no'); ?><span class="error mandatory"> *</span></label>
                                    <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-key"></i></div>
                                        <input type="text" class="form-control" data-validate="required" required="required" id="exampleInputuname" placeholder="IMI Number" name="imei_no" data-message-required="<?php echo get_phrase('please_enter_required_value'); ?>"> 
                                    </div> 
                                    </div>
    </div>
    <br>
                                <!--           
                                <!----CREATION FORM ENDS-->
                                <div class="text-right">
                                    <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('allot_machine'); ?></button>
                                </div>
    <?php echo form_close(); ?> 
            </section>
        </div>
 </div>
</div>

