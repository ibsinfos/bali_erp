<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
    <title><?php echo 'PAYMENT RECEIPT'; ?> 1</title>
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
    <link rel="manifest" href="<?php echo APP_URL.'/'; ?>sysfrm/uploads/icon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?php echo APP_URL.'/'; ?>sysfrm/uploads/icon/ms-icon-144x144.png"> -->
    <meta name="theme-color" content="#ffffff">
    <style>
        <?php if(!isset($PAGE_SIZE) || $PAGE_SIZE=='A4'){?>
            @page {
                size: 'A4';
                margin-left: 6mm;
                margin-right: 6mm;
                margin-top: 6mm;
                margin-bottom: 6mm;
                padding: 0;
                width: auto;
                min-height: 297;
                /*width: 138.5mm*/
            }
        <?php }else if(isset($PAGE_SIZE) && $PAGE_SIZE=='A5'){?>
            @page {
                size: 'A5';
                margin-left: 6mm;
                margin-right: 6mm;
                margin-top: 6mm;
                margin-bottom: 6mm;
                padding: 0;
                width: auto;
                min-height: 297;
            }
        <?php }else if(isset($PAGE_SIZE) && $PAGE_SIZE=='A6'){?>
            @page {
                size: 'A6';
                margin-left: 6mm;
                margin-right: 6mm;
                margin-top: 6mm;
                margin-bottom: 6mm;
                padding: 0;
                width: auto;
                min-height: 297;
            }
        <?php }?>

        * { margin: 0; padding: 0; }
        body {
            font: 14px/1.4 Helvetica, Arial, sans-serif;
        }
        #page-wrap { width: 800px; margin: 0 auto; }

        textarea { border: 0; font: 14px Helvetica, Arial, sans-serif; overflow: hidden; resize: none; }
        table { border-collapse: collapse; }
        table td, table th { border: 1px solid black; padding: 5px; }

        #header { height: 15px; width: 100%; margin: 20px 0; background: #222; text-align: center; color: white; font: bold 15px Helvetica, Sans-Serif; text-decoration: uppercase; letter-spacing: 20px; padding: 8px 0px; }

        #address { width: 250px; height: 150px; float: left; }
        #customer { overflow: hidden; }

        #logo { text-align: right; float: right; position: relative; margin-top: 25px; border: 1px solid #fff; max-width: 540px; overflow: hidden; }
        #customer-title { font-size: 20px; font-weight: bold; float: left; }

        #meta { margin-top: 1px; width: 100%; float: right; }
        #meta td { text-align: right;  }
        #meta td.meta-head { text-align: left; background: #eee; }
        #meta td textarea { width: 100%; height: 20px; text-align: right; }

        #items { clear: both; width: 100%; margin: 30px 0 0 0; border: 1px solid black; }
        #items th { background: #eee; }
        #items textarea { width: 80px; height: 50px; }
        #items tr.item-row td {  vertical-align: top; }
        #items td.description { width: 300px; }
        #items td.item-name { width: 175px; }
        #items td.description textarea, #items td.item-name textarea { width: 100%; }
        #items td.total-line { border-right: 0; text-align: right; }
        #items td.total-value { border-left: 0; padding: 10px; }
        #items td.total-value textarea { height: 20px; background: none; }
        #items td.balance { background: #eee; }
        #items td.blank { border: 0; }

        #terms { text-align: center; margin: 20px 0 0 0; }
        #terms h5 { text-transform: uppercase; font: 13px Helvetica, Sans-Serif; letter-spacing: 10px; border-bottom: 1px solid black; padding: 0 0 8px 0; margin: 0 0 8px 0; }
        #terms textarea { width: 100%; text-align: center;}



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
        .txt-right{text-align:right}
        @media print
        {
            .no-print, .no-print *
            {
                display: none !important;
            }
        }

    </style>
