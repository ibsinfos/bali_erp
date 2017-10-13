<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


   function create_dynamic_form($arrDynamic, $arrGroups, $arrLabel, $arrAjaxEvent, $arrValidation, $arrFieldValue, $arrFieldQuery,
            $arrDbField, $arrClass, $arrPlaceHolder, $arrMin, $arrMax){ 

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
            $group_active   = (!(empty($arrVal[3])) && $arrVal[3] == "Y") ? "active" : "";
        }    

        echo "<div class='content-wrap'>";
        foreach($arrGroups as $key => $value)
        {
            $count = 0;
            if(strstr($value, "||||"))
              {
                  $arrVal = explode("||||", $value);
              }        
              $group_section  = !(empty($arrVal[3])) ? $arrVal[3] : "";
              foreach($arrDbField as $db_key => $db_field)
              {    
                    $keyArr =  explode("_", $db_key);
                    if($keyArr[0] == $key)
                    {    
                      $count +=1;
                      if($count == 1 || ($count%3) == 0)
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
                                   $pattern = "^[A-Za-z -8]+$";
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
                         $maxlength = "";
                         if(!empty($arrMin[$key][$db_field]))
                         {
                             "min = ".$arrMin[$key][$db_field];
                         }
                         if(!empty($arrMax[$key][$db_field]))
                         {
                            $maxlength =  "maxlength = '".$arrMax[$key][$db_field]."'";
                         }
                            switch($field_type)
                            {
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
                                        $pattern placeholder = '$place_holder' $maxlength 
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
                                           data-validate='$form_validation_type' $maxlength 
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
                                           if(strtolower($form_validation) == "m")
                                               echo "<span class='error mandatory'> *</span></label>";
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
                                           echo "<select class='selectpicker' data-style='form-control' data-container='body'  name='$db_field' id='$db_field' $required "
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
                                               echo "</label>";        
                                               echo "<select class='selectpicker' data-style='form-control' data-container='body' name='$db_field' id='$db_field' "
                                                       . "data-validate='$form_validation_type' data-message-required='Select' $ajax_event>
                                                   <option value='0'>Select</option>";

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
 
                }
   }             
   

