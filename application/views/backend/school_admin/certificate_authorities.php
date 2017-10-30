<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('certificate_types'); ?></h4>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour"  class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            
<?php $BRC = get_bread_crumb(); if (strpos($BRC, '^') !== false) { $ExpBrd = explode('^', $BRC);?>
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
<div class="white-box">        
    <section>
        <div class="sttabs tabs-style-flip">
            <nav>
                <ul>
                    <li id="section1">
                        <a href="#section-flip-1" class="sticon fa fa-list "data-step="5" data-intro="<?php echo get_phrase('Here you can see certificate authorities list.'); ?>" data-position='right'><span>
<?php echo get_phrase('certificate_authorities_list'); ?></span></a>
                    </li>
                    <li id="section2">
                        <a href="#section-flip-2" class="sticon fa fa-plus" data-step="6" data-intro="<?php echo get_phrase('From here you can add a certificate authorities.'); ?>" data-position='left'><span>
<?php echo get_phrase('add_certificate_authorities'); ?></span></a>
                    </li>                
                </ul>
            </nav>                                    
            <div class="content-wrap">
                <section id="section-flip-1">
                    <table class= "custom_table table display" cellspacing="0" width="100%" id="example23">
                        <thead>
                            <tr>
                                <th><div><?php echo get_phrase('s._no.'); ?></div></th>
                                <th><div><?php echo get_phrase('authorities_name'); ?></div></th>
                                <th><div><?php echo get_phrase('authorities_designation'); ?></div></th>
                                <th><div data-step="8" data-intro="<?php echo get_phrase('You can edit or delete a certificate authorities from here.'); ?>" data-position='left'><?php echo get_phrase('action'); ?></div></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if (!empty($authorities_list)) {
                                $count = 1;
                                foreach ($authorities_list as $row):
                                    ?>
                                    <tr>
                                        <td><?php echo $count++; ?></td>
                                        <td><?php echo $row['authorities_name']; ?></td>
                                        <td><?php echo $row['designaiton']; ?></td>
                                        <td>
                                            <a href="javascript: void(0);" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_edit_authorities/<?php echo $row['certificate_authorities_id']; ?>');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil-square-o"></i></button></a>
                                            <a href="javascript: void(0);" onclick="confirm_modal('<?php echo base_url(); ?>index.php?school_admin/certificate_authorities/delete/<?php echo $row['certificate_authorities_id']; ?>');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-trash-o"></i></button></a>
                                        </td> 
                                    </tr>
                                <?php endforeach; ?>
                            <?php } ?>
                        </tbody>
                    </table>
                </section>

                <section id="section-flip-2">
<?php echo form_open_multipart(base_url() . 'index.php?school_admin/certificate_authorities/create', array('class' => 'form-horizontal form-groups-bordered validate', 'target' => '_top')); ?>
                    <div class="row">
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="field-1"><?php echo get_phrase('Authorities_name'); ?><span class="mandatory"> *</span></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-user"></i></div>
                                <input type="text" class="form-control" name="name" placeholder="Authorities Name" required=""> 
                            </div>
                            <label class="mandatory"> <?php echo form_error('authorities_name'); ?></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="field-1"><?php echo get_phrase('designation_Authorities'); ?><span class="mandatory"> *</span></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-telegram"></i></div>
                                <input type="text" class="form-control" name="designation" placeholder="Authorities Designation" required=""> 
                            </div>
                            <label class="mandatory"> <?php echo form_error('designation'); ?></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="field-1"><?php echo get_phrase('Authorities_sign'); ?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-file"></i></div>
                                <input type="file" class="form-control" name="authorities_sign"> 
                            </div>
                            <label class="mandatory"> <?php echo form_error('authorities_sign'); ?></label>
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('add_authorities'); ?></button>
                    </div>
<?php echo form_close(); ?> 
                </section>             
            </div>
        </div>
    </section>
</div>