<div class="row bg-title"> 
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('restore_google_backup'); ?></h4>
    </div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>index.php?school_admin/dashboard">
                    <?php echo get_phrase('Dashboard'); ?>
                </a>
            </li>
            <li class="active">
                <?php echo get_phrase('restore_google_backup'); ?>
            </li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>

<div class="row">
    <div class="col-md-12">
        <div class="white-box">
            <div class="panel-body">
                <section>
                    <?php echo form_open_multipart(base_url() . 'index.php?school_admin/restor_google_backup_action',array('name'=>'restore_google_backup','class' => 'form-groups-bordered validate'));?>
                   <?php //echo form_open(base_url() . 'index.php?school_admin/restor_google_backup_action' , array('name'=>'restore_google_backup','class' => 'form-groups-bordered validate' , 'enctype' => 'multipart/form-data'));?>
                        <div class="col-xs-12 col-md-offset-3 col-md-6 form-group">
                            <label for="field-1"><?php echo get_phrase('upload_backup_file'); ?></label>
                            <div class="col-sm-12 no-padding">
                                <input type="file" id="input-file-now" class="dropify" name="userfile" /> 
                            </div>
                        </div> 
                    <div class="col-md-12 col-xs-12 text-center">
                        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" ><?php echo get_phrase('restore_google_backup');?></button>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</div>