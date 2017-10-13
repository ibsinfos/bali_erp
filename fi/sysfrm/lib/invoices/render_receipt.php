<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<!--
Dynamically Auto Generated Page - Do Not Edit
================================================================
Software Name: iBilling - CRM, Accounting and Invoicing Software
Version: 3.3.0
Author: Sadia Sharmin
Website: http://www.ibilling.io/
Contact: sadiasharmin3139@gmail.com
Purchase: http://codecanyon.net/item/ibilling-accounting-and-billing-software/11021678?ref=SadiaSharmin
License: You must have a valid license purchased only from envato(the above link) in order to legally use this Software.
========================================================================================================================
-->


<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />

    <title><?php echo 'INVOICE RECEIPT'; ?> <?php echo $d['id']; ?></title>
    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo APP_URL; ?>/sysfrm/uploads/icon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo APP_URL.'/'; ?>sysfrm/uploads/icon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo APP_URL.'/'; ?>sysfrm/uploads/icon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo APP_URL.'/'; ?>sysfrm/uploads/icon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo APP_URL.'/'; ?>sysfrm/uploads/icon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo APP_URL.'/'; ?>sysfrm/uploads/icon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo APP_URL.'/'; ?>sysfrm/uploads/icon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo APP_URL.'/'; ?>sysfrm/uploads/icon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo APP_URL.'/'; ?>sysfrm/uploads/icon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo APP_URL.'/'; ?>sysfrm/uploads/icon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo APP_URL.'/'; ?>sysfrm/uploads/icon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo APP_URL.'/'; ?>sysfrm/uploads/icon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo APP_URL.'/'; ?>sysfrm/uploads/icon/favicon-16x16.png">
    <link rel="manifest" href="<?php echo APP_URL.'/'; ?>sysfrm/uploads/icon/manifest.json">
    <link rel="stylesheet" href="<?php echo APP_URL.'/'; ?>../assets/css/icons/font-awesome/css/font-awesome.min.css">

    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?php echo APP_URL.'/'; ?>sysfrm/uploads/icon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <style>

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
<?php $rcpt= ucfirst('receipt');
$RunningYear?>
<body>

