<?php if(!empty($comment_details)){ ?>
<div class="modal-body" id="comment_box">
    <div class="form-horizontal">
        <div class="form-group">
            <div class="col-md-12 m-b-20">            
                <?php echo $comment_details[0]['comment_body'];?><br/>
            <label>Reply for this</label>
            <textarea class="form-control" rows="3" name="sub_comments" id="comment_body" required="required"></textarea>      
            <span class="errorMsg" style="display: none; color:#F50404;">Please write your reply.</span>
            </div>
            <input type="hidden" name="parent_comment_id" id="parent_comment_id_reply" value ="<?php echo $comment_details[0]['comment_id'];?>" >
            <input type="hidden" name="thread_id" id="thread_id" value ="<?php echo $comment_details[0]['thread_id'];?>" >
        </div>
        <div class="text-right">
            <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" onclick="myFunction()"><?php echo get_phrase('reply');?></button>
        </div>
    </div>
</div>
<?php } ?>
<script>
    function myFunction(){     
        var comment_body        =   $('#comment_body').val();
        if(comment_body!='') {
            var parent_comment_id   =   $('#parent_comment_id_reply').val();
            var thread_id           =   $('#thread_id').val();
            $.ajax({            
                url: '<?php echo base_url();?>index.php?ajax_controller/post_parent_comment/',
                type: 'POST',
                data: { thread_id:thread_id, comment_body:comment_body,parent_comment_id:parent_comment_id},
                success: function(data) {
                    $('#modal_ajax').hide();
                    window.location.reload();
                },
                error: function(){
                    alert('error');
                }
            });  
        } else {
        $('.errorMsg').show();
            return false;
        }
    }
    
      $('#modal_ajax').on('shown.bs.modal', function (e) {
    $('#modal_ajax #myModalLabel').html('<?php echo $page_title; ?>');
})
</script>