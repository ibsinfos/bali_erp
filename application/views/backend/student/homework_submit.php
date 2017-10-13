<?php
   // pre($homeworks);
   // echo "<br>here student id is $student_id and parent id is $parent_id";
?>
<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?></h4>
    </div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?student/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li><a href="<?php echo base_url(); ?>index.php?student/my_exam"><?php echo get_phrase('my_exam'); ?></a></li>
            <li class="active">
                <?php echo get_phrase($page_title); ?>
            </li>
        </ol>
    </div>
</div>
<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro|Open+Sans+Condensed:300|Raleway' rel='stylesheet' type='text/css'>

<div class="white-box">
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-6">
                
            </div>
            <div class="col-md-6 text-right">
                <button class="fcbtn btn btn-danger btn-outline btn-1d">
                    <span id="demo"></span>
                </button>
            </div>
        </div>
    </div>
</div>
<div class="white-box">
    <?php echo form_open(base_url() . 'index.php?student/homework/create', array('onsubmit'=>"return validate();",'class' => 'validate', 'target' => '_top', 'id'=>'online_exam', 'name' => 'online_exam')); ?>
    <div class="row">
        <input type="hidden" name="hw_id" value="<?php echo $homeworks[0]['home_work_id'] ?>">
        <input type="hidden" name="hw_type" value="<?php echo $homeworks[0]['type_id'] ?>">
        <input type="hidden" name="class_id" value="<?php echo $homeworks[0]['class_id'] ?>">
        <input type="hidden" name="section_id" value="<?php echo $homeworks[0]['section_id'] ?>">
        <input type="hidden" name="subject_id" value="<?php echo $homeworks[0]['subject_id'] ?>">
        <input type="hidden" name="student_id" value="<?php echo $student_id ?>">
        <input type="hidden" name="parent_id" value="<?php echo $parent_id ?>">
        <input type="hidden" name="action" value="create">
        
    </div>
    
    <div class="row">          
        <div class="col-xs-12 col-md-offset-3 col-md-6">
          <h4 class="page-title"><?php echo $homeworks[0]['hw_name']; ?></h4>
            

        </div> 
    </div>
    <hr>
    <div class="row">          
        <div class="col-xs-12 col-md-offset-3 col-md-6">
            
              <h4 class="page-title"><?php echo $homeworks[0]['hw_description']; ?></h4>
            

        </div> 
    </div>
    <hr>
                            <div class="row">
                                <div class="col-xs-12 col-md-offset-3 col-md-6">
                                    <label for="poll_content">
                                    <?php echo get_phrase('home_work_description'); ?>:<span class="error mandatory"> *</span></label>
                                    <textarea class='summernote' name="hw_description" id="hw_description"></textarea>
                                    <label> <?php echo form_error('description'); ?></label>
                                </div>
                            </div>
                            
                           
                            
    <!--    <div class="col-md-6 text-right">
    <?php //echo $this->pagination->create_links();  ?>
        </div>-->
    <div class="row">
        <div class="text-right col-md-12 p-t-10">
            <button type="submit" name='submit' id='submit' class="fcbtn btn btn-danger btn-outline btn-1d">
                <?php echo get_phrase('submit'); ?>
            </button>
        </div>
    </div>  
<?php echo form_close(); ?>
</div>		


<script>
function validate()
    {
        
        var obj1 = document.getElementById('hw_description');
         //var obj2 = document.myForm.name;
             if(obj1.value == '') 
             {      
               alert("Please Provide Details!");
               obj1.focus();
               return false;       
             }
             else
               return true;
    } 
// Set the date we\'re counting down to
    var t = new Date();
    t.setSeconds(t.getSeconds() + <?php echo $total?>);
//twentyMinutesLater.setMinutes(twentyMinutesLater.getMinutes() + <?php //echo $total?>);
    var countDownDate = t.getTime();
// countDownDate = new Date("Jan 5, 2018 15:37:25").getTime();

// Update the count down every 1 second
    var x = setInterval(function() {

    // Get todays date and time
    var now = new Date().getTime();
    
    // Find the distance between now an the count down date
    var distance = countDownDate - now;
    
    // Time calculations for days, hours, minutes and seconds
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
    // Output the result in an element with id="demo"
    document.getElementById("demo").innerHTML = hours + ":"
    + minutes + ":" + seconds;
    
    // If the count down is over, write some text 
    if (distance < 0) {
        clearInterval(x);
        submit_exam_online() ;
        document.getElementById("demo").innerHTML = "EXPIRED";
    }
}, 500);

function submit_exam_online() {
    document.getElementById("online_exam").submit();
}




</script>