<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Default_PayslipemployeeController extends Zend_Controller_Action{
    public function init(){
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
                    $rsPayslipDetails=$payrollPayslipModel->getEmployeCronPaylip($id);
                    if(empty($rsPayslipDetails)){
                        $this->_helper->flashMessenger('Paysllip should allow after payroll generation date.');
                    }else{
                        $payrollPayslipModel->generate($rsPayslipDetails[0]['id']);
                        $this->_helper->flashMessenger('Payslip generated successfully.');
                    }
                }else{
                    $this->_helper->flashMessenger('Payslip already generated.');
                }
            }else{
                $this->_helper->flashMessenger('Selected employee not exist gor payslip generation,Please contact with system administration.');
            }
        }else{
            $this->_helper->flashMessenger('Invalid employe selected, pleasee try again.');
        }
        $this->getResponse()->setRedirect($baseUrl->baseUrl().'/index.php/payslipemployee');
    }
    
    public function generatebulkAction(){
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
                        $this->_helper->flashMessenger('Unlnown errorr for payslip generation.');
                    }
                }
            }
        }
        $this->getResponse()->setRedirect($baseUrl->baseUrl().'/index.php/payslipemployee');
    }
    
}

