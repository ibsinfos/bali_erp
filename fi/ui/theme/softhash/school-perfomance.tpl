{include file="sections/header.tpl"}
<div class="row">
    

    <div class="col-md-6">

        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>{'Set School Perfomance'}</h5>
            </div>
            <div class="ibox-content">
                <form role="form" name="school_perfomance" method="post"
                      action="{$_url}settings/add_school_perfomance/">
                    <div class="form-group">
                        <label for="header_scripts">{'Academic Year'}</label>
                            <input type="text" value="{date('Y')}-{date('Y', strtotime('+1 years'))}" id="affected_from" name="affected_from" placeholder="" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="footer_scripts">{'School Perfomance'}</label>
                        <select id="school_perfomance" name="school_perfomance" class="form-control">
                            <option value="">{'Select Perfomance'}</option>
                            <option value="1" >Outstanding</option>
                            <option value="2" >Very Good</option>
                            <option value="3" >Good</option>
                            <option value="4" >Acceptable</option>
                            <option value="5" >Weak</option>
                            <option value="6" >Very Weak</option>
                        </select>

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
                    <th>School Perfomance</th>
                    <th>Status</th>
                    <th>Value</th>
                </tr>
                {foreach $perfomance as $key => $value}
               
                <tr>
                    <td>{$count++}</td>
                    <td>{$value->running_year}</td>
                    <td>{$value->school_perfomance}</td>
                    <td>{if $value->active eq '1'} {'Active'} {else} {'Inactive'} {/if}</td>
                    <td>{$value->value}</td>
                </tr>
                {/foreach}
            </table>
            
                
            
        </div>
    </div>

</div>


{include file="sections/footer.tpl"}
