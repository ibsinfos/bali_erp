  <br>
<div class="row">
    <div class="col-md-12">   
        <div class="tab-content">
            <div class="tab-pane active" id="home">
                <table class="table table-bordered datatable" id="table_export">
                    <thead>
                        <tr>
                            <th width="80"><div><?php echo get_phrase('#'); ?></div></th>                            
                            <th><div><?php echo get_phrase("applicant's_name"); ?></div></th>
                            <th><div><?php echo get_phrase("class"); ?></div></th>
                            <th><div><?php echo get_phrase('gender'); ?></div></th>
                            <th><div><?php echo get_phrase('date_of_birth'); ?></div></th>
                            <th><div><?php echo get_phrase('email'); ?></div></th>
                            <th><div><?php echo get_phrase('action'); ?></div></th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $applied_students = $this->db->get('applied_students')->result_array();
                        $count = 1;
                        foreach ($applied_students as $row):
                            ?>
                            <tr>
                                <td><?php echo $count++; ?></td>
                                <!--td><img src="<?php //echo $this->crud_model->get_image_url('student', $row['student_id']); ?>" class="img-circle" width="50" /></td-->
                                <td>
                                    <?php
                                    $studid = $this->db->get_where('applied_students', array('student_id' => $row['student_id']));
                                    echo $studid->row()->name;
                                    ?>
                                </td>                              

                                <td>
                                    <?php echo $this->db->get_where('parent', array(
                                    'parent_id' => $parent_id))->row()->father_name; ?>
                                </td>


                                <td>
                                    <?php echo $this->db->get_where('parent', array(
                                        'parent_id' => $parent_id))->row()->mother_name; ?>
                                </td>                               
                                <td>
                                    <?php
                                    echo $this->db->get_where('student', array(
                                        'student_id' => $row['student_id']
                                    ))->row()->sex;
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo $this->db->get_where('applied_students', array(
                                        'student_id' => $row['student_id']
                                    ))->row()->email;
                                    ?>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-success btn-sm" value="<?php echo $row['student_id'];?>">Approve</button>
                                    <button type="button" class="btn btn-danger btn-sm" value="<?php echo $row['student_id'];?>">Reject</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div>
         
        <?php
        if (!empty($sections)):
            foreach ($sections as $row):
                ?>
                <div class="tab-pane" id="<?php echo $row['section_id']; ?>">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="10"><div><?php echo get_phrase('#'); ?></div></th>                            
                            <th><div><?php echo get_phrase("applicant's_name"); ?></div></th>
                            <th><div><?php echo get_phrase('class'); ?></div></th>
                            <th><div><?php echo get_phrase('email'); ?></div></th>
                            <th><div><?php echo get_phrase('date_of_birth'); ?></div></th>
                            <th><div><?php echo get_phrase('gender'); ?></div></th>                                    
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $applied_students = $this->db->get('applied_students')->result_array();
                        $count = 1;
                        foreach ($students as $row):
                            ?>
                        <tr>
                            <td><?php echo $count++; ?></td>
                            <td>
                                <?php
                                $student_name = $this->db->get_where('applied_students', array(
                                    'student_id' => $row['student_id']));
                                echo $applied_students->row()->name;
                                ?>
                            </td>
                            <?php
                            $parent_id = $this->db->get_where('applied_students', array('student_id' => $row['student_id']))->row()->class_id;
                            //foreach($parent_id as $row): 
                            ?>
                            <td>
                                <?php
                                echo $this->db->get_where('applied_students', array(
                                    'student_id' => $row['student_id']
                                ))->row()->email;
                                ?>
                            </td>
                            <td>
                                <?php
                                echo $this->db->get_where('student', array(
                                    'student_id' => $row['student_id']
                                ))->row()->birthday;
                                ?>
                            </td>                                       
                        </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>   
       
    </div>
</div>



<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->                      
<script type="text/javascript">

    jQuery(document).ready(function ($)
    {


        var datatable = $("#table_export").dataTable({
            "sPaginationType": "bootstrap",
            "sDom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'T>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>",
            "oTableTools": {
                "aButtons": [
                    {
                        "sExtends": "xls",
                        "mColumns": [0, 2, 3, 4]
                    },
                    {
                        "sExtends": "pdf",
                        "mColumns": [0, 2, 3, 4]
                    },
                    {
                        "sExtends": "print",
                        "fnSetText": "Press 'esc' to return",
                        "fnClick": function (nButton, oConfig) {
                            datatable.fnSetColumnVis(1, false);
                            datatable.fnSetColumnVis(5, false);

                            this.fnPrint(true, oConfig);

                            window.print();

                            $(window).keyup(function (e) {
                                if (e.which == 27) {
                                    datatable.fnSetColumnVis(1, true);
                                    datatable.fnSetColumnVis(5, true);
                                }
                            });
                        },
                    },
                ]
            },
        });

        $(".dataTables_wrapper select").select2({
            minimumResultsForSearch: -1
        });
    });

</script>

<script type="text/javascript">
    $('.btn-success').on('click', function() {
        stud_id = $('.btn-success').val(); 
        confirm('Are you sure you want to approve it?');  
        alert(stud_id);
        $.ajax({
            type: "POST",
            url: 'index.php?school_admin/approve_student',
            data:{"stud_id": stud_id},
         
            success : function(data){
                alert('success'); 
             },
            error : function(){
                alert('error');
            }
        });
    });
</script>    