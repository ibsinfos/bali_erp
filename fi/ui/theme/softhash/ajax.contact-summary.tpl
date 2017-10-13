<style type="text/css">
    .wid-15 {
        float: right;
       padding-right:60%;
       text-align: left;
       
    }
</style>
<p>

    <strong >{$_L['Full Name']}: </strong> <span class="wid-15">{$d['account']}</span> <br>
   {if ($d['company']) neq ''}
       <strong>{'Parent Name'}: </strong> <span class="wid-15">{$d['company']}</span> <br>
   {/if}
    <strong>{$_L['Email']}: </strong> <span class="wid-15">{if ($d['email']) neq ''} {$d['email']} {else} N/A {/if} </span><br>
    <strong>{$_L['Phone']}: </strong> <span class="wid-15">{if ($d['phone']) neq ''} {$d['phone']} {else} N/A {/if} </span><br>
    <strong>{$_L['Address']}: </strong> <span class="wid-15">{if ($d['address']) neq ''} {$d['address']} {else} N/A {/if} </span><br>
    <strong>{$_L['City']}: </strong> <span class="wid-15">{if ($d['city']) neq ''} {$d['city']} {else} N/A {/if} </span><br>
    <strong>{$_L['State Region']}: </strong><span class="wid-15"> {if ($d['state']) neq ''} {$d['state']} {else} N/A {/if} </span><br>
    <strong>{$_L['ZIP Postal Code']}: </strong> <span class="wid-15">{if ($d['zip']) neq ''} {$d['zip']} {else} N/A {/if} </span><br>
    <strong>{$_L['Country']}: </strong> <span class="wid-15">{if ($d['country']) neq ''} {$d['country']} {else} N/A {/if}</span> <br>
{*    <strong>{$_L['Tags']}: </strong> {if ($d['tags']) neq ''} {$d['tags']} {else} N/A {/if} <br>*}
    <strong>{'Class'}: </strong> <span class="wid-15">{if ($d['gname']) neq ''} {$d['gname']} {else} N/A {/if} </span><br>

    {foreach $cf as $c}

        <strong>{$c['fieldname']}: </strong> <span class="wid-15">{if get_custom_field_value($c['id'],$d['id']) neq ''} {get_custom_field_value($c['id'],$d['id'])} {else} N/A {/if} </span><br>

    {/foreach}

</p>

<hr>


<table class="table table-hover margin bottom">
    <thead>
    <tr>

        <th colspan="3">{$_L['Accounting Summary']}</th>

    </tr>
    </thead>
    <tbody>
    <tr>

        <td> {'Total Paid'}
        </td>
        <td class="text-center"><span class="label label-primary amount" data-a-dec="{$_c['dec_point']}" data-a-sep="{$_c['thousands_sep']}" data-a-pad="{$_c['currency_decimal_digits']}" data-p-sign="{$_c['currency_symbol_position']}" data-a-sign="{$_c['currency_code']} " data-d-group="{$_c['thousand_separator_placement']}">{$ti}</span></td>

    </tr>
    <tr>

        <td> {'Total Invoice'}
        </td>
        <td class="text-center"><span class="label label-primary amount" data-a-dec="{$_c['dec_point']}" data-a-sep="{$_c['thousands_sep']}" data-a-pad="{$_c['currency_decimal_digits']}" data-p-sign="{$_c['currency_symbol_position']}" data-a-sign="{$_c['currency_code']} " data-d-group="{$_c['thousand_separator_placement']}">{$te}</span></td>


    </tr>
    <tr>

        <td> {'Total Balance'}
        </td>
        <td class="text-center"><span class="label label-danger amount" data-a-dec="{$_c['dec_point']}" data-a-sep="{$_c['thousands_sep']}" data-a-pad="{$_c['currency_decimal_digits']}" data-p-sign="{$_c['currency_symbol_position']}" data-a-sign="{$_c['currency_code']} " data-d-group="{$_c['thousand_separator_placement']}">{$te-$ti}</span></td>


    </tr>
    </tbody>
</table>