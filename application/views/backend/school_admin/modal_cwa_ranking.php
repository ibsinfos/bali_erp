<div class="row">
    <div class="col-md-12 white-box">
            <section>
                <div class="sttabs tabs-style-flip"> 
                    <nav>
                        <ul>
                            <li>
                                <a href="#list"><i class="fa fa-bars m-r-5"></i><?php echo get_phrase('ranking_list'); ?></a>
                            </li>
                            <li>
                                <a href="#add"><i class="fa fa-plus-circle m-r-5"></i><?php echo get_phrase('add_ranking'); ?></a>
                            </li>
                        </ul>
                    </nav>
                    <div class="content-wrap">
                        <section id="list">
                            <table class="table table-hover manage-u-table">
                                <thead>
                                    <tr>
                                        <th><div>No</div></th>
                                        <th><div><?php echo get_phrase('name'); ?></div></th>
                                        <th><div><?php echo get_phrase('percent'); ?></div></th>
                                        <th><div><?php echo get_phrase('percent_limit'); ?></div></th>
                                        <th><div><?php echo get_phrase('number_subjects'); ?></div></th>
                                        <th><div><?php echo get_phrase('options'); ?></div></th>
                                    </tr>
                                </thead>
                                <tbody><?php $count = 1; if(count($rankings)){ foreach ($rankings as $row): ?>
                                    <tr>
                                        <td><?php echo $count++; ?></td>
                                        <td><?php echo $row['name']; ?></td>
                                        <td><?php echo $row['percent']; ?></td>
                                        <td><?php echo $row['percent_limit']; ?></td>
                                        <td><?php echo 	$row['number_subjects'];?></td>
                                        <td>
                                        <!--delete-->
                                            <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>index.php?school_admin/delete_ranking/cwa/<?php echo $row['ranking_id']; ?>');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete Class"><i class="fa fa-trash-o"></i></button></a>
                                        </td>
                                    </tr><?php endforeach; } ?>
                                </tbody>
                            </table>
                        </section>
                        
                        <section id="add">
                            <div>
                                <?php echo form_open(base_url() . 'index.php?school_admin/cwa_settings/ranking_level' ); ?>
                                    <div class="row" >
                                        <div class="form-group col-md-12">
                                            <label for="name" class="control-label"><?php echo get_phrase("Name"); ?></label>
                                            <span class="error" style="color: red;"> *
                                            </span>
                                            <input type="text" class="form-control" name="name" value="" required>
                                        </div>
                                    </div>
                    
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="marks" class="control-label"><?php echo get_phrase("marks"); ?></label>
                                            <span class="error" style="color: red;"> *
                                            </span>
                                            <input type="text" class="form-control" name="marks" value="" onkeypress="return isNumber(event)" required>
                                        </div>
                                    </div>
                    
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="limit" class="control-label"><?php echo get_phrase("limits_type"); ?></label>
                                            <span class="error" style="color: red;"> *
                                            </span>
                                                <select name="limit" class="selectpicker1" data-style="form-control" data-live-search="true" data-validate="required" required="required">
                                                    <option value="less"><?php echo get_phrase("less_than"); ?></option>
                                                    <option value="equal"><?php echo get_phrase("equal_to"); ?></option>
                                                    <option value="greater"><?php echo get_phrase("greater_than"); ?></option>
                                                </select>
                                           
                                        </div>
                                    </div>
                    
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="subjects" class="control-label"><?php echo get_phrase("number_of_subjects"); ?></label>
                                            <span class="error" style="color: red;"> *
                                            </span>
                                           <input type="text" class="form-control" name="subjects" value="" onkeypress="return isNumber(event)" required></div>                           
                                        </div>
                                    </div>
                    
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="subject_limit" class="control-label"><?php echo get_phrase("subject_limit"); ?></label>
                                            <span class="error" style="color: red;"> *
                                            </span>
                                                <select name="subject_limit" class="selectpicker1" data-style="form-control" data-live-search="true" data-validate="required" required="required">
                                                    <option value="less"><?php echo get_phrase("less_than"); ?></option>
                                                    <option value="equal"><?php echo get_phrase("equal_to"); ?></option>
                                                    <option value="greater"><?php echo get_phrase("greater_than"); ?></option>
                                                </select>
                                           
                                        </div>
                                    </div>
                                
                                    <div class="text-right">
                                        <button type="submit" onclick="handleClick();" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('submit'); ?></button>
                                    </div>
                                    
                                <?php echo form_close(); ?>              
                            </div>                
                        </section>
                    </div>
                </div>
            </section>
   
    </div>
</div>

<script type="text/javascript">
function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

    (function() {
        [].slice.call(document.querySelectorAll('.sttabs')).forEach(function(el) {
            new CBPFWTabs(el);
            $('#cce').hide();
            $('#cce_outer').removeClass('tab-current');
        });
    })();
</script>