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

    public function filterAction() {
        $arr = array('0' => 'A', '1' => 'B');
        $this->view->arr = $arr;
    }

}
