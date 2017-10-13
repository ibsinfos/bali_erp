<?php 

foreach ($data as $value) { 
    //$change_value  =str_ireplace('</p>','',);   
    $result = preg_replace('/<p\b[^>]*>(.*?)<\/p>/i', '', $value['hw_description']);
    ?>
    <div class="modal-body"> 
        <from class="form-horizontal form-material">  
            <div class="form-group">
                <div class="col-md-6 m-b-20"> 
                    <label for="field-1"><?php echo get_phrase('name'); ?></label>
                    <input type="text"  class="form-control" value="<?php echo $value['hw_name']; ?>" readonly="readonly">
                </div>

                <div class="col-md-6 m-b-20">
                    <label for="field-1"><?php echo get_phrase('description'); ?></label>
                    <input type="text"  class="form-control" value="<?php echo strip_tags($value['hw_name']); ?>" readonly="readonly">
                </div>

                <div class="col-md-6 m-b-20">
                    <label for="field-1"><?php echo get_phrase('start_date'); ?></label>
                    <input type="text"  class="form-control" value="<?php echo $value['start_date'] ?>" readonly="readonly">
                </div>

                <div class="col-md-6 m-b-20">
                    <label for="field-1"><?php echo get_phrase('end_date'); ?></label>
                    <input type="text"  class="form-control" value="<?php echo $value['end_date'] ?>" readonly="readonly">
                </div>
                
            </div>
            <hr>
            
        </from>
    </div>
<?php } ?>