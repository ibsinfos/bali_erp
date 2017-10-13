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

<div class="white-box" data-step="5" data-intro="Here you can view list of schools." data-position='top'>
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
                    <th><div><?php echo get_phrase('address line 1'); ?></div></th>
                    <th><div><?php echo get_phrase('address line 2'); ?></div></th>
                    <th><div><?php echo get_phrase('mobile'); ?></div></th>
                    <th><div><?php echo get_phrase('pin'); ?></div></th>
                    <th><div><?php echo get_phrase('options'); ?></div></th>
                </tr>
            </thead>

            <tbody>
            <?php
            $count = 1;
            foreach ($schools as $row) {
            ?>
                <tr>
                <td><?php echo $count++; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['addr_line1']; ?></td>
                <td><?php echo $row['addr_line2']; ?></td>
                <td><?php echo $row['mobile']; ?></td>
                <td><?php echo $row['pin']; ?></td>
                <td><a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_school_view/<?php echo $row['school_id'];?>');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('View Profile'); ?>" title="<?php echo get_phrase('View Profile'); ?>"><i class="fa fa-eye"></i></button></a> 
                    
                <a href="<?php echo base_url(); ?>index.php?admin/add_school/update/<?php echo $row['school_id']; ?>"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('Update'); ?>" title="<?php echo get_phrase('Update'); ?>"><i class="fa fa-pencil"></i></button></a>
                </td>
                </tr> 
            <?php } ?>
                </tbody>
        </table>
    </div>     
    </div>
</div>

<script type="text/javascript">

    function validateemail(email) {
        $.post("<?php echo base_url(); ?>index.php?Validate/validateemail/", {email: email}, function (response) {
            if (response == 'invalid') {
                toastr.error('<?php echo get_phrase('email_already_taken') ?>');
                document.getElementById('parent_email').value = '';
            }
        });
    }


</script>


