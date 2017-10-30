<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Default_PayslipemployeeController extends Zend_Controller_Action{
    public function init(){
//        error_reporting(E_ALL);
//        ini_set('display_errors', 1);
        $flash_messages = $this->_helper->flashMessenger->getMessages();
        if(!empty($flash_messages))
            $this->_helper->layout->getView()->flash_messages = $flash_messages[0];
    }
    //private $options;
    public function preDispatch() {
        parent::preDispatch();
        $ajaxContext = $this->_helper->getHelper('AjaxContext');
    }

    public function indexAction() {
//        error_reporting(E_ALL);
//        ini_set("display_errors", 1);
        $auth = Zend_Auth::getInstance();
        $popConfigPermission = array();
        if ($auth->hasIdentity()) {
            $loginUserId = $auth->getStorage()->read()->id;
            $loginuserRole = $auth->getStorage()->read()->emprole;
            $loginuserGroup = $auth->getStorage()->read()->group_id;
        }
        $employeeModel = new Default_Model_Employee();
        $currentOrgHead = $employeeModel->getCurrentOrgHead();
        if (!empty($currentOrgHead)) {
            ///initialise the helper for calculation start here
            /* $payrollCal=new sapp_Payrollcal();
              $payrollCal->suppress_errors = true;
              $string=str_replace("%","/100",'x+z');

              echo $payrollCal->evaluate('y(x,z) = ' . $string);
              echo $payrollCal->e("y(2,2)");die; */
            ///////initialise the helper for calculation end here here
            $call = $this->_getParam('call');
            if ($call == 'ajaxcall')
                $this->_helper->layout->disableLayout();

            if (sapp_Global::_checkprivileges(EMPLOYEE, $loginuserGroup, $loginuserRole, 'add') == 'Yes') {
                array_push($popConfigPermission, 'employee');
            }
            $this->view->popConfigPermission = $popConfigPermission;
            $view = Zend_Layout::getMvcInstance()->getView();
            $objname = $this->_getParam('objname');
            $refresh = $this->_getParam('refresh');
            $dashboardcall = $this->_getParam('dashboardcall', null);
            $data = array();
            $id = '';
            $searchQuery = '';
            $searchArray = array();
            $tablecontent = '';
            if ($refresh == 'refresh') {
                if ($dashboardcall == 'Yes')
                    $perPage = DASHBOARD_PERPAGE;
                else
                    $perPage = PERPAGE;

                $sort = 'DESC';
                $by = 'e.modifieddate';
                $pageNo = 1;
                $searchData = '';
                $searchQuery = '';
                $searchArray = '';
            }
            else {
                $sort = ($this->_getParam('sort') != '') ? $this->_getParam('sort') : 'DESC';
                $by = ($this->_getParam('by') != '') ? $this->_getParam('by') : 'e.modifieddate';

                if ($dashboardcall == 'Yes')
                    $perPage = $this->_getParam('per_page', DASHBOARD_PERPAGE);
                else
                    $perPage = $this->_getParam('per_page', PERPAGE);

                $pageNo = $this->_getParam('page', 1);
                $searchData = $this->_getParam('searchData');
                $searchData = rtrim($searchData, ',');
            }
            //$dataTmp = $employeeModel->getGridforpayroll($sort, $by, $perPage, $pageNo, $searchData,$call,$dashboardcall,$loginUserId);
            //array_push($data,$dataTmp);
            //$dataArr = $employeeModel->getAllPayslipEmployee();
            $dataArr = $employeeModel->getGridForPayslipEmployee($sort, $by, $perPage, $pageNo, $searchData,$call,$dashboardcall,$loginUserId);
            array_push($data,$dataArr);
            //sapp_Payrollcal::pre($data[0]);die;
            $this->view->dataArray = $data;
            //$this->view->dataArray = $dataArr;
            $this->view->call = $call;
        }
        else {
            $this->addorganisationhead($loginUserId);
        }
        $this->view->messages = $this->_helper->flashMessenger->getMessages();
    }
    
    public function generateAction(){
        $id = $this->_request->getParam('id');
        $err_msg_arr=array();
        $error=FALSE;
        $baseUrl = new Zend_View_Helper_BaseUrl();
        if($id!=""){
            $empModel=new Default_Model_Employee();
            $isExist=$empModel->employeeCheckExistByMainUserId($id);
            if($isExist[0]['Tot']>0){
                $payrollPayslipModel=new Default_Model_Payrollpayslip();
                $rsData=$payrollPayslipModel->isPayslipGneratedForEmployee($id);
                if(empty($rsData)){
                    $payrollPayslipModel->generate($id);
                }
//                $rsData=$payrollPayslipModel->isPayslipGneratedForEmployee($id);
//                if(empty($rsData)){
//                    $rsPayslipDetails=$payrollPayslipModel->getEmployeCronPaylip($id);
//                    if(empty($rsPayslipDetails)){
//                        $this->_helper->flashMessenger('Payslip should allow after payroll generation date.');
//                    }else{
//                        $payrollPayslipModel->generate($rsPayslipDetails[0]['id']);
//                        $this->_helper->flashMessenger('Payslip generated successfully.');
//                    }
//                }else{
//                    $this->_helper->flashMessenger('Payslip already generated.');
//                }
            }else{
                $this->_helper->flashMessenger('Selected employee not exist for payslip generation,Please contact with system administration.');
            }
        }else{
            $this->_helper->flashMessenger('Invalid employe selected, pleasee try again.');
        }
        $this->getResponse()->setRedirect($baseUrl->baseUrl().'/index.php/payslipemployee');
    }
    
    public function generatebulkoldAction(){
        $err_msg_arr=array();
        $error=FALSE;
        $baseUrl = new Zend_View_Helper_BaseUrl();
        if($this->getRequest()->isPost()){
            $empId=trim($this->_request->getParam('selected_emp_ids',null));
            if($empId==""){
                $this->_helper->flashMessenger('Invalid employies selected, pleasee try again.');
            }else{
                $idArr= explode(',', $empId);
                if(empty($idArr)){
                    $this->_helper->flashMessenger('Invalid employies selected, pleasee try again.');
                }else{
                    $bulkPayslipGenerateIdStr='';
                    $payrollPayslipModel=new Default_Model_Payrollpayslip();
                    $empModel=new Default_Model_Employee();
                    foreach($idArr As $k => $v){
                        $isExist=$empModel->employeeCheckExistByMainUserId($v);
                        //sapp_Payrollcal::pre($isExist);
                        if($isExist[0]['Tot']>0){
                            $rsData=$payrollPayslipModel->isPayslipGneratedForEmployee($v);
                            //sapp_Payrollcal::pre($rsData);
                            if(empty($rsData)){
                                $rsPayslipDetails=$payrollPayslipModel->getEmployeCronPaylip($v);
                                //sapp_Payrollcal::pre($rsPayslipDetails);
                                if(!empty($rsPayslipDetails)){
                                    if($bulkPayslipGenerateIdStr==""){
                                        $bulkPayslipGenerateIdStr=$rsPayslipDetails[0]['id'];
                                    }else{
                                        $bulkPayslipGenerateIdStr.=','.$rsPayslipDetails[0]['id'];
                                    }
                                    //sapp_Payrollcal::pre($bulkPayslipGenerateIdStr);
                                }
                            }
                        }
                    }
                    //sapp_Payrollcal::pre($bulkPayslipGenerateIdStr);
                    //die;
                    if($bulkPayslipGenerateIdStr!=""){
                        $payrollPayslipModel->generate_bulk($bulkPayslipGenerateIdStr);
                        $this->_helper->flashMessenger('Payslip generated successfully.');
                    }else{
                        $this->_helper->flashMessenger('Unknown error for payslip generation.');
                    }
                }
            }
        }
        $this->getResponse()->setRedirect($baseUrl->baseUrl().'/index.php/payslipemployee');
    }
    
    public function generateemployeepayslipAction(){
//        error_reporting(E_ALL);
//        ini_set('display_errors',1);
        $id = $this->_request->getParam('id');
        $err_msg_arr=array();
        $error=FALSE;
        $baseUrl = new Zend_View_Helper_BaseUrl();
        
        $payrollCal = new sapp_Payrollcal();
        $empsalarydetailsModal = new Default_Model_Empsalarydetails();
        $payrollcategoryModel = new Default_Model_Payrollcategory();
        $payrollGroup = new Default_Model_Payrollgroup();
        $payrollPayslipDetailsModel = new Default_Model_Payrollpayslipdetails();
                
        $this->view->id = $id;
        
        $bas = 0;
        
        if(isset($id) && $id > 0 && isset($_POST['month']) && $_POST['month']>0){
            $empModel=new Default_Model_Employee();
            $isExist=$empModel->employeeCheckExistByMainUserId($id);

            if($isExist[0]['Tot']>0){
                $empData = $empModel->employeeDetailsByMainUserId($id);
                
                $empId = $empData[0]['id'];
                $empSummaryData = $empModel->getsingleEmployeeData($empId);

                $todayTimestamp = time();
                $doj = $empSummaryData[0]['date_of_joining'];
                //echo $togenerateDate = date('Y-m-d',mktime(0, 0, 0, $_POST['month'])); die;
                $beforeDoj = 0;
                if($_POST['month'] < date('m',strtotime($doj)) && date('Y',strtotime($doj)) == date('Y')) {
                   $beforeDoj = 1;
                }
                
                if(((date('m') - date('m',strtotime($doj))) >= 1 || (date('Y') > date('Y',strtotime($doj)))) && $beforeDoj == 0) {
                    $last_day_this_month  = date('t',mktime(0, 0, 0, date('m'),10));
                    $joinDate = date('d',strtotime($doj));
//                    if(date('m',strtotime($doj)) == date('m',strtotime('-1 month'))){
//                        $workingDays = $last_day_this_month - $joinDate + 1;
//                    } else 
                    if(date('m',strtotime($doj)) == $_POST['month'] && date('Y',strtotime($doj)) == date('Y')) {
                        $dojLastDayOfMonth = date('t',mktime(0, 0, 0, date('m',strtotime($doj)),10));
                        $workingDays = $dojLastDayOfMonth - $joinDate + 1;
                    } 
                    else {
                        $dojLastDayOfMonth = $workingDays = date('t',mktime(0, 0, 0, $_POST['month'],10));
                    }
                       // echo $dojLastDayOfMonth; die;
                    $payrollPayslipModel=new Default_Model_Payrollpayslip();
                    $rsData=$payrollPayslipModel->isPayslipGneratedForEmployee($empId,$_POST['month']);
                    if(empty($rsData)){
                        $data = $empsalarydetailsModal->getsingleEmpSalaryDetailsData($empId);
                    
                        if(!empty($data)){
                            $bas=sapp_Global:: _decrypt( $data[0]['salary']);
                        }else{
                            $this->_helper->flashMessenger('Please define employee salary first to generate payslip.');
                            echo 2; // salary not defined
                            exit;
                        }
                        $basic = $bas;
                    //echo $workingDays; echo '=====';
                    $salaryPerDay = $bas / $dojLastDayOfMonth;//echo '=====';
                    $salaryForWorkingDays = $salaryPerDay * $workingDays;//echo '=====';
                    
                    $salaryCategory=array();
                    $salaryCategory['BAS']=$salaryForWorkingDays; //$bas;
                    $paySlipDataArr = array('emp_id' => $empId);
                    $payslip_id=$payrollPayslipModel->add($paySlipDataArr);
                    $allEarningDeduction=$payrollcategoryModel->get_all_earning_deduction($empId);

                    $totalSal=0;

                    foreach ($allEarningDeduction AS $key=>$value){
                        if ($value['code'] == "BAS") {
                            $salaryCategory['BAS']=$basic; //$bas;
                            $allEarningDeduction[$key]['value'] = $salaryForWorkingDays; //$bas;
                            $totalSal+=$salaryForWorkingDays; //$bas;
                            continue;
                        }else{
                            if ($value['value_type_id'] == 1) { 
                                //sapp_Payrollcal::pre($value);                     
                                $formula = $value['value_formula'];

                                $string = str_replace("%", "/100", $formula);

                                $salaryCategoryKeyArr= array_keys($salaryCategory);
                                $salaryCategoryValArr= array_values ($salaryCategory);

                                $salaryCategoryKeyStr= implode(',', $salaryCategoryKeyArr);
                                $salaryCategoryValStr= implode(',', $salaryCategoryValArr);
                                //sapp_Payrollcal::pre('$salaryCategoryKeyStr : '.$salaryCategoryKeyStr);
                                //sapp_Payrollcal::pre('$salaryCategoryValStr : - '.$salaryCategoryValStr);

                                $str = 'y(' . strtolower($salaryCategoryKeyStr) . ') = ' . strtolower($string);
                                //sapp_Payrollcal::pre('For '.$value['code'].' formula is : '.$str); 
                                $payrollCal->evaluate($str);

                                $calculatedValue = $payrollCal->e("y($salaryCategoryValStr)");

                                $allEarningDeduction[$key]['value']=$calculatedValue;
                                $tempSalaryCategoryalue=$allEarningDeduction[$key]['value'];
                                $salaryCategory[$value['code']]=$tempSalaryCategoryalue;
                            }else if($value['value_type_id'] == 2){ 
                                $conditionAmount = ''; $tempSalaryCategoryalue = 0;
                                //sapp_Payrollcal::pre($value);
                                ///sapp_Payrollcal::pre("comming for condition data checking : ".$value['code'].' == '.$value['value_formula']); //die;
                                $conditionValueDetails= sapp_Showpayrollcondition::get_payroll_condition_value_arr_in_edit($value['value_formula']);
                                //sapp_Payrollcal::pre($conditionValueDetails);//die;
                                switch ($conditionValueDetails['operator']){
                                    case "gt":
                                        if($salaryCategory[$conditionValueDetails['if']]>$conditionValueDetails['condition']){
                                            $conditionAmount=$conditionValueDetails['then'];
                                        }
                                        break;
                                    case "lt":
                                        //$opertator ="<";
                                        if($salaryCategory[$conditionValueDetails['if']]<$conditionValueDetails['condition']){
                                            $conditionAmount=$conditionValueDetails['then'];
                                        }
                                        break;
                                    case "ge":
                                        //$opertator =">=";
                                        if($salaryCategory[$conditionValueDetails['if']]>=$conditionValueDetails['condition']){ 
                                            $conditionAmount=$conditionValueDetails['then'];
                                        }
                                        break;
                                    case "le":
                                        //$opertator ="<=";
                                        if($salaryCategory[$conditionValueDetails['if']]<=$conditionValueDetails['condition']){
                                            $conditionAmount=$conditionValueDetails['then'];
                                        }
                                        break;
                                    case "et":
                                        //echo 'equal to======';
                                        //$opertator ="==";
                                        if($salaryCategory[$conditionValueDetails['if']]==$conditionValueDetails['condition']){ //echo 'if======';
                                            $conditionAmount=$conditionValueDetails['then'];
                                        }
                                        break;
                                    default:
                                    //$opertator ="==";
                                    if($salaryCategory[$conditionValueDetails['if']]==$conditionValueDetails['condition']){ 
                                        $conditionAmount=$conditionValueDetails['then'];
                                    }
                                    break;
                                }
                                //sapp_Payrollcal::pre('$conditionAmount : '.$conditionAmount);
                                if($conditionAmount!='') {
                                    $c_formula = $conditionAmount;

                                    $c_string = str_replace("%", "/100", $c_formula);

                                    $salaryCategoryKeyArr= array_keys($salaryCategory);
                                    $salaryCategoryValArr= array_values ($salaryCategory);

                                    $salaryCategoryKeyStr= implode(',', $salaryCategoryKeyArr);
                                    //echo '<br/>';
                                    $salaryCategoryValStr= implode(',', $salaryCategoryValArr);

                                    $c_str = 'y(' . strtolower($salaryCategoryKeyStr) . ') = ' . strtolower($c_string);
                                    //echo '=================<br/>';
                                    $payrollCal->evaluate($c_str);
                                    $calculatedValue = $payrollCal->e("y($salaryCategoryValStr)");// echo '<br/>';
                                    //echo '=============<br/>';
                                    if($calculatedValue > 0) {
                                        $allEarningDeduction[$key]['value']=$calculatedValue;
                                        $tempSalaryCategoryalue = $allEarningDeduction[$key]['value'];
                                        $salaryCategory[$value['code']] = $tempSalaryCategoryalue;
                                    }
                                }
                                }
                            else{ 
                                $tempSalaryCategoryalue = $value['value_formula'];
                                $salaryCategory[$value['code']] = $tempSalaryCategoryalue;
                                $allEarningDeduction[$key]['value'] = $tempSalaryCategoryalue;
                            }
                            if($value['type']==0){
                                $totalSal+=$tempSalaryCategoryalue;
                            }else{
                                $totalSal-=$tempSalaryCategoryalue;
                            } 
                        }
                        //echo $totalSal; echo '<br/>';
                    }
//                    print_r($allEarningDeduction);
//                    die;
//                        
                        foreach ($allEarningDeduction AS $k=>$v){ //print_r($v);
                            if($v['payroll_category_id']!="" && $v['value_formula']!="" && $v['value']!="" && $payslip_id!=""){
                                $payrollPayslipCateggoryDataArray=array('payroll_category_id'=>$v['payroll_category_id'],'formula'=>$v['value_formula'],'value'=>$v['value'],'payroll_payslip_id'=>$payslip_id);

                               $payrollPayslipDetailsModel->add($payrollPayslipCateggoryDataArray);
                            }
                            //echo '<pre>'; print_r($payrollPayslipCateggoryDataArray);
                        }
//die;
                        $payrollPayslipModel->edit(array("net_pay"=>$totalSal,'status'=>1,'payslip_month'=>$_POST['month'],'payslip_year'=>date('Y'),'generate_date'=>date('Y-m-d')),$payslip_id,'id');
                        if($bas>0){
                            $this->_helper->flashMessenger('Payslip has been generated successfully.');
                            exit;
                        }else{
                            $payrollPayslipModel->delete($payslip_id);
                            $this->_helper->flashMessenger('Please define employee salary first to generate payslip.');
                        }
                    } 
                    else {
                        $this->_helper->flashMessenger('Payslip of this employee has already been generated.');
                        exit;
                    }
                } else {  // end doj
                    if($beforeDoj == 1) {
                        $this->_helper->flashMessenger('Payslip can not be generated for month prior to employee joining date.');
                    } else {
                        $this->_helper->flashMessenger('Month of employee joining date must be less than current month to prepare payslip for previous month.');
                    }
                    echo false;
                    exit;
                }
            }
            //$this->_redirect('payslipemployee');
        }
    }
    
    public function generatebulkAction(){
        $err_msg_arr=array();
        $error=FALSE;
        $baseUrl = new Zend_View_Helper_BaseUrl();
        if($this->getRequest()->isPost()){
            $empId=trim($this->_request->getParam('selected_emp_ids',null));
            if($empId==""){
                $this->_helper->flashMessenger('Invalid employees selected, pleasee try again.');
            }else{
                
            }
            $this->view->empId = $empId;
        }
        
        //$this->getResponse()->setRedirect($baseUrl->baseUrl().'/index.php/payslipemployee');
    }
    
    public function generatebulkpayslipAction(){
//        error_reporting(E_ALL);
//        ini_set('display_errors',1);
        $err_msg_arr=array();
        $error=FALSE;
        $baseUrl = new Zend_View_Helper_BaseUrl();
        
        $payrollCal = new sapp_Payrollcal();
        $empsalarydetailsModal = new Default_Model_Empsalarydetails();
        $payrollcategoryModel = new Default_Model_Payrollcategory();
        $payrollGroup = new Default_Model_Payrollgroup();
        $payrollPayslipDetailsModel = new Default_Model_Payrollpayslipdetails();
        
        if($this->getRequest()->isPost()){
            //print_r($_POST); die;
            $empId=trim($this->_request->getParam('emp_ids',null));
            $this->view->empId = $empId;
            $month=trim($this->_request->getParam('month',null));
            if($empId==""){
                $this->_helper->flashMessenger('Invalid employees selected, please try again.');
            }else{
                $idArr= explode(',', $empId);
                $bulkPayslipGenerateIdStr = 0; $dojError = 0; $bulkError = 0;
                $payrollPayslipModel = new Default_Model_Payrollpayslip();
                $empModel = new Default_Model_Employee();

                foreach ($idArr As $k => $v) {
                    $emp_user_id = $v;
                    $empId = $empModel->getEmployeeByEmpId($emp_user_id);
                    $empSummaryData = $empModel->getsingleEmployeeData($empId);

                    $todayTimestamp = time();
                    $doj = $empSummaryData[0]['date_of_joining'];
                    $beforeDoj = 0;
                    if($_POST['month'] < date('m',strtotime($doj)) && date('Y',strtotime($doj)) == date('Y')) {
                       $beforeDoj = 1;
                    }
                    
                    if((count($empSummaryData)>0 && ((date('m') - date('m',strtotime($doj))) >= 1 || (date('Y') > date('Y',strtotime($doj))))) && $beforeDoj == 0) {
                        
                        $last_day_this_month  = date('t',mktime(0, 0, 0, date('m'),10));
                        $joinDate = date('d',strtotime($doj));
//                        if(date('m',strtotime($doj)) == date('m',strtotime('-1 month'))){
//                            $workingDays = $last_day_this_month - $joinDate + 1;
//                        } else 
                        if(date('m',strtotime($doj)) == $_POST['month'] && date('Y',strtotime($doj)) == date('Y')) {
                            $dojLastDayOfMonth = date('t',mktime(0, 0, 0, date('m',strtotime($doj)),10));
                            $workingDays = $dojLastDayOfMonth - $joinDate + 1;
                        } 
                        else {
                            $dojLastDayOfMonth = $workingDays = date('t',mktime(0, 0, 0, date('m',strtotime($doj)),10));
                        }
                        
                        $payrollPayslipModel=new Default_Model_Payrollpayslip();
                        $rsData=$payrollPayslipModel->isPayslipGneratedForEmployee($empId,$_POST['month']);
                        if(empty($rsData)){
                            $data = $empsalarydetailsModal->getsingleEmpSalaryDetailsData($empId);

                            if(!empty($data)){
                                $bas=sapp_Global:: _decrypt( $data[0]['salary']);
                            }else{
                                $bulkError++;
                                //$this->_helper->flashMessenger('Please define employee salary first to generate payslip.');
                                continue;
                            }
                            
                            $basic = $bas;
                            
                            $salaryPerDay = $bas / $dojLastDayOfMonth;
                            $salaryForWorkingDays = $salaryPerDay * $workingDays;

                            $salaryCategory=array();
                            $salaryCategory['BAS']=$salaryForWorkingDays; //$bas;
                            
                            $paySlipDataArr = array('emp_id' => $empId);
                            $payslip_id=$payrollPayslipModel->add($paySlipDataArr);
                            $allEarningDeduction=$payrollcategoryModel->get_all_earning_deduction($empId);

                            $totalSal=0;

                        foreach ($allEarningDeduction AS $key=>$value){
                            if ($value['code'] == "BAS") {
                                $salaryCategory['BAS']=$basic; //$bas;
                                $allEarningDeduction[$key]['value'] = $salaryForWorkingDays; //$bas;
                                $totalSal+=$salaryForWorkingDays; //$bas;
                                continue;
                            }else{
                                if ($value['value_type_id'] == 1) { 
                                    sapp_Payrollcal::pre($value);                     
                                    $formula = $value['value_formula'];

                                    $string = str_replace("%", "/100", $formula);

                                    $salaryCategoryKeyArr= array_keys($salaryCategory);
                                    $salaryCategoryValArr= array_values ($salaryCategory);

                                    $salaryCategoryKeyStr= implode(',', $salaryCategoryKeyArr);
                                    $salaryCategoryValStr= implode(',', $salaryCategoryValArr);
                                    sapp_Payrollcal::pre('$salaryCategoryKeyStr : '.$salaryCategoryKeyStr);
                                    sapp_Payrollcal::pre('$salaryCategoryValStr : - '.$salaryCategoryValStr);

                                    $str = 'y(' . strtolower($salaryCategoryKeyStr) . ') = ' . strtolower($string);
                                    sapp_Payrollcal::pre('For '.$value['code'].' formula is : '.$str); 
                                    $payrollCal->evaluate($str);

                                    $calculatedValue = $payrollCal->e("y($salaryCategoryValStr)");

                                    $allEarningDeduction[$key]['value']=$calculatedValue;
                                    $tempSalaryCategoryalue=$allEarningDeduction[$key]['value'];
                                    $salaryCategory[$value['code']]=$tempSalaryCategoryalue;
                                }else if($value['value_type_id'] == 2){ 
                                    $conditionAmount= ''; $tempSalaryCategoryalue = 0;
                                    sapp_Payrollcal::pre("comming for condition data checking : ".$value['code'].' == '.$value['value_formula']);
                                    $conditionValueDetails= sapp_Showpayrollcondition::get_payroll_condition_value_arr_in_edit($value['value_formula']);

                                    switch ($conditionValueDetails['operator']){
                                    case "gt":
                                        if($salaryCategory[$conditionValueDetails['if']]>$conditionValueDetails['condition']){
                                            $conditionAmount=$conditionValueDetails['then'];
                                        }
                                        break;
                                    case "lt":
                                        //$opertator ="<";
                                        if($salaryCategory[$conditionValueDetails['if']]<$conditionValueDetails['condition']){
                                            $conditionAmount=$conditionValueDetails['then'];
                                        }
                                        break;
                                    case "ge":
                                        //$opertator =">=";
                                        if($salaryCategory[$conditionValueDetails['if']]>=$conditionValueDetails['condition']){
                                            $conditionAmount=$conditionValueDetails['then'];
                                        }
                                        break;
                                    case "le":
                                        //$opertator ="<=";
                                        if($salaryCategory[$conditionValueDetails['if']]<=$conditionValueDetails['condition']){
                                            $conditionAmount=$conditionValueDetails['then'];
                                        }
                                        break;
                                    case "et":
                                        //$opertator ="==";
                                        if($salaryCategory[$conditionValueDetails['if']]==$conditionValueDetails['condition']){
                                            $conditionAmount=$conditionValueDetails['then'];
                                        }
                                        break;
                                    default:
                                    //$opertator ="==";
                                    if($salaryCategory[$conditionValueDetails['if']]==$conditionValueDetails['condition']){
                                        $conditionAmount=$conditionValueDetails['then'];
                                    }
                                    break;
                                }
                                if($conditionAmount!='') {
                                    $c_formula = $conditionAmount;

                                    $c_string = str_replace("%", "/100", $c_formula);

                                    $salaryCategoryKeyArr= array_keys($salaryCategory);
                                    $salaryCategoryValArr= array_values ($salaryCategory);

                                    $salaryCategoryKeyStr= implode(',', $salaryCategoryKeyArr);
                                    $salaryCategoryValStr= implode(',', $salaryCategoryValArr);

                                    $c_str = 'y(' . strtolower($salaryCategoryKeyStr) . ') = ' . strtolower($c_string);
                                    $payrollCal->evaluate($c_str);
                                    $calculatedValue = $payrollCal->e("y($salaryCategoryValStr)");

                                    if($calculatedValue > 0) {
                                        $allEarningDeduction[$key]['value']=$calculatedValue;
                                        $tempSalaryCategoryalue = $allEarningDeduction[$key]['value'];
                                        $salaryCategory[$value['code']] = $tempSalaryCategoryalue;
                                    }
                                }
                                }  else{ 
                                        $tempSalaryCategoryalue = $value['value_formula'];
                                        $salaryCategory[$value['code']] = $tempSalaryCategoryalue;
                                        $allEarningDeduction[$key]['value'] = $tempSalaryCategoryalue;
                                    }
                                    if($value['type']==0){
                                        $totalSal+=$tempSalaryCategoryalue;
                                    }else{
                                        $totalSal-=$tempSalaryCategoryalue;
                                    } 
                                }
                            }
                        
                        foreach ($allEarningDeduction AS $k=>$v){
                            if($v['payroll_category_id']!="" && $v['value_formula']!="" && $v['value']!="" && $payslip_id!=""){
                                $payrollPayslipCateggoryDataArray=array('payroll_category_id'=>$v['payroll_category_id'],'formula'=>$v['value_formula'],'value'=>$v['value'],'payroll_payslip_id'=>$payslip_id);

                                $payrollPayslipDetailsModel->add($payrollPayslipCateggoryDataArray);
                            }
                        }

                        $payrollPayslipModel->edit(array("net_pay"=>$totalSal,'status'=>1,'payslip_month'=>$_POST['month'],'payslip_year'=>date('Y'),'generate_date'=>date('Y-m-d')),$payslip_id,'id');
                        if($bas>0){
                           // $this->_helper->flashMessenger('Payslip has been generated successfully.');
                        }else{
                            $payrollPayslipModel->delete($payslip_id);
                            //$this->_helper->flashMessenger('Please define employee salary first to generate payslip.');
                        }
                    } 
                        else {
                            $bulkPayslipGenerateIdStr++;
                        }
                    } else {
                        $dojError++;
                    }
                }
                if($bulkError == count($idArr)){
                    $this->_helper->flashMessenger('Please define employee salary first to generate payslip.');
                }
                if($bulkError > 0 && $bulkError < count($idArr)){
                    $this->_helper->flashMessenger('Salary is not defined for some employees.');
                }
                if($dojError == count($idArr)){
                    $this->_helper->flashMessenger('employee date of joining must be a past date.');
                } 
                if($dojError > 0 && $dojError < count($idArr)) {
                    $this->_helper->flashMessenger('For some employees, date of joining is future date, so payslip can\'t be generated.');
                }
                if(count($idArr) == $bulkPayslipGenerateIdStr) {
                    $this->_helper->flashMessenger('Payslip of selected employees has already been generated.');
                } 
                if($bulkPayslipGenerateIdStr > 0 && $bulkPayslipGenerateIdStr < count($idArr)){
                    $this->_helper->flashMessenger('Payslip of some employees has already been generated.');
                }
            }
            
            $this->_redirect('payslipemployee');
        } else {
            $this->_helper->flashMessenger('Invalid details for payslip generation.');
            $this->_redirect('payslipemployee');
        }
        
        //$this->getResponse()->setRedirect($baseUrl->baseUrl().'/index.php/payslipemployee');
    }
    
}

