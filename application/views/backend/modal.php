
<script type="text/javascript">
    function showAjaxModal(url) {
        // SHOWING AJAX PRELOADER IMAGE
        jQuery('#modal_ajax .modal-body').html('<div style="text-align:center;margin-top:200px;"><img src="assets/images/preloader.gif" /></div>');

        // LOADING THE AJAX MODAL
        jQuery('#modal_ajax').modal('show', {backdrop: 'true'});

        // SHOW AJAX RESPONSE ON REQUEST SUCCESS
        $.ajax({
            url: url,
            success: function (response)
            {
                jQuery('#modal_ajax .modal-body').html(response);
                $('.selectpicker').selectpicker('refresh');
                $('.selectpicker1').selectpicker('refresh');
                var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
                $('.js-switch').each(function() {//data-color="#707cd2"
                    objData = $(this).data();
                    if(!objData.color){
                        objData.color = "#707cd2";
                    }
                   
                    if(objData.className==undefined){
                        new Switchery($(this)[0], objData);
                    }
                });
            }
        });
    }

    function showDocumentPreview(url) {
        // SHOWING AJAX PRELOADER IMAGE
        jQuery('#document_preview_ajax .modal-body').html('<div style="text-align:center;margin-top:200px;"><img src="assets/images/preloader.gif" /></div>');

        // LOADING THE AJAX MODAL
        jQuery('#document_preview_ajax').modal('show', {backdrop: 'true'});

        // SHOW AJAX RESPONSE ON REQUEST SUCCESS
        $.ajax({
            url: url,
            success: function (response)
            {
                jQuery('#document_preview_ajax .modal-body').html(response);
                $('.selectpicker').selectpicker('refresh');
                var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
                $('.js-switch').each(function() {//data-color="#707cd2"
                    objData = $(this).data();
                    if(!objData.color){
                        objData.color = "#707cd2";
                    }
                    //console.log($(this).data());
                    new Switchery($(this)[0], objData);
                });
            }
        });
    }
</script>

<!-- For Document preview PopUP starts -->
<div id="document_preview_ajax" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="" id="document_preview_ajax">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel"><?php echo $system_name; ?></h4>
            </div>
            <div class="modal-body">
                
                
            </div>    
        </div>
    </div>
</div>
<!-- For Document preview PopUP ends -->


