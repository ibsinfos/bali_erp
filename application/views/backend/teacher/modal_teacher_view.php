<?php
//echo '<pre>'; print_r($teacher_info); 
if (!empty($teacher_info)){ ?>
    <div class="profile-env">
        <header class="row">   
            <div class="col-xs-3">           
                <img src="<?php echo base_url();?>uploads/user.jpg" alt="profile image"  width="100" height="100"> 
            </div>
            <div class="col-sm-9">
                <div class="profile-name m-t-20">
                    <h3>
                        <?php echo $teacher_info[0]['name']." ". $teacher_info[0]['middle_name']." ". $teacher_info[0]['last_name']; ?>                     
                    </h3>
                </div>          
            </div>
        </header>
        <section class="profile-info-tabs">
            <div class="row">
                <div class="col-md-12">
                    <br>
                    <table class="table table-bordered">   
                       
                        <tr>
                            <td><?php echo get_phrase('emp_code'); ?></td>
                            <td><b><?php echo $teacher_info[0]['card_id']; ?></b></td>
                        </tr>
                        <tr>
                            <td><?php echo get_phrase('emp_id'); ?></td>
                            <td><b><?php echo substr($teacher_info[0]['emp_id'],4); ?></b></td>
                        </tr>
                        <tr>
                            <td><?php echo get_phrase('email'); ?></td>
                            <td><b><?php echo $teacher_info[0]['email'];?></b>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo get_phrase('job_title'); ?></td>
                            <td><b><?php echo $teacher_info[0]['job_title']; ?></b>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo get_phrase('yers_of_exp'); ?></td>
                            <td><b><?php echo $teacher_info[0]['experience']; ?></b>
                            </td>
                        </tr>                        
                        <tr>
                            <td><?php echo get_phrase('phone'); ?></td>
                            <td><b><?php echo $teacher_info[0]['cell_phone'];?></b>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>		
        </section>
    </div>
<?php } ?>
        

