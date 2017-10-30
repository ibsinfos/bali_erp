<?php
/********************************************************************************* 
 *  This file is part of Sentrifugo.
 *  Copyright (C) 2015 Sapplica
 *   
 *  Sentrifugo is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  Sentrifugo is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with Sentrifugo.  If not, see <http://www.gnu.org/licenses/>.
 *
 *  Sentrifugo Support <support@sentrifugo.com>
 ********************************************************************************/

class Default_ViewwpsreportController extends Zend_Controller_Action
{

	private $options;
	private $userlog_model;
	public function preDispatch()
	{
		$ajaxContext = $this->_helper->getHelper('AjaxContext');
		$ajaxContext->addActionContext('empauto', 'json')->initContext();
		
	}

	/**
	 * Init
	 *
	 * @see Zend_Controller_Action::init()
	 */
	public function init()
	{
            $this->_options= $this->getInvokeArg('bootstrap')->getOptions();
	}
        
        public function indexoldAction() {
            $auth = Zend_Auth::getInstance();
            if ($auth->hasIdentity()) {
                $loginUserId = $auth->getStorage()->read()->id;
            }
            $userid = $this->getRequest()->getParam('userid');
            $payslip_id = $this->getRequest()->getParam('payslipid');
            $this->view->payslip_id = $payslip_id;
            $paymentprotectionmodel = new Default_Model_Paymentprotection();
            $employeeModal = new Default_Model_Employee();
            $empsalarydetailsModal = new Default_Model_Empsalarydetails();
            $payrollPayslipDetailsModal = new Default_Model_Payrollpayslipdetails();
            $salarySlipDetails=$payrollPayslipDetailsModal->get_details_by_employee_id($userid);
            $netPayDetails=$payrollPayslipDetailsModal->get_current_net_pay($userid);
            $payrollCal = new sapp_Payrollcal();
            $paymentprotectiondetails = $paymentprotectionmodel->get_wps_report_by_employee_id($userid);

            $earningColArr=array();
            $deductColArr=array();
            foreach ($salarySlipDetails AS $k =>$v){
                if($v['type']==0){
                    $tempArr=array();
                    $tempArr['name']=$v['name'];
                    $tempArr['value']=$v['value'];
                    $earningColArr[]=$tempArr;
                }else{
                    $tempArr=array();
                    $tempArr['name']=$v['name'];
                    $tempArr['value']=$v['value'];
                    $deductColArr[]=$tempArr;
                }
            }

            $data = $empsalarydetailsModal->getsingleEmpSalaryDetailsData($userid);
            if (!empty($data)) {
                $bas = sapp_Global:: _decrypt($data[0]['salary']);
                $data[0]['salary']=$bas;
            }

            $isrowexist = $employeeModal->getsingleEmployeeData($userid);
            if ($isrowexist == 'norows')
                $this->view->rowexist = "norows";
            else
                $this->view->rowexist = "rows";

            $empdata = $employeeModal->getActiveEmployeeData($userid);
            if (!empty($empdata)) {
                $emppayslipsModel = new Default_Model_Emppayslips();
                if ($userid) {
                    //To display Employee Profile information......
                    $usersModel = new Default_Model_Users();
                    $employeeData = $usersModel->getUserDetailsByIDandFlag($userid);
                }
                $this->view->id = $userid;
                $this->view->employeedata = $employeeData[0];

                // Code by Shuchita
                if ($userid) {
                    //To display Employee Profile information......
                    $empLeavesModel = new Default_Model_Employeeleaves();
                    $employeeLeavesData = $empLeavesModel->getsingleEmployeeleaveData($userid);
                    $empLeaveData=$employeeLeavesData[0];
                    $this->view->empLeaveData=$empLeaveData;
                }

                $empsalarydetailsModal = new Default_Model_Empsalarydetails();
                $payrollPayslip = new Default_Model_Payrollpayslip();
                $payrollcategoryModel = new Default_Model_Payrollcategory();
                $payrollGroup = new Default_Model_Payrollgroup();
                $payrollPayslipDetailsModel = new Default_Model_Payrollpayslipdetails();
                $data1 = $empsalarydetailsModal->getsingleEmpSalaryDetailsData($userid);

                $empPayslipData = $payrollPayslip->get_data($payslip_id);
                $this->view->empPayslipData=$empPayslipData;

                if(!empty($data)){
                    $bas=sapp_Global:: _decrypt( $data1[0]['salary']);
                }else{
                    continue;
                }

                $salaryCategory=array();
                $salaryCategory['BAS']=$bas;

                $allEarningDeduction=$payrollcategoryModel->get_emp_earning_deduction($userid);

                $totalSal=0;
                $totalSal=$empPayslipData[0]['net_pay'];
                if(count($allEarningDeduction)>0) {
                 foreach ($allEarningDeduction AS $key=>$value){
                    $allEarningDeduction[$key]['payroll_category_id'] = $value['payroll_category_id'];
                    $allEarningDeduction[$key]['type'] = $value['type'];
                    if ($value['code'] == "BAS") {
                        $salaryCategory['BAS']=$bas;
                        $allEarningDeduction[$key]['value'] = $bas;
                        $totalSal+=$bas;
                        continue;
                    }else{
                        if ($value['value_type_id'] == 1) {
                        $formula = $value['value_formula'];
                        $string = str_replace("%", "/100", $formula);

                        $salaryCategoryKeyArr= array_keys($salaryCategory);
                        $salaryCategoryValArr= array_values ($salaryCategory);
                        $salaryCategoryKeyStr= implode(',', $salaryCategoryKeyArr);
                        $salaryCategoryValStr= implode(',', $salaryCategoryValArr);

                        $str = 'y(' . strtolower($salaryCategoryKeyStr) . ') = ' . strtolower($string);
                        $payrollCal->evaluate($str);
                        $calculatedValue = $payrollCal->e("y($salaryCategoryValStr)");

                        $allEarningDeduction[$key]['value']=$calculatedValue;
                        $tempSalaryCategoryalue=$allEarningDeduction[$key]['value'];
                        $salaryCategory[$value['code']]=$tempSalaryCategoryalue;
                    }
                    else if($value['value_type_id'] == 2){
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

                    $allEarningDeduction[$key]['value']=$conditionAmount;
                    $tempSalaryCategoryalue=$allEarningDeduction[$key]['value'];
                    $salaryCategory[$value['code']]=$tempSalaryCategoryalue;
                }
                    else{
                    ///fix
                        $tempSalaryCategoryalue=$value['value_formula'];
                        $salaryCategory[$value['code']]=$tempSalaryCategoryalue;
                        $allEarningDeduction[$key]['value'] = $tempSalaryCategoryalue;
                    }

                    if($value['type']==0){

                    }else{

                    } 
                    }
                }

                foreach ($allEarningDeduction AS $k=>$v){ 
                $checkExist = $payrollPayslipDetailsModel->get_data_by_category_id($v['payroll_category_id'],$payslip_id);

                if(count($checkExist) == 0) {
                    if($v['type']==0) {
                        $totalSal+=$v['value'];
                    } else {
                        $totalSal-=$v['value'];
                    }
                    if($v['payroll_category_id']!="" && $v['value']!="" && $payslip_id!=""){
                        $payrollPayslipCateggoryDataArray=array('payroll_category_id'=>$v['payroll_category_id'],'formula'=>$v['value_formula'],'value'=>$v['value'],'payroll_payslip_id'=>$payslip_id);
                        $payrollPayslipDetailsModel->add($payrollPayslipCateggoryDataArray);
                    }
                } else {
                    $payrollCateData = $payrollcategoryModel->get_category_data($checkExist[0]['payroll_category_id']);
                    if($payrollCateData[0]['type']==0) {
                        $totalSal-=$checkExist[0]['value'];
                        $totalSal+=$v['value'];
                    } else {
                        $totalSal+=$checkExist[0]['value'];
                        $totalSal-=$v['value'];
                    }
                    $payrollPayslipCateggoryDataArray=array('formula'=>$v['value_formula'],'value'=>$v['value']);
                    $payrollPayslipDetailsModel->editpayslipdata($payrollPayslipCateggoryDataArray,$checkExist[0]['id']);
                }
            }
                }

            $paySlipDataArr = array("net_pay"=>$totalSal);
            $payrollPayslipData=$payrollPayslip->update($paySlipDataArr,$payslip_id);
            if($totalSal>0){
            }else{
                $payrollPayslip->delete($payslip_id);
            }

                // Code by Shuchita
                if ($this->getRequest()->getPost()) {

                }
            }

            $this->view->salarydetails=$data[0];
            $this->view->earningColArr=$earningColArr;
            $this->view->deductColArr=$deductColArr;
            $this->view->netPayDetails=$netPayDetails;
            $this->view->netPay = $netPay;
            $this->view->empdata = $empdata;
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
            $paymentprotectionmodel = new Default_Model_Paymentprotection(); 
            $currentOrgHead = $employeeModel->getCurrentOrgHead();
            
            $employment_status_model = new Default_Model_Employmentstatus();
            
            $employmentStatusData = $employment_status_model->getempstatusActivelist();
            $all_employees=$paymentprotectionmodel->get_all_employee_generated_wps('','');

            $this->view->employmentStatusData=$employmentStatusData;
            $this->view->all_employees=$all_employees;
        }
        
