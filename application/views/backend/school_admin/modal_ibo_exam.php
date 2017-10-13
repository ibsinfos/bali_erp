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
                            
                            <?php echo form_open(base_url() . 'index.php?school_admin/ibo_exam_connect/connect', array('id'=>'connect_exam', 'class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top')); ?>
                            <table id="example_cce">
                                <thead>
                                    <tr>
                                        <th><div><?php echo get_phrase('No'); ?></div></th>
                                        <th><div><?php echo get_phrase('exam_name'); ?></div></th>
                                        <th><div><?php echo get_phrase('exam_category'); ?></div></th>
                                        <th><div><?php echo get_phrase('options'); ?></div></th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                <?php 
                                    $ibo_exam_id=array(); 
                                    if(count($connected_ibo_exam)){ 
                                        foreach ($connected_ibo_exam as $row) { 
                                            $ibo_exam_id[]=$row['ibo_exam_id']; 
                                        }
                                    } 
                                    if(count($ibo_exams)){
                                        $count = 1; 
                                        foreach ($ibo_exams as $row): 
                                            if(!in_array($row['ibo_exam_id'], $ibo_exam_id)){ 
                                ?>
                               
                                    <tr>
                                        <td><?php echo $count++; ?></td>
                                        <td><?php echo $row['name']; ?></td>
                                        <td><?php echo $row['exam_category']; ?></td>
                                        <td>                                     
                                            <input type="checkbox" name="selected_exam[]" value="<?php echo $row['ibo_exam_id'];?>">
                                        </td>
                                    </tr>
                                <?php } endforeach; }?>
                                </tbody> 
                            </table>
                            <div class="text-right col-xs-12 p-t-20">
                                <button type="submit" onclick="handleClick();" class="fcbtn btn btn-danger btn-outline btn-1d">
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
                                        <th><div><?php echo get_phrase('options'); ?></div></th>
                                    </tr>
                                </thead>
                                
                                <tbody>

                                <?php $count = 1; foreach ($connected_ibo_exam as $row):  ?>
                                    <tr>
                                        <td><?php echo $count++; ?></td>
                                        <td><?php echo $row['name']; ?></td>
                                        <td><?php echo $row['exam_category']; ?></td>
                                        <td>             
                                            <a onclick="confirm_modal('<?php echo base_url(); ?>index.php?school_admin/ibo_exam_connect/delete/<?php echo $row['ibo_exam_id']; ?>');">
                                            <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete Class" title="Delete Class"><i class="fa fa-trash-o"></i></button>
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
    function handleClick() {

       $('form#connect_exam').submit();
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

    $('#connect_exam').submit(function(){
    if(!$('#connect_exam input[type="checkbox"]').is(':checked')){
      alert("Please check at least one.");
      return false;
    }
});

</script>