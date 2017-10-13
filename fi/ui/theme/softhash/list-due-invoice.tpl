    {include file="sections/header.tpl"}
<style type="text/css">
    #date_diff {
        display: none;
    }
</style>
<div class="ibox float-e-margins">
    
    <div class="ibox-content">

        
        <form class="form-horizontal" method="post" action="{$_url}">
            {if $classes }
                <select name="class_id" id="class_id">
                    <option value="" >Select Class</option>
                    <option value="all">All Class</option>
                    {foreach $classes as $class}
                        <option {if $class_id eq $class["id"]}selected{/if} value="{$class["id"]}" >{$class["gname"]}</option>
                    {/foreach}
                </select>
            {/if}
            <br><br>
                <input value="{if $from_date neq '0'}{$from_date}{/if}" type="text" datepicker data-date-format="yyyy-mm-dd" data-auto-close="true" name="from_date" id="from_date" placeholder="Due From">&nbsp;&nbsp;&nbsp;
                <input value="{if $to_date neq '0'}{$to_date}{/if}" type="text" datepicker data-date-format="yyyy-mm-dd" data-auto-close="true" name="to_date" id="to_date" placeholder="Due To"> &nbsp;&nbsp;&nbsp;
                <a href="javascript:void(0);" onclick="filter_search();" class="btn btn-primary btn-xs"><i class="fa fa-search"></i> {$_L['Filter']}</a>
            <br>
            <span id="date_diff" class="mandatory">From Date should be less than To Date</span>
            <br> 
        </form>
                <table id="dt_table" class="table datatable table-bordered table-hover sys_table footable" {if $view_type == 'filter'} data-filter="#foo_filter" data-page-size="50" {/if}>
            <thead>
            <tr>
                <th>#</th>
                <th>{$_L['Account']}</th>
                <th>{$_L['Amount']}</th>
                <th>{$_L['Invoice Date']}</th>
                <th>{$_L['Due Date']}</th>
                <th>
                    {$_L['Status']}
                </th>
                <th class="text-right">{$_L['Manage']}</th>
            </tr>
            </thead>
            <tbody id="invoice_list_by_class">

            {foreach $d as $ds}
                <tr>
                    <td><a href="{$_url}invoices/view/{$ds['id']}/">{$ds['invoicenum']}{if $ds['cn'] neq ''} {$ds['cn']} {else} {$ds['id']} {/if}</a> </td>
                    <td><a href="{$_url}contacts/view/{$ds['userid']}/">{$ds['account']}</a> </td>
                    <td class="amount">{$ds['total']}</td>
                    <td>{date( $_c['df'], strtotime($ds['date']))}</td>
                    <td>{date( $_c['df'], strtotime($ds['duedate']))}</td>
                    <td>

                        {if $ds['status'] eq 'Unpaid'}
                            <span class="label label-danger">{ib_lan_get_line($ds['status'])}</span>
                            {elseif $ds['status'] eq 'Paid'}
                            <span class="label label-success">{ib_lan_get_line($ds['status'])}</span>
                        {elseif $ds['status'] eq 'Partially Paid'}
                            <span class="label label-info">{ib_lan_get_line($ds['status'])}</span>
                        {elseif $ds['status'] eq 'Cancelled'}
                            <span class="label">{ib_lan_get_line($ds['status'])}</span>
                        {else}
                            {ib_lan_get_line($ds['status'])}
                        {/if}



                    </td>
                    
                    <td class="text-right">
                        <a href="{$_url}invoices/view/{$ds['id']}/" class="btn btn-primary btn-xs"><i class="fa fa-check"></i> {$_L['View']}</a>
                        <!--<a {*if $ds['status'] eq 'Unpaid'}  href="{$_url}invoices/edit/{$ds['id']}/" {else} disabled='true' href="javascript:void(0);" title="Can't Edit"  {/if} class="btn btn-info btn-xs">
                            {if $ds['status'] eq 'Unpaid'} <i class="fa fa-pencil"></i> {$_L['Edit']} {else}  &nbsp;&nbsp;&nbsp;{'Paid'} {/if*}</a>  -->
                        {*<a href="#" class="btn btn-danger btn-xs cdelete" id="iid{$ds['id']}"><i class="fa fa-trash"></i> {$_L['Delete']}</a>*}
                    </td>
                </tr>
            {/foreach}

            </tbody>

            

        </table>
    </div>
</div>
{include file="sections/footer.tpl"}
<script type="text/javascript">
    loadDataTable();
    function loadDataTable() {
        $('#dt_table').DataTable({
            dom: 'Bfrtip',
            responsive: true,
            buttons: [
                "pageLength",
                {
                    extend: 'print',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5 ]
                    }
                },
                {
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5 ]
                    }
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5 ]
                    }
                },
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5 ]
                    },
                    customize: function (doc) {
                        doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                    }
                }
            ],
            order: [[ 0, "desc" ]]
        }); 
    }
  function filter_search(){
      var _url  =   $('#_url').val();
      var class_id = $('#class_id').val();
        var from_date = $('#from_date').val();
        var to_date = $('#to_date').val();
        var param       =   '';
        var x   =       new Date(from_date);//'';
        var y   =       new Date(to_date);//'Here'; 

        if(from_date != '' && to_date && x > y) {
            $("#date_diff").show();
            return false;
        } else {
            $("#date_diff").hide();
        }
        if(class_id !='' && from_date !='' && to_date !='') {
            param       =   class_id+'/'+from_date+'/'+to_date;
        } else if(class_id != '' && from_date !='') {
            param       =   class_id+'/'+from_date;
        } else if (class_id != '' && to_date !='') {
            param       =   class_id+'/0/'+to_date;
        } else {
            param       =   class_id;
        }
        //console.log(param);return false;
            
      window.location.href = _url + 'invoices/due-list/filter/'+param;


{*      
  var dt_table = $('#dt_table').DataTable();
      $.post(_url + 'invoices/due-list/filter', {
        class_id: $('#class_id').val(),
        from_date: $('#from_date').val(),
        to_date: $('#to_date').val(),
        b_url    : _url
    })
        .done(function (data) {
            var adrs = $("#invoice_list_by_class");


            adrs.html(data);
            
 
            {*dt_table.ajax.reload( function ( data ) {
                $('#dt_table').val( data.table_data );
            } );

        });*}
  }  
</script>
