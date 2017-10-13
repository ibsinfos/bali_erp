<?php // pre($term_list); die;
foreach ($term_list as $row):
      ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary" data-collapsed="0">

                <div class="panel-body">

                    <?php echo form_open(base_url() . 'index.php?teacher/report_term/do_update/' . $row['term_id']  , array('class' => 'form-material form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data')); ?>

                    <div class="form-group"> 
                        <div class="col-md-12 m-b-20">
                            <label>Term Name</label>
                            <input type="text" class="form-control" id="name" name="name" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>" value="<?php echo $row['name']; ?>">
                        </div> 
                    </div>
                      <div class="form-group"> 
                        <div class="col-md-12 m-b-20">
                            <label>Running Year</label>
                            <input type="text" class="form-control" id="name" name="running_year" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>" value="<?php echo $row['running_year']; ?>" readonly="">
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


