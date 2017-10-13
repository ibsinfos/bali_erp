<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
<title><?php echo 'PAYMENT RECEIPT 1'?></title>
<!-- <link rel="apple-touch-icon" sizes="57x57" href="<?php //echo APP_URL; ?>/sysfrm/uploads/icon/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="<?php //echo APP_URL.'/'; ?>sysfrm/uploads/icon/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="<?php //echo APP_URL.'/'; ?>sysfrm/uploads/icon/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="<?php //echo APP_URL.'/'; ?>sysfrm/uploads/icon/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="<?php //echo APP_URL.'/'; ?>sysfrm/uploads/icon/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="<?php //echo APP_URL.'/'; ?>sysfrm/uploads/icon/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="<?php //echo APP_URL.'/'; ?>sysfrm/uploads/icon/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="<?php //echo APP_URL.'/'; ?>sysfrm/uploads/icon/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="<?php //echo APP_URL.'/'; ?>sysfrm/uploads/icon/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="<?php //echo APP_URL.'/'; ?>sysfrm/uploads/icon/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="<?php //echo APP_URL.'/'; ?>sysfrm/uploads/icon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="<?php //echo APP_URL.'/'; ?>sysfrm/uploads/icon/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="<?php //echo APP_URL.'/'; ?>sysfrm/uploads/icon/favicon-16x16.png">
<link rel="manifest" href="<?php //echo APP_URL.'/'; ?>sysfrm/uploads/icon/manifest.json">

