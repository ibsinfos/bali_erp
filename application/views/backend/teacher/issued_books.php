<hr />
<div class="row">
    <div class="col-md-12">

        <div class="tab-content">
            <br>            
            <!----TABLE LISTING STARTS-->
            <div class="tab-pane box active" id="list">

                <table class="table table-bordered datatable" id="table_export">
                    <thead>
                        <tr>
                            <th><div><?php echo get_phrase('book_name'); ?></div></th>
                    <th><div><?php echo get_phrase('issue_date'); ?></div></th>
                    <!--<th><div><?php echo get_phrase('issue_by'); ?></div></th>-->
                    <th><div><?php echo get_phrase('return_date'); ?></div></th>
                    <!--<th><div><?php echo get_phrase('return_to'); ?></div></th>-->
                    <th><div><?php echo get_phrase('current_status'); ?></div></th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach ($issue_log as $row):
                                ?>
                                <tr>
                                    <td><?php echo empty($row['book_title']) ? "" : $row['book_title']; ?></td>
                                    <td><?php echo empty($row['issue_date']) || $row['issue_date'] == "0000-00-00" ? "" : date("d-m-Y", strtotime($row['issue_date'])); ?></td>
                                    <!--<td><?php echo empty($issue_by_arr['name']) ? "" : $issue_by_arr['name']; ?></td>-->
                                    <td><?php echo empty($row['return_date']) || $row['return_date'] == "0000-00-00" ? "" : date("d-m-Y", strtotime($row['return_date'])); ?></td>
                                    <!--<td><?php echo empty($return_to_arr['name']) ? "" : $return_to_arr['name']; ?></td>-->
                                    <td><?php echo empty($row['status']) ? "" : $row['status']; ?></td>

                                </tr>
                                <?php
                            endforeach;
                        ?>
                    </tbody>
                </table>
            </div>
            <!----TABLE LISTING ENDS--->
        </div>
    </div>
</div>
