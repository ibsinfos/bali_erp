<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('view_noticeboard'); ?></h4>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?teacher/dashboard"><?php echo get_phrase('dashboard'); ?></a></li>

<?php $BRC = get_bread_crumb_old(); if (strpos($BRC, '^') !== false) { $ExpBrd = explode('^', $BRC);?>
            <li>
                <?php echo get_phrase(@$ExpBrd[0]); ?>
                <?php echo @$ExpBrd[1]; ?>
            </li> <?php }else{ $ExpBrd[2] = $BRC;}?>
            <li class="active">
                <?php echo get_phrase(@$ExpBrd[2]); ?>
            </li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-md-12 text-right">
        <a href="<?php echo base_url(); ?>index.php?teacher/send_notices">
            <button type="button" class=" m-b-20 btn btn-primary btn-circle btn-lg pull-right tooltip-danger" data-target="#add-contact" data-toggle="tooltip" data-placement="left" data-original-title="New Notice" data-step="5" data-intro="Send new notices!!" data-position='left' >
             <i class="fa fa-plus"></i>    
            </button>                 
        </a>
    </div>
    <div class="col-sm-12">    
        <div class="white-box" data-step="6" data-intro="<?php echo get_phrase('Here lists the notices!!');?>" data-position='top'> 
            <!-- <table id="example23" class="display nowrap table_edjust" > -->
            <table id="example23" class="display table_edjust" cellspacing="0" width="100%">

                <thead>
                    <tr>
                        <th width="5%"><div>No</div></th>
                        <th width="20%"><div><?php echo get_phrase('title');?></div></th>
                        <th width="45%"><div><?php echo get_phrase('notice');?></div ></th>
                        <!-- <th width="15%"><div><?php echo get_phrase('class');?></div></th> -->
                        <th width="10%"><div><?php echo get_phrase('send_by');?></div></th>
                        <!-- <th width="5%"><div><?php //echo get_phrase('details');?></div></th> -->
                        <th width="15%"><div><?php echo get_phrase('date');?></div></th>
                    </tr>
                </thead>
                <tbody>    
                    
                <?php $count = 1; 
                    foreach ($notices as $row):?>
                    <tr>
                        <td><?php echo $count++;?></td>
                        <td><?php echo ucfirst(wordwrap($row['notice_title'], 30, "\n", true));?></td>
                        <td><?php echo ucfirst(wordwrap($row['message'], 50, "\n", true)); ?></td>
                        <!-- <td><?php echo ucfirst(wordwrap($row['class_name'], 25, "\n", true)); ?></td> -->
                        <td><?php echo ($row['sender_type']=='SA') ? 'School Admin':(($row['sender_type']=='T')?'Teacher':'');?></td>
                        <!-- <td>
                        <a href="javascript: void(0);" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/view_notice_details/<?php echo $row['custom_message_id']; ?>');">
                            <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger tooltip-danger" data-toggle="tooltip" 
                               data-placement="top" data-original-title="<?php echo get_phrase('view_details'); ?>" title="<?php echo get_phrase('view_details'); ?>">
                                <i class="fa fa-file-text-o"></i>
                            </button>
                        </a>
                        </td> -->
                        <td><?php echo date('d M, Y', strtotime($row['message_created_at']));?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>      
        </div>
    </div>
</div>