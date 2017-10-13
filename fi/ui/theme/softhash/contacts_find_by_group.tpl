{include file="sections/header.tpl"}

<div class="row">

    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">

                <a href="{$_url}contacts/group_email/{$gid}/" class="btn btn-primary mb-md"><i class="fa fa-paper-plane"></i> {$_L['Send Email']}</a>
                <br>

                <table id="dt_table" class="table datatable table-bordered table-hover sys_table footable">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{$_L['Name']}</th>
                        <th>{'Parent Name'}</th>
                        <th>{'Total Invoice'}</th>
                        <th>{'Total Payment'}</th>
                        <th>{'Total Due'}</th>
                        <th>{$_L['Phone']}</th>
                        <th class="text-right">{$_L['Manage']}</th>
                    </tr>
                    </thead>
                    <tbody>
                    {foreach $d as $ds}

                        <tr>
                            <td><a href="{$_url}contacts/view/{$ds['id']}/">{$ds['id']}</a> </td>
                            <td><a href="{$_url}contacts/view/{$ds['id']}/">{$ds['account']}</a> </td>
                            <td>{$ds['company']}</td>
                            <td>{$ds['total_invoice']}</td>
                            <td>{$ds['total_payment']}</td>
                            <td>{$ds['total_pending']}</td>
                            <td>
                                {$ds['phone']}
                            </td>
                            <td class="text-right">
                                <a href="{$_url}contacts/view/{$ds['id']}/" class="btn btn-primary btn-xs"><i class="fa fa-search"></i> {$_L['View']}</a>
                                    {*<a href="#" class="btn btn-danger btn-xs cdelete" id="uid{$ds['id']}"><i class="fa fa-trash"></i> {$_L['Delete']}</a>*}
                            </td>
                        </tr>

                    {/foreach}
                        {*<tr>
                            <td colspan="3">Total :</td>
                            <td>{$tot_inv}</td>
                            <td>{$tot_pay}</td>
                            <td>{$tot_due}</td>
                            <td colspan="2"></td>
                        </tr>*}

                    </tbody>
                </table>

            </div>
        </div>
    </div>

</div>

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