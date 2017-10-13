<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
    <title><?php echo 'INVOICE RECEIPT'; ?> <?php echo $receipt->receipt_no; ?></title>
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
		@page {
			size: <?php echo isset($PAGE_SIZE)?$PAGE_SIZE:'A6'?>;
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
    <?php for($i=0;$i<=1;$i++){?>
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
                    <span style=" font-weight: bold;font-size: 15px;">Reg No: DEO/EE/JOD/REG/2016/F-13/393</span>
                </td>
                <td style="border: 0;  text-align: right" width="37%">
                    <div id="logo" style="font-size:18px"><?php echo fetch_parl_key_rec(false,'address');?></div>
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
                        <strong><?php echo $rcpt . ' To'; ?></strong> <br>
                        <?php if($student->parent_fname != '') {?>
                            <?php echo $student->parent_fname.' '.$student->parent_lname; ?> <br>
                            <?php echo $student->student_fname; ?>: <?php //echo $a['account']; ?> <br>
                        <?php }else{?>
                            <?php echo $student->student_fname.' '.$student->student_lname; ?> <br>
                        <?php }?>

                        <?php echo $student->address; ?> <br>
                        <?php echo $student->city; ?> <?php echo $student->region; ?> <?php echo $student->zip_code; ?> <br>
                        <?php echo $student->country; ?> <br>
                        <?php echo !empty($student->phone)?'Phone: '. $student->phone. ' <br>':'';?>
                        <?php echo !empty($student->user_email)?'Email: '. $student->user_email. ' <br>':'';?>
                    </td>
                    <td class="meta-head"><?php echo $rcpt.' No'; ?> #</td>
                    <td><?php echo fetch_parl_key_rec(false,'system_title').'/'.$receipt->running_year.'/'.$receipt->receipt_no; ?></td>
                </tr>
                <tr>
                    <td class="meta-head"><?php echo 'Enroll Code';//$_L['Due Date']; ?></td>
                    <td><?php echo 'Non Enroll';//date($config['df'], strtotime($d['duedate'])); ?></td>
                </tr>
                <tr>
                    <td class="meta-head"><?php echo get_phrase('status'); ?></td>
                    <td><?php echo $receipt->is_paid?'Paid':'Pending'?></td>
                </tr>
                <tr>
                    <td class="meta-head"><?php echo $rcpt.' Date';?></td>
                    <td><?php echo date('d/m/Y', strtotime($receipt->pay_date));?></td>
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

            <?php
            foreach ($receipt->payment_trans as $item){
                if($item->item_type==1 || $item->item_type==4){
                    echo '  <tr class="item-row">
                                <td class="description">'.$item->item_name.'</td>
                                <td colspan="2" align="right"><span class="price">'.sett('currency').' '.$item->item_amt.'</span></td>
                            </tr>';
                }
            }?>



            <?php if(1){?>
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
                        <div class="due"><?php echo sett('currency');?> <?php echo $receipt->net_amount;?></div>
                    </td>
                </tr>
                <?php if($receipt->previous_amount > 0){?>
                <tr>
                    <td class="blank"> </td>
                    <td colspan="1" class="total-line"><?php echo get_phrase('previous_payment'); ?></td>
                    <td class="total-value txt-right">
                        <div class="due"><?php echo sett('currency');?> <?php echo $receipt->previous_amount;?></div>
                    </td>
                </tr>
                <?php }?>
                <tr>
                    <td class="blank"> </td>
                    <td colspan="1" class="total-line"><?php echo get_phrase('total_paid');?></td>
                    <td class="total-value txt-right">
                        <div class="due"><?php echo sett('currency');?> <?php echo $receipt->paid_amount;?></div>
                    </td>
                </tr>
                <tr>
                    <td class="blank"> </td>
                    <td colspan="1" class="total-line balance"><?php echo get_phrase('amount_due'); ?></td>
                    <td class="total-value txt-right">
                        <div class="due"><?php echo sett('currency');?> <?php echo $receipt->due_amount;?></div>
                    </td>
                </tr>
            <?php }else{?>
                <tr>
                    <td class="blank"> </td>
                    <td colspan="1" class="total-line balance"><?php echo get_phrase('grand_total'); ?></td>
                    <td class="total-value balance txt-right">
                        <div class="due"><?php echo sett('currency');?> <?php echo $receipt->net_amount; ?></div>
                    </td>
                </tr>
            <?php }?>
            <!-- <tr>
                <td ><?php //echo $invoice_terms;?></td>
                <td colspan="3"> <br></br><br></br></td>
            </tr> -->
            <tr>
                <td class="blank">&nbsp;</td>
                <td colspan="3">Cashier  / Manager </td>
            </tr>
        </table>
        </br>
        <div width="100%" style="border-top-style:  dashed; border-width: 1px;">&nbsp;</div>
        </br>
        <!--replication for admin copy starts-->
    <?php }?>



    <?php /* if ($trs_c != ''){?>
        <br>
        <h4><?php echo $_L['Related Transactions']; ?>: </h4>
        <table id="related_transactions" style="width: 100%">
            <tr>
                <th align="left" width="20%"><?php echo $_L['Date']; ?></th>
                <th align="left"><?php echo $_L['Account']; ?></th>
                <th width="50%" align="left"><?php echo $_L['Description']; ?></th>
                <th align="right"><?php echo $_L['Amount']; ?></th>
            </tr>
            <?php  foreach ($trs as $tr){
                echo '  <tr class="item-row">
                            <td align="left">'.date( $config['df'], strtotime($tr['date'])).'</td>
                            <td align="left">'.$tr['account'].'</td>
                            <td align="left">'.$tr['description'].'</td>
                            <td align="right"><span class="price">'.$config['currency_code'].' '.number_format($tr['amount'],2,$config['dec_point'],$config['thousands_sep']).'</span></td>
                        </tr>';
            } ?>
        </table>
    <?php } */?>
    <!--end related transactions -->

    <?php if($receipt->note != ''){?>
        <br></br>
        <div id="terms" style=" text-align: left;">
            <h5><?php echo 'Note'; ?></h5>
            <?php echo $receipt->note; ?>
        </div>
    <?php }?>
    <button class='button -dark center no-print'  onClick="window.print();">Click Here to Print</button>
</div>
</body>
</html>