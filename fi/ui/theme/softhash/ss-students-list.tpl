{include file="sections/header.tpl"}
 
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form class="form-horizontal" method="post" action="{$_url}">
                        {if $classes }
                            <select name="class_id" id="class_id">
                                <option value="" >Select All Class</option>
                            {foreach $classes as $class}
                                <option {if $class_id eq $class['id']}{'selected'}{/if} value="{$class["id"]}" >{$class["gname"]}</option>
                            {/foreach}
                            </select>
                        {/if}
                        {if $scholarships }
                            <select name="scholarship_id" id="scholarship_id">
                                <option value="" >Select All Scholarship</option>
                            {foreach $scholarships as $scholarshipdet}
                                <option {if $scholarship_id eq $scholarshipdet['id']}{'selected'}{/if} value="{$scholarshipdet["id"]}" >{$scholarshipdet["scholarship_name"]}</option>
                            {/foreach}
                            </select>
                        {/if}
                         
                            <a href="javascript:void(0);" onclick="filter_search();" class="btn btn-primary btn-xs"><i class="fa fa-search"></i> {$_L['Filter']}</a>
                        <br><br> 
                    </form>
                    <table  id="dt_table" class="table datatable table-bordered table-hover sys_table footable">
                        <thead>
                           <tr>
                               <th>#</th>
                               <th>{$_L['Name']}</th>
                               <th>{'Scholarship Name'}</th>
                               <th>{'Deduction Type'}</th>
                               <th>{'Deduction Value'}</th>
                               <th class="text-right">{$_L['Manage']}</th>
                           </tr>
                        </thead>
                        <tbody id='student_list_by_class'>
                            {foreach $d as $ds}
                                <tr>
                                    <td><a href="{$_url}contacts/view/{$ds['userid']}/">{$count++}</a> </td>
                                    <td><a href="{$_url}contacts/view/{$ds['id']}/">{$ds['account']}</a> </td>
                                   <td>{$ds['scholarship_name']}</td>
                                   <td>{if $ds['deduction_type'] eq "1"}Amount{else if $ds['deduction_type'] eq "2"}Percentage{/if} {$ds['deduction_type']}</td>
                                    <td>{$ds['deduction_value']}</td>
                                    <td class="text-right">
                                        <a href="{$_url}contacts/view/{$ds['userid']}/" class="btn btn-primary btn-xs"><i class="fa fa-search"></i> {$_L['View']}</a>
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
    $('#dt_table').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            "pageLength",
{*            'copy', 'excel', 'pdf', 'print'*}
        ]
    }); 
    
  function filter_search(){
        var _url            =   $('#_url').val();
        var class_id        =   $('#class_id').val();
        var scholarship_id  =   $('#scholarship_id').val();
        window.location     =   _url + 'fee-deductions/ss-students-list/filter/'+class_id+'/'+scholarship_id;
        {*$.post(', {
            class_id: $('#class_id').val(),
            scholarship_id: $('#scholarship_id').val(),
            b_url    : _url
        })
        .done(function (data) {
            var adrs = $("#student_list_by_class");
            adrs.html(data);

        });*}
        
        
  }  
</script>