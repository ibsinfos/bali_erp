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
                                    <?php echo get_phrase('assments'); ?>
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
                                        <th><div><?php echo get_phrase('subjects'); ?></div></th>
                                        <th><div><?php echo get_phrase('options'); ?></div></th>
                                    </tr>
                                </thead>
                                <tbody><?php $count = 1; if(count($subjects)){ foreach ($subjects as $row): ?>
                                    <tr>
                                        <td><?php echo $count++; ?></td>
                                        <td><?php echo $row['name']; ?></td>
                                        <td>
                                            
											<!-- Add Assessment -->
											<a onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_ibo_add_assessments/<?php echo $row['class_id']; ?>/<?php echo $row['subject_id']; ?>');">
                                                <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Add Assessment" title="Add Assessment"><i class="fa fa-outdent"></i></button>
                                            </a>
                                            
                                        </td>
                                </tr><?php endforeach; } ?>
                                </tbody>
                            </table>
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