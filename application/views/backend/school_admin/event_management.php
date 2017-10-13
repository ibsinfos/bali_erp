<style type="text/css">
.modal-dialog {
	width: 700px !important;
}
</style> 

<?php 
$this->load->helper("functions");
$this->load->library("CSRF_Protect");
$csrf = new CSRF_Protect(); ?>

<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('MANAGE_EVENTS');?></h4>
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

<div class="row m-t-40">
    <div class="col-md-12">
        <!-- row -->
        <div class="row">
            <div class="col-md-3">
                <div class="white-box">
                    <h3>Drag and drop your event </h3>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <a href="#" class="btn btn-lg m-t-20 btn-danger btn-block waves-effect waves-light" 
                                data-step="5" data-intro="<?php echo get_phrase('Add a new event Category here!!');?>" data-position='top'
                                onclick="showAjaxModal('<?php echo base_url('index.php?modal/popup/modal_event_types/')?>');">
                                <i class="fa fa-plus-circle"></i> New Event Category
                            </a>
                           <!--  <a href="#" data-toggle="modal" data-target="#delete-type" class="btn btn-lg m-t-20  btn-danger btn-block waves-effect waves-light">
                                <i class="fa fa-remove"></i> Delete Event Category
                            </a> -->
                            <a href="#" data-toggle="modal" data-target="#add-event" class="btn btn-lg m-t-20 btn-danger btn-block waves-effect waves-light"
                                data-step="7" data-intro="<?php echo get_phrase('Add a new event here!!');?>" data-position='top'>
                                <i class="fa fa-plus-circle"></i> Add Event 
                            </a>
                            <div id="calendar-events" class="m-t-20" data-step="6" data-intro="<?php echo get_phrase('View the events category added!!');?>" data-position='top'>
                                <?php foreach($recent_events as $val){ ?>
                                    <div class="calendar-events bg-danger"  bg-<?php echo $val['color']?>>
                                        <font style="color:#ffffff !important;"><?php echo $val['description']; ?></font>
                                    </div>                
                                <?php } ?>
                                <!--<div class="calendar-events" data-class="bg-success"><i class="fa fa-circle text-success"></i> My Event Two</div>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="white-box" >
                    <div id="eventcalendar" data-step="6" data-intro="<?php echo get_phrase('View the events category added!!');?>" data-position='top'></div>
                </div>
            </div>
        </div>
        <!-- /.row -->
       
        <!-- Modal Add Event Category -->        
        <!-- <div class="modal fade" id="add-type">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form role="form">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title"><strong>Add</strong> event type</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="control-label">Event Name</label>
                                    <input class="form-control form-white" placeholder="Enter name" type="text" name="category-name" id="category-name"  />
                                </div>
                                 <div class="col-md-6">
                                    <label class="control-label">Choose Event Color</label>
                                    <select class="form-control form-white" data-placeholder="Choose a color..." name="category-color" id="category-color">
                                        <option value="success">Success</option>
                                        <option value="danger">Danger</option>
                                        <option value="info">Info</option>
                                        <option value="primary">Primary</option>
                                        <option value="warning">Warning</option>
                                    </select>
                                </div> 
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger waves-effect waves-light save-category" data-dismiss="modal">Save</button>
                            <button type="button" class="btn btn-white waves-effect" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div> -->
        
        <!-- Modal Delete Event Category --> 
        <!-- <div class="modal fade none-border" id="delete-type">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form role="form">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title"><strong>Delete</strong> event type</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="control-label">Select Event Type</label>
                                    <select class="form-control form-white" data-placeholder="Choose a category..." name="category-name"
                                            id="category-name">
                                            <?php /*foreach($types as $val){ ?>
                                                <option value="<?php echo $val['id'];?>"><?php echo $val['title'];?></option>
                                            <?php }*/ ?>
                                    </select>
                                </div>                                
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger waves-effect waves-light delete-category" data-dismiss="modal">Delete</button>
                            <button type="button" class="btn btn-white waves-effect" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div> -->
        
        <!-- Modal Add Event-->        
        <div class="modal fade none-border" id="add-event">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form role="form">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"><strong>Add event </strong> </h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Event Description</label>
                                    <input class="form-control form-white" placeholder="Enter Description" type="text" name="description-name" id="description-name" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Select Event Type</label>
                                    <select class="selectpicker form-white" data-style="form-control" data-live-search="true" data-placeholder="Choose a category..." name="event-type" id="event-type">
                                        <option value="">Select Type</option>
                                        <?php foreach($types as $val){ ?>
                                        <option value="<?php echo $val['title'];?>"><?php echo $val['title'];?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div> 
                                                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Choose Start Date</label>
                                    <input class="form-control form-white" id="datetimepicker_1" type="text"  name="startTime" value="<?php echo date('Y-m-d H:i')?>"/> 
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Choose End Date</label>
                                    <input class="form-control form-white" id="datetimepicker_2" type="text" name="endTime" 
                                    value="<?php echo date('Y-m-d H:i',strtotime('+1 days'))?>"/> 
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Choose Event Color</label>
                                    <input class="colorpicker form-control form-white " type="text" name="color-picker" id="color-picker" value="#7ab2fa" /> 
                                </div>
                                </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="fcbtn btn btn-danger btn-outline btn-1d save-event">Add</button>
                        <!-- <button type="button" class="btn btn-white waves-effect" data-dismiss="modal">Close</button> -->
                    </div>
                    </form>
                </div>
            </div>
        </div>       
    </div>
</div>
<?php echo listEvents(); ?>

<script type="text/javascript">
$(function () {
    $('#datetimepicker_1, #datetimepicker_2').datetimepicker({autoclose:true});
});

function update_event_type(categoryName, categoryColor){
    var categoryName = $('#category-name').val();
    var cadastategoryColor = $('#category-color').val();
    var deferred = $.Deferred();
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>index.php?ajax_controller/event_type/',
        data: { categoryName:categoryName,categoryColor:categoryColor},
        dataType:'json',
        success: function (data){
            deferred.resolve(data);
        },
        error: function(){
            //alert('not updated');
        }
    });
    return deferred.promise();
}

