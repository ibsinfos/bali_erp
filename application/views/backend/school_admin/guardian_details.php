<?php //echo "cvdV".'<pre>';print_r($guardian_details);?>
<div class="row">
    <div class="col-md-12">
        <div class="form-group col-sm-6" style="padding: 0;">
        <label class="control-label" style="margin-bottom: 5px;">Select Class</label>
        <select class="selectpicker" data-style="form-control" data-live-search="true" onchange="window.location = this.options[this.selectedIndex].value">
            <option value="">Select Class</option>
            <?php  
            
                foreach ($classes as $row): ?>
                <option value="<?php echo base_url(); ?>index.php?school_admin/guardian_details/<?php echo $row['class_id']; ?>">
                <?php echo get_phrase('class'); ?>&nbsp;<?php echo $row['name']; ?>
                </option>
            <?php endforeach; ?>
        </select>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <?php if($class_id != ''): ?>       
        <ul class="nav nav-tabs bordered">
            <li class="active">
                <a href="#home" data-toggle="tab">
                    <span class="visible-xs"><i class="entypo-users"></i></span>
                    <span class="hidden-xs"><?php echo get_phrase('all_students'); ?></span>
                </a>
            </li>
            <?php
            if (!empty($sections)):
                foreach ($sections as $row):
                    ?>
                    <li>
                        <a href="#<?php echo $row['section_id']; ?>" data-toggle="tab">
                            <span class="visible-xs"><i class="entypo-user"></i></span>
                            <span class="hidden-xs"><?php echo get_phrase('section'); ?> <?php echo $row['name']; ?> </span>
                        </a>
                    </li>
                <?php endforeach; ?>
            <?php endif;?>
                    
        </ul>

        <div class="tab-content">
            <div class="tab-pane active" id="home">
                <table class="table table-bordered datatable" id="table_export">
                    <thead>
                        <tr>
                            <th><div><?php echo get_phrase('#'); ?></div></th> 
                            <th><div><?php echo get_phrase('student_name'); ?></div></th> 
                            <th><div><?php echo get_phrase('guardian_name'); ?></div></th>                            
                            <th><div><?php echo get_phrase('emergency_contact'); ?></div></th>
                            <th><div><?php echo get_phrase('email'); ?></div></th>
                            <th><div><?php echo get_phrase('address'); ?></div></th>                           
                            
                        </tr>
                    </thead>  
                    <tbody>
                        <?php                        
                            $count = 1;
                            if(!empty($guardian_details)){
                            foreach($guardian_details as $row1):                               
                            ?>
                            <tr>
                                <td><?php echo $count; ?></td>  
                                <?php //$stud_id = $row1->student_id; ?>
                                <td><?php echo $row1['student_id']; ?></td>                                                               
                                <td><?php echo $row1->guardian_fname." ".$row1->guardian_lname;?></td>
                                <td><?php echo $row1->guardian_emergency_number; ?></td>
                                <td><?php echo $row1->guardian_email; ?></td>
                                <td><?php echo $row1->guardian_address; ?></td>
                                
                            </tr>
                        <?php
                            $count++;
                            endforeach;
                            }
                        ?>
                    </tbody>
                </table>
            </div>       
        <?php
            if (!empty($sections)):
            foreach ($sections as $row):
            ?> 
            <div class="tab-pane" id="<?php echo $row['section_id']; ?>">
            <table class="table table-bordered datatable" id="table_export1">
            <thead>
                <tr>
                    <th><div><?php echo get_phrase('#'); ?></div></th> 
                    <th><div><?php echo get_phrase('student_name'); ?></div></th> 
                    <th><div><?php echo get_phrase('guardian_name'); ?></div></th>                            
                    <th><div><?php echo get_phrase('emergency_contact'); ?></div></th>
                    <th><div><?php echo get_phrase('email'); ?></div></th>
                    <th><div><?php echo get_phrase('address'); ?></div></th>                            
                                       
                </tr>
            </thead>
            <tbody>
            <?php                        
                $count = 1;//print_r($guardian_details);
                if(!empty($guardian_details)){
                foreach($guardian_details as $row1): 
                    
                ?>
                <tr>
                    <td><?php echo $count; ?></td>                      
                    <td><?php echo $row1->student_id; ?></td>                                                               
                    <td><?php echo $row1->guardian_fname." ".$row1->guardian_lname;?></td>
                    <td><?php echo $row1->guardian_emergency_number; ?></td>
                    <td><?php echo $row1->guardian_email; ?></td>
                    <td><?php echo $row1->guardian_address; ?></td>
                   
                </tr>
            <?php
                $count++;
                endforeach;
                }
            ?>
            </tbody>
            
            </table>
            </div>
        <?php endforeach; ?>
        <?php endif; ?>        
        
    <?php endif; ?>         
    </div>
    </div>     
</div>

<script type="text/javascript">
    jQuery(document).ready(function ($){
        var datatable = $("#table_export,#table_export1").dataTable({
			  rowReorder: {
            selector: 'td:nth-child(2)'
			},
			responsive: true,
            "sPaginationType": "bootstrap",
            "sDom": "<'row'<'col-xs-6 col-left'l><'col-xs-6 col-right'<'export-data'T>f>r>t<'row'<'col-xs-6 col-left'i><'col-xs-6 col-right'p>>",
            "oTableTools": {
                "aButtons": [
                    /*{
                        "sExtends": "xls",
                        "mColumns": [0, 2, 3, 4]
                    },
                    {
                        "sExtends": "pdf",
                        "mColumns": [0, 2, 3, 4]
                    },*/
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
