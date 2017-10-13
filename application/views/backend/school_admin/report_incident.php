<?php  $class_id = $this->uri->segment(3);?>
<!--<link rel="stylesheet" type="text/css" href="assets/new_assets/css/bootstrap1.min.css">-->
<link rel="stylesheet" type="text/css" href="assets/new_assets/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="assets/new_assets/css/datatable.css"/>
<script type="text/javascript" src="assets/new_assets/js/datatable.js"></script>

<div class="row">
   
            <div class="col-xs-12 col-sm-2 pull-right" style="margin-bottom:10px;">
                <a href="javascript:;" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/incident_modal/');" 
               class="btn btn-primary pull-right">
                <i class="entypo-plus-circled"></i>
                <?php echo get_phrase('add_new_incident'); ?>
                </a>
            </div>


    <div class="col-md-12">

        <div class="tabs-vertical-env">
         
            <div class="tab-content">

                <div class="tab-pane active">
                    <table class="table table-bordered responsive" id="manage_section">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th><?php echo get_phrase('student'); ?></th>                                
                                <th><?php echo get_phrase('date'); ?></th>
                                <th><?php echo get_phrase('description'); ?></th>
                                <th><?php echo get_phrase('follow-up date'); ?></th>
                                <th><?php echo get_phrase('status'); ?></th>
                                <th><?php echo get_phrase('submitted_status'); ?></th>
                                <th><?php echo get_phrase('options'); ?></th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Jack Andrew</td>
                                <td>10.03.2017</td>
                                <td>Disrupting a class</td>
                                <td></td>
                                <td>Not Served</td>
                                <td>Submitted</td>
                                <td>
                                    
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                            Action <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-default pull-right" role="menu">

                                            
                                           

                                            <!-- STUDENT EDITING LINK -->
                                            <li>
                                                <a href="#">
                                                    <i class="entypo-pencil"></i>
    Edit                                                </a>
                                            </li>
                                            <!-- STUDENT DELETE LINK -->   
                                             <li>
                                            <a href="#" onclick="confirm_student_delete('http://localhost/beta/index.php?school_admin/student/delete/101',101);">
                                                <i class="entypo-trash"></i>
                                                Delete                                            </a>
                                            </li>
                                            
                                        </ul>
                                    </div>
                                    
                                    
                                    
                                </td>
                                
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Peter Clark</td>
                                <td>15.03.2017</td>
                                <td>Disrespect of staff member</td>
                                <td></td>
                                <td>Not Served</td>
                                <td>Submitted</td>
                                <td>
                                    
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                            Action <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-default pull-right" role="menu">

                                            
                                           

                                            <!-- STUDENT EDITING LINK -->
                                            <li>
                                                <a href="#">
                                                    <i class="entypo-pencil"></i>
    Edit                                                </a>
                                            </li>
                                            <!-- STUDENT DELETE LINK -->   
                                             <li>
                                            <a href="#">
                                                <i class="entypo-trash"></i>
                                                Delete  </a>
                                            </li>
                                            
                                        </ul>
                                    </div>
                                    
                                    
                                    
                                </td>
                                
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>	
    </div>
</div>

<!--script tag for responsive table-->
<script type="text/javascript">
    jQuery(document).ready(function ($)
    {
        var datatable = $("#manage_section").dataTable({
			  rowReorder: {
            selector: 'td:nth-child(2)'
			},
			responsive: true,
          "sPaginationType": "bootstrap",
        dom: 'Bfrtip',
        buttons: [
            'pageLength',
            {
                extend: 'excel',
                exportOptions: {
                      columns: [  0, 1, 2,3,4, 5 ,6 ]
                }
            },
            {
                extend: 'pdf',
                exportOptions: {
                    columns: [  0, 1, 2,3,4, 5 ,6 ]
                }
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: [ 0, 1, 2,3,4, 5,6 ]
                }
            },
        ]
          
                 });
          
        });
</script>
