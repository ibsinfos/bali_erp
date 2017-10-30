<!-- Bootstrap Core CSS -->
<link href="<?php echo base_url();?>assets/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Menu CSS -->
<link href="<?php echo base_url();?>assets/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">

<!--Fa-icons-->
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/icons/font-awesome/css/font-awesome.min.css">

<!-- morris CSS -->
<link href="<?php echo base_url();?>assets/bower_components/morrisjs/morris.css" rel="stylesheet">
<!-- chartist CSS -->
<link href="<?php echo base_url();?>assets/bower_components/chartist-js/dist/chartist.min.css" rel="stylesheet">
<link href="<?php echo base_url();?>assets/bower_components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css" rel="stylesheet">
<!-- Calendar CSS -->
<link href="<?php echo base_url();?>assets/bower_components/calendar/dist/fullcalendar.css" rel="stylesheet" />
<!--charts css for dashboard-->
<!-- chartist CSS -->
<link href="<?php echo base_url();?>assets/bower_components/chartist-js/dist/chartist.min.css" rel="stylesheet">
<link href="<?php echo base_url();?>assets/bower_components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css" rel="stylesheet">

<!-- morris CSS -->
<link href="<?php echo base_url();?>assets/bower_components/morrisjs/morris.css" rel="stylesheet">
<link href="<?php echo base_url();?>assets/bower_components/css-chart/css-chart.css" rel="stylesheet">
<!--Gauge chart CSS -->
<link href="<?php echo base_url();?>assets/bower_components/Minimal-Gauge-chart/css/cmGauge.css" rel="stylesheet" type="text/css" />
<!-- Vector CSS -->
<link href="<?php echo base_url();?>assets/bower_components/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet" />

<!-- animation CSS -->
<link href="<?php echo base_url();?>assets/css/animate.css" rel="stylesheet">

<!--for ERP tour-->
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/introjs.css">

<!--dropify css-->
<link rel="stylesheet" href="<?php echo base_url();?>assets/bower_components/dropify/dist/css/dropify.min.css">

<!-- Date picker plugins css -->
<link href="<?php echo base_url();?>assets/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />


<!-- Color picker plugins css -->
<link href="<?php echo base_url();?>assets/bower_components/jquery-asColorPicker-master/css/asColorPicker.css" rel="stylesheet">

<!-- Daterange picker plugins css -->
<link href="<?php echo base_url();?>assets/bower_components/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
<link href="<?php echo base_url();?>assets/bower_components/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">


<!--Datetimepicker together-->
<!-- <link href="<?php //echo base_url();?>assets/bower_components/bootstrap-datepicker/bootstrap-datetimepicker.css" rel="stylesheet"> -->
<link href="<?php echo base_url();?>assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet"> 

<!--clockpicker css-->
<link href="<?php echo base_url();?>assets/bower_components/clockpicker/dist/jquery-clockpicker.min.css" rel="stylesheet">

<!--For datatable-->
<link href="<?php echo base_url();?>assets/bower_components/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/bower_components/datatables/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/bower_components/datatables/responsive.dataTables.min.css" rel="stylesheet" type="text/css" />

<!--dropdown selectpicker-->
<link href="<?php echo base_url();?>assets/bower_components/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />

<!--For multiselect dropdown-->
<link href="<?php echo base_url();?>assets/bower_components/multiselect/css/multi-select.css" rel="stylesheet" type="text/css" />


<!-- toast CSS -->
<link href="<?php echo base_url();?>assets/bower_components/toast-master/css/jquery.toast.css" rel="stylesheet">

<!--Sweat alerts CSS -->
<link href="<?php echo base_url();?>assets/bower_components/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">

<!--USer card-->
<link href="<?php echo base_url();?>assets/bower_components/Magnific-Popup-master/dist/magnific-popup.css" rel="stylesheet">

<!--Switch button-->
<link href="<?php echo base_url();?>assets/bower_components/switchery/dist/switchery.min.css" rel="stylesheet" />

<!--summernote editor-->
<link href="<?php echo base_url();?>assets/bower_components/summernote/dist/summernote.css" rel="stylesheet" />

<!-- Calendar CSS -->
<link href="<?php echo base_url();?>assets/bower_components/calendar/dist/fullcalendar.css" rel="stylesheet" />

<!-- Custom theme CSS -->
<link href="<?php echo base_url();?>assets/css/style.css" rel="stylesheet">

