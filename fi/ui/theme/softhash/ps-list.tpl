{include file="sections/header.tpl"}
<div class="wrapper wrapper-content animated fadeInUp">

    <div class="ibox">
        <div class="ibox-title">
            <h5>{if $type eq 'Product'} {'Fee List'} {else if $type eq 'Service'} {'Charge List'} {else} {'One type Fee for Enquery'}{/if}</h5>
            <div class="ibox-tools">
                {if $type eq 'Product'} <a href="{$_url}ps/p-new" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i> {'Add Fee'}</a>{/if}
                {if $type eq 'Service'}<a href="{$_url}ps/s-new" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i> {'Add Charge'}</a>{/if}
                {if $type eq 'OneTimeFeeBeforeAdmission'}<a href="{$_url}ps/one-time-fee-before-admission-add" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i> {'Add Enquery Fees'}</a>{/if}
            </div>
        </div>
        <div class="ibox-content" id="ibox_form">
            <div class="input-group">
                <input type="text" placeholder="{$_L['Search']}" id="txtsearch" class="form-group"> 
                <span class="input-group-btn"><button type="button"  id="search" class="btn btn-sm btn-primary"> {$_L['Search']}</button> </span>
            </div>
            <br>
            <div class="input-group">
                <select id="fee_type" name="fee_type">
                    <option value=" ">Select Fee Type</option>
                    {foreach $fee_types as $key=> $value}
                        <option {if $selected_fee_type eq $value['id']}selected{/if} value="{$value['id']}">{$value['name']}</option>
                    {/foreach}
                </select>
            </div>    
            <input type="hidden" id="stype" value="{$type}">

            <div class="project-list mt-md">
                <div id="progressbar">    </div>
                <div id="sysfrm_ajaxrender">   </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="_lan_are_you_sure" value="{$_L['are_you_sure']}">

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