<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="<?php //echo APP_URL.'/'; ?>sysfrm/uploads/icon/ms-icon-144x144.png"> -->
<link rel="stylesheet" href="<?php echo base_url('assets/bower_components/font-awesome/css/font-awesome.min.css')?>">
<meta name="theme-color" content="#ffffff">
<style>
    @page {
        size: <?php echo isset($PAGE_SIZE)?$PAGE_SIZE:'A4'?>;
        margin-left: <?php echo isset($M_LEFT)?$M_LEFT:'12mm'?>;
        margin-right: <?php echo isset($M_RIGHT)?$M_RIGHT:'12mm'?>;;
        margin-top: <?php echo isset($M_TOP)?$M_TOP:'12mm'?>;;
        margin-bottom: <?php echo isset($M_BOTTOM)?$M_BOTTOM:'12mm'?>;;
        padding: <?php echo isset($M_PAD)?$M_PAD:'0'?>;;
        width: <?php echo isset($WIDTH)?$WIDTH:'12mm'?>;;
        min-height: <?php echo isset($MIN_LEFT)?$MIN_LEFT:'297'?>;;
        /*width: 138.5mm*/
    }
    * { margin: 0; padding: 0; }
    body {
        font: 12px/1.4 Helvetica, Arial, sans-serif;
    }
    #page-wrap { width: 800px; margin: 0 auto; }

    textarea { border: 0; font: 14px Helvetica, Arial, sans-serif; overflow: hidden; resize: none; }
    table { border-collapse: collapse; }
    table td, table th { border: 1px solid black; padding: 5px; }

    #header { height: 15px; width: 100%; margin: 20px 0; background: #222; text-align: center; color: white; font: bold 15px Helvetica, Sans-Serif; text-decoration: uppercase; letter-spacing: 20px; padding: 8px 0px; }

    #address { width: 250px; height: 150px; float: left; }
    #customer { overflow: hidden; }

    #logo { text-align: right; float: right; position: relative; margin-top: 0px; border: 1px solid #fff; max-width: 600px; overflow: hidden; }
    #customer-title { font-size: 20px; font-weight: bold; float: left; }

    #meta { margin-top: 15px; width: 100%; float: right; }
    .marg-top-fif {
        margin-top: 15px !important;
    }
    #meta td { text-align: right;      padding: 2px 5px;}
    #meta td.meta-head { text-align: left; background: #eee; }
    #meta td textarea { width: 100%; height: 20px; text-align: right; }

    #items { clear: both; width: 100%; margin: 3px 0 0 0; border: 1px solid black; }
    #items th { background: #eee; padding:2px 5px; }
    #items textarea { width: 80px; height: 50px; }
    #items tr.item-row td {  vertical-align: top; padding:2px 5px; }
    #items td.description { width: 300px; }
    #items td.item-name { width: 175px; }
    #items td.description textarea, #items td.item-name textarea { width: 100%; }
    #items td.total-line { border-right: 0; text-align: right; padding:2px 5px;}
    #items td.total-value { border-left: 0; padding:2px 5px;}
    #items td.total-value textarea { height: 20px; background: none; }
    #items td.balance { background: #eee; }
    #items td.blank { border: 0; }

    #terms { text-align: center; margin: 20px 0 0 0; }
    #terms h5 { text-transform: uppercase; font: 13px Helvetica, Sans-Serif; letter-spacing: 10px; border-bottom: 1px solid black; padding: 0 0 8px 0; margin: 0 0 8px 0; }
    #terms textarea { width: 100%; text-align: center;}

    .sm-padding{padding: 2px 5px; }
    .note{text-transform:uppercase}   

    .delete-wpr { position: relative; }
    .delete { display: block; color: #000; text-decoration: none; position: absolute; background: #EEEEEE; font-weight: bold; padding: 0px 3px; border: 1px solid; top: -6px; left: -22px; font-family: Verdana; font-size: 12px; }

    /* Extra CSS for Print Button*/
    .button {
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        overflow: hidden;
        margin-top: 20px;
        padding: 12px 12px;
        cursor: pointer;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        -webkit-transition: all 60ms ease-in-out;
        transition: all 60ms ease-in-out;
        text-align: center;
        white-space: nowrap;
        text-decoration: none !important;

        color: #fff;
        border: 0 none;
        border-radius: 4px;
        font-size: 14px;
        font-weight: 500;
        line-height: 1.3;
        -webkit-appearance: none;
        -moz-appearance: none;

        -webkit-box-pack: center;
        -webkit-justify-content: center;
        -ms-flex-pack: center;
        justify-content: center;
        -webkit-box-align: center;
        -webkit-align-items: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-flex: 0;
        -webkit-flex: 0 0 160px;
        -ms-flex: 0 0 160px;
        flex: 0 0 160px;
    }
    .button:hover {
        -webkit-transition: all 60ms ease;
        transition: all 60ms ease;
        opacity: .85;
    }
    .button:active {
        -webkit-transition: all 60ms ease;
        transition: all 60ms ease;
        opacity: .75;
    }
    .button:focus {
        outline: 1px dotted #959595;
        outline-offset: -4px;
    }

    .button.-regular {
        color: #202129;
        background-color: #edeeee;
    }
    .button.-regular:hover {
        color: #202129;
        background-color: #e1e2e2;
        opacity: 1;
    }
    .button.-regular:active {
        background-color: #d5d6d6;
        opacity: 1;
    }

    .button.-dark {
        color: #FFFFFF;
        background: #333030;
    }
    .button.-dark:focus {
        outline: 1px dotted white;
        outline-offset: -4px;
    }
    tr{height: 15px;}

    tr td{height: 15px !important;}
    .txt-center {text-align:center}
    .txt-right {text-align:right}
    .note-table{width:100%}
    .note-table tr td{border:0px;}
    .p0{padding:0}
    .csh-line{border-left:1px solid #000 !important;vertical-align: bottom;}

    @media print
    {
        .no-print, .no-print *
        {
            display: none !important;
        }
    }
</style>

</head>
<body>

<div id="page-wrap">
    <div>   
        <div style="height: 60px !important;">
            <table width="100%">
                <tr>
                    <td style="border: 0;  padding:0; text-align: left">
                        <img id="image" src="<?php echo base_url('assets/images/logo_ag.png')?>"  width="50" height="50"  alt="logo" />
                    </td>
                
                    <td style="border: 0;  text-align: right">
                        <div id="logo" style="font-size:14px; height: auto;">
                            <div style="font-size:16px;"><b><?php echo sett('system_name'); ?></b></div>
                            <div><?php echo sett('address'); ?></div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <div style="clear:both"></div>
        <div id="customer" style=" margin-top:3px !important;">
            <table id="meta" class="marg-top-fif">
                <tr >
                    <td rowspan="6" style="border: 1px solid white; max-height: 25px; border-right: 1px solid black; text-align: left" width="42%">
                        <strong><?php echo $print_type. ' To'; ?></strong> <br>
                        Michael Doe <br/>
                        John Doe <br/>
                        Address
                        CA NY XXXX <br>
                        ONE
                    </td>
                    <td class="meta-head" style="height: 15px;"><?php echo $print_type.' No.'; ?> </td>
                    <td style="height: 15px;"><?php echo sett('system_name').'/'.date('Y-m-d').'/1'; ?></td>
                </tr>
                <tr>
                    <td class="meta-head" style="height: 15px;"><?php echo 'Enroll Code.';//$_L['Due Date']; ?></td>
                    <td style="height: 15px;">EX123</td>
                </tr>
                <tr>
                    <td style="height: 15px;" class="meta-head"><?php echo $print_type.' Date'; ?></td>
                    <td style="height: 15px;">
                        <?php echo date('d/m/Y')?>
                    </td>
                </tr>
                <tr>
                    <td style="height: 15px;" class="meta-head"><?php echo 'Mode of Payment'; ?></td>
                    <td style="height: 15px;"><?php echo get_phrase('cash')?></td>
                </tr>
            </table>
        </div>
        <div style="margin:15px 0 0 0 !important; padding: 0px !important;">
            <table id="items" class="marg-top-fif"  height="50">
            <tr>
                <th width="65%"><?php echo get_phrase('item'); ?></th>
                <th colspan="2" align="right"><?php echo get_phrase('total'); ?></th>
            </tr>
            <tr class="item-row">
                <td class="description"> Item 1</td>
                <td colspan="2" align="right"><span class="price"> <?php echo sett('currency').' 300'?></span></td>
            </tr>
            <tr class="item-row">
                <td class="description"> Item 2</td>
                <td colspan="2" align="right"><span class="price"> <?php echo sett('currency').' 200'?></span></td>
            </tr>
            <tr>
                <td colspan="3">
                    <table width="100%">
                        <tr>
                            <td class="total-line" align="right" height="15"><?php echo get_phrase('total'); ?></td>
                            <td class="total-value" align="right" height="15">
                                <div class="due"><?php echo sett('currency').' 500'?></div>
                            </td>
                            <td class="total-line" align="right" height="15"><?php echo get_phrase('previous_payment'); ?>:</td>
                            <td class="total-value" align="right" height="15">
                                <div id="subtotal"><?php echo sett('currency').' 200'?></div>
                            </td>
                        </tr>
                        <tr>
                            <td  class="total-line" align="right" height="15"><?php echo get_phrase('paid_amount')?></td>
                            <td class="total-value" align="right" height="15">
                                <div class="due"><?php echo sett('currency').' 100'?></div>
                            </td>
                    
                            <td class="total-line balance" height="15"><?php echo get_phrase('amount_due'); ?></td>
                            <td class="total-value balance" align="right" height="15">
                                <div class="due"><?php echo sett('currency').' 200'?></div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
                
            <tr>
                <td colspan="4" class="p0">
                    <table class="note-table">
                        <tr>
                            <td class="txt-center sm-padding note"> 
                                Note: fee once paid will not be refunded in any case <br/>
                                <span>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </span>
                                Computer generated <?php echo $print_type?>
                                <span>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </span>
                            </td>
                            <td class="txt-right csh-line" style="width: 190px;">Cashier  / Manager</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>  
    <br></br> 
   
   <div id="terms" style=" text-align: left;">
        <h5><?php echo 'Note'; ?></h5>
        Notes
    </div>
    <button class='button -dark center no-print'  onClick="window.print();">Click Here to Print</button>                     
</div>

</body>
</html>