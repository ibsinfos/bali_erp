<?php if(!empty($blogs)){?>
     <table class="table display table_noinfo" id="table_noinfo" >
        <thead>
            <tr>
                <th>
                    <?php echo get_phrase('available_blogs_:');?>
                </th>
            </tr>
        </thead>
        <tbody class="view-all-blog-tbody">       
            <?php foreach($blogs as $blog): ?>
            <tr>
                <td>
                    <a href="<?php echo base_url();?>index.php?blogs/view_blogs_details/<?php echo $blog['blog_id']; ?>">
                        <h4><?php echo $blog['blog_title']; ?></h4>
                    </a>

                    <?php echo get_phrase('posted_by')." ".$blog['blog_user_name'];?> @
                        <?php echo date('d, M Y H:i:s', strtotime($blog['blog_created_time'])); ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table> 
<?php } else{

    echo get_phrase('no_blogs_related_to_this_topic!!'); } ?>
   
<script>
   $('.table_noinfo').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        "bInfo" : false,
        buttons: [
            "pageLength"
        ]
        
    }); 
</script>
