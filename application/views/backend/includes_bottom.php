
<div class="modal fade in" id="confirm-modal">
    <div class="modal-dialog" style="top:35%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title text-center">Do you want to remove this information ?</h4>
            </div>

            <div class="modal-footer text-center-imp">
                <button type="button" class="btn btn-danger confirm-act">Delete</button>
                <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url();?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<!--jquery-UI js only for calender-->
<script src="<?php echo base_url();?>assets/bower_components/calendar/jquery-ui.min.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="<?php echo base_url();?>assets/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Sidebar menu plugin JavaScript -->
<script src="<?php echo base_url();?>assets/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
<!--Slimscroll JavaScript For custom scroll-->
<script src="<?php echo base_url();?>assets/js/jquery.slimscroll.js"></script>
<!--Wave Effects -->
<script src="<?php echo base_url();?>assets/js/waves.js"></script>
<!--For Erp Take a tour-->
<script src="<?php echo base_url();?>assets/js/old_js/intro.js"></script>
<script src="<?php echo base_url('assets/js/key-navigate.js');?>"></script>
<!--For tabs -->
<script src="<?php echo base_url();?>assets/bower_components/jquery-loading/dist/jquery.loading.min.js"></script>
<script src="<?php echo base_url();?>assets/js/cbpFWTabs.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery.validate.min.js"></script>
<script src="<?php echo base_url();?>assets/js/fl-menu.js"></script>
<script src="<?php echo base_url();?>assets/sweetalert/sweetalert.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/sweetalert/sweetalert.css">
<script type="text/javascript">
    (function() {
        [].slice.call(document.querySelectorAll('.sttabs')).forEach(function(el) {
            new CBPFWTabs(el);
        });
    })();
</script>

<!--For file uplaod-->
<script src="<?php echo base_url();?>assets/bower_components/dropify/dist/js/dropify.min.js"></script>
<?php if ($this->session->flashdata('flash_message') != ""):?>
<script type="text/javascript">
var msg = '<?php echo json_encode($this->session->flashdata("flash_message"));?>';
EliminaTipo1(msg);
function EliminaTipo1(){
    //swal(msg);
    swal(msg,'','success')
}
</script>
<?php endif; ?>

<?php if($this->session->flashdata('flash_message_error') != ""):?>
<script type="text/javascript">
var msg = '<?php echo json_encode($this->session->flashdata("flash_message_error"));?>';
EliminaTipo5(msg);
function EliminaTipo5(){
//	swal(msg);
// alert(":shdgfjsgfhj");
    swal(
      msg,''
      ,
      'error'
    )
}
</script>
<?php endif;?>

<!--Datatable-->
<script src="<?php echo base_url();?>assets/bower_components/datatables/jquery.dataTables.min.js"></script>
<!-- start - This is for export functionality only -->
<script src="<?php echo base_url();?>assets/bower_components/datatables/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url();?>assets/bower_components/datatables/buttons.flash.min.js"></script>
<script src="<?php echo base_url();?>assets/bower_components/datatables/jszip.min.js"></script>
<script src="<?php echo base_url();?>assets/bower_components/datatables/pdfmake.min.js"></script>
<script src="<?php echo base_url();?>assets/bower_components/datatables/vfs_fonts.js"></script>
<script src="<?php echo base_url();?>assets/bower_components/datatables/buttons.html5.min.js"></script>
<script src="<?php echo base_url();?>assets/bower_components/datatables/buttons.print.min.js"></script>
<script src="<?php echo base_url();?>assets/bower_components/datatables/dataTables.responsive.min.js"></script>

<!--Numeric.js from old theme-->
<script src="<?php echo base_url();?>assets/js/old_js/jquery-numeric.js"></script>

