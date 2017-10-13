<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('manage_noticeboard'); ?></h4>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
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
<div class="row m-0" >
    <div class="col-md-12 white-box">        
            <section>
                <div class="sttabs tabs-style-flip">
                    <nav>
                        <ul>
                            <li  data-step="5" data-intro="<?php echo get_phrase('From here you can view the list of notices');?>" data-position='top' class="active"><a href="#section-flip-1" class="sticon fa fa-list-ol"><span><?php echo get_phrase('noticeboard_list'); ?></span></a></li>
                            <li  data-step="6" data-intro="<?php echo get_phrase('From here you can add a notice.');?>" data-position='top'><a href="#section-flip-2" class="sticon fa fa-plus-square"><span><?php echo get_phrase('add_notice'); ?></span></a></li>                        
<!--                            <li class="active"><a href="#section-flip-1" class="sticon fa fa-list-ol"><span><?php echo get_phrase('noticeboard_list'); ?></span></a></li>
                            <li><a href="#section-flip-2" class="sticon fa fa-plus-square"><span><?php echo get_phrase('add_notice'); ?></span></a></li>                
 -->                       </ul>
                    </nav> 
                    <div class="content-wrap">
                        <section id="section-flip-1">                                     
                            <div class="tab-pane box active" id="section-flip-1">
                                <table id="example23" class="display table_edjust" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                        <th width="5%"><div><?php echo get_phrase('no');?></div></th>
                                        <th width="15%"><div><?php echo get_phrase('title');?></div></th>
                                        <th width="30%"><div><?php echo get_phrase('notice');?></div></th>
                                        <th width="12%"><div><?php echo get_phrase('class');?></div></th>
                                        <th width="10%"><div><?php echo get_phrase('added_by');?></div></th>
                                        <th width="13%"><div><?php echo get_phrase('date');?></div></th>
                                        <th width="15%"><div><?php echo get_phrase('options');?></div></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $count = 1;
                                        foreach($notices as $row):?>
                                        <tr>
                                            <td><?php echo $count++;?></td>
                                            <td><?php echo ucfirst(wordwrap($row['notice_title'], 30, "\n", true));?></td>
                                            <td><?php echo ucfirst(wordwrap($row['notice'], 45, "\n", true));?></td>
                                            <?php if($row['class_id'] == ''){ ?>
                                            <td><?php echo get_phrase('common_notice');?></td>
                                            <?php } else{ ?>
                                            <td><?php echo $row['name'];?></td>
                                            <?php } ?>
                                            <td><?php echo $row['sender_type'];?></td>
                                            <td><?php echo date('d M, Y', strtotime($row['create_time']));?></td>
                                            <td>
                                                <a href="javascript: void(0);" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_edit_notice/<?php echo $row['notice_id'];?>');">
                                                    <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil-square-o"></i></button>
                                                </a>                                               
                                                <a href="javascript: void(0);" onclick="confirm_modal('<?php echo base_url();?>index.php?school_admin/noticeboard/delete/<?php echo $row['notice_id'];?>');">
                                                    <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-trash-o"></i></button>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php endforeach;?>
                                    </tbody>
                                </table>
                            </div>                        
                        </section>
                        <section id="section-flip-2">
                            <?php echo form_open(base_url() . 'index.php?school_admin/noticeboard/create' , array('class' => 'form-group validate','target'=>'_top'));?>
                            <div class ="row" >
                                <div class="col-sm-6 form-group">
                                    <label for="field-1"><?php echo get_phrase('title');?><span class="error" style="color: red;"> *</span></label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-tags"></i></div>
                                        <input type="text" class="form-control" name="notice_title" placeholder="Enter a title" required/>                                         </div>
                                    <label style="color:red;"> <?php echo form_error('notice_title'); ?></label>
                                </div>
                                <div class="col-sm-6 form-group">
                                <label for="field-2" class="control-label"><?php echo get_phrase('class'); ?><span class="error" style="color: red;"> *</span></label>
                                <select name="class_id" class="selectpicker" data-style="form-control"  data-container="body" data-live-search="true" required>
                                        <option><?php echo get_phrase('select_class'); ?></option>
                                        <option value=" "><?php echo get_phrase('all'); ?></option>
                                        <?php  foreach ($classes as $row): ?>
                                        <option value="<?php echo $row['class_id']; ?>"><?php echo $row['name']; ?></option>
                                        <?php endforeach;  ?>
                                    </select>                                
                                </div>                                                                                  
                            </div>
                            <?php $date = date('Y-m-d H:i:s');?>
                            <input type="hidden"  name="create_timestamp" value="<?php echo $date;?>"/>
                            <div class ="row">
                                <div class="col-sm-12 form-group">
                                    <label for="field-1"><?php echo get_phrase('description');?><span class="error" style="color: red;"> *</span></label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-bars"></i></div>
                                        <textarea name="notice" id="ttt" rows="5" placeholder=" " class="form-control" required></textarea>                                        
                                    </div>
                                    <label class="mandatory"> <?php echo form_error('notice'); ?></label>
                                </div>                                 
                            </div>                            
                            <div class="text-right">
                                <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" ><?php echo get_phrase('add_notice');?></button>
                            </div>
                            <?php echo form_close();?>
                        </section>
                    </div>  
                </div>
            </section>
        
    </div>
</div>    

