{include file="sections/header.tpl"}
<div class="row">
    

    <div class="col-md-6">

        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>{'Set Fee Penalty'}</h5>
            </div>
            <div class="ibox-content">
                <form role="form" name="fee_penalty" method="post"
                      action="{$_url}settings/add_penalty/">
                    <div class="form-group">
                        <label for="header_scripts">{'Academic Year'} <span class="mandatory">*</span></label>
                            <input type="text" value="{date('Y')}-{date('Y', strtotime('+1 years'))}" id="academic_year" name="academic_year" placeholder="" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="footer_scripts">{'Fee Penalty'} <span class="mandatory">*</span></label>
                        <input type="text" id="penalty_name" name="penalty_name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="footer_scripts">{'Penalty Type'} <span class="mandatory">*</span></label>
                        <select class="form-control" name="penalty_type">
                            <option value="1">Fix</option>
                            <option value="2">Per day</option>
                        </select>
                    </div>
                    {* <div class="form-group">
                        <label for="footer_scripts">{'Amount'} <span class="mandatory">*</span></label>
                        <input type="text" id="amount_per_day" name="amount_per_day" class="form-control">
                    </div>    *} 
                    <div class="form-group">
                        <label for="footer_scripts">{'Amount'} <span class="mandatory">*</span></label>
                        <input type="text" id="amount" name="amount" class="form-control">
                    </div>   
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> {$_L['Submit']}</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="ibox-content">
            <table class="table table-bordered table-hover sys_table footable" data-page-size="50">
                <tr>
                    <th >#</th>
                    <th>Running Year</th>
                    <th>Penalty Name</th>
                    <th>Type</th>
                    <th>Amount</th>
                    {* <th>Amount Per Day</th> *}
                    <th>Status</th>
                </tr>
                {foreach $penalty as $key => $value}
                <tr>
                    <td>{$count++}</td>
                    <td>{$value->academic_year}</td>
                    <td>{$value->penalty_name}</td>
                    <td>{$value->penalty_type}</td>
                    <td>{$value->amount}</td>
                    {* <td>{$value->amount_per_day}</td> *}
                    <td>{if $value->status eq '1'} {'Active'} {else} {'Inactive'} {/if}</td>
                </tr>
                {/foreach}
            </table>
        </div>
    </div>

</div>


{include file="sections/footer.tpl"}