<script>
    var example23_getrow = $('#example23').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            "pageLength",
            'copy', 'excel', 'pdf', 'print'
        ]
    });
    example23_getrow.$('tr').tooltip( {selector: '[data-toggle="tooltip"]'});

    var MoreTable = $('#MoreTable').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            "pageLength",
            'copy', 'excel', 'pdf', 'print'
        ]
    });
    MoreTable.$('tr').tooltip( {selector: '[data-toggle="tooltip"]'});
    
    var example_getrow = $('#example').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            "pageLength"
        ]
    });
    example_getrow.$('tr').tooltip( {selector: '[data-toggle="tooltip"]'});
    
    $('#ex_att').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        "pageLength": 100,
        buttons: [
            "pageLength",
            'copy', 'excel', 'pdf', 'print'
        ],
        "info":     false,

    });
    //
    $('#ex').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            "pageLength",
            'copy', 'excel', 'pdf', 'print'
        ],
        "info":     false,
        
    });

    $('#att').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            "pageLength"
        ],
        "info":     false,
        
    });
    
    //
    var classexample_getrow =  $('.example').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            "pageLength"
        ]
    });
    classexample_getrow.$('tr').tooltip( {selector: '[data-toggle="tooltip"]'});
    
    //
    var example_getrow_desc = $('.example_asc').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            "pageLength"            
        ],
        order: [[ 0, "desc" ]]
    });
    example_getrow_desc.$('tr').tooltip( {selector: '[data-toggle="tooltip"]'});
    
    //
    var example_getrow_desc_more = $('#example_asc_time').DataTable({
      dom: 'Bfrtip',
      responsive: true,
      buttons: [
          "pageLength",
          'copy', 'excel', 'pdf', 'print'
          
      ],
      order: [[ 0, "asc" ]]
    });
    example_getrow_desc_more.$('tr').tooltip( {selector: '[data-toggle="tooltip"]'});
    
    //For Blogs
    var blogs_desc_more = $('.blogs_desc').DataTable({
      dom: 'Bfrtip',
      responsive: true,
      buttons: [
          "pageLength"            
      ],
      order: [[ 0, "asc" ]]
    });
    blogs_desc_more.$('tr').tooltip( {selector: '[data-toggle="tooltip"]'});
    
     
    var example1234 = $('#example1234').DataTable({
        rowReorder: {selector: 'td:nth-child(2)'},
        responsive: true,
        dom: 'Bfrtip',
               buttons: [
            'pageLength',
            {
                extend: 'copyHtml5',
                exportOptions: {
                      columns: [ 0, 1,2,3]
                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                      columns: [ 0, 1, 2,3]
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2,3]
                }
            },
             {
                extend: 'print',
                exportOptions: {
                    columns: [ 0, 1, 2,3]
                }
            },
           
        ]
    });
    example1234.$('tr').tooltip( {selector: '[data-toggle="tooltip"]'}); 
         
    var section_ids =   "#data_table ,"+$("#section_ids").val();
    var datatables = $(section_ids).dataTable({
        rowReorder: {selector: 'td:nth-child(2)'},
        responsive: true,
        dom: 'Bfrtip',
          buttons: [
            'pageLength',
            {
                extend: 'copyHtml5',
                exportOptions: {
                      columns: [0, 1, 2,3,4,5,6]
                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                      columns: [ 0, 1, 2,3,4,5,6]
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2,3,4,5,6]
                }
            },
             {
                extend: 'print',
                exportOptions: {
                    columns: [ 0, 1, 2,3,4,5,6]
                }
            },
           
        ]
        
} );
    
//This is for showing tooltip onwords 2nd page.
datatables.$('tr').tooltip( {selector: '[data-toggle="tooltip"]'});
    
  var section_ids_info =   "#data_table_stud_info ,"+$("#section_ids_info").val();
    var datatables = $(section_ids_info).dataTable({
        rowReorder: {selector: 'td:nth-child(2)'},
        responsive: true,
        dom: 'Bfrtip',
          buttons: [
            'pageLength',
            {
                extend: 'copyHtml5',
                exportOptions: {
                      columns: [0, 1, 2,3,4]
                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                      columns: [ 0, 1, 2,3,4]
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2,3,4]
                }
            },
             {
                extend: 'print',
                exportOptions: {
                    columns: [ 0, 1, 2,3,4]
                }
            },
           
        ]
} );
     
</script>

<!--this is for working datatable with tabs-->
<script>
$("a[data-toggle=\"tab\"]").on("shown.bs.tab", function (e) {
    $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
});
</script>

<!-- Date Picker Plugin JavaScript -->
<script src="<?php echo base_url();?>assets/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script>
    jQuery('.mydatepicker, #datepicker').datepicker();
    jQuery('#birthday').datepicker({
       endDate:'-2y',
       autoclose: true,
    });
    jQuery('#datepicker-autoclose').datepicker({
        autoclose: true,
        todayHighlight: true
    });

    var holi = '';
    <?php if(isset($hstring) && $hstring!='') { ?>
        holi = '<?php echo $hstring; ?>';
    <?php } ?>
    jQuery('#mydatepicker_holiday_disable').datepicker({ 
            startDate: new Date(),
            endDate: new Date(),
            todayHighlight: true,
            datesDisabled: [holi],
    });
