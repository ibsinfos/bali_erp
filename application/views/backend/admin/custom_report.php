<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($caption); ?> </h4></div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?admin/dashboard"><?php echo get_phrase($caption); ?></a></li>
            <li class="active"><?php echo get_phrase($caption); ?></li>
        </ol>
    </div>
</div>


<div class="col-md-12 white-box">
<?php echo form_open(base_url() . 'index.php?admin_report/custom_report/'); ?>
<div class="col-sm-4 form-group" data-step="5" data-intro="Select a school want to see gender report" data-position='right'>
<?php
    foreach($arrDbField as $db_key => $db_field)
    {    
              $field_val = $arrFieldValue[$db_field];
              if(strstr($field_val, "?"))
              {
                  $arrField           =        explode("?", $field_val);
                  $field_type         =       (!empty($arrField[0])) ? $arrField[0] : "";
                  $field_values       =       (!empty($arrField[1])) ? $arrField[1] : "";
              }

                        
              switch($field_type)
                {
                    case 'text' :
                      echo "<div class='col-sm-4 form-group text-left'>
                                <label for='field-1' class='control-label'>".get_phrase($label);

                         echo   "<div class='input-group'>
                                    <div class='input-group-addon'>
                                        <i class='$class'></i>
                                    </div>";
                            echo "<input type='$field_type' class='form-control' id='$db_field' name='$db_field'> 
                            </div>";
                           echo "</div>";
                       break;

                        case 'date':
                            echo "
                                <div class='col-sm-4 form-group text-left'>
                                    <label for='field-1'>".
                                        get_phrase($label);

                            echo "<div class='input-group'>
                                <div class='input-group-addon'><i class='icon-calender'></i>
                                </div>";
                            echo "<input type='text' class='form-control' name='$db_field' "
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
                        echo "<select class='selectpicker' data-style='form-control' data-container='body'  name='$db_field' id='$db_field' $required "
                                .  $ajax_event.">".
                            "<option value='0'>Select</option>";
                            
                        foreach($arrMain as $select_key => $select_value)
                        {
                            if(in_array($db_field, array_keys($arrPost)))
                            {
                                
                                if($select_key == $arrPost[$db_field])
                                   $selected =  " selected = 'selected'";
                                else
                                    $selected = '';
                                    
                            }       
                            echo "<option value = '$select_key' $selected>$select_value</option>";
                        }     
                      echo "</select>";      
                      echo "</div>";
                   break;
          }
     }
?>
<input type="hidden" name="year" value="<?php echo $running_year;?>">
<div class="text-right col-xs-12" >
    <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" data-step="8" data-intro="Click to view report" data-position='left'><?php echo get_phrase('VIEW REPORT');?></button>
</div>
<?php echo form_close(); ?>
</div>
<div class="row">
<div class="col-sm-12 white-box">    
          
<table id="example23" class="display nowrap" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th><div><?php echo get_phrase('sl_no.');?></div></th>
            <th><div><?php echo get_phrase('School'); ?></div></th>  
            <?php if($schools_id != ""){?>
                <th><div><?php echo get_phrase('Class'); ?></div></th>                            
                <th><div><?php echo get_phrase('Section'); ?></div></th>                            
            <?php }?>
            <th><div><?php echo get_phrase("Male"); ?></div></th>                            
            <th><div><?php echo get_phrase('Female'); ?></div></th>
            <th><div><?php echo get_phrase('Total'); ?></div></th>
        </tr>
    </thead>
    <tbody><?php
    $n = 1;
    if(count($gender_records)>0){
        foreach ($gender_records as $row){   ?>
            <tr>
                <td><?php echo $n++;?></td>
                <td><?php echo $row['school_name']; ?></td>
                <?php if($schools_id != ""){?>
                    <td><?php echo $row['class_name']; ?></td>
                    <td><?php echo $row['section_name'];?></td>
                <?php }?>
                <td><?php  echo $row['male_count'];?></td>
                <td><?php echo ($row['female_count']);?></td>
                <td><?php echo ($row['male_count']+$row['female_count']);?></td>
            </tr>
        <?php }
    } else {?> 
        <tr><td colspan="5" >No data Available</td>
    <?php }?>
    </tbody>

    </table>
</div>                     
</div>
<script type="text/javascript">
    
    function select_class(school_id) { 
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?Ajax_controller/get_class_by_school/' + school_id,
            success:function (response){//alert(response);
                jQuery('#class_holder').html(response).selectpicker('refresh');
            }
        });
    }
    function select_section(class_id) {
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?Ajax_controller/get_sections_by_class/' + class_id,
            success:function (response){//alert(response);
                jQuery('#section_holder').html(response).selectpicker('refresh');
            }
        });
    }
</script>