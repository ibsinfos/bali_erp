<div class="row">
    <div class="col-md-12 no-padding">
        <div class="white-box">
            <section>
                <div class="sttabs tabs-style-flip"> 
                    <nav>
                        <ul>
                            <li><a href="#list"><i class="fa fa-bars m-r-5"></i> <?php echo get_phrase('exams'); ?></a></li>
                            <li><a href="#list_connect"><i class="fa fa-plus-circle m-r-5"></i><?php echo get_phrase('connected_exams'); ?></a></li>
                        </ul>
                    </nav>
                    <div class="content-wrap">
                        <section id="list">
                            
                            <?php echo form_open(base_url() . 'index.php?school_admin/cce_exam_connect/connect', array('id'=>'connect_exam', 'class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top')); ?>
                            <table id="example_cce">
                                <thead>
                                    <tr>
                                        <th><div><?php echo get_phrase('No'); ?></div></th>
                                        <th><div><?php echo get_phrase('exam_name'); ?></div></th>
                                        <th><div><?php echo get_phrase('exam_category'); ?></div></th>
                                        <th><div><?php echo get_phrase('exam_term'); ?></div></th>
                                        <th><div><?php echo get_phrase('options'); ?></div></th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                <?php //pre($connected_cce_exam); die();?>
                                <?php 
                                    $cce_exam_id=array(); 
                                    if(count($connected_cce_exam)){ 
                                        foreach ($connected_cce_exam as $row) { 
                                            $cce_exam_id[]=$row['cce_exam_id']; 
                                        }
                                    } 
                                    if(count($cce_exams)){
                                        $count = 1; 
                                        foreach ($cce_exams as $row): 
                                            if(!in_array($row['cce_id'], $cce_exam_id)){ 
                                ?>
                               
                                    <tr>
                                        <td><?php echo $count++; ?></td>
                                        <td><?php echo $row['name']; ?></td>
                                        <td><?php echo $row['cce_cat_name']; ?></td>
                                        <td>
                                            <select class="selectpicker1" data-style="form-control" data-live-search="true" name="cce_exam_term[]" id="cce_exam_term" required>
                                                <option value="">Select Term</option>
                                                <option value="1">Term 1</option>
                                                <option value="2">Term 2</option>
                                            </select>
                                        </td>
                                        <td>                                     
                                            <input type="checkbox" name="selected_exam[]" value="<?php echo $row['cce_id'];?>" onclick="handleClick(this);">
                                        </td>
                                    </tr>
                                <?php } endforeach; }?>
                                </tbody> 
                            </table>
                            <div class="text-right col-xs-12 p-t-20">
                                <button type="submit" onclick="handleClick();" class="fcbtn btn btn-danger btn-outline btn-1d" id="connect_exam_submit" disabled="disabled">
                                    <?php echo get_phrase('connect_exam'); ?>
                                </button>
                            </div>
                             <?php echo form_close(); ?>
                            
                        </section>

                        <section id="list_connect">
                            <table id="example_list_connect">
                                <thead>
                                    <tr>
                                        <th><div><?php echo get_phrase('No'); ?></div></th>
                                        <th><div><?php echo get_phrase('exam_name'); ?></div></th>
                                        <th><div><?php echo get_phrase('exam_category'); ?></div></th>
                                        <th><div><?php echo get_phrase('term'); ?></div></th>
                                        <th><div><?php echo get_phrase('options'); ?></div></th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                <?php //pre($connected_cce_exam); die(); ?>
                                <?php $count = 1; foreach ($connected_cce_exam as $row):  ?>
                                    <tr>
                                        <td><?php echo $count++; ?></td>
                                        <td><?php echo $row['name']; ?></td>
                                        <td><?php echo $row['cce_cat_name']; ?></td>
                                        <td><?php if($row['term'] ==1){
                                                    echo 'Term 1';
                                                 }else if($row['term'] ==2){
                                                    echo 'Term 2';
                                                 }
                                            ?>
                                                
                                        </td>
                                        <td>             
                                            <a onclick="confirm_modal('<?php echo base_url(); ?>index.php?school_admin/cce_exam_connect/delete/<?php echo $row['cce_connect_id']; ?>');">
                                            <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete Connection" title="Delete Connection"><i class="fa fa-trash-o"></i></button>
                                            </a>                                            
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody> 
                            </table>
                        </section>                
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->

<script type="text/javascript">
    function handleClick(cb){
        //$('form#connect_exam').submit();
        if(cb.checked){
            $('#connect_exam_submit').prop("disabled", false);
            $("#cce_exam_term").validate({
                messages: {
                 cce_exam_term: {
                  required: "Select A Term to Connect with exam",
                 },
                }
            });
        }else{
            $('#connect_exam_submit').prop("disabled", true);
        }
    }
    /*(function() {
        [].slice.call(document.querySelectorAll('.sttabs')).forEach(function(el) {
            new CBPFWTabs(el);
        });

        <?php if($param2=='cce'){?>
                $('#cce').show();  
        <?php }else{?>
            $('#cce').hide();
            $('#cce_outer').removeClass('tab-current');<?php }?>
        
    })();*/

    (function() {
        [].slice.call(document.querySelectorAll('.sttabs')).forEach(function(el) {
            new CBPFWTabs(el);
            $('#cce').show();
            //$('#cce_outer').removeClass('tab-current');
        });
    })();

    $('#example_cce').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            "pageLength", 

        ]
    });

    $('#example_list_connect').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            "pageLength", 

        ]
    });


    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip(); 
    });

    
    

</script>