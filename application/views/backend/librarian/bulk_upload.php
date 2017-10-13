<table class="table table-bordered datatable" id="table_export">
    <thead>
        <tr>
            <th width="80"><div><?php echo get_phrase('id');?></div></th>
            <th><div><?php echo get_phrase('add');?></div></th>
            <th><div><?php echo get_phrase('blank_excel_sheet');?></div></th>
            <th><div><?php echo get_phrase('upload');?></div></th>
        </tr>
    </thead>
    <tbody>
        <?php $count=1 ;?> 
        <!--For Category & Subcategory uploads-->
        <tr>
        <?php echo form_open(base_url() . 'index.php?librarian/category/import_excel/' , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
            <td><?php echo $count++; ?></td>
            <td><?php echo get_phrase('Categories_&_subcatgeories');?></div></td>
            <td><div class="btn-group">
                 <a href="<?php echo base_url();?>uploads/Category_Upload_Template.xlsx" target="_blank" 
                      class="btn btn-info btn-sm"><i class="entypo-download"></i> Download blank excel file</a>
                </div></td>                
            <td>
                <div class="form-group">
                    <input type="file" name="userfile" class="form-control" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>">
                    <button type="submit" class="btn btn-info"><?php echo get_phrase('upload_and_import');?></button>
                </div>
            </td>
        <?php echo form_close();?>
        </tr>
      
        
        
        <!--For Book uploads-->
        <tr>
        <?php echo form_open(base_url() . 'index.php?librarian/books/import_excel/' , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
            <td><?php echo $count++; ?></td>
            <td><?php echo get_phrase('books_details');?></div></td>
            <td><div class="btn-group">
                 <a href="<?php echo base_url();?>uploads/library_data_format.xlsx" target="_blank" 
                      class="btn btn-info btn-sm"><i class="entypo-download"></i> Download blank excel file</a>
                </div></td>
                
            <td>
                <div class="form-group">
                    <input type="file" name="userfile" class="form-control" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>">
                    <button type="submit" class="btn btn-info"><?php echo get_phrase('upload_and_import');?></button>
                </div>
            </td>
        <?php echo form_close();?>
        </tr>    
             
    </tbody>
</table>



<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->                      
<script type="text/javascript">

jQuery(document).ready(function($)
{
 var datatable = $("#table_export").dataTable({
         "sPaginationType": "bootstrap",
         "sDom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'T>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>",
         "oTableTools": {
                 "aButtons": [

                         {
                                 "sExtends": "xls",
                                 "mColumns": [1,2]
                         },
                         {
                                 "sExtends": "pdf",
                                 "mColumns": [1,2]
                         },
                         {
                                 "sExtends": "print",
                                 "fnSetText"	   : "Press 'esc' to return",
                                 "fnClick": function (nButton, oConfig) { 
                                         datatable.fnSetColumnVis(0, false);
                                         datatable.fnSetColumnVis(3, false);

                                         this.fnPrint( true, oConfig );

                                         window.print();

                                         $(window).keyup(function(e) {
                                                   if (e.which == 27) {
                                                           datatable.fnSetColumnVis(0, true);
                                                           datatable.fnSetColumnVis(3, true);
                                                   }
                                         });
                                 },

                         },
                 ]
         },

 });

 $(".dataTables_wrapper select").select2({
         minimumResultsForSearch: -1
 });
});

</script>



