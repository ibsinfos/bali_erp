
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title" >
                    <i class="entypo-plus-circled"></i>
                    <?php echo get_phrase('return_with_fine'); ?>
                </div>
            </div>
            <div class="panel-body">
                <?php echo form_open(base_url() . 'index.php?librarian/issuereturnbooks/return_with_fine/' . $param2, array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top')); ?>
               
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo get_phrase('fine_amount'); ?></label>
                    <div class="col-sm-5">
                        <input type="number" min="1" step="0.5" class="form-control" value="" name="fine_amount" data-validate="required" data-message-required=""/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo get_phrase('book_status'); ?></label>
                    <div class="col-sm-5">
                        <select name="book_status" id="edit_category_id"  class="selectpicker1" data-style="form-control" data-live-search="true" data-validate="required">
                            <option value=""><?php echo get_phrase('select_status'); ?></option>
                            <option value="Damage"><?php echo get_phrase('damage'); ?></option>
                            <option value="Lost"><?php echo get_phrase('lost'); ?></option>
                        </select>
                    </div>
                </div> 
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-5">
                        <button type="submit" class="btn btn-info"><?php echo get_phrase('submit'); ?></button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>



