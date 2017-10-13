{include file="sections/header.tpl"}
{literal}
<style>
.modal-backdrop {display:none}
.modal-open {overflow: auto;}
.modal{margin-top:100px;}
</style>
{/literal}
<div class="row">
    <div class="col-md-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>{'Employees'}</h5>
            </div>
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
                            <input type="text" class="form-control dtp" name="month" value="{$month}" placeholder="Select Month"/>
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
                        <th>{'Mail ID'}</th>
                        <th>{'Work Phone'}</th>
                        <th>{'Acc No.'}</th>
                        <th>{'Salary'}</th>
                        <th>{'Action'}</th>
                    </thead>
                    <tbody>
                        {foreach $es as $emp}
                            <tr>
                                <td>{$emp['employeeId']}</td>
                                <td>{$emp['userfullname']}</td>
                                <td>{$emp['emprole_name']}</td>
                                <td>{$emp['emailaddress']}</td>
                                <td>{$emp['contactnumber']}</td>
                                <td>{$emp['accountnumber']}</td>
                                <td>{$emp['salary']|decrypt_salary}</td>
                                <td>
                                    {if $emp['payslip_id']!=''}
                                        {if $emp['is_paid'] eq 1}
                                            <a href="javascript:;" class="btn btn-success btn-xs">{$_L['Paid']}</a>
                                        {else}
                                            <a href="javascript:;" class="btn btn-primary btn-xs paymodal" data-toggle="modal" data-target="#selectAccount"
                                               data-payslipid="{$emp['payslip_id']}">
                                                {$_L['Unpaid']}
                                            </a>
                                        {/if}
                                    {else}
                                        Not Generated
                                    {/if}
                                </td>
                            </tr>
                        {/foreach}
                        
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="selectAccount" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Select Account to Deduct From</h4>
      </div>
      <div class="modal-body">
        <form action="{$_url}employees/paynow/">
            <input type="hidden" name="payslip_id" id="payslip_id"/>
            <div class="row">
                <div class="col-md-12">
                    <label>Account</label>
                    <select class="form-control" id="acc_id">
                        <option value="">Select Account</option>
                        {foreach $accts as $act}
                            <option value="{$act['id']}">{$act['account']}</option>
                        {/foreach}
                    </select>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary paynow">Pay Now</button>
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

$(document).on('click','.paymodal',function(){
    //console.log($(this).data('payslipid'));
    $('#selectAccount').find('#payslip_id').val($(this).data('payslipid'));
});

{/literal}
$(document).on('click','.paynow',function(){
    $modal = $(this).closest('.modal');
    $payslip_id = $modal.find('#payslip_id').val();
    $acc_id = $modal.find('#acc_id').val();
    $.ajax({
        type:'post',
        url:"{$_url}employees/paynow/",
        {literal}
        data:{payslip_id:$payslip_id,acc_id:$acc_id},
        {/literal}
        success:function(data){
            if(data=='success'){
                alert('Salary Paid');
                $modal.modal('hide')
                window.location.reload();
            }
        }
    });
});
</script>