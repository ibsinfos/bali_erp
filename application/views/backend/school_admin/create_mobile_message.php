<div class="col-md-12 white-box AfterSend">
    <p class="error p_error">Please select atleast one parent</p>
    <p class="error s_error">Please select atleast one student</p>
    <p class="error t_error">Please select atleast one teacher</p>
    <p class="error par_msg_error">Please enter parent message</p>
    <p class="error stu_msg_error">Please enter student message</p>
    <p class="error tea_msg_error">Please enter teacher message</p>
    <div class="col-sm-4 loader2">
        <center id="loader2">Please wait while processing ......</center>
    </div>
</div>

<div class="col-md-12 white-box">
    <div class="sttabs tabs-style-flip"><?php if(isset($receiver_type)){?>
        <nav>
            <ul><?php if(in_array('1', $receiver_type)){?>
                <li class="<?php if($receiver_type[0]=='1'){ echo 'active'; }?>">
                    <a href="#parent" class="sticon fa fa-list"><span class="hidden-xs"><?php echo get_phrase('Parent'); ?></span></a>
                </li><?php } if(in_array('2', $receiver_type)){ ?>
                <li class="<?php if($receiver_type[0]=='2'){ echo 'active'; }?>">
                    <a href="#student" class="sticon fa fa-list">
                        <span class="hidden-xs"><?php echo get_phrase('student'); ?></span>
                    </a>
                </li><?php } if(in_array('3', $receiver_type)){?>
                <li class="<?php if($receiver_type[0]=='3'){ echo 'active'; }?>">
                    <a href="#teacher" class="sticon fa fa-list">
                        <span class="hidden-xs"><?php echo get_phrase('teacher'); ?></span>
                    </a>
                </li><?php }?>
            </ul>
        </nav><?php }?> <?php if(isset($receiver_type)){?>
<?php echo form_open(base_url() . 'index.php?school_admin/custom_message/send', array('class' => 'form', 'id' => 'SendMessage')); ?>
        <div class="content-wrap"><?php if(in_array('1', $receiver_type)){?>      
            <section id="parent">            
                <div class="row">
                    <div class="col-md-6">
                        <label class="control-label"><?php echo get_phrase('recipient'); ?></label>
                        <input type="hidden" name="reciever[]" id="reciever2" value="">
            <select class="selectpicker" multiple data-style="form-control" id="parent_reciever" onchange="get_value_parent()" name="parent_reciever[]" data-live-search="true" data-actions-box="true">
<?php if(count($parents)){ foreach ($parents as $parent) { ?>
                            <option value="<?php echo $parent['parent_id']; ?>"><?php echo $parent['parent_fullname']; ?></option>
<?php } } ?>
                        </select>
                    </div>

                    <div class="col-md-12"><br>
                        <label for="description"><?php echo get_phrase('message');?><span class="error" style="color: red;">*</span></label>
                        <textarea class="form-control" id="parent_message" rows="8" name="parent_message" placeholder="<?php echo get_phrase('write_your_message'); ?>"></textarea>
                    </div>
                     <div class="col-xs-12 col-md-4 setDate_time">
                        <label><?php echo get_phrase('set_date_time'); ?><span class="error" style="color: red;"> *</span></label>
                       <div class="input-group date datetimepicker1">
    			    <span class="input-group-addon">
    				<span class="glyphicon glyphicon-calendar"></span>
    			    </span>
                           <input type="text" name="set_date_time" class="form-control date-close-start1" id="set_date_time" onchange="set_dateto_all();">
                        </div>
                    </div>

                </div>                        
            </section><?php } if(in_array('2', $receiver_type)){?>

            <section id="student">  
                <div class="row">
                    <div class="col-md-6">
                        <label class="control-label"><?php echo get_phrase('recipient'); ?></label>
                        <input type="hidden" name="reciever[]" id="reciever" value="">
            <select class="selectpicker" multiple data-style="form-control" id="student_reciever" onchange="get_value_student()" name="student_reciever[]" data-live-search="true" data-actions-box="true">
<?php if(count($students)){ foreach ($students as $student){ ?>
                            <option value="<?php echo $student['student_id']; ?>"><?php echo $student['student_fullname']; ?></option><?php } } ?>
                        </select>
                    </div>
                    <div class="col-md-12"><br>
                        <label for="description"><?php echo get_phrase('message');?><span class="error" style="color: red;">*</span></label>
                        <textarea class="form-control" id="student_message" rows="8" name="student_message" placeholder="<?php echo get_phrase('write_your_message'); ?>"></textarea>
                    </div>
                     <div class="col-xs-12 col-md-4 setDate_time">
                        <label><?php echo get_phrase('set_date_time'); ?><span class="error" style="color: red;"> *</span></label>
                       <div class="input-group date datetimepicker1">
    			    <span class="input-group-addon">
    				<span class="glyphicon glyphicon-calendar"></span>
    			    </span>
                           <input type="text" name="set_date_time1" class="form-control date-close-start1" id="set_date_time1" onchange="set_dateto_all1();">
                        </div>
                    </div>
                </div>                            
            </section><?php } if(in_array('3', $receiver_type)){ ?>

            <section id="teacher">  
                <div class="row">
                    <div class="col-md-6">
                        <label class="control-label"><?php echo get_phrase('recipient'); ?></label>
                        <input type="hidden" name="reciever[]" id="reciever1" value="">
            <select class="selectpicker" multiple data-style="form-control" id="teacher_reciever" onchange="get_value_teacher()" name="teacher_reciever[]" data-live-search="true" data-actions-box="true">
<?php if(count($teachers)){ foreach ($teachers as $teacher){ ?>
                            <option value="<?php echo $teacher['teacher_id']; ?>"><?php echo $teacher['teacher_fullname']; ?></option><?php } } ?>
                        </select>
                    </div>

                    <div class="col-md-12"><br>
                        <label for="description"><?php echo get_phrase('message');?><span class="error" style="color: red;">*</span></label>
                        <textarea id="teacher_message" class="form-control" rows="8" name="teacher_message" placeholder="<?php echo get_phrase('write_your_message'); ?>"></textarea>
                    </div>
                    <div class="col-xs-12 col-md-4 setDate_time">
                        <label><?php echo get_phrase('set_date_time'); ?><span class="error" style="color: red;"> *</span></label>
                       <div class="input-group date datetimepicker1">
    			    <span class="input-group-addon">
    				<span class="glyphicon glyphicon-calendar"></span>
    			    </span>
                           <input type="text" name="set_date_time2" class="form-control date-close-start1" id="set_date_time2" onchange="set_dateto_all2();">
                        </div>
                    </div>
                </div>         
            </section> <?php } ?>
        </div>
        <div class="col-md-12 text-right">
            <button type="button" id="send_later" class="fcbtn btn btn-danger btn-outline btn-1d" onclick="set_time_later();"><?php echo get_phrase('send_later');?></button>
            <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" id="submit_button"><?php echo get_phrase('send');?></button>
        </div>
        <?php echo form_close(); ?> <?php } ?>
    </div>