</script>

<!-- moment Plugin JavaScript -->
<script src="<?php echo base_url();?>assets/bower_components/moment/moment.js"></script>

<!-- Date range Plugin JavaScript -->
<script src="<?php echo base_url();?>assets/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script>
    // Daterange picker
    $('.input-daterange-datepicker').daterangepicker({
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-danger',
        cancelClass: 'btn-inverse'
    });
    $('.input-daterange-timepicker').daterangepicker({
        timePicker: true,
        format: 'MM/DD/YYYY h:mm A',
        timePickerIncrement: 30,
        timePicker12Hour: true,
        timePickerSeconds: false,
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-danger',
        cancelClass: 'btn-inverse'
    });
</script>

<!--Datetimepicker together-->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script> -->
<script src="<?php echo base_url();?>assets/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript">
    $(function () {
        $('#datetimepicker1').datetimepicker();
    });
</script>

<!--For COlorpicker-->
<!-- Color Picker Plugin JavaScript -->
<script src="<?php echo base_url();?>assets/bower_components/jquery-asColorPicker-master/libs/jquery-asColor.js"></script>
<script src="<?php echo base_url();?>assets/bower_components/jquery-asColorPicker-master/dist/jquery-asColorPicker.min.js"></script>
<script>
    $(".colorpicker").asColorPicker();
</script>

<!--For Clock picker-->
<script src="<?php echo base_url();?>assets/bower_components/clockpicker/dist/jquery-clockpicker.min.js"></script>
<script>
$('.clockpicker').clockpicker({
    donetext: 'Done',
}).find('input').change(function() {
    console.log(this.value);
});
</script>


<!--For selectpicker-->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.3/js/bootstrap-select.min.js"></script> -->
<script src="<?php echo base_url('assets/bower_components/bootstrap-select/bootstrap-select.min.js');?>" type="text/javascript"></script>
<script>
$(function(){   
    $('.selectpicker').selectpicker({dropupAuto: false});
   
    $('#modal_ajax').on('shown.bs.modal', function () {
        $('.selectpicker1').selectpicker({dropupAuto: false});
        $('.selectpicker1').selectpicker("refresh");
    });
});
</script>

<!--multiselect dropdown-->
<script type="text/javascript" src="<?php echo base_url();?>assets/bower_components/multiselect/js/jquery.multi-select.js"></script>
<!--Toaster js-->
<script src="<?php echo base_url();?>assets/bower_components/toast-master/js/jquery.toast.js"></script>
<script src="<?php echo base_url();?>assets/js/toastr.js"></script>
<script type="text/javascript">
    //Alerts
    $(".myadmin-alert .closed").click(function(event) {
        $(this).parents(".myadmin-alert").fadeToggle(350);
        return false;
    });
    /* Click to close */
    $(".myadmin-alert-click").click(function(event) {
        $(this).fadeToggle(350);
        return false;
    });
</script>


<!-- Sweet-Alert  -->
<script src="<?php echo base_url();?>assets/bower_components/sweetalert/sweetalert.min.js"></script>
<script src="<?php echo base_url();?>assets/bower_components/sweetalert/jquery.sweet-alert.custom.js"></script>

<script>
//This is for "are you want ot sure delete"  alert message this shows confirm or cancel button as well
 $('#sa-params').click(function(){
        swal({   
            title: "Are you sure?",   
            text: "You will not be able to recover this imaginary file!",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "Yes, delete it!",   
            cancelButtonText: "No, cancel plx!",   
            closeOnConfirm: false,   
            closeOnCancel: false 
        }, function(isConfirm){   
            if (isConfirm) {     
                swal("Deleted!", "Your imaginary file has been deleted.", "success");   
            } else {     
                swal("Cancelled", "Your imaginary file is safe :)", "error");   
            } 
        });
    });
//This is for "add/ update / edit successfully" message alert (you have to use this id only), if you want to add then add below that with comments on which page you have to apply this
$('#sa-success').click(function(){
    swal("Add/update Successfully!", "Your Data is successfully add/upadate.", "success")
});
</script>



