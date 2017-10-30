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

class Default_GeneratewpsreportController extends Zend_Controller_Action
{ 

	private $options;
	public function preDispatch()
	{

	}

	public function init()
	{
		$employeeModel = new Default_Model_Employee();
		$this->_options= $this->getInvokeArg('bootstrap')->getOptions();
	}
	
        public function indexAction()
	{
            $employeemodel = new Default_Model_Employee();
            $call = $this->_getParam('call');
            if($call == 'ajaxcall')
            $this->_helper->layout->disableLayout();

            $view = Zend_Layout::getMvcInstance()->getView();
            $type = $this->_getParam('type');
            $objname = $this->_getParam('objname');
            $refresh = $this->_getParam('refresh');
            $dashboardcall = $this->_getParam('dashboardcall',null);
            $data = array();		$searchQuery = '';		
            $searchArray = array(); $tablecontent='';

            if($refresh == 'refresh')
            {
                if($dashboardcall == 'Yes')
                $perPage = DASHBOARD_PERPAGE;
                else
                $perPage = PERPAGE;

                $sort = 'DESC';$by = 'e.id';$pageNo = 1;$searchData = '';$searchQuery = '';
                $searchArray = array();
            }
            else
            {
                $sort = ($this->_getParam('sort') !='')? $this->_getParam('sort'):'DESC';
                $by = ($this->_getParam('by')!='')? $this->_getParam('by'):'e.id';
                if($dashboardcall == 'Yes')
                $perPage = $this->_getParam('per_page',DASHBOARD_PERPAGE);
                else
                $perPage = $this->_getParam('per_page',PERPAGE);

                $pageNo = $this->_getParam('page', 1);
                $searchData = $this->_getParam('searchData');
                $searchData = rtrim($searchData,',');
            }
            
            $employment_status_model = new Default_Model_Employmentstatus();
            $employmentStatusData = $employment_status_model->getempstatusActivelist();
            
            if($type!=''){
                $dataTmp = $employeemodel->getGridForWPS($sort,$by,$perPage,$pageNo,$searchData,$call,$dashboardcall,$type);
            } else { 
                $dataTmp = $employeemodel->getGridForWPS($sort,$by,$perPage,$pageNo,$searchData,$call,$dashboardcall);
            }

            array_push($data,$dataTmp);
            $this->view->employmentstatusdata = $employmentStatusData;
            $this->view->type = $type;
            $this->view->dataArray = $data;
            $this->view->call = $call ;
            $this->view->messages = $this->_helper->flashMessenger->getMessages();
	}
        
