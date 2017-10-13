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
                            <th><div><?php echo get_phrase('supplier_name'); ?></div></th>
                    <th><div><?php echo get_phrase('no_of_books'); ?></div></th>
                    <th><div><?php echo get_phrase('bill_number'); ?></div></th>
                    <th><div><?php echo get_phrase('total_price'); ?></div></th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                            $count = 1;
                            foreach ($books_stock as $row):
                                ?>
                                <tr>
                                    <td><?php echo $row['supplier_name']; ?></td>
                                    <td><?php echo $row['no_of_books']; ?></td>
                                    <td><?php echo $row['bill_number']; ?></td>
                                    <td><?php echo $row['total_price']." ".$row['currency']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!----TABLE LISTING ENDS--->

        </div>
    </div>
</div>