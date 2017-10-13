<?php
if (!empty($school_info)){ $school_info=$school_info[0]; ?>
    <div class="profile-env">
        <header class="row">   
            <div class="col-xs-3">    
                <?php if($school_info['logo']!="" && file_exists('uploads/school_images/'.$school_info['logo'])) ?>
                <img src="<?php echo base_url();?>uploads/school_images/<?=$school_info['logo']?>" alt="School Logo"  width="100" height="100"> 
            </div>
            <div class="col-sm-9">
                <div class="profile-name m-t-20">
                    <h3>
                        <?php echo $school_info['name']; ?>                     
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
                            <td><?php echo get_phrase('School Id'); ?></td>
                            <td><b><?php echo $school_info['school_id']; ?></b></td>
                        </tr>
                        <tr>
                            <td><?php echo get_phrase('Name'); ?></td>
                            <td><b><?php echo $school_info['name']; ?></b></td>
                        </tr>
                        <tr>
                            <td><?php echo get_phrase('Address Line 1'); ?></td>
                            <td><b><?php echo $school_info['addr_line1'];?></b>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo get_phrase('Address Line 2'); ?></td>
                            <td><b><?php echo $school_info['addr_line2'];?></b>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo get_phrase('mobile'); ?></td>
                            <td><b><?php echo $school_info['mobile']; ?></b>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo get_phrase('telephone'); ?></td>
                            <td><b><?php echo $school_info['telephone']; ?></b>
                            </td>
                        </tr>                        
                        <tr>
                            <td><?php echo get_phrase('pincode'); ?></td>
                            <td><b><?php echo $school_info['pin'];?></b>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>		
        </section>
    </div>
<?php } ?>
        

