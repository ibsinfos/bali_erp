<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?></h4>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" target="_blank" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?parents/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active">
                <?php echo get_phrase($page_title); ?>
            </li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <?php if(!empty($student_info)){?>
        <div class="white-box">
            <h2><?php echo get_phrase('students_details'); ?></h2>
        </div>
        <?php
            foreach($student_info as $row){  ?>
            
            <div class="col-xs-12 col-sm-4 col-lg-4 text-center">
             <div class="white-box" data-step="5" data-intro="<?php echo get_phrase('On click of student name, will display information of hostel and warden');?>" data-position='top'>
                <div class="panel panel-default">
                    <img style="border-radius:50%; margin-top:10px;" width="150px" class="card-img-top" src="<?php echo $photo_url;?>">
                    <div class="card-block">
                    <button class="accordion">
                        <strong><?php echo $row['name']; ?></strong></button>
                        
                    <div class="panel" id="section">
                        <?php foreach($warden_details as $det){ ?>
                        <div class="row">
                            <div class="col-xs-12 card-row">
                                <span class="col-xs-6 col-md-5 text-right"><b class="word-white-sapce"><?php echo get_phrase('warden_name:'); ?></b></span>
                                <span class="col-xs-6 col-md-7 text-left"><?php echo $det['name']  ;  ?></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 card-row">
                                <span class="col-xs-6 col-md-5 text-right"><b class="word-white-sapce"><?php echo get_phrase('warden_email:'); ?></b></span>
                                <span class="col-xs-6 col-md-7 text-left"><?php echo $det['email']  ;  ?></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 card-row">
                                <span class="col-xs-6 col-md-5 text-right"><b class="word-white-sapce"><?php echo get_phrase('warden_phone:'); ?></b></span>
                                <span class="col-xs-6 col-md-7 text-left"><?php echo $det['phone_number']  ;  ?></span>
                            </div>
                        </div>
                        <?php } ?>
                        
                        <div class="row">
                            <div class="col-xs-12 card-row">
                                <span class="col-xs-6 col-md-5 text-right"><b class="word-white-sapce"><?php echo get_phrase('hostel_name:'); ?></b></span>
                                <span class="col-xs-6 col-md-7 text-left"><?php echo $row['hostel_name']  ;  ?></span>
                            </div>
                        </div>

                      
                        <div class="row">
                            <div class="col-xs-12 card-row">
                                <span class="col-xs-6 col-md-5 text-right"><b class="word-white-sapce"><?php echo get_phrase('type:'); ?></b></span>
                                <span class="col-xs-6 col-md-7 text-left"><?php echo $row['hostel_type']  ;?></span>
                            </div>
                        </div>
                    
                        <div class="row">
                            <div class="col-xs-12 card-row">
                                <span class="col-xs-6 col-md-5 text-right"><b class="word-white-sapce"><?php echo get_phrase('floor_name:'); ?></b></span>
                                <span class="col-xs-6 col-md-7 text-left"><?php echo $row['floor_name']  ;?></span>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-xs-12 card-row">
                                <span class="col-xs-6 col-md-5 text-right"><b class="word-white-sapce"><?php echo get_phrase('room_no:'); ?></b></span>
                                <span class="col-xs-6 col-md-7 text-left"><?php echo $row['room_no']  ; ?></span>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-xs-12 card-row">
                                <span class="col-xs-6 col-md-5 text-right"><b class="word-white-sapce"><?php echo get_phrase('room_fare:'); ?></b></span>
                                <?php if($room_fare == ''){ ?>
                                <span class="col-xs-6 col-md-7 text-left"><?php echo "Room Fare Not Defined" ; ?></span>
                                <?php } else { ?>
                                <span class="col-xs-6 col-md-7 text-left"><?php echo $room_fare ; ?></span>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 card-row">
                                <span class="col-xs-6 col-md-5 text-right"><b class="word-white-sapce"><?php echo get_phrase('food:'); ?></b></span>
                                <span class="col-xs-6 col-md-7 text-left"><?php echo $row['food']  ; ?></span>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-xs-12 card-row">
                                <span class="col-xs-6 col-md-5 text-right"><b class="word-white-sapce"><?php echo get_phrase('register_date:'); ?></b></span>
                                <span class="col-xs-6 col-md-7 text-left"><?php echo $row['register_date']  ; ?></span>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-xs-12 card-row">
                                <span class="col-xs-6 col-md-5 text-right"><b class="word-white-sapce"><?php echo get_phrase('vacating_date:'); ?></b></span>
                                <span class="col-xs-6 col-md-7 text-left"><?php echo $row['vacating_date']  ; ?></span>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-xs-12 card-row">
                                <span class="col-xs-6 col-md-5 text-right"><b class="word-white-sapce"><?php echo get_phrase('transfer_date:'); ?></b></span>
                                <span class="col-xs-6 col-md-7 text-left"><?php echo $row['transfer_date']  ; ?></span>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-xs-12 card-row">
                                <span class="col-xs-6 col-md-5 text-right"><b class="word-white-sapce"><?php echo get_phrase('status:'); ?></b></span>
                                <span class="col-xs-6 col-md-7 text-left"><?php echo $row['status']  ; ?></span>
                            </div>
                        </div> 
                        
                    </div>
                </div>
            </div>
                </div>
            </div>
        <?php } ?>
        </div>
    </div>
<?php } else { ?>
  <div class="panel panel-heading" data-collapsed="0" >
   <div class="panel-heading">
       <div class="panel-title" >
           <i class="entypo-info"></i>
           <?php echo get_phrase("No information available as your child is not using hostel facility!!!"); ?>
       </div>
   </div> 
</div>
<?php } ?>



<script>
    var acc = document.getElementsByClassName("accordion");
    var i;

    for (i = 0; i < acc.length; i++) {
        acc[i].onclick = function () {
            this.classList.toggle("active");
            var panel = this.nextElementSibling;
            if (panel.style.display === "block") {
                panel.style.display = "none";
            } else {
                panel.style.display = "block";
            }
        }
    }
</script>

<style>
    button.accordion {
        background-color: #ff9009;
        color: #fff;
        cursor: pointer;
        padding: 10px;
        width: 100%;
        border: none;
        text-align: center;
        outline: none;
        font-size: 15px;
        transition: 0.4s;
        margin-top:10px;
    }

    button.accordion.active, button.accordion:hover {
        background-color: #efa956; 
    }

    #section {
        padding: 10px;
        display: none;
        margin-bottom:0;
       
    }
  
</style>

