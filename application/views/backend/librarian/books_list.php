<hr />
<div class="row">
    <div class="col-md-12">


        <!------CONTROL TABS END------>
        <div class="tab-content">
            <br>            
            <!----TABLE LISTING STARTS-->
            <div class="tab-pane box active" id="list">

                <table class="table table-bordered datatable" id="table_export">
                    <thead>
                        <tr>
                            <th><div><?php echo get_phrase('unique_id'); ?></div></th>
                            <th><div><?php echo get_phrase('book_issue_status'); ?></div></th>
                            <th><div><?php echo get_phrase('book_status'); ?></div></th>
                            <th><div><?php echo get_phrase('change_status'); ?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $count = 1;
                            foreach ($books_stock as $row):
                                ?>
                                <tr>
                                    <td><?php echo $row['book_unique_id']; ?></td>
                                    <td><?php echo $row['book_issue_status']; ?></td>
                                    <td><?php echo $row['book_status']; ?></td>
                                    <td>
                                        <?php
                                        if ($row['book_issue_status'] != "Yes" && $row['book_status'] != "Lost")
                                        {
                                            ?>
                                            <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_change_book_status/<?php echo $row['book_unique_id']; ?>');">
                                                <i class="entypo-pencil"></i>
                                                <?php echo get_phrase('change_status'); ?>
                                            </a>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!----TABLE LISTING ENDS--->

        </div>
    </div>
</div>