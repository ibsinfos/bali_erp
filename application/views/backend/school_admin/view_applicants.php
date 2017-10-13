<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?></h4>
    </div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
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

<?php echo form_open(base_url() . 'index.php?school_admin/submit_applicants', array('class' => 'form-group validate', 'id' => 'studentEnquiryForm', 'onsubmit' => "return valideSelectedCehckBox();")); ?> 
    
<div class="row m-0">
    <div class="col-sm-12 white-box">

        <!-- <div class="row p-b-20 p-r-30">   
	<button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d pull-right" onclick="showAjaxModal('<?php //echo base_url();?>index.php?modal/popup/modal_fees_seetings');" data-step="5" data-intro="On click of Fees Settings,Fees setting page will open" data-position='left'><?php //echo get_phrase("fees_settings");?></button>
</div> -->

    <table id="table" class="table_edjust table-responsive display nowrap" cellspacing="0" width="100%"  data-step="5" data-intro="<?php echo get_phrase('Lists the applicants who submitted the application to school.');?>" data-position='top'>
        <thead>
            <tr>
                <th><div><?php echo get_phrase('no'); ?></div></th>   
                <th><div><?php echo get_phrase('student_name'); ?></div></th>                            
                <th><div><?php echo get_phrase('parent_name'); ?></div></th>
                <th><div><?php echo get_phrase('class_applied_for'); ?></div></th>
                <th><div><?php echo get_phrase('date_of_birth'); ?></div></th>
                <th><div><?php echo get_phrase('email_id'); ?></div></th>
                <th><div><?php echo get_phrase('phone'); ?></div></th>
                <!-- <th><div><?php //echo get_phrase('fees_paid'); ?></div></th> -->
                <th data-step="6" data-position="left" data-intro="<?php echo get_phrase('Select the checkbox and enter the Form No. to generate admission form of the student.');?>"><div><?php echo get_phrase('form_status'); ?></div></th>
                <th><div><?php echo get_phrase('form_no'); ?></div></th>
                <th><div><?php echo get_phrase('form_id'); ?></div></th>
                <th><div><?php echo get_phrase('counselling'); ?></div></th>
            </tr>
        </thead>
        <tbody>
        </tbody>            
    </table>
    
   <div class="row m-t-20">
     <div class="text-right col-xs-12">
        <button type="submit"  data-step="7" data-position="left" data-intro="<?php echo get_phrase('Click on the Generate Admission button to generate the Admission Form.');?>" class="fcbtn btn btn-danger btn-outline btn-1d" id="generate_admission" name = "generate_admission" value="generate_admission"><?php echo get_phrase('generate_admisson_form'); ?></button>
    </div>
    
</div> 

</div>
</div>

<?php echo form_close(); ?>
<script type="text/javascript"> 
    
    function valideSelectedCehckBox() {
        var totalSelected = 0;
        $("#studentEnquiryForm input:checkbox:checked").each(function () {
            totalSelected++;
        });
        if (totalSelected == 0) {
            alert("Select any student to Generate Adminission Form.");
            return false;
        } else {
            return true;
        }
    }

    function handleClick(cb) {
        var cb_id = $(cb).attr("id");
        var splt_id = cb_id.split('_');

        if (cb.checked) {
            $('#table tbody tr:nth-child('+splt_id[1]+') td:nth-child('+splt_id[1]+')').click();
            //$('#table tbody span.dtr-data #Form_no' + cb.value).prop('readonly', false);
            //$('#table tbody span.dtr-data #Form_no' + cb.value).prop('required', true);

            $('#Form_no' + cb.value).prop('readOnly', false);
            //$('#Form_no' + cb.value).prop('required', true);
            //$('#Form_no'+cb.value).prop('name', "form_no[]");
        } else { 
            $('#table tbody tr:nth-child('+splt_id[1]+') td:nth-child('+splt_id[1]+')').click();
            //$('#table tbody span.dtr-data #Form_no' + cb.value).prop('readonly', true);
            //$('#table tbody span.dtr-data #Form_no' + cb.value).prop('required', false);

            $('#Form_no' + cb.value).prop('readOnly', true);
            //$('#Form_no' + cb.value).prop('required', false);
            //$('#Form_no'+cb.value).prop('name', "");
        }
    }
    
    var table;
    $(document).ready(function() {
        //var SearchName = $('#PublicSearch').val();

        //datatables
        table = $('#table').DataTable({ 
            "dom": 'Bfrtip',
            "responsive": true,
            "buttons": [
                "pageLength",
                'copy', 'excel', 'pdf', 'print'
            ],

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
         
            "ajax": {
                "url": "<?php echo base_url().'index.php?ajax_controller/ajax_datatable_student_enquired_view/';?>",
                "type": "POST",
                  "dataSrc": function (data) {
                    setTimeout(function () {
                        $('[data-toggle="tooltip"]').tooltip({});
                    }, 0);
                    return data.data;
                }
            },

            //Set column definition initialisation properties.
            "columnDefs": [
                { "targets": [0,8,9,10], "orderable": false },                 
            ],

        });
        table.$('tr').tooltip( {selector: '[data-toggle="tooltip"]'});
        

    });
</script>
