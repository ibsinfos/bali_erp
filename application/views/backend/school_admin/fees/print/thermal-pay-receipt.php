<html dir="ltr" moznomarginboxes="" mozdisallowselectionprint="">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $print_type.' '.$receipt->receipt_no?></title>
<style>
    /*@media print {*/
    @page {
        margin: 0 10px;
        /*margin-left: 7mm;
        margin-right: 5mm;
        margin-top: 0mm;*/

    }
    body {
    font-size: 9px;
    max-width: 400px;
    min-width: 200px;
    /*font-family: arial;*/
    /*font-family: Lucida Console,Lucida Sans Typewriter,monaco,Bitstream Vera Sans Mono,monospace; */
    font-family: Verdana,Tahoma, Segoe, sans-serif;
    /*max-width: 200px;*/
    }
    #receipt{
        padding: 0 5px;
    }
    .receipt-container {
    margin-bottom: 30px;
    /*width: 300px;*/
    /*border-width: 1px;
    border-style: solid;*/
    }
    .institution_header{
    width: 100%;
    float: left;
    margin-left: 5px;
    }
    .institution_name{
    font-size: 11px;
    /*text-align: center;*/
    font-weight: bold;
    margin-bottom: 5px;
    margin-top: 5px;
    }
    .institution_address {
    font-size: 11px;
    }
    .receipt_title {
    border-top:1px solid black;
    border-bottom:1px solid black;
    text-align: center;
    font-weight: bold;
    font-size: 12px;
    clear: both;
    padding-top: 3px;
    padding-bottom: 3px;
    }
    .institution_logo {
    float: left;
    width: 15%;
    height: 50px;
    border-width: 1px;
    border-color: black;
    border-style: dotted;
    margin-right: 5px;
    display: none;
    }

    .receipt-details {
        width: 100%;
        margin: 5px;
    }
    .student-details {
        margin: 5px;
        width:100%;
    }
    td.left-label {
        padding-right: 10px;
    }
    .left{
        float: left;
        width: 60%;
    }
    .right {
        float: right;
        text-align: right;
        width: 40%;
        word-wrap: break-word;
    }
    .receipt-details_item {
        /*margin-top: 5px;*/
        clear: both;
        line-height: 15px;
        margin-left: 5px;
        margin-right: 5px;
    }
    .receipt-footer{
        color: gray;
        margin: 5px;
    }
    section{
        /*border-bottom:2px solid #333;*/
        border-top:1px solid black;
        /*border-bottom:1px solid black;*/
        border-collapse: collapse;
        clear: both;
        padding-top: 5px;
        padding-bottom: 5px;
        overflow: auto;
        margin-top: -1px; /* workaround for border collapse*/
        margin-bottom: -1px; /* workaround for border collapse*/
    }
    .student-details {

    }
    section.particulars-header {
        border-bottom-width: 0px;
        /*margin-left: 10px;
        margin-right: 10px;*/
    }
    .particulars-header-left {
        float: left;
    }
    .particulars-header-right {
        float: right;
    }
    .payment_status{
        /*font-weight: bold;*/
    }
    .payment_status .left {
        text-align: right;
        width: 70%;
    }
    .payment_status .right {
        /*text-align: right;*/
        width: 30%;
        float: right;
    }
    .bottom_fields{
        clear: both;
    }
    .subtitle {
        /*font-weight: bold;*/
    }
    .particulars-header {
        padding-left: 5px;
        padding-right: 5px;
    }
    .summary p {
        margin-top: 0px;
        margin-left: 5px;
    }
    .discount p {
        margin-top: 0px;
        margin-left: 5px;
    }
    .subtitle {
        margin-top: 0px;
        margin-left: 5px;
    }

    /*Particular wise*/
    .particular_wise_item {

    }
    .particular_wise_item .particular_name{
        font-weight: bold;
        float: left;
        margin-left: 5px;
        margin-right: 5px;
    }
    .particular_wise_item .particular_wise_item_details{
        font-weight: normal;
        float: right;
        width: 100%;
        margin-left: 5px;
        margin-right: 5px;
    }
    .particular_wise_item_details .left {
        width: 70%;
        text-align: right;

    }
    .particular_wise_item_details .right {
        width: 30%;
    }
    .table {
        display: table;
    }
    .table-row {
        display: table-row;
    }
    .table-cell {
        display: table
    }
    /*}*/
    /* style defaults*/
    tr {
        height: 15px;
    }
    p {
        margin: 1em 0 1em 0;
    }
    body {
        margin: 1px;
        /*padding: 1em;*/
    }

    .payment_status-details {
        width: 100%;
    }
    .payment_status-details tr {

    }
    .payment_status-details td {

    }
    .payment_status-details .right-label {
        text-align: right;
    }
    .receipt-details .right-label {
        text-align: right;
    }
    .student-details .right-label {
        text-align: right;
    }
    .payment_status-details .bold {
        float: right;
    }
    hr {
        background-color: black;
        height: 1px;
        border: 0 none;
        color: black;
    }
    td.left {
        float: inherit;
        width: inherit;
        padding-right: 5px;
        padding-left: 5px;
        width: 40%;
    }
    .txt-left{
        text-align:left;
    }
    .txt-right{
        text-align:right;
    }
</style>    
  
