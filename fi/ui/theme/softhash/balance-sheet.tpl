{include file="sections/header.tpl"}

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>{'Bank Account Balance'} </h5>

            </div>
            <div class="ibox-content">

                <table class="table table-bordered sys_table">

                    <th width="80%">{$_L['Account']}</th>

                    <th class="text-right">{$_L['Balance']}</th>

                    {foreach $d as $ds}
                        <tr>

                            <td>{$ds['account']}</td>

                            <td class="text-right"><span class="amount{if $ds['balance'] < 0} text-red{/if}">{$ds['balance']}</span></td>

                        </tr>
                    {/foreach}



                </table>
                <table class="table invoice-total">
                    <tbody>

                    <tr>
                        <td><strong>{$_L['TOTAL']} :</strong></td>
                        <td><strong><span class="amount{if $tbal < 0} text-red{/if}">{$tbal}</strong></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        </div>




    <!-- Widget-2 end-->
</div> <!-- Row end-->


<!-- Row end-->


<!-- Row end-->

{include file="sections/footer.tpl"}
