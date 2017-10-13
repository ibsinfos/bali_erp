<!-- Include Editor style. -->
<link href='https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.4.2/css/froala_editor.min.css' rel='stylesheet' type='text/css' />
<link href='https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.4.2/css/froala_style.min.css' rel='stylesheet' type='text/css' />

<!-- Include JS file. -->

<script type='text/javascript' src='assets/js/froala_editor.min.js'></script>

<script>
  $(function() {
    $('#froala-editor').froalaEditor({
      heightMin: 100,
      heightMax: 200
    });
  });
</script>   
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title" >
                        <i class="entypo-plus-circled"></i>
    <?php echo get_phrase('Add_question_in_online_exam'); ?>
                    </div>
                </div>
                <div class="tab-content">
            <br>            
            <!----TABLE LISTING STARTS-->
            <div class="tab-pane box active" id="list">

                <table class="table table-bordered datatable" id="table_export">
                    <thead>
                        <tr>
                            <th><div><?php echo get_phrase('class'); ?></div></th>
                            <th><div><?php echo get_phrase('section'); ?></div></th>
                            <th><div><?php echo get_phrase('subject_name'); ?></div></th>
                            <th><div><?php echo get_phrase('options'); ?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if(empty($show_data)){ ?>
                            <tr><td colspan="4"><?php echo get_phrase('no_data_available_in_table'); ?></td></tr>
                        <?php } else{
                        $count = 1;
                        foreach ($show_data as $row): ?>
                            <tr>
                                <td><?php echo $row['class_name']; ?></td>
                                <td><?php echo $row['section_name']; ?></td>
                                <td><?php echo $row['subject_name']; ?></td>
                                <td>
                                    <div class="btn-group">
                                         <a href="<?php echo base_url(); ?>index.php?school_admin/add_question_online/<?php echo $row['class_id']; ?>/<?php echo $row['subject_id']; ?>/<?php echo $row['section_id']; ?>"> 
                                          
                                        <button type="button" class="btn btn-default" >
                                             <?php echo get_phrase('add_question'); ?>
                                        </button>
                                         </a>
                                    </div>
                                </td>
                            </tr>
                       <?php endforeach; }?>
                    </tbody>
                </table>
            </div>
            <!----TABLE LISTING ENDS--->



        </div>
            </div>
        </div>
    </div>
 



