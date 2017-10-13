
<div class="row">
    <div class="col-md-12">
        <div class="white-box">
            <section>
                <div class="sttabs tabs-style-flip">
                    <!------CONTROL TABS START------>
                    <nav>
                        <ul>
                            <li>
                                <a href="#list"><i class="fa fa-bars"></i> <?php echo get_phrase('ranking_list'); ?></a>
                            </li>
                            <li>
                                <a href="#add" data-toggle="tab"><i class="fa fa-plus-circle m-r-5"></i><?php echo get_phrase('add_ranking'); ?></a>
                            </li>
                        </ul>
                    </nav>
                    <!------CONTROL TABS END------>
                    <div class="content-wrap">
                        <!----TABLE LISTING STARTS-->
                        <section id="list" class="p-10">
                            <table class="table table_edjust" id="example_cce">
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
                                <tbody><?php
                                    $count = 1;
                                    if (count($rankings)) {
                                        foreach ($rankings as $row):
                                            ?>
                                            <tr>
                                                <td><?php echo $count++; ?></td>
                                                <td><?php echo $row['name']; ?></td>
                                                <td><?php echo $row['percent']; ?></td>
                                                <td><?php echo $row['percent_limit']; ?></td>
                                                <td><?php echo $row['number_subjects']; ?></td>
                                                <td>
                                                    <!--delete-->
                                                    <a onclick="confirm_student_delete('<?php echo base_url(); ?>index.php?school_admin/delete_ranking/gpa/<?php echo $row['ranking_id']; ?>');">
                                                        <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete Profile"><i class="fa fa-trash-o"></i></button>
                                                    </a>
                                                </td>
                                            </tr><?php endforeach;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </section>
                        <!----TABLE LISTING ENDS--->

                        <!----CREATION FORM STARTS---->
                        <section id="add">
                            <div>
<?php echo form_open(base_url() . 'index.php?school_admin/gpa_settings/ranking_level'); ?>                            
                                <div class="row" >
                                    <div class="form-group margin">
                                        <label for="name" class="control-label"><?php echo get_phrase("Name"); ?></label>
                                       <input type="text" class="form-control" name="name" value="" required>
                                    </div>  
                                </div>

                                <div class="row" >
                                    <div class="form-group margin">
                                        <label for="marks" class="control-label"><?php echo get_phrase("marks(%)"); ?></label>
                                        <input type="text" class="form-control" name="marks" value="" onkeypress="return isNumber(event)" required></div>
                                    </div>                                    
                                </div>                                    

                                <div class="row" >
                                    <div class="form-group margin">
                                        <label for="limit" class="control-label"><?php echo get_phrase("limits_type"); ?></label>
                                        
                                            <select name="limit" class="selectpicker1" data-style="form-control" data-live-search="true" data-validate="required" required="required">
                                                <option value="less"><?php echo get_phrase("less_than"); ?></option>
                                                <option value="equal"><?php echo get_phrase("equal_to"); ?></option>
                                                <option value="greater"><?php echo get_phrase("greater_than"); ?></option>
                                            </select>
                                       
                                    </div>                                
                                </div>                                

                                <div class="row" >
                                    <div class="form-group margin">
                                        <label for="subjects" class="control-label"><?php echo get_phrase("number_of_subjects"); ?></label>
                                       <input type="text" class="form-control" name="subjects" value="" onkeypress="return isNumber(event)" required>
                                    </div>                                
                                </div>                                

                                <div class="row" >
                                    <div class="form-group margin">
                                        <label for="subject_limit" class="control-label"><?php echo get_phrase("subject_limit"); ?></label>
                                     
                                            <select name="subject_limit" class="selectpicker1" data-style="form-control" data-live-search="true" data-validate="required" required="required">
                                                <option value="less"><?php echo get_phrase("less_than"); ?></option>
                                                <option value="equal"><?php echo get_phrase("equal_to"); ?></option>
                                                <option value="greater"><?php echo get_phrase("greater_than"); ?></option>
                                            </select>
                                     
                                    </div>
                                </div>
                            <div class="row">
                                <div class="col-md-12 text-right no-padding">
                                    <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('Submit'); ?></button>
                                </div>
                            </div>

<?php echo form_close(); ?>              
                            </div>                
                        </section>
                        <!----CREATION FORM ENDS-->
                    </div>
                </div>
            </section>
        </div>
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

    (function () {
        [].slice.call(document.querySelectorAll('.sttabs')).forEach(function (el) {
            new CBPFWTabs(el);
            $('#cce').hide();
            $('#cce_outer').removeClass('tab-current');
        });
    })();
    
    
    
     $('#example_cce').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            "pageLength"
        ]
    });
    $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
    });
</script>
