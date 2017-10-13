<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?></h4>
    </div>
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
</div>

    <div class="col-md-12 white-box" >
        <ul id="sortable2" class="connectedSortable ui-sortable" >

            <li data-step="6" data-intro="<?php echo get_phrase('From here you can create certificate according to the template of your choice.'); ?>" data-position='right' id="55" class="ui-state-highlight ui-sortable-handle" style="cursor:pointer" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_certificate_content/s');"><i class="fa fa-bars"></i><?php echo get_phrase(' create_certificate'); ?></li>

            <a href="<?php echo base_url(); ?>index.php?school_admin/student_certificate_list"><li  data-step="7" data-intro="<?php echo get_phrase('From here you can download the created certificate.'); ?>" data-position='right'id="55" class="ui-state-highlight ui-sortable-handle"><i class="fa fa-bars"></i><?php echo get_phrase(' View_certificate'); ?></li></a>
            <li data-step="8" data-intro="<?php echo get_phrase('From here you can create transfer certificate for a student.'); ?>" data-position='right'id="55" class="ui-state-highlight ui-sortable-handle" style="cursor:pointer" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_get_student_nameforCertificate/tc/create');"><i class="fa fa-bars"></i><?php echo get_phrase(' transfer_certificate'); ?></li>
            <li data-step="9" data-intro="<?php echo get_phrase('From here you can create merit certificate for a student.'); ?>" data-position='right'id="55" class="ui-state-highlight ui-sortable-handle" style="cursor:pointer" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_get_student_nameforCertificate/mc/create');"><i class="fa fa-bars"></i><?php echo get_phrase(' merit_certificate'); ?></li>
            <div data-step="5" data-intro="<?php echo get_phrase('From here you can see the designs of various templates.'); ?>" data-position='top'>
                <a href="<?php echo base_url(); ?>index.php?school_admin/template1"><li  id="55" class="ui-state-highlight ui-sortable-handle" ><i class="fa fa-bars"></i><?php echo get_phrase(' template 1'); ?></li></a>
                <a href="<?php echo base_url(); ?>index.php?school_admin/template2"><li  id="55" class="ui-state-highlight ui-sortable-handle"><i class="fa fa-bars"></i><?php echo get_phrase(' template 2'); ?></li></a>
                <a href="<?php echo base_url(); ?>index.php?school_admin/template3"><li id="55" class="ui-state-highlight ui-sortable-handle"><i class="fa fa-bars"></i><?php echo get_phrase(' template 3'); ?></li></a>
                <a href="<?php echo base_url(); ?>index.php?school_admin/template4"><li id="55" class="ui-state-highlight ui-sortable-handle"><i class="fa fa-bars"></i><?php echo get_phrase(' template 4'); ?></li></a>
        </ul>
    </div>
