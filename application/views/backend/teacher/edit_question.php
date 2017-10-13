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
            <li><a href="<?php echo base_url(); ?>index.php?teacher/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li><a href="<?php echo base_url(); ?>index.php?teacher/view_question/<?php echo $class_id .'/'. $exam_id.'/'.$subject_id;?>"><?php echo get_phrase('view_question'); ?></a></li>
            <li class="active">
                <?php echo get_phrase($page_title); ?>
            </li>
        </ol>
    </div>
</div>

 <?php  foreach ($question as $row): ?>
<div class="row">
    <?php if ($this->session->flashdata('flash_message_error')) { ?>        
        <div class="alert alert-danger">
            <?php echo $this->session->flashdata('flash_message_error'); ?>
        </div>
    <?php } ?>
    <?php echo form_open(base_url().'index.php?teacher/add_question/edit/do_update/'.$row['id'].'/'.$exam_id, array('class' => 'form-groups-bordered validate', 'enctype' => 'multipart/form-data', 'id' => 'addQuestionFrom','name' => 'addQuestion')); ?>
    <div class="alert" id="error_msg">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
  <strong>Please Check any answer!</strong>
</div>
    <div class="col-md-12">        
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title" >
                    <i class="entypo-plus-circled"></i>
                    <?php echo get_phrase('edit_question_form'); ?>
                </div>
            </div>
          
           
            <div class="row">               
                <div class="col-md-12"><div class="panel panel-primary" data-collapsed="0"><?php echo get_phrase('subject_type'); ?></div></div>
                <div class="col-md-12"> 
                    <div class="col-md-3">  
                        <label class="form-check-label">
                        <?php if($row['qtype_id']=='1')$chk1 = 'checked="checked"';else $chk1="";?>
                            <input class="form-check-input" type="radio" 
                                   name="question_type" value="1" <?php echo $chk1; ?>  id="question_type" onclick="show_tabs_list();">
                                   <?php echo get_phrase('objective_questions'); ?>
                        </label> 
                    </div>
                    <div class="col-md-3"> 
                        <label class="form-check-label">
                            <?php if($row['qtype_id']=='2')$chk2 = 'checked="checked"';else $chk2="";?>
                            <input class="form-check-input" type="radio" 
                                   name="question_type" value="2"  <?php echo $chk2; ?> id="question_type" onclick="view_true_false();">
                                   <?php echo get_phrase('true_/_false'); ?>
                        </label> 


                    </div>
                    <div class="col-md-3"> 
                        <label class="form-check-label">
                             <?php if($row['qtype_id']=='3')$chk3 = 'checked="checked"'; else $chk3="";?>
                            <input class="form-check-input" type="radio" 
                                   name="question_type" value="3" <?php echo $chk3; ?> id="question_type" onclick="fill_inblank();"  >
                                   <?php echo get_phrase('fill_in_the_blanks'); ?>
                        </label>                    </div>
