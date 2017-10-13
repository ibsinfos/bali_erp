
<div class="row">
    <div class="col-md-12 white-box">                              
        <table class= "custom_table table display" cellspacing="0" width="100%" id="example">
            <thead>
                <tr>
                    <th><div><?php echo get_phrase('answer'); ?></div></th>
                    <th><div><?php echo get_phrase('comment'); ?></div></th>
                    <th><div><?php echo get_phrase('view'); ?></div></th>
                </tr>
            </thead>
            <?php if (!empty($assignment_Details)) { ?>
                <tbody>
                    <tr>
                        <td><?php echo $assignment_Details[0]['answer']; ?></td>
                        <td><?php echo $assignment_Details[0]['comments']; ?></td>
                        <td><a href="javascript: void(0);" onclick="showDocumentPreview('<?php echo base_url(); ?>index.php?modal/popup/assignment_preview/<?php echo $assignment_Details[0]['file_desc']; ?>/student');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="View Assignment"><i class="fa fa-eye"></i></button></a></td>                        
                    </tr>
                </tbody>
            <?php } ?>
        </table>
    </div>
</div>		

<script>
    var example_getrow = $('#example').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            "pageLength",
            'copy', 'excel', 'pdf', 'print'
        ]
    });
    example_getrow.$('tr').tooltip({selector: '[data-toggle="tooltip"]'});

</script>


<script type="text/javascript">
document.parent.location.close();
alert("sucess");
</script>