        public function getemployeesbystatusAction(){
            $type = $this->_request->getParam('type',null);
            $month = $this->_request->getParam('month',null);
            $paymentprotectionmodel = new Default_Model_Paymentprotection(); 
            $all_employees=$paymentprotectionmodel->get_all_employee_generated_wps($type,$month);
            
            $empList = '<option value="">Select Employee Name</option>';
            
            foreach($all_employees as $k=>$v){
                $empList.='<option value="'.$v['firstname'].' '.$v['lastname'].'">'.$v['firstname'].' '.$v['lastname'].'</option>';
            }
            
            echo $empList;
            exit();
        }

        public function filterAction(){
            //error_reporting(E_ALL);
            //ini_set("display_errors", 1);
            $this->_helper->layout()->disableLayout();
            //$this->_helper->viewRenderer->setNoRender();
            $content="judhisthira";
            $year =  $this->_getParam('year', date('Y'));
            $month=  $this->_getParam('month', date('m'));
            $empstatus=  $this->_getParam('empstatus', "");
            $emp_name=  $this->_getParam('emp_name', "");

            $empsalarydetailsModal = new Default_Model_Empsalarydetails();
            $empLeavesModel = new Default_Model_Employeeleaves();

            $filterData = array();
     
            $paymentprotectionmodel = new Default_Model_Paymentprotection(); 
            $filterData=$paymentprotectionmodel->get_data_with_filter($month,$empstatus,$emp_name,$year);

            //print_r($filterData); die;
            
            $i = 0;
            foreach($filterData as $key=>$data) { 
                $userid = $data['user_id'];
                $data1 = $empsalarydetailsModal->getsingleEmpSalaryDetailsData($userid); 
                if (!empty($data1)) {
                    $bas = sapp_Global:: _decrypt($data1[0]['salary']);
                    $salary = $bas;
                }

                $employeeLeavesData = $empLeavesModel->getsingleEmployeeleaveData($userid);
                $empLeaveData=$employeeLeavesData[0];
                $salaryPerDay=$salary/30;

                if($empLeaveData['emp_leave_limit']>=$empLeaveData['used_leaves']) { 
                    $lop=0;
                }else{
                    $lop=$empLeaveData['used_leaves']-$empLeaveData['emp_leave_limit'];
                }

                $presentDays=30-$lop;
                $salaryForPresentDays=$presentDays*$salaryPerDay;
                $deductedSalary=$salaryPerDay*$lop;
                $filterData[$i]['net_pay']=$data['net_pay']-$deductedSalary;     
                $i++;
            }

            $this->view->filterData = $filterData;
            $this->render('ajax');
        }
        
