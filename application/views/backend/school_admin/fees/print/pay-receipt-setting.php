<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('print_receipt_setting');?></h4> 
    </div>

    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript:void(0);" onclick="javascript:introJs().start();" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?<?php echo $this->session->userdata('login_type');?>/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>

            <?php $BRC = get_bread_crumb(); if (strpos($BRC, '^') !== false) { $ExpBrd = explode('^', $BRC);?>
            <li>
                <?php echo get_phrase(@$ExpBrd[0]); ?>
                <?php echo @$ExpBrd[1]; ?>
            </li> <?php }else{ $ExpBrd[2] = $BRC;}?>
            <li class="active">
                <?php echo get_phrase(@$ExpBrd[2]); ?>
            </li>
        </ol> 
    </div>

    <!-- /.page title -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-md-12 white-box">
        <div class="row"> 
            <form method="post" id="print-form">
                <div class="col-md-8 col-md-offset-2">
                    <div class="row mt10">
                        <div class="col-md-12">
                            <h3 class="bg-primary text-left" style="padding:10px;"><?php echo get_phrase('payment_receipt')?></h3>       
                        </div>   
                    </div>     
                    
                    <div class="row mt10">
                        <div class="col-md-12 print-page">
                            <iframe id="NORMAL" src="<?php echo base_url('index.php?fees/prints/preview/pay-receipt/'.sett('pay_receipt_print_size'))?>" 
                            frameborder="0" scrolling="no" style="width: 100%;height:600px;border:1px solid;
                            display:<?php echo sett('pay_receipt_print_type')=='pay-receipt'?'block':'none'?>">
                            </iframe>  
                            <iframe id="THERMAL" src="<?php echo base_url('index.php?fees/prints/preview/thermal-pay-receipt')?>"
                            frameborder="0" scrolling="no" style="width: 402px;height:600px;border:1px solid;
                            display:<?php echo sett('pay_receipt_print_type')=='thermal-pay-receipt'?'block':'none'?>">
                            </iframe>  
                        </div>   
                    </div> 
                    <hr/>

                    <h3>Page Type</h3>
                    <div class="row">
                        <div class="col-md-2">
                            <label>
                                <input type="radio" name="print_type" value="pay-receipt" <?php echo sett('pay_receipt_print_type')=='pay-receipt'?'checked':''?>/> Normal
                            </label>
                        </div>  
                        <div class="col-md-2">
                            <label>
                                <input type="radio" name="print_type" value="thermal-pay-receipt" <?php echo sett('pay_receipt_print_type')=='thermal-pay-receipt'?'checked':''?>/> Thermal
                            </label>           
                        </div>  
                    </div>


                    <div class="print-size <?php echo sett('pay_receipt_print_type')!='pay-receipt'?'dis-none':''?>"> 
                        <h3>Page Size</h3>
                        <div class="row">
                            <div class="col-md-4">
                                <select name="print_size" class="selectpicker" data-style="form-control">
                                    <option value="A4" <?php echo sett('pay_receipt_print_size')=='A4'?'selected':''?>>A4</option>
                                    <option value="A5" <?php echo sett('pay_receipt_print_size')=='A5'?'selected':''?>>A5</option>
                                    <option value="A6" <?php echo sett('pay_receipt_print_size')=='A6'?'selected':''?>>A6</option>
                                </select>      
                            </div>  
                        </div>
                    </div>
                    
                    <div class="row mt10">
                        <div class="col-md-2 pull-right">
                            <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d">Save</button>  
                        </div>  
                    </div>

                </div>
            </form>    
        </div>
    </div>
</div>
<script>
$('input[name=print_type]').change(function(){
   if(this.value=='pay-receipt') {
        $('#NORMAL,.print-size').show();
        $('#THERMAL').hide();
   }else{
        $('#NORMAL,.print-size').hide();
        $('#THERMAL').show();
   }
});
</script>
