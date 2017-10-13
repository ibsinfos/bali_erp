{include file="sections/header.tpl"}

    <div class="row">

        {if ($_c['contact_set_view_mode']) eq 'tbl'}

            <div class="col-md-12">

                <div class="panel panel-default">
                    <div class="panel-body">
                        <table id="dt_table" class="table datatable table-bordered table-hover sys_table footable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{$_L['Name']}</th>
                                <th>{'Parent Name'}</th>
                                <th>{$_L['Email']}</th>
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

                                    <td>
                                        {$ds['email']}

                                    </td>
                                    <td>
                                        {$ds['phone']}
                                    </td>
                                    <td class="text-right">
                                        <a href="{$_url}contacts/view/{$ds['id']}/" class="btn btn-primary btn-xs"><i class="fa fa-search"></i> {$_L['View']}</a>

{*                                        <a href="delete/crm-user/{$ds['id']}/" class="btn btn-danger btn-xs cdelete" id="uid{$ds['id']}"><i class="fa fa-trash"></i> {$_L['Delete']}</a>*}
                                    </td>
                                </tr>

                            {/foreach}

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>


        {else}

            {foreach $d as $ds}
                <div class="col-md-3 sdiv">
                    <!-- CONTACT ITEM -->
                    <div class="panel panel-default">
                        <div class="panel-body profile">
                            <div class="profile-image">
                                {if $ds['img'] eq 'gravatar'}
                                    <img src="http://www.gravatar.com/avatar/{($ds['email'])|md5}?s=200" class="img-thumbnail img-responsive" alt="{$ds['fname']} {$ds['lname']}">
                                {elseif $ds['img'] eq ''}
                                    <img src="{$app_url}sysfrm/uploads/system/profile-icon.png" class="img-thumbnail img-responsive" alt="{$ds['fname']} {$ds['lname']}">
                                {else}
                                    <img src="{$ds['img']}" class="img-thumbnail img-responsive" alt="{$ds['account']}">
                                {/if}
                            </div>
                            <div class="profile-data">

                                <div class="profile-data-name">{$ds['account']}</div>

                            </div>

                        </div>
                        <div class="panel-body">
                            <div class="contact-info">

                                <p><small>{$_L['Email']}</small><br/>{if $ds['email'] neq ''}{$ds['email']} {else} {$_L['n_a']} {/if}</p>

                                <p>
                                    <a href="{$_url}contacts/view/{$ds['id']}/" class="btn btn-primary btn-xs"><i class="fa fa-search"></i> {$_L['View']}</a>

{*                                    <a href="delete/crm-user/{$ds['id']}/" class="btn btn-danger btn-xs cdelete" id="uid{$ds['id']}"><i class="fa fa-trash"></i> {$_L['Delete']}</a>*}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            {/foreach}

        {/if}

    </div>

 

{include file="sections/footer.tpl"}
<script type="text/javascript">
    $('#dt_table').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            "pageLength",
{*            'copy', 'excel', 'pdf', 'print'*}
        ],
        order: [[ 0, "desc" ]]
    }); 
    </script>