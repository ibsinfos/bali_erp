<div class="row">
    <div class="col-md-12 no-padding">
        <div class="white-box">
            <section>
                <div class="sttabs tabs-style-flip">   
                    <nav>
                        <ul>
                            <li><a href="#list"><i class="fa fa-bars m-r-5"></i> <?php echo get_phrase('group_list'); ?></a></li>
                            <li><a href="#add"><i class="fa fa-plus-circle m-r-5"></i><?php echo get_phrase('add_group'); ?></a></li>
                        </ul>
                    </nav>
                    <div class="content-wrap">
                        <section id="list">
                            <table id="example_cce" >
                                <thead>
                                    <tr>
                                        <th><div><?php echo get_phrase('No'); ?></div></th>
                                        <th><div><?php echo get_phrase('group_name'); ?></div></th>

                                        <th><div><?php echo get_phrase('options'); ?></div></th>
                                    </tr>
                                </thead>
                                <tbody><?php $count = 1; //pre($group_records);exit;
                                if(count($group_records)>0){
                                    foreach ($group_records as $row): ?>
                                         <tr>
                                        <td><?php echo $count++; ?></td>
                                        <td><?php echo $row['name']; ?></td>
                                        <td>             
                                            <a onclick="confirm_modal('<?php echo base_url(); ?>index.php?school_admin/groups/delete/<?php echo $row['id']; ?>');">
                                            <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete Class" title="Delete Class"><i class="fa fa-trash-o"></i></button>
                                            </a>                                            
                                        </td>
                                    </tr>
                                    <?php endforeach;
                                }?>
                                </tbody>
                            </table>
                        </section>
                        <section id="add">
                            <div>
                                <?php echo form_open(base_url() . 'index.php?school_admin/groups/add', array('id'=>'group_add', 'class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top')); ?>                                    <div class="form-group">
                                        
                                        <div class="col-sm-10">
                                            <div class="col-md-4 ">
                                                <label> <?php echo get_phrase("group_name");?> </label><span id="error_name" class="mandatory">*</span>
                                                <input type="text" name="group_name" value="" required="required"><span id="error_name" class="mandatory">*</span>
<!--                                                <label> <?php echo get_phrase("numeric_name");?> </label><span id="error_name" class="mandatory">*</span>
                                                <input type="text" name="group_numeric_name" value="" required="required">-->
                                               
                                            </div>
                                       </div>
                                    </div>
                                                                   
                                    <div class="text-right">
                                        <button type="submit" onclick="handleClick();" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('add_group'); ?></button>
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
    function handleClick() {

      // $('form#group_add').submit();
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