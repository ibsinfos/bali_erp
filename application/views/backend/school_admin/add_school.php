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
<div class="row">
    <div class="col-md-12 white-box">
 <div class="sttabs tabs-style-flip">
    <nav>
        <ul>
            <li class="active">
                <a href="#section-flip-1" class="sticon fa fa-list"><span><?php echo get_phrase('all_schools');?></span>
                </a>
            </li>
            <li><a href="#add" class="sticon fa fa-plus-circle">
                <span><?php echo get_phrase('add_school');?></span>
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
                            <th><div><?php echo get_phrase('school_name');?></div></th>
                             <th><div><?php echo get_phrase('database_name');?></div></th>
                             <th><div><?php echo get_phrase('allot_SMS');?></div></th>
                            <th><div><?php echo get_phrase('options');?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($info_school)):
                            $count = 1;
     foreach ($info_school as $row): ?>
                        <tr>
                             <td><?php echo $count++ ;?></td>
                             <td><?php echo $row['school_name'];?></td>
                             <td><?php echo $row['db_name'];?></td>
                             <td><?php echo $row['allot_sms'];?></td>
                             <td>
                                 <!--edit -->
                                 <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/get_shcool_info_edit/<?php echo $row['id'];?>');" data-step="6" data-intro="<?php echo get_phrase('Here select you class for which you want to assessment list and add new assessment');?>" data-position='bottom'><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Edit Assessment"><i class="fa fa-pencil-square-o"></i></button></a>
                             <!--delete -->
                             <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>index.php?school_admin/add_school/delete/<?php echo $row['id']; ?>');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete Assessment"><i class="fa fa-trash-o"></i></button></a>
                                               
                             </td>
                        </tr>
     <?php endforeach;
                        endif;                    
                        ?>
                       
                    </tbody>
                    </table>
              </section>
            <section id="add">
    <?php echo form_open(base_url() . 'index.php?school_admin/add_school/create', array('class' => ' form-groups-bordered validate', 'target' => '_top')); ?>
                                <div class="row">          
                                    <div class="col-xs-12 col-md-offset-3 col-md-6">
                                        <label for="field-1"><?php echo get_phrase('school_name'); ?><span class="error mandatory"> *</span></label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-book"></i></div>
                                            <input type="text" class="form-control" data-validate="required" required="required" id="exampleInputuname" placeholder="School Name" name="school_name" data-message-required="<?php echo get_phrase('please_enter_required_value'); ?>"> 
                                        </div>                                        
                                    </div> 
                                </div>
    <br>
    <div class="row">
                                    <div class="col-xs-12 col-md-offset-3 col-md-6">
                                        <label for="field-2"><?php echo get_phrase('database_name'); ?><span class="error mandatory"> *</span></label>
                                         <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-database"></i></div>
                                        <input type="text" class="form-control" data-validate="required" required="required" id="exampleInputuname" placeholder="Database Name" name="db_name" data-message-required="<?php echo get_phrase('please_enter_required_value'); ?>"> 
                                    </div> 
                                    </div>
    </div>
    <br>
    <div class="row">
                                    <div class="col-xs-12 col-md-offset-3 col-md-6">
                                        <label for="field-1"><?php echo get_phrase('SMS_alloted'); ?></label>
                                         <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-comments"></i></div>
                                      <input type="text" class="form-control" data-validate="required" id="exampleInputuname" placeholder="Alloted SMS" name="allote_sms" data-message-required="<?php echo get_phrase('please_enter_required_value'); ?>" onkeypress="return isNumberKey(event);"> 
                                          <span></span>
                                    </div>
                                </div>
    </div>
                            
                                <!--           
                                <!----CREATION FORM ENDS-->
                                <div class="text-right">
                                    <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('add_school'); ?></button>
                                </div>
    <?php echo form_close(); ?> 
            </section>
</div>
 </div>
    </div>
</div>

<script type="text/javascript">
        function isNumberKey(evt)
 {
     var charCode = (evt.which) ? evt.which : event.keyCode
     if (charCode > 31 && (charCode < 48 || charCode > 57))
         return false;
 
     return true;
 }
</script>
