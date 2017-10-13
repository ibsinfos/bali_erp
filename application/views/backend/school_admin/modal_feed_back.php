<?php if (!empty($feed_backs)) { ?>
    <div class="text-center">
        <h3><b><?php echo get_phrase('over_all_rating_for_') . " " . $teacher_name[0]['name'] . " is " . $over_all_rating . "%"; ?></b></h3>
    </div>
    <div class="row">
    <div class="col-md-12 white-box">
        <table id="example123" class="display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th width="45px"><div><?php echo get_phrase('no:'); ?></div></th> 
                            <th><div><?php echo get_phrase('feed_back'); ?></div></th> 
                            <th><div><?php echo get_phrase('rating'); ?></div></th>
                        </tr>
                    </thead>  
                    <tbody>
                        <?php
                        $count = 1;
                        foreach ($feed_backs as $feeds) {
                            ?>
                            <tr>
                                <td><?php echo $count++; ?></td>
                                <td class="to_feedback_content"><?php echo ucfirst(wordwrap($feeds['feedback_content'], 35, "\n", true)); ?></td> 
                                <td width="150px">
                                    <?php for($i=0;$i<$feeds['rating'];$i++) { ?>
                            <i class="fa fa-star" style="color:#FFD700; font-size: 18px;">&nbsp;</i>
                            <?php } ?>
                            <?php for($i=0;$i<5-$feeds['rating'];$i++) { ?>
                            <i class="fa fa-star" style="font-size: 18px; color: #ccc;">&nbsp;</i>
                            <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
   
    <?php
} else {
    echo get_phrase('no_feedback_available!!');
    ?>
<?php } ?>
<script>
    $('#modal_ajax').on('shown.bs.modal', function () {
        $(this).find('.modal-dialog').css({
            height: 'auto',
            'max-height': '100%'});
    });
   
   
</script>
<script>
$('#example123').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            "pageLength"
        ]
    });  


</script>