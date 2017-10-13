{include file="sections/header.tpl"}
<div class="wrapper wrapper-content animated fadeInUp">

    <div class="ibox">
        <form id="insta-form">
        <div class="ibox-content" id="ibox_form">
            <div class="alert alert-success" id="emsg">
                <span id="emsgbody"></span>
            </div>
            {* <div class="input-group">
                <input type="text" placeholder="{$_L['Search']}" id="txtsearch" class="form-group"> 
                <span class="input-group-btn"><button type="button"  id="search" class="btn btn-sm btn-primary"> {$_L['Search']}</button> </span>
            </div>
            <br> *}
            <div class="row" id="ibox_form">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-2">
                            <select id="academic_year" class="form-control" name="academic_year" required>
                                <option value=" ">Academic Year</option>
                                {foreach $ry as $y}
                                    <option value="{$y}"> {$y} </option>
                                {/foreach}
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select id="group_id" class="form-control" name="group_id" required>
                                <option value=" ">Select Group</option>
                                {foreach $gs as $key=> $value}
                                    <option {* {if $selected_fee_type eq $value['id']}selected{/if }  *}value="{$value['group_id']}">{$value['gname']}</option>
                                {/foreach}
                            </select>
                        </div>
                        {* <div class="col-md-2">
                            <select id="fee_type_id" class="form-control" name="fee_type_id" required>
                                <option value=" ">Select Fee Type</option>
                                {foreach $fee_types as $key=> $value}
                                    <option value="{$value['id']}">{$value['name']}</option>
                                {/foreach}
                            </select>
                        </div> *}
                        <div class="col-md-2">
                            <select id="installment_id" class="form-control" name="installment_id" required>
                                <option value=" ">Select Installment</option>
                                {foreach $installments as $key=> $value}
                                    <option value="{$value['id']}">{$value['installment_name']}</option>
                                {/foreach}
                            </select>
                        </div>
                        <div class="col-md-2">
                            <span class="input-group-btn"><button type="button" id="fetch_insta" class="btn btn-sm btn-primary"> {$_L['Submit']}</button></span>
                        </div>
                    </div>
                    <br/>

                    {* <div class="row" id="sys-item-box" style="display:none">
                        <div class="col-md-2">
                            <select id="sys-items" class="form-control" name="sys_item_id" required>
                                <option value=" ">Select Item</option>
                            </select>
                        </div> 
                        <div class="col-md-2">
                            <span class="input-group-btn">
                                <button type="button" id="fetch_insta" class="btn btn-sm btn-primary"> {$_L['Search']}</button> 
                            </span>
                        </div>
                    </div> *}
                </div>
            </div> 
            <br/><br/>

            <div class="row">
                <div class="col-md-12">
                    <table id="item-data" style="width:400px">
                        <tbody>
                        </tbody>
                        <tfoot>
                        </tfoot>
                    </table>
                </div>
            </div>  
            <br/><br/>

            <div class="row">
                <div class="col-md-12">
                    <div id="insta-data">
                    </div>
                </div>
            </div>  

            <div class="row save-insta" style="display:none">
                <div class="col-md-12">
                    <span class="input-group-btn">
                        <button type="button" id="save_insta" class="btn btn-sm btn-primary pull-right"> {'Save'}</button> 
                    </span>
                </div>
            </div>  

            <div class="project-list mt-md">
                <div id="progressbar">    </div>
                <div id="sysfrm_ajaxrender">   </div>
            </div>
        </div>
        </form>
    </div>
</div>
<input type="hidden" id="_lan_are_you_sure" value="{$_L['are_you_sure']}">

{include file="sections/footer.tpl"}
