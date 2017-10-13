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

<div class="row">
<div class="col-md-12 white-box">
    
<div class="row">
      
   <a  href="<?php echo base_url(); ?>index.php?school_admin/payment_config"  class="btn btn-primary btn-circle btn-lg pull-right tooltip-danger par-add-btn" data-toggle="tooltip" data-placement="left" title="" data-original-title="Add New Payment Details."> 
       <i class="fa fa-plus"></i>
   </a>        

</div>


<div class="row"> 
<table  class="table table-bordered datatable" id="example23">
    <thead>
        <tr>
            <!--th width="80"><div><?php //echo get_phrase('photo'); ?></div></th-->
            <th width="80"><div><?php echo get_phrase('#'); ?></div></th>
            <th><div><?php echo get_phrase('gateway_name'); ?></div></th>
            <th><div><?php echo get_phrase('type'); ?></div></th>
            <th><div><?php echo get_phrase('endpoints'); ?></div></th>
            <th><div><?php echo get_phrase('username'); ?></div></th>            
            <th><div><?php echo get_phrase('hostname'); ?></div></th>
            <th><div><?php echo get_phrase('signature'); ?></div></th>
            <th><div><?php echo get_phrase('options'); ?></div></th>
        </tr>
    </thead>
    <tbody>
        <?php $count = 0; foreach ($get_details as $row): 
            $count++;
            ?>
            <tr>
                <!--td><img src="<?php //echo $this->crud_model->get_image_url('teacher', $row['teacher_id']); ?>" class="img-circle" width="30" /></td-->
                <td><?php echo $count; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php if ($row['type']== 0){ echo get_phrase('sandbox');} else { echo get_phrase('live');} ?></td>
                <td><?php echo $row['endpoints']; ?></td>
                <td><?php echo $row['username']; ?></td>                
                <td><?php echo $row['hostname']; ?></td>
                <td><?php echo $row['signature']; ?></td>
                <td>
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                            <?php echo get_phrase('action'); ?> <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-default pull-right" role="menu">                            
                            <li>
                                <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_payment_gateway_edit/<?php echo $row['gateway_id'];?>');" 
                                    <i class="entypo-user"></i>
                                    <?php echo get_phrase('edit'); ?>
                                </a>
                            </li>
                            <li> 
                                <a href="" onclick="confirm_modal('<?php echo base_url(); ?>index.php?school_admin/view_payment_details/delete/<?php echo $row['gateway_id']; ?>');"
                                    <i class="entypo-trash"></i><?php echo get_phrase('delete'); ?>
                                </a>
                            </li>
                        </ul>                       
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</div>

<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->                      
<script type="text/javascript">
    jQuery(document).ready(function ($)
    {
        var datatable = $("#table_export").dataTable({
                        rowReorder: {
            selector: 'td:nth-child(2)'
                        },
                        responsive: true,
            "sPaginationType": "bootstrap",
            "sDom": "<'row'<'col-xs-12 col-sm-3 col-left'l><'col-xs-12 col-sm-9 col-right'<'export-data'T>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>",
            "oTableTools": {
                "aButtons": [
//                    {
//                        "sExtends": "xls",
//                        "mColumns": [0, 1, 2, 3]
//                    },
//                    {
//                        "sExtends": "pdf",
//                        "mColumns": [0, 1, 2, 3]
//                    },
//                    {
//                        "sExtends": "print",                        
//                        //"fnSetText": "Press 'esc' to return",
//                        "fnClick": function (nButton, oConfig) {
//                            //datatable.fnSetColumnVis(0, false);
//                            datatable.fnSetColumnVis(4, false);
//                            this.fnPrint(true, oConfig);
//                            window.print();
//                            $(window).keyup(function (e) {
//                                if (e.which == 27) {
//                                    datatable.fnSetColumnVis(0, true);
//                                    //datatable.fnSetColumnVis(4, true);
//                                }
//                            });
//                        }
//                    }
                ]
            }
        });

        $(".dataTables_wrapper select").select2({
            minimumResultsForSearch: -1
        });
    });    
</script>



