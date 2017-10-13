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
    <!-- /.breadcrumb -->
</div>
<div class="row m-b-20">
    <div class="col-md-12">
        <?php if ($categories_id > 0) { ?>                                
            <a href="<?php echo base_url(); ?>index.php?school_admin/add_inventory_product/<?php echo $categories_id; ?>" class="btn btn-primary btn-circle btn-lg pull-right tooltip-danger" data-toggle="tooltip" data-placement="left" title="" data-original-title="Add New Product">
                <i class="fa fa-plus"></i>
            </a>
        <?php } else { ?>
            <a href="<?php echo base_url(); ?>index.php?school_admin/add_inventory_product/"  data-step="5" data-intro="<?php echo get_phrase('From here you can add a new inventory product.');?>" data-position="left"  class="btn btn-primary btn-circle btn-lg pull-right tooltip-danger" data-toggle="tooltip" data-placement="left" title="" data-original-title="Add New Product">
                <i class="fa fa-plus"></i>
            </a>
        <?php } ?>
    </div>
</div>
<div class="col-md-12 white-box">        
    <table id="table" class="table display" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th><div><?php echo get_phrase('no'); ?></div></th>
                    <th><div><?php echo get_phrase('product_name'); ?></div></th>
                    <th><div><?php echo get_phrase('product_id'); ?></div></th>
                    <th><div><?php echo get_phrase('rate'); ?></div></th>
                    <th><div><?php echo get_phrase('quantity'); ?></div></th>
                    <th><div><?php echo get_phrase('category'); ?></div></th>
                    <th><div><?php echo get_phrase('seller'); ?></div></th>
                    <th><div><?php echo get_phrase('status'); ?></th>
                    <th><div><?php echo get_phrase('Option'); ?></div></th>
                    <th><div><?php echo get_phrase('Action'); ?></div></th>
                </tr>
            </thead>

            <tbody>
            </tbody>
    </table>

    <!-- /table -->
</div>

<div id="for_barcode_display" style="display: none;">
</div>

<script>
    var table;

    $(document).ready(function () {

        var SearchName = $('#PublicSearch').val();

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
                "url": "<?php echo base_url() . 'index.php?ajax_controller/manage_product_admin_login/' . $categories_id; ?>",
                "type": "POST",
                "dataSrc": function (data) {
                    setTimeout(function () {
                        $('[data-toggle="tooltip"]').tooltip();
                    }, 0);
                    return data.data;
                }
            },

//Set column definition initialisation properties.
            "columnDefs": [
                {"targets": [0, 8, 9], "orderable": false},
            ],

        });
   
        if (SearchName != '') {
            table.search(SearchName).draw();
        }

    });

    function docw() { 
        var doct = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">";
    }

    // print section for search generated barcode
    function PrintElem(elem) 
    { 
        Popup($(elem).html());
    } 

    function Popup(data) 
    { 
       var mywindow = window.open('', 'print_details', 'height=562,width=795'); 
        mywindow.document.write('<html><head>'); 
        mywindow.document.write('</head><body >'); 
        mywindow.document.write(data); 
        mywindow.document.write('</body></html>'); 
        mywindow.document.close(); 
        mywindow.print(); 
        return true;
    }

    function generate_barcode(id=''){
        if(id!=''){
            //alert(id);
            var url = '<?php echo base_url();?>index.php?ajax_controller/generate_barcode';
            $.ajax({
                type:'POST',
                url:url,
                data:{ProductId:id},
                success:function(response){
                    $('#for_barcode_display').html(response);                
                    //$('#print_barcode').show();
                    docw();
                    setTimeout(function(){PrintElem('#for_barcode_display')}, 2000);
                    return true;
                    //location.reload();                    
                }
            });
        }
    }
</script>