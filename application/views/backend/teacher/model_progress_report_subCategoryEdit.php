<?php
$edit_data = $this->db->get_where(' progress_report_sub_category', array('sub_category_id' => $param2))->result_array();
foreach ($edit_data as $row):
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary" data-collapsed="0">

                <div class="panel-body">

                    <?php echo form_open(base_url() . 'index.php?teacher/progress_report_sub_category/do_update/' . $row['sub_category_id'] . '/' . $row['category_id'], array('class' => 'form-material form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data')); ?>

                    <div class="form-group"> 
                        <div class="col-md-12 m-b-20">
                            <label>Sub Category</label>
                            <input type='hidden' value="<?php echo $param3; ?>" name='heading_id'>
                            <textarea class="form-control" rows="3" id="category" name="sub_category" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>"><?php echo $row['description']; ?></textarea>
                        </div> 
                    </div>
                    <div class="col-xs-12 text-right p-0">

                        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('update'); ?></button>

                    </div>

                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>

    <?php
endforeach;
?>


