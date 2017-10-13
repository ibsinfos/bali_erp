<hr />
<div class="row">
    <div class="col-md-12">
        <div class="box-content">
            <?php echo form_open(base_url() . 'index.php?librarian/issuereturnbooks/', array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top')); ?>
            <div class="form-group">
                <label class="col-sm-1 control-label"><?php echo get_phrase('type'); ?></label>
                <div class="col-sm-2">
                    <select name="user_type" id="user_type"  class="selectpicker" data-style="form-control" data-live-search="true" data-validate="required">
                        <option value="Student"><?php echo get_phrase('student'); ?></option>
                        <option value="Teacher"><?php echo get_phrase('teacher'); ?></option>
                    </select>
                </div>
                <label class="col-sm-2 student_section control-label"><?php echo get_phrase('student_card_no'); ?></label>
                <div class="col-sm-2 student_section">
                    <input type="text" class="form-control" name="student_id" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>"/>
                </div>
                <label class="col-sm-2 control-label teacher_section hidden"><?php echo get_phrase('teacher'); ?></label>
                <div class="col-sm-2 teacher_section  hidden">
                    <select name="teacher_id" id="user_type"  class="selectpicker" data-style="form-control" data-live-search="true" data-validate="required">
                        <option value=""><?php echo get_phrase('select_teacher'); ?></option>
                        <?php
                            $teacher = $this->db->get('teacher')->result_array();
                            foreach ($teacher as $row1):
                                ?>
                                <option value="<?php echo $row1['teacher_id']; ?>">
                                    <?php echo $row1['name']; ?>
                                </option>
                                <?php
                            endforeach;
                        ?>
                    </select>
                </div>
                <div class="col-sm-offset-1 col-sm-3">
                    <input type="submit" name="get_user_log" class="btn btn-info" value="<?php echo get_phrase('get_detail'); ?>" />
                </div>
            </div>
            </form>                
        </div>       

        <div class="tab-content">
            <br>            
            <!----TABLE LISTING STARTS-->
            <div class="tab-pane box active" id="list">
                <?php
                    if (!empty($remaining_issue))
                    {
                        ?>
                        <a href="javascript:;" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_issue_new_book/<?php echo $user_id ?>/<?php echo $user_type ?>');" 
                           class="btn btn-primary pull-right">
                            <i class="entypo-plus-circled"></i>
                            <?php echo get_phrase('issue_books'); ?>
                        </a> 

                        <?php
                    }
                ?>

                <table class="table table-bordered datatable" id="table_export">
                    <thead>
                        <tr>
                            <th><div><?php echo get_phrase('user_name'); ?></div></th>
                    <th><div><?php echo get_phrase('user_type'); ?></div></th>
                    <th><div><?php echo get_phrase('book_name'); ?></div></th>
                    <th><div><?php echo get_phrase('issue_date'); ?></div></th>
                    <!--<th><div><?php echo get_phrase('issue_by'); ?></div></th>-->
                    <th><div><?php echo get_phrase('return_date'); ?></div></th>
                    <!--<th><div><?php echo get_phrase('return_to'); ?></div></th>-->
                    <th><div><?php echo get_phrase('reissue'); ?></div></th>
                    <th><div><?php echo get_phrase('return'); ?></div></th>
                    <th><div><?php echo get_phrase('return_with_fine'); ?></div></th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach ($issue_log as $row):
                                if ($row['user_type'] == "Student")
                                {
                                    $table_name = "student";
                                    $condition_arr = array("card_id" => $row['user_id']);
                                }
                                else
                                {
                                    $table_name = "teacher";
                                    $condition_arr = array("teacher_id" => $row['user_id']);
                                }
                                $user_arr = (array) $this->db->get_where($table_name, $condition_arr)->row();
                                $issue_by_arr = (array) $this->db->get_where("librarian", array("librarian_id" => $row['issue_by']))->row();
                                $return_to_arr = (array) $this->db->get_where("librarian", array("librarian_id" => $row['return_to']))->row();
                                $book_detail = $this->crud_model->get_book_detail_by_unique_id($row['book_unique_id']);
                                ?>
                                <tr>
                                    <td><?php echo empty($user_arr['name']) ? "" : $user_arr['name']; ?></td>
                                    <td><?php echo empty($row['user_type']) ? "" : $row['user_type']; ?></td>
                                    <td><?php echo empty($book_detail['book_title']) ? "" : $book_detail['book_title']; ?></td>
                                    <td><?php echo empty($row['issue_date']) || $row['issue_date'] == "0000-00-00" ? "" : date("d-m-Y", strtotime($row['issue_date'])); ?></td>
                                    <!--<td><?php echo empty($issue_by_arr['name']) ? "" : $issue_by_arr['name']; ?></td>-->
                                    <td><?php echo empty($row['return_date']) || $row['return_date'] == "0000-00-00" ? "" : date("d-m-Y", strtotime($row['return_date'])); ?></td>
                                    <!--<td><?php echo empty($return_to_arr['name']) ? "" : $return_to_arr['name']; ?></td>-->
                                    <td>
                                        <?php
                                        if ($row['status'] == "Issued")
                                        {
                                            ?>
                                            <a href="<?php echo base_url(); ?>index.php?librarian/issuereturnbooks/reissue/<?php echo $row['issue_id']; ?>">
                                                <i class="entypo-retweet"></i>
                                            </a>
                                            <?php
                                        }
                                        ?>
                                    </td> 
                                    <td>
                                        <?php
                                        if ($row['status'] == "Issued")
                                        {
                                            ?>
                                            <a href="<?php echo base_url(); ?>index.php?librarian/issuereturnbooks/return/<?php echo $row['issue_id']; ?>">
                                                <i class="entypo-reply"></i>
                                            </a>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($row['status'] == "Issued")
                                        {
                                            ?>

                                            <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_return_with_fine/<?php echo $row['issue_id']; ?>');">
                                                <i class="entypo-reply-all"></i>
                                            </a>
                                            <?php
                                        }
                                        ?>
                                    </td> 
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


<!-----  DATA TABLE EXPORT CONFIGURATIONS ----->                      
<script type="text/javascript">

    jQuery(document).ready(function ($)
    {
        $(document).on("change", "#user_type", function () {
            var user_type = $(this).val();
            if (user_type == "Student")
            {
                $('.teacher_section').addClass("hidden");
                $('.student_section').removeClass("hidden");
            }
            else
            {
                $('.student_section').addClass("hidden");
                $('.teacher_section').removeClass("hidden");
            }
        });
    });

</script>