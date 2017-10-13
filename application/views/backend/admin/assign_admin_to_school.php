<div class="row bg-title"> 
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?admin/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active"><?php echo get_phrase($page_title); ?></li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>

<div class="row">
    <?php echo form_open(base_url() . 'index.php?admin/assign_admin_to_school/assign', array('class' => 'form-groups-bordered validate', 'enctype' => 'multipart/form-data', 'id' => 'assignAdminToSchoolForm')); ?>
        <div class="col-md-12">
            <div class="white-box">
                <section>
                    <div class="sttabs tabs-style-flip" align="left">
                        <nav>
                            <ul>
                                <li class="active text-left" data-step="6" data-intro="Here you can fill School Information" data-position='top'><a href="#section-flip-5" class="sticon fa fa-info-circle"><span>Admin & Schools</span></a></li>
                                <input type="hidden" id="hidden"  value="0"/>
                            </ul>
                        </nav>
                        <div class="content-wrap">
                            <section>
                                <div class="row">
                                    <div class="col-sm-4 form-group">
                                        <label class="col-md-12" for="field-4">
                                            <?php echo get_phrase('Select Admin'); ?><span class="error mandatory"> *</span>
                                        </label>
                                        <select name="admin_id" data-style="form-control" class="selectpicker" required>
                                            <option value="">--Select Admin--</option>
                                            <?php foreach($adminData as $key=>$admin) { ?>
                                                <option value="<?=$admin['school_admin_id']?>"><?=$admin['first_name']." ".$admin['last_name']?></option>
                                            <?php } ?>
                                        </select>
                                        <span id="error_mobile" class="mandatory"></span>
                                    </div>
                                    <div class="col-sm-4 form-group">
                                        <label for="field-4">
                                            <?php echo get_phrase('Select School'); ?><span class="error mandatory"> *</span>
                                        </label>
                                        <select name="school_id" data-style="form-control" class="selectpicker" required>
                                            <option value="">--Select School--</option>
                                            <?php foreach($schoolData as $key=>$school) { ?>
                                                <option value="<?=$school['school_id']?>"><?=$school['name']?></option>
                                            <?php } ?>
                                        </select>
                                        <span id="error_mobile" class="mandatory"></span>
                                    </div>
                                    <div class="text-right col-xs-12 p-t-20" >
                                        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d">Save</button>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    <?php echo form_close(); ?>
</div>

<div class="col-sm-12 white-box">

<div class="white-box" data-step="5" data-intro="Here you can view list of administrators & their assigned schools." data-position='top'>
    
    
    <div class="table-responsive">  
        <table id="example23" class="display nowrap" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th><div><?php echo get_phrase('No'); ?></div></th>
                    <th><div><?php echo get_phrase('Admin Name'); ?></div></th>
                    <th><div><?php echo get_phrase('School Name'); ?></div></th>
                    <th><div><?php echo get_phrase('action'); ?></div></th>
                </tr>
            </thead>

            <tbody>
            <?php
            $count = 1;
            foreach ($admin_school_data as $row) {
            ?>
                <tr>
                    <td><?php echo $count++; ?></td>
                    <td><?php echo $row['first_name']." ".$row['last_name']; ?></td>
                    <td><?php echo $row['school_name']; ?></td>
                    <td>
                        <a href="javascript:void(0)" onclick="confirm_modal('<?php echo base_url(); ?>index.php?admin/delete_school_admin/<?php echo $row['uid']; ?>');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-trash-o"></i></button></a>
                    </td>
                </tr> 
            <?php } ?>
                </tbody>
        </table>
    </div>     
    </div>
</div>

<script>
    /*$(document).ready(function() {
        $('#example23').DataTable({
            "dom": 'Bfrtip',
            "responsive": true,
            "buttons": [
                "pageLength",
                'copy', 'excel', 'pdf', 'print'
            ],
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo base_url(); ?>index.php?admin/all_teachers/",
                "type": "POST",
                "dataSrc": "records"
            },
            "columns": [
                { "data": "sl_no" },
                { "data": "name" },
                { "data": "email" },
                { "data": "cell_phone" },
                { "data": "teacher_id" }

            ],

            "aaSorting": [[1, 'asc']],

            "columnDefs": [

                    { "targets": [0,4], "orderable": false },
                    
                    {
                        "targets": 4,
                        "render": function ( data, type, row ) {
                            return '<a href="#">View Profile</a>';
                        },
                      
                    },
                ]
        });
    });*/



    function validateemail(email) {
        $.post("<?php echo base_url(); ?>index.php?Validate/validateemail/", {email: email}, function (response) {
            if (response == 'invalid') {
                toastr.error('<?php echo get_phrase('email_already_taken') ?>');
                document.getElementById('parent_email').value = '';
            }
        });
    }


</script>