<!--new Simple Modal-->
<div id="modal_ajax" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel"><?php echo get_phrase($page_title); ?></h4>
            </div>
            <div class="modal-body">
                
                
            </div>    
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<script type="text/javascript">
    function confirm_modal(delete_url) {
	//alert(delete_url);die;
        jQuery('#modal-4').modal('show', {backdrop: 'static'});
        document.getElementById('delete_link').setAttribute('href', delete_url);
        //jQuery('#modal-4').modal('hide');
    }
    function custom_confirm_modal(custom_url,confirm_msg) {
        jQuery('#modal-service').modal('show', {backdrop: 'static'});
        //$('#send_service_link').prop('href', custom_url);
        //document.getElementById('').setAttribute();
        $(".modal-footer a[href='#']").attr('href',custom_url);
        $('#custom_confim_message').html(confirm_msg);
    }
    function confirm_student_delete(delete_url,id){
        
        jQuery('#modal-student').modal('show', {backdrop: 'static'});
        jQuery('#delete_link_hidden').val(delete_url);
        jQuery('#tr_to_delete').val(id);
    }
    function vacate_confirm_modal(vacate_url,confirm_msg) {
        jQuery('#modal-vacate').modal('show', {backdrop: 'static'});
        //$('#send_service_link').prop('href', custom_url);
        //document.getElementById('').setAttribute();
        $(".modal-footer a[href='#']").attr('href',vacate_url);
        $('#vacate_confim_message').html(confirm_msg);
    }
    function ConfirmStudentToggleEnable(ToggleEnableUrl){
        var url = ToggleEnableUrl;
        var SpltUrl = url.split('ToggleEnable/');
        var status = SpltUrl[1].split('/');
        if(status[1]==1){
            $('#TogEnBtn').empty();
            $('#TogEnBtn').html('Disable');
        }else{
            $('#TogEnBtn').empty();
            $('#TogEnBtn').html('Enable');
        }
        jQuery('#ModalToggleEnable').modal('show', {backdrop: 'static'});
        jQuery('#action_link').val(ToggleEnableUrl);
    }
        function ConfirmParentToggleEnable(ToggleEnableUrl){
        var url = ToggleEnableUrl;
        var SpltUrl = url.split('enable_disable/');
        var status = SpltUrl[1].split('/');
        if(status[1]==1){
            $('#TogEnBtn1').empty();
            $('#TogEnBtn1').html('Disable');
        }else{
            $('#TogEnBtn1').empty();
            $('#TogEnBtn1').html('Enable');
        }
       jQuery('#modal-parent-disable').modal('show', {backdrop: 'static'});
       jQuery('#action').val(ToggleEnableUrl);
    }
    
    function confirm_print(print_url,confirm_msg){
//          document.getElementById("print_button").disabled = false;
         jQuery('#modal-vacate').modal('show', {backdrop: 'static'});

        $(".modal-footer a[href='#']").attr('href',print_url);
        $('#vacate_confim_message').html(confirm_msg);
    }
    function Confirmdynamic_fieldToggleEnable(ToggleEnableUrl){
        var url = ToggleEnableUrl;
        var SpltUrl = url.split('ToggleEnable/');
        var status = SpltUrl[1].split('/');
        if(status[1]=="Disable"){
            $('#TogEnBtn2').empty();
            $('#TogEnBtn2').html('Disable');
        }else{
            $('#TogEnBtn2').empty();
            $('#TogEnBtn2').html('Enable');
        }
        jQuery('#ModalDynamicFieldToggleEnable').modal('show', {backdrop: 'static'});
        jQuery('#action_link_dynamicField').val(ToggleEnableUrl);
    }

</script>


<!-- (Delete Modal)-->
<div class="modal fade" id="modal-4">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="text-align:center;">Do you want to remove this information ?</h4>
            </div>

            <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
                <a href="#" class="btn btn-danger" id="delete_link"><?php echo get_phrase('delete'); ?></a>
                <button type="button" class="btn btn-info" data-dismiss="modal"><?php echo get_phrase('cancel'); ?></button>
            </div>
        </div>
    </div>
</div>

<!-- (Normal Modal)-->
<div class="modal fade" id="modal-service">
    <div class="modal-dialog">
        <div class="modal-content" style="margin-top:100px;">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="text-align:center;" id="custom_confim_message"></h4>
            </div>

            <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
                <a href="#" class="btn btn-danger" id="send_service_link">Yes</a>
                <button type="button" class="btn btn-info" data-dismiss="modal"><?php echo get_phrase('cancel'); ?></button>
            </div>
        </div>
    </div>
</div>
<!-- (Normal vacate Modal)-->
<div class="modal fade" id="modal-vacate">
    <div class="modal-dialog">
        <div class="modal-content" style="margin-top:100px;">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="text-align:center;" id="vacate_confim_message"></h4>
            </div>

            <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
                <a href="#" class="btn btn-danger" id="send_vacate_link">Yes</a>
                <button type="button" class="btn btn-info" data-dismiss="modal"><?php echo get_phrase('cancel'); ?></button>
            </div>
        </div>
    </div>
</div>
<!-- (Normal Modal)-->
<div class="modal fade" id="modal-student">
      <div class="modal-dialog">
        <div class="modal-content" style="margin-top:100px;">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="text-align:center;">Are you sure to delete this information ?</h4>
            </div>

            <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
                <a href="#" class="btn btn-danger" onclick="delete_record()"><?php echo get_phrase('delete'); ?></a>
                <input type="hidden" id="delete_link_hidden" >
                <input type="hidden" id="tr_to_delete" >
                
                <button type="button" class="btn btn-info" data-dismiss="modal"><?php echo get_phrase('cancel'); ?></button>
            </div>
        </div>
    </div>