<div id="page-wrap">
    <div style="height: 60px !important;">
    <table width="100%">
        <tr>
            <td style="border: 0;  padding:0; text-align: left">
                <img id="image" src="<?php echo APP_URL; ?>/sysfrm/uploads/system/logo.png"  width="80" height="80"  alt="logo" />
                <?php  /*<br><br>
                        <span style="font-size: 18px; color: #2f4f4f"><strong><?php echo strtoupper($rcpt); ?> # <?php */
                        if($d['cn'] != ''){
                            $dispid = $d['cn'];
                        }else{
                            $dispid = $d['id'];
                        }
                       //echo 'DA/'.$invoiceRunningYear.'/'.$d['invoicenum'].$dispid;*/
                        ?></strong></span>
            </td>
           
            <td style="border: 0;  text-align: right">
                <div id="logo" style="font-size:14px; height: auto;">
                    <div style="font-size:16px;"><b><?php echo $customSysName; ?></b></div>
                    <div><?php echo $config['caddress']; ?></div>
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
                    <strong><?php echo $print_type. " To"; ?></strong> <br>
                    <?php if($a['company'] != '') {?>
                        Mr. <?php echo $a['company']; ?> <br>
                       <?php echo $_L['ATTN']; ?>: <?php echo $a['account']; ?> <br>
                    <?php  } else{?>
                        <?php echo $d['account']; ?> <br>
                    <?php }?>

                    <?php echo $a['address']; ?>  <?php echo $a['city']; ?> <?php echo $a['state']; ?> <?php echo $a['zip'];?> 
                    <?php //echo $a['country']; ?> 
                    <br>
                    <?php
                    if(($a['phone']) != ''){
                        echo 'Phone: '. $a['phone']. ' <br>';
                    }
                    echo 'Class: '.$className;
                    /* if(($a['email']) != ''){
                        echo 'Email: '. $a['email']. ' <br>';
                    } 
                    foreach ($cf as $cfs){
                        echo $cfs['fieldname'].': '. get_custom_field_value($cfs['id'],$a['id']). ' <br>';
                    } */
                    ?>
                </td>
                <td class="meta-head" style="height: 15px;"><?php echo $print_type.' No.'; ?> </td>
                <td style="height: 15px;"><?php echo 'MIS/'.$invoiceRunningYear.'/'.$d['invoicenum'].$dispid; ?></td>
            </tr>
            <tr>
                <td class="meta-head" style="height: 15px;"><?php echo 'Admission No.';//$_L['Due Date']; ?></td>
                <td style="height: 15px;"><?php echo $admission_no;//$studentEnroleCode;//date($config['df'], strtotime($d['duedate'])); ?></td>
            </tr>
            <tr>
                <td style="height: 15px;" class="meta-head"><?php echo $_L['Status']; ?></td>
                <td style="height: 15px;" ><?php echo ib_lan_get_line($d['status']);?></td>
            </tr>
            <tr>
                <td style="height: 15px;" class="meta-head"><?php echo $print_type.' Date'; ?></td>
                <td style="height: 15px;">
                    <?php $trs_lst_ind = count($trs)>0?(count($trs)-1):FALSE; 
                        echo (is_numeric($trs_lst_ind))?date($config['df'], strtotime($trs[$trs_lst_ind]['date'])):date($config['df'], strtotime($d['date']));
                    ?>
                </td>
            </tr>
            <tr>
                <td style="height: 15px;" class="meta-head"><?php echo 'Mode of Payment'; ?></td>
                <td style="height: 15px;"><?php echo $d['paymentmethod'].($d['ref_no']!=''?' / '.$d['ref_no']:'')?></td>
            </tr>
            <tr>
                <td style="height: 15px;" class="meta-head"><?php echo 'No of Installments'; ?></td>
                <td style="height: 15px;"><?php echo $total_intallments?></td>
            </tr>
            <?php /*<tr>
                <td class="meta-head"><?php echo $_L['Due Date']; ?></td>
                <td><?php echo date($config['df'], strtotime($d['duedate'])); ?></td>
            </tr>

            <tr>
                <td class="meta-head"><?php echo $_L['Amount Due']; ?></td>
                <td><div class="due"><?php echo $config['currency_code'].' '.$i_due; ?></div></td>
            </tr>*/?>
        </table>
    </div>
    <div style="height: 250px !important;  margin:15px 0 0 0 !important; padding: 0px !important;">
        <table id="items" class="marg-top-fif"  height="50">
        <tr>
            <th height="20"><?php echo 'Particulars'; ?></th>
            <th align="right" height="20"><?php echo $_L['Amount']; ?></th>
            <!--<th align="right"><?php $_L['Qty']; ?></th>-->
            <th align="right" height="20" style="width: 190px;"><?php echo $_L['Total']; ?></th>
        </tr>
        <?php
        foreach ($items as $item){
            echo '<tr class="item-row">
                    <td class="description" height="15">'.$item['description'].'</td>
                    <td align="right" height="15">'.$currSymbol.' '.number_format($item['amount'],2,$config['dec_point'],$_c['thousands_sep']).'</td>
                    <td align="right" height="15"><span class="price"> '.$currSymbol.' '.number_format($item['total'],2,$config['dec_point'],$_c['thousands_sep']).'</span></td>
                </tr>';
        } ?>
        <tr>
            <td colspan="3">
                <table width="100%">
                    <tr>
                        <td class="total-line" align="right" height="15"><?php echo $_L['Sub Total']; ?>:</td>
                        <td class="total-value" align="right" height="15"><div id="subtotal"><?php echo $currSymbol;?> <?php echo number_format($d['subtotal'],2,$config['dec_point'],$_c['thousands_sep']); ?></div></td>
                        <td class="total-line" align="right" height="15"><?php echo 'Total'; ?></td>
                        <td class="total-value" align="right" height="15"><div class="due"><?php echo $currSymbol;?> <?php echo number_format($d['total'],2,$config['dec_point'],$_c['thousands_sep']);; ?></div></td>
                    </tr>
                    <?php
                    if($d['credit'] != '0.00'){
                        ?>
                        <tr>
                            <td  class="total-line" align="right" height="15"><?php echo $_L['Total Paid']; ?></td>
                            <td class="total-value" align="right" height="15"><div class="due"><?php echo $currSymbol; ?> <?php echo number_format($d['credit'],2,$config['dec_point'],$_c['thousands_sep']);; ?></div></td>
                        <?php
                        if(($d['discount']) != '0.00') {
                        ?>
                            <td class="total-line" align="right" height="15"><?php echo $_L['Discount']; ?>
                                <?php
                                if($d['discount_type'] == 'p'){
                                    echo '('.$d['discount_value'].')%';
                                } ?>
                                 :
                                <div id="subtotal"><?php echo $currSymbol; ?> <?php echo number_format($d['discount'],2,$config['dec_point'],$_c['thousands_sep']); ?></div>    
                            </td>
                            <td class="total-line balance" height="15"><?php echo $_L['Amount Due']; ?>:<div class="due"><?php echo $currSymbol?> <?php echo $i_due; ?></div></td>
                        <?php } else { ?>
                            <td class="total-line balance" height="15"><?php echo $_L['Amount Due']; ?></td>
                            <td class="total-value balance" align="right" height="15"><div class="due"><?php echo $currSymbol;?> <?php echo $i_due; ?></div></td>
                        <?php } ?>
                        </tr>
                    <?php
                    } else {
                        ?>
                        <tr>
                            <td colspan="2" class="total-line balance" height="15"><?php echo $_L['Grand Total']; ?></td>
                            <td colspan="2" class="total-value balance" align="right" height="15"><div class="due"><?php echo 'Currency Code'//'$config['currency_code']; ?> <?php echo number_format($d['total'],2,$config['dec_point'],$_c['thousands_sep']);; ?></div></td>
                        </tr>
                    <?php
                    }
                    ?>
                </table>
            </td>
        </tr>

            
        <!--<tr>
            <td ><?php //echo $invoice_terms;?></td>
            <td colspan="3"> <br></br></td>
        </tr>-->
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
    <br></br>
    <br></br>
    </div>                        
    <div width="100%" style="border-top-style:  dashed; border-width: 1px;">&nbsp;</div>
    <!--replication for admin copy starts-->
    <div style="height: 450px !important; overflow: hidden; margin:-18px 0px 0px 0px !important; padding: 0px !important;"> 
    <div style="height: 60px !important;">  
    <table width="100%">
        <tr>
            <td style="border: 0;  padding:0; text-align: left">
                <img id="image" src="<?php echo APP_URL; ?>/sysfrm/uploads/system/logo.png"  width="80" height="80"  alt="logo" />
                <?php /*<br><br>
                <span style="font-size: 18px; color: #2f4f4f"><strong><?php echo strtoupper($rcpt); ?> # <?php */
                if($d['cn'] != ''){
                    $dispid = $d['cn'];
                }else{
                    $dispid = $d['id'];
                }
                //echo 'DA/'.$invoiceRunningYear.'/'.$d['invoicenum'].$dispid;*/
                ?></strong></span>
            </td>
            
            <td style="border: 0;  text-align: right">
                <div id="logo" style="font-size:14px">
                    <div style="font-size:16px;"><b><?php echo $customSysName; ?></b></div>
                    <div><?php echo $config['caddress']; ?></div>
                </div>
            </td>
        </tr>
    </table>
    </div>

    <div style="clear:both"></div>

    <div id="customer" class="marg-top-fif">

        <table id="meta" class="marg-top-fif" height="120">
            <tr>
                <td rowspan="6" style="border: 1px solid white; border-right: 1px solid black; text-align: left" width="42%">
                    <strong><?php echo $print_type . " To"; ?></strong> <br>
                    <?php if($a['company'] != '') {?>
                        Mr. <?php echo $a['company']; ?> <br>
                       <?php echo $_L['ATTN']; ?>: <?php echo $a['account']; ?> <br>
                    <?php }else{?>
                        <?php echo $d['account']; ?> <br>
                    <?php }?>

                    <?php echo $a['address']; ?>  <?php echo $a['city']; ?> <?php echo $a['state']; ?> <?php echo $a['zip']; ?> <?php //echo $a['country']; ?> 
                    <br>
                    <?php
                    if(($a['phone']) != ''){
                        echo 'Phone: '. $a['phone']. ' <br>';
                    }
                    echo 'Class: '.$className;
                    /* if(($a['email']) != ''){
                        echo 'Email: '. $a['email']. ' <br>';
                    }
                    foreach ($cf as $cfs){
                        echo $cfs['fieldname'].': '. get_custom_field_value($cfs['id'],$a['id']). ' <br>';
                    } */
                    ?></td>
                <td class="meta-head"><?php echo $print_type.' No.'; ?></td>
                <td><?php echo 'MIS/'.$invoiceRunningYear.'/'.$d['invoicenum'].$dispid; ?></td>
            </tr>
            <tr>
                <td class="meta-head"><?php echo 'Admission No.';//$_L['Due Date']; ?></td>
                <td><?php echo $admission_no;//$studentEnroleCode;//date($config['df'], strtotime($d['duedate'])); ?></td>
            </tr>
            <tr>
                <td class="meta-head"><?php echo $_L['Status']; ?></td>
                <td><?php echo ib_lan_get_line($d['status']);?></td>
            </tr>
            <tr>
                <td class="meta-head"><?php echo $print_type.' Date'; ?></td>
                <td style="height: 15px;">
                    <?php $trs_lst_ind = count($trs)>0?(count($trs)-1):FALSE; 
                        echo (is_numeric($trs_lst_ind))?date($config['df'], strtotime($trs[$trs_lst_ind]['date'])):date($config['df'], strtotime($d['date']));
                    ?>
                </td>
                <!-- <td><?php //echo date($config['df'], strtotime($d['date'])); ?></td> -->
            </tr>
            
            <tr>
                <td style="height: 15px;" class="meta-head"><?php echo 'Mode of Payment'; ?></td>
                <td style="height: 15px;"><?php echo $d['paymentmethod'].($d['ref_no']!=''?' / '.$d['ref_no']:'')?></td>
            </tr>
            <tr>
                <td style="height: 15px;" class="meta-head"><?php echo 'No of Installments'; ?></td>
                <td style="height: 15px;"><?php echo $total_intallments?></td>
            </tr>
            <?php /*<tr>
                <td class="meta-head"><?php echo $_L['Due Date']; ?></td>
                <td><?php echo date($config['df'], strtotime($d['duedate'])); ?></td>
            </tr>

            <tr>
                <td class="meta-head"><?php echo $_L['Amount Due']; ?></td>
                <td><div class="due"><?php echo $config['currency_code'].' '.$i_due; ?></div></td>
            </tr>*/?>

        </table>

    </div>

    <table id="items" class="marg-top-fif" >

        <tr>
            <th><?php echo 'Particulars'; ?></th>
            <th align="right"><?php echo $_L['Amount']; ?></th>
            <!--<th align="right"><?php $_L['Qty']; ?></th>-->
            <th align="right" style="width: 190px;"><?php echo $_L['Total']; ?></th>

        </tr>
        <?php
        foreach ($items as $item){
            echo '  <tr class="item-row">
            <td class="description" height="15">'.$item['description'].'</td>
            <td align="right" height="15">'.$currSymbol.' '.number_format($item['amount'],2,$config['dec_point'],$_c['thousands_sep']).'</td>
            
            <td align="right" height="15"><span class="price"> '.$currSymbol.' '.number_format($item['total'],2,$config['dec_point'],$_c['thousands_sep']).'</span></td>
        </tr>';
        }

        ?>

        <tr>
            <td colspan="3">
            <table width="100%">
                    <tr>
                        <td class="total-line" align="right" height="15"><?php echo $_L['Sub Total']; ?>:</td>
                        <td class="total-value" align="right" height="15"><div id="subtotal">
                            <?php echo $currSymbol; ?> <?php echo number_format($d['subtotal'],2,$config['dec_point'],$_c['thousands_sep']); ?></div></td>
                        <td class="total-line" align="right" height="15"><?php echo 'Total'; ?></td>
                        <td class="total-value" align="right" height="15">
                            <div class="due"><?php echo $currSymbol; ?> <?php echo number_format($d['total'],2,$config['dec_point'],$_c['thousands_sep']);?>
                            </div>
                        </td>
                    </tr>
                    <?php
                    if($d['credit'] != '0.00'){
                        ?>
                        <tr>
                            <td  class="total-line" align="right" height="15"><?php echo $_L['Total Paid']; ?></td>
                            <td class="total-value" align="right" height="15"><div class="due"><?php echo $currSymbol; ?> <?php echo number_format($d['credit'],2,$config['dec_point'],$_c['thousands_sep']);; ?></div></td>
                        <?php
                        if(($d['discount']) != '0.00') {
                        ?>
                            <td class="total-line" align="right" height="15"><?php echo $_L['Discount']; ?>
                                <?php
                                if($d['discount_type'] == 'p'){
                                    echo '('.$d['discount_value'].')%';
                                } ?>
                                 :
                                <div id="subtotal"><?php echo $currSymbol; ?> <?php echo number_format($d['discount'],2,$config['dec_point'],$_c['thousands_sep']); ?></div>    
                            </td>
                            <td class="total-line balance" height="15"><?php echo $_L['Amount Due']; ?>:<div class="due"><?php echo $currSymbol; ?> <?php echo $i_due; ?></div></td>
                        <?php } else { ?>
                            <td class="total-line balance" height="15"><?php echo $_L['Amount Due']; ?></td>
                            <td class="total-value balance" align="right" height="15"><div class="due"><?php echo $currSymbol; ?> <?php echo $i_due; ?></div></td>
                        <?php } ?>
                        </tr>
                    <?php
                    } else {
                        ?>
                        <tr>
                            <td colspan="2" class="total-line balance" height="15"><?php echo $_L['Grand Total']; ?></td>
                            <td colspan="2" class="total-value balance" align="right" height="15"><div class="due"><?php echo $currSymbol; ?> <?php echo number_format($d['total'],2,$config['dec_point'],$_c['thousands_sep']);; ?></div></td>
                        </tr>
                    <?php
                    }
                    ?>
                
                </table>
        </td>
        </tr>
        <!--<tr>
            <td ><?php //echo $invoice_terms;?></td>
            <td colspan="3"> <br></br></td>
        </tr>-->
        
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
    
    <!--replication for admin copy end-->

    <!--    related transactions -->

    <?php
    if ($trs_c != ''){
        ?>
        <h4><?php echo $_L['Related Transactions']; ?>: </h4>
        <table id="related_transactions" class="marg-top-fif"  style="width: 100%">

            <tr>
                <th align="left" width="20%" height="15"><?php echo $_L['Date']; ?></th>
                <th align="left" height="15"><?php echo $_L['Account']; ?></th>
                <th width="45%" align="left" height="15"><?php echo $_L['Description']; ?></th>
                <th align="right" height="15" style="width: 190px;"><?php echo $_L['Amount']; ?></th>
            </tr>

            <?php

            foreach ($trs as $tr){
                echo '  <tr class="item-row">


            <td align="left" height="15">'.date( $config['df'], strtotime($tr['date'])).'</td>
            <td align="left" height="15">'.$tr['account_name'].'</td>
            <td align="left" height="15">'.$tr['description'].'</td>
            <td align="right" height="15"><span class="price">'.$currSymbol.' '.number_format($tr['amount'],2,$config['dec_point'],$config['thousands_sep']).'</span></td>
        </tr>';
            }

            ?>


        </table>
    <?php } ?>

<!--    end related transactions -->

    <?php if($d['notes'] != ''){?>
        <br>
        <div id="terms" style=" text-align: left;">
            <h5><?php echo $_L['Terms']; ?></h5>
            <?php echo $invoice_terms; ?>
        </div>
    <?php } ?>


    <button class='button -dark center no-print'  onClick="window.print();">Click Here to Print</button>
</div>

</body>

</html>