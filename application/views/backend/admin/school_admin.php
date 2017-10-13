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



<div class="col-sm-12 white-box">

<div class="white-box" data-step="5" data-intro="Here you can view list of school administrators." data-position='top'>
    <?php if ($this->session->flashdata('flash_message_error')) { ?>        

        <div class="alert alert-danger">
        <?php echo $this->session->flashdata('flash_message_error') . get_phrase('so_could_not_update_/_edit_profile'); ?>
        </div>
    <?php } ?>
    
    <div class="table-responsive">  
        <table id="example23" class="display nowrap" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th><div><?php echo get_phrase('No'); ?></div></th>
                    <th><div><?php echo get_phrase('name'); ?></div></th>
                    <th><div><?php echo get_phrase('Email'); ?></div></th>
                    <th><div><?php echo get_phrase('Mobile'); ?></div></th>
                    <th><div><?php echo get_phrase('options'); ?></div></th>
                </tr>
            </thead>

            <tbody>
            <?php
            $count = 1;
            foreach ($adminArray as $row) {
            ?>
                <tr>
                <td><?php echo $count++; ?></td>
                <td><?php echo $row['first_name']." ".$row['last_name']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['mobile']; ?></td>
                <td><a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_school_admin_view/<?php echo $row['school_admin_id'];?>');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('View Profile'); ?>" title="<?php echo get_phrase('View Profile'); ?>"><i class="fa fa-eye"></i></button></a> 
                    
                <a href="<?php echo base_url(); ?>index.php?admin/add_school_admin/update/<?php echo $row['school_admin_id']; ?>"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('Update'); ?>" title="<?php echo get_phrase('Update'); ?>"><i class="fa fa-pencil"></i></button></a>
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


