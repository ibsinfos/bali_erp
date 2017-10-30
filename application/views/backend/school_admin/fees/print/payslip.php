<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
    <title><?php echo 'INVOICE RECEIPT'; ?> <?php echo $receipt->receipt_no; ?></title>
    
    <meta name="theme-color" content="#ffffff">
    <style>
        * { margin: 0; padding: 0; }
        body {
            font: 14px/1.4 Helvetica, Arial, sans-serif;
        }
        #page-wrap { width: 800px; margin: 0 auto; }

        textarea { border: 0; font: 14px Helvetica, Arial, sans-serif; overflow: hidden; resize: none; }
        table { border-collapse: collapse; }
        table td:not(.no-padding), table th { border: 1px solid black; padding: 5px; }
        .item-table td{border:0;}
        table td.no-padding{padding:1px}

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
        .text-right{text-align:right}
        .text-left{text-align:left}
        .text-center{text-align:center}
        .row{padding:5px;}
        .col-md-12{width:100%}
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
    <div class="right-block-data right-over-border"> 
        <div id="error_message" style="display:none;"></div>
            <!--<div class="ml-alert-1-info m1-info-set">
                    <div class="style-1-icon info"></div>Feature will be available soon.
            </div>-->
            <div id="winPrint">
                <div class="slimScrollDiv">
                    <div id="empleavesummary" class="details_data_display_block newtablegrid" style="width:100% !important;">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <span class="text-center"> 
                                    <img id="image" src="<?php echo base_url('assets/images/logo_ag.png')?>"  width="40" height="40" alt="logo"/>
                                </span>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-info">
                                        <div class="panel-heading text-center"><?php echo sett('system_title')?></div>
                                        <div class="text-center year_info"><b>Payslip For <?php echo date('F Y',strtotime($psrec->generate_date))?></b></div>
                                        <div class="panel-body">
                                            <table class="table table-bordered"  width="100%">
                                                <tbody>
                                                    <tr>
                                                        <th class="info" colspan="1" id="p">Personal No.</th>
                                                        <td colspan="2"><?php echo $psrec->contactnumber?></td>
                                                        <th class="info" colspan="1">Name</th>
                                                        <td colspan="2"><?php echo $psrec->userfullname?></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="info" colspan="1">Bank</th>
                                                        <td colspan="2"><?php echo $psrec->bankname?></td>
                                                        <th class="info" colspan="1">Bank A/C No.</th>
                                                        <td colspan="2"><?php echo $psrec->accountnumber?></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="info" colspan="1">DOJ</th>
                                                        <td colspan="2"><?php echo $psrec->date_of_joining?></td>
                                                        <th class="info" colspan="1">LOP Days</th>
                                                        <td colspan="2"><?php echo $lop_days?></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="info" colspan="1">Employee Id</th>
                                                        <td colspan="2"><?php echo $psrec->employeeId?></td>
                                                        <th class="info" colspan="1">STD Days</th>
                                                        <td colspan="2">30</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 table-responsive">
                                    <table class="table table-bordered" width="100%">
                                        <tbody>
                                           <tr>
                                              <td class="no-padding">
                                                <table class="table item-table" width="100%">
                                                    <thead>
                                                        <tr class="info">
                                                            <th class="text-center" width="30%">Earnings</th>
                                                            <th class="text-center">Amount in <?php echo sett('currency')?></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach($earngs as $v){?>
                                                            <tr>
                                                                <td><?php echo $v->name?></td>
                                                                <td><?php echo number_format($v->value,2)?></td>
                                                            </tr>    
                                                        <?php }?>
                                                    </tbody>
                                                </table>    
                                              </td> 
                                              <td class="no-padding">
                                                <table class="table item-table" width="100%" border="0">
                                                    <thead>
                                                        <tr class="info">
                                                            <th class="text-center" width="30%">Deductions</th>
                                                            <th class="text-center">Amount in <?php echo sett('currency')?></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach($dedcs as $v){?>
                                                            <tr>
                                                                <td><?php echo $v->name?></td>
                                                                <td><?php echo number_format($v->value,2)?></td>
                                                            </tr>    
                                                        <?php }?>
                                                            <tr>
                                                                <td><?php echo 'LOP Amount'?></td>
                                                                <td><?php echo number_format($lop_amt,2)?></td>
                                                            </tr>
                                                    </tbody>
                                                </table>    
                                              </td>           
                                           </tr>        
                                            <tr>
                                                <td class="text-right"></td>
                                                <td class="text-right"><b> NET Earning <?php echo number_format($psrec->net_pay,2)?></b></td>
                                            </tr>

                                        </tbody>
                                    </table>
                                    <span>**This is computer generated Payslip and does not require signature and stamp.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
                <div style="height:50px !important; width:100% !important;"></div>
            </div>
            
            <div align="center">
                <button class='button -dark center no-print'  onClick="window.print();">Click Here to Print</button>
            </div>
        </div>	
    </div>
</div>
</body>
</html>