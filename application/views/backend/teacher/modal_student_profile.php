<?php if(!empty($student_info)){foreach($student_info as $row):?>

<div class="profile-env">
    
    <header class="row">
        
        <div class="col-sm-3">
            
            <a href="#" class="profile-picture">
                <img src="<?php echo (!empty($student_image))?$student_image:'' ;?>" 
                    class="img-responsive img-circle" />
            </a>
            
        </div>
        
        <div class="col-sm-9">
            
            <ul class="profile-info-sections">
                <li style="padding:0px; margin:0px;">
                    <div class="profile-name">
                         <?php foreach($student_details as $details) {?>
                            <h3>
                                <?php echo (!empty($details['name']))?$details['name']:'' ;?>                     
                            </h3>
                    </div>
                </li>
            </ul>
            
        </div>
        
        
    </header>
    
    <section class="profile-info-tabs">
        
        <div class="row">
            
            <div class="">
                    <br>
                    
                <table class="table table-bordered">
                
                    <?php if($row['class_id'] != ''):?>
                    <tr>
                        <td><?php echo get_phrase('class');?></td>
                        <td><b><?php echo $this->crud_model->get_class_name($row['class_id']);?></b></td>
                    </tr>
                    <?php endif;?>

                    <?php if($row['section_id'] != '' && $row['section_id'] != 0):?>
                    <tr>
                        <td><?php echo get_phrase('section');?></td>
                        <td><b><?php echo $this->db->get_where('section' , array('section_id' => $row['section_id']))->row()->name;?></b></td>
                    </tr>
                    <?php endif;?>
                
                    <?php if($row['roll'] != ''):?>
                    <tr>
                        <td><?php echo get_phrase('roll');?></td>
                        <td><b><?php echo $row['roll'];?></b></td>
                    </tr>
                    <?php endif;?>
                    <tr>
                        <td><?php echo get_phrase('birthday');?></td>
                        <td><b><?php echo (!empty($details['birthday']))?$details['birthday']:'';?></b></td>
                    </tr>
                   
                    <tr>			
                        <td>Student Email</td>	
                        <td><b><?php echo $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->email; ?></b></td>
                </tr>
				
                    <tr>
                        <td><?php echo get_phrase('gender');?></td>
                        <td><b><?php echo (!empty($details['sex']))?$details['sex']:'' ;?></b></td>
                    </tr>
                    <tr>
                        <td><?php echo get_phrase('phone');?></td>
                        <td><b><?php echo (!empty($details['phone']))?$details['phone']:'';?></b></td>
                    </tr>
                    
                    <tr>
                        <td><?php echo get_phrase('address');?></td>
                        <td><b><?php echo (!empty($details['address']))?$details['address']:'' ;?></b>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo get_phrase('parent');?></td>
                        <td>
                            <b>
                                <?php
                                    echo (!empty($details['father_name']))?$details['father_name']:'' ;
                                ?>
                            </b>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo get_phrase('email');?></td>
                        <td><b><?php echo (!empty($details['email']))?$details['email']:'' ;?></b></td>
                    </tr>
                    <tr>
                        <td><?php echo get_phrase('parent_phone');?></td>
                        <td><b><?php echo (!empty($details['cell_phone']))?$details['cell_phone']:'' ;?></b></td>
                    </tr>
                    
                </table>
                     <?php } ?>
            </div>
        </div>      
    </section>
    
    
    
</div>


<?php endforeach;
}?>