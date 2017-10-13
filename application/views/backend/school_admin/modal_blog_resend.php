<div class="modal-body">
    <?php echo form_open(base_url().'index.php?blogs/blog_preview/resend/'.$param2, array('class' =>'validate', 'method' => 'POST'));?>
    <from class="form-horizontal form-material">
        <div class="form-group">
            <label class="col-md-12">Comments from Admin</label>
            <div class="col-md-12 m-b-20">
                <textarea class="form-control" rows="2" placeholder="Enter your comments here" name="comments"></textarea>
            </div>                       
        </div>
        <div class="text-right">
            <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" name="save_details"><?php echo get_phrase('resend_blog');?></button>
        </div>
    </from>     
    <?php echo form_close();?>
</div> 






