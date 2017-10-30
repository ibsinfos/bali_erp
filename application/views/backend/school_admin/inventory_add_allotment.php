<?php extract($product); ?>
<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('add_inventory_allotment'); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/Dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/inventory_category"><?php echo get_phrase('inventory'); ?></a></li>
            <li class="active"><?php echo get_phrase('add_inventory_allotment'); ?></li>
        </ol>  
    </div>
    <!-- /.breadcrumb -->
</div>
<?php
     $msg=$this->session->flashdata('flash_message_error');
     if ($msg) { ?>        
        <div class="alert alert-danger">
            <?php echo $msg; ?>
        </div>
    <?php } ?>
<div class="col-md-12 white-box">
    <form  action="<?php echo base_url(); ?>index.php?school_admin/inventory_allotment/create/<?php echo $product_id; ?>" method="post">

        <div class="col-sm-4 form-group" data-step="5" data-intro="<?php echo get_phrase('Here  you select the class for which you want to allot inventory.');?>" data-position='right'>
            <label class="control-label"><?php echo get_phrase('class'); ?></label>                
            <select name="class" id="class" class="selectpicker" data-style="form-control" data-live-search="true" required="required" onchange="select_section(this.value)" data-validate="required" data-message-required ="Please select a class" >

                <option value=""><?php echo get_phrase('select_class'); ?></option>
                <?php
                foreach ($classes as $row):
                    ?>
                    <option value="<?php echo $row['class_id']; ?>" ><?php echo get_phrase('class'); ?>&nbsp;<?php echo $row['name']; ?></option>

<?php endforeach; ?>
            </select>
        </div> 

        <div class="col-sm-4 form-group" data-step="6" data-intro="<?php echo get_phrase('Here  you select the section for which you want to allot inventory.');?>" data-position='left'>
            <label class="control-label"><?php echo get_phrase('section'); ?></label>                
            <select name="section" class="selectpicker" data-style="form-control" data-live-search="true" id="section" required="required" data-validate="required" onChange="select_teacher()" data-message-required ="Please select a section">
                <option value=""><?php echo get_phrase('select_class_first'); ?></option>
            </select> 
        </div> 


        <div class="col-sm-4 form-group" data-step="7" data-intro="<?php echo get_phrase('Here  you select the teacher for which you want to allot inventory.');?>" data-position='left'>
            <label class="control-label"><?php echo get_phrase('teacher'); ?></label>                
            <select name="teacher" class="selectpicker" data-style="form-control" data-live-search="true" id="teacher" required="required" data-validate="required" data-message-required ="Please select a teacher">
                <option value=""><?php echo get_phrase('select_section_first'); ?></option>
            </select>
        </div>
        <div class="text-center col-xs-12 p-t-20">
            <input type="submit" class="fcbtn btn btn-danger btn-outline btn-1d input_allot" value="Allot Product"/>
            <a href="<?php echo base_url(); ?>index.php?school_admin/manage_product/">
               </a>
        </div>  

    </form>
</div>
<script type="text/javascript">
    
    function select_section(class_id) {

        $.ajax({
            url: '<?php echo base_url(); ?>index.php?school_admin/get_class_section/' + class_id,
            success: function (response)
            {

                jQuery('#section').html(response).selectpicker('refresh');
            }
        });
    }

    function select_teacher() {
        var class_id = $("#class option:selected").val();
        var section_id = $("#section option:selected").val();

        $.ajax({
            url: '<?php echo base_url(); ?>index.php?ajax_controller/get_teacher_ajax/' + class_id + '/' + section_id,
            success: function (response)
            {
                jQuery('#teacher').html(response).selectpicker('refresh');
            }
        });
    }

</script>