<!--this is create a problem with different resolution so i have to remove this one-->
<script>
    $('.tabs-style-flip').css("max-width", "none");
</script>

 <!-- Magnific popup JavaScript -->
<script src="<?php echo base_url();?>assets/bower_components/Magnific-Popup-master/dist/jquery.magnific-popup.min.js"></script>
<script src="<?php echo base_url();?>assets/bower_components/Magnific-Popup-master/dist/jquery.magnific-popup-init.js"></script>


<!--For student profile edit-->
<script>
function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#blah')
                    .attr('src', e.target.result)
                    .width(150)
                    .height(150);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<!--For switch button-->
<script src="<?php echo base_url();?>assets/bower_components/switchery/dist/switchery.min.js"></script>
<script>
 // Switchery
var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
$('.js-switch').each(function() {//data-color="#707cd2"
    objData = $(this).data();
    if(!objData.color){
        objData.color = "#707cd2";
    }
    new Switchery($(this)[0], objData);
});
</script>

<!--For summernote editor-->
<script src="<?php echo base_url();?>assets/bower_components/summernote/dist/summernote.min.js"></script>
<script>
    jQuery(document).ready(function() {
        $('.summernote').summernote({
            height: 350, // set editor height
            minHeight: null, // set minimum height of editor
            maxHeight: null, // set maximum height of editor
            focus: false // set focus to editable area after initializing summernote
        });
        $('.inline-editor').summernote({
            airMode: true
        });
    });
    window.edit = function() {
        $(".click2edit").summernote()
    }, window.save = function() {
        $(".click2edit").destroy()
    }
</script>
<!---->
<script>
$(document).ready(function() {
  $('.button-on').click(function() {
    $('.serch-click-overlay').show(300);
    $('.button-on').hide();
    $('.sidebar-head').hide();
  });

  $('.serach-cross').click(function() {
    $('.serch-click-overlay').fadeOut(300);
    $('.button-on').show();
    $('.sidebar-head').show();
  });


    $('#modal_ajax').on('shown.bs.modal', function () {
        $('.selectpicker1').selectpicker({dropupAuto: false});
        $('.selectpicker1').selectpicker("refresh");
    });
});
</script>

<!--Css Style switcher-->
<script>
$(document).ready(function() {    
$('#demo-wrapper li').on('click', function(){
     var path = $(this).data('path');
     $('#color-switcher').attr('href', path);
});
});
</script>

<!--
Typeahead Autocompleter header search-->
<script src="<?php echo base_url();?>assets/js/typeahead.bundle.js"></script>
<script src="<?php echo base_url();?>assets/js/handlebar.js"></script>


<!-- Calendar JavaScript -->

<script src='<?php echo base_url();?>assets/bower_components/calendar/dist/fullcalendar.min.js'></script>
<script src="<?php echo base_url();?>assets/bower_components/calendar/dist/jquery.fullcalendar.js"></script>
<script src="<?php echo base_url();?>assets/bower_components/calendar/dist/cal-init.js"></script>


<!--THIS THING ALWAYS IN THE LAST, IF YOU WANT TO PUT SOMETHING HERE THEN PLS KEEP IT ABOVE THIS ONE AND MAKE THE COMMENT ON THE TOP OF PARTICULAR LINK -->
<!-- Custom Theme JavaScript -->
<script src="<?php echo base_url();?>assets/js/custom.js"></script>

<!--Own Custom js file(this is not working now)-->
<script src="<?php echo base_url();?>assets/js/custom_js.js"></script>

<!--For Chat group-->
<script src="<?php echo base_url();?>assets/js/chat.js"></script>

<script src="<?php echo base_url();?>assets/bower_components/styleswitcher/jQuery.style.switcher.js"></script>

<!--Own new_Custom js file-->
<script src="<?php echo base_url();?>assets/js/new_custom_js.js"></script>

<script>
  window.intercomSettings = {
    app_id: "qujjof9e",
    name: '<?php echo sett('system_title')?>', 
  };
  
  Intercom('onShow', function() {
      $('#intercom-container .intercom-conversations-header-body').attr('style','background-image:<?php echo base_url();?>assets/images/logo_ag.png');
      $('#intercom-container .intercom-conversations-header-body').attr('style','background-repeat:no-repeat');
    });
</script>
<script>(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',intercomSettings);}else{var d=document;var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};w.Intercom=i;function l(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/qujjof9e';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);}if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})()</script>