</div>

<script type="text/javascript">
    (function () {
        [].slice.call(document.querySelectorAll('.sttabs')).forEach(function (el) {
            new CBPFWTabs(el);
        });

$('.selectpicker').selectpicker({dropupAuto: false,selectAllValue: 'multiselect-all'});

    })();
</script>

<script type="text/javascript">
    $('.setDate_time').hide();
    $('.setDate_time').hide();
    $('.setDate_time').hide();
    
    function set_time_later(){
    $('.setDate_time').show();
    $('.setDate_time').show();
    $('.setDate_time').show(); 
    $('#send_later').hide();
    document.getElementById('submit_button').innerHTML = "submit";
    }
    function get_value_student() {
        var student_id = []; 
        $('#student_reciever :selected').each(function(i, selected){ 
        student_id[i] = $(selected).val(); 
        });
        $('#reciever').val(student_id);           
    }

    function get_value_parent() {
        var parent_id = []; 
        $('#parent_reciever :selected').each(function(i, selected){ 
        parent_id[i] = $(selected).val(); 
        });
        $('#reciever2').val(parent_id);           
    }
    function get_value_teacher() {
        var teacher_id = []; 
        $('#teacher_reciever :selected').each(function(i, selected){ 
        teacher_id[i] = $(selected).val(); 
        });
        $('#reciever1').val(teacher_id);           
    }
    debugger;
    var SendMessageFrm = $('#SendMessage');
    debugger;
    SendMessageFrm.submit(function (e) {

        var ParentFlag = TotalParent = StudentFlag = TotalStudent = TeacherFlag = TotalTeacher = 0;
debugger;
        ParentFlag = '<?php echo isset($receiver_type[0])?$receiver_type[0]:'0';?>';
        StudentFlag = '<?php echo isset($receiver_type[1])?$receiver_type[1]:'0';?>';
        TeacherFlag = '<?php echo isset($receiver_type[2])?$receiver_type[2]:'0';?>';
debugger;
        if(ParentFlag == 1){
            var TotalParent =$('#parent_reciever :selected').length;
            debugger;
            if(TotalParent == 0){
                $('.AfterSend').show();
                $('.p_error').show();                
                return false;
            }else{                
                $('.p_error').hide();
                $('.AfterSend').hide();

                var par_msg= $('#parent_message').val();
                if(par_msg!=''){
                    $('.par_msg_error').hide();
                     $('.AfterSend').hide();
                }else{
                    $('.AfterSend').show();
                    $('.par_msg_error').show();
                    return false;    
                }
            }    
        }

        if(StudentFlag == 2){
            var TotalStudent =$('#student_reciever :selected').length;
            debugger;
            if(TotalStudent == 0){
                $('.AfterSend').show();
                $('.s_error').show();
                return false;
            }else{
                $('.s_error').hide();
                $('.AfterSend').hide();

                var stu_msg= $('#student_message').val();
                if(stu_msg!=''){
                    $('.stu_msg_error').hide();
                     $('.AfterSend').hide();
                }else{
                    $('.AfterSend').show();
                    $('.stu_msg_error').show();
                    return false;    
                }
            }     
        }

        if(TeacherFlag == 3){
            var TotalTeacher =$('#teacher_reciever :selected').length;
            debugger;    
            if(TotalTeacher == 0){
                $('.AfterSend').show();
                $('.t_error').show();
                return false;
            }else{
                $('.t_error').hide();
                $('.AfterSend').hide();

                var tea_msg= $('#teacher_message').val();
                if(tea_msg!=''){
                    $('.tea_msg_error').hide();
                     $('.AfterSend').hide();
                }else{
                    $('.AfterSend').show();
                    $('.tea_msg_error').show();
                    return false;    
                }
            } 
        }

        $.ajax({
            type: SendMessageFrm.attr('method'),
            url: SendMessageFrm.attr('action'),
            data: SendMessageFrm.serialize(),

            beforeSend: function(){
                $('.AfterSend').show();
                $('#loader2').show();
            },

            success: function (data) {
                debugger;
                if(data){  
                debugger;                  
                    $('#loader2').hide();
                    $('.loader2').html('Message sent succesfully');
                    location.reload();
                }               
            },
            error: function (data) {
                console.log('An error occurred.');
                console.log(data);
            },
        }); 
        return false; 
    });

      $(function () {
            $('.datetimepicker1').datetimepicker({
                startDate:new Date(),
                format: 'yyyy-mm-dd hh:ii'
            });
        });
        
        
        function set_dateto_all(){
           var time_val = $('#set_date_time').val();
           $('#set_date_time1').val(time_val);
           $('#set_date_time2').val(time_val);
        }
         function set_dateto_all1(){
           var time_val = $('#set_date_time1').val();
           $('#set_date_time').val(time_val);
           $('#set_date_time2').val(time_val);
        }
         function set_dateto_all2(){
           var time_val = $('#set_date_time2').val();
           $('#set_date_time').val(time_val);
           $('#set_date_time1').val(time_val);
        }
        
</script>