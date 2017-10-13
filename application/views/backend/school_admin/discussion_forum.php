<style>

.panel-shadow {
    box-shadow: rgba(0, 0, 0, 0.3) 7px 7px 7px;
}
.panel-white {
  border: 1px solid #dddddd;
}
.panel-white  .panel-heading {
  color: #333;
  background-color: #fff;
  border-color: #ddd;
}
.panel-white  .panel-footer {
  background-color: #fff;
  border-color: #ddd;
}

.post .post-heading {
  height: 95px;
  padding: 20px 15px;
}
.post .post-heading .avatar {
  width: 60px;
  height: 60px;
  display: block;
  margin-right: 15px;
}
.post .post-heading .meta .title {
  margin-bottom: 0;
}
.post .post-heading .meta .title a {
  color: black;
}
.post .post-heading .meta .title a:hover {
  color: #aaaaaa;
}
.post .post-heading .meta .time {
  margin-top: 8px;
  color: #999;
}
.post .post-image .image {
  width: 100%;
  height: auto;
}
.post .post-description {
  padding: 15px;
}
.post .post-description p {
  font-size: 14px;
}
.post .post-description .stats {
  margin-top: 20px;
}
.post .post-description .stats .stat-item {
  display: inline-block;
  margin-right: 15px;
}
.post .post-description .stats .stat-item .icon {
  margin-right: 8px;
}
.post .post-footer {
  border-top: 1px solid #ddd;
  padding: 15px;
}
.post .post-footer .input-group-addon a {
  color: #454545;
}
.post .post-footer .comments-list {
  padding: 0;
  margin-top: 20px;
  list-style-type: none;
}
.post .post-footer .comments-list .comment {
  display: block;
  width: 100%;
  margin: 20px 0;
}
.post .post-footer .comments-list .comment .avatar {
  width: 35px;
  height: 35px;
}
.post .post-footer .comments-list .comment .comment-heading {
  display: block;
  width: 100%;
}
.post .post-footer .comments-list .comment .comment-heading .user {
  font-size: 14px;
  font-weight: bold;
  display: inline;
  margin-top: 0;
  margin-right: 10px;
}
.post .post-footer .comments-list .comment .comment-heading .time {
  font-size: 12px;
  color: #aaa;
  margin-top: 0;
  display: inline;
}
.post .post-footer .comments-list .comment .comment-body {
  margin-left: 50px;
}
.post .post-footer .comments-list .comment > .comments-list {
  margin-left: 50px;
}
</style>

<a href="<?php echo base_url(); ?>index.php?school_admin/discussion_category"
   class="btn btn-primary pull-right">
    <i class="entypo-plus-circled"></i>
    <?php echo get_phrase('add_category_/_sub_category'); ?>
</a>

<link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css">
<div class="container">
    <?php foreach($discussion_titles as $discussions){ ?>
    <div class="row">
        
        <div class="col-sm-8">
            <div class="panel panel-white post panel-shadow">
                <div class="post-description"> 
                    <div class="title h4">
                        <a href="#"><b><?php if($discussions['user_id'] == '1'){ echo "Admin";}?></b></a>
                        <?php echo get_phrase('added_a_new_discussion')." "."'".$discussions['discussion_title']."'";?>.
                    </div>
                    <p ><b><?php echo $discussions['disucssion_body'];?></b></p>
                    <input type="hidden" name="discussion_id" id="discussion_id" value ="<?php echo $discussions['discussion_id'];?> " >
                    <div class="stats">
                        <a href="#" class="btn btn-default stat-item">
                            <i class="fa fa-comment"><?php echo get_phrase('view_comments');?></i>
                        </a>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="comment" placeholder="Enter Your Comment Here and Hit Enter" name="comment" required>
                        </div>
                        <!--a href="#" class="btn btn-default stat-item">
                            <i class="fa fa-thumbs-down icon"></i>12
                        </a-->
                    </div>
                </div>                
            </div>
        </div>
      
    </div>
     <?php }?>
</div>


<script>
  $(document).keydown(function (e) {
        var comment_body = $('#comment').val();
        var discussion_id = $('#discussion_id').val();
        
        var keyCode = e.keyCode || e.which,
        key = {enter: 13}; 
        switch (keyCode) {
            case key.enter: { 
                alert('Enter was pressed'+comment_body);
                $.ajax({
                    type: 'post',
                    url:'<?php echo base_url();?>index.php?school_admin/add_comment/',
                    data:{comment_body:comment_body,discussion_id:discussion_id},                    
                    success: function (data){ 
                        alert('success');
                        alert(comment_body+discussion_id);
                        /*if(response=="OK"){
                            toastr.success('Sent Successfully');
                        }else {
                            return false; 
                        }*/
                    },
                    error: function(){
                        alert('error');
                    }
                    //console.log(data);
                });
                //Inside here you can do your post calls to PHP but I'm not very sure on what you want to accomplish once the key is pressed down.
            }
        }
});  
</script>    