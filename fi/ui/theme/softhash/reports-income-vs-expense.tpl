{include file="sections/header.tpl"}
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>{'Reports Invoice vs Payment'} </h5>

            </div>
            <div class="ibox-content">


                <h4>{'Invoice Vs Payment'}</h4>
                <hr>
                <h5>{'Total Invoice'}: {$_c['currency_code']} {number_format($ae,2,$_c['dec_point'],$_c['thousands_sep'])}</h5>
                <h5>{'Total Payment'}: {$_c['currency_code']} {number_format($ai,2,$_c['dec_point'],$_c['thousands_sep'])}</h5>
                <hr>
                {'Total Due Amount'} = {$_c['currency_code']} {number_format($aime,2,$_c['dec_point'],$_c['thousands_sep'])}
                <hr>
                <h5>{'Total Invoice This Month'}: {$_c['currency_code']} {number_format($me,2,$_c['dec_point'],$_c['thousands_sep'])}</h5>
                <h5>{'Total Payment This Month'}: {$_c['currency_code']} {number_format($mi,2,$_c['dec_point'],$_c['thousands_sep'])}</h5>
                <hr>
                {'Total Due This Month'} = {$_c['currency_code']} {number_format($mime,2,$_c['dec_point'],$_c['thousands_sep'])}
                <hr>



                <h4>{'Invoice vs Payment This Year'}</h4>
                <hr>
                <div id="placeholder" class="flot-placeholder"></div>
                <hr>


            </div>
        </div>
        </div>


</div>
 <!-- Row end-->

{include file="sections/footer.tpl"}