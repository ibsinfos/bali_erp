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
<div class="col-md-2 pull-right">
    <a href="javascript: void(0);" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_inventory_add_category/');" class="btn btn-primary btn-circle btn-lg pull-right tooltip-danger par-add-btn" data-toggle="tooltip" data-placement="left" title="" data-original-title="Add New Cateogory" data-step="5" data-intro="Add New Category in Inventory" data-position='left'>
        <i class="fa fa-plus"></i>
    </a>        
</div>
</div>
<div class="col-md-12 white-box" data-step="6" data-intro="<?php echo get_phrase('Inventory Category List.');?>" data-position='top'>
    <table id="ex" class="display nowrap table-responsive" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th><div><?php echo get_phrase('Categories_Name'); ?></div></th>
                <th><div><?php echo get_phrase('Total_Item'); ?></div></th>
                <th><div><?php echo get_phrase('Actions'); ?></div></th>
                <th><div><?php echo get_phrase('Options'); ?></div></th>     
            </tr>
        </thead>
        <tbody>
            <?php foreach ($category as $row) { ?><tr>
                    <td>
                        <?php echo $row['categories_name']; ?>
                    </td>
                    <td> <?php echo $row['count']; ?>
                    </td>
                    <td>
                        <div class="btn-group">
                            <button type="button" data-toggle="dropdown" class="btn btn-default btn-outline dropdown-toggle waves-effect waves-light">
                                <?php echo get_phrase('View_Details '); ?> <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-default pull-right pos-static" role="menu">
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php?school_admin/manage_product/<?php echo $row['categories_id']; ?>" >
                                        <i class="fa fa-view"></i>
                                        <?php echo 'View All ' . $row['categories_name']; ?>
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </td>
                    <td>
                        <a href="<?php echo base_url(); ?>index.php?school_admin/add_inventory_product/<?php echo $row['categories_id']; ?>"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo 'Add ' . $row['categories_name']; ?>"><i class="fa fa-plus-square"></i></button></a>                                                       
                        <a href="<?php echo base_url(); ?>index.php?school_admin/category_edit/<?php echo $row['categories_id']; ?>" ><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Edit Category"><i class="fa fa-pencil-square-o"></i></button></a>
                        <?php
                         if(intval($row['transaction'])>0){        
                           echo '<button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 disabled"  data-placement="top" data-original-title="'.get_phrase('delete_class').'" title="'.get_phrase('delete_class').'"><i class="fa fa-trash-o"></i> </button>';
                            }
                            else{
                                ?>
                        <a href="javascript: void(0);" onclick="confirm_modal('<?php echo base_url(); ?>index.php?school_admin/inventory_category/delete/<?php echo $row['categories_id']; ?>');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete Category"><i class="fa fa-trash-o"></i></button></a>
                    </td>
                    <?php
                        }
                    ?>
                </tr><?php } ?>
        </tbody>
    </table>
</div> 