</div>
<!-- (ToggleEnable Modal)-->
<div class="modal fade" id="ModalToggleEnable">
      <div class="modal-dialog">
        <div class="modal-content" style="margin-top:100px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="text-align:center;">Are you sure to execute this action ?</h4>
            </div>

            <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
                <a href="#" class="btn btn-danger" onclick="ToggleEnableRecord()" id="TogEnBtn"><?php echo get_phrase('disable'); ?></a>
                <input type="hidden" id="action_link" >                
                <button type="button" class="btn btn-info" data-dismiss="modal"><?php echo get_phrase('cancel'); ?></button>
            </div>
        </div>
    </div>
</div>
<!-- (ToggleEnable parent)-->
<div class="modal fade" id="modal-parent-disable">
      <div class="modal-dialog">
        <div class="modal-content" style="margin-top:100px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="text-align:center;">Are you sure to execute this action ?</h4>
            </div>

            <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
                <a href="javascript: void(0);" class="btn btn-danger" onclick="ToggleEnableRecordparent()" id="TogEnBtn1"><?php echo get_phrase('disable'); ?></a>
                <input type="hidden" id="action" >                
                <button type="button" class="btn btn-info" data-dismiss="modal"><?php echo get_phrase('cancel'); ?></button>
            </div>
        </div>
    </div>
</div>
<!-- (ToggleEnable Dynamic Field)-->
<div class="modal fade" id="ModalDynamicFieldToggleEnable">
      <div class="modal-dialog">
        <div class="modal-content" style="margin-top:100px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="text-align:center;">Are you sure to execute this action ?</h4>
            </div>

            <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
                <a href="javascript: void(0);" class="btn btn-danger" onclick="ToggleEnableRecordDynamicField()" id="TogEnBtn2"><?php echo get_phrase('disable'); ?></a>
                <input type="hidden" id="action_link_dynamicField" >                
                <button type="button" class="btn btn-info" data-dismiss="modal"><?php echo get_phrase('cancel'); ?></button>
            </div>
        </div>
    </div>
</div>

<!-- (Delete Modal)-->
<div class="modal fade" id="ConfirmAction">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="text-align:center;">Are you sure to execute this action ?</h4>
            </div>

            <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
                <a href="#" class="btn btn-danger" id="confirm_action_link"><?php echo get_phrase('yes'); ?></a>
                <button type="button" class="btn btn-info" data-dismiss="modal"><?php echo get_phrase('no'); ?></button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function delete_record(){
        var url =$("#delete_link_hidden").val();
        var id =$("#tr_to_delete").val();
        $.post(url, function (response) {
           
            if (response == 1) {
             toastr.success("Deleted Successfully");
              $(".tr_"+id).hide();
              
              $('#modal-student').modal('hide');
           }
        });
    }
    
    function ToggleEnableRecord(){
        var url =$("#action_link").val();
        $.post(url, function (response) {
            if(response){
                $('#ModalToggleEnable').modal('hide');
                //toastr.success(response+" Successfully");
                location.reload(true);                
            }
        });
    }
      function ToggleEnableRecordparent(){
        var url =$("#action").val();
        $.post(url, function (response) {
//            alert(url+"here");
            if(response){
                $('#modal-parent-disable').modal('hide');
                //toastr.success(response+" Successfully");
                location.reload(true);                
            }
        });
    }
    function ToggleEnableRecordDynamicField(){
        var url =$("#action_link_dynamicField").val();
         $.post(url, function (response) {
//             alert(url);
            if(response){
                $('#ModalDynamicFieldToggleEnable').modal('hide');
                //toastr.success(response+" Successfully");
                location.reload(true);                
            }
        });
    }

    function ConfirmAction(url){
        jQuery('#ConfirmAction').modal('show', {backdrop: 'static'});
        document.getElementById('confirm_action_link').setAttribute('href', url);
    }

    $('#confirm_action_link').click(function(){
        $('#ConfirmAction').modal('hide'); 
    });
    
    
</script>
