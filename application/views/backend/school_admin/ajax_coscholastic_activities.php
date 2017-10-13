<div class="row">
    <div class="col-md-12">        
        <div class="white-box">
            <section>
                <div class="sttabs tabs-style-flip">
                <!------CONTROL TABS START------>
                    <nav>
                        <ul>
                            <li>
                                <a href="#list">
                                    <i class="fa fa-bars m-r-5"></i>
                                    <?php echo get_phrase('co_scholastic_activities'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="#add"> 
                                    <i class="fa fa-plus-circle m-r-5"></i>
                                    <?php echo get_phrase('add_co_scholastic_activities'); ?>
                                </a>
                            </li>
                        </ul>
                    </nav>
                <!------CONTROL TABS END------>

                    <div class="content-wrap">
                <!----TABLE LISTING STARTS-->
                        <section id="list">
                            <table class="table table-hover manage-u-table table_edjust" id="example_cce">
                                <thead>
                                    <tr>
                                        <th><div><?php echo get_phrase('NO'); ?></div></th>
                                        <th><div><?php echo get_phrase('co_scholastic_activities'); ?></div></th>
                                        <th><div><?php echo get_phrase('options'); ?></div></th>
                                    </tr>
                                </thead>
                                <tbody><?php $count = 1; if(count($cs_activities)){ foreach ($cs_activities as $row): ?>
                                    <tr>
                                        <td><?php echo $count++; ?></td>
                                        <td><?php echo $row['csa_name']; ?></td>
                                        <td>                                     
                                            <a onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_edit_co_Scholastic/update/<?php echo $row['csa_id']; ?>');">
                                                <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Edit Coscholastic" title="Edit Coscholastic"><i class="fa fa-pencil-square-o"></i></button>
                                            </a>

                                            
                                        <!--delete-->
                                            <a onclick="confirm_modal('<?php echo base_url(); ?>index.php?school_admin/cs_activities/delete/<?php echo $row['csa_id']; ?>');">
                                                <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete Coscholastic" title="Delete Coscholastic"><i class="fa fa-trash-o"></i></button>
                                            </a>
                                        </td>
                                </tr><?php endforeach; } ?>
                                </tbody>
                            </table>
                        </section>
                        <section id="add">
                            <div>
                                <?php echo form_open(base_url() . 'index.php?school_admin/cs_activities/add', array('id'=>'program_add', 'class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top')); ?> 
                               
                               <input type="hidden" class="form-control" name="class_id" value =<?php echo $cce_class_id; ?> required> 
                                
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        <?php echo get_phrase('co_scholastic_name'); ?>
                                    </label>

                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="csa_name" required>
                                    </div>
                                </div>
                                                                   
                                <div class="text-right">
                                    <button type="submit" onclick="handleClick();" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('add_co_scholastic'); ?></button>
                                </div>                                
                            </div>
                        </section> 
            <!----TABLE LISTING ENDS-->

        </div>
    </div>
</div>
<script type="text/javascript">

(function() {
        [].slice.call(document.querySelectorAll('.sttabs')).forEach(function(el) {
            new CBPFWTabs(el);
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