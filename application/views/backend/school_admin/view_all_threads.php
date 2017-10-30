<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('view_discussion_posts'); ?> </h4></div>
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
<div class="row">
    <div class="col-md-12 m-b-20">
        <a href="<?php echo base_url(); ?>index.php?discussion_forum/create_thread/" class="btn btn-primary btn-circle btn-lg pull-right tooltip-danger" data-toggle="tooltip" data-placement="left" title="" data-original-title="Add New Thread" data-step="5" data-intro="<?php echo get_phrase('From_here_you_can_post_a_new_disucssion_topic'); ?>" data-position='left'><i class="fa fa-plus"></i>
        </a>
    </div>
</div>
<div class="row">
    <div class="col-md-12">

        <div class="white-box" data-step="6" data-position="top" data-intro="<?php echo get_phrase('Here_you_can_view_the_discussion_posts'); ?>."> 
            <table class= "custom_table table display" cellspacing="0" width="100%" id="example">
                <thead>
                    <tr>
                        <th><div>
                                <?php echo get_phrase('no'); ?>
                            </div>    
                        </th>
                        <th>
                            <div>
                                <?php echo get_phrase('recent_discussions'); ?></div>
                        </th>
                        <th>
                            <div>
                                <?php echo get_phrase('discussion_category'); ?>
                            </div>
                        </th>
                        <th>
                            <div>
                                <?php echo get_phrase('action'); ?>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php $count1 = 1; ?>
                    <?php foreach ($threads as $t) { ?>
                        <tr>
                            <td>
                                <?php echo $count1++; ?>
                            </td>
                            <td>
                                <div>
                                    <b><?php echo $t['title']; ?></b>
                                </div>
                                <span class='center-block'><?php echo date('d, M Y @ H:i', strtotime($t['date_created'])); ?><?php echo " by " . $t['discussion_username']; ?></span>
                            </td>
                            <td>
                                <?php echo $t['name']; ?>
                            </td>
                            <td>
                                <a href="<?php echo base_url(); ?>index.php?discussion_forum/view_discussion_details/<?php echo $t['thread_id']; ?>">
                                    <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="View Thread"><i class="fa fa-eye"></i></button>
                                </a>

                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