<!--                    <div class="col-md-3"> 
                        <label class="form-check-label">
                             <?php if($row['qtype_id']=='4')$chk4 = 'checked="checked"'; else $chk4="";?>
                            <input class="form-check-input" type="radio" 
                                   name="question_type" value="4" <?php echo $chk4; ?> id="question_type" onclick="subjective();" >
                                   <?php echo get_phrase('Subjective'); ?>
                        </label>
                    </div>-->
                </div>
            </div>

            <div class="panel-body" id="tabs" >
                <ul class="nav nav-tabs bordered" style="margin: 0px 0px 20px 0px;" id="tabs_list">
                    <li class="active">
                        <a href="#advance1" data-toggle="tab" >
                            <span class="visible-xs"><i class="entypo-users"></i></span>
                            <span class="hidden-xs"><?php echo get_phrase('question'); ?></span>
                            <input type="hidden" id="hidden"  value="0"/>
                        </a>
                    </li>
                    <li class="">
                        <a href="#advance2" data-toggle="tab" >
                            <span class="visible-xs"><i class="entypo-user"></i></span>
                            <span class="hidden-xs"><?php echo get_phrase('answer1'); ?></span>
                        </a>
                    </li>
                    <li class="">
                        <a href="#advance3" data-toggle="tab">
                            <span class="visible-xs"><i class="entypo-user"></i></span>
                            <span class="hidden-xs"><?php echo get_phrase('answer2'); ?></span>
                        </a>
                    </li>

                    <li class="">
                        <a href="#advance4" data-toggle="tab">
                            <span class="visible-xs"><i class="entypo-user"></i></span>
                            <span class="hidden-xs"><?php echo get_phrase('answer3'); ?></span>
                        </a>
                    </li>

                    <li class="">
                        <a href="#advance5" data-toggle="tab">
                            <span class="visible-xs"><i class="entypo-user"></i></span>
                            <span class="hidden-xs"><?php echo get_phrase('answer4'); ?></span>
                        </a>
                    </li>
                    <li class="">
                        <a href="#advance6" data-toggle="tab">
                            <span class="visible-xs"><i class="entypo-users"></i></span>
                            <span class="hidden-xs"><?php echo get_phrase('answer5'); ?></span>
                        </a>
                    </li>
                    <li class="">
                        <a href="#advance7" data-toggle="tab">
                            <span class="visible-xs"><i class="entypo-users"></i></span>
                            <span class="hidden-xs"><?php echo get_phrase('answer6'); ?></span>
                        </a>
                    </li>
                    <li class="">
                        <a href="#advance8" data-toggle="tab">
                            <span class="visible-xs"><i class="entypo-users"></i></span>
                            <span class="hidden-xs"><?php echo get_phrase('correct_answer'); ?></span>
                        </a>
                    </li>

                </ul>

                <div class="tab-content col-md-12">
                    <div class="tab-pane active" id="advance1">
                        <div class="row">    
                            <div class="col-xs-12">
                                <label for="field-1"><?php echo get_phrase('question'); ?>
                                    <span class="error" style="color: red;"> *</span></label>
                                <div class="form-group">
                                    <textarea class="form-control" rows="5" name="question" placeholder="Enter your Question" data-validate="required" data-message-required ="Please enter your Question ">
                                   <?php echo $row['question']; ?> </textarea>
                                </div>
                            </div>

                        </div>

                    </div>
                    
                    <div id="true_false" style="display:none;"> 
                         <?php if($row['true_false']=='True')$true = 'checked="checked"';else $true="";?>
                        <div class="col-md-3">  
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" 
                                       name="true_false_ques" value="True" <?php echo $true; ?> >
                                       <?php echo get_phrase('true'); ?>
                            </label> 
                        </div>
                        <?php if($row['true_false']=='False')$false = 'checked="checked"';else $false="";?>
                        <div class="col-md-3"> 
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" 
                                       name="true_false_ques" value="False" <?php echo $false; ?>>
                                       <?php echo get_phrase('false'); ?>
                            </label>
                        </div>
                    </div>

                     <div id="fill_blank" style="display:none;">
                        <div class="col-xs-12">
                            <label for="field-1"><?php echo get_phrase('blank_space'); ?>
                            </label>
                            <div class="form-group">
                                <input type="text" class="form-control" name="blank_space" placeholder="Blank Space" value="<?php echo $row['fill_blank'] ?>">
                            </div>
                        </div>
                    </div>
                    
                    <div class="tab-pane" id="advance2"> 
                        <div class="row">                            
                            <div class="col-xs-12">
                                <label for="field-1"><?php echo get_phrase('answer1'); ?>
                                    <span class="error" style="color: red;"> *</span></label>
                                <div class="form-group">
                                    <textarea class="form-control" rows="5" name="answer1" placeholder="Enter your Answer" data-validate="required" data-message-required ="Please enter your answer2 ">
                                   <?php echo $row['option1']; ?>
                                    </textarea>
                                </div>
                            </div>
                        </div>

                    </div>    

                    <div class="tab-pane" id="advance3">
                        <div class="row">
                            <div class="col-xs-12">
                                <label for="field-1"><?php echo get_phrase('answer2'); ?>
                                    <span class="error" style="color: red;"> *</span></label>
                                <div class="form-group">
                                    <textarea class="form-control" rows="5" name="answer2" placeholder="Enter your Answer" data-validate="required" data-message-required ="Please enter your Answer ">
                                  <?php echo $row['option2']; ?>
                                    </textarea>
                                </div>
                            </div> 
                        </div>
                    </div>           

                    <div class="tab-pane" id="advance4">
                        <div class="row">

                            <div class="col-xs-12">
                                <label for="field-1"><?php echo get_phrase('answer3'); ?>
                                    <span class="error" style="color: red;"> *</span></label>
                                <div class="form-group">
                                    <textarea class="form-control" rows="5" name="answer3" placeholder="Enter your Answer" data-validate="required" data-message-required ="Please enter your Answer ">
                                    <?php echo $row['option3']; ?>
                                    </textarea>

                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="tab-pane" id="advance5"> 
                        <div class="row">
                            <div class="col-xs-12">
                                <label for="field-1"><?php echo get_phrase('answer2'); ?>
                                    <span class="error" style="color: red;"> *</span></label>
                                <div class="form-group">
                                    <textarea class="form-control" rows="5" name="answer4" placeholder="Enter your Answer" data-validate="required" data-message-required ="Please enter your Answer ">
                                    <?php echo $row['option4']; ?>
                                    </textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="advance6">
                        <div class="row">
                            <div class="col-xs-12">
                                <label for="field-1"><?php echo get_phrase('answer5'); ?>
                                    <span class="error" style="color: red;"> *</span></label>
                                <div class="form-group">
                                    <textarea class="form-control" rows="5" name="answer5" placeholder="Enter your Answer" data-validate="required" data-message-required ="Please enter your Answer ">
                                    <?php echo $row['option5']; ?>
                                    </textarea>

                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="tab-pane" id="advance7">
                        <div class="row">
                            <div class="col-xs-12">
                                <label for="field-1"><?php echo get_phrase('answer6'); ?>
                                    <span class="error" style="color: red;"> *</span></label>
                                <div class="form-group">
                                    <textarea class="form-control" rows="5" name="answer6" placeholder="Enter your Answer" data-validate="required" data-message-required ="Please enter your Answer ">
                                    <?php echo $row['option6']; ?>
                                    </textarea>

                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="tab-pane" id="advance8">
                        <div class="row">
                            <?php 
                            $answr1='';
                             $answr2='';
                              $answr3='';
                               $answr4='';
                                $answr5='';
                                 $answr6='';
                            
                            $answer = $row['answer'];
                            $array =  explode(',', $answer);
                            foreach ($array as $answr) {
                            if($answr==1)
                                $answr1 = 'checked="checked"';
                                elseif($answr==2) 
                                $answr2 = 'checked="checked"';
                              elseif($answr==3) 
                                $answr3 = 'checked="checked"';
                              elseif($answr==4) 
                                $answr4 = 'checked="checked"';
                              elseif($answr==5) 
                                $answr5 = 'checked="checked"';
                              elseif($answr==6) 
                                $answr6 = 'checked="checked"';
                            }
                            ?>
                            
                            
                            
                            <div class="col-xs-12">
                                <label for="field-1"><?php echo get_phrase('correct_answer'); ?>
                                </label>
                                <div class="form-group">
                                    <input type="checkbox" name="correct_answer[]" id="correct_answer[]" value="1" <?php echo $answr1; ?> ><label for="field-1"><?php echo get_phrase('answer1'); ?>
                                    </label>

                                </div>
                                <div class="form-group">
                                    <input type="checkbox" name="correct_answer[]" id="correct_answer[]" value="2" <?php echo $answr2; ?>><label for="field-1"><?php echo get_phrase('answer2'); ?>
                                    </label>

                                </div>
                                <div class="form-group">
                                    <input type="checkbox" name="correct_answer[]" id="correct_answer[]" value="3" <?php echo $answr3; ?>><label for="field-1"><?php echo get_phrase('answer3'); ?>
                                    </label>

                                </div>
                                <div class="form-group">
                                    <input type="checkbox" name="correct_answer[]" id="correct_answer[]" value="4" <?php echo $answr4; ?>><label for="field-1"><?php echo get_phrase('answer4'); ?>
                                    </label>

                                </div>
                                <div class="form-group">
                                    <input type="checkbox" name="correct_answer[]" id="correct_answer[]" value="5" <?php echo $answr5; ?>><label for="field-1"><?php echo get_phrase('answer5'); ?>
                                    </label>

                                </div>
                                <div class="form-group">
                                    <input type="checkbox" name="correct_answer[]" id="correct_answer[]" value="6" <?php echo $answr6; ?>><label for="field-1"><?php echo get_phrase('answer6'); ?>
                                    </label>

                                </div>
                            </div>
                        </div>

                    </div>

                       <div class="row">    
                            <div class="col-xs-12">
                                <label for="field-1"><?php echo get_phrase('explanation'); ?>
                                    <span class="error" style="color: red;"> *</span></label>
                                <div class="form-group">
                                    <textarea class="form-control" rows="5" name="explanation" placeholder="Enter your Explanation" data-validate="required" data-message-required ="Please enter your Explanation ">
                                   <?php echo $row['explanation']; ?>
                                    </textarea>

                                </div>
                            </div>

                        </div>
                    <div class="row">
