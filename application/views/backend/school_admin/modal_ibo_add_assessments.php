<div class="row">
    <div class="col-md-12 no-padding">
    
        <div class="white-box">
           
            <section>
                <div class="sttabs tabs-style-flip"> 
                     
                 
                <!------CONTROL TABS START------>
                    <nav>
                        <ul>
                            <li><a href="#list"><i class="fa fa-bars m-r-5"></i> <?php echo get_phrase('assessment_list'); ?></a></li>
                            <li><a href="#add"><i class="fa fa-plus-circle m-r-5"></i><?php echo get_phrase('add_assessment'); ?></a></li>
                        </ul>
                    </nav>
                <!------CONTROL TABS END------>
                    <div class="content-wrap">
                    <!----TABLE LISTING STARTS-->
                        <section id="list">
                            <table id="example_cce">
                                <thead>
                                    <tr>
                                        <th><div><?php echo get_phrase('No'); ?></div></th>
                                        <th><div><?php echo get_phrase('class'); ?></div></th>
                                        <th><div><?php echo get_phrase('subject'); ?></div></th>
                                        <th><div><?php echo get_phrase('assessment'); ?></div></th>
                                        <th><div><?php echo get_phrase('options'); ?></div></th>
                                    </tr>
                                </thead>
                                <?php //pre($subjects);  die();?>
                                <tbody><?php $count = 1;  foreach ($assessment as $row):  ?>

                                    <tr>
                                        <td><?php echo $count++; ?></td>
                                        <td><?php echo $row['class_name']; ?></td>
                                        <td><?php echo $row['subject_name']; ?></td>
                                        <td><?php echo $row['assessment_name']; ?></td>
                                        <td>
                                            
                                        <!--edit-->
                                            <!-- <a onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_edit_class/<?php echo $row['program_id']; ?>');">
                                                <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Edit Class" title="Edit Class"><i class="fa fa-pencil-square-o"></i></button>
                                            </a> -->
                                            <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Edit IBO Program" title="Edit IBO Program"><i class="fa fa-pencil-square-o"></i></button>
                                        <!--delete-->
                                            <!-- <a onclick="confirm_modal('<?php echo base_url(); ?>index.php?school_admin/cce_classes/delete/<?php echo $row['program_id']; ?>');">
                                                <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete Class" title="Delete Class"><i class="fa fa-trash-o"></i></button>
                                            </a> -->
                                            <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete IBO Program" title="Delete IBO Program"><i class="fa fa-trash-o"></i></button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </section>
                    <!----TABLE LISTING ENDS--->
                    <!----CREATION FORM STARTS----> 

                        <section id="add">
                            <div>
                                <?php echo form_open(base_url() . 'index.php?school_admin/ibo_add_assessments', array('id'=>'add_assessment', 'class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top')); ?>  
                                <?php foreach ($subjects as $row_sub): ?>                                   
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        <?php echo get_phrase('assessment_name'); ?>
                                    </label>
                                    <input type="hidden" value="<?php echo $class->class_id; ?>" name="class_id">
                                    <input type="hidden" value="<?php echo $row_sub['subject_id']; ?>" name="subject_id">
                                    <div class="col-sm-6">
                                        <textarea class="form-control" rows="5" id="assessment" name="assessment" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>" placeholder="Please Enter Assessment" required="required"></textarea>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                                                              
                                <div class="text-right">
                                        <button type="submit" onclick="handleClick();" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('add'); ?></button>
                                </div>                                
                            </div>
                        </section>  
                        <?php //endforeach; ?>              
                    </div>
                <!----CREATION FORM ENDS-->
                </div>
            </section>
        </div>
    </div>
</div>

<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->

<script type="text/javascript">
    function handleClick() {

       $('form#add_assessment').submit();
    }
    
    (function() {
        [].slice.call(document.querySelectorAll('.sttabs')).forEach(function(el) {
            new CBPFWTabs(el);
        });

        <?php if($param2=='cce'){?>
                $('#cce').show();  
        <?php }else{?>
            $('#cce').hide();
            $('#cce_outer').removeClass('tab-current');<?php }?>
        
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