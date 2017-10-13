{include file="sections/header.tpl"}
<div class="row">
    <div class="col-md-4 no-padding">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>{$_L['Add Expense']}</h5>

            </div>
            <div class="ibox-content" id="ibox_form">
                <div class="alert alert-danger" id="emsg">
                    <span id="emsgbody"></span>
                </div>
                <form class="form-horizontal" method="post" id="tform" role="form">
                    <div class="form-group">
                        <label for="account" class="col-sm-3 control-label add-no-padding">{$_L['Account']}<span class="mandatory">*</span></label>
                        <div class="col-sm-9">
                            <select id="account" name="account" class="form-control">
                                <option value="">{$_L['Choose an Account']}</option>
                                {foreach $d as $ds}
                                    <option value="{$ds['id']}">{$ds['account']}</option>
                                {/foreach}


                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="date" class="col-sm-3 control-label add-no-padding">{$_L['Date']}</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control"  value="{$mdate}" name="date" id="date" datepicker data-date-format="yyyy-mm-dd" data-auto-close="true">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description" class="col-sm-3 control-label add-no-padding">{$_L['Description']}<span class="mandatory">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="description" name="description">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="amount" class="col-sm-3 control-label add-no-padding">{$_L['Amount']}<span class="mandatory">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control amount" id="amount" name="amount">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-3">
                            &nbsp;
                        </div>
                        {*<div class="col-sm-9">
                            <h4><a href="#" id="a_toggle">{$_L['Advanced']}</a> </h4>
                        </div>*}
                    </div>
                    <div id="a_hide">
                    
                        <div class="form-group">
                            <label for="cats" class="col-sm-3 control-label add-no-padding">{'Vendor'}</label>
                            <div class="col-sm-9">
                                <select class="form-control select2" id="vendor_id">
                                    <option value="">{$_L['Select']}</option>
                                    {foreach $vendors as $vendor}
                                        <option value="{$vendor['id']}">{$vendor['name']}</option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="cats" class="col-sm-3 control-label add-no-padding">{$_L['Category']}</label>
                            <div class="col-sm-9">
                                <select id="cats" name="cats" class="form-control">
                                    <option value="Uncategorized">{$_L['Uncategorized']}</option>
                                    {foreach $cats as $cat}
                                        <option value="{$cat['name']}">{$cat['name']}</option>
                                    {/foreach}


                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tags" class="col-sm-3 control-label add-no-padding">{$_L['Tags']}</label>
                            <div class="col-sm-9">
                                <select name="tags[]" id="tags" class="form-control" multiple="multiple">
                                    {foreach $tags as $tag}
                                        <option value="{$tag['text']}">{$tag['text']}</option>
                                    {/foreach}

                                </select>
                            </div>
                        </div>
                        {*<div class="form-group">
                            <label for="payee" class="col-sm-3 control-label add-no-padding">{$_L['Payee']}</label>
                            <div class="col-sm-9">
                                <select id="payee" name="payee" class="form-control">
                                    <option value="">{$_L['Choose Contact']}</option>
                                    {foreach $p as $ps}
                                        <option value="{$ps['id']}">{$ps['account']}</option>
                                    {/foreach}


                                </select>
                            </div>
                        </div>*}
                        <div class="form-group">
                            <label for="pmethod" class="col-sm-3 control-label add-no-padding">{$_L['Method']}</label>
                            <div class="col-sm-9">
                                <select id="pmethod" name="pmethod" class="form-control">
                                    <option value="">{$_L['Select Payment Method']}</option>
                                    {foreach $pms as $pm}
                                        <option value="{$pm['name']}">{$pm['name']}</option>
                                    {/foreach}


                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ref" class="col-sm-3 control-label add-no-padding">{$_L['Ref']}#</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="ref" name="ref">
                                <span class="help-block">{$_L['ref_example']}</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-9">
                            <button type="submit" id="submit" class="btn btn-primary"><i class="fa fa-check"></i> {$_L['Submit']}</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>{$_L['Recent Expense']}</h5>

            </div>
            <div class="ibox-content">

                <table id="dt_table" class="table table-bordered sys_table">
                    <thead>
                    <tr>
                        <th>{$_L['Date']}</th>
                        <th>{$_L['Description']}</th>
                        <th>{$_L['Amount']}</th>

                    </tr>
                    </thead>
                    <tbody>

                    {foreach $tr as $trs}
                        <tr>
                            <td>{$trs['date']}</td>
                            <td><a href="{$_url}transactions/manage/{$trs['id']}">{$trs['description']}</a> </td>
                            <td class="amount">{$trs['amount']}</td>
                        </tr>
                    {/foreach}

                    </tbody>
                </table>

            </div>
        </div>
    </div>

</div>

<input type="hidden" id="_lan_no_results_found" value="{$_L['No results found']}">
<style>
    .add-no-padding{
        text-align:left !important;
        padding-left:10px;
    }
</style>
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