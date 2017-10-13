<hr />
<?php
    if (!empty($category_id))
    {
        ?>
        <a href="javascript:;" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/subcategory_add/<?php echo $category_id; ?>');" 
           class="btn btn-primary pull-right">
            <i class="entypo-plus-circled"></i>
            <?php echo get_phrase('add_new_subcategory'); ?>
        </a> 
        <br><br><br>

        <div class="row">
            <div class="col-md-12">

                <div class="tabs-vertical-env">

                    <ul class="nav tabs-vertical">
                        <?php
                        $category = $this->db->get_where('book_category', array("category_status" => "Active"))->result_array();
                        foreach ($category as $row):
                            ?>
                            <li class="<?php if ($row['category_id'] == $category_id) echo 'active'; ?>">
                                <a href="<?php echo base_url(); ?>index.php?librarian/subcategory/<?php echo $row['category_id']; ?>">
                                    <i class="entypo-dot"></i>
                                    <?php echo get_phrase('category'); ?> <?php echo $row['category_name']; ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>

                    <div class="tab-content">

                        <div class="tab-pane active">
                            <table class="table table-bordered responsive">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo get_phrase('subcategory_name'); ?></th>
                                        <th><?php echo get_phrase('subcategory_status'); ?></th>
                                        <th><?php echo get_phrase('options'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $count = 1;
                                    $subcategory = $this->db->get_where('book_subcategory', array(
                                                'category_id' => $category_id
                                            ))->result_array();
                                    foreach ($subcategory as $row):
                                        ?>
                                        <tr>
                                            <td><?php echo $count++; ?></td>
                                            <td><?php echo $row['subcategory_name']; ?></td>
                                            <td><?php echo $row['subcategory_status']; ?></td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                                        Action <span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">

                                                        <!-- EDITING LINK -->
                                                        <li>
                                                            <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/subcategory_edit/<?php echo $row['subcategory_id']; ?>');">
                                                                <i class="entypo-pencil"></i>
                                                                <?php echo get_phrase('edit'); ?>
                                                            </a>
                                                        </li>
                                                        <li class="divider"></li>

                                                        <!-- DELETION LINK -->
                                                        <li>
                                                            <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>index.php?librarian/subcategories/delete/<?php echo $row['subcategory_id']; ?>');">
                                                                <i class="entypo-trash"></i>
                                                                <?php echo get_phrase('delete'); ?>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>

                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>	

            </div>
        </div>
        <?php
    }
    else
    {
        ?>
        <div class="row">
            <div class="col-md-12"><h3>No Active Category Available</h3></div>
        </div>
        <?php
    }
?>
