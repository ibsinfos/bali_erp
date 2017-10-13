<?php

/* * ******************************************************************************* 
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
 * ****************************************************************************** */

class Default_EmppayslipsController extends Zend_Controller_Action {

    private $options;

    public function preDispatch() {
        
    }

    public function init() {
        $this->_options = $this->getInvokeArg('bootstrap')->getOptions();
    }

    public function indexAction() {
        
    }

    public function editAction() {
        if (defined('EMPTABCONFIGS')) {
            $empOrganizationTabs = explode(",", EMPTABCONFIGS);

            if (in_array('emp_payslips', $empOrganizationTabs)) {
                $auth = Zend_Auth::getInstance();
                if ($auth->hasIdentity()) {
                    $loginUserId = $auth->getStorage()->read()->id;
                }
                $userid = $this->getRequest()->getParam('userid');
                $employeeModal = new Default_Model_Employee();
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

                    if ($this->getRequest()->getPost()) {
                        
                    }
                }
                $this->view->empdata = $empdata;
            } else {
                $this->_redirect('error');
            }
        } else {
            $this->_redirect('error');
        }
    }

    public function viewAction() {
        if (defined('EMPTABCONFIGS')) {
            $empOrganizationTabs = explode(",", EMPTABCONFIGS);

            if (in_array('emp_payslips', $empOrganizationTabs)) {
                $auth = Zend_Auth::getInstance();
                if ($auth->hasIdentity()) {
                    $loginUserId = $auth->getStorage()->read()->id;
                }
                $userid = $this->getRequest()->getParam('userid');
                $payslip_id = $this->getRequest()->getParam('payslipid');
                $this->view->payslip_id = $payslip_id;
                $employeeModal = new Default_Model_Employee();
                $empsalarydetailsModal = new Default_Model_Empsalarydetails();
                $payrollPayslipDetailsModal = new Default_Model_Payrollpayslipdetails();
                $salarySlipDetails=$payrollPayslipDetailsModal->get_details_by_employee_id($userid);
                $netPayDetails=$payrollPayslipDetailsModal->get_current_net_pay($userid);
                $payrollCal = new sapp_Payrollcal();
                //sapp_Payrollcal::pre($salarySlipDetails);die;
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

                // {$payrollcategoryModel = new Default_Model_Payrollcategory();
                /*$payrollCal = new sapp_Payrollcal();
                //$payrollCal->suppress_errors = true;
                $categories = $payrollcategoryModel->payroll_get_all_category();
                $allcategory = '';
                $catNoStr = "";
                $categoryvaluearray = array();
                foreach ($categories as $category) {
                    $allcategory .= $category['code'] . ",";
                    $catNoStr .= "2,";
                }


                $earnings = $payrollcategoryModel->get_earings_of_employee($userid);
                $deductions = $payrollcategoryModel->get_deductions_of_employee($userid);
                //echo '<pre>';print_r($data);die;
                // die("kk");
                //echo '<pre>';
                $allcategory = substr($allcategory, 0, -1);
                $catNoStr = substr($catNoStr, 0, -3);
                $toDeduct = 0;
                foreach ($deductions as $key => $value) {

                    if ($value['value_type_id'] == 1) {
                        $formula = $value['value_formula'];
                        $string = str_replace("%", "/100", $formula);
                        //die($allcategory);
                        $str = 'y(' . strtolower($allcategory) . ') = ' . $string;
                        //echo $str;
                        $payrollCal->evaluate($str);
                        //echo  $payrollCal->last_error;
                        //echo $payrollCal->e("y(".$bas.",2,2,2,2)");
                        $deductions[$key]['value'] = $payrollCal->e("y(" . $bas . ",$catNoStr)");
                        //echo $deductions[$key]['value'];die;
                        $toDeduct+=$deductions[$key]['value'];
                    }
                }
                //echo '<pre>';print_r($catNoStr);die;
                $totEearn = 0;
                foreach ($earnings as $key => $value) {
                    if (strtolower($value['name']) == "basic salary") {
                        $earnings[$key]['value'] = $bas;

                        $totEearn+=$earnings[$key]['value'];

                        continue;
                    }
                    if ($value['value_type_id'] == 1) {
                        $formula = $value['value_formula'];
                        $string = str_replace("%", "/100", $formula);
                        //die($allcategory);
                        $str = 'y(' . strtolower($allcategory) . ') = ' . $string;
                        //echo $str;
                        $payrollCal->evaluate($str);
                        //echo  $payrollCal->last_error;
                        //echo $payrollCal->e("y(".$bas.",2,2,2)");
                        $earnings[$key]['value'] = $payrollCal->e("y(" . $bas . ",$catNoStr)");
                    } else {
                        $earnings[$key]['value'] = $value['value_formula'];
                        $categoryvaluearray[$value['code']] = $value['value_formula'];
                    }
                    $totEearn+=$earnings[$key]['value'];
                }

                //die('ern '.$totEearn.' ==== totl dedu '.$toDeduct);
                $netPay = $totEearn - $toDeduct;
                //echo $netPay;die;

                $this->view->earnings = $earnings;
                $this->view->deductions = $deductions;
                
                $this->view->salarydetails= $data[0];}*/
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
                        //echo '<pre>'; print_r($employeeLeavesData); die;
                    }
                    
                    // Calculation for payroll category
                    //$payslipid;
                    
                    $empsalarydetailsModal = new Default_Model_Empsalarydetails();
                    $payrollPayslip = new Default_Model_Payrollpayslip();
                    $payrollcategoryModel = new Default_Model_Payrollcategory();
                    $payrollGroup = new Default_Model_Payrollgroup();
                    $payrollPayslipDetailsModel = new Default_Model_Payrollpayslipdetails();
                    $data1 = $empsalarydetailsModal->getsingleEmpSalaryDetailsData($userid);
                    
                    $empPayslipData = $payrollPayslip->get_data($payslip_id);
                    $this->view->empPayslipData=$empPayslipData;
            //echo '<pre>'; print_r($empPayslipData);
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
                            
                            //echo $totalSal;echo '<pre>';print_r($value); echo $tempSalaryCategoryalue;
                            if($value['type']==0){
//                                $tempArr=array();
//                                $tempArr['name']=$value['name'];
//                                $tempArr['value']=$tempSalaryCategoryalue;
//                                $earningColArr[]=$tempArr;
                               // $totalSal+=$tempSalaryCategoryalue;
                            }else{
//                                $tempArr=array();
//                                $tempArr['name']=$value['name'];
//                                $tempArr['value']=$tempSalaryCategoryalue;
//                                $deductColArr[]=$tempArr;
                                //$totalSal-=$tempSalaryCategoryalue;
                            } 
                            }
                    }

                    foreach ($allEarningDeduction AS $k=>$v){
                    $checkExist = $payrollPayslipDetailsModel->get_data_by_category_id($v['payroll_category_id'],$payslip_id);
                    //print_r($checkExist);
                    if(count($checkExist) == 0) {
                        if($v['type']==0) {
                            $totalSal+=$v['value'];
                        } else {
                            $totalSal-=$v['value'];
                        }
                        if($v['payroll_category_id']!="" && $v['value_formula']!="" && $v['value']!="" && $payslip_id!=""){
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
                //echo $totalSal; die;
//echo $totalSal;
                //$payrollPayslip->edit(array("net_pay"=>$totalSal),$payslip_id,'id');
                $paySlipDataArr = array("net_pay"=>$totalSal);
                $payrollPayslip=$payrollPayslip->update($paySlipDataArr,$payslip_id);
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
            } else {
                $this->_redirect('error');
            }
        } else {
            $this->_redirect('error');
        }
    }

    public function printslipAction() {
        
     //  $this->_helper->layout()->disableLayout();
      // $this->_helper->layout->disableLayout();
       $userid = $this->getRequest()->getParam('userid');
                $employeeModal = new Default_Model_Employee();
                $empsalarydetailsModal = new Default_Model_Empsalarydetails();
                /*$data = $empsalarydetailsModal->getsingleEmpSalaryDetailsData($userid);
                if (!empty($data)) {
                    $bas = sapp_Global:: _decrypt($data[0]['salary']);
                }
                $payrollcategoryModel = new Default_Model_Payrollcategory();
                $payrollCal = new sapp_Payrollcal();
                //$payrollCal->suppress_errors = true;
                $categories = $payrollcategoryModel->payroll_get_all_category();
                $allcategory = '';
                $catNoStr = "";
                $categoryvaluearray = array();
                foreach ($categories as $category) {
                    $allcategory .= $category['code'] . ",";
                    $catNoStr .= "2,";
                }


                $earnings = $payrollcategoryModel->get_earings_of_employee($userid);
                $deductions = $payrollcategoryModel->get_deductions_of_employee($userid);
                //echo '<pre>';print_r($deductions);die;
                // die("kk");
                //echo '<pre>';
                $allcategory = substr($allcategory, 0, -1);
                $catNoStr = substr($catNoStr, 0, -3);
                $toDeduct = 0;
                foreach ($deductions as $key => $value) {

                    if ($value['value_type_id'] == 1) {
                        $formula = $value['value_formula'];
                        $string = str_replace("%", "/100", $formula);
                        //die($allcategory);
                        $str = 'y(' . strtolower($allcategory) . ') = ' . $string;
                        //echo $str;
                        $payrollCal->evaluate($str);
                        //echo  $payrollCal->last_error;
                        //echo $payrollCal->e("y(".$bas.",2,2,2,2)");
                        $deductions[$key]['value'] = $payrollCal->e("y(" . $bas . ",$catNoStr)");
                        //echo $deductions[$key]['value'];die;
                        $toDeduct+=$deductions[$key]['value'];
                    }
                }
                //echo '<pre>';print_r($catNoStr);die;
                $totEearn = 0;
                foreach ($earnings as $key => $value) {
                    if (strtolower($value['name']) == "basic salary") {
                        $earnings[$key]['value'] = $bas;

                        $totEearn+=$earnings[$key]['value'];

                        continue;
                    }
                    if ($value['value_type_id'] == 1) {
                        $formula = $value['value_formula'];
                        $string = str_replace("%", "/100", $formula);
                        //die($allcategory);
                        $str = 'y(' . strtolower($allcategory) . ') = ' . $string;
                        //echo $str;
                        $payrollCal->evaluate($str);
                        //echo  $payrollCal->last_error;
                        //echo $payrollCal->e("y(".$bas.",2,2,2)");
                        $earnings[$key]['value'] = $payrollCal->e("y(" . $bas . ",$catNoStr)");
                    } else {
                        $earnings[$key]['value'] = $value['value_formula'];
                        $categoryvaluearray[$value['code']] = $value['value_formula'];
                    }
                    $totEearn+=$earnings[$key]['value'];
                }

                //die('ern '.$totEearn.' ==== totl dedu '.$toDeduct);
                $netPay = $totEearn - $toDeduct; 
                */
		
		$cols_param_arr = array('name' => 'Name','code' => 'Code','value_formula'=>'Formula','value'=>'Value');

		$field_names = array();
		$field_widths = array();
		$data['field_name_align'] = array();
                
		foreach($cols_param_arr as $column_key => $column_name)
		{
			$field_names[] = array(
                                        'field_name'=>$column_key,
                                        'field_label'=>$column_name
			);
			$field_widths[] = 25;
			$data['field_name_align'][] = 'C';
		}

		$data = array('grid_no'=>1, 'project_name'=>'', 'object_name'=>'Payslip June 2016', 'grid_count'=>1,'file_name'=>'Payslip.pdf');

		$pdf = $this->_helper->PdfHelper->generateReport($field_names, $earnings, $field_widths, $data);
		$this->_helper->json(array('file_name'=>$data['file_name']));
    }
    
    function salarydetailsAction()
    {
        		$this->_helper->layout->disableLayout();

		 	$objName = 'empsalarydetails';
		 	$empsalarydetailsform = new Default_Form_empsalarydetails();
		 	$empsalarydetailsform->removeElement("submit");
		 	$elements = $empsalarydetailsform->getElements();
		 	if(count($elements)>0)
		 	{
		 		foreach($elements as $key=>$element)
		 		{
		 			if(($key!="Cancel")&&($key!="Edit")&&($key!="Delete")&&($key!="Attachments")){
		 				$element->setAttrib("disabled", "disabled");
		 			}
		 		}
		 	}
		 	 
		 	try
		 	{
		 		if($id && is_numeric($id) && $id>0 && $id!=$loginUserId)
		 		{
		 			$employeeModal = new Default_Model_Employee();
					$usersModel = new Default_Model_Users();
		 			$empdata = $employeeModal->getActiveEmployeeData($id);
					$employeeData = $usersModel->getUserDetailsByIDandFlag($id);
		 			if($empdata == 'norows')
		 			{
		 				$this->view->rowexist = "norows";
		 				$this->view->empdata = "";
		 			}
		 			else
		 			{
		 				$this->view->rowexist = "rows";
		 				if(!empty($empdata))
		 				{
		 					$empsalarydetailsModal = new Default_Model_Empsalarydetails();
		 					$usersModel = new Default_Model_Users();
		 					$currencymodel = new Default_Model_Currency();
		 					$accountclasstypemodel = new Default_Model_Accountclasstype();
		 					$bankaccounttypemodel = new Default_Model_Bankaccounttype();
		 					$payfrequencyModal = new Default_Model_Payfrequency();
		 					$data = $empsalarydetailsModal->getsingleEmpSalaryDetailsData($id);
		 						
		 					if(!empty($data))
		 					{

		 						if(isset($data[0]['currencyid']) && $data[0]['currencyid'] !='')
		 						{
		 							$currencyArr = $currencymodel->getCurrencyDataByID($data[0]['currencyid']);
		 							if(sizeof($currencyArr)>0)
		 							{
		 								$empsalarydetailsform->currencyid->addMultiOption($currencyArr[0]['id'],$currencyArr[0]['currencyname'].' '.$currencyArr[0]['currencycode']);
		 								$data[0]['currencyid']= $currencyArr[0]['currencyname'];

		 							}
									else
									{
										$data[0]['currencyid']="";
									}
		 						}

		 						if(isset($data[0]['accountclasstypeid']) && $data[0]['accountclasstypeid'] !='')
		 						{
		 							$accountclasstypeArr = $accountclasstypemodel->getsingleAccountClassTypeData($data[0]['accountclasstypeid']);
		 							if(sizeof($accountclasstypeArr)>0 && $accountclasstypeArr !='norows')
		 							{
		 								$empsalarydetailsform->accountclasstypeid->addMultiOption($accountclasstypeArr[0]['id'],$accountclasstypeArr[0]['accountclasstype']);
		 							    $data[0]['accountclasstypeid']=$accountclasstypeArr[0]['accountclasstype'];
		 							}
									else
									{
										 $data[0]['accountclasstypeid']="";
									}
		 						}

		 						if(isset($data[0]['bankaccountid']) && $data[0]['bankaccountid'] !='')
		 						{
		 							$bankaccounttypeArr = $bankaccounttypemodel->getsingleBankAccountData($data[0]['bankaccountid']);
		 							if($bankaccounttypeArr !='norows')
		 							{
		 								$empsalarydetailsform->bankaccountid->addMultiOption($bankaccounttypeArr[0]['id'],$bankaccounttypeArr[0]['bankaccounttype']);
		 							    $data[0]['bankaccountid']=$bankaccounttypeArr[0]['bankaccounttype'];
		 							}
									else
									{
										 $data[0]['bankaccountid']="";
									}
		 						}
		 						
		 						if(isset($data[0]['salarytype']) && $data[0]['salarytype'] !='')
		 						{
				 					$payfreqData = $payfrequencyModal->getActivePayFreqData($data[0]['salarytype']);
									if(sizeof($payfreqData) > 0)
									{
										foreach ($payfreqData as $payfreqres){
											$empsalarydetailsform->salarytype->addMultiOption($payfreqres['id'],$payfreqres['freqtype']);
										}
									}
		 						}

		 						$empsalarydetailsform->populate($data[0]);

		 						if($data[0]['accountholding'] !='')
		 						{
		 							$accountholding = sapp_Global::change_date($data[0]["accountholding"], 'view');
		 							$empsalarydetailsform->accountholding->setValue($accountholding);
		 						}
			 					 if(!empty($data[0]['salarytype']))
								 {
							           $salarytype = $payfrequencyModal->getsinglePayfrequencyData($data[0]['salarytype']);
							            if(!empty($salarytype) && $salarytype !='norows')
							            {
								          $data[0]['salarytype'] = $salarytype[0]['freqtype'];
							            }
						         }
						         if(!empty($data[0]['salary'])){
									 if($data[0]['salary'] !='')
									{
									  $data[0]['salary']=sapp_Global:: _decrypt( $data[0]['salary']);
									}
									else
									{
										$data[0]['salary']="";
									}
						        }

		 					}
		 				    
		 					//$this->view->controllername = $objName;
		 					//$this->view->data = $data;
		 					//$this->view->id = $id;
		 					//$this->view->form = $empsalarydetailsform;
		 					//$this->view->employeedata = $employeeData[0];

		 				}
		 				//$this->view->empdata = $empdata;
                                                return $data;
		 			}
		 		}
		 		else
		 		{
		 			$this->view->rowexist = "norows";
		 		}
		 	}
		 	catch(Exception $e)
		 	{
		 		$this->view->rowexist = "norows";
		 	}
    }
}

?>
