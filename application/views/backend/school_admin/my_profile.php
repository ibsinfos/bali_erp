<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('View_Profile'); ?></h4>
    </div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>index.php?school_admin/dashboard">
                    <?php echo get_phrase('Dashboard'); ?>
                </a>
            </li>
            <li class="active">
                <?php echo get_phrase('View_Profile'); ?>
            </li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>

<div class="row">
    <div class="col-md-12">
        <div class="white-box">
            <?php foreach($edit_data as $row): ?>
                <div class="panel-body">
                    <table class="table table-bordered table_row_hover">
                        <div class="col-md-12 m-b-20 no-padding">
                            <div class="col-xs-4 col-sm-2 col-md-1 p-0">
                                <span class="profile-picture">
                                            <img src="<?php echo ($row['image']!=" "?"uploads/admin_image/".$row['image']:"uploads/user.jpg");?>" width="70px" height="70px"/> </span>
                            </div>

                            <div class="col-xs-8 col-sm-10 col-md-11">
                                <h2 class="stu-name-margin"><?php echo $row['name']; ?></h2>
                            </div>
                        </div>

                        <tr>
                            <th><b><?php echo get_phrase('email_: '); ?></b></th>
                            <td>
                                <?php echo $row['email']; ?>
                            </td>
                        </tr>
                        <tr>
                            <th><b><?php echo get_phrase('logged_in_as_: '); ?></b></th>
                            <td>
                                <?php echo "Admin"; ?>
                            </td>
                        </tr>
                    </table>
                </div>
                <?php endforeach; ?>
        </div>
    </div>
</div>