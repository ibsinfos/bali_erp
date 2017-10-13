<from class="form-horizontal form-material">

      <?php echo form_open(base_url() . 'index.php?school_admin/create_ceritificate/'.$param2, array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data')); ?>
    <input type="hidden" name="student_id" value="<?php echo $param2; ?>" >
    <div class="form-group">
        <div class="col-md-6 m-b-20"> 
            <label><?php echo get_phrase('ceritificate_title'); ?></label>
            <input type="text" class="form-control" placeholder="Enter certificate title" name="ceritificate_title" data-validate="required" required="required"  value=""></div>
        
        <div class="col-md-6 m-b-20">
            <label><?php echo get_phrase('sub_title'); ?></label>
            <input type="text" class="form-control" name="sub_title" placeholder="Enter certificate title " value=""></div>
        
        <div class="col-md-6 m-b-20">
            <label><?php echo get_phrase('main_content'); ?></label>
            <textarea type="text" class="form-control" name="main_cantent" placeholder="Enter main catent" data-validate="required"  required="required" value=""></textarea>
        </div>        
  
         <div class="col-md-12 m-b-20 text-right">
            <button class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('submit'); ?>
            </button></div>
    </div>
     <?php echo form_close(); ?>
</from> 
<script type="text/javascript">
    $(function () {
        $('#datepicker').datepicker();
    });
</script>