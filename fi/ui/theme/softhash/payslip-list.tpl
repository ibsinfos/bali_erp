{include file="sections/header.tpl"}
<div class="row">
    <div class="col-md-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title"><h5>{'Payslips'}</h5></div>
            <div class="ibox-content">
                <form method="post">
                    <div class="row">
                        <div class="col-md-3">
                            <select class="form-control" name="role">
                                <option value="">Select Role</option>
                                {foreach $mrols as $mrol}
                                    <option value="{$mrol['id']}" {if $mrol['id'] eq $role}selected{/if}>{$mrol['rolename']}</option>
                                {/foreach}
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control dtp" name="month" value="{$month}"/>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-success" type="submit">View</button>
                        </div>
                    </div>
                </form>
                
                <br>
                <table id="dt_table" class="table datatable table-bordered table-hover sys_table footable">
                    <thead>
                        <th>{'Employee ID'}</th>
                        <th>{'Name'}</th>
                        <th>{'Role'}</th>
                        <th>{'Acc No.'}</th>
                        <th>{'Generate Day'}</th>
                        <th>{'Salary'}</th>
                        <th>{'Net Pay'}</th>
                        <th>{'Action'}</th>
                    </thead>
                    <tbody>
                        {foreach $ps as $psem}
                            <tr>
                                <td>{$psem['employeeId']}</td>
                                <td>{$psem['userfullname']}</td>
                                <td>{$psem['emprole_name']}</td>
                                <td>{$psem['accountnumber']}</td>
                                <td>{($psem['generate_date']!='0000-00-00')?$psem['generate_date']:''}</td>
                                <td>{$psem['salary']|decrypt_salary}</td>
                                <td>{$psem['net_pay']}</td>
                                <td class="text-right">
                                    <a href="{$_url}employees/payslip-view/{$psem['payslip_id']}/" class="btn btn-primary btn-xs">
                                        <i class="fa fa-eye"></i> {$_L['View_payslip']}
                                    </a>
                                </td>
                            </tr>
                        {/foreach}
                        
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
{include file="sections/footer.tpl"}
<script type="text/javascript">
{literal}
$('#dt_table').DataTable({
    dom: 'Bfrtip',
    responsive: true,
    buttons: [
        "pageLength",
        'copy', 'excel', 'pdf', 'print'
    ],
    order: [[ 0, "desc" ]]
}); 

$('.dtp').datepicker({//startView:1,
                      autoclose:true,
                      format: 'mm-yyyy',
                      viewMode: "months", 
                      minViewMode: "months",
                      clearBtn: true});

$('select[name=role]').select2({
    placeholder:'Select Role',    
    theme: "bootstrap",
    allowClear: true
})
{/literal}
</script>