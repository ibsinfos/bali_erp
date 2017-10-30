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


<div class="col-md-15 white-box" id="admin_custom">
<?php echo form_open(base_url() . 'index.php?admin/admin_custom_report/'); ?>
<div  data-step="5" data-intro="Select a school want to see gender report" data-position='right'>
<?php

    $running_year = "";
    $view_flag = 0;
    if(!empty($arrDbField)){
        $view_flag = 1;
		if(count($arrDbField) >2){
            $md_class = 'col-sm-4 ';
        } else {
            $md_class = 'col-sm-6 ';
        }
        foreach($arrDbField as $db_key => $db_field)
        {    
            $view_flag = 1;
            $ajax_event = '' ;     
            $field_val = $arrFieldValue[$db_field];
            if(!empty($arrAjaxEvent[$db_field]))
              $ajax_event = $arrAjaxEvent[$db_field];

            if(strstr($field_val, "?"))
            {
                $arrField           =        explode("?", $field_val);
                $field_type         =       (!empty($arrField[0])) ? $arrField[0] : "";
                $field_values       =       (!empty($arrField[1])) ? $arrField[1] : "";
            }

           $class = 'ti-user';
           $label = $arrLabel[$db_field];
            switch($field_type)
              {
                case 'text' :
                  echo "<div class='col-sm-5 form-group text-left'>
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
                        if(isset($_POST[$db_field]))
                            $val = $_POST[$db_field];
                        else
                            $val = '';
                        echo "
                                           <div class='".$md_class." form-group text-left'>
                                               <label for='field-1'>".
                                                   get_phrase($label);
                                            
                                                  echo "</label>";
                                           echo "<div class='input-group' >
                                               <div class='input-group-addon'><i class='icon-calender'></i>
                                               </div>";
                                           echo "<input type='text' data-provide='datepicker' class='form-control' name='$db_field' "
                                                   . "id='$db_field' value='$val' placeholder=''  data-start-view='2' >"
                                               ."</div>";
                                           
                                           echo "</div>";
                                       break;            
                    case 'drop' :
                        $selected = '';
                        $arrMain = array();
                        $arr = array();
                        if(!empty($field_values))
                        {
                            if($field_values == "query")
                            {
                              if(isset($arrDynamic[$db_field]))
                                    $arrMain = $arrDynamic[$db_field];
                            }    
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
                          $selected = '';
                        echo "<div class='".$md_class." form-group '>
                        <label for='control-label'>".
                            get_phrase($label);

                            echo "</label>";        
                        echo "<select class='selectpicker' $ajax_event data-style='form-control' data-container='body'  name='$db_field' id='$db_field' "

                                .  ">".
                            "<option value='0'>Select</option>";
                        
                        foreach($arrMain as $select_key => $select_value)
                            {
                                if(isset($arrPost))
                                {    
                                if(in_array($db_field, array_keys($arrPost)))
                                {
                                    if($select_key == $arrPost[$db_field])
                                       $selected =  " selected = 'selected'";
                                    else
                                        $selected = '';
                                    
                                }
                                } 
                                echo "<option value = '$select_key' $selected>$select_value</option>";
                            }     
                        echo "</select>";      
                        echo "</div>";
                       break;
              }
         }
    }     
?>
<input type="hidden" name="year" value="<?php echo $running_year;?>">
<input type="hidden" name="id" value="<?php echo $id;?>">

<?php
if($view_flag == 1)
{
    ?>


<div class="col-sm-8 form-group" >
    <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" data-step="8" data-intro="Click to view report" data-position='left'><?php echo get_phrase('VIEW REPORT');?></button>
</div>
<?php
}
    echo form_close(); 
?>
</div>
<div class="row">
<div class="col-sm-12 white-box">    
    <div class="col-sm-8 form-group">
      <?php
        if(!empty($school_name))
            echo "<h2>$school_name</h2>";
     ?>   
    </div>          
<table id="example23" class="display nowrap" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th><div><?php echo get_phrase('sno.');?></div></th>
            <?php
                if(isset($arrCaption))
                {
                    foreach($arrCaption as $caption)
                    {
                        echo "<th><div>".get_phrase($caption)."</div></th>";
                    }    
                }
            ?>
          
    </thead>
    <tbody><?php
    $n = 1;
    if(isset($result)>0){
        foreach ($result as $row){   ?>
            <tr>
                <td><?php echo $n++;?></td>
                <?php
                    foreach($arrCaption as $caption)
                    {
                        echo "<td>".$row[$caption]."</td>";
                    }
                ?>    
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
 
    
    function select_class(obj) { 
        var school_id = obj.value;
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?Ajax_controller/get_class_by_school/' + school_id,
            success:function (response){//alert(response);
                $('#class_id').html(response)
            }
        });
    }
    function select_section(obj) {
        var class_id = obj.value;
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?Ajax_controller/get_sections_by_class/' + class_id,
            success:function (response){//alert(response);
                 $('#section_id').html(response);
            }
        });
    }
 //   $('.datepicker').datepicker();
</script>

