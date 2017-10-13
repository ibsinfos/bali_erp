<div class="row">
    <div class="col-md-12 no-padding">
        <div class="white-box">
            <section>
                <div class="sttabs tabs-style-flip"> 
                    <nav>
                        <ul>
                            <li><a href="#list"><i class="fa fa-bars m-r-5"></i> <?php echo get_phrase('class_list'); ?></a></li>
                            <li><a href="#add"><i class="fa fa-plus-circle m-r-5"></i><?php echo get_phrase('assign_program'); ?></a></li>
                        </ul>
                    </nav>
                    <div class="content-wrap">
                        <section id="list">
                            <table id="example_cce">
                                <thead>
                                    <tr>
                                        <th><div><?php echo get_phrase('No'); ?></div></th>
                                        <th><div><?php echo get_phrase('class_name'); ?></div></th>
                                        <th><div><?php echo get_phrase('program_name'); ?></div></th>
                                        <th><div><?php echo get_phrase('options'); ?></div></th>
                                    </tr>
                                </thead>
                                <tbody><?php $count = 1; foreach ($class_program as $row):  ?>
                                    <tr>
                                        <td><?php echo $count++; ?></td>
                                        <td><?php echo $row['name']; ?></td>
                                        <td><?php echo $row['program_name']; ?></td>
                                        <td>                                     
                                            <!-- <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Edit IBO Program" title="Edit IBO Program"><i class="fa fa-pencil-square-o"></i></button>
                                            <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete IBO Program" title="Delete IBO Program"><i class="fa fa-trash-o"></i></button> -->
                                            <a onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_edit_program/<?php echo $row['program_id']; ?>');">
                                                <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Edit IBO Program" title="Edit IBO Program"><i class="fa fa-pencil-square-o"></i></button>
                                            </a>

                                            
                                        <!--delete-->
                                            <a onclick="confirm_modal('<?php echo base_url(); ?>index.php?school_admin/ibo_program/delete/<?php echo $row['program_id']; ?>');">
                                                <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete IBO Program" title="Delete IBO Program"><i class="fa fa-trash-o"></i></button>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </section>

                        <section id="add">
                            <div>
                                <?php echo form_open(base_url() . 'index.php?school_admin/ibo_program_assign_class', array('id'=>'program_class', 'class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top')); ?>                                    
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        <?php echo get_phrase('class_name'); ?>
                                    </label>

                                    <div class="col-sm-6">
                                        <select class="selectpicker" data-style="form-control" data-live-search="true" name="ibo_class">
                                            <option value="">Select Class</option>
                                        <?php  if(count($classes)){ foreach ($classes as $row): ?>
                                            <option  value="<?php echo $row['class_id'];?>">
                                                <?php echo get_phrase('class'); ?>&nbsp;<?php echo $row['name']; ?>
                                            </option>
                                        <?php endforeach; }?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        <?php echo get_phrase('program_name'); ?>
                                    </label>

                                    <div class="col-sm-6">
                                        <select class="selectpicker1" data-style="form-control" data-live-search="true" name="ibo_program">
                                            <option value="">Select Program</option>
                                        <?php  if(count($programs)){ foreach ($programs as $row_program): ?>
                                            <option  value="<?php echo $row_program['program_id'];?>">
                                                <?php echo $row_program['program_name']; ?>
                                            </option>
                                        <?php endforeach; }?>
                                        </select>
                                    </div>
                                </div>
                                                                   
                                    <div class="text-right">
                                        <button type="submit" onclick="handleClick();" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('assign'); ?></button>
                                    </div>                                
                            </div>
                        </section>                
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->

<script type="text/javascript">
    function handleClick() {

       $('form#program_class').submit();
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