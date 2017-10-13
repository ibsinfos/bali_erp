<link rel="stylesheet" type="text/css" href="assets/new_assets/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="assets/new_assets/css/datatable.css"/>
<script type="text/javascript" src="assets/new_assets/js/datatable.js"></script>

<style>
    .exam_chart {
    width           : 100%;
        height      : 265px;
        font-size   : 11px;
}
  
</style>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary panel-shadow" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">questions</div>
            </div>
            <div class="panel-body">
                <div class="col-md-12">
                  <?php  
                    $_SESSION['TIMER'] = time() + 600; 
                    
                    echo $_SESSION['TIMER'];?>
                    <form name="que_form" action="" method="post">
                   <?php  $i=1; ?>
                    <?php foreach ($question as $row3)  { ?>
                    <div id="show_question<?php echo $i; ?>" style="display:none;">
                   <table class="table table-bordered">
                       <thead>
                        <tr>
                            <td class="col-md-9" colspan="2"><?php echo $row3['question'];?></td>
                        </tr>
                      <?php  if($row3['qtype_id']=='1'){ 
                          if(strlen($row3['option1'])>0)  {                        ?>
                        <tr>
                            <td style="text-align: center;" class="col-md-1"><input type="checkbox" name="answer[]"></td>
                            <td><?php echo $row3['option1'];?></td>
                        </tr>
                          <?php  }  if(strlen($row3['option2'])>0)  { ?>
                        <tr>
                            <td style="text-align: center;" class="col-md-1"><input type="checkbox" name="answer[]"></td>
                            <td><?php echo $row3['option2'];?></td>
                        </tr>
                        <?php  }  if(strlen($row3['option3'])>0)  { ?>
                         <tr>
                            <td style="text-align: center;" class="col-md-1"><input type="checkbox" name="answer[]"></td>
                            <td><?php echo $row3['option3'];?></td>
                        </tr>
                        <?php } if(strlen($row3['option4'])>0)  { ?>
                         <tr>
                            <td style="text-align: center;" class="col-md-1"><input type="checkbox" name="answer[]"></td>
                            <td><?php echo $row3['option4'];?></td>
                        </tr>
                        <?php  } if(strlen($row3['option5'])>0)  { ?>
                         <tr>
                            <td style="text-align: center;" class="col-md-1"><input type="checkbox" name="answer[]"></td>
                            <td><?php echo $row3['option5'];?></td>
                        </tr>
                        <?php } if(strlen($row3['option6'])>0)  { ?>
                         <tr>
                            <td style="text-align: center;" class="col-md-1"><input type="checkbox" name="answer[]"></td>
                            <td><?php echo $row3['option6'];?></td>
                        </tr>
                        <?php 
                        }
                        } ?>
                        <?php  if($row3['qtype_id']=='2'){ ?>
                        <tr><td colspan='2'>
                          <?php  echo get_phrase('hint')." : ".$row3['hint'];   ?>
                        </td>
                        </tr>
                        <tr><td class="col-md-2"><input type="radio" name="ture/false" value="true"></td><td class="col-md-2"><?php echo get_phrase('true');  ?></td></tr>
                        <tr><td class="col-md-2"><input type="radio" name="ture/false" value="true"></td><td class="col-md-2"><?php echo get_phrase('false');  ?></td></tr>
                        <?php } ?>
                        <?php  if($row3['qtype_id']=='3'){ ?>
                         <tr><td><?php  echo get_phrase('hint')." : ".$row3['hint'];   ?></td></tr>
                        <tr><td><input type="text" name="fill_in_blanks"></td></tr>
                         
                        <?php } ?>
                        <?php  if($row3['qtype_id']=='4'){ ?>
                         <tr><td><?php  echo get_phrase('hint')." : ".$row3['hint'];   ?></td></tr>
                         <tr><td><textarea rows="5" name='subjtive'> </textarea></td></tr>
                         
                        <?php } ?>
                       </thead>
                       
                   </table>
                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" onclick="pre_question('<?php echo $i; ?>');">
                                            Previous 
                    </button>
                 <button type="button" class="btn btn-default btn-sm dropdown-toggle" >
                                            Save 
                                        </button>
                        <button type="button" class="btn btn-default" onclick="save_and_next(<?php echo $row3['id'] ?>,<?php echo $i+1; ?>);">
                                            Save&Next 
                                        </button>
                 <button type="reset" class="btn btn-default" >
                                            Reset Answer 
                                        </button>
                        <button type="button" name="next" id="next11" class="btn btn-default" onclick="next_question('<?php echo $i+1; ?>');">
                                            Next 
                                        </button>   
                    </div>
                    <?php 
                    $i=$i+1;  }?>
                    </form>
               </div>              
    
                <span id="section_selector_holder"></span>
            </div>
        </div>  
    </div>    
</div>

<script type="text/javascript">
    $("#show_question1").show();
    
  function next_question(value){
      //alert(value);
      //for($i =0;)
      //alert("#show_question"+value);
     // $(#show_question+value).();
     var value1=value-1;
     //alert(value1);
      $("#show_question"+value1).hide();
      $("#show_question"+value).show();
  }
   function pre_question(value){
      //alert(value);
      //for($i =0;)
      //alert("#show_question"+value);
     // $(#show_question+value).();
     var value1=value-1;
     //alert(value1);
      $("#show_question"+value).hide();
      $("#show_question"+value1).show();
       
  }
  
  function save_and_next(id,value){
   
     var value1 = value-1;
     //alert(value1);
      $("#show_question"+value1).hide();
      $("#show_question"+value).show();
      //alert("fdgdfgd");         
       $.ajax({       
         url: '<?php echo base_url(); ?>index.php?Ajax_controller/questions/<?php echo $row3["exam_id"]; ?>/'+id,
            success: function (response)
           {
             alert(response);
              //$("#section_selector_holder").load(response);
              //jQuery('#section_selector_holder').html(response);
           }
        });
       
       }
</script>
    
    
    
    
    
    
    
    
    
    
    

    