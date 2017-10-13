{include file="sections/header.tpl"}
<div class="wrapper wrapper-content">
    
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <table  id="dt_table" class="table datatable table-bordered table-hover sys_table footable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{'Scholarship Name'}</th>
                            <th>{'Type'}</th>
                            <th>{'Value'}</th>
                            <th>{'Academic Year'}</th>
                            <th class="text-right">{$_L['Manage']}</th>
                        </tr>
                        </thead>
                        <tbody>

                        {foreach $scholarship_types as $stype}

                            <tr>

                                <td>{$count++}</td>
                                <td>{$stype['scholarship_name']}</td>
                                <td>{if $stype['deduction_type'] eq '1'} {'Amount'} {else} {'Percentage'} {/if}</td>
                                <td>{$stype['deduction_value']}</td>
                                <td>{$stype['academic_year']}</td>
                                
                                <td class="text-right">
                                    <a href="#" class="btn btn-primary btn-xs" name="cancel" id="cancel" ><i class="fa fa-times"></i>{$_L['Cancel']}</a>
                                    <a href="{$_url}fee-deductions/edit/{$stype['id']}/" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> {$_L['Edit']}</a>
                                    <input type="hidden" name="ded_id" id="ded_id" value="{$stype['id']}">
                                </td>
                            </tr>

                        {/foreach}

                        </tbody>
                    </table>

                </div>
            </div>
        </div>




</div>
                            


</div>
{include file="sections/footer.tpl"}
<script type="text/javascript">
     
    $( "#cancel" ).click(function() {
        
        _url  =   $('#_url').val(); 
        ded_id=$('#ded_id').val();
         
        $.post(_url + 'fee-deductions/cancel_deduction', {
            ded_id: ded_id,
            b_url    : _url
        })
        .done(function (data) {
            //alert(data);
            window.location.href = _url + 'fee-deductions/view-list';
             

        });
    });
    $('#dt_table').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            "pageLength",
{*            'copy', 'excel', 'pdf', 'print'*}
        ]
    }); 
</script>