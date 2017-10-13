<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
    <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);"  onclick="javascript:introJs().start();" id="take-tour"  class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        
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


<div class="col-xs-12 white-box">
    <input type="hidden" name="running_year" id="running_year" value="<?php echo $running_year;?>">
    <div class="form-group col-sm-4" data-step="5" data-intro="<?php echo get_phrase('Select a teacher, then you will get a list of all classes with their all subjects.');?>" data-position='right'>
        <label class="control-label"><?php echo get_phrase('select_class'); ?></label>
        <select class="selectpicker" data-style="form-control" data-live-search="true">
            <option value=""><?php echo get_phrase('select'); ?></option>            
        </select>
    </div>

    <div class="col-sm-4 form-group" data-step="6" data-intro="<?php echo get_phrase('Select a class, then you will get a list of all subjects.');?>" data-position='right'>
        <label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('select_section'); ?></label><span class="error" style="color: red;"></span>

        <select class="selectpicker" data-style="form-control" data-live-search="true">
            <option value=""><?php echo get_phrase('select'); ?></option>
        </select>
    </div>

    <div class="form-group col-sm-4" data-step="7" data-intro="<?php echo get_phrase('Select a subject for set a priority.');?>" data-position='right'>
        <label class="control-label"><?php echo get_phrase('select_subject'); ?></label>
        <select class="selectpicker" data-style="form-control" data-live-search="true">
            <option value=""><?php echo get_phrase('select'); ?></option>            
        </select>
    </div>

    <div class="form-group col-sm-4" data-step="8" data-intro="<?php echo get_phrase('Select a priority to set.');?>" data-position='right'>
        <label class="control-label"><?php echo get_phrase('start_time'); ?></label>
        <select class="selectpicker" data-style="form-control" data-live-search="true">
            <option value=""><?php echo get_phrase('select'); ?></option>            
        </select>
    </div>

    <div class="form-group col-sm-4" data-step="8" data-intro="<?php echo get_phrase('Select a priority to set.');?>" data-position='right'>
        <label class="control-label"><?php echo get_phrase('end_time'); ?></label>
        <select class="selectpicker" data-style="form-control" data-live-search="true">
            <option value=""><?php echo get_phrase('select'); ?></option>            
        </select>
    </div>

    <div class="form-group col-sm-4" data-step="8" data-intro="<?php echo get_phrase('Select a priority to set.');?>" data-position='right'>
        <label class="control-label"><?php echo get_phrase('duration_(in_minutes)'); ?></label>
        <select class="selectpicker" data-style="form-control" data-live-search="true">
            <option value=""><?php echo get_phrase('select'); ?></option>            
        </select>
    </div>

    <div class="form-group col-sm-4" data-step="8" data-intro="<?php echo get_phrase('Select a priority to set.');?>" data-position='right'>
        <label class="control-label"><?php echo get_phrase('number_of_classes'); ?></label>
        <select class="selectpicker" data-style="form-control" data-live-search="true">
            <option value=""><?php echo get_phrase('select'); ?></option>            
        </select>
    </div>

    <div class="form-group col-sm-4" data-step="8" data-intro="<?php echo get_phrase('Select a priority to set.');?>" data-position='right'>
        <label class="control-label"><?php echo get_phrase('maximum_number_of_continuous_classes'); ?></label>
        <select class="selectpicker" data-style="form-control" data-live-search="true">
            <option value=""><?php echo get_phrase('select'); ?></option>            
        </select>
    </div>

    <div class="text-right">
        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('add_timetable'); ?></button>
    </div>

</div>