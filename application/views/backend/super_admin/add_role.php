<div class="row bg-title"> 
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?super_admin/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li><a href="<?php echo base_url(); ?>index.php?super_admin/role"><?php echo get_phrase('manage_role'); ?></a></li>
            <li class="active"> <span><?php echo get_phrase($page_title); ?></span></li>
            
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>            

<div class="col-md-12 white-box" data-step="5" data-intro="To fill the details, you can add a new subject from here." data-position='top'>
    <?php echo form_open(base_url() . 'index.php?super_admin/role/create', array('class' => ' form-groups-bordered validate', 'target' => '_top')); ?>
                                <div class="row">
                                    <div class="col-xs-12 col-md-6 form-group">
                                        <label for="field-2"><?php echo get_phrase('school'); ?><span class="error mandatory"> *</span></label>
                                        <select name="school_id" class="selectpicker" data-style="form-control" data-live-search="true" required="required" >
                                            <option value=""><?php echo get_phrase('select_school'); ?></option>
<?php foreach ($school as $row): ?>
                                            <option value="<?php echo $row['school_id']; ?>"><?php echo ucwords($row['name']); ?></option><?php endforeach; ?>
                                        </select>
                                    </div>


                                    <div class="col-xs-12 col-md-6 form-group">
                                        <label for="field-1"><?php echo get_phrase('role_name'); ?><span class="error mandatory"> *</span></label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-book"></i></div>
                                            <input type="text" class="form-control" data-validate="required" required="required" id="exampleInputuname" placeholder="Role" name="name" data-message-required="<?php echo get_phrase('please_enter_role_name'); ?>" value="<?php echo set_value('name'); ?>">
                                            <span class="mandantory"> <?php echo form_error('name'); ?></span> 
                                        </div>                                        
                                    </div>                                    
                                </div>
                            
                                <!--           
                                <!----CREATION FORM ENDS-->

                                <div class="row">          
                                    <div class="col-xs-12 col-md-7 form-group col-md-offset-3 text-right">
                                        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('add'); ?></button>                                        
                                    </div>                                    
                                </div>
    <?php echo form_close(); ?> 
</div>

<script type="text/javascript">

   
    jQuery(document).ready(function ($)
    {
        
        var path=window.location.href;
        var splitUrl = path.split('/');
  var class_id=splitUrl[splitUrl.length-1];
  
  if(class_id!=="")
  {
   $("#class_id_holder").val(class_id);
   get_class_section_subject(class_id);
  }
       
        $(".dataTables_wrapper select").select2({
            minimumResultsForSearch: -1
        });

        $(".list-class-toggle").click(function() {
            $(".toggle-list-add").show();
        });
        $(".add-class-toggle").click(function() {
            $(".toggle-list-add").hide();
        });        
        
        
        
    });

    function get_class_section_subject(class_id) {
        $.ajax({
            url: '<?php echo base_url();?>index.php?ajax_controller/get_sections_by_class/' + class_id ,
            success: function(response)
            {
                jQuery('#section__holder').html(response);
            }
        });
    }
 function class_change(path)
    {
  
        window.location = path;
       

    }
</script>