<!--                        <div class="col-sm-6 col-xs-12">
                            <label for="field-2"><?php echo get_phrase('subject'); ?><span class="error" style="color: red;"> *</span></label>
                            <div class="form-group">
                                <input type="hidden" name="class_id" value="<?php echo $class_id;?>">                                
                                   <select class="form-control"  data-validate="required" data-message-required ="Please select your subject " name="subject_id">
                                    <option value="">Select Subject</option>
                                    
                        <?php
                   
                        foreach ($subject as $row1):
                            if($row1['subject_id']==$row['subject_id']){ ?>
                                    <option value="<?php echo $row1['subject_id']; ?>" selected=""> <?php echo $row1['name']; ?> </option>
                                    
                            <?php }else {?> <option value="<?php echo $row1['subject_id']; ?>">
                            <?php echo $row1['name']; ?>
                            </option>
                            <?php }
                            endforeach; ?>
                                </select>
                            </div>   
                        </div>-->
                        <div class="col-sm-6 col-xs-12">
                            <label for="field-2"><?php echo get_phrase('hint'); ?><span class="error" style="color: red;"> *</span></label>
                            <div class="form-group">
                                <input type="text" required="required" class="form-control" name="hint"  placeholder="Hint"  value="<?php echo $row['hint'];?>" >

                            </div>   
                        </div>
                            <div class="col-sm-4 col-xs-12">
                            <label for="field-2"><?php echo get_phrase('order'); ?><span class="error" style="color: red;"> *</span></label>
                            <div class="form-group">
                                <input type="number" class="form-control" name="order"  placeholder="Order" required="required"  value="<?php echo $row['order'] ?>" >
                            </div>   
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 col-xs-12">
                            <label for="field-2"><?php echo get_phrase('marks'); ?><span class="error" style="color: red;"> *</span></label>
                            <div class="form-group">
                                <input type="number" required="required" class="form-control" name="marks"  placeholder="Marks"  value="<?php echo $row['marks'];?>" >

                            </div> 
                        </div>
                        <div class="col-sm-4 col-xs-12">
                            <label for="field-2"><?php echo get_phrase('negative_marks'); ?><span class="error" style="color: red;"> *</span></label>
                            <div class="form-group">
                                <input type="number" class="form-control" name="negative_marks"  placeholder="Negative Marks"  value="<?php echo $row['negative_marks'];?>" >

                            </div>   
                        </div>
                        <div class="col-sm-4 col-xs-12">
                            <label for="field-2"><?php echo get_phrase('difficulty_level'); ?><span class="error" style="color: red;"> *</span></label>
                            <div class="form-group">
                                <?php
                               
                                $dlchck1='';
                                $dlchck2='';
                                $dlchck3='';
                              
                                if($row['diff_id']=='1') 
                                       $dlchck1='selected=""';
                                      elseif($row['diff_id']=='2')
                                       $dlchck2='selected=""';
                                       elseif($row['diff_id']=='3')
                                       $dlchck3='selected=""';
                                       else{
                                           }
                                    
                                    ?>
                                <select data-style="form-control" data-live-search="true" class="selectpicker" name="difficulty_level" required="required" data-validate="required" data-message-required ="Please select difficult level" >
                                    <option value=""><?php echo get_phrase('select'); ?></option>
                                    <option value="1" <?php echo $dlchck1; ?>><?php echo get_phrase('easy'); ?></option>
                                    <option value="2" <?php echo $dlchck2; ?>><?php echo get_phrase('medium'); ?></option>
                                    <option value="3" <?php echo $dlchck3; ?>><?php echo get_phrase('difficult'); ?></option>
                                </select>
                            </div> 
                        </div>
                        <input type="hidden" name="class_id"   value="<?php echo $class_id ?>" >
                        <input type="hidden" name="subject_id" value="<?php echo $subject_id ?>" >
                    </div> 
                   <div class="btn_for_sm" id="button_show1" >   
                        <button type="submit" onclick="return validate(this.form);" class="btn btn-primary tab_btn"><?php echo get_phrase('save'); ?></button>
                    </div>
                    <div class="btn_for_sm" id="button_show2" style="display:none;">   
                        <button type="submit" class="btn btn-primary tab_btn"><?php echo get_phrase('save'); ?></button>
                    </div>
                </div>
            </div>
        </div>
     
    </div>