<!-- color CSS -->
<link href="<?php echo base_url();?>assets/css/colors/blue-dark.css" id="theme" rel="stylesheet">

<link href="<?php echo base_url();?>assets/bower_components/jquery-loading/dist/jquery.loading.min.css" rel="stylesheet" type="text/css">

<!--Own Custom style css -->
<link href="<?php echo base_url();?>assets/css/custom-style.css" rel="stylesheet" id="color-switcher">

<!--Own New Custom style css -->
<link href="<?php echo base_url();?>assets/css/new-custom-style.css" rel="stylesheet">

<script src="<?php echo base_url('assets/bower_components/jquery/dist/jquery.min.js');?>"></script>

<script type="text/javascript">
	jQuery(document).ready(function($){
		$('.notify').hide();
        setInterval(ajaxCallUnreadMessage,5000);  
	});

	function ajaxCallUnreadMessage(){
        var mycontent = "";
	    base_url = $('#base_url').val();
	    mycontent = $.ajax({
	        async: false,
	        dataType: 'json',
	        url: base_url + 'index.php?Ajax_controller/getNotifications_new',
	        success: function (response) {
	        },
	        error: function (error_param, error_status) {

	        }
	    });

	    notific = $.parseJSON(mycontent.responseText);

	    if(notific.total_count > 0){
	    	$('.heartbit').empty();
	    	$('.heartbit').html(notific.total_count);
	    	$('.notify').show();
	    }else{
	    	$('.notify').hide();
	    }	    
    }

    function open_panel()
    {
	    slideIt();
	    var a=document.getElementById("feedback_sidebar");
	    a.setAttribute("id","feedback_sidebar1");
	    a.setAttribute("onclick","close_panel()");
    }

    function slideIt()
    {
        var slidingDiv = document.getElementById("feedback_slider");
        var stopPosition = 0;
        
        if (parseInt(slidingDiv.style.right) < stopPosition )
        {
            slidingDiv.style.right = parseInt(slidingDiv.style.right) + 2 + "px";
            setTimeout(slideIt, 1); 
        }
    }
        
    function close_panel(){
	    slideIn();
	    a=document.getElementById("feedback_sidebar1");
	    a.setAttribute("id","feedback_sidebar");
	    a.setAttribute("onclick","open_panel()");
    }

    function slideIn()
    {
        var slidingDiv = document.getElementById("feedback_slider");
        var stopPosition = -375;
        
        if (parseInt(slidingDiv.style.right) > stopPosition )
        {
            slidingDiv.style.right = parseInt(slidingDiv.style.right) - 2 + "px";
            setTimeout(slideIn, 1); 
        }
    }

    $(document).ready(function(){
    	var frm = $('#FeedbackForm');
    	frm.submit(function (e) {
    		$.ajax({
	            type: frm.attr('method'),
	            url: frm.attr('action'),
	            data: frm.serialize(),

	            beforeSend: function(){
	                $('#loader').show();
	            },

	            success: function (data) {
	                $('body').loading('stop');
	                console.log(data);
	                close_panel();
	            },
	            error: function (data) {
	                console.log('An error occurred.');
	            },
	        }); 
	        return false;
    	});

    	$('.fa-hand-o-right').click(function(){
    		close_panel();
    	});
    });

</script>


<div id="feedback_slider" style="right:-375px !important;">
    <div id="feedback_header">            
        <h2>Feedback Form</h2>
		<?php echo form_open(base_url() . 'index.php?Ajax_controller/send_feedback', array('class' => 'form', 'id' => 'FeedbackForm')); ?>
        <div class="col-xs-12 col-md-12 form-group">
			<input type="text" class="form-control" placeholder="Title" name="title" value="<?php echo set_value('title') ?>" autocomplete="off" required="required">
		</div>

		<div class="col-xs-12 col-md-12 form-group"> 
        	<textarea class="form-control" name="description" value="<?php echo set_value('description') ?>" rows="5" required placeholder="Description"></textarea>
        </div>

        <div class="col-xs-12 col-md-12 form-group"> 
        	<input type="file" id="input-file-now" class="dropify" name="feedback_document" />        	
        </div>

        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d text-center sub-btn"><?php echo get_phrase('send'); ?></button>
        <?php echo form_close(); ?>
        	<i class="fa fa-hand-o-right fa-2x text-right" aria-hidden="true"></i>

    </div>
</div>