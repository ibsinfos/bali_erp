<?php
    $user_type = $param3; //echo $user_type; 
    $user_id = $param2; //echo $user_id;exit;
    $general_setting = (array) $this->db->get_where('general_library_setting', array(
                'setting_for' => $user_type,
            ))->row();
    
    $user_current_issued = $this->db->get_where('book_issue_table', array(
                'user_type' => $user_type,
                'user_id' => $user_id,
                'status' => "Issued"
            ))->num_rows();
    
    $remaining_issue = empty($general_setting['max_issue_limit']) ? "7" : $general_setting['max_issue_limit'] - $user_current_issued;
?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title" >
                    <i class="entypo-plus-circled"></i>
                    <?php echo get_phrase('issue_new_book'); ?>
                </div>
            </div>
            <?php
                if (!empty($remaining_issue))
                {
                    ?>
                    <div class="panel-body">
                        <?php echo form_open(base_url() . 'index.php?librarian/issuereturnbooks/', array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top')); ?>
                        <input type="hidden" name="user_id" value="<?php echo $user_id ?>" />
                        <input type="hidden" name="user_type" value="<?php echo $user_type ?>" />
                        <?php
                        for ($i = 1; $i <= $remaining_issue; $i++)
                        {
                            ?>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('book') . " " . $i; ?></label>
                                <div class="col-sm-5">
                                    <select name="book_id[]"  class="selectpicker1" data-style="form-control" data-live-search="true" data-validate="required" id="book_id" 
                                            data-message-required="<?php echo get_phrase('value_required'); ?>">                                        
                                        <?php
                                            $books_list = $this->db->get('books')->result_array();
                                            foreach ($books_list as $row):
                                                //$stock_count = $this->db->get_where('books_stock', array(
                                                        //'book_id' => $row['book_id']))->num_rows();                                        
                                                //if($stock_count < $no_ofbooks){
                                                ?>                             
                                                    <option value="<?php echo $row['book_id']; ?>"><?php echo $row['book_title']; ?>
                                                    </option>
                                                <?php //} ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div> 
                        </div>
                        
                            <!--div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('book') . " " . $i; ?></label>
                                <div class="col-sm-5">
                                    <input type="number" min="0" class="form-control" name="book_id[]"/>
                                    
                                </div>
                            </div-->
                            <?php
                        }//exit;
                        ?>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <input type="submit" name="issue_new_book" class="btn btn-info" value="<?php echo get_phrase('issue_books'); ?>" />
                            </div>
                        </div>
                        </form>
                    </div>

                    <?php
                }
            ?>

        </div>
    </div>
</div>



