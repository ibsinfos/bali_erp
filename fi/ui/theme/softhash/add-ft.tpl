{include file="sections/header.tpl"}
<div class="wrapper wrapper-content">
    <div class="row">

        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>
                        {'Add Fee Type'}
                    </h5>
                    {*<div class="ibox-tools">
                           <a href="{$_url}ps/p-list" class="btn btn-primary btn-xs">{'List Fees'}</a>
                    </div>*}
                </div>
                <div class="ibox-content" id="ibox_form">
                    <div class="alert alert-danger" id="emsg">
                        <span id="emsgbody"></span>
                    </div>

                    <form class="form-horizontal" id="rform">
                        {if $ftype['id'] neq '' }
                            <input type="hidden" id="type_id" name="type_id" value="{$ftype['id']}" class="form-control" >
                        {/if}
                        <div class="form-group"><label class="col-lg-2 control-label" >{'Fee Pay Mode'}<span class="mandatory">*</span></label>
                            <div class="col-lg-10">
                                <select  id="fee_mod" name="fee_mod" class="form-control">
                                    <option {if $ftype['pay_type'] eq 'regular' } {'selected'} {/if}value="regular">{'Regular Payment'}</option>
                                    <option {if $ftype['pay_type'] eq 'single' } {'selected'} {/if}value="single">{'Single Payment'}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"><label class="col-lg-2 control-label" for="name">{'Type Name'}<span class="mandatory">*</span></label>

                            <div class="col-lg-10"><input type="text" id="name" {if $ftype['name'] neq '' }value="{$ftype['name']}"{/if} name="name" class="form-control" autocomplete="off">

                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">

                                <button {if $ftype['id'] neq '' } action="edit" {else}action="add"{/if} class="btn btn-sm btn-primary" type="submit" id="submit">{$_L['Submit']}
                                    
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <table class="table table-bordered table-hover sys_table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{$_L['Name']}</th>
                            <th>{'Fee Mode'}</th>
                            <th>{'Created On'}</th>
                            <th class="text-right">{$_L['Manage']}</th>
                        </tr>
                        </thead>
                        <tbody>

                        {foreach $ft as $ftype}

                            <tr>

                                <td>{$ftype['id']}</td>
                                <td>{$ftype['name']}</td>
                                <td>{$ftype['pay_type']}</td>
                                <td>{$ftype['created_date']}</td>
                                <td class="text-right">
                                    {if $ftype['id'] > '6'}<a href="{$_url}ps/edit-ft/{$ftype['id']}/" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> {$_L['Edit']}</a>
                                      {else}No Edit{/if}
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