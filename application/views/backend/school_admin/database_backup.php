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
    <div class="col-md-8 form-group">
        <div class="form-group col-sm-6 p-0" data-step="5" data-intro="<?php echo get_phrase('Select class from here and then list of subject will open here');?>" data-position='bottom'>
            <label class="control-label"><?php echo get_phrase($page_subtitle); ?></label>
        </div>
    </div>
    <div class="col-lg-2 col-sm-2 col-xs-12"><button class="btn btn-block btn-success" onclick="location.href='<?php echo base_url();?>index.php?school_admin/restor_google_backup';"><?php echo get_phrase('restore_google_backup'); ?></button></div>
    <div class="col-lg-2 col-sm-2 col-xs-12"><button class="btn btn-block btn-success btn_create_backup"><?php echo get_phrase('create_backup'); ?></button></div>
</div>

<div class="col-md-12 white-box">        
    <table class= "custom_table table display" cellspacing="0" width="100%" id="example23">
        <thead>
            <tr>
                <th>#</th>
                <th><div><?php echo get_phrase('name'); ?></div></th>
                <th><div><?php echo get_phrase('size'); ?> (in MB)</div></th>
                <th><div><?php echo get_phrase('create_time'); ?></div></th>
                <th><div><?php echo get_phrase('modified_time'); ?></div></th>
                <th></th>
            </tr>
        </thead>
        <tbody><?php if(count($data)){ $n = 1; foreach ($data as $datum){ ?>
            <tr>
                <td><?php echo $n++; ?></td>
                <td><?php echo ucfirst($datum['name']); ?></td>
                <td><?php echo $datum['size']; ?></td>
                <td><?php echo date('d-m-Y H:i:s', $datum['create_time']); ?></td>
                <td><?php echo date('d-m-Y H:i:s', $datum['modified_time']); ?></td>
                <td>
                    <a href="javascript: void(0);" onclick="confirm_modal('<?php echo base_url(); ?>index.php?school_admin/deleted_database_manual_backups/<?php echo $datum['name']; ?>');">
                        <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-trash-o"></i></button>
                    </a> &nbsp;
                    <a href="<?php echo base_url(); ?>index.php?school_admin/download_database_manual_backups/<?php echo $datum['name']; ?>">
                        <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Download"><i class="fa fa-download"></i></button>
                    </a>
                </td>
            </tr><?php }} ?>
        </tbody>
    </table>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('.btn_create_backup').on("click",function(){
            location.href='<?php echo base_url().'index.php?school_admin/create_database_data_backup';?>';
        });
    });
</script>