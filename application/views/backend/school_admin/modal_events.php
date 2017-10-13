<?php echo form_open(); ?>
<div class="row">
    <div class="col-md-12">
        <a href="#" onclick="showAjaxModal('<?php echo base_url('index.php?modal/popup/modal_event_types/') ?>');">
             <button type="button" class="btn btn-default btn-outline btn-circle m-r-5 tooltip-danger" data-toggle="tooltip" 
                            data-placement="top" data-original-title="back">
                            <i class="fa fa-reply"></i>
                        </button>
        </a>
    </div>
</div>
<table id="example23" class="table table_edjust new_tabulation display m-t-20">
    <thead>
        <tr>
            <th width="8%" style="min-width: 8% !important;">No</th>
            <th width="18%" style="min-width: 18% !important;">Event Name</th>
            <th width="42%" style="min-width: 42% !important;">Description</th>   
            <th width="20%" style="min-width: 20% !important;">Date</th>       
            <th width="12%" style="min-width: 12% !important;">Action</th>           
        </tr>
    </thead>

    <tbody>           
        <?php $count = 1;
        foreach ($events as $event):
            ?>
            <tr>
                <td><?php echo $count ?></td>
                <td><?php echo $event->title; ?></td>     
                <td><?php echo $event->description; ?></td> 
                <td><?php echo date('Y-m-d H:i', strtotime($event->start)) . ' - ' . date('Y-m-d H:i', strtotime($event->end)); ?></td>       
                <td><a href="#" onClick="delete_events(<?php echo $event->id ?>)">
                        <button type="button" class="btn btn-default btn-outline btn-circle m-r-5 tooltip-danger" data-toggle="tooltip" 
                            data-placement="top" data-original-title="Delete">
                            <i class="fa fa-trash"></i>
                        </button></a>







                </td>              
            </tr>            
    <?php $count++;
endforeach; ?>    
    </tbody>    
</table>

<?php echo form_close(); ?>

<script type="text/javascript">
    var example23_getrow = $('#example23').DataTable({
        dom: 'frtip',
        responsive: true,
        buttons: [
            "pageLength",
            'excel', 'pdf', 'print'
        ]
    });
    example23_getrow.$('tr').tooltip({selector: '[data-toggle="tooltip"]'});
    function check() {
        var parent_email = $("input[name='parent_id']:checked").val();
        $("#parent").val(parent_email);
        $("#parent_email").val(parent_email);
        $.ajax({
            type: "POST",
            //url: "index.php?school_admin/student_add",
            data: {parent_email: 'parent_email'},
            dataType: "html",
            success: function (data) {
                $("#parent").val(parent_email);
                $("#modal_ajax").modal('hide');
            },
            error: function (data) {
                console.log('error');
            }
        });
    }
    $(".tooltip-danger").tooltip({selector: '[data-toggle="tooltip"]'});
</script>

