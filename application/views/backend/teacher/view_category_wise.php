<div class="col-md-12 text-right no-padding">
<a href="<?php echo base_url(); ?>index.php?discussion_forum/create_thread/"
   class="btn btn-primary">
    <i class="entypo-plus-circled"></i>
    <?php echo get_phrase('new_thread'); ?>
</a> 
</div>
<div class="col-md-12 no-padding">
    <table class="table table-bordered datatable" id="table_export">
        <thead>
            <tr>
          <th><?php echo get_phrase('recent_discussion');?></th>
          <th><?php echo get_phrase('comments_/_view');?></th>
          <th><?php echo get_phrase('last_comment');?></th>
       
        </tr>
        </thead>
        <tbody>
        
        <?php foreach($threads_by_category as $t){?>
        <tr>
            <td><a href="<?php echo base_url(); ?>index.php?discussion_forum/view_discussion_details/<?php echo $t['thread_id']; ?>"> <?php echo $t['title'];?></a>
                    <span class='center-block'><?php echo date('d, M Y', strtotime($t['date_created']));?><?php echo " by ".$t['discussion_username']; ?></span></td>

          <td><?php echo get_phrase('comments_/_view');?></td>
          <td>Maria Anders</td>
  
        </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
