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


<div>
    <div class="col-md-12 white-box">
        <?php echo form_open(base_url().'index.php?school_admin/admission_settings_update'); ?>
        
            <div class="col-sm-6 form-group" data-step="5" data-intro="<?php echo get_phrase('Choose_academic_year_from_here.');?>" data-position='bottom'>
                <label class="control-label">
                    <?php echo get_phrase('Academic_Year'); ?>
                </label>
                <select class="selectpicker" data-style="form-control" data-live-search="true" name="running_year" id="running_year">
                    <option value="">
                        <?php echo get_phrase('select_running_session');?>
                    </option>
                    <?php for($i = 0; $i < 10; $i++):?>
                        <option value="<?php echo $cYear-$i-1;?>-<?php echo ($cYear-$i);?>" <?php if($student_running_year==( $cYear-$i-1). '-'.($cYear-$i)) echo 'selected';?>>
                            <?php echo ($cYear-$i-1);?>-
                                <?php echo ($cYear-$i);?>
                        </option>
                        <?php endfor;?>
                </select>
            </div>
            <div class="col-sm-6 form-group p-l-30" data-step="6" data-intro="<?php echo get_phrase('You_can_set_on/off_from_here.');?>" data-position='bottom'>
                <label class="control-label">
                    <?php echo get_phrase('Admission_off_/_on'); ?>
                </label>
                <div class="switchery-demo tooltip-danger" data-toggle="tooltip" data-placement="left" title="" data-original-title="<?php if($admission_settings_state==1){?>ON<?php }else{?>OFF<?php }?>">
                    <input type="checkbox" <?php if($admission_settings_state==1){?>checked
                    <?php }?> class="js-switch" data-color="#6164c1" name="admission_settings_state"/>
                </div>
        </div>
        <div class="col-md-12 text-right">
                    <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" data-step="7" data-intro="<?php echo get_phrase('You_can_submit_from_here.');?>" data-position='left'>
                        <?php echo get_phrase('Submit'); ?>
                    </button>
                </div>
    </div>