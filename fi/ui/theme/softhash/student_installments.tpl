{include file="sections/header.tpl"}
<div class="ibox float-e-margins">
    <div class="ibox-content">
        <form class="form-horizontal" id="installment_form">
        <div class="form-group">
            <div class="form-group col-lg-12">
                {if $classes }
                    <select name="class_id" id="class_id">
                        <option value="" >All Class</option>
                    {foreach $classes as $class}
                        <option value="{$class["id"]}" {if $class['id'] eq $class_id} selected="selected" {/if}>{$class["gname"]}</option>
                    {/foreach}
                    </select>
                {/if}
                {* <div class="form-group" style="float: right; margin-right:70%"> *}
                    {* <label class="col-lg-4" for="header_scripts">{'Academic Year'}</label> *}
                <select id="academic_year" name="academic_year">
                        <option value="">{'Select Academic Year'}</option>
                    {foreach $ry as $y}
                        <option {if $y eq $acad_year} selected="selected" {/if} value="{$y}" >
                            {$y}
                        </option>
                    {/foreach}
                </select>
                {* </div> *}
                <a href="javascript:void(0);" onclick="filter_search();" class="btn btn-primary btn-xs"><i class="fa fa-search"></i> {$_L['Filter']}</a>
                <br><br>
                </div>
        
                <table id="dt_table" class="table datatable table-bordered table-hover sys_table footable" >
                    <thead>
                        <tr>
                            <th >#</th>
                            <th>Student Name</th>
                            <th>School Fee</th>
                            <th>Transport Fee</th>
                            <th>Hostel Fee</th>
                        </tr>
                    </thead>
                    <tbody id="installment_list_by_class">
                    {foreach $inst as $key => $value}  
                        <tr>
                            <td>{$count++}</td>
                            <td>{$value['Student_name']}</td>
                            <td>{$value['schoolfee_name']} {if $value['schoolfee_inst_number'] neq ''}({$value['schoolfee_inst_number']}){/if}<br>{$value['School_fees']}</td>
                            <td>{$value['hostelfee_name']} {if $value['hostelfee_name'] neq ''}({$value['hostelfee_inst_number']}){/if}</td>
                            <td>{$value['transportfee_name']} {if $value['transportfee_name'] neq ''}({$value['transportfee_inst_number']}){/if}</td>
                        </tr>
                    {/foreach}
                    </tbody>
                </table>
            </div>
        </div>    
        </form>
    </div>    
</div>
{include file="sections/footer.tpl"}
<script lang="text/javascript">
     $('#dt_table').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            "pageLength",
{*            'copy', 'excel', 'pdf', 'print'*}
        ]
    }); 
 
    function filter_search(){
     
        var _url        =   $("#_url").val();
        var ac_year     =   $("#academic_year").val();
        var class_id    =   $("#class_id").val();
         
       $.post(_url +'installments/student_installment/filter/'+ac_year+'/'+class_id,{
           class_id: class_id,
           ac_year: ac_year,
           b_url    : _url
       }).done(function (data){
          var adrs = $("#installment_list_by_class");
            adrs.html(data);
        });
    
  }  
</script>