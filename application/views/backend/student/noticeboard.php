<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('view_noticeboard'); ?></h4>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" nclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?student/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active">
                <?php echo get_phrase('noticeboard'); ?>
            </li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">    
        <div class="white-box" data-step="5" data-intro="<?php echo get_phrase('Here you can view the noticeboard information.');?>" data-position='top'> 
            <table id="example23" class="display table_edjust" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th width="5%"><div>No</div></th>
                        <th width="15%"><div><?php echo get_phrase('title');?></div></th>
                        <th width="60%"><div><?php echo get_phrase('notice');?></div></th>
                        <th width="10%"><div><?php echo get_phrase('class');?></div></th>
                        <th width="10%"><div><?php echo get_phrase('date');?></div></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $count = 1;foreach($notices as $row):?>
                    <tr>
                        <td><?php echo $count++;?></td>
                        <td><?php echo ucfirst(wordwrap($row['notice_title'], 35, "\n", true));?></td>
                        <td class="span5"><?php echo ucfirst(wordwrap($row['notice'], 65, "\n", true));?></td>
                        <td><?php echo ($row['name']=="") ? get_phrase('common_notice') : $row['name'];?></td>
                        <td><?php echo date('d M, Y', $row['create_timestamp']);?></td>							
                    </tr>
                    <?php endforeach;?>
                    </tbody>
            </table>      
        </div>
    </div>
</div>                                        
























