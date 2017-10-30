<style type="text/css">
    .compose-message-editor{margin-top: 20px; margin-bottom: 10px;}
    #sample_wysiwyg{min-height: 175px;}
    .WellOuter{margin:0px !important;}
    .error{color: red; display: none;}
    .required{color: red !important;}
    #loader, #loader2, .AfterSend{display: none;}
    .loader2{color: green; font-weight: bold; padding-top: 50px;}
    .continue_outer{padding: 0px 0px 132px 0px;}
</style>

<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?></h4>
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
                            <li data-step="5" data-intro="<?php echo get_phrase('From here you can view the list of notices');?>" data-position='top' class="active"><a href="#section-flip-1" class="sticon fa fa-list-ol" id="notice_list"><span><?php echo get_phrase('noticeboard_list'); ?></span></a></li>
                            <li data-step="6" data-intro="<?php echo get_phrase('From here you can add a notice.');?>" data-position='top' id="add_notice"><a href="#section-flip-2" class="sticon fa fa-plus-square"><span><?php echo get_phrase('add_notice'); ?></span></a></li>                        
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
                                        <!-- <th width="12%"><div><?php echo get_phrase('class');?></div></th> -->
                                        <th width="10%"><div><?php echo get_phrase('added_by');?></div></th>
                                        <th width="13%"><div><?php echo get_phrase('date');?></div></th>
                                        <th width="15%"><div><?php echo get_phrase('options');?></div></th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php $count = 1; if(count($notices)){
                                        foreach($notices as $row):?>
                                        <tr>
                                            <td><?php echo $count++;?></td>
                                            <td><?php echo ucfirst(wordwrap($row['notice_title'], 30, "\n", true));?></td>
                                            <td><?php echo ucfirst(wordwrap($row['message'], 45, "\n", true));?></td>
                                            <!-- <td><?php echo $row['class_name'];?></td> -->
                                            <td><?php echo ($row['sender_type']=='SA') ? 'School Admin':(($row['sender_type']=='T')?'Teacher':'');?></td>
                                            <td><?php echo date('d M, Y', strtotime($row['message_created_at']));?></td>
                                            <td>
                                                <!-- <a href="javascript: void(0);" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_edit_notice/<?php echo $row['notice_id'];?>');">
                                                    <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil-square-o"></i></button>
                                                </a> -->                                               
                                                <a href="javascript: void(0);" onclick="confirm_modal('<?php echo base_url();?>index.php?school_admin/noticeboard/delete/<?php echo $row['custom_message_id'];?>');">
                                                    <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-trash-o"></i></button>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php endforeach; }?>
                                    </tbody>
                                </table>
                            </div>                        
                        </section>
                        <section id="section-flip-2">
                                    <?php echo form_open(base_url() . 'index.php?school_admin/create_custom_message', array('class' => 'form', 'id' => 'ReceiverTypeForm')); ?>
                                        <div class="row">
                                            <div class="form-group col-sm-5" data-step="5" data-intro="<?php echo get_phrase('Select a class.');?>" data-position='bottom'>
                                                <label class="control-label"><?php echo get_phrase('class'); ?><span class="required">*</span></label>

                                                <input type="hidden" name="reciever_class_id[]" id="reciever_class_id" value="">
                                                <select class="selectpicker" multiple data-style="form-control" onchange="get_class()" id="class_id" name="class_id[]" data-live-search="true" data-actions-box="true">

                            <?php foreach ($classes as $row): ?>
                                                    <option value="<?php echo $row['class_id']; ?>"><?php echo $row['name']; ?></option>
                            <?php endforeach;?>
                                                </select>

                                                <p class="error cls_error">Please select class</p>
                                            </div>

                                            <div class="form-group col-sm-5" data-step="6" data-intro="<?php echo get_phrase('Select receiver type.');?>" data-position='bottom'>
                                                <label class="control-label"><?php echo get_phrase('receiver'); ?><span class="required">*</span></label>

                                                <input type="hidden" name="reciever_type_id[]" id="reciever_type_id" value="">
                                            <select class="selectpicker" multiple data-style="form-control" onchange="get_receiver()" id="receiver_type" name="receiver_type[]" data-live-search="true" data-actions-box="true">

                                                    <option value="1">Parent</option>
                                                    <option value="2">Student</option> 
                                                    <option value="3">Teacher</option>
                                                </select>
                                                <p class="error rcv_error">Please select receiver type</p>
                                            </div>                                            
                                        </div>

                                        <div class="continue_outer" data-step="7" data-intro="<?php echo get_phrase('Click for get message form');?>" data-position='bottom'>
                                            <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d">
                                                <?php echo get_phrase('continue'); ?>
                                            </button>
                                        </div>
                                <?php echo form_close(); ?>
                                <div id="loader"><center><img src="assets/images/preloader.gif"></center></div>                                
                        </section>
                    </div>  
                </div>
            </section>        
    </div>
</div>

<div id="BottomPart"></div>

<script type="text/javascript">
    function get_class(){
        var reciever_class_id = []; 
        $('#class_id :selected').each(function(i, selected){ 
            reciever_class_id[i] = $(selected).val(); 
        });
        $('#reciever_class_id').val(reciever_class_id);           
    }

    function get_receiver(){
        var reciever_type_id = []; 
        $('#receiver_type :selected').each(function(i, selected){ 
            reciever_type_id[i] = $(selected).val(); 
        });
        $('#reciever_type_id').val(reciever_type_id);           
    }

    var TotalClass = TotalReceiver = 0;

    var frm = $('#ReceiverTypeForm');
    frm.submit(function (e) {
        TotalClass =$('#class_id :selected').length;
        TotalReceiver =$('#receiver_type :selected').length;

        if((TotalClass == 0) && (TotalReceiver == 0)){
            $('.cls_error').show();
            $('.rcv_error').show();
            return false;
        }else{
            $('.cls_error').hide();
            $('.rcv_error').hide();
        }

        if(TotalClass == 0){
            $('.cls_error').show();
            return false;
        }else{
            $('.cls_error').hide();
        }

        if(TotalReceiver == 0){
            $('.rcv_error').show();
            return false;
        }else{
            $('.rcv_error').hide();
        }

        if((TotalClass)&&(TotalReceiver)){
            $.ajax({
                type: frm.attr('method'),
                url: frm.attr('action'),
                data: frm.serialize(),

                beforeSend: function(){
                    $('#loader').show();
                },

                success: function (data) {
                    $('#loader').hide();
                    $('#BottomPart').empty();
                    $('#BottomPart').html(data);
                    $('#add_notice').click();
                },
                error: function (data) {
                    console.log('An error occurred.');
                    console.log(data);
                },
            }); 
            return false;           
        }else{
            e.preventDefault();
        }
    });

    $(document).ready(function(){
        $('#notice_list').click(function(){
            $('#BottomPart').hide();
        });

        $('#add_notice').click(function(){
            $('#BottomPart').show();
        });
    });

</script>