        public function generatebulkreportoldAction(){
            $id = $this->_request->getParam('selected_emp_ids');
            $idArr = explode(",", $id);
            $idStr = implode("','",$idArr); 
            
            $err_msg_arr=array();
            $error=FALSE;
            $baseUrl = new Zend_View_Helper_BaseUrl();
            
            //$this->_helper->getHelper("FlashMessenger")->addMessage(array("success"=>"WPS report has been generated successfully."));
            
            $this->_helper->viewRenderer->setNoRender(true);
            $this->_helper->layout()->disableLayout();
            $payrollPayslip = new Default_Model_Payrollpayslip();
            $payrollcategoryModel = new Default_Model_Payrollcategory();
            $payrollGroup = new Default_Model_Payrollgroup();
            $payrollPayslipDetailsModel = new Default_Model_Payrollpayslipdetails();
            $alllEmployee = $payrollPayslip->get_all_employee_by_id($idStr);
            
            $payrollCal = new sapp_Payrollcal();
            $empsalarydetailsModal = new Default_Model_Empsalarydetails();

//            error_reporting(E_ALL|E_STRICT);
//            ini_set('display_errors', 'on');
            /// getting payslip generatting date;
echo '<pre>'; print_r($alllEmployee);//die;
            $payfrequency= new Default_Model_Payfrequency();
            $date=$payfrequency->gegPayslipGenerateDay();
            
            if(date('j')!=$date){
                return FALSE;
            }
            //echo 'dsd'; die;
            foreach ($alllEmployee As $key => $val) {
                if ($val['emprole'] != 10) {
                    //continue;
                }
                //echo $val['emprole']; die;
                $data = $empsalarydetailsModal->getsingleEmpSalaryDetailsData($val['user_id']);
//print_r($data); die;
                if(!empty($data)){
                 $bas=sapp_Global:: _decrypt( $data[0]['salary']);
                }else{
                    continue;
                }
                echo $bas; //die;
                $salaryCategory=array();
                $salaryCategory['BAS']=$bas;
                $paySlipDataArr = array('emp_id' => $val['user_id']);
                echo $payslip_id=$payrollPayslip->add($paySlipDataArr); //die;
                $allEarningDeduction=$payrollcategoryModel->get_all_earning_deduction($val['user_id']);
                print_r($allEarningDeduction); //die;
                $totalSal=0;
                foreach ($allEarningDeduction AS $key=>$value){
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
                            $salaryCategoryValArr= array_values ($salaryCategory);//print_r($salaryCategoryValArr); die;
                            echo $salaryCategoryKeyStr= implode(',', $salaryCategoryKeyArr);//die;
                            $salaryCategoryValStr= implode(',', $salaryCategoryValArr);
echo $salaryCategoryValStr; //die;

                            echo $str = 'y(' . strtolower($salaryCategoryKeyStr) . ') = ' . strtolower($string); //die;
                            $payrollCal->evaluate($str);
                           echo $calculatedValue = $payrollCal->e("y($salaryCategoryValStr)");//die;

                            $allEarningDeduction[$key]['value']=$calculatedValue;
                            $tempSalaryCategoryalue=$allEarningDeduction[$key]['value'];
                            $salaryCategory[$value['code']]=$tempSalaryCategoryalue;
                        }else if($value['value_type_id'] == 2){ 
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

                            sapp_Payrollcal::pre('$conditionAmount : '.$conditionAmount);
                            $allEarningDeduction[$key]['value']=$conditionAmount;
                            $tempSalaryCategoryalue=$allEarningDeduction[$key]['value'];
                            $salaryCategory[$value['code']]=$tempSalaryCategoryalue;
                        }else{ 
                            ///fix
                            $tempSalaryCategoryalue=$value['value_formula'];
                            $salaryCategory[$value['code']]=$tempSalaryCategoryalue;
                            $allEarningDeduction[$key]['value'] = $tempSalaryCategoryalue;
                        }
                        if($value['type']==0){
                            $totalSal+=$tempSalaryCategoryalue;
                        }else{
                            $totalSal-=$tempSalaryCategoryalue;
                        } //$this->pre("come at 741");
                    }
                }

                foreach ($allEarningDeduction AS $k=>$v){
                    if($v['payroll_category_id']!="" && $v['value_formula']!="" && $v['value']!="" && $payslip_id!=""){
                        $payrollPayslipCateggoryDataArray=array('payroll_category_id'=>$v['payroll_category_id'],'formula'=>$v['value_formula'],'value'=>$v['value'],'payroll_payslip_id'=>$payslip_id);
                        $payrollPayslipDetailsModel->add($payrollPayslipCateggoryDataArray);
                    }
                }
                echo $totalSal; 
                $payrollPayslip->edit(array("net_pay"=>$totalSal),$payslip_id,'id');
                if($totalSal>0){
                    $payrollPayslip->generate($payslip_id);
                }else{
                    $payrollPayslip->delete($payslip_id);
                }
        }//die;
            $this->_helper->getHelper("FlashMessenger")->addMessage(array("success"=>"WPS report has been generated successfully."));
            $this->_redirect('generatewpsreport');
            
