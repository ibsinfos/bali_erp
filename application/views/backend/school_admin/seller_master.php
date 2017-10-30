<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('seller_list'); ?></h4>
    </div>
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
</div>

<div class="row">
    <div class="col-xs-12 m-b-20" >
        <a href="<?php echo base_url(); ?>index.php?school_admin/seller_add/" class="btn btn-primary btn-circle btn-lg pull-right tooltip-danger" data-toggle="tooltip" data-placement="left" title="" data-original-title="Add Seller Info" data-step="5" data-intro="From here you can add seller info" data-position='left'>
            <i class="fa fa-plus"></i>
        </a>
    </div>
</div>

<div class="col-md-12 white-box preview_outer">
    <div data-step="6" data-intro="<?php echo get_phrase('Here you can see list of seller info.');?>" data-position='bottom'>
        <table id="example_asc_time" class="table display nowrap">
            <thead>
                <tr>
                    <th><div><?php echo get_phrase('s._no.'); ?></div></th>
                    <th><div><?php echo get_phrase('name'); ?></div></th>
                    <th><div><?php echo get_phrase('phoneNo'); ?></div></th>
                    <th><div><?php echo get_phrase('email_id'); ?></div></th>
                    <th><div><?php echo get_phrase('contact_person'); ?></div></th>
                    <th><div><?php echo get_phrase('address'); ?></div></th>
                    <th><div><?php echo get_phrase('product_purchased'); ?></div></th>
                    <th><div><?php echo get_phrase('Options'); ?></div></th>
                </tr>
            </thead>

            <tbody>
                <?php
                $count = 0;
                foreach ($data as $row) {
                    $count++;
                    ?><tr>
                        <td><?php echo $count; ?></td>
                        <td>
                            <?php echo $row['seller_name']; ?>  
                        </td>

                        <td>
                            <?php echo $row['seller_phone_number']; ?> 
                        </td>
                        <td>
                            <?php echo $row['seller_email_id']; ?> 
                        </td>
                        <td>
                            <?php echo $row['seller_contact_person']; ?> 
                        </td>
                        <td>
                            <?php echo $row['seller_address']; ?> 
                        </td>
                        <td>
                            <?php echo $row['count']; ?> 
                        </td>
                        <td>
                            <!--uploads/inventory_seller_document/-->
                            <?php if (!empty($row['attached_document']) && file_exists(FCPATH.'uploads/inventory_seller_document/'.$row['attached_document'])){ ?>
                            <a href="javascript: void(0);" onclick="showDocumentPreview('<?php echo base_url(); ?>index.php?modal/popup/seller_document_preview/<?php echo $row['attached_document']; ?>');">
                                <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('view') ?>" title="<?php echo get_phrase('view_business_card') ?>"><i class="fa fa-eye"></i></button>
                            </a>
                            <?php }else{ ?>
                                <a href="javascript: void(0);"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="No Available Business Card" disabled="" title="<?php echo get_phrase('no_available_business_card') ?>"><i class="fa fa-eye"></i></button></a>
                            <?php }
?>
                            <a href="<?php echo base_url(); ?>index.php?school_admin/seller_edit/<?php echo $row['seller_id']; ?>" >
                                <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('edit'); ?>" title="<?php echo get_phrase('edit'); ?>">
                                    <i class="fa fa-pencil-square-o"></i>
                                </button>
                            </a>
                            <?php
                             if(intval($row['count'])>0)
                            {
                                      
                           echo '<button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 disabled"  data-placement="top" data-original-title="'.get_phrase('delete_class').'" title="'.get_phrase('delete_class').'"><i class="fa fa-trash-o"></i> </button>';
                            }
                            else
                            {
                                ?>
                            <a href="javascript: void(0);" onclick="confirm_modal('<?php echo base_url(); ?>index.php?school_admin/seller_master/delete/<?php echo $row['seller_id']; ?>');">
                                <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete">
                                    <i class="fa fa-trash-o"></i>
                                </button>
                            </a>
                       <?php
                            }
                        ?>    
                        </td>
                    </tr><?php } ?>
            </tbody>
        </table>
    </div>
</div>