</head>
<?php $rcpt= ucfirst('receipt');?>
<body>
<div id="page-wrap">
        <table width="100%">
            <tr>
                <td style="border: 0;  text-align: left" width="23%">
                    <img id="image" src="<?php echo base_url('assets/images/logo_ag.png')?>"  width="40" height="40"  alt="logo" />
                    <?php /*<br><br>
                    <span style="font-size: 18px; color: #2f4f4f"><strong><?php echo strtoupper($rcpt); ?> #
                    
                    echo 'DA/'.$invoiceRunningYear.'/'.$d['invoicenum'].$dispid;
                    </strong></span>*/?>
                </td>
                <td style="border: 0;  text-align: left" width="40%">
                    <span style=" font-weight: bold;font-size: 15px;"><?php echo sett('reg_no')?></span>
                </td>
                <td style="border: 0;  text-align: right" width="37%">
                    <div id="logo" style="font-size:18px">Address</div>
                </td>
            </tr>
        </table>
        <hr>
        <br>
        <div style="clear:both"></div>
        <div id="customer">
            <table id="meta">
                <tr>
                    <td rowspan="5" style="border: 1px solid white; border-right: 1px solid black; text-align: left" width="42%">
                        <strong><?php echo 'Receipt To'; ?></strong> <br>
                        Joan Doe</br>
                        John Doe</br>
                        Street 1</br>
                        AS CA 641929 </br>
                        USA </br>
                        Phone: 9876543210</br>
                        Email: john.doe@mail.com
                    </td>
                    <td class="meta-head"><?php echo 'Receipt No'; ?> #</td>
                    <td>RECEIPT/01</td>
                </tr>
                <tr>
                    <td class="meta-head"><?php echo 'Enroll Code';?></td>
                    <td>ER1</td>
                </tr>
                <tr>
                    <td class="meta-head"><?php echo get_phrase('status'); ?></td>
                    <td>Paid</td>
                </tr>
                <tr>
                    <td class="meta-head"><?php echo 'Rceipt Date';?></td>
                    <td>01/01/2017</td>
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

        <table id="items">
            <tr>
                <th width="65%"><?php echo get_phrase('item'); ?></th>
                <th colspan="2" align="right"><?php echo get_phrase('total'); ?></th>
            </tr>

            <tr class="item-row">
                <td class="description">Item 1</td>
                <td colspan="2" align="right"><span class="price"><?php echo sett('currency');?> 100</span></td>
            </tr>

            <tr class="item-row">
                <td class="description">Item 2</td>
                <td colspan="2" align="right"><span class="price"><?php echo sett('currency');?> 200</span></td>
            </tr>

            <?php /*
            <tr>
                <td><div class="due"><?php echo 'Total:- ';?><?php echo $config['currency_code']; ?> <?php echo number_format($d['total'],2,$config['dec_point'],$_c['thousands_sep']);; ?></div></td>
                <td><div class="due"><?php echo $_L['Total Paid'].':- '; ?><?php echo $config['currency_code']; ?> <?php echo number_format($d['credit'],2,$config['dec_point'],$_c['thousands_sep']);; ?></div></td>
                <td><div class="due"><?php echo $_L['Amount Due'].': -'; ?> <?php echo $config['currency_code']; ?> <?php echo $i_due; ?></div></td>
            </tr>
            */?>
            <tr>
                <td class="blank"> </td>
                <td colspan="1" class="total-line"><?php echo get_phrase('total'); ?></td>
                <td class="total-value txt-right">
                    <div class="due"><?php echo sett('currency');?> 300</div>
                </td>
            </tr>
            <tr>
                <td class="blank"> </td>
                <td colspan="1" class="total-line"><?php echo get_phrase('previous_payment');?></td>
                <td class="total-value txt-right">
                    <div class="due"><?php echo sett('currency');?> 100</div>
                </td>
            </tr>
            <tr>
                <td class="blank"> </td>
                <td colspan="1" class="total-line"><?php echo get_phrase('total_paid');?></td>
                <td class="total-value txt-right">
                    <div class="due"><?php echo sett('currency');?> 200</div>
                </td>
            </tr>
            <tr>
                <td class="blank"> </td>
                <td colspan="1" class="total-line balance"><?php echo get_phrase('amount_due'); ?></td>
                <td class="total-value txt-right">
                    <div class="due"><?php echo sett('currency');?> 0</div>
                </td>
            </tr>
            <tr>
                <td class="blank">&nbsp;</td>
                <td colspan="3">Cashier  / Manager </td>
            </tr>
        </table>
        </br>
        <div width="100%" style="border-top-style:  dashed; border-width: 1px;">&nbsp;</div>
        </br>

    <div id="terms" style=" text-align: left;">
        <h5><?php echo 'Note'; ?></h5>
        Notes
    </div>
    <!-- <button class='button -dark center no-print'  onClick="window.print();">Click Here to Print</button> -->
</div>
</body>
</html>