<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('view_my_blog'); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>index.php?parents/dashboard">
                    <?php echo get_phrase('Dashboard'); ?>
                </a>
            </li>   
            <li><a href="<?php echo base_url(); ?>index.php?blogs/view_all_blogs"><?php echo get_phrase('view_published_blogs'); ?></a></li>
            <li class="active">
                <?php echo get_phrase('view_my_blog'); ?>
            </li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>

<div class="row">
    <div class="col-md-12 text-right form-group">
        <a href="<?php echo base_url(); ?>index.php?blogs/create_blog" class="btn btn-primary btn-circle btn-lg pull-right tooltip-danger" data-toggle="tooltip" data-placement="left" title="" data-original-title="Create a new blog">
            <i class="fa fa-plus" data-step="5" data-intro="<?php echo get_phrase('You can create a new  blog here');?>" data-position='left'></i>
        </a>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="white-box" data-step="6" data-intro="<?php echo get_phrase('List the blogs you have published');?>" data-position='top'>
            <table class="custom_table table display " id="example">
                <thead>
                    <tr>
                        <th><div>
                            <?php echo get_phrase('no'); ?>
                            </div>
                        </th>
                        <th>
                            <div>
                                <?php echo get_phrase('blog_title'); ?>
                            </div>
                        </th>
                        <th>
                            <div>
                                <?php echo get_phrase('posted_on'); ?>
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
                    <?php if(!empty($my_blogs)){ ?>
                        <?php $count = 1;  foreach ($my_blogs as $row): ?>
                            <tr>
                                <td>
                                    <?php echo $count++; ?>
                                </td>
                                <td>
                                    <?php echo $row['blog_title'];?>
                                </td>
                                <td>
                                    <?php echo $row['blog_created_time'];?>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <?php if($row['blog_available']=="1"){?>
                                            <label>
                                                <?php echo "Published";?>
                                            </label>
                                            <?php } else if($row['blog_available']=="2"){ ?>
                                        <label>
                                                <?php echo "Not Published";?>
                                            </label>
                                            <?php } else if($row['blog_available']=="3"){ ?>
                                        <label>
                                                <?php echo "Admin has resend";?>
                                            </label>
                                            <?php } ?>
                                        
                                    </div>
                                </td>
                                <td>
                                    
                                    <?php if($row['blog_available']=="1"){?>

<!--                                        <a href="<?php echo base_url(); ?>index.php?blogs/view_blogs_details/<?php echo $row['blog_id']; ?>">
                                        <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="View"><i class="fa fa-eye"></i></button>
                                        </a>-->

                                        <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>index.php?blogs/blog_delete/delete/<?php echo $row['blog_id']; ?>');">
                                          <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-trash"></i></button>
                                        </a>

                                        <?php } ?>
                                    <?php if($row['blog_available']=="3"){ ?>
                                      
                                        <a href="<?php echo base_url(); ?>index.php?blogs/blog_edit/edit/<?php echo $row['blog_id'];?>" >
                                            <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-eye"></i></button>
                                          
                                        </a>
                                      
                                        <?php } ?>   

                                        <?php if($row['blog_available']=="2"){ ?>
                                        <a href="<?php echo base_url(); ?>index.php?blogs/blog_preview_for_user/<?php echo $row['blog_id']; ?>">
                                            <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Preview"><i class="fa fa-eye"></i></button>
                                        </a>
                                        <?php } ?>

                                      
                                </td>
                            </tr>
                            <?php endforeach; } ?>
                </tbody>
            </table>
        </div>
    </div>
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