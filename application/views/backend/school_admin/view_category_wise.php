<a href="<?php echo base_url(); ?>index.php?discussion_forum/create_thread/"
   class="btn btn-primary">
    <i class="entypo-plus-circled"></i>
    <?php echo get_phrase('new_thread'); ?>
</a> 
<br><br>




<table>
    <tbody>
    <tr>
      <th><?php echo get_phrase('recent_discussion');?></th>
      <th><?php echo get_phrase('comments_/_view');?></th>
      <th><?php echo get_phrase('last_comment');?></th>
      <!--<th><?php echo get_phrase('category');?></th>-->
    </tr>
    <?php foreach($threads_by_category as $t){?>
    <tr>
        <td><a href="<?php echo base_url(); ?>index.php?discussion_forum/view_discussion_details/<?php echo $t['thread_id']; ?>"> <?php echo $t['title'];?></a>
                <span class='center-block'><?php echo date('d, M Y', strtotime($t['date_created']));?><?php echo " by ".$t['discussion_username']; ?></span></td>
      
      <td><?php echo get_phrase('comments_/_view');?></td>
      <td>Maria Anders</td>
<!--      <td><a href="<?php echo base_url(); ?>index.php?discussion_forum/view_category_wise/<?php echo $t['category_id']; ?>">
      <?php echo $t['name'];?></a>
      </td>-->
    </tr>
    <?php } ?>
    </tbody>
</table>

<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
</style>