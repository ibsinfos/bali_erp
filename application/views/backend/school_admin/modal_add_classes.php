<div class="row">
    <div class="col-md-12 no-padding">
        <div class="white-box">
            <section>
                <div class="sttabs tabs-style-flip">   
                    <nav>
                        <ul>
                            <li><a href="#list"><i class="fa fa-bars m-r-5"></i> <?php echo get_phrase('class_list'); ?></a></li>
                            <li><a href="#add"><i class="fa fa-plus-circle m-r-5"></i><?php echo get_phrase('add_class'); ?></a></li>
                        </ul>
                    </nav>
                    <div class="content-wrap">
                        <section id="list">
                            <table id="example_cce">
                                <thead>
                                    <tr>
                                        <th><div><?php echo get_phrase('No'); ?></div></th>
                                        <th><div><?php echo get_phrase('class_name'); ?></div></th>
                                        <th><div><?php echo get_phrase('numeric_name'); ?></div></th>
                                        <th><div><?php echo get_phrase('options'); ?></div></th>
                                    </tr>
                                </thead>
                                <tbody><?php $count = 1; foreach ($classes_record as $row): ?>
                                    <tr>
                                        <td><?php echo $count++; ?></td>
                                        <td><?php echo $row['name']; ?></td>
                                        <td><?php echo $row['name_numeric']; ?></td>
                                        <td>             
                                            <a onclick="confirm_modal('<?php echo base_url(); ?>index.php?school_admin/cce_classes/delete/<?php echo $row['class_id']; ?>');">
                                            <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete Class" title="Delete Class"><i class="fa fa-trash-o"></i></button>
                                            </a>                                            
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </section>
                        <section id="add">
                            <div id="add_class_section">
                                <?php echo form_open(base_url() . 'index.php?school_admin/classes_evaluation/'.$param2, array('id'=>'class_add', 'class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top')); ?>   <div class="form-group">
                                    <strong>
                                        <?php 
                                        echo strtoupper($param2). ' '.'Classes'; 
                                        ?>
                                    </strong>
                                        <div class="col-sm-12">
                                        <?php 
                                            $cce_class_id=array(); 
                                            if(count($evaluation_classes)){ 
                                                foreach ($evaluation_classes as $row) { 
                                                    $cce_class_id[]=$row['class_id']; 
                                                }
                                            } 
                                            if(count($all_classes)){ 
                                                foreach ($all_classes as $row): 
                                                    if(!in_array($row['class_id'], $cce_class_id)){ 
                                        ?>
                                            <div class="col-md-4 checkbox checkbox-danger">
                                                <input type="checkbox" name="selected_class[]" value="<?php echo $row['class_id'];?>" onclick="handleClick(this)"  id="class_check<?php echo $row['class_id'];?>">
                                                <label> <?php echo $row['name'];?> </label>
                                            </div>
                                            <?php } endforeach; }?>
                                        </div>
                                    </div>
                                                                   
                                    <div class="text-right">
                                        <button type="submit" onclick="handleClick();" disabled="disabled" class="fcbtn btn btn-danger btn-outline btn-1d" id="add_class_button"><?php echo get_phrase('add_classes'); ?></button>
                                    </div>                                
                            </div>
                        </section>                
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<script type="text/javascript">
    function handleClick(cb){
        //$('form#class_add').submit();
        if(cb.checked){
            $('#add_class_button').prop("disabled", false);
        }else{
            $('#add_class_button').prop("disabled", true);
        }
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