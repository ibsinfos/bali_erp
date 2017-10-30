
<style type="text/css">
    .compose-message-editor{margin-top: 20px; margin-bottom: 10px;}
    #sample_wysiwyg{min-height: 175px;}
    .WellOuter{margin:0px !important;}
    .error{color: red; display: none;}
    .required{color: red !important;}
    #loader, #loader2, .AfterSend{display: none;}
    .AfterSend{text-align: center;}
    .loader2{color: green; font-weight: bold; padding-top: 0px;}
    .continue_outer{padding: 0px 0px 0px 0px;}
</style>

<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('MANAGE NEW NOTICES'); ?></h4>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?teacher/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li><a href="<?php echo base_url(); ?>index.php?teacher/noticeboard"><?php echo get_phrase('noticeboard'); ?></a></li>
            <li class="active">
                <?php echo get_phrase('new_notice'); ?>
            </li>
        </ol>
    </div>
</div>

<div class="row">
<div class="col-sm-12">
<div class="white-box">
    <div class="tab-pane box active" id="list">
        <div class="box-content">
                <?php echo form_open(base_url() . 'index.php?teacher/create_custom_message', array('class' => 'form', 'id' => 'ReceiverTypeForm')); ?>
                    <div class="row">
                        <div class="form-group col-sm-5" data-step="5" data-intro="<?php echo get_phrase('Select a class.');?>" data-position='bottom'>
                            <label class="control-label"><?php echo get_phrase('class'); ?><span class="required">*</span></label>

                            <input type="hidden" name="reciever_class_id[]" id="reciever_class_id" value="">
                            <select class="selectpicker" multiple data-style="form-control" onchange="get_class()" id="class_id" name="class_id[]" data-live-search="true" data-actions-box="true">

        <?php foreach ($teacher_class as $row): ?>
                                <option value="<?php echo $row['class_id']; ?>"><?php echo $row['class']; ?></option>
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
        </div>
    </div>
</div>
</div>
</div>

<div id="loader"><center><img src="assets/images/preloader.gif"></center></div>

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

</script>