</div>
<?php echo form_close(); ?>
<?php endforeach; ?>
<!--<script src="assets/new_assets/js/google_api.js"></script>
<script src="assets/new_assets/js/locationpicker.jquery.min.js"></script>
<script src="assets/new_assets/js/jquery-ui.js"></script>
<script src="assets/new_assets/js/jquery.validate.min.js"></script>
<script src="assets/new_assets/js/bootstrap-formhelpers.min.js"></script>
<script src="assets/new_assets/css/bootstrap-formhelpers.min.css"></script>-->

<script type="text/javascript">
                                jQuery(document).ready(function () {
                                    $(".numeric").numeric();
                                });
</script>

<script type="text/javascript">
   
    $(function () {
        $(".datepicker").datepicker({dateFormat: "dd/mm/yy",
            changeMonth: true,
            changeYear: true,
            endDate: '+0d',
            autoclose: true
        });
    });
    function agecalculate() {
        var dob = $(".datepicker").val();
        var now = new Date();
        var d = new Date();
        var year = d.getFullYear() - 3;
        d.setFullYear(year);
        var birthdate = dob.split("/");
        var born = new Date(birthdate[2], birthdate[1] - 1, birthdate[0]);
        age = get_age(born, now);
        if (age <= 3)
        {
            alert("Age should be greater than or equal to 3");
            return false;
        }
    }
    function get_age(born, now) {
        var birthday = new Date(now.getFullYear(), born.getMonth(), born.getDate());
        if (now >= birthday)
            return now.getFullYear() - born.getFullYear();
        else
            return now.getFullYear() - born.getFullYear() - 1;
    }

    function get_class_sections(class_id) {
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?school_admin/get_class_section/' + class_id,
            success: function (response)
            {
                jQuery('#section_selector_holder').html(response).selectpicker('refresh');
            }
        });
    }

    function checkemail() {
        var email = $("#studentemail").val();
        if (email) {
            $.ajax({
                type: 'post',
                url: '<?php echo base_url(); ?>index.php?school_admin/get_class_students_mass/',
                data: {user_name: name},
                success: function (response) {
                    $('#name_status').html(response);
                    if (response == "OK") {
                        return true;
                    } else {
                        return false;
                    }
                }
            });
        } else {
            $('#name_status').html("");
            return false;
        }
    }
