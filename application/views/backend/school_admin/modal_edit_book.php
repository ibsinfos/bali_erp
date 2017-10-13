<?php 
$edit_data		=	$this->db->get_where('book' , array('book_id' => $param2) )->result_array();
?>

<div class="tab-pane box active" id="edit" style="padding: 5px">
    <div class="box-content">
        <?php foreach($edit_data as $row):?>
        <?php echo form_open(base_url() . 'index.php?school_admin/book/do_update/'.$row['book_id'] , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo get_phrase('name');?></label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="name" value="<?php echo $row['name'];?>"
                            data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo get_phrase('author');?></label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="author" value="<?php echo $row['author'];?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo get_phrase('description');?></label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="description" value="<?php echo $row['description'];?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo get_phrase('price');?></label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" name="price" value="<?php echo $row['price'];?>"/>
                    </div>
                    <label class="col-sm-2 control-label"><?php echo get_phrase('currency');?></label>
                    <div class="col-sm-3">
                        <select class="selectpicker1" data-style="form-control" data-live-search="true" name= "currency" style="width:100%;">
                            <option value="USD" <?php if ($row['currency'] == 'USD') echo 'selected'; ?>><?php echo get_phrase('USD');?></option>
                            <option value="AED" <?php if ($row['currency'] == 'AED') echo 'selected'; ?>><?php echo get_phrase('AED');?></option>
                            <option value="EUR" <?php if ($row['currency'] == 'EUR') echo 'selected'; ?>><?php echo get_phrase('EUR');?></option>
                            <option value="INR" <?php if ($row['currency'] == 'INR') echo 'selected'; ?>><?php echo get_phrase('INR');?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo get_phrase('class');?></label>
                    <div class="col-sm-5">
                        <select name="class_id" class="selectpicker1" data-style="form-control" data-live-search="true">
                            <?php 
                            $classes = $this->db->get('class')->result_array();
                            foreach($classes as $row2):
                            ?>
                                <option value="<?php echo $row2['class_id'];?>"
                                    <?php if($row['class_id']==$row2['class_id'])echo 'selected';?>><?php echo $row2['name'];?></option>
                            <?php
                            endforeach;
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo get_phrase('status');?></label>
                    <div class="col-sm-5">
                        <select name="status" class="selectpicker1" data-style="form-control" data-live-search="true">
                            <option value="available" <?php if($row['status']=='available')echo 'selected';?>><?php echo get_phrase('available');?></option>
                            <option value="unavailable" <?php if($row['status']=='unavailable')echo 'selected';?>><?php echo get_phrase('unavailable');?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-5">
                      <button type="submit" class="btn btn-info"><?php echo get_phrase('save_changes');?></button>
                  </div>
                </div>
        </form>
        <?php endforeach;?>
    </div>
</div>