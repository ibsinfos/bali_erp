{include file="sections/header.tpl"}
<div class="row">
    <div class="col-md-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>{'Classes'}</h5>

            </div>
            <div class="ibox-content">
{*                <a href="#" class="btn btn-success" id="add_new_group"><i class="fa fa-plus"></i> {$_L['Add New Group']}</a>*}
                <a href="{$_url}reorder/groups/" class="btn btn-primary"><i class="fa fa-arrows"></i> {$_L['Reorder']}</a>
                {*<div class="row pull-right" width="100%">
                    <div class="col-md-6 ">Total Invoice: {$tot_inv}</div>
                    <div class="col-md-6 ">Total Payment: {$tot_pay}</div>
                    <div class="col-md-6 ">Total Pending: {$tot_due}</div>
                       
                </div>*}
                
                {*<div class="ibox-title">Total Invoice: {$tot_inv}<br>Total Payment:{$tot_pay}<br>Total Due:{$tot_due}</div>*}
                <br>
                <br>
                <table id="dt_table" class="table datatable table-bordered table-hover sys_table footable">
                    <thead>
                        <th>{'Class'}</th>
                        <th>{'Total Invoice'}</th>
                        <th>{'Total Payment'}</th>
                        <th>{'Total Pending'}</th>
                        <th>{$_L['Manage']}</th>
                    </thead>
                    <tbody>
                        {foreach $gs as $g}
                            <tr>
                                <td>{$g['gname']}</td>
                                <td>{$g['total_invoice']}</td>
                                <td>{$g['total_payment']}</td>
                                <td>{$g['total_invoice']-$g['total_payment']}</td>
                                <td>
                                    <a href="{$_url}contacts/find_by_group/{$g['id']}/" class="btn btn-xs btn-primary"><i class="fa fa-bars"></i> {'List Students'}</a>
                                    {*<a href="#" class="btn btn-xs btn-warning edit_group" id="e{$g['id']}" data-name="{$g['gname']}"><i class="fa fa-pencil"></i> {$_L['Edit']}</a>

                                        <a href="{$_url}settings/users-delete/{$g['id']}" id="g{$g['id']}" class="btn btn-xs btn-danger cdelete"><i class="fa fa-trash"></i> {$_L['Delete']}</a>*}

                                </td>
                            </tr>
                        {/foreach}
                        
                    </tbody>
                </table>

            </div>
        </div>
    </div>



</div>



<input type="hidden" name="_msg_add_new_group" id="_msg_add_new_group" value="{$_L['Add New Group']}">
<input type="hidden" name="_msg_group_name" id="_msg_group_name" value="{$_L['Group Name']}">
<input type="hidden" name="_msg_edit" id="_msg_edit" value="{$_L['Edit']}">
<input type="hidden" name="_msg_ok" id="_msg_ok" value="{$_L['OK']}">
<input type="hidden" name="_msg_cancel" id="_msg_cancel" value="{$_L['Cancel']}">
{include file="sections/footer.tpl"}
<script type="text/javascript">
    $('#dt_table').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            "pageLength",
            'copy', 'excel', 'pdf', 'print'
        ],
        order: [[ 0, "desc" ]]
    }); 
    </script>