function delete_event_type(categoryId){
confirm_modal('<?php echo base_url(); ?>index.php?ajax_controller/delete_event_type/'+categoryId);
    //var categoryId = $('#category-name option:checked').val(); 
//    $('#confirm-modal').modal({
//      backdrop: 'static',
//      keyboard: false
//    })
//    .one('click', '#con-del-act', function(e) {
//        $.ajax({
//            type: 'POST',
//            url: '<?php //echo base_url(); ?>index.php?ajax_controller/delete_event_type/',
//            data: {categoryId:categoryId},
//            dataType:'json',
//            success: function (data){
//                if(data.type=='success'){
//                    swal('',data.msg,'success')
//                    window.location.reload();
//                }else{
//                    swal('',data.msg,'error');
//                    $('#confirm-modal').modal('hide');
//                }
//            }
//        });
//    });    
}

function add_event(eventType, description, colorPicker, startTime, endTime){
    var description = $('#description-name').val();
    var eventType = $('#event-type').val();
    var colorPicker = $('#color-picker').val();
    var startTime = $('#datetimepicker_1').val();
    var endTime = $('#datetimepicker_2').val();

    $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>index.php?school_admin/event/create/',
        data: { eventType:eventType, description:description, colorPicker:colorPicker, startTime:startTime, endTime:endTime},
        success: function (data){
            //console.log(data);
            window.location.reload();
        },
        error: function(){
            //alert('not updated');
        }
    });
}

function delete_events(eventId){
confirm_modal('<?php echo base_url(); ?>index.php?ajax_controller/delete_event/'+eventId);
    //var categoryId = $('#category-name option:checked').val(); 
//    $('#confirm-modal').modal({
//      backdrop: 'static',
//      keyboard: false
//    })
//    .one('click', '#con-del-act', function(e) {
//        $.ajax({
//            type: 'POST',
//            url: '<?php echo base_url(); ?>index.php?ajax_controller/delete_event/',
//            data: {eventId:eventId},
//            dataType:'json',
//            success: function (data){
//                alert(data);
//                if(data.type=='success'){
//                    //swal('',data.msg,'success')
//                    window.location.reload();
//                }else{
//                    //swal('',data.msg,'error');
//                    $('#confirm-modal').modal('hide');
//                }
//            }
//        });
//    });    
}


$(document).on('click','[data-target="#add-type"]',function(){
    $('#modal_ajax').modal('hide');
});

</script>