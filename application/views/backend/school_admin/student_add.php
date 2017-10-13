<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('Student_admission_Form'); ?></h4>
    </div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li><?php echo get_phrase('student'); ?>
                <ul>                    
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/student_information"><?php echo get_phrase('student_information'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/student_promotion"><?php echo get_phrase('student_promotion'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/map_students_id"><?php echo get_phrase('map_students_id'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/student_fee_configuration"><?php echo get_phrase('student_fee_setting'); ?></a></li>
                </ul>
            </li>
            <li class="active">
                <?php echo $page_title; ?>
            </li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>

<?php
$msg = $this->session->flashdata('flash_validation_error');
if ($msg) {
    ?>        
    <div class="alert alert-danger">
        <?php echo $msg; ?>
    </div>
<?php } ?>
<div class="panel panel-danger block6" data-step="5" data-intro="For Information" data-position='bottom'>
    <div class="panel-heading"> Student Admission Notes
        <div class="pull-right"><a href="#" data-perform="panel-collapse"><i class="ti-minus"></i></a> <a href="#" data-perform="panel-dismiss"><i class="ti-close"></i></a> </div>
    </div>
    <div class="panel-wrapper collapse in" aria-expanded="true">
        <div class="panel-body">
            <p> Admitting new students will automatically create an enrollment to the selected class in the running session. Please check and recheck the informations you have inserted because once you admit new student, you won't be able to edit his/her class, roll, section without promoting to the next session.</p>
        </div>
    </div>
</div>


<div class="row">

    <?php echo form_open(base_url() . 'index.php?school_admin/student/create/', array('class' => 'form-groups-bordered validate', 'enctype' => 'multipart/form-data', 'id' => 'addStudentForm')); ?>
        <div class="white-box">
            <section>
                <div class="sttabs tabs-style-flip">
                    <nav >
                        <ul>
                            <?php
                                $i = 0; 
                                $arrVal     = array();
                                $arrValid   = array();
                                $arrField   = array();
                               
                                foreach($arrGroups as $key => $value)
                                {
                                    if(strstr($value, "||||"))
                                    {
                                        $arrVal = explode("||||", $value);
                                    }        
                                    $group_name     = !(empty($arrVal[0])) ? $arrVal[0] : "";
                                    $group_image    = !(empty($arrVal[1])) ? $arrVal[1] : "";
                                    $group_intro    = !(empty($arrVal[2])) ? $arrVal[2] : "";
                                    $group_section  = !(empty($arrVal[3])) ? $arrVal[3] : "";
                                    $group_active   = (strtolower($arrVal[3]) == "y") ? "active" : "";
                                    $i++;
                                    if($i == 1)
                                        $class_group = "active";
                                    else
                                        $class_group = "";
                                  
                                    echo "<li id='tab".$i."' class='$class_group'><a  data-toggle='tab' class='$group_image'>".get_phrase($group_name)."</a></li>";
                                    
                                 }    
                                echo "</ul></nav>";
                              
                              echo "<div class='content-wrap'>";
                              foreach($arrGroups as $key => $value)
                              {
                                 
                                  $count = 0;
                                  if(strstr($value, "||||"))
                                    {
                                        $arrVal = explode("||||", $value);
                                    }        
                                    $group_section  = !(empty($arrVal[3])) ? $arrVal[3] : "";
                                    echo "<section id='$group_section'>";
                                   
                                    foreach($arrDbField as $db_key => $db_field)
                                    {    
                                       
                                        $keyArr =  explode("_", $db_key);
                                       
                                        if($keyArr[0] == $key)
                                        {    
                                            $count +=1;
                                            if($count == 1 || (($count-1)%3) == 0)
                                                echo "<div class='row'>";
                                            
                                                
                                                if(in_array($db_field, array_keys($arrValidation[$key])))
                                                {        
                                                   $valid = $arrValidation[$key][$db_field];
                                                    
                                                    if(strstr($valid, "?"))
                                                    {
                                                        $arrValid               = explode("?", $valid);
                                                        $form_validation        = (!empty($arrValid[0])) ? $arrValid[0] : "";
                                                        $form_validation_type   = (!empty($arrValid[1])) ? $arrValid[1] : "";
                                                    }        


                                                    $field_val = $arrFieldValue[$key][$db_field];
                                                     if(strstr($field_val, "?"))
                                                     {
                                                         $arrField           =        explode("?", $field_val);
                                                         $field_type         =       (!empty($arrField[0])) ? $arrField[0] : "";
                                                         $field_values       =       (!empty($arrField[1])) ? $arrField[1] : "";
                                                     }
                                                    $label = $arrLabel[$key][$db_field];
                           $ajax_event = '';
                           if(!empty($arrAjaxEvent[$key][$db_field]))
                               $ajax_event = $arrAjaxEvent[$key][$db_field];
                           $pattern = '';
                           
                           switch($form_validation_type)
                           {
                               case 'alphabetic';
                                   $pattern = "^[A-Za-z -]+$";
                               break;
                               case 'numeric':
                                   $pattern = "\d*";
                               break;
                               case 'tel':
                                   $pattern = "\d*";
                               break;

                              // case 'email':
                                //   $pattern = "[a-zA-Z0-9._\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,4}";
                               //break;
                               default:
                               $pattern = '';
                           break;    
                       }
                       if(!empty($pattern))
                           $pattern = "pattern = '$pattern'";
                       else
                           $pattern = '';
                        
                       $place_holder = '';
                         $class = 'ti-user';
                         $place_holder = $arrPlaceHolder[$key][$db_field];
                         $class = $arrClass[$key][$db_field];
                         $required = ''; 
                                                    switch($field_type)
                                                    { 
                                                        
                                                        case 'button':
                                                        if($key == 1)
                                                        {    
                                                        echo "<br><div class='col-sm-12 form-group text-left'>
                                                            <button type='button' id='$db_field' 
                                                                class='fcbtn btn btn-danger btn-outline btn-1d pull-right'>


                                                                ".get_phrase('next')." <i class='fa fa-angle-right'></i>
                                                            </button>
                                                        </div>";
                                                        }
                                                        else {
                                                            
                                                            echo "<br>
                                                            <div class='col-sm-12 form-group text-left'>
                                                                <button type='button' id='$db_field' 
                                                                class='fcbtn btn btn-danger btn-outline btn-1d pull-right'>


                                                                ".get_phrase('next')." <i class='fa fa-angle-right'></i>
                                                            </button>
                                                                <button type='button' id='bck_$key' 
                                                                class='fcbtn btn btn-danger btn-outline btn-1d pull-right'>


                                                                ".get_phrase('back')." <i class='fa fa-angle-left'></i>
                                                            </button>&nbsp;&nbsp;&nbsp;&nbsp;
                                                            
                                                            
                                                        </div>";
                                                            
                                                        }
                                                       break;     
                                                        case 'stopgap':
                                                           echo  "<div class='col-sm-4 form-group text-left'>
                                                                    <label for='field-1' class='control-label'>
                                                                    ".get_phrase($label);
                                                            if(strtolower($form_validation) == "m")
                                                                    echo "<span class='error mandatory'> *</span></label>";
                                                            else
                                                                       echo "</label>";
                                                            echo "<div class='input-group'>
                                                                    <input type='hidden' id='parent' class='form-control' name='parent' value=''>
                                                                    <input type='text' id='parent_email' class='form-control' name='parent_email  data-validate='required' data-message-required='Please select parent details from the popup window' disabled>

                                                                    <span class='input-group-btn' data-step='12' data-intro='From Here you can select parent' data-position='right'>
                                                                    <a href='#' class='btn fileinput-exists btn-block btn-danger' data-dismiss='fileinput' onclick=\"showAjaxModal('".base_url('index.php?modal/popup/modal_parent/')."')\">Select Parent</a>                                                          
                                                                </span>
                                                                </div></div>";
                                                       break;    
                                                        case 'text' :
                                  echo "<div class='col-sm-4 form-group text-left'>
                                            <label for='field-1' class='control-label'>".get_phrase($label);
                                   if(strtolower($form_validation) == "m")
                                    {    
                                        echo "<span class='error mandatory'> *</span></label>";
                                        $required = "required";
                                    }
                                    else
                                         echo "</label>";
                                     echo   "<div class='input-group'>
                                                <div class='input-group-addon'>
                                                    <i class='$class'></i>
                                                </div>";
                                        echo "<input type='$field_type' class='form-control' id='$db_field' name='$db_field'
                                        $pattern placeholder = '$place_holder' 
                                        data-message-required='Enter Value' $required> 
                                        </div>";
                                       echo "</div>";
                                   break;
                                   case 'tel' :
                                     echo "<div class='col-sm-4 form-group text-left'>
                                               <label for='field-1'>".get_phrase($label);
                                       if(strtolower($form_validation) == "m")
                                       {    
                                               echo "<span class='error mandatory'> *</span></label>";
                                               $required = "required";

                                       }
                                       else
                                                  echo "</label>";
                                     echo   "<div class='input-group'>
                                                   <div class='input-group-addon'>
                                                       <i class='ti-user'></i>
                                                   </div>";
                                     echo "<input type='$field_type' class='form-control' id='$db_field' name='$db_field'
                                           data-validate='$form_validation_type' 
                                           data-message-required='Enter Value' $required> 
                                           </div>";
                                       echo "</div>";
                                   break;
                                   case 'date':
                                                echo "
                                           <div class='col-sm-4 form-group text-left'>
                                               <label for='field-1'>".
                                                   get_phrase($label);
                                             if(strtolower($form_validation) == "m")
                                               {    
                                                   echo "<span class='error mandatory'> *</span></label>";
                                                   $required = "required";

                                               }
                                              else
                                                  echo "</label>";
                                           echo "<div class='input-group'>
                                               <div class='input-group-addon'><i class='icon-calender'></i>
                                               </div>";
                                          
                                           echo "<input type='text' class='form-control datepicker' name='$db_field' "
                                                   . "id='$db_field' placeholder='' data-validate='$form_validation_type' data-start-view='2' $required>"

                                               ."</div>";
                                           
                                           echo "</div>";
                                       break;        
                                       case 'drop' :
                                           $arrMain = array();
                                           $arr = array();
                                           if(!empty($field_values))
                                           {
                                               if($field_values == "query")
                                               {
                                                 if(isset($arrDynamic[$key][$db_field]))
                                                       $arrMain = $arrDynamic[$key][$db_field];
                                               }    
                                               else
                                               {    
                                                   if($field_values == "ajax_child")
                                                   {}
                                                   else
                                                   {    
                                                       $arr =  explode(",", $field_values);
                                                       foreach($arr as $val)
                                                       {
                                                          $arrInner =  explode("=>", $val);
                                                          $arrMain[$arrInner[0]] = $arrInner[1];
                                                       }
                                                   }   
                                               }   
                                             }    

                                           echo "<div class='col-sm-4 form-group text-left'>
                                           <label for='control-label'>".
                                               get_phrase($label);
                                          if(strtolower($form_validation) == "m")
                                           {    
                                                   echo "<span class='error mandatory'> *</span></label>";
                                                   $required = "required = 'required'";
                                           }
                                           else
                                               echo "</label>";        

                                           echo "<select class='form-control' data-style='form-control' data-container='body'  name='$db_field' id='$db_field' $required "


                                                   .  $ajax_event.">".
                                               "<option value=''>Select</option>";

                                           foreach($arrMain as $select_key => $select_value)
                                           {
                                               echo "<option value = '$select_key'>$select_value</option>";
                                           }     
                                         echo "</select>";      
                                         echo "</div>";
                                       break;
                                       case 'email' :
                                         echo "<div class='col-sm-4 form-group text-left'>
                                                   <label for='field-1'>".get_phrase($label);
                                          if(strtolower($form_validation) == "m")
                                           {    
                                                   echo "<span class='error mandatory'> *</span></label>";
                                                   $required = "required";

                                           }
                                           else
                                                 echo "</label>";
                                               echo   "<div class='input-group'>
                                                             <div class='input-group-addon'>
                                                                 <i class='$class'></i>
                                                             </div>";
                                               echo "<input type='$field_type' class='form-control' id='$db_field' name='$db_field'
                                                     data-validate='$form_validation_type'  placeholder = '$place_holder'  $required
                                                     data-message-required='Enter Value' $form_validation_type > 
                                                     </div>";

                                               echo "</div>";
                                           break;
                                           case 'installment' :

                                               echo "<div class='col-sm-4 form-group text-left'>
                                               <label for='control-label'>".
                                                   get_phrase($label);
                                               if(strtolower($form_validation) == "m")

                                           {    
                                                   echo "<span class='error mandatory'> *</span></label>";
                                                   $required = "required = 'required'";
                                           }
                                           else

                                               echo "</label>"; 
                                                      
                                               echo "<select class='form-control' data-style='form-control' name='$db_field'"
                                                       . " id='$db_field' "
                              . "data-validate='$form_validation_type' $required data-message-required='Select' $ajax_event>
                                                   <option value=''>Select</option>";


                                           echo "<select class='form-control' data-style='form-control' data-container='body'  name='$db_field' id='$db_field' $required "


                                                   .  $ajax_event.">".
                                               "<option value=''>Select</option>";
                                                   foreach($arrInstallment[$field_values] as $row)
                                                   {
                                                       echo "<option value = '".$row['id']."'>".$row['installment_name']."</option>";
                                                   }     
                                                 echo "</select>";      
                                                 echo "</div>";

                                           break;
                                           case 'hidden' :
                                               echo "<input type='hidden' name='$db_field' id='$db_field' ";
                                           break;
                                           case 'image' :
                                               echo "<div class='white-box'>
                                                       <label for='field-1'>".get_phrase($label);
                                               if(strtolower($form_validation) == "m")
                                               {    
                                                       echo "<span class='error mandatory'> *</span></label>";
                                                       $required = "required";

                                               }
                                               else
                                                       echo "</label>";
                                               echo "<input type='file' id='$db_field' class='dropify' name='$db_field' />"; 
                                              echo "</div>";
                                            break;    
                                                    }
                                            }
                                                
                                             
                            if(($count%3==0))
                            {
                                echo "</div>";
                            }    
                                            
                                        
                                    
                            }
                                    }
                                   
                                echo "</section>";
   }      
   ?>                         
                            
<?php 
 echo "<div class='text-right' style='display:none' id='id_btn_block'>
                <button  type='submit' class='fcbtn btn btn-danger btn-outline btn-1d'>Add Student</button>
       </div>";
echo form_close(); ?>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('.sttabs li > a').click(function(e){
            
            if (e.originalEvent)
            {
              return false;
            }
        });
        
        $('#transport_id').change(function () {
            //$('#transport_fee_idError').html('');
            var transport_id = $(this).val();
            $.ajax({
                dataType: 'json',
                url: '<?php echo base_url(); ?>index.php?Ajax_controller/get_transportfee/' + transport_id,
                success: function (response) {
                    if (response.status == "success") {
                        $('#transport_fee_id').val(response.transport_fee);
                    } //else {
                        //$('#transport_fee_idError').html(response.message).selectpicker('refresh');
                   // }
                }
            });
        });

        $("#route_id").change(function () {
            var route_id = $(this).val();
            $.ajax({
                url: '<?php echo base_url(); ?>index.php?ajax_controller/get_bus_stop/' + route_id,
                success: function (response)
                {
                    jQuery('#transport_id').html(response).selectpicker('refresh');
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });
        });

        $('#dormitory_id').change(function () {
            var dormitory_id = $(this).val();
            $.ajax({
                url: '<?php echo base_url(); ?>index.php?Ajax_controller/get_free_hostel_room/' + dormitory_id,
                success: function (response) {
                    $('#room_id').html(response).selectpicker('refresh');
                }
            });
        });

        $('#room_id').change(function () {
            $('#room_idError').html('');
            var room_id = $(this).val();
            $.ajax({
                dataType: 'json',
                url: '<?php echo base_url(); ?>index.php?Ajax_controller/get_dormitoryfee/' + room_id,
                success: function (response) {
                    if (response.status == "success") {
                        $('#dormitory_fee_id').val(response.hostel_fee);
                    } //else {
                       // $('#room_idError').html(response.message);
                    //}
                }
            });
        });
        
        $('#class_id').change(function () {
           
            var class_id = $(this).val();
            $.ajax({
                url: '<?php echo base_url(); ?>index.php?Ajax_controller/get_section_by_class_id/' + class_id,
                 success: function (response)
                {
                    jQuery('#section_id').html(response).selectpicker('refresh');
                }, error: function (response){
                    
                    
                    }
            });
        });
        
        $(".datepicker").datepicker({
            dateFormat: "dd/mm/yy",
            changeMonth: true,
            changeYear: true,
            endDate: '+0d',
            autoclose: true
        });
        
       
    });

    function agecalculate() {
       // var dob = $(".datepicker").val();
        var now = new Date();
        var d = new Date();
        var year = d.getFullYear() - 3;
        d.setFullYear(year);
        var birthdate = dob.split("/");
        var born = new Date(birthdate[2], birthdate[1] - 1, birthdate[0]);
        age = get_age(born, now);
        if (age <= 3) {
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
        var class_fee_status        =   0;
        jQuery.ajax({
            url: '<?php echo base_url(); ?>index.php?Ajax_controller/check_fee_set_forclass/' + class_id,
            type:'POST',
            dataType: 'json',
            async: false,
            success: function(response) {
                if(response.status == 'success'){
                    class_fee_status    =   1;
                    jQuery("#set_fee_link").html('');
                } else {
                    backendLoginFinance();
                    jQuery("#set_fee_link").html(response.message+'<br>');
                }
            }
        });
        if(class_fee_status != 0) {
            jQuery.ajax({
                url: '<?php echo base_url(); ?>index.php?admin/get_class_section/' + class_id,
                success: function(response) {
                    jQuery("#section_selector_holder").html(response).selectpicker('refresh');
                }
            });
        } else {
            var def_section = '<option value="">Select Class First</option>';
            jQuery("#section_selector_holder").html(def_section).selectpicker('refresh');
        }
    }

    function checkemail() {
        var email = $("#studentemail").val();
        if (email) {
            $.ajax({
                type: 'post',
                url: '<?php echo base_url(); ?>index.php?admin/get_class_students_mass/',
                data: {
                    user_name: name
                },
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
    
    $("#btn0").click(function(){
      // $('#id_btn_block').css('display','none');     
        var valid_val = 1;
        var elems = $('#section-flip-1').find('input');
        elems.each(function(index,element) {
   
        if (!element.validity.valid) {
            element.reportValidity();
            //alert("Required field");
            element.focus();
            valid_val = 0;
            return false;
            // element.reportValidity();
           
        }
       });
        var elems1 = $('#section-flip-1').find('select');
        elems1.each(function(index,element) {
        if (!element.validity.valid) {
            //alert("Required field");
            element.reportValidity();
            element.focus();
            valid_val = 0;
            return false;
        }
       });
       if(valid_val == 1)
       {    
            $('#tab2').addClass('tab-current');
            $('a[href="#section-flip-2"]').click();
            $('#section-flip-2').css('display','block');
            $('#section-flip-1').css('display','none');
            $('#tab1').removeClass('tab-current');
        }
});
$("#bck_2").click(function(){
            $('#tab1').addClass('tab-current');
            $('a[href="#section-flip-1"]').click();
            $('#section-flip-1').css('display','block');
            $('#section-flip-2').css('display','none');
            $('#tab2').removeClass('tab-current');
        
});
$("#bck_3").click(function(){
            $('#tab2').addClass('tab-current');
            $('a[href="#section-flip-2"]').click();
            $('#section-flip-2').css('display','block');
            $('#section-flip-3').css('display','none');
            $('#tab3').removeClass('tab-current');
        
});
$("#bck_4").click(function(){
            $('#tab3').addClass('tab-current');
            $('a[href="#section-flip-3"]').click();
            $('#section-flip-3').css('display','block');
            $('#section-flip-4').css('display','none');
            $('#tab4').removeClass('tab-current');
        
});
$("#bck_5").click(function(){
            $('#tab4').addClass('tab-current');
            $('a[href="#section-flip-4"]').click();
            $('#section-flip-4').css('display','block');
            $('#section-flip-5').css('display','none');
            $('#tab5').removeClass('tab-current');
        
});

$("#btn0").click(function(){
      // $('#id_btn_block').css('display','none');     
        var valid_val = 1;
        var elems = $('#section-flip-1').find('input');
        elems.each(function(index,element) {
   
        if (!element.validity.valid) {
            element.reportValidity();
            //alert("Required field");
            element.focus();
            valid_val = 0;
            return false;
            // element.reportValidity();
           
        }
       });
        var elems1 = $('#section-flip-1').find('select');
        elems1.each(function(index,element) {
        if (!element.validity.valid) {
            //alert("Required field");
            element.reportValidity();
            element.focus();
            valid_val = 0;
            return false;
        }
       });
       if(valid_val == 1)
       {    
            $('#tab2').addClass('tab-current');
            $('a[href="#section-flip-2"]').click();
            $('#section-flip-2').css('display','block');
            $('#section-flip-1').css('display','none');
            $('#tab1').removeClass('tab-current');
        }
});

$("#btn1").click(function(){
      // $('#id_btn_block').css('display','none');     
        var valid_val = 1;
        var elems = $('#section-flip-2').find('input');
        elems.each(function(index,element) {
   
        if (!element.validity.valid) {
            element.reportValidity();
            //alert("Required field");
            element.focus();
            valid_val = 0;
            return false;
            // element.reportValidity();
           
        }
       });
        var elems1 = $('#section-flip-2').find('select');
        elems1.each(function(index,element) {
        if (!element.validity.valid) {
            //alert("Required field");
            element.reportValidity();
            element.focus();
            valid_val = 0;
            return false;
        }
       });
       if(valid_val == 1)
       {    
            $('#tab3').addClass('tab-current');
            $('a[href="#section-flip-3"]').click();
            $('#section-flip-3').css('display','block');
            $('#section-flip-2').css('display','none');
            $('#tab2').removeClass('tab-current');
        }
});


$("#btn2").click(function(){
        var valid_val = 1;
       // $('#id_btn_block').css('display','none');
        var elems = $('#section-flip-3').find('input');
        elems.each(function(index,element) {
   
        if (!element.validity.valid) {
            element.reportValidity();
            element.focus();
            valid_val = 0;
            return false;
            // element.reportValidity();
           
        }
       });
        var elems1 = $('#section-flip-3').find('select');
        elems1.each(function(index,element) {
        if (!element.validity.valid) {
            //alert("Required field");
            element.reportValidity();
            element.focus();
            valid_val = 0;
            return false;
        }
       });
       if(valid_val == 1)
       {    
            $('#tab4').addClass('tab-current');
            $('a[href="#section-flip-4"]').click();
            $('#section-flip-4').css('display','block');
            $('#section-flip-3').css('display','none');
            $('#tab3').removeClass('tab-current');
        }
});
$("#btn3").click(function(){
      //  $('#id_btn_block').css('display','none');
        var valid_val = 1;
        var elems = $('#section-flip-4').find('input');
        elems.each(function(index,element) {
   
        if (!element.validity.valid) {
            //alert("Required field");
            element.reportValidity();
            element.focus();
            valid_val = 0;
            return false;
            // element.reportValidity();
           
        }
       });
        var elems1 = $('#section-flip-4').find('select');
        elems1.each(function(index,element) {
        if (!element.validity.valid) {
            //alert("Required field");
            element.reportValidity();
            element.focus();
            valid_val = 0;
            return false;
        }
       });
       if(valid_val == 1)
       {    
            $('#tab5').addClass('tab-current');
            $('a[href="#section-flip-5"]').click();
            $('#section-flip-5').css('display','block');
            $('#section-flip-4').css('display','none');
            $('#tab4').removeClass('tab-current');
        }
});
$("#btn4").click(function(){
        
    
        var valid_val = 1;
        var elems = $('#section-flip-5').find('input');
        elems.each(function(index,element) {
           
        if (!element.validity.valid) {
            element.reportValidity();
            element.focus();
            valid_val = 0;
            return false;

           
        }
       });
        var elems1 = $('#section-flip-5').find('select');
        
        elems1.each(function(index,element) {
        if (!element.validity.valid) {
            
           element.reportValidity();
            element.focus();
            valid_val = 0;
            return false;
        }
       });
       
       if(parseInt(valid_val) == 1)
       {    
       // $("#id_btn_block").css("display": "inline-block" );   
        document.getElementById('id_btn_block').style.display = "block";
        $('#tab5').addClass('tab-current');
            $('a[href="#section-flip-5"]').click();
            $('#section-flip-6').css('display','block');
            $('#section-flip-5').css('display','none');
            $('#tab5').removeClass('tab-current');
        }
});

function activeTab(tab){
    $('ul li a[href="#' + tab + '"]').tab('show');
}


$(document).ready(function () {
//    $('#btn2').on('click', function () {
//        var city = $('#city').val();
//        if (city == '') {
//            document.getElementById('error_city').innerHTML = "Please Enter City";
//        } else {
//            document.getElementById('error_city').innerHTML = "";
//        }
//
//        var address = $('#address').val();
//        if (address == '') {
//            document.getElementById('error_address').innerHTML = "Please Enter Address";
//        } else {
//            document.getElementById('error_address').innerHTML = "";
//        }
//
//        var country = $('#country').val();
//        if (country == '') {
//            document.getElementById('error_country').innerHTML = "Please Enter Country";
//        } else {
//            document.getElementById('error_country').innerHTML = "";
//        }
//        var nationality = $('#nationality').val();
//        if (nationality == '') {
//            document.getElementById('error_nationality').innerHTML = "Please Enter Nationality";
//        } else {
//            document.getElementById('error_nationality').innerHTML = "";
//        }
//        var place_of_birth = $('#place_of_birth').val();
//        if (place_of_birth == '') {
//            document.getElementById('eror_POB').innerHTML = "Please Enter Place of Birth";
//        } else {
//            document.getElementById('eror_POB').innerHTML = "";
//        }
//        var phone = $('#phone').val();
//        if (phone == '') {
//            document.getElementById('error_phone').innerHTML = "Please Enter Phone";
//        } else {
//            document.getElementById('error_phone').innerHTML = "";
//        }
//
//
//        if ((city != '') && (address != '') && (country != '') && (nationality != '') && (place_of_birth != '') && (phone != '')) {
//            $('#ForthTab').click();
//        }
//
//        if ($("#addStudentForm").valid()) {
//
//            $("#tabs").tabs({
//                active: 3
//            });
//            var prev = $('#ui-id-3');
//            prev.css('background-color', '#fff');
//            prev.css('color', '#555555');
//            var current = $('#ui-id-4');
//            current.css('background-color', '#a02d2d');
//            current.css('color', '#ffffff');
//        }
//    });

//    $('#btn3').on('click', function () {
//
//        var card_id = $('#card_id').val();
//        if (card_id == '') {
//            document.getElementById('error_card_id').innerHTML = "Please Enter Card id";
//        } else {
//            document.getElementById('error_card_id').innerHTML = "";
//        }
//
//        var icard_no = $('#icard_no').val();
//        if (icard_no == '') {
//            document.getElementById('error_icard_no').innerHTML = "Please Enter ICard No";
//        } else {
//            document.getElementById('error_icard_no').innerHTML = "";
//        }
//
//        var type = $('#type').val();
//        if (type == '') {
//            document.getElementById('error_type').innerHTML = "Please Enter Type";
//        } else {
//            document.getElementById('error_type').innerHTML = "";
//        }
//
//
//        if ((card_id != '') && (icard_no != '') && (type != '')) {
//            $('#FivthTab').click();
//        }
//
//
//
//        if ($("#addStudentForm").valid()) {
//
//            $("#tabs").tabs({
//                active: 4
//            });
//
//            var prev = $('#ui-id-4');
//            prev.css('background-color', '#fff');
//            prev.css('color', '#555555');
//            var current = $('#ui-id-5');
//            current.css('background-color', '#a02d2d');
//            current.css('color', '#ffffff');
//        }
//    });

//    $('#btn4').on('click', function () {
//        var searchLocation = $('#searchLocation').val();
//        if (searchLocation == '') {
//            document.getElementById('error_searchLocation').innerHTML = "Please Enter Location";
//        } else {
//            document.getElementById('error_searchLocation').innerHTML = "";
//        }
//
//        var tutFeeInsType = $('#tutionfee_inst_type').val()
//        if (tutFeeInsType == '') {
//            document.getElementById('error_tutionfee_inst_type').innerHTML = "Please Select School Fee Instalment";
//        } else {
//            document.getElementById('error_tutionfee_inst_type').innerHTML = "";
//        }
//
//        if ((searchLocation != '') && tutFeeInsType!='') {
//            $('#SixTab').click();
//        }
//
//
//        if ($("#addStudentForm").valid()) {
//
//            $("#tabs").tabs({
//                active: 5
//            });
//            var prev = $('#ui-id-5');
//            prev.css('background-color', '#fff');
//            prev.css('color', '#555555');
//            var current = $('#ui-id-6');
//            current.css('background-color', '#a02d2d');
//            current.css('color', '#ffffff');
//        }
//    });
});

function allnumeric(inputtxt) {
    var numbers = /^[0-9]+$/;
    if (inputtxt.value.match(numbers)) {
        alert('Your Registration number has accepted....');
        document.form1.text1.focus();
        return true;
    } else {
        alert('Please input numeric characters only');
        document.form1.text1.focus();
        return false;
    }
}

function Validate() {
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

function checkavailability(section_id) {
    var class_id = $('#class_id').val();
    $.ajax({
        url: '<?php echo base_url(); ?>index.php?ajax_controller/check_availability',
        type: 'POST',
        data: {
            class_id: class_id,
            section_id: section_id
        },
        success: function (response) {
            count = JSON.parse(response);
            if (count.allowed === 'no') {
                $('#availability').html('This section is already filled, try another section');
            } else {
                $('#availability').html('');
            }
        },
        error: function () {
            alert('error');
        }
    });
}

//$('.selectpicker').selectpicker({dropupAuto: false});
</script>