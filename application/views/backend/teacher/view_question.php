<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?></h4>
    </div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?teacher/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li><a href="<?php echo base_url(); ?>index.php?teacher/online_exam"><?php echo get_phrase('online_exam'); ?></a></li>
            <li class="active">
                <?php echo get_phrase($page_title); ?>
            </li>
        </ol>
    </div>
</div>

        <div class="row">
            <div class="col-xs-2 pull-right visible-xs add-stu-btn">
                <a href="<?php echo base_url(); ?>index.php?teacher/add_question" class="btn btn-primary pull-right">
                    <i class="entypo-plus-circled"></i>
                    <?php echo get_phrase('add_new_question'); ?>
                </a>
            </div>
            <div class="col-md-10">
                <div class="form-group col-sm-6" style="padding: 0;">
                    <label class="control-label">Select Subject</label>
                    <select data-style="form-control" data-live-search="true" class="selectpicker" onchange="window.location = this.options[this.selectedIndex].value">
                        <option value="">Select Subject</option>
                        <?php                        
                        foreach ($subject as $row):
                            ?>
                            <option <?php if ($subject_id == $row['subject_id']) {
                            echo 'selected';
                        } ?> value="<?php echo base_url(); ?>index.php?teacher/view_question/<?php echo $row['class_id']; ?>/<?php echo $exam_id; ?>/<?php echo $row['subject_id']; ?>">
                            <?php echo $row['name']; ?>
                            </option>
                            <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-2 hidden-xs">
                   <a href="<?php echo base_url(); ?>index.php?teacher/add_question/<?php echo $row['class_id']; ?>/<?php echo $exam_id ?>" class="btn btn-primary pull-right btn_float_center">
                    <i class="entypo-plus-circled"></i>
                    <?php echo get_phrase('add_new_question'); ?>
                </a>

            </div>
        </div>
        
        <div class="row">

        </div>

<div>
    <div class="col-md-12 white-box">
        <?php if($subject_id != ''): ?>
                <table  class="table datatable" id="example23">
                    <thead>
                        <tr>
                            <th><div><?php echo get_phrase('no'); ?></div></th>                        
                            <th><div><?php echo get_phrase('question'); ?></div></th>                            
                            <th><div><?php echo get_phrase("class"); ?></div></th>
                            <th><div><?php echo get_phrase("expalnation"); ?></div></th>
                            <th><div><?php echo get_phrase("order"); ?></div></th>
                            <th><div><?php echo get_phrase('options'); ?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                      $count = 1;
                        foreach ($question as $row):     ?>
                                <td><?php echo $count++; ?></td>
                                <td><?php echo $row['question']; ?></td>
                                <td><?php echo "Class ".$row['class_name']; ?></td>                             
                                <td><?php echo $row['explanation'];?> </td>
                                <td><?php echo $row['order'];?> </td>
                                <td>

                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                            Action <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-default pull-right pos-static" role="menu">
                <!-- QUESTION EDITING LINK -->
                                            <li>
                                                <a href="<?php echo base_url(); ?>index.php?teacher/edit_question/<?php echo $row['id']; ?>/<?php echo $row['class_id']; ?>/<?php echo $row['subject_id']; ?>/<?php echo $exam_id; ?>">
                                                    <i class="entypo-pencil"></i>
    <?php echo get_phrase('edit'); ?>
                                                </a>
                                            </li>
                                            <!-- QUESTION DELETE LINK -->   
                                             <li>
                                            <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>index.php?teacher/add_question/delete/<?php echo $row['id']; ?>/<?php echo $row['class_id']; ?>/<?php echo $exam_id; ?>');">
                                                <i class="entypo-trash"></i>
                                                <?php echo get_phrase('delete'); ?>
                                            </a>
                                            </li>
                                        </ul>
                                    </div>

                                </td>
                                
                            </tr>
<?php endforeach; ?>
                          
                    </tbody>
                </table>
        </div>

        <?php endif; ?>
    </div>


<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->                      
<script type="text/javascript">    
$(document).ready(function() {
        /*for loader
        $body = $("body");
        $(document).on({
            ajaxStart: function() { $body.addClass("loading");    },
             ajaxStop: function() { $body.removeClass("loading"); }    
        });
        */
    
       var section_ids         =   "#table_export ,"+$("#section_ids").val();
        var datatables = $(section_ids).dataTable({
		
                rowReorder: {
                        selector: 'td:nth-child(2)'
			},
		responsive: true,
                
        dom: 'Bfrtip',
        buttons: [
            'pageLength',
            
            {
                extend: 'excel',
                exportOptions: {
                      columns: [ 0, 1, 2,3]
                }
            },
            {
                extend: 'pdf',
                exportOptions: {
                    columns: [ 0, 1, 2,3]
                }
            },
             {
                extend: 'print',
                exportOptions: {
                    columns: [ 0, 1, 2,3]
                }
            },
           
        ]
    } );
} );
     
     
</script>

