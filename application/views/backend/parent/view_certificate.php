<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('Certificate_list'); ?> </h4></div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?parents/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active">
                <?php echo get_phrase('certificate'); ?>
            </li>
        </ol>
    </div>
</div>

<!------CONTROL TABS START------>

<div class="col-md-12 white-box" data-step="7" data-intro="<?php echo get_phrase('This shows list of subject details.'); ?>" data-position='top'>

    <table class= "custom_table table display" cellspacing="0" width="100%" id="example23">
        <thead>
            <tr>
                <th><div><?php echo get_phrase('s._no.'); ?></div></th>
                <th><div><?php echo get_phrase('certificate_title'); ?></div></th>
                <th><div><?php echo get_phrase('sub_title'); ?></div></th>
                <th><div><?php echo get_phrase('issue_date'); ?></div></th>
                <th><div><?php echo get_phrase('options'); ?></div></th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($certificate_list)):
                $count = 1;

                foreach ($certificate_list as $row):
                    ?>
                    <tr>
                        <td><?php echo $count++; ?></td>
                        <td><?php echo ucfirst($row['certificate_title']); ?></td>
                        <td><?php
                            echo ucfirst($row['sub_title']);
                            ?>
                        </td>
                        <td><?php echo $row['date']; ?></td>
                        <td>
                            <a href="<?php echo base_url(); ?>index.php?parents/template<?php echo $row['template_type']; ?>/download/<?php echo $row['student_id']; ?>/<?php echo $row['certificate_id']; ?>"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="View Certificate"><i class="fa fa-eye"></i></button></a>                                                </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>    
