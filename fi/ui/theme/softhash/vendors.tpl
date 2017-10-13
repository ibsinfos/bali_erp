{include file="sections/header.tpl"}
<div class="wrapper wrapper-content">
    
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-2 pull-right">
                            <a href="{$_url}vendors/add/" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> {'Add'}</a>
                        </div>
                    </div>
                    <br/>
                    <table  id="dt_table" class="table datatable table-bordered table-hover sys_table footable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{'Vendor Name'}</th>
                            <th class="text-right">{$_L['Manage']}</th>
                        </tr>
                        </thead>
                        <tbody>

                        {foreach $vendors as $vendor}

                            <tr>

                                <td>{$count++}</td>
                                <td>{$vendor['name']}</td>
                                
                                <td class="text-right">
                                    <a href="#" class="btn btn-danger btn-xs" id="delete" data-id="{$vendor['id']}"><i class="fa fa-times"></i>{'Delete'}</a>
                                    <a href="{$_url}vendors/edit/{$vendor['id']}/" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> {$_L['Edit']}</a>
                                   
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
     
    $( "#delete" ).click(function() {
        _url  =   $('#_url').val(); 
        vendor_id=$(this).data('id');
         
        if(confirm('Are you sure?')){
            $.post(_url + 'vendors/delete', {
                vendor_id: vendor_id,
                b_url    : _url
            })
            .done(function (data) {
                window.location.href = _url + 'vendors/list';
            });
        }
    });
    $('#dt_table').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            "pageLength",
            'copy', 'excel', 'pdf', 'print'
            ]
    }); 
</script>