<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Default_PayslipreportController extends Zend_Controller_Action {

    public function init() {
        $flash_messages = $this->_helper->flashMessenger->getMessages();
        if (!empty($flash_messages))
            $this->_helper->layout->getView()->flash_messages = $flash_messages[0];
        
        //$contextSwitch= $this->_helper->getHelper('contextSwitch');
        //$contextSwitch->addActionContext('filter')->initContext();
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
        $emp_payslip = new Default_Model_Payrollpayslip();
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
        }
        $rollModel=new Default_Model_Payrollgroup();
        $roles_details=$rollModel->get_all_main_roles();
        $all_employees=$emp_payslip->get_all_employee_generated_payslip();
        //sapp_Payrollcal::pre($all_employees);die;
        $this->view->roles=$roles_details;
        $this->view->all_employees=$all_employees;
    }

    public function filterAction(){
        //error_reporting(E_ALL);
        //ini_set("display_errors", 1);
        $this->_helper->layout()->disableLayout();
        //$this->_helper->viewRenderer->setNoRender();
        $content="judhisthira";
        $month=  $this->_getParam('month', date('m'));
        $roll_id=  $this->_getParam('roll', "");
        $emp_name=  $this->_getParam('emp_name', "");
        
        $empsalarydetailsModal = new Default_Model_Empsalarydetails();
        $empLeavesModel = new Default_Model_Employeeleaves();
                
        $filterData = array();
        $payslipDetails=new Default_Model_Payrollpayslip();
        $filterData=$payslipDetails->get_data_with_filter($month,$roll_id,$emp_name);
        
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
}
