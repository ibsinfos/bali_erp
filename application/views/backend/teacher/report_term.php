<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12"><h4 class="page-title"><?php echo get_phrase('progress_reports_settings'); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>

        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?teacher/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li>Progress Report
                <ul>                    
                    <li><a href="<?php echo base_url(); ?>index.php?teacher/progress_report_heading_wise"><?php echo get_phrase('progress_details'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?teacher/progress_report_heading_setting"><?php echo get_phrase('progress_report_setting'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?teacher/progress_report"><?php echo get_phrase('subject_wise'); ?></a></li>  
                </ul>
            </li>
            <li class="active">
                <?php echo get_phrase('report_term'); ?>
            </li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>

<div class="panel panel-danger block6" data-step="5" data-intro="<?php echo get_phrase('For Information');?>" data-position='bottom'>
    <div class="panel-heading"> Teacher Notes
        <div class="pull-right"><a href="#" data-perform="panel-collapse"><i class="ti-minus"></i></a> <a href="#" data-perform="panel-dismiss"><i class="ti-close"></i></a> </div>
    </div>
    <div class="panel-wrapper collapse in" aria-expanded="true">
        <div class="panel-body">
            <p>Dear Teacher please add Terms Year wise.</p>
        </div>
    </div>
</div>
<div class="row m-0">
<div class="col-md-12 white-box">
    <div class="sttabs tabs-style-flip">
        <nav>
            <ul>
                <li class="active">
                    <a href="#section-flip-1" class="sticon fa fa-list"><span><?php echo get_phrase('all_terms'); ?></span>
                    </a>
                </li>
                <li><a href="#add" class="sticon fa fa-plus-circle">
                        <span><?php echo get_phrase('add_term'); ?></span>
                    </a>
                </li>
            </ul>
        </nav>
        <div class="content-wrap">
            <section id="section-flip-1">          
                <table class= "custom_table table display" cellspacing="0" width="100%" id="example23">
                    <thead>
                        <tr>
                            <th><div><?php echo get_phrase('s.no'); ?></div></th>
                            <th width="70%"><div><?php echo get_phrase('name'); ?></div></th>
                            <th><div><?php echo get_phrase('options'); ?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($term_list)):   
                            $count = 1;
                            foreach($term_list as $row){ ?>
                        <tr>
                    <td><?php echo $count++; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td>
                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/modal_edit_term/<?php echo $row['term_id']; ?>');" ><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil-square-o"></i></button></a>
                                    <!--delete-->
                    <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>index.php?teacher/report_term/delete/<?php echo $row['term_id']; ?>');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-trash-o"></i></button></a>
                    </td>
                        </tr>
                            <?php }
                            endif; ?>
                    </tbody>
                </table>

            </section>

            <section id="add">
                <form class="form-horizontal form-groups-bordered validate" name='add_term' id="add_exam_form" method="post" action="<?php echo base_url(); ?>index.php?teacher/report_term/create">
                    <div class="row">          
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="field-1"><?php echo get_phrase('term'); ?></label>
                            <input type="text" class="form-control" id="term" name="term" data-validate="required" required="required" data-message-required="<?php echo get_phrase('value_required'); ?>" placeholder="Please enter term">
                        </div> 
                    </div>
                    <div class="text-right">
                        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('submit'); ?></button>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>
</div>