<?php
if (!empty($school_admin_info)){ $admin_info=$school_admin_info[0]; ?>
    <div class="profile-env">
        <header class="row">   
            <div class="col-xs-3">           
                <?php if($admin_info['profile_pic']!="" && file_exists('uploads/sc_admin_images/'.$admin_info['profile_pic'])) ?>
                <img src="<?php echo base_url();?>uploads/sc_admin_images/<?=$admin_info['profile_pic']?>" alt="School Admin Profile Picture"  width="100" height="100"> 
            </div>
            <div class="col-sm-9">
                <div class="profile-name m-t-20">
                    <h3>
                        <?php echo $admin_info['first_name']." ".$admin_info['last_name']; ?>                     
                    </h3>
                </div>          
            </div>
        </header>
        <section class="profile-info-tabs">
            <div class="row">
                <div class="">
                    <br>
                    <table class="table table-bordered">
                        <tr>
                            <td><?php echo get_phrase('School Admin Id'); ?></td>
                            <td><b><?php echo $admin_info['school_admin_id']; ?></b></td>
                        </tr>
                        <tr>
                            <td><?php echo get_phrase('Name'); ?></td>
                            <td><b><?php echo $admin_info['first_name']." ".$admin_info['last_name']; ?></b></td>
                        </tr>
                        <tr>
                            <td><?php echo get_phrase('Email'); ?></td>
                            <td><b><?php echo $admin_info['email']; ?></b></td>
                        </tr>
                        <tr>
                            <td><?php echo get_phrase('Password'); ?></td>
                            <td><b><?php echo $admin_info['original_pass']; ?></b></td>
                        </tr>
                        <tr>
                            <td><?php echo get_phrase('mobile'); ?></td>
                            <td><b><?php echo $admin_info['mobile']; ?></b>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>		
        </section>
    </div>
<?php } ?>
        

