<!--to be deleted-->
<?php $details = array_shift($notice_details); ?>
<?php if($details['sender_type'] == 'Teacher'){?>
<div class="modal-body">
    <from class="form-horizontal form-material">
        <div class="form-group">            
            <div class="col-md-12 m-b-20">
                <label>Notice Title</label><br>
                <label><?php echo ucfirst(wordwrap($details['notice_title'], 25, "\n", true));?></label>
            </div>             
            <div class="col-md-12 m-b-20">
                <label>Notice Description</label><br>
                <label><?php echo ucfirst(wordwrap($details['notice'], 40, "\n", true));?></label>
            </div> 
            <div class="col-md-12 m-b-20">
                <label>Class</label><br>
                <?php if($details['class_id'] == 0){ ?>
                <label><?php echo get_phrase('common_notice');?></label>
                <?php } else{ ?>
                <label><?php echo $this->db->get_where('class',array('class_id'=>$details['class_id']))->row()->name;?></label>
                <?php } ?>
            </div> 
            
            <div class="col-md-12 m-b-20">
                <?php if(!empty($stud_ids)) { ?>            
                <label>Sent To Students</label><br>
                <?php foreach($stud_ids as $ids){                    
                        $stud_emails  =  get_data_generic_fun('student','email',array('student_id'=>$ids),'result_arr');  ?>
                        <label><?php echo $stud_emails[0]['email'].","; ?></label>
                <?php } ?>
                 <?php } else {?>
            <label>No Students Selected</label><br>       
            <?php } ?>
            </div> 
            
            <div class="col-md-12 m-b-20">
                <?php if(!empty($par_ids)) { ?>
                <label>Sent To Parents</label><br>
                <?php foreach($par_ids as $pids){
                        $par_emails  =  get_data_generic_fun('parent','email',array('parent_id'=>$pids),'result_arr');  ?>
                        <label><?php echo $par_emails[0]['email'].","; ?></label>
                <?php } ?>           
            <?php } else {?>
            <label>No Parents Selected</label><br>
            <?php }?>
            </div> 
            
            <div class="col-md-12 m-b-20">
                <label>Sent On</label><br>
                <label><?php echo $details['create_time'];?></label>
            </div>
        </div>     
    </from>
</div>
<?php } ?>
<?php if($details['sender_type'] == 'Admin'){?>
<div class="modal-body">
    <from class="form-horizontal form-material">
        <div class="form-group">            
            <div class="col-md-12 m-b-20">
                <label>Notice Title</label><br>
                <label><?php echo $details['notice_title'];?></label>
            </div>             
            <div class="col-md-12 m-b-20">
                <label>Notice Description</label><br>
                <label><?php echo $details['notice'];?></label>
            </div> 
            <div class="col-md-12 m-b-20">
                <label>Class</label><br>
                <?php if($details['class_id'] == 0){ ?>
                <label><?php echo get_phrase('common_notice');?></label>
                <?php } else{ ?>
                <label><?php echo $this->db->get_where('class',array('class_id'=>$details['class_id']))->row()->name;?></label>
                <?php } ?>
            </div> 
            
            <div class="col-md-12 m-b-20">
                <label>Sent On</label><br>
                <label><?php echo $details['create_time'];?></label>
            </div>
        </div>     
    </from>
</div>
<?php } ?>