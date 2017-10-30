<?php if($user_type == "t"){
    $method = "teacher_certificates";
}else{
    $method = "student_certificates"; 
}
//pre($edit_data); 
?>

<from class="form-horizontal form-material">
      <?php echo form_open(base_url() . 'index.php?school_admin/'.$method.'/edit/'.$edit_data[0]->certificate_id, array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data')); ?>
    <div class="form-group">
        <div class="col-md-6 m-b-20"> 
            <label><?php echo get_phrase('ceritificate_title'); ?><span class="error mandatory"> *</span></label>
            <input type="text" class="form-control" placeholder="Enter certificate title" name="ceritificate_title" data-validate="required" required="required"  value="<?php echo $edit_data[0]->certificate_title; ?>"></div>        
        <div class="col-md-6 m-b-20">
            <label><?php echo get_phrase('sub_title'); ?><span class="error mandatory"> *</span></label>
            <input type="text" class="form-control" name="sub_title" placeholder="Enter certificate title " value="<?php echo $edit_data[0]->sub_title; ?>" required="required"></div>
        
        <div class="col-md-6 m-b-20">
            <label><?php echo get_phrase('main_content'); ?></label>
            <input type="text" class="form-control" name="main_cantent" placeholder="Enter main catent" data-validate="required"  value="<?php echo $edit_data[0]->main_cantent; ?>">
        </div>
        <div class="col-md-6 m-b-20">
            <label><?php echo get_phrase('page_size'); ?></label>
            <select name="page_size" class="selectpicker1" data-style="form-control" data-live-search="true">
            <option value=""> Select Page Size  </option>
            <?php foreach($size_list as $row): ?>
            <option value="<?php echo $row['size']; ?>" <?php if($edit_data[0]->page_size == $row['size']){ echo "selected";} ?>><?php echo $row['size']; ?></option>
            <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-6 m-b-20">
            <label><?php echo get_phrase('page_orientation'); ?></label>
            <select name="page_orientation" class="selectpicker1" data-style="form-control" data-live-search="true"> 
                <option value=""> Select Page Orientation  </option>
                <option value="Landscape" <?php if($edit_data[0]->page_orientation == "Landscape"){ echo "selected = ''";} ?><?php echo $row['size']; ?>> Landscape </option>
                <option value="Portrait" <?php if($edit_data[0]->page_orientation == "Portrait"){ echo "selected = ''";} ?><?php echo $row['size']; ?>> Portrait </option>
            </select>
        </div>
        <!--<input type="hidden" name="student_id" id="student_id" value="<?php // echo $edit_data[0]->student_id; ?>">-->
         <div class="col-md-12 m-b-20 text-right">
            <button class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('edit_certificate'); ?>
            </button>
         </div>
    </div>
     <?php echo form_close(); ?>
</from> 
<script type="text/javascript">
    $(function () {
        $('#datepicker').datepicker();
    });
 
    function onclasschange(class_id)
{
    jQuery('#section').html('<option value="">Select Section</option>');
    $.ajax({
            url: '<?php echo base_url();?>index.php?school_admin/get_section_by_class/' + class_id.value,
            success: function (response)
            {
                jQuery('#section').append(response).selectpicker1('refresh');                
                //$('#section').trigger("chosen:updated");
            }
        });           
}
function onsectionchange(section_id)
    {
        var class_id = $('#class_holder').val();
//        jQuery('#student_holder').html('<option value="">Select Student</option>');
        $.ajax({
            url: '<?php echo base_url(); ?>/index.php?school_admin/get_student/' + section_id + '/' + class_id,
            success: function (response)
            { 
                jQuery('#student_holder').append(response).selectpicker('refresh');
            }
        });
//        $('#student_holder').trigger("chosen:updated");
    }
    
    function oncertificate_typechange(certificate_type)
    {
        jQuery('#template_holder').html('<option value="">Select Template</option>');
        $.ajax({
            url: '<?php echo base_url(); ?>/index.php?school_admin/get_template_type/' + certificate_type,
            success: function (response)
            {  
                jQuery('#template_holder').append(response).selectpicker('refresh');
            }
        });
//        $('#student_holder').trigger("chosen:updated");
    }
    
    
    function student_val(student_id){
   $('#student_id').val(student_id);
    }

function get_authorities(){
        var authorities_id = []; 
        $('#authorities :selected').each(function(i, selected){ 
            authorities_id[i] = $(selected).val(); 
        }); 
        $('#show_aothorities').val(authorities_id);           
    }
</script>