<?php
//require(base_url()."assets/event_assets/functions/functions.php");
?>

<link href="<?php echo base_url(); ?>assets/event_assets/css/fullcalendar.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>assets/event_assets/css/fullcalendar.print.css" rel="stylesheet" media="print" />	

<script src="<?php echo base_url(); ?>assets/event_assets/js/sweetalert.min.js"></script> 
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/event_assets/css/sweetalert.css">
<!-- Custom Fonts -->

<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('EVENTS'); ?></h4>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?parents/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active">
                <?php echo get_phrase('EVENTS'); ?>
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
                    <h3 class="box-title">Drag and drop your event </h3>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
<!--                            <a href="#" class="btn btn-lg m-t-20 btn-danger btn-block waves-effect waves-light" 
                                data-step="5" data-intro="<?php // echo get_phrase('Add a new event Category here!!');?>" data-position='top'
                                onclick="showAjaxModal('<?php // echo base_url('index.php?modal/popup/modal_event_types/')?>');">
                                <i class="fa fa-plus-circle"></i> New Event Category
                            </a>-->
                           <!--  <a href="#" data-toggle="modal" data-target="#delete-type" class="btn btn-lg m-t-20  btn-danger btn-block waves-effect waves-light">
                                <i class="fa fa-remove"></i> Delete Event Category
                            </a> -->
<!--                            <a href="#" data-toggle="modal" data-target="#add-event" class="btn btn-lg m-t-20 btn-danger btn-block waves-effect waves-light"
                                data-step="7" data-intro="<?php // echo get_phrase('Add a new event here!!');?>" data-position='top'>
                                <i class="fa fa-plus-circle"></i> Add Event 
                            </a>-->
                            <div id="calendar-events" class="m-t-20" data-step="6" data-intro="<?php echo get_phrase('View the events category added!!');?>" data-position='top'>
                                <?php foreach($types as $val){ ?>
                                    <div class="calendar-events bg-danger"  bg-<?php echo $val['event_color']?>>
                                        <?php echo $val['title']; ?>
                                    </div>                
                                <?php } ?>
                                <!--<div class="calendar-events" data-class="bg-success"><i class="fa fa-circle text-success"></i> My Event Two</div>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="white-box">
                    <div id="eventcalendar"></div>
                </div>
            </div>
        </div>
        <!-- /.row -->
<!-- Header -->
<div id="home"></div>

<!-- /.intro-header -->

<!-- Page Content -->

<div id="eventcalendar"></div>
<div class="content-section-a">

    <!--BEGIN PLUGIN -->
    <div class="container-fluid no-padding">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default dash no-border">
                       <!-- /.panel-heading -->
                            <div class="table-responsive" style="color:#aaa!important;border-color:#ddd!important;">
                            <div id="events"></div>
                            </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>



    <script src="<?php echo base_url(); ?>assets/event_assets/js/fullcalendar.min.js"></script>


<?php echo listEvents(); ?>
    <script>
        $(document).ready(function () {
            $('#dataTables-example').dataTable();
<?php
foreach ($events as $event):
    ?>
            var myevent = {
                id: "<?php echo $event['id']; ?>",
                title: "<?php echo $event['title']; ?>",
                description: "<?php echo $event['description']; ?>",
                start: "<?php echo $event['start']; ?>",
                end: "<?php echo $event['end']; ?>",
                allDay: false
            };
            $('#events').fullCalendar('renderEvent', myevent, true);
    <?php
    //break;
endforeach;
?>


    });
    </script>

