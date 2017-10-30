<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('photo_galleries'); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" 
        class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>

        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?<?php echo $this->session->userdata('login_type');?>/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>

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
    <!-- /.breadcrumb -->
</div>
<div class="row m-0">
    <div class="col-md-12 white-box">
        <div class="sttabs tabs-style-flip">
            <nav>
                <ul>
                    <li class="active" data-step="5" data-intro="<?php echo get_phrase('From here you can manage photo galleries');?>" data-position='right'>
                        <a href="#list" class="sticon fa fa-list"><span class="hidden-xs"><?php echo get_phrase('manage_galleries'); ?></span></a>
                    </li>
                    <li data-step="6" data-intro="<?php echo get_phrase('From here you can add new fee head');?>" data-position='left'>
                        <a href="#add" class="sticon fa fa-plus-circle">
                            <span class="hidden-xs"><?php echo get_phrase('create_gallery'); ?></span>
                        </a>
                    </li>
                </ul>
            </nav>
            <div class="content-wrap">     	
                <section id="list">  
                    <!--TABLE LISTING STARTS-->           
                    <table class= "custom_table table display" cellspacing="0" width="100%" id="dt_table">
                        <thead>
                            <tr>
                                <th><div><?php echo get_phrase('no'); ?></div></th>
                                <th><div><?php echo get_phrase('class'); ?></div></th>
                                <th><div><?php echo get_phrase('gallery_name'); ?></div></th>
                                <th><div><?php echo get_phrase('images'); ?></div></th>
                                <th><div><?php echo get_phrase('action'); ?></div></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count = 1;
                            foreach ($records as $rec): ?>
                                <tr>
                                    <td><?php echo $count++; ?></td>
                                    <td><?php echo $rec->class_name; ?></td>
                                    <td><?php echo $rec->title; ?></td>
                                    <td><?php echo $rec->image_count; ?></td>
                                    <td>
                                        <a href="javascript: void(0);"
                                        onclick="showAjaxModal('<?php echo base_url('index.php?'.$this->session->userdata('login_type').'/photo_gallery_edit/'.$rec->id);?>')">
                                            <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" 
                                                data-toggle="tooltip" data-placement="top" data-original-title="Edit">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </button>
                                        </a>
                                        
                                        <a href="<?php echo base_url('index.php?'.$this->session->userdata('login_type').'/photo_gallery_images/'.$rec->id)?>">
                                            <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" 
                                                data-toggle="tooltip" data-placement="top" data-original-title="Gallery Images">
                                                <i class="fa fa-picture-o"></i>
                                            </button>
                                        </a>
                                         
                                        <a href="javascript:void(0)" 
                                            onclick="confirm_act('<?php echo base_url('index.php?'.$this->session->userdata('login_type').'/photo_gallery_delete/'.$rec->id);?>')">
                                            <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger"
                                            data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-trash-o"></i></button>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <!-- <div class="row">
                        <?php foreach ($records as $rec){?>  
                        <div class="col-md-4">
                            <img src="" class="img-thumbnail"/>
                            <h4><?php echo $rec->title?></h4>
                        </div>
                        <?php }?>
                    </div> -->
                </section>
                <!--TABLE LISTING ENDS-->

                <!--CREATION FORM STARTS-->
                <section id="add">  
                    <?php echo form_open(base_url('index.php?'.$this->session->userdata('login_type').'/photo_galleries#add'), 
                        array('class' => 'form-horizontal form-groups-bordered validate', 
                    'target' => '_top')); ?>
                    <div class="row">
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="running_session"><?php echo get_phrase('running_session'); ?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-sellsy"></i></div>
                                <input type="text" class="form-control" name="name" value="<?php echo $running_year?>" disabled/> 
                            </div>
                        </div>
                    </div>
                    <br/>
                    
                    <div class="row">          
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="field-1"><?php echo get_phrase('class'); ?><span class="error mandatory">*</span></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-road"></i></div>
                                <select name="class_id" class="selectpicker" data-style="form-control" data-live-search="true">
                                    <option value="0"><?php echo get_phrase('common')?></option>
                                    <?php foreach($classes as $cls){?>
                                        <option value="<?php echo $cls->class_id?>"><?php echo $cls->name?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div> 
                    </div>
                    <br/>

                    <div class="row">          
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="field-1"><?php echo get_phrase('gallery_title');?><span class="error mandatory">*</span></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-road"></i></div>
                                <input type="text" class="form-control" name="title" required="required" value="<?php echo set_value('title')?>"/> 
                            </div>
                        </div> 
                    </div>
                    <br/>

                    <div class="row">          
                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label for="field-1"><?php echo get_phrase('gallery_description'); ?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-book"></i></div>
                                <textarea class="form-control" name="description"><?php echo set_value('description')?></textarea>
                            </div> 
                        </div>
                    </div>
                    <br>

                    <div class="form-group">
                        <div class="text-right">
                            <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('submit');?></button>
                        </div>
                    </div>
                   <?php echo form_close()?>   
                </section>                
            </div>
        </div>
    </div>
</div>
<script>
$(function(){
    $('#dt_table').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            "pageLength",
            {
                extend: 'print',
                exportOptions: {
                    columns: [ 0, 1, 2]
                }
            },
            {
                extend: 'copyHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2]
                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2]
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2]
                },
                customize: function (doc) {
                    doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                }
            }
        ],
        columnDefs: [{ orderable: false, targets:-1 }],
        order: [[ 0, 'asc' ]]
    });
});

$(document).on('change','input[name=non_enroll]',function(){
    if(this.checked){
        $('input[name=amount]').val('');
        $('.amt-box').show();            
    }else{
        $('input[name=amount]').val('');          
        $('.amt-box').hide();
    }
});
</script>