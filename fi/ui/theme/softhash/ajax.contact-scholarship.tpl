<div id="no-more-tables">
    <table class="table table-bordered sys_table">
       <th class="text-right">{$_L['Scholarship Name']}</th>
        <th class="text-right">{$_L['Deduction Type']}</th>
        <th class="text-right">{$_L['Deduction Value']}</th>
        <th class="text-right">{$_L['Academic Year']}</th>
        {foreach $tr as $ds}
            <tr class="text-right">
                <td>{$ds['scholarship_name']}</td>
                <td>{if $ds['deduction_type'] eq 1}Amount{else if $ds['deduction_type'] eq 2}Percentage{/if}</td>
                <td>{$ds['deduction_value']}</td>
                <td>{$ds['academic_year']}</td>
            </tr>
        {/foreach}
    </table>
    </div>
