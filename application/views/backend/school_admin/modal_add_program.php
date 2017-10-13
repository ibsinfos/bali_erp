<div class="row">
    <div class="col-md-12 no-padding">
        <div class="white-box">
            <section>
                <div class="sttabs tabs-style-flip">
                    <nav>
                        <ul>
                            <li><a href="#list"><i class="fa fa-bars m-r-5"></i> <?php echo get_phrase('program_list'); ?></a></li>
                            <li><a href="#add"><i class="fa fa-plus-circle m-r-5"></i><?php echo get_phrase('add_program'); ?></a></li>
                        </ul>
                    </nav>
                    <div class="content-wrap">
                        <section id="list">
                            <table id="example_cce">
                                <thead>
                                    <tr>
                                        <th><div><?php echo get_phrase('No'); ?></div></th>
                                        <th><div><?php echo get_phrase('program_name'); ?></div></th>
                                        <th><div><?php echo get_phrase('options'); ?></div></th>
                                    </tr>
                                </thead>
                                <tbody><?php $count = 1; foreach ($programs as $row):  ?>
                                    <tr>
                                        <td><?php echo $count++; ?></td>
                                        <td><?php echo $row['program_name']; ?></td>
                                        <td>
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
                                <?php echo form_open(base_url() . 'index.php?school_admin/ibo_program/add', array('id'=>'program_add', 'class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top')); ?>
                            <div class="form-horizontal form-material">                                   
                                <div class="form-group">
                                    <div class="col-md-12 m-b-20">
                                        <label>
                                            <?php echo get_phrase('program_name'); ?>
                                        </label>
                                        <span class="error" style="color: red;"> *</span>
                                        <input type="text" class="form-control" name="program_name" required placeholder="Please Enter Program Name">
                                    </div>
                                </div>

                                <div class="form-group">                                  
                                    <div class="text-right">
                                        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('add_program'); ?></button>
                                    </div>
                                </div>
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

       $('form#program_add').submit();
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