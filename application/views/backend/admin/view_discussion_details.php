<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('view_comments'); ?> </h4></div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>index.php?school_admin/dashboard">
                    <?php echo get_phrase('Dashboard'); ?>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url(); ?>index.php?discussion_forum/view_all_threads">
                    <?php echo get_phrase('view_all_threads'); ?>
                </a>
            </li>
            <li class="active">
                <?php echo get_phrase('view_comments'); ?>
            </li>
        </ol>
    </div>
</div>

<?php if (!empty($details)){?>
<div class="row">
    <div class="col-md-12">
        <div class="row well p-l-0 p-r-0 blog_box">
            <span>                
            </span>
            <div class="col-md-12">
                <div class="col-md-1 pull-left">
                    <?php if($details[0]['discussion_usertype'] == 'teacher'){ ?>
                    <a href=""><img src="<?php echo $this->crud_model->get_image_url('teacher', $details[0]['discussion_userid']);?>" alt="profile image" class="img-circle" width="60" height="60"> </a>
                    <?php }else if($details[0]['discussion_usertype'] == 'admin'){ ?>
                    <a href=""><img src="<?php echo $this->crud_model->get_image_url('admin', $details[0]['discussion_userid']);?>" alt="profile image" class="img-circle" width="60" height="60"> </a>
                    <?php } else if($details[0]['discussion_usertype'] == 'student'){ ?>
                    <a href=""><img src="<?php echo $this->crud_model->get_image_url('student', $details[0]['discussion_userid']);?>" alt="profile image" class="img-circle" width="60" height="60"> </a>
                    <?php }else if($details[0]['discussion_usertype'] == 'parent'){ ?>
                    <a href=""><img src="<?php echo $this->crud_model->get_image_url('parent', $details[0]['discussion_userid']);?>" alt="profile image" class="img-circle" width="60" height="60"> </a>
                    <?php }?>
                    <!--<img src="uploads/user.jpg" class="img-circle" width="60" height="60" alt="user profile image">-->
                </div>
                <div class="col-md-11">
                    <h3 class="col-md-12 p-l-0 m-t-0 m-b-0"><?php echo $details[0]['title']; ?></h3>
                    <h6 class="text-muted time"><?php echo date('M  d, Y', strtotime($details[0]['date_created']));?><i> by </i><?php echo $details[0]['discussion_username']; ?>
                    </h6>
                </div>
            </div>
            <div class="col-md-12 m-t-10 text-font">
                <?php echo $details[0]['discussion_topic']; ?>
                <input type="hidden" value ="<?php echo $details[0]['thread_id'];?>" name = "comment_id">
            </div>
        </div>
    </div>
</div>
<?php }else{ ?>



<?php } ?>

