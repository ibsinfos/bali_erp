{include file="sections/header.tpl"}
<div class="right-block-data right-over-border"> 
    <div id="error_message" style="display:none;"></div>
        <!--<div class="ml-alert-1-info m1-info-set">
                <div class="style-1-icon info"></div>Feature will be available soon.
        </div>-->
        <div id="winPrint">
            <div class="slimScrollDiv">
                <div id="empleavesummary" class="details_data_display_block newtablegrid" style="width:100% !important;">
                    <div class="row">
                        <div class="row">
                            <div class="col-md-12">
                                <span class="text-left"><img src="" alt="logo image here"/></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-info">
                                    <div class="panel-heading">Company Name here</div>
                                    <div class="text-center year_info"><b>Payslip For {date('F Y',strtotime($psrec['generate_date']))}</b></div>
                                    <div class="panel-body">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <th class="info" colspan="1" id="p">Personal No.</th>
                                                    <td colspan="2">{$psrec['contactnumber']}</td>
                                                    <th class="info" colspan="1">Name</th>
                                                    <td colspan="2">{$psrec['userfullname']}</td>
                                                </tr>
                                                <tr>
                                                    <th class="info" colspan="1">Bank</th>
                                                    <td colspan="2">{$psrec['bankname']}</td>
                                                    <th class="info" colspan="1">Bank A/C No.</th>
                                                    <td colspan="2">{$psrec['accountnumber']}</td>
                                                </tr>
                                                <tr>
                                                    <th class="info" colspan="1">DOJ</th>
                                                    <td colspan="2">{$psrec['date_of_joining']}</td>
                                                    <th class="info" colspan="1">LOP Days</th>
                                                    <td colspan="2">{$lop_days}</td>
                                                </tr>
                                                <tr>
                                                    <th class="info" colspan="1">Employee Id</th>
                                                    <td colspan="2">{$psrec['employeeId']}</td>
                                                    <th class="info" colspan="1">STD Days</th>
                                                    <td colspan="2">30</td>
                                                </tr>
                                                {*
                                                <tr>
                                                    <th class="info" colspan="1">Location</th>
                                                    <td colspan="2"></td>
                                                    <th class="info" colspan="1">Worked Days</th>
                                                    <td colspan="2"></td>
                                                </tr>
                                                <tr>
                                                    <th class="info" colspan="1">Department</th>
                                                    <td colspan="2">{$psrec['department_name']}</td>
                                                    <th class="info" colspan="1">Designation</th>
                                                    <td colspan="2">{$psrec['jobtitle_name']}</td>
                                                </tr>
                                                *}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="info">
                                            <th class="text-center" width="30%">Earnings</th>
                                            <th class="text-center">Amount NO.</th>
                                            <th class="text-center" width="30%">Deduction</th>
                                            <th class="text-center">Amount in RS.</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="2">
                                                <div class="col-md-12">
                                                    {foreach from=$earngs item=$v}
                                                    <div class="col-md-6">{$v['name']}</div>
                                                    <div class="col-md-6 text-right">{number_format($v['value'],2)}</div>
                                                    {/foreach}
                                                </div>
                                            </td>
                                            <td colspan="2">
                                                <div class="col-md-12"> 
                                                    {foreach from=$dedcs item=$v}
                                                    <div class="col-md-6">{$v['name']}</div>
                                                    <div class="col-md-6 text-right">{number_format($v['value'],2)}</div>
                                                    {/foreach}
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="col-md-6">LOP Amount</div>
                                                    <div class="col-md-6 text-right">{number_format($lop_amt,2)}</div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td class="text-right"><b>NET Earning</b></td>
                                            <td class="text-left"><b>{number_format($psrec['net_pay'],2)}</b></td>
                                            <td></td>
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
            <input type="button" value="Print" class="print" onclick="printSalarySlip();">
            <input type="button" value="PDF" class="print" onclick="salarySlipPDF();">
        </div>
    </div>	
</div>
{include file="sections/footer.tpl"}
<script type='text/javascript'>
$(document).ready(function () {
    $("#emp_payslips").addClass('active');
    $("#emp_payslips").removeAttr("onclick");
});
    
function printSalarySlip(){
    //alert($("#winPrint").html());
    PrintElem($("#winPrint").html());
}

function salarySlipPDF(){
    //alert($("#winPrint").html());
    var param_str = $('#filters_div').find('select, textarea, input').serialize();
    var url= base_url+"/default/reports/rolesgrouprptpdf?"+param_str; 	
    $.ajax({
        type: "POST",
        url: base_url +'/emppayslips/printslip/userid/102',
        data: param_str,
        success: function(response){ 
            alert(response);
            response = JSON.parse(response);
            url = base_url +'/reports/downloadreport/file_name/' + response.file_name;
            var $preparingFileModal = $("#preparing-file-modal");
            $preparingFileModal.dialog({ modal: true });

            $.fileDownload(url, {
                    successCallback: function(url) 
                    {
                        $preparingFileModal.dialog('close');
                    },
                    failCallback: function(responseHtml, url) 
                    {
                        $preparingFileModal.dialog('close');
                        $("#error-modal").dialog({ modal: true });
                    }
                });			        
            return false; //this is critical to stop the click event which will trigger a normal file download!
        },
    });
}

function PrintElem(elem)
{
    {literal}
    var mywindow = window.open('', 'PRINT', 'height=400,width=600');
    mywindow.document.write('<html><head><title>Sharad Technologies LLC - School ERP</title>\
                            <style type="text/css">*{-webkit-print-color-adjust: exact !important; }.col-md-6{width:49% !important; float:left !important;}.text-right{text-align:right !important;}.info,.panel-info>.panel-heading{background-color:#d9edf7 !important;-webkit-print-color-adjust: exact !important; padding: 10px 15px; border-bottom: 1px solid transparent; border-top-left-radius: 3px; border-top-right-radius: 3px;}.newtablegrid table {color: #3B3B3B;font-family: "Roboto Regular";font-size: 13px;line-height: 25px; position: relative;width: 100%;border-collapse: collapse;}.table-bordered {border: 1px solid #ddd; }th,td{border: 1px solid #ddd !important; text-align:left !important; padding:8px !important;}.text-center{text-align:center;}.year_info{padding:20px 10px !important;}</style>');
    {/literal}
    mywindow.document.write('</head><body >');
    mywindow.document.write('<h1>Sharad Technologies LLC - School ERP</h1>');
    mywindow.document.head.innerHTML+='<link rel="stylesheet" type="text/css" href="http://localhost/beta_merge/hrm/public/media/css/bootstrap.min.css" />';
    mywindow.document.write(elem);
    mywindow.document.write('</body></html>');
    var tables=mywindow.document.getElementsByTagName('table');
    
    for(var i=0;i<tables.length;i++) {
        tables[i].setAttribute('cellpadding','5');
        tables[i].setAttribute('cellspacing','0');
        tables[i].setAttribute('border','1');
        tables[i].setAttribute('width','100%');
        tables[i].setAttribute('style','margin-top:20px; border-top:0;');
    }

    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10*/
    mywindow.print();
    mywindow.close();
    return true;
}
</script>
