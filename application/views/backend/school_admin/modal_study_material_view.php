<?php if (!empty($study_material_info)){ 
    $row = array_shift($study_material_info); ?>
    <div class="profile-env">        
        <section class="profile-info-tabs">
            <div class="row">
                <!--<div class="">-->
                    <br>
                    <table class="table table-bordered">   
                       
                        <tr>
                            <td><?php echo get_phrase('title'); ?></td>
                            <td><b><?php echo $row['title']; ?></b></td>
                        </tr>
                        <tr>
                            <td><?php echo get_phrase('description'); ?></td>
                            <td><b><?php echo $row['description']; ?></b></td>
                        </tr>                        
                        <tr>
                            <td><?php echo get_phrase('class'); ?></td>
                            <td><b><?php echo $row['classname']; ?></b>
                            </td>
                        </tr>                        
                        <tr>
                            <td><?php echo get_phrase('added_by'); ?></td>
                            <td><b><?php echo $row['teacher_name'];?></b>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo get_phrase('file'); ?></td>
                            <td><a href="<?php echo base_url().'index.php?school_admin/download_study_material/'.$row['file_name']; ?>" class="btn btn-blue btn-icon icon-left">
                                <button type="button" class="btn btn-default  btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" 
                                        data-placement="top" data-original-title="<?php echo get_phrase('download') ?>" title="<?php echo get_phrase('download') ?>">
                                <i class="fa fa-download"></i>
                                </button>
                            </a><b><?php echo $row['file_name'];?></b>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo get_phrase('file_type'); ?></td>
                            <td><b><?php echo $row['file_type']; ?></b>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo get_phrase('added_on'); ?></td>
                            <td><b><?php echo $row['timestamp']; ?></b>
                            </td>
                        </tr>
                    </table>
                <!--</div>-->
            </div>		
        </section>
    </div>
<?php } ?>
        