//            if($id!=""){
//                $empModel=new Default_Model_Employee();
//                $isExist=$empModel->employeeCheckExistByMainUserId($id);
//                if($isExist[0]['Tot']>0){
//                    
//                }else{
//                    $this->_helper->flashMessenger('Selected employee not exist for WPS generation,Please contact with system administration.');
//                }
//            }else{
//                $this->_helper->flashMessenger('Invalid employe selected, pleasee try again.');
//            }
            //$this->getResponse()->setRedirect($baseUrl->baseUrl().'/index.php/payslipemployee');
        }
        
        public function generateAction(){
            $id = $this->_request->getParam('id');
            $err_msg_arr=array();
            $error=FALSE;
            $baseUrl = new Zend_View_Helper_BaseUrl();
            
            $this->_helper->getHelper("FlashMessenger")->addMessage(array("success"=>"WPS report has been generated successfully."));
            $this->_redirect('generatewpsreport');
        }
        
        public function generatebulkreportAction(){
//            echo '<pre>';
//            print_r($_POST); //die;
            $id = $this->_request->getParam('selected_emp_ids');
            $year = $this->_request->getParam('year');
            $month = $this->_request->getParam('month');
            $idArr = explode(",", $id);
            $idStr = implode("','",$idArr); 
            
            $err_msg_arr=array();
            $error=FALSE;
            $baseUrl = new Zend_View_Helper_BaseUrl();
            
            $this->_helper->viewRenderer->setNoRender(true);
            $this->_helper->layout()->disableLayout();
            $paymentprotectionmodel = new Default_Model_Paymentprotection();    // WPS Model
            $payrollPayslip = new Default_Model_Payrollpayslip();
            $payrollcategoryModel = new Default_Model_Payrollcategory();
            $payrollGroup = new Default_Model_Payrollgroup();
            $payrollPayslipDetailsModel = new Default_Model_Payrollpayslipdetails();
            $alllEmployee = $payrollPayslip->get_all_employee_by_id($idStr);
           // print_r($alllEmployee); die;
            $payrollCal = new sapp_Payrollcal();
            $empsalarydetailsModal = new Default_Model_Empsalarydetails();
            
            if($month=='' && $year==''){
                $this->_helper->getHelper("FlashMessenger")->addMessage(array("error"=>"Please select year and month for which you want to generate WPS report."));
                $this->_redirect('generatewpsreport');
            }

//            error_reporting(E_ALL|E_STRICT);
//            ini_set('display_errors', 'on');

//            $payfrequency= new Default_Model_Payfrequency();
//            $date=$payfrequency->gegPayslipGenerateDay();
//
//            if(date('j')<$date){
//                $this->_helper->getHelper("FlashMessenger")->addMessage(array("error"=>"WPS report can not be generated prior to payslip generation date."));
//                $this->_redirect('generatewpsreport');
//            }
            $emptyFlag = 0; $generatedFlag = 0;
            
            foreach ($alllEmployee As $key => $val) {
               $empPayslipData = $payrollPayslip->isPayslipGneratedForEmployee($val['user_id'],$month,$year);
               if(count($empPayslipData) > 0){
                   $payment_protection_data['payslip_id'] = $empPayslipData[0]['id'];
                   $payment_protection_data['emp_id'] = $val['user_id'];
                   $payment_protection_data['mode_of_salary_transfer'] = $_POST['mode_of_salary_transfer_'.$val['user_id']];
                   $payment_protection_data['reference_no'] = $_POST['reference_no_'.$val['user_id']];
                   $payment_protection_data['wps_year'] = $year;
                   $payment_protection_data['wps_month'] = $month;
                   
                   $result = $paymentprotectionmodel->add($payment_protection_data);
                   if($result == 0){
                       $generatedFlag++;
                   }
               } else {
                   $emptyFlag++;
               }
            }
            
            if(count($alllEmployee) == $generatedFlag) {
                $this->_helper->getHelper("FlashMessenger")->addMessage(array("error"=>"WPS report has already been generated for all the selected employees."));
            } elseif($emptyFlag > 0) {
                $this->_helper->getHelper("FlashMessenger")->addMessage(array("error"=>"WPS report can not be generated for some employees because payslip is not yet generated for those employees."));
            } else {
                $this->_helper->getHelper("FlashMessenger")->addMessage(array("success"=>"WPS report has been generated successfully."));
            }
            $this->_redirect('generatewpsreport');
        }
}