<?php echo form_open(base_url().'index.php?discussion_forum/view_discussion_details/'.$details[0]['thread_id']); ?>
<div class="col-md-12">
    <div class="well col-xs-12">
        <div class="col-xs-1 text-left">            
            <img src="<?php echo $image;?>" alt="profile image" class="img-circle" width="60" height="60">
        </div>
        <div class="col-md-11 p-r-0">
            <textarea name="post_body" class="col-md-10" id="textpost" placeholder=" Add a comment" required></textarea>
            <input type='hidden' name="thread_id" class="col-md-10" id="thread_id" value="<?php echo $details[0]['thread_id']; ?>">
            <span class="col-md-2 text-right">
                <button type="submit" id="comment" name="add_comment" value="add_comment" class="fcbtn btn btn-danger btn-outline btn-1d">
                <?php echo get_phrase('post_comments');?></button></span>
        </div>
    </div>
    <div class="col-md-12 p-10 white-box">
        <h3 class="box-title">
            <?php if(!empty($count)){?>
            <header>
                <h4><?php echo get_phrase('comments')." "."(".$count.")";?></h4>
            </header>
            <?php } else {?>
            <header>
                <h4><?php echo get_phrase('no_comments_posted_yet');?></h4>
            </header>
            <?php }?>
        </h3>
        <?php if(!empty($comments)){ 
        foreach ($comments as $post):        
            //foreach($sub_comments as $sub):?>
            <div class="col-md-12 p-10 white-box">
                <div class="media">
                    <div class="media-left"> 
                        <?php if($post['user_type'] == 'teacher'){ ?>
                        <a href=""><img src="<?php echo $this->crud_model->get_image_url('teacher', $post['user_id']);?>" alt="profile image" class="img-circle" width="60" height="60"> </a>
                        <?php }else if($post['user_type'] == 'admin'){ ?>
                        <a href=""><img src="<?php echo $this->crud_model->get_image_url('admin', $post['user_id']);?>" alt="profile image" class="img-circle" width="60" height="60"> </a>
                        <?php } else if($post['user_type'] == 'student'){ ?>
                        <a href=""><img src="<?php echo $this->crud_model->get_image_url('student', $post['user_id']);?>" alt="profile image" class="img-circle" width="60" height="60"> </a>
                        <?php }else if($post['user_type'] == 'parent'){ ?>
                        <a href=""><img src="<?php echo $this->crud_model->get_image_url('parent', $post['user_id']);?>" alt="profile image" class="img-circle" width="60" height="60"> </a>
                        <?php }?>
                    </div>
                    <div class="media-body">
                        <a><span class="badge badge-danger pull-right" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_add_comment/<?php echo $post['comment_id']; ?>')">REPLY</span></a>
                        <h5 class="media-heading"><span><?php echo $post['user_name'] . ' - ';?></span><span><?php echo date('M, d @ Y H:i', strtotime($post['date_add']));?> </span>
                        </h5>
                        <p><?php echo $post['comment_body']; ?></p>
                    </div>
                    <?php $sub_comments =   get_data_generic_fun('discussion_post','*', array('parent_comment_id'=>$post['comment_id']),'result_arr', array('date_add' => 'desc'));  ?>
                    <?php if(!empty($sub_comments)){  ?>  
                    <div class="media">
                        <div class="media-left"> 
                            <?php if($sub_comments[0]['user_type'] == 'teacher'){ ?>
                            <a href=""><img src="<?php echo $this->crud_model->get_image_url('teacher', $sub_comments[0]['user_id']);?>" alt="profile image" class="img-circle" width="60" height="60"> </a>
                            <?php }else if($sub_comments[0]['user_type'] == 'admin'){ ?>
                            <a href=""><img src="<?php echo $this->crud_model->get_image_url('admin', $sub_comments[0]['user_id']);?>" alt="profile image" class="img-circle" width="60" height="60"> </a>
                            <?php } else if($sub_comments[0]['user_type'] == 'student'){ ?>
                            <a href=""><img src="<?php echo $this->crud_model->get_image_url('student', $sub_comments[0]['user_id']);?>" alt="profile image" class="img-circle" width="60" height="60"> </a>
                            <?php }else if($sub_comments[0]['user_type'] == 'parent'){ ?>
                            <a href=""><img src="<?php echo $this->crud_model->get_image_url('parent', $sub_comments[0]['user_id']);?>" alt="profile image" class="img-circle" width="60" height="60"> </a>
                            <?php }?>
                        </div>
                        <div class="media-body">
                            <a><span class="badge badge-danger pull-right" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_add_comment/<?php echo $sub_comments[0]['comment_id']; ?>')">REPLY</span></a>
                            <h5 class="media-heading"><span><?php echo $sub_comments[0]['user_name'] . ' - ';?></span><span><?php echo date('M, d @ Y H:i', strtotime($sub_comments[0]['date_add']));?> </span>
                            </h5>
                            <p><?php echo $sub_comments[0]['comment_body']; ?></p>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        <?php endforeach;?>
        <?php } ?>
    </div>
</div>
<?php echo form_close(); 



