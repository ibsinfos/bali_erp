<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Default_PayslipgroupController extends Zend_Controller_Action {

    public function init() {
        $flash_messages = $this->_helper->flashMessenger->getMessages();
        if (!empty($flash_messages))
            $this->_helper->layout->getView()->flash_messages = $flash_messages[0];
    }

    //private $options;
    public function preDispatch() {
        parent::preDispatch();
        $ajaxContext = $this->_helper->getHelper('AjaxContext');
    }

    public function indexAction() {
        $auth = Zend_Auth::getInstance();
        $popConfigPermission = array();
        if ($auth->hasIdentity()) {
            $loginUserId = $auth->getStorage()->read()->id;
            $loginuserRole = $auth->getStorage()->read()->emprole;
            $loginuserGroup = $auth->getStorage()->read()->group_id;
        }
        $employeeModel = new Default_Model_Employee();
        $role_model = new Default_Model_Roles();
        $currentOrgHead = $employeeModel->getCurrentOrgHead();
        if (!empty($currentOrgHead)) {
            $call = $this->_getParam('call');
            if ($call == 'ajaxcall')
                $this->_helper->layout->disableLayout();

            if (sapp_Global::_checkprivileges(PREFIX, $loginuserGroup, $loginuserRole, 'add') == 'Yes') {
                array_push($popConfigPermission, 'prefix');
            }
            if (sapp_Global::_checkprivileges(IDENTITYCODES, $loginuserGroup, $loginuserRole, 'edit') == 'Yes') {
                array_push($popConfigPermission, 'identitycodes');
            }
            if (sapp_Global::_checkprivileges(EMPLOYMENTSTATUS, $loginuserGroup, $loginuserRole, 'add') == 'Yes') {
                array_push($popConfigPermission, 'empstatus');
            }
            if (sapp_Global::_checkprivileges(JOBTITLES, $loginuserGroup, $loginuserRole, 'add') == 'Yes') {
                array_push($popConfigPermission, 'jobtitles');
            }
            if (sapp_Global::_checkprivileges(POSITIONS, $loginuserGroup, $loginuserRole, 'add') == 'Yes') {
                array_push($popConfigPermission, 'position');
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
                $by = 'r.id';
                $pageNo = 1;
                $searchData = '';
                $searchQuery = '';
                $searchArray = '';
            }
            else {
                $sort = ($this->_getParam('sort') != '') ? $this->_getParam('sort') : 'DESC';
                $by = ($this->_getParam('by') != '') ? $this->_getParam('by') : 'r.id';

                if ($dashboardcall == 'Yes')
                    $perPage = $this->_getParam('per_page', DASHBOARD_PERPAGE);
                else
                    $perPage = $this->_getParam('per_page', PERPAGE);

                $pageNo = $this->_getParam('page', 1);
                $searchData = $this->_getParam('searchData');
                $searchData = rtrim($searchData, ',');
            }
            //$jduhiTmpData='$sort : '.$sort.' == $by : '.$by.' == $perPage : '.$perPage.' == $pageNo : '.$pageNo.' == $searchData : '.$searchData.' == $call : '.$call.' == $dashboardcall : '.$dashboardcall;
            //die($jduhiTmpData);
            //die("kkk");
            //$dataTmp = $role_model->getGrid($sort, $by, $perPage, $pageNo, $searchData,$call,$dashboardcall,$loginUserId);
            $dataTmp = $role_model->getPayrollGrid($sort, $by, $perPage, $pageNo, $searchData, $call, $dashboardcall, '', '', '', '');
            //$dataTmp = $employeeModel->getGrid($sort, $by, $perPage, $pageNo, $searchData,$call,$dashboardcall,$loginUserId);
            //print_r($dataTmp);
            array_push($data, $dataTmp);
            //sapp_Payrollcal::pre($data);die;
            $this->view->dataArray = $data;
            $this->view->call = $call;
        }
        else {
            //$this->addorganisationhead($loginUserId);
        }
        $this->view->messages = $this->_helper->flashMessenger->getMessages();
    }

    public function addAction() {
        $emptyFlag = 0;
        $report_opt = array();
        $popConfigPermission = array();
        $auth = Zend_Auth::getInstance();
        $candidateid = $this->_request->getParam('cid');
        if ($auth->hasIdentity()) {
            $loginUserId = $auth->getStorage()->read()->id;
            $loginuserRole = $auth->getStorage()->read()->emprole;
            $loginuserGroup = $auth->getStorage()->read()->group_id;
        }

        $employeeModel = new Default_Model_Employee();
        $currentOrgHead = $employeeModel->getCurrentOrgHead();

        if (empty($currentOrgHead)) {
            $this->addorganisationhead($loginUserId);
        } else {
            if (sapp_Global::_checkprivileges(PREFIX, $loginuserGroup, $loginuserRole, 'add') == 'Yes') {
                array_push($popConfigPermission, 'prefix');
            }
            if (sapp_Global::_checkprivileges(IDENTITYCODES, $loginuserGroup, $loginuserRole, 'edit') == 'Yes') {
                array_push($popConfigPermission, 'identitycodes');
            }
            if (sapp_Global::_checkprivileges(EMPLOYMENTSTATUS, $loginuserGroup, $loginuserRole, 'add') == 'Yes') {
                array_push($popConfigPermission, 'empstatus');
            }
            if (sapp_Global::_checkprivileges(JOBTITLES, $loginuserGroup, $loginuserRole, 'add') == 'Yes') {
                array_push($popConfigPermission, 'jobtitles');
            }
            if (sapp_Global::_checkprivileges(POSITIONS, $loginuserGroup, $loginuserRole, 'add') == 'Yes') {
                array_push($popConfigPermission, 'position');
            }
        }
        $this->view->popConfigPermission = $popConfigPermission;
        //$employeeform = new Default_Form_employee();
    }

    public function generateAction() {
        $id = $this->_request->getParam('id');
        //error_reporting(E_ALL|E_STRICT);
        //ini_set('display_errors', 'on');
        //die($id);
        $baseUrl = new Zend_View_Helper_BaseUrl();
        if ($id != "") {
            $role_model = new Default_Model_Roles();
            $idArr = $role_model->getAllEmployeIdByRoleId($id);
            if (empty($idArr)) {
                $this->_helper->flashMessenger('No active employee found with selected role, pleasee try again.');
            } else {
                $bulkPayslipGenerateIdStr = '';
                $payrollPayslipModel = new Default_Model_Payrollpayslip();
                $empModel = new Default_Model_Employee();
                //sapp_Payrollcal::pre($idArr);
                foreach ($idArr As $k => $v) {
                    $rsData = $payrollPayslipModel->isPayslipGneratedForEmployee($v['id']);
                    //sapp_Payrollcal::pre($rsData);die;
                    if (empty($rsData)) {
                        $rsPayslipDetails = $payrollPayslipModel->getEmployeCronPaylip($v['id']);
                        //sapp_Payrollcal::pre($rsPayslipDetails);die;
                        if (!empty($rsPayslipDetails)) {
                            if ($bulkPayslipGenerateIdStr == "") {
                                $bulkPayslipGenerateIdStr = $rsPayslipDetails[0]['id'];
                            } else {
                                $bulkPayslipGenerateIdStr .= ',' . $rsPayslipDetails[0]['id'];
                            }
                            //sapp_Payrollcal::pre($bulkPayslipGenerateIdStr);
                        }
                    }//die;
                }
                //sapp_Payrollcal::pre($bulkPayslipGenerateIdStr);
                //die;
                if ($bulkPayslipGenerateIdStr != "") {
                    $payrollPayslipModel->generate_bulk($bulkPayslipGenerateIdStr);
                    $this->_helper->flashMessenger('Payslip generated successfully.');
                } else {
                    $this->_helper->flashMessenger('Unlnown errorr for payslip generation.');
                }
            }
            $this->_helper->flashMessenger('Payslip generated for group successfully.');
        } else {
            // send error message
            $this->_helper->flashMessenger('Payslip generated for group successfully.');
        }
        $this->getResponse()->setRedirect($baseUrl->baseUrl() . '/index.php/payslipgroup');
    }
    
    public function generateemployeepayslipAction() {
        $id = $this->_request->getParam('id');
        $this->view->id = $id;
        //error_reporting(E_ALL|E_STRICT);
        //ini_set('display_errors', 'on');
        //die($id);
        $baseUrl = new Zend_View_Helper_BaseUrl();
        
        $payrollCal = new sapp_Payrollcal();
        $empsalarydetailsModal = new Default_Model_Empsalarydetails();
        $payrollcategoryModel = new Default_Model_Payrollcategory();
        $payrollGroup = new Default_Model_Payrollgroup();
        $payrollPayslipDetailsModel = new Default_Model_Payrollpayslipdetails();
        
        $bas = 0;
        
        if(isset($id) && $id > 0 && isset($_POST['month']) && $_POST['month']>0){
            $role_model = new Default_Model_Roles();
            $idArr = $role_model->getAllEmployeIdByRoleId($id);
            
            if (empty($idArr)) {
                $this->_helper->getHelper("FlashMessenger")->addMessage(array("error"=>"No active employees found with selected role, please try again."));
            } else {
                $bulkPayslipGenerateIdStr = 0; $dojError = 0; $bulkError = 0;
                $payrollPayslipModel = new Default_Model_Payrollpayslip();
                $empModel = new Default_Model_Employee();

                foreach ($idArr As $k => $v) {
                    $empId = $v['id'];
                    $empSummaryData = $empModel->getsingleEmployeeData($empId);
                    $todayTimestamp = time();
                    $doj = $empSummaryData[0]['date_of_joining'];
                    
                    $beforeDoj = 0;
                    if($_POST['month'] < date('m',strtotime($doj)) && date('Y',strtotime($doj)) == date('Y')) {
                       $beforeDoj = 1;
                    }
                    
                    if(((date('m') - date('m',strtotime($doj))) >= 1 || (date('Y') > date('Y',strtotime($doj)))) && $beforeDoj == 0)  {
                        
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
                            //$this->_helper->flashMessenger('Payslip has been generated successfully.');
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
                    $this->_helper->flashMessenger('Salary is not defined for some employees. Payslip has been generated for remaining employees.');
                }
                if($dojError == count($idArr)){
                    $this->_helper->flashMessenger('employee date of joining must be a past date.');
                } 
                if($dojError > 0 && $dojError < count($idArr)) {
                    $this->_helper->flashMessenger('For some employees, date of joining is future date, so payslip can\'t be generated. Payslip has been generated for remaining employees.');
                }
                if(count($idArr) == $bulkPayslipGenerateIdStr) {
                    $this->_helper->flashMessenger('Payslip of selected employees has already been generated.');
                } 
                if($bulkPayslipGenerateIdStr > 0 && $bulkPayslipGenerateIdStr < count($idArr)){
                    $this->_helper->flashMessenger('Payslip of some employees has already been generated. Payslip has been generated for remaining employees.');
                }
//                if(count($idArr) == $bulkPayslipGenerateIdStr) {
//                    $this->_helper->getHelper("FlashMessenger")->addMessage(array("success"=>"Payslip of some employees has already been generated."));
//                } else {
//                    $this->_helper->getHelper("FlashMessenger")->addMessage(array("success"=>"Payslip has been generated for group successfully."));
//                }
            }
            //$this->_redirect('payslipgroup');
        } else {
            // send error message
            //$this->_helper->flashMessenger('Payslip could not be generated for some employees.');
        }
        
    }

    public function filterAction() {
        $arr = array('0' => 'A', '1' => 'B');
        $this->view->arr = $arr;
    }

}
