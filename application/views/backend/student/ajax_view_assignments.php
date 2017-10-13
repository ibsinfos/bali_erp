<div class="row">
<div class="col-md-12">
    <div class="white-box preview_outer">    
<table class= "custom_table table display" cellspacing="0" width="100%" id="example">
    <thead>
        <tr>
            <th><div>No.</div></th>
            <th><div><?php echo get_phrase('title'); ?></div></th>
            <th><div><?php echo get_phrase('teacher'); ?></div></th>
            <th><div><?php echo get_phrase('description'); ?></div></th>
            <th><div><?php echo get_phrase('date_of_assign'); ?></div></th>
            <th><div><?php echo get_phrase('date_of_submission'); ?></div></th>            
            <th><div><?php echo get_phrase('action'); ?></div></th>
        </tr>
    </thead>
    <tbody>
    <?php 
    if(!empty($assignment_details)){
          $count = 1;
          foreach ($assignment_details as $row) { ?>   
            <tr>               
                <td><?php echo $count++; ?></td>               
                <td><?php echo $row['assignment_topic']?></td>
                <td><?php echo $row['teacher_name']?></td>
                <td><?php echo $row['assignment_description']?></td>
                <td><?php echo $row['assigned_date']?></td> 
                <td><?php echo $row['submission_date']?></td>  
                
                <td><a href="javascript: void(0);" onclick="showDocumentPreview('<?php echo base_url();?>index.php?modal/popup/assignment_preview/<?php echo $row['file_name'];?>');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="View Assignment"><i class="fa fa-eye"></i></button></a>
                 <?php if (!empty($row['file_name'])){?>
                          <a href="uploads/assignments/<?php echo $row['file_name']; ?>" target="blank"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Download">
                    <i class="fa fa-download"></i>
                </button></a>
                         <?php } else{?>
                    <a><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="" disabled="">
                    <i class="fa fa-download"></i>
                </button></a> 
                         <?php  }
                        $curnt_date = date('Y-m-d H:i'); 
//                        echo "<br>".$row['submission_date']; die;
                        if(strtotime($curnt_date) >= strtotime($row['submission_date'])){ ?>
                             <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="" disabled=""><i class="fa fa-share"></i></button>
                     <?php    }
                        elseif($row['isSubmitted'] == "1"){ ?>
                             <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="" disabled=""><i class="fa fa-share"></i></button>
                     <?php    } 
                     
                        else{ ?>
                                 <a href="javascript: void(0);" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_assignment_submit/<?php echo $row['assignment_id'];?>');">
                                   <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Submit"><i class="fa fa-share"></i></button>
                                 </a>
                        <?php }?>
                    </ul>
                </td>
            </tr>
    
    <?php } ?>
    </tbody>
</table>
</div>
</div>
     <?php     } ?>

<script>
   var example_getrow = $('#example').DataTable({
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