<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12"><h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
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


<div class="col-md-12 white-box">

    <section data-step="5" data-intro="<?php echo get_phrase('Here you can different type of exam setting.');?>" data-position='bottom'>
        <div class="sttabs tabs-style-flip">
            <!------CONTROL TABS START------>
            <nav>
                <ul>
                    <li id="cce_outer" <?php
                    if (isset($SelectedTab) && $SelectedTab == 'cce') {
                        echo "class='tab-current'";
                    }
                    ?>><a href="#cce"><span><i class="ti-settings"></i> <?php echo get_phrase('CCE_settings'); ?></span></a></li>
                    <li class="DoNotConflict <?php
                    if (isset($SelectedTab) && $SelectedTab == 'cwa') {
                        echo "tab-current";
                    }
                    ?>"><a href="#cwa"><span><i class="ti-settings"></i> <?php echo get_phrase('CWA_settings'); ?></span></a></li>
                    <li class="DoNotConflict <?php
                        if (isset($SelectedTab) && $SelectedTab == 'gpa') {
                            echo "tab-current";
                        }
                        ?>"><a href="#gpa"><span><i class="ti-settings"></i> <?php echo get_phrase('GPA_settings'); ?></span></a></li>
                    <li class="DoNotConflict <?php
                        if (isset($SelectedTab) && $SelectedTab == 'ibo') {
                            echo "tab-current";
                        }
                        ?>"><a href="#ibo"><span><i class="ti-settings"></i> IBO Settings</span></a></li>
                    <li class="DoNotConflict <?php
                        if (isset($SelectedTab) && $SelectedTab == 'igcse') {
                            echo "tab-current";
                        }
                        ?>"><a href="#ibo"><span><i class="ti-settings"></i> IGCSE Settings</span></a></li>
                    <li class="DoNotConflict <?php
                        if (isset($SelectedTab) && $SelectedTab == 'icse') {
                            echo "tab-current";
                        }
                        ?>"><a href="#icse"><span><i class="ti-settings"></i> ICSE Settings</span></a></li>
                </ul>
            </nav>
            <!------CONTROL TABS END------>
            <div class="content-wrap">
                <!----TABLE LISTING STARTS-->
                <section id="cce" <?php
                    if (isset($SelectedTab) && $SelectedTab == 'cce') {
                        echo "class='ShowTab'";
                    }
                    ?>>

                    <div class="row">
                        <div class="col-lg-3 col-sm-4  col-xs-12">
                            <div class="white-box exam-setting-box">
                                <h3 class="m-t-0 m-b-20 text-center"><b><?php echo get_phrase('add_classes'); ?></b></h3>
                                <ul class="list-inline text-center">
                                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_add_classes/cce');">
                                        <button  type="button" class="btn btn-default btn-outline btn-circle btn-xl m-r-5"><i class="fa fa-plus-circle"></i></button>
                                    </a>
                                </ul>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-4  col-xs-12">
                            <div class="white-box exam-setting-box">
                                <h3 class="m-t-0 m-b-20 text-center"><b><?php echo get_phrase('add_subjects'); ?></b></h3>
                                <ul class="list-inline text-center">
                                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_add_subjects/cce');">
                                        <button  type="button" class="btn btn-default btn-outline btn-circle btn-xl m-r-5"><i class="fa fa-book"></i></button>
                                    </a>
                                </ul>
                            </div>
                        </div>

                        <!-- <div class="col-lg-3 col-sm-4  col-xs-12">
                            <div class="white-box exam-setting-box">
                                <h3 class="m-t-0 m-b-20 text-center"><b><?php echo get_phrase('periodic_test_marks'); ?></b></h3>
                                <ul class="list-inline text-center">
                                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_pt_settings/<?php echo $pt_max;?>');">
                                        <button  type="button" class="btn btn-default btn-outline btn-circle btn-xl m-r-5"><i class="fa fa-plus-circle"></i></button>
                                    </a>
                                </ul>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-4  col-xs-12">
                            <div class="white-box exam-setting-box">
                                <h3 class="m-t-0 m-b-20 text-center"><b><?php echo get_phrase('notebook_submission_marks'); ?></b></h3>
                                <ul class="list-inline text-center">
                                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_notebook_settings/<?php echo $notebook_max;?>');">
                                        <button  type="button" class="btn btn-default btn-outline btn-circle btn-xl m-r-5"><i class="fa fa-plus-circle"></i></button>
                                    </a>
                                </ul>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-4  col-xs-12">
                            <div class="white-box exam-setting-box">
                                <h3 class="m-t-0 m-b-20 text-center"><b><?php echo get_phrase('subject_enrichment_marks'); ?></b></h3>
                                <ul class="list-inline text-center">
                                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_se_settings/<?php echo $se_max;?>');">
                                        <button  type="button" class="btn btn-default btn-outline btn-circle btn-xl m-r-5"><i class="fa fa-plus-circle"></i></button>
                                    </a>
                                </ul>
                            </div>
                        </div> -->

                        <div class="col-lg-3 col-sm-4  col-xs-12">
                            <div class="white-box exam-setting-box">
                                <h3 class="m-t-0 m-b-20 text-center"><b><?php echo get_phrase('Co- Scholastic_Activities'); ?></b></h3>
                                <ul class="list-inline text-center">
                                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_add_cs_activities');">
                                        <button  type="button" class="btn btn-default btn-outline btn-circle btn-xl m-r-5"><i class="fa fa-plus-circle"></i></button>
                                    </a>
                                </ul>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-4  col-xs-12">
                            <div class="white-box exam-setting-box">
                                <h3 class="m-t-0 m-b-20 text-center"><b><?php echo get_phrase('marks_Co- Scholastic_Activities'); ?></b></h3>
                                <ul class="list-inline text-center">
                                    <a href="<?php echo base_url(); ?>index.php?school_admin/csa_marks_manage">
                                        <button  type="button" class="btn btn-default btn-outline btn-circle btn-xl m-r-5">
                                            <i class="fa fa-check-circle"></i>
                                        </button>
                                    </a>
                                </ul>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-4  col-xs-12">
                            <div class="white-box exam-setting-box">
                                <h3 class="m-t-0 m-b-20 text-center"><b><?php echo get_phrase('connect_exams'); ?></b></h3>
                                <ul class="list-inline text-center">
                                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_cce_exams_connect/');">
                                        <button  type="button" class="btn btn-default btn-outline btn-circle btn-xl m-r-5"><i class="fa fa-link"></i></button>
                                    </a>
                                </ul>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-4  col-xs-12">
                            <div class="white-box">
                                <h3 class="m-t-0 m-b-20 text-center"><b><?php echo get_phrase('manage_marks'); ?></b></h3>
                                <ul class="list-inline text-center">
                                    <a href="<?php echo base_url(); ?>index.php?school_admin/cce_manage_marks">
                                        <button  type="button" class="btn btn-default btn-outline btn-circle btn-xl m-r-5"><i class="fa fa-cog"></i></button>
                                    </a>
                                </ul>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-4  col-xs-12">
                            <div class="white-box">
                                <h3 class="m-t-0 m-b-20 text-center"><b><?php echo get_phrase('report_cards'); ?></b></h3>
                                <ul class="list-inline text-center">
                                    <a href="<?php echo base_url(); ?>index.php?school_admin/cce_report_card">
                                        <button  type="button" class="btn btn-default btn-outline btn-circle btn-xl m-r-5"><i class="fa fa-address-card-o"></i></button>
                                    </a>
                                </ul>
                            </div>
                        </div>
                    </div>
                </section>
                <!----TABLE LISTING ENDS--->
                <!----CREATION FORM STARTS---->
                <section id="cwa" <?php
                    if (isset($SelectedTab) && $SelectedTab == 'cwa') {
                        echo "class='ShowTab'";
                    }
                    ?>>

                    <div class="row">
                        <div class="col-lg-3 col-sm-4  col-xs-12">
                            <div class="white-box exam-setting-box">
                                <h3 class="m-t-0 m-b-20 text-center"><b><?php echo get_phrase('add_classes'); ?></b></h3>
                                <ul class="list-inline text-center">
                                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_add_classes/cwa');">
                                        <button  type="button" class="btn btn-default btn-outline btn-circle btn-xl m-r-5"><i class="fa fa-plus-circle"></i></button>
                                    </a>
                                </ul>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-4  col-xs-12">
                            <div class="white-box exam-setting-box">
                                <h3 class="m-t-0 m-b-20 text-center"><b><?php echo get_phrase('add_subjects'); ?></b></h3>
                                <ul class="list-inline text-center">
                                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_add_subjects/cwa');">
                                        <button  type="button" class="btn btn-default btn-outline btn-circle btn-xl m-r-5"><i class="fa fa-book"></i></button>
                                    </a>
                                </ul>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-4  col-xs-12">
                            <div class="white-box exam-setting-box">
                                <h3 class="m-t-0 m-b-20 text-center"><b><?php echo get_phrase('connect_exams'); ?></b></h3>
                                <ul class="list-inline text-center">
                                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_cwa_exams_connect/');">
                                        <button  type="button" class="btn btn-default btn-outline btn-circle btn-xl m-r-5"><i class="fa fa-link"></i></button>
                                    </a>
                                </ul>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-4  col-xs-12">
                            <div class="white-box exam-setting-box">
                                <h3 class="m-t-0 m-b-20 text-center"><b><?php echo get_phrase('manage_marks'); ?></b></h3>
                                <ul class="list-inline text-center">
                                    <a href="<?php echo base_url(); ?>index.php?school_admin/cwa_manage_marks">
                                        <button  type="button" class="btn btn-default btn-outline btn-circle btn-xl m-r-5"><i class="fa fa-cog"></i></button>
                                    </a>
                                </ul>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-4  col-xs-12">
                            <div class="white-box">
                                <h3 class="m-t-0 m-b-20 text-center"><b><?php echo get_phrase('report_cards'); ?></b></h3>
                                <ul class="list-inline text-center">
                                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/cwa_consolidated_report');">
                                        <button  type="button" class="btn btn-default btn-outline btn-circle btn-xl m-r-5"><i class="fa fa-address-card-o"></i></button>
                                    </a>
                                </ul>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-4  col-xs-12">
                            <div class="white-box exam-setting-box">
                                <h3 class="m-t-0 m-b-20 text-center"><b><?php echo get_phrase('ranking_levels'); ?></b></h3>
                                <ul class="list-inline text-center">
                                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_cwa_ranking/');">
                                        <button  type="button" class="btn btn-default btn-outline btn-circle btn-xl m-r-5"><i class="fa fa-bar-chart"></i></button>
                                    </a>
                                </ul>
                            </div>
                        </div> 
                    </div>
                </section>
                <!----CREATION FORM ENDS-->
                <!----GPA SETTINGS STARTS---->
                <section id="gpa" <?php
                    if (isset($SelectedTab) && $SelectedTab == 'gpa') {
                         echo "class='ShowTab'";
                    }
                    ?>>
                    
                    <div class="row">
                        <div class="col-lg-3 col-sm-4  col-xs-12">
                            <div class="white-box exam-setting-box">
                                <h3 class="m-t-0 m-b-20 text-center"><b><?php echo get_phrase('add_classes'); ?></b></h3>
                                <ul class="list-inline text-center">
                                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_add_classes/gpa');">
                                        <button  type="button" class="btn btn-default btn-outline btn-circle btn-xl m-r-5"><i class="fa fa-plus-circle"></i></button>
                                    </a>
                                </ul>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-4  col-xs-12">
                            <div class="white-box exam-setting-box">
                                <h3 class="m-t-0 m-b-20 text-center"><b><?php echo get_phrase('add_subjects'); ?></b></h3>
                                <ul class="list-inline text-center">
                                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_add_subjects/gpa');">
                                        <button  type="button" class="btn btn-default btn-outline btn-circle btn-xl m-r-5"><i class="fa fa-book"></i></button>
                                    </a>
                                </ul>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-4  col-xs-12">
                            <div class="white-box exam-setting-box">
                                <h3 class="m-t-0 m-b-20 text-center"><b><?php echo get_phrase('connect_exams'); ?></b></h3>
                                <ul class="list-inline text-center">
                                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_gpa_exam_connect/');">
                                        <button  type="button" class="btn btn-default btn-outline btn-circle btn-xl m-r-5"><i class="fa fa-link"></i></button>
                                    </a>
                                </ul>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-4  col-xs-12">
                            <div class="white-box exam-setting-box">
                                <h3 class="m-t-0 m-b-20 text-center"><b><?php echo get_phrase('manage_marks'); ?></b></h3>
                                <ul class="list-inline text-center">
                                    <a href="<?php echo base_url(); ?>index.php?school_admin/gpa_manage_marks">
                                        <button  type="button" class="btn btn-default btn-outline btn-circle btn-xl m-r-5"><i class="fa fa-cog"></i></button>
                                    </a>
                                </ul>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-4  col-xs-12">
                            <div class="white-box exam-setting-box">
                                <h3 class="m-t-0 m-b-20 text-center"><b><?php echo get_phrase('report_cards'); ?></b></h3>
                                <ul class="list-inline text-center">
                                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/gpa_consolidated_report');">
                                        <button  type="button" class="btn btn-default btn-outline btn-circle btn-xl m-r-5"><i class="fa fa-address-card-o"></i></button>
                                    </a>
                                </ul>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-4  col-xs-12">
                            <div class="white-box exam-setting-box">
                                <h3 class="m-t-0 m-b-20 text-center"><b><?php echo get_phrase('ranking_levels'); ?></b></h3>
                                <ul class="list-inline text-center">
                                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_gpa_ranking/');">
                                        <button  type="button" class="btn btn-default btn-outline btn-circle btn-xl m-r-5"><i class="fa fa-bar-chart"></i></button>
                                    </a>
                                </ul>
                            </div>
                        </div> 
                        
                        <div class="col-lg-3 col-sm-4  col-xs-12">
                            <div class="white-box exam-setting-box">
                                <h3 class="m-t-0 m-b-20 text-center"><b><?php echo get_phrase('calculation_selection'); ?></b></h3>
                                <ul class="list-inline text-center">
                                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_gpa_preference/');">
                                        <button  type="button" class="btn btn-default btn-outline btn-circle btn-xl m-r-5"><i class="fa fa-check-circle"></i></button>
                                    </a>
                                </ul>
                            </div>
                        </div> 
                    </div>                       
                </section>
                <!----GPA settings ENDS-->  

                <!-- IBO Settings Start -->  
                <!----TABLE LISTING STARTS-->
                <section id="ibo" <?php
                    if (isset($SelectedTab) && $SelectedTab == 'ibo') {
                         echo "class='ShowTab'";
                    }
                    ?>>

                    <div class="row">
                        <div class="col-lg-3 col-sm-4  col-xs-12">
                            <div class="white-box exam-setting-box">
                                <h3 class="m-t-0 m-b-20 text-center"><b><?php echo get_phrase('IBO_programs'); ?></b></h3>
                                <ul class="list-inline text-center">
                                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_add_program');">
                                        <button  type="button" class="btn btn-default btn-outline btn-circle btn-xl m-r-5"><i class="fa fa-folder-open"></i></button>
                                    </a>
                                </ul>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-4  col-xs-12">
                            <div class="white-box exam-setting-box">
                                <h3 class="m-t-0 m-b-20 text-center"><b><?php echo get_phrase('add_classes'); ?></b></h3>
                                <ul class="list-inline text-center">
                                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_add_classes/ibo');">
                                        <button  type="button" class="btn btn-default btn-outline btn-circle btn-xl m-r-5"><i class="fa fa-plus-circle"></i></button>
                                    </a>
                                </ul>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-4  col-xs-12">
                            <div class="white-box exam-setting-box">
                                <h3 class="m-t-0 m-b-20 text-center"><b><?php echo get_phrase('class_assign_program'); ?></b></h3>
                                <ul class="list-inline text-center">
                                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_assign_ibo_program');">
                                        <button  type="button" class="btn btn-default btn-outline btn-circle btn-xl m-r-5"><i class="fa fa-check-circle"></i></button>
                                    </a>
                                </ul>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-4  col-xs-12">
                            <div class="white-box exam-setting-box">
                                <h3 class="m-t-0 m-b-20 text-center"><b><?php echo get_phrase('add_subjects'); ?></b></h3>
                                <ul class="list-inline text-center">
                                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_add_subjects/ibo');">
                                        <button  type="button" class="btn btn-default btn-outline btn-circle btn-xl m-r-5"><i class="fa fa-book"></i></button>
                                    </a>
                                </ul>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-4  col-xs-12">
                            <div class="white-box exam-setting-box">
                                <h3 class="m-t-0 m-b-20 text-center"><b><?php echo get_phrase('program_assessment'); ?></b></h3>
                                <ul class="list-inline text-center">
                                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_ibo_programs')">
                                        <button  type="button" class="btn btn-default btn-outline btn-circle btn-xl m-r-5"><i class="fa fa-bar-chart"></i></button>
                                    </a>
                                </ul>
                            </div>
                        </div>
                            
                        <div class="col-lg-3 col-sm-4  col-xs-12">
                            <div class="white-box exam-setting-box exam-setting-box">
                                <h3 class="m-t-0 m-b-20 text-center"><b><?php echo get_phrase('connect_exams'); ?></b></h3>
                                <ul class="list-inline text-center">
                                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_ibo_exam');">
                                        <button  type="button" class="btn btn-default btn-outline btn-circle btn-xl m-r-5"><i class="fa fa-link"></i></button>
                                    </a>
                                </ul>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-4  col-xs-12">
                            <div class="white-box exam-setting-box exam-setting-box">
                                <h3 class="m-t-0 m-b-20 text-center"><b><?php echo get_phrase('manage_marks'); ?></b></h3>
                                <ul class="list-inline text-center">
                                    <a href="<?php echo base_url(); ?>index.php?school_admin/ibo_manage_marks">
                                        <button  type="button" class="btn btn-default btn-outline btn-circle btn-xl m-r-5"><i class="fa fa-line-chart"></i></button>
                                    </a>
                                </ul>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-4  col-xs-12">
                            <div class="white-box">
                                <h3 class="m-t-0 m-b-20 text-center"><b><?php echo get_phrase('report_cards'); ?></b></h3>
                                <ul class="list-inline text-center">
                                    <a href="<?php echo base_url(); ?>index.php?school_admin/ibo_report_card">
                                        <button  type="button" class="btn btn-default btn-outline btn-circle btn-xl m-r-5"><i class="fa fa-address-card-o"></i></button>
                                    </a>
                                </ul>
                            </div>
                        </div>
                    </div>
                 </section>
                    <!--TABLE LISTING ENDS-->
                     <!--TABLE IGCSE Starts--> 
                <section id="igcse" <?php
                    if (isset($SelectedTab) && $SelectedTab == 'igcse') {
                         echo "class='ShowTab'";
                    }
                    ?>>
                    <div class="row">
                        <div class="col-lg-3 col-sm-4  col-xs-12">
                            <div class="white-box exam-setting-box">
                                <h3 class="m-t-0 m-b-20 text-center"><b><?php echo get_phrase('add_classes'); ?></b></h3>
                                <ul class="list-inline text-center">
                                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_add_classes/igcse');">
                                        <button  type="button" class="btn btn-default btn-outline btn-circle btn-xl m-r-5"><i class="fa fa-plus-circle"></i></button>
                                    </a>
                                </ul>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-4  col-xs-12">
                            <div class="white-box exam-setting-box">
                                <h3 class="m-t-0 m-b-20 text-center"><b><?php echo get_phrase('add_subjects'); ?></b></h3>
                                <ul class="list-inline text-center">
                                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_add_subjects/igcse');">
                                        <button  type="button" class="btn btn-default btn-outline btn-circle btn-xl m-r-5"><i class="fa fa-book"></i></button>
                                    </a>
                                </ul>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-4  col-xs-12">
                            <div class="white-box exam-setting-box">
                                <h3 class="m-t-0 m-b-20 text-center"><b><?php echo get_phrase('connect_exams'); ?></b></h3>
                                <ul class="list-inline text-center">
                                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_igcse_exams_connect/');">
                                        <button  type="button" class="btn btn-default btn-outline btn-circle btn-xl m-r-5"><i class="fa fa-link"></i></button>
                                    </a>
                                </ul>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-4  col-xs-12">
                            <div class="white-box exam-setting-box">
                                <h3 class="m-t-0 m-b-20 text-center"><b><?php echo get_phrase('manage_marks'); ?></b></h3>
                                <ul class="list-inline text-center">
                                    <a href="<?php echo base_url(); ?>index.php?school_admin/igcse_manage_marks">
                                        <button  type="button" class="btn btn-default btn-outline btn-circle btn-xl m-r-5"><i class="fa fa-cog"></i></button>
                                    </a>
                                </ul>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-4  col-xs-12">
                            <div class="white-box">
                                <h3 class="m-t-0 m-b-20 text-center"><b><?php echo get_phrase('report_cards'); ?></b></h3>
                                <ul class="list-inline text-center">
                                    <a href="<?php echo base_url(); ?>index.php?school_admin/igcse_report_card">
                                        <button  type="button" class="btn btn-default btn-outline btn-circle btn-xl m-r-5"><i class="fa fa-address-card-o"></i></button>
                                    </a>
                                </ul>
                            </div>
                        </div>
                    
                 </section>     
                    <!-- IBO IGCSE End -->    
                <!----CREATION FORM STARTS---->
                <section id="icse" <?php
                        if (isset($SelectedTab) && $SelectedTab == 'icse') {
                            echo "class='ShowTab'";
                        }
                        ?>>

                    <div class="row">
                        <div class="col-lg-3 col-sm-4  col-xs-12">
                            <div class="white-box exam-setting-box">
                                <h3 class="m-t-0 m-b-20 text-center"><b><?php echo get_phrase('add_classes'); ?></b></h3>
                                <ul class="list-inline text-center">
                                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_add_classes/icse');">
                                        <button  type="button" class="btn btn-default btn-outline btn-circle btn-xl m-r-5"><i class="fa fa-plus-circle"></i></button>
                                    </a>
                                </ul>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-4  col-xs-12">
                            <div class="white-box exam-setting-box">
                                <h3 class="m-t-0 m-b-20 text-center"><b><?php echo get_phrase('add_subjects'); ?></b></h3>
                                <ul class="list-inline text-center">
                                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_add_subjects/icse');">
                                        <button  type="button" class="btn btn-default btn-outline btn-circle btn-xl m-r-5"><i class="fa fa-book"></i></button>
                                    </a>
                                </ul>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-4  col-xs-12">
                            <div class="white-box exam-setting-box">
                                <h3 class="m-t-0 m-b-20 text-center"><b><?php echo get_phrase('connect_exams'); ?></b></h3>
                                <ul class="list-inline text-center">
                                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_icse_exams_connect/');">
                                        <button  type="button" class="btn btn-default btn-outline btn-circle btn-xl m-r-5"><i class="fa fa-link"></i></button>
                                    </a>
                                </ul>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-4  col-xs-12">
                            <div class="white-box exam-setting-box">
                                <h3 class="m-t-0 m-b-20 text-center"><b><?php echo get_phrase('manage_marks'); ?></b></h3>
                                <ul class="list-inline text-center">
                                    <a href="<?php echo base_url(); ?>index.php?school_admin/icse_manage_marks">
                                        <button  type="button" class="btn btn-default btn-outline btn-circle btn-xl m-r-5"><i class="fa fa-cog"></i></button>
                                    </a>
                                </ul>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-4  col-xs-12">
                            <div class="white-box">
                                <h3 class="m-t-0 m-b-20 text-center"><b><?php echo get_phrase('report_cards'); ?></b></h3>
                                <ul class="list-inline text-center">
                                    <a href="<?php echo base_url(); ?>index.php?school_admin/icse_report_card">
                                        <button  type="button" class="btn btn-default btn-outline btn-circle btn-xl m-r-5"><i class="fa fa-address-card-o"></i></button>
                                    </a>
                                </ul>
                            </div>
                        </div>

                        
                </section>
                <!----CREATION FORM ENDS-->      
                    </div>
                </div>
            </section>
          
        </div>
    </section>
</div>

