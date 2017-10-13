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
                            <th><div><?php echo get_phrase('book_title'); ?></div></th>
                    <th><div><?php echo get_phrase('author_name'); ?></div></th>
                    <th><div><?php echo get_phrase('isbn_number'); ?></div></th>
                    <th><div><?php echo get_phrase('note'); ?></div></th>
                    <th><div><?php echo get_phrase('total_books'); ?></div></th>
                    <th><div><?php echo get_phrase('available_books'); ?></div></th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                            $count = 1;
                            foreach ($books as $row):
                                ?>
                                <tr>
                                    <td><?php echo $row['book_title']; ?></td>
                                    <td><?php echo $row['book_author']; ?></td>
                                    <td><?php echo $row['isbn_number']; ?></td>
                                    <td><?php echo $row['book_note']; ?></td>
                                    <td><?php echo $row['total_books']; ?></td>
                                    <td><?php echo $row['available_books']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!----TABLE LISTING ENDS--->
        </div>
    </div>
</div>