         public function viewAction() {
            $auth = Zend_Auth::getInstance();
            if ($auth->hasIdentity()) {
                $loginUserId = $auth->getStorage()->read()->id;
            }
            $userid = $this->getRequest()->getParam('userid');
            $reportid = $this->getRequest()->getParam('reportid');
            
            $paymentprotectionmodel = new Default_Model_Paymentprotection(); 
            $wpsData = $paymentprotectionmodel->get_data_by_id($reportid);
            $this->view->wpsData = $wpsData[0];
            $payslip_id = $wpsData[0]['payslip_id'];
            $this->view->payslip_id = $payslip_id;
            
            $employeeModal = new Default_Model_Employee();
            $empsalarydetailsModal = new Default_Model_Empsalarydetails();
            $payrollPayslipDetailsModal = new Default_Model_Payrollpayslipdetails();
            $salarySlipDetails=$payrollPayslipDetailsModal->get_details_by_employee_id($userid,$payslip_id);
            $netPayDetails=$payrollPayslipDetailsModal->get_current_net_pay($userid,$payslip_id);
            
            $currencyModel = new Default_Model_Currency();
            
            $payrollCal = new sapp_Payrollcal();
            $earningColArr=array();
            $deductColArr=array();
            foreach ($salarySlipDetails AS $k =>$v){
                if($v['type']==0){
                    $tempArr=array();
                    $tempArr['name']=$v['name'];
                    $tempArr['value']=$v['value'];
                    $earningColArr[]=$tempArr;
                }else{
                    $tempArr=array();
                    $tempArr['name']=$v['name'];
                    $tempArr['value']=$v['value'];
                    $deductColArr[]=$tempArr;
                }
            }

            $data = $empsalarydetailsModal->getsingleEmpSalaryDetailsData($userid);
            if (!empty($data)) {
                $bas = sapp_Global:: _decrypt($data[0]['salary']);
                $data[0]['salary']=$bas;
            }
            
            $currency = $currencyModel->getCurrencyDataByID($data[0]['currencyid']);
            $this->view->currency=$currency[0];

            $isrowexist = $employeeModal->getsingleEmployeeData($userid);
            if ($isrowexist == 'norows')
                $this->view->rowexist = "norows";
            else
                $this->view->rowexist = "rows";

            $empdata = $employeeModal->getActiveEmployeeData($userid);
            
            $employeeSummaryData = $employeeModal->getEmp_from_summary($userid);
            $this->view->employeeSummaryData=$employeeSummaryData;
            
            if (!empty($empdata)) {
                $emppayslipsModel = new Default_Model_Emppayslips();
                if ($userid) {
                    //To display Employee Profile information......
                    $usersModel = new Default_Model_Users();
                    $employeeData = $usersModel->getUserDetailsByIDandFlag($userid);
                    if($employeeData[0]['vendor_id']!='' && $employeeData[0]['vendor_id']!=NULL) {
                        $vendorModel = new Default_Model_Vendors();
                        $vendorData = $vendorModel->getsingleVendorsData($employeeData[0]['vendor_id']);
                        $employeeData[0]['vendor_name'] = $vendorData['name'];
                    }
                    
                }
                $this->view->id = $userid;
                $this->view->employeedata = $employeeData[0];

                // Code by Shuchita
                if ($userid) {
                    //To display Employee Profile information......
                    $empLeavesModel = new Default_Model_Employeeleaves();
                    $employeeLeavesData = $empLeavesModel->getsingleEmployeeleaveData($userid);
                    $empLeaveData=$employeeLeavesData[0];
                    $this->view->empLeaveData=$empLeaveData;
                }
                    
                // Calculation for payroll category

                $empsalarydetailsModal = new Default_Model_Empsalarydetails();
                $payrollPayslip = new Default_Model_Payrollpayslip();
                $payrollcategoryModel = new Default_Model_Payrollcategory();
                $payrollGroup = new Default_Model_Payrollgroup();
                $payrollPayslipDetailsModel = new Default_Model_Payrollpayslipdetails();
                $data1 = $empsalarydetailsModal->getsingleEmpSalaryDetailsData($userid);

                $empPayslipData = $payrollPayslip->get_data($payslip_id);
                $this->view->empPayslipData=$empPayslipData;

                if(!empty($data)){
                 $bas=sapp_Global:: _decrypt( $data1[0]['salary']);
                }else{
                    continue;
                }

                $salaryCategory=array();
                $salaryCategory['BAS']=$bas;

                $allEarningDeduction=$payrollcategoryModel->get_emp_earning_deduction($userid,$payslip_id);

                $totalSal=0;
                $totalSal=$empPayslipData[0]['net_pay'];
                if(count($allEarningDeduction)>0) {
                 foreach ($allEarningDeduction AS $key=>$value){
                        $allEarningDeduction[$key]['payroll_category_id'] = $value['payroll_category_id'];
                        $allEarningDeduction[$key]['type'] = $value['type'];
                        if ($value['code'] == "BAS") {
                            $salaryCategory['BAS']=$bas;
                            $allEarningDeduction[$key]['value'] = $bas;
                            $totalSal+=$bas;
                            continue;
                        }else{
                            if ($value['value_type_id'] == 1) {
                            $formula = $value['value_formula'];
                            $string = str_replace("%", "/100", $formula);

                            $salaryCategoryKeyArr= array_keys($salaryCategory);
                            $salaryCategoryValArr= array_values ($salaryCategory);
                            $salaryCategoryKeyStr= implode(',', $salaryCategoryKeyArr);
                            $salaryCategoryValStr= implode(',', $salaryCategoryValArr);

                            $str = 'y(' . strtolower($salaryCategoryKeyStr) . ') = ' . strtolower($string);
                            $payrollCal->evaluate($str);
                            $calculatedValue = $payrollCal->e("y($salaryCategoryValStr)");

                            $allEarningDeduction[$key]['value']=$calculatedValue;
                            $tempSalaryCategoryalue=$allEarningDeduction[$key]['value'];
                            $salaryCategory[$value['code']]=$tempSalaryCategoryalue;
                        }
                            else if($value['value_type_id'] == 2){
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
                        
                            $allEarningDeduction[$key]['value']=$conditionAmount;
                            $tempSalaryCategoryalue=$allEarningDeduction[$key]['value'];
                            $salaryCategory[$value['code']]=$tempSalaryCategoryalue;
                        }
                    else{
                    ///fix
                        $tempSalaryCategoryalue=$value['value_formula'];
                        $salaryCategory[$value['code']]=$tempSalaryCategoryalue;
                        $allEarningDeduction[$key]['value'] = $tempSalaryCategoryalue;
                    }

                    if($value['type']==0){

                    }else{

                    } 
                    }
            }

            foreach ($allEarningDeduction AS $k=>$v){ 
                $checkExist = $payrollPayslipDetailsModel->get_data_by_category_id($v['payroll_category_id'],$payslip_id);

                if(count($checkExist) == 0) {
                    if($v['type']==0) {
                        $totalSal+=$v['value'];
                    } else {
                        $totalSal-=$v['value'];
                    }
                    if($v['payroll_category_id']!="" && $v['value']!="" && $payslip_id!=""){
                        $payrollPayslipCateggoryDataArray=array('payroll_category_id'=>$v['payroll_category_id'],'formula'=>$v['value_formula'],'value'=>$v['value'],'payroll_payslip_id'=>$payslip_id);
                        $payrollPayslipDetailsModel->add($payrollPayslipCateggoryDataArray);
                    }
                } else {
                    $payrollCateData = $payrollcategoryModel->get_category_data($checkExist[0]['payroll_category_id']);
                    if($payrollCateData[0]['type']==0) {
                        $totalSal-=$checkExist[0]['value'];
                        $totalSal+=$v['value'];
                    } else {
                        $totalSal+=$checkExist[0]['value'];
                        $totalSal-=$v['value'];
                    }
                    $payrollPayslipCateggoryDataArray=array('formula'=>$v['value_formula'],'value'=>$v['value']);
                    $payrollPayslipDetailsModel->editpayslipdata($payrollPayslipCateggoryDataArray,$checkExist[0]['id']);
                }
            }
            }

        $paySlipDataArr = array("net_pay"=>$totalSal);
        $payrollPayslipData=$payrollPayslip->update($paySlipDataArr,$payslip_id);
        if($totalSal>0){
        }else{
            $payrollPayslip->delete($payslip_id);
        }

        }

        $this->view->salarydetails=$data[0];
        $this->view->earningColArr=$earningColArr;
        $this->view->deductColArr=$deductColArr;
        $this->view->netPayDetails=$netPayDetails;
        $this->view->netPay = @$netPay;
        $this->view->empdata = $empdata;
   }
}