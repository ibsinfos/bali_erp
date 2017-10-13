<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('Create_Category'); ?> </h4></div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);"  onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
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
<?php //echo '<pre>'; print_r($categories); exit;?>

<div class="col-md-12 white-box">
    <div class="sttabs tabs-style-flip">
        <nav>
            <ul>
                <li data-step="5" data-intro="From here you can view and edit the category." data-position="top"><a href="#section-flip-1" class="sticon fa fa-bars"><span><?php echo get_phrase('view_categories');?></span></a></li>
                <li data-step="6" data-intro="From here you can add a new category." data-position="top"><a href="#section-flip-2" class="sticon fa fa-plus-circle"><span><?php echo get_phrase('add_category');?></span></a></li>

            </ul>
        </nav>
        <div class="content-wrap  add-new-style">
            <section id="section-flip-1">
                <table class= "custom_table table display" cellspacing="0" width="100%" id="example23">
                    <thead>
                        <tr>
                            <th><div>
                                <?php echo get_phrase('s._no.');?></div>
                            </th>
                            <th><div>
                                <?php echo get_phrase('category');?></div>
                            </th>
                            <th><div>
                                <?php echo get_phrase('options');?></div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php if (!empty($categories)){ $i = 1; ?>  
                        <?php //echo '<pre>'; print_r($categories);?>
                            <?php foreach ($categories as $cat): ?>
                                <tr>
                                    <td>
                                       <?php echo $i; ?>
                                    </td>
                                    <td>
                                       <?php echo $cat['name']; ?>
                                    </td>

                                    <td>
                                        <a title="edit" href="<?php echo base_url(); ?>index.php?discussion_forum/edit_category/<?php echo $cat['category_id']; ?>">
                                            <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil-square-o"></i></button>
                                        </a>

                                        <a title="delete" href="#" onclick="confirm_modal('<?php echo base_url(); ?>index.php?discussion_forum/edit_category/delete/<?php echo $cat['category_id']; ?>');">
                                            <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-trash-o"></i></button>
                                        </a>
                                    </td>
                                </tr>
                                <?php $i++; endforeach; ?>
                    </tbody>
                </table>
                <?php } else {?>
                    <table class= "custom_table table display" cellspacing="0" width="100%" id="example23">
                        <thead>
                            <tr>
                                <th>
                                    <?php echo get_phrase('no_records_found');?>
                                </th>
                            </tr>
                        </thead>
                    </table>
                    <?php } ?>


            </section>
            <section id="section-flip-2">
                <?php echo form_open(base_url() . 'index.php?discussion_forum/create_category' , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top' , 'enctype' => 'multipart/form-data'));?>

                    <?php if ($this->session->flashdata('flash_message_error')) { ?>
                        <div class="alert alert-danger">
                            <?php echo $this->session->flashdata('flash_message_error'); ?>
                        </div>
                        <?php } ?>

                        <div class="col-xs-12 col-md-offset-3 col-md-6">
                            <label>
                                <?php echo get_phrase('category_name');?><span class="error mandatory"> *</span></label>

                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-pie-chart"></i></div>
                                <input type="text" class="form-control" name="category_name" id="category_name" value=" " data-validate="required" data-message-required="Please enter a category" /> </div>
                        </div>

                        <div class="form-group col-xs-12 text-center">
                            <button type="submit" name="submit_cat" value="submit_cat" class="fcbtn btn btn-danger btn-outline btn-1d m-t-10 m-b-10">
                                <?php echo get_phrase('add_category');?>
                            </button>
                        </div>
                        <?php echo form_close();  ?>

            </section>
        </div>
        <!-- /content -->
    </div>
    <!-- /tabs -->
</div>


<script type="text/javascript">
    $(function() {
        $('#category_name').change(function() {
            var name = $('#category_name').val().toLowerCase().replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-');
            $('#tags').val(name);
        });
    });
</script>