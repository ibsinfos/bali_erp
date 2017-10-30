<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('Certificate_list'); ?> </h4></div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?teacher/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active">
                <?php echo get_phrase('certificate'); ?>
            </li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-md-12 p-0">
        <div class="col-lg-6 col-sm-6 col-xs-12">
            <div class="white-box" data-step="5" data-intro="<?php echo get_phrase('Experience Certificate Genereate');?>" data-position='right'>
                <h3 class="m-t-0 m-b-20 text-center"><b><?php echo get_phrase('experience_certificate'); ?></b></h3>
                <ul class="list-inline text-center">
                    <a href="<?php echo base_url(); ?>index.php?teacher/experince_certificate">
                        <button  type="button" class="btn btn-default btn-outline btn-circle btn-xl m-r-5"><i class="fa fa-file-text"></i></button>
                    </a>
                </ul>
            </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-xs-12">
            <div class="white-box" data-step="6" data-intro="<?php echo get_phrase('Internship Certificate Genereate');?>" data-position='right'>
                <h3 class="m-t-0 m-b-20 text-center"><b><?php echo get_phrase('internship_certificate'); ?></b></h3>
                <ul class="list-inline text-center">
                    <a href="<?php echo base_url(); ?>index.php?teacher/internship_certificate">
                        <button  type="button" class="btn btn-default btn-outline btn-circle btn-xl m-r-5"><i class="fa fa-vcard-o"></i></button>
                    </a>
                </ul>
            </div>
        </div>
    </div>
</div>
<!------CONTROL TABS START------>

<div class="col-md-12 white-box">

    <table class= "custom_table table display" cellspacing="0" width="100%" id="ex">
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
                            <a href="<?php echo base_url(); ?>index.php?certificate/<?php echo "teacher_".strtolower($row['template_type']); ?>/download/<?php echo $row['teacher_id']; ?>/<?php echo $row['certificate_id']; ?>"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="View Certificate"><i class="fa fa-eye"></i></button></a>                                                </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>    
