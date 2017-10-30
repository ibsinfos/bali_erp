<div class="col-md-12 white-box preview_outer">      
  <table class= "custom_table table display" cellspacing="0" width="100%" id="example23">
    <thead>
        <tr>
            <th><div>S.No.</div></th>
            <th><div><?php echo get_phrase('student_name'); ?></div></th>
            <th><div><?php echo get_phrase('assign_date'); ?></div></th>
            <th><div><?php echo get_phrase('student_submission_date'); ?></div></th>
            <th><div><?php echo get_phrase('answer'); ?></div></th>
            <th><div><?php echo get_phrase('comment'); ?></div></th>
            <th><div><?php echo get_phrase('status'); ?></div></th>
            <th><div><?php echo get_phrase('option'); ?></div></th>
        </tr>
    </thead>
    <tbody>
    <?php // pre($assignment_details); exit;
      if(!empty($assignment_details)){         
              $count = 1;
          foreach ($assignment_details as $row) { ?>   
            <tr>               
                <td><?php echo $count++; ?></td>               
                <td><?php echo ucwords($row['name'] ." ". ($row['mname']!=''?$row['mname']:'') ." ". $row['lname']);?></td>           
                <td><?php echo $row['assigned_date'];?></td> 
                <td><?php echo $row['submitted_date'];?></td> 
                <td><?php echo $row['answer'];?></td> 
                <td><?php echo $row['comments'];?></td> 
                <td><?php if($row['isSubmitted'] == "1"){ echo "Attempted";}else{ echo "Not Attempted";}?></td>
                <td>
                    <?php  if($row['isSubmitted'] == "1"){
                        if (!empty($row['file_desc']) && file_exists(FCPATH.'uploads/assignments_answers/'.$row['file_desc'])){
                        ?>
                    <a href="#" onclick="showDocumentPreview('<?php echo base_url();?>index.php?modal/popup/assignment_preview/<?php echo $row['file_desc'];?>/teacher');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="View Assignment"><i class="fa fa-eye"></i></button></a>
                     <a href="uploads/assignments_answers/<?php echo $row['file_desc']; ?>" target="blank"><button type="button" class="btn btn-defoult btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Download Assignment">
                        <i class="fa fa-download"></i>
                    </button></a>
                    <?php }
                    else{ ?>
                            <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_submit_assignment_view/<?php echo $row['answer_id'];?>');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="No Available" disabled=""><i class="fa fa-eye"></i></button> 
                   </a>
                    <a><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="No Attachment" disabled="">
                    <i class="fa fa-download"></i>
                </button></a>
                    <?php }
                    }else{ ?>
                            <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_submit_assignment_view/<?php echo $row['answer_id'];?>');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="No Available" disabled=""><i class="fa fa-eye"></i></button> 
                   </a>
                    <a><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="No Attachment" disabled="">
                    <i class="fa fa-download"></i>
                </button></a>
                    <?php } ?>  
                <?php 
                   if($row['is_Verified']==1){ ?>
                       <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Already Verify" disabled=""><i class="fa fa-share"></i></button>
                 <?php  }elseif($row['isSubmitted'] == "0"){ ?>
                       <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="No Available" disabled=""><i class="fa fa-share"></i></button>
                 <?php }else{ ?>
                       <a href="<?php echo base_url(); ?>index.php?teacher/verify_student_assignment/<?php echo $row['assignment_id']; ?>/<?php echo $row['is_Verified'];  ?>">
                      <button type="submit" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Verify"><i class="fa fa-share"></i></button>
                        </a>                       
                 <?php }?>
                </td>   
            </tr>
    
    <?php } 
      }?>
    </tbody>
</table>
   
</div>
                    
<script>
   var example_getrow = $('#example23').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            "pageLength",
            'copy', 'excel', 'pdf', 'print'
        ]
    });
    example_getrow.$('tr').tooltip( {selector: '[data-toggle="tooltip"]'});    
    
     $(function () {
       $('.preview_outer').on('shown.bs.tooltip', function (e) {
          setTimeout(function () {
            $(e.target).tooltip('hide');
          }, 500);
       });
    }); 
</script>