</head>
  <body style="">
    <div id="content_wrapper">
      <div id="content">
        <!-- Template for  template thermal responsive -->
        <div class="receipt-container">
            <div id="receipt">
                <div class="receipt-header">
                    <div class="institution_logo">
                    </div>
                    <div class="institution_header">
                        <p class="institution_name">
                            <strong><?php echo $print_type. ' to'; ?></strong> <br>
                            <?php if($student->father_name != '') {?>
                                <?php echo $student->father_name.' '.$student->father_lname;?><br>
                            <?php echo $student->name; ?>: <?php //echo $a['account']; ?> <br>
                            <?php }else{?>
                                <?php echo $student->name.' '.$student->lname; ?> <br>
                            <?php }?>
                            <?php echo $student->class_name;?>
                        </p>
                        <p class="institution_address">
                            <?php echo $student->address;?>
                            <?php echo $student->city;?> <?php echo $student->state;?> <?php echo $student->zip_code;?>
                        </p>
                    </div>
                </div>
                <div class="receipt_title">Fee receipt</div>
                <div class="receipt-content">
                    <table class="receipt-details">
                        <tbody>
                            <tr class="">
                                <td class="left-label"> Receipt No.:</td>
                                <td class="bold right-label"> <?php echo $receipt->receipt_no?></td>
                            </tr>
                            <tr class="">
                                <td class="left-label">Date:</td>
                                <td class="right-label">
                                    <?php echo date('d/m/Y',strtotime($receipt->pay_date))?> 
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <hr>
                    <table class="student-details">
                        <tbody>
                            <tr>
                                <td class="left-label">Student:</td>
                                <td class="bold rtl_bracket_fix right-label"><?php echo $student->name.' '.$student->lname?></td>
                            </tr>
                            
                            <tr>
                                <td class="left-label">Parent:</td>
                                <td class="right-label"><?php echo $student->father_name.' '.$student->father_lname;?></td>
                            </tr>
                            <tr>
                                <td class="left-label">Class: </td>
                                <td class="right-label"> <?php echo $student->class_name?></td>
                            </tr>
                            
                            <tr>
                                <td class="left-label"><?php echo get_phrase('enroll_code')?></td>
                                <td class="right-label"><?php echo $student->enroll_code?></td>
                            </tr>
                            
                            <!-- <tr>
                                <td class="left-label">Fee Term:</td>
                                <td class="right-label"> Term 1</td>
                            </tr> -->
                        </tbody>
                    </table>
                    <section class="particulars-header">
                        <div class="particulars-header-left">Items</div>
                        <div class="particulars-header-right">Amount (₹)</div>
                    </section>
                    
                    <section class="particulars">
                        <?php $i=1;
                            foreach ($receipt->payment_trans as $item){
                            if($item->item_type==1 || $item->item_type==4){?>
                            <div class="receipt-details_item">
                                <div class="left"><?php echo $i.'. '.$item->item_name?></div>
                                <div class="right"><?php echo $item->item_amt?></div>
                            </div>
                        <?php $i++;}}?>     
                    </section>
                    <?php /*
                    <section class="discount">
                        <p class="subtitle">Discount</p>
                        
                        <div class="receipt-details_item">
                            <div class="left">1.discount</div>
                            <div class="right">- 100.00</div>
                        </div>
                    </section>
                    <section class="fine">
                        <p class="subtitle">
                            Fine
                        </p>
                        
                        <div class="receipt-details_item">
                            <div class="left ">1.fine</div>
                            <div class="right">10.00</div>
                        </div>
                    </section>*/?>
                    <section class="summary">
                        <p class="subtitle"><?php echo get_phrase('summary')?></p>
                        <div class="receipt-details_item">
                            <div class="left"><?php echo get_phrase('total_fees')?></div>
                            <div class="right"><?php echo sett('currency').' '.$receipt->net_amount?></div>
                        </div>
                        <?php /*
                        <div class="receipt-details_item">
                            <div class="left">
                                Discount
                            </div>
                            <div class="right">
                                - 100.00
                            </div>
                        </div>
                        
                        <div class="receipt-details_item">
                            <div class="left">
                                Fine
                            </div>
                            <div class="right">
                                10.00
                            </div>
                        </div>*/?>
                    </section>
                    <section class="payment_status">
                        <table class="payment_status-details">
                            <tbody>
                                <tr class="">
                                    <td class="right-label">Total amount to pay:</td>
                                    <td class="bold"><?php echo sett('currency').' '.$receipt->net_amount?></td>
                                </tr>
                                
                                <tr class="">
                                    <td class="right-label">Previous Payments:</td>
                                    <td class="bold"><?php echo sett('currency').' '.$receipt->previous_amount?></td>
                                </tr>
                                
                                <tr class="">
                                    <td class="right-label">Amount paid:</td>
                                    <td class="bold"><?php echo sett('currency').' '.$receipt->paid_amount?></td>
                                </tr>
                                
                                <!-- <tr class="">
                                    <td class="right-label">
                                        Total amount paid:
                                    </td>
                                    <td class="bold">
                                        <?php //echo sett('currency')?> 100.00
                                    </td>
                                </tr> -->
                                
                                <tr class="">
                                    <td class="right-label">Total due amount:</td>
                                    <td class="right-label"><?php echo sett('currency').' '.$receipt->due_amount?></td>
                                </tr>
                            </tbody>
                        </table>
                    </section>
                    <section class="bottom_fields">
                        <table>
                            <tbody>
                                <tr class="receipt-details_item">
                                    <td class="left">Payment mode:</td>
                                    <td class=""><?php echo $receipt->pay_method?></td>
                                </tr>
                                
                                    
                                <tr class="receipt-details_item">
                                    <td class="left">Notes:</td>
                                    <td class=""><?php echo $receipt->note?></td>
                                </tr>
                            </tbody>
                        </table>
                    </section>
                </div>
                <div class="receipt-footer">

                </div>
            </div>
        </div>
      </div>
      <div class="extender"></div>
    </div>
  
