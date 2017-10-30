<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('view_all_blogs'); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>index.php?school_admin/dashboard">
                    <?php echo get_phrase('Dashboard'); ?>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url(); ?>index.php?blogs/view_my_blogs">
                    <?php echo get_phrase('view_my_blogs'); ?>
                </a>
            </li> 
            <li class="active">
                <?php echo get_phrase('view_all_blogs'); ?>
            </li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>

<div class="row">
    <div class="col-xs-12 visible-xs">
        <a href="<?php echo base_url(); ?>index.php?blogs/create_blog" class="btn btn-primary btn-circle btn-lg pull-right tooltip-danger" data-toggle="tooltip" data-placement="left" title="" data-original-title="Create New Blog"><i class="fa fa-plus"></i>
        </a>
    </div>
</div>
<div class="row">
    <div class="col-md-10"  data-step="5" data-intro="<?php echo get_phrase('List_the_available_category.');?>" data-position='top'>
        <div class="form-group col-md-6 p-0">
            <label for="blog_category">
                <?php echo get_phrase('select_category');?>
            </label>
            <input type="hidden" id="category_id" value="<?php echo $category_id ?>">
            <select class="selectpicker" data-style="form-control" data-live-search="true" name="search_id" onchange="get_blogs_by_category(this.value);" >
                <option value="0">
                    <?php echo get_phrase('select_category');?>
                </option>
                <option value="0">
                    <?php echo get_phrase('all');?>
                </option>
                <?php foreach($blog_categories as $cats){?>
                    <option value="<?php echo $cats['blog_category_id']?>" <?php if ($category_id == $cats['blog_category_id']){ ?> selected='selected' <?php }?>>
                        <?php echo $cats['blog_category_name'] ;?>
                    </option>
                    <?php } ?>
            </select>
        </div>
    </div>
    
<!--    <div class="col-md-2 hidden-xs">
        <a href="<?php echo base_url(); ?>index.php?blogs/create_blog" class="btn btn-primary btn-circle btn-lg pull-right tooltip-danger" data-toggle="tooltip" data-placement="left" title="" data-original-title="Create New Blog"><i class="fa fa-plus"></i>
        </a>
    </div>-->

</div>

<div class="row">
    <div class="col-md-12">
        <div class="white-box" data-step="6" data-intro="<?php echo get_phrase('List_the_blogs_available.');?>" data-position='top'>
                <table id="table" class="table display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th><div><?php echo get_phrase('s_no.');?></div></th>
                            <th><div><?php echo get_phrase('available_blogs_:');?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                      
                    </tbody>
                </table>
        </div>
    </div>
</div>    
<script>
    function get_blogs_by_category(category_id) {
////         $('#table').dataTable().reload();
//        $.ajax({
//            url: '<?php echo base_url();?>index.php?blogs/view_all_category_blogs/'+ category_id,
//            success: function(response) {
//                jQuery('#table').html(response);
//            }
//        });

        window.location = '<?php echo base_url();?>index.php?blogs/view_all_category_blogs/'+category_id;

    }
</script>

<script>
    var table;
    $(document).ready(function() {
      var category_id = $('#category_id').val(); 
      if(category_id==''){
          category_id = '1';
      }
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
                "url": "<?php echo base_url().'index.php?ajax_controller/view_all_blog_student_login/';?>",
                "type": "POST",
                data : { category_id:category_id}
            },

            //Set column definition initialisation properties.
            "columnDefs": [
                { "targets": [0], "orderable": false },                 
            ],

        });
        table.$('tr').tooltip( {selector: '[data-toggle="tooltip"]'});
        
    });
    
</script>