</script>
<script>
    function allnumeric(inputtxt)
    {
        var numbers = /^[0-9]+$/;
        if (inputtxt.value.match(numbers))
        {
            alert('Your Registration number has accepted....');
            document.form1.text1.focus();
            return true;
        } else
        {
            alert('Please input numeric characters only');
            document.form1.text1.focus();
            return false;
        }
    }
    function Validate()
    {
        var phone = $("#phone");
        if (phone.val().length > 10) {
            $('#error_phone').html('Maximum 10 digits are allowed');
            return false;

        } else if (phone.val().length < 7) {
            $('#error_phone').html('Invalid contact number');

            $("#hidden").val('1');
            return false;
        } else if (isNaN(phone.val())) {
            $('#error_phone').html('Enter a valid phone number');
            return false;

        } else {
            $('#error_phone').html('');
            return true;
        }
    }
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var phone = $("#phone");
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            $('#error_phone').html('Enter numeric value only');
            $("#phone").val('');

            $("#hidden").val('1');

            //return false;

        } else if (phone.val().length > 10) {
            $('#error_phone').html('Maximum 10 digits are allowed');
            //return false;
            $("#hidden").val('1');

        } else if (phone.val().length < 7) {
            $('#error_phone').html('Invalid contact number');
            // return false;
            $("#hidden").val('1');

        } else {
            $('#error_phone').html('');
            $("#hidden").val('0');
            return true;
        }
    }
</script>

<script>
     $("#error_msg").hide("");
    function validateChecks() {
		var chks = document.getElementsByName('correct_answer[]');
		var checkCount = 0;
		for (var i = 0; i < chks.length; i++) {
			if (chks[i].checked) {
				checkCount++;
			}
		}
		if (checkCount < 1) {
			return false;
		}
		return true;
	}
	function validate(form) {
		if(validateChecks()==false) {
		$("#error_msg").show();
                $("#error_msg").focus();
                 return false;
		}
		return true;
	}

 //   question type check
   var question_type  = $("#question_type:checked").val(); 

   if(question_type==1){
    $("#tabs_list").show();
        $("#true_false").hide();
        $("#fill_blank").hide();
   }
   else if(question_type==2){
   $("#button_show2").show();
     $("#button_show1").hide();
     
        //alert("bdhfadsf");
        $("#tabs_list").hide();
        $("#true_false").show();
        $("#advance1").show();
        $("#fill_blank").hide();
        $("#advance8").hide();
   }
   else if(question_type==3){
    $("#button_show2").show();
     $("#button_show1").hide();
     
        $("#advance1").show();
        $("#true_false").hide();
        $("#tabs_list").hide();        
        $("#fill_blank").show();
        $("#advance8").hide();
   }
   else if(question_type==4){
    $("#button_show2").show();
     $("#button_show1").hide();
     
        $("#advance1").show();
        $("#true_false").hide();
        $("#tabs_list").hide();
        $("#fill_blank").hide();  
        $("#advance8").hide();
   }
   else{
   }
   
   
   
       function view_true_false() {
        
     $("#button_show2").show();
     $("#button_show1").hide();
     
        //alert("bdhfadsf");
        $("#tabs_list").hide();
        $("#true_false").show();
        $("#advance1").show();
        $("#fill_blank").hide();
        $("#advance8").hide();
        
        
    }

    function show_tabs_list() {
  
        $("#tabs_list").show();
        $("#true_false").hide();
        $("#fill_blank").hide();
        //$("#advance8").show();
    }

    function fill_inblank() {
         $("#button_show2").show();
     $("#button_show1").hide();
     
        $("#advance1").show();
        $("#true_false").hide();
        $("#tabs_list").hide();        
        $("#fill_blank").show();
        $("#advance8").hide();
    }
    function subjective() {
         $("#button_show2").show();
     $("#button_show1").hide();
     
        $("#advance1").show();
        $("#true_false").hide();
        $("#tabs_list").hide();
        $("#fill_blank").hide();  
        $("#advance8").hide();
        
    }
    
</script>

<style>
.alert {
    padding: 20px;
    background-color: #f44336;
    color: white;
}

.closebtn {
    margin-left: 15px;
    color: white;
    font-weight: bold;
    float: right;
    font-size: 22px;
    line-height: 20px;
    cursor: pointer;
    transition: 0.3s;
}

.closebtn:hover {
    color: black;
}

</style>
