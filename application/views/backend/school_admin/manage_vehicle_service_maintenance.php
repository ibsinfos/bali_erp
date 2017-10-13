<?php if(!empty($details)){?>

    <div class="row">
	<div class="col-sm-12">    
        <div class="white-box">
<!----TABLE LISTING STARTS-->

    <table id="example" class="display nowrap" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th><?php echo get_phrase('no'); ?></th>
                    <th><div><?php echo get_phrase('date_of_service'); ?></div></th>
                    <th><div><?php echo get_phrase('reason_for_service'); ?></div></th>            
                    <th><div><?php echo get_phrase('vendor_name'); ?></div></th>
                    <th><div><?php echo get_phrase('vendor_phone_no'); ?></div></th>
                    <th><div><?php echo get_phrase('vendor_address'); ?></div></th>
                    <th><div><?php echo get_phrase('cost_for_service'); ?></div></th>
                    <th><div><?php echo get_phrase('payment_type'); ?></div></th>
                    <th><div><?php echo get_phrase('return_date_from_service'); ?></div></th>
                </tr>
            </thead>
            <tbody>
                <?php $count = 1;
                foreach ($details as $row): ?>
                    <tr>
                        <td><?php echo $count++; ?></td>
                        <td><?php echo $row['date_of_service']; ?></td>
                        <td><?php echo $row['reason_for_service']; ?></td>
                        <td><?php echo $row['vendor_name']; ?></td>
                        <td><?php echo $row['vendor_phone_no']; ?></td>
                        <td><?php echo $row['vendor_address']; ?></td>
                        <td><?php echo $row['cost_for_service']; ?></td>
                        <td><?php echo $row['payment_type']; ?></td>
                        <td><?php echo $row['return_date_from_service']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
<?php echo form_close();?>
<?php } else{ echo get_phrase('no_data_avaiable');}?>
</div>
</div>
</div>

<!--For tabs -->
<script src="<?php echo base_url(); ?>assets/js/cbpFWTabs.js"></script>
<script type="text/javascript">
    (function () {
        [].slice.call(document.querySelectorAll('.sttabs')).forEach(function (el) {
            new CBPFWTabs(el);
        });
    })();
$('#example').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            "pageLength"
        ]
    });
</script>

