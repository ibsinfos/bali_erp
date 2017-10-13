<div class="row bg-title"> 
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
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


<div class="row">
    <div class="col-md-12 text-right form-group" >
        <a href="<?php echo base_url(); ?>index.php?school_admin/generate_online_poll" class="btn btn-primary btn-circle btn-lg pull-right tooltip-danger" data-toggle="tooltip" data-placement="left" title="" data-original-title="<?php echo get_phrase('create_new_poll');?>">
            <i class="fa fa-plus" data-step="5" data-intro="<?php echo get_phrase('You can create a new  blog here.');?>" data-position='left'></i>
        </a>
    </div>
</div>


<div class="col-md-12 white-box" data-step="6" data-intro="<?php echo get_phrase('List the polls you have published.');?>" data-position='top'>        
    <table class="custom_table table display example" id="polls">
        <thead>
            <tr>
                <th>
                    <div>
                        <?php echo get_phrase('SL'); ?>
                    </div>    
                </th>
                <th>
                    <div>
                        <?php echo get_phrase('poll_title'); ?>
                    </div>
                </th>
                <th>
                    <div>
                        <?php echo get_phrase('posted_on'); ?>
                    </div>
                </th>
                <th>
                    <div>
                        <?php echo get_phrase('class'); ?>
                    </div>
                </th>
                <th>
                    <div>
                        <?php echo get_phrase('total_poll'); ?>
                    </div>
                </th>
                <th>
                    <div>
                        <?php echo get_phrase('status'); ?>
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
            <?php if(!empty($online_polls)){ ?>
                <?php $count = 1;  foreach ($online_polls as $row): ?>
                    <tr>
                        <td>
                            <?php echo $count++; ?>
                        </td>
                        <td>
                            <?php echo $row['poll_title'];?>
                        </td>
                        <td>
                            <div class="btn-group">
                                <?php echo $row['post_date'];?>
                            </div>
                        </td>
                        <td>
                            <div class="btn-group">
                                <?php echo $row['class_name'];?>
                            </div>
                        </td>
                        <td>
                            <div class="btn-group">
                                <?php echo $row['total_poll'];?>
                            </div>
                        </td>
                        <td>
                            <div class="btn-group">
                                <?php 
                                if($row['status'] == 1) {
                                    echo "Active";
                                } else if($row['status'] == 2) {
                                    echo "Closed";
                                } else {
                                    echo "Inactive";
                                }
                                ?>
                            </div>
                        </td>
                        <td>
                            <a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/modal_online_poll_view/<?php echo $row['poll_id']; ?>');"><button class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="View"><i class="fa fa-eye"></i></button></a>
                        <?php if($row['status']!=2){ ?>
                            <a href="#" onclick="custom_confirm_modal('<?php echo base_url(); ?>index.php?school_admin/online_polls/close/<?php echo $row['poll_id']; ?>','Do you want to close this poll');">
                              <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Close"><i class="fa fa-window-close-o"></i></button>
                            </a>
                        <?php } else { ?>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <?php } ?>
                            <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>index.php?school_admin/online_polls/delete/<?php echo $row['poll_id']; ?>');">
                              <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-trash"></i></button>
                            </a>
                        </td>
                    </tr>
            <?php endforeach; } ?>
        </tbody>
    </table>
        
</div>



<script>
    function publish_blog(blog_id) {
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?ajax_controller/blog_available/' + blog_id,
            success: function(response) {
                $("#publish" + blog_id).prop('disabled', true);
                toastr.success('Blog is now public');

            },
            error: function(response) {
                alert("error");
            }
        });
    }
</script>