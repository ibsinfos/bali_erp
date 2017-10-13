<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Default_PayrollgroupController extends Zend_Controller_Action{
    
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
    
    public function indexAction()
    {
        $auth = Zend_Auth::getInstance();
        $popConfigPermission = array();
        if($auth->hasIdentity()){
                $loginUserId = $auth->getStorage()->read()->id;
                $loginuserRole = $auth->getStorage()->read()->emprole;
                $loginuserGroup = $auth->getStorage()->read()->group_id;
        }
        $employeeModel = new Default_Model_Employee();
        $payrollgroupModel = new Default_Model_Payrollgroup();
        $currentOrgHead = $employeeModel->getCurrentOrgHead();
        if(!empty($currentOrgHead))
        {
            $call = $this->_getParam('call');
            if($call == 'ajaxcall')
            $this->_helper->layout->disableLayout();

            if(sapp_Global::_checkprivileges(PREFIX,$loginuserGroup,$loginuserRole,'add') == 'Yes'){
                    array_push($popConfigPermission,'prefix');
            }
            if(sapp_Global::_checkprivileges(IDENTITYCODES,$loginuserGroup,$loginuserRole,'edit') == 'Yes'){
                    array_push($popConfigPermission,'identitycodes');
            }
            if(sapp_Global::_checkprivileges(EMPLOYMENTSTATUS,$loginuserGroup,$loginuserRole,'add') == 'Yes'){
                    array_push($popConfigPermission,'empstatus');
            }
            if(sapp_Global::_checkprivileges(JOBTITLES,$loginuserGroup,$loginuserRole,'add') == 'Yes'){
                    array_push($popConfigPermission,'jobtitles');
            }
            if(sapp_Global::_checkprivileges(POSITIONS,$loginuserGroup,$loginuserRole,'add') == 'Yes'){
                    array_push($popConfigPermission,'position');
            }
            $this->view->popConfigPermission = $popConfigPermission;
            $view = Zend_Layout::getMvcInstance()->getView();
            $objname = $this->_getParam('objname');
            $refresh = $this->_getParam('refresh');
            $dashboardcall = $this->_getParam('dashboardcall',null);
            $data = array();$id='';
            $searchQuery = '';
            $searchArray = array();
            $tablecontent = '';
            if($refresh == 'refresh')
            {
                    if($dashboardcall == 'Yes')
                    $perPage = DASHBOARD_PERPAGE;
                    else
                    $perPage = PERPAGE;

                    $sort = 'ASC';$by = 'mr.id';$pageNo = 1;$searchData = '';
                    $searchQuery = '';$searchArray='';
            }
            else
            {
                    $sort = ($this->_getParam('sort') !='')? $this->_getParam('sort'):'ASC';
                    $by = ($this->_getParam('by')!='')? $this->_getParam('by'):'mr.id';

                    if($dashboardcall == 'Yes')
                    $perPage = $this->_getParam('per_page',DASHBOARD_PERPAGE);
                    else
                    $perPage = $this->_getParam('per_page',PERPAGE);

                    $pageNo = $this->_getParam('page', 1);
                    $searchData = $this->_getParam('searchData');
                    $searchData = rtrim($searchData,',');

            }
            $dataTmp = $payrollgroupModel->getGrid($sort, $by, $perPage, $pageNo, $searchData,$call,$dashboardcall,$loginUserId);

            array_push($data,$dataTmp); 
            //sapp_Payrollcal::pre($data); die;
            $this->view->dataArray = $data;
            $this->view->call = $call;
        }
        else
        {
                //$this->addorganisationhead($loginUserId);

        }		
        $this->view->messages = $this->_helper->flashMessenger->getMessages(); //echo 'sdf'; die;
    }
    
    public function indexoldAction(){
        $auth = Zend_Auth::getInstance();
        $popConfigPermission = array();
        if($auth->hasIdentity()){
            $loginUserId = $auth->getStorage()->read()->id;
            $loginuserRole = $auth->getStorage()->read()->emprole;
            $loginuserGroup = $auth->getStorage()->read()->group_id;
        }
        
        $payrollgroupModel = new Default_Model_Payrollgroup();
        $employeeModel = new Default_Model_Employee();
        $currentOrgHead = $employeeModel->getCurrentOrgHead();
        if(empty($currentOrgHead)){
                $this->addorganisationhead($loginUserId);
        }else{
            if(sapp_Global::_checkprivileges(PREFIX,$loginuserGroup,$loginuserRole,'add') == 'Yes'){
                    array_push($popConfigPermission,'prefix');
            }
            if(sapp_Global::_checkprivileges(IDENTITYCODES,$loginuserGroup,$loginuserRole,'edit') == 'Yes'){
                    array_push($popConfigPermission,'identitycodes');
            }
            if(sapp_Global::_checkprivileges(EMPLOYMENTSTATUS,$loginuserGroup,$loginuserRole,'add') == 'Yes'){
                    array_push($popConfigPermission,'empstatus');
            }
            if(sapp_Global::_checkprivileges(JOBTITLES,$loginuserGroup,$loginuserRole,'add') == 'Yes'){
                    array_push($popConfigPermission,'jobtitles');
            }
            if(sapp_Global::_checkprivileges(POSITIONS,$loginuserGroup,$loginuserRole,'add') == 'Yes'){
                    array_push($popConfigPermission,'position');
            }
        }
        $this->view->popConfigPermission = $popConfigPermission;
        $allRollesData=$payrollgroupModel->get_all_main_roles();
        //echo '<pre>';print_r($alllGroupData);die;
        $this->view->allRollesData=$allRollesData;
    }
        
    public function addAction(){
        $emptyFlag=0;
        $report_opt = array();
        $popConfigPermission = array();
        $auth = Zend_Auth::getInstance();
        $candidateid= $this->_request->getParam('cid');
        if($auth->hasIdentity()){
            $loginUserId = $auth->getStorage()->read()->id;
            $loginuserRole = $auth->getStorage()->read()->emprole;
            $loginuserGroup = $auth->getStorage()->read()->group_id;
        }
        
        $payrollgroupModel = new Default_Model_Payrollgroup();
        $employeeModel = new Default_Model_Employee();
        $currentOrgHead = $employeeModel->getCurrentOrgHead();

        if(empty($currentOrgHead)){
                $this->addorganisationhead($loginUserId);
        }else{
            if(sapp_Global::_checkprivileges(PREFIX,$loginuserGroup,$loginuserRole,'add') == 'Yes'){
                    array_push($popConfigPermission,'prefix');
            }
            if(sapp_Global::_checkprivileges(IDENTITYCODES,$loginuserGroup,$loginuserRole,'edit') == 'Yes'){
                    array_push($popConfigPermission,'identitycodes');
            }
            if(sapp_Global::_checkprivileges(EMPLOYMENTSTATUS,$loginuserGroup,$loginuserRole,'add') == 'Yes'){
                    array_push($popConfigPermission,'empstatus');
            }
            if(sapp_Global::_checkprivileges(JOBTITLES,$loginuserGroup,$loginuserRole,'add') == 'Yes'){
                    array_push($popConfigPermission,'jobtitles');
            }
            if(sapp_Global::_checkprivileges(POSITIONS,$loginuserGroup,$loginuserRole,'add') == 'Yes'){
                    array_push($popConfigPermission,'position');
            }
        } 
        $this->view->popConfigPermission = $popConfigPermission;
        $this->view->groupcode=$payrollgroupModel->get_payroll_group_code();
        $err_msg_arr=array();
        $error=FALSE;
        $id = $this->_request->getParam('id');
        $rs_main_roll_details=$payrollgroupModel->get_main_roll_details($id);
        if($this->getRequest()->isPost()){
            $payroll_group_codes=trim($this->_request->getParam('add_payroll_group_code_hidden',null));
            if(array_key_exists('add_payroll_group_code_hidden', $_POST)){
                $payroll_group_codes=$_POST['add_payroll_group_code_hidden'];
            }else{
                $payroll_group_codes="";
            }
            
            $dataArr=array();
            if($payroll_group_codes=="" && !is_array($payroll_group_codes)){;
                $error=TRUE;
                $err_msg_arr['payroll_group_codes']="Please select any optiionn for 'Payroll Category Code'";
            }else{
                $dataArr['payroll_group_codes']=$payroll_group_codes;
            }
            
            if($error==FALSE){
                $trDb = Zend_Db_Table::getDefaultAdapter();
                $trDb->beginTransaction();
                try{
                    //echo '<pre>LL';print_r($dataArr); //die;
                    //echo '<pre>LL';print_r($id);die;
                    $baseUrl = new Zend_View_Helper_BaseUrl();
                    $retData=$payrollgroupModel->save_payroll_group($dataArr,$id);
                    if($retData==FALSE){
                        $this->_helper->flashMessenger($rs_main_roll_details[0]['rolename'].' already set with category.');
                    }else{
                        $this->_helper->flashMessenger('Payroll category and rolles created successfully.');
                    }
                    $trDb->commit();
                    $this->getResponse()->setRedirect($baseUrl->baseUrl().'/index.php/payrollgroup');

                   
                } catch (Exception $ex) {
                   
                    $trDb->rollBack();
                    $exception = $e->getMessage();
                    if(!empty($exception)){
                        $error=TRUE;
                        $error=TRUE;
                        $err_msg_arr['header_messsage']=$e->getMessage();
                    }else{
                        $error=TRUE;
                        $err_msg_arr['header_messsage']="Unknown error arises to save thepayroool group data,Please try again.";
                    }
                    $this->view->error=TRUE;
                }
            }else{
                //echo '<pre>';print_r($err_msg_arr);die;
                $this->view->error=TRUE;
            }
        }else{
            $this->view->rs_main_roll_details=$rs_main_roll_details;
            $this->view->main_roll_id=$id;
        }
        $this->view->error=$error;
        $this->view->err_msg_arr=$err_msg_arr;
    }
    
    public function editAction($id){
        $emptyFlag=0;
        $report_opt = array();
        $popConfigPermission = array();
        $auth = Zend_Auth::getInstance();
        $candidateid= $this->_request->getParam('cid');
        if($auth->hasIdentity()){
                $loginUserId = $auth->getStorage()->read()->id;
                $loginuserRole = $auth->getStorage()->read()->emprole;
                $loginuserGroup = $auth->getStorage()->read()->group_id;
        }
        
        $employeeModel = new Default_Model_Employee();
        $currentOrgHead = $employeeModel->getCurrentOrgHead();

        if(empty($currentOrgHead)){
                $this->addorganisationhead($loginUserId);
        }else{
            if(sapp_Global::_checkprivileges(PREFIX,$loginuserGroup,$loginuserRole,'add') == 'Yes'){
                    array_push($popConfigPermission,'prefix');
            }
            if(sapp_Global::_checkprivileges(IDENTITYCODES,$loginuserGroup,$loginuserRole,'edit') == 'Yes'){
                    array_push($popConfigPermission,'identitycodes');
            }
            if(sapp_Global::_checkprivileges(EMPLOYMENTSTATUS,$loginuserGroup,$loginuserRole,'add') == 'Yes'){
                    array_push($popConfigPermission,'empstatus');
            }
            if(sapp_Global::_checkprivileges(JOBTITLES,$loginuserGroup,$loginuserRole,'add') == 'Yes'){
                    array_push($popConfigPermission,'jobtitles');
            }
            if(sapp_Global::_checkprivileges(POSITIONS,$loginuserGroup,$loginuserRole,'add') == 'Yes'){
                    array_push($popConfigPermission,'position');
            }
        }
        $payrollgroupModel = new Default_Model_Payrollgroup();
        $this->view->popConfigPermission = $popConfigPermission;
        //error_reporting(E_ALL|E_STRICT);
        //ini_set('display_errors', 'on');
        $err_msg_arr=array();
        $error=FALSE;
        $this->view->groupcode=$payrollgroupModel->get_payroll_group_code();
        $id = $this->_request->getParam('id');
        //die('==='.$id);
        if($this->getRequest()->isPost()){
            if(array_key_exists('add_payroll_group_code_hidden', $_POST)){
                $payroll_group_codes=$_POST['add_payroll_group_code_hidden'];
            }else{
                $payroll_group_codes="";
            }
            //$group_code=trim($this->_request->getParam('group_code',null));
            $dataArr=array();
            if($payroll_group_codes=="" && !is_array($payroll_group_codes)){;
                $error=TRUE;
                $err_msg_arr['payroll_group_codes']="Please select any option for 'Payroll Category Code'";
            }else{
                $dataArr['payroll_group_codes']=$payroll_group_codes;
            }
            
            if($error==FALSE){
                $trDb = Zend_Db_Table::getDefaultAdapter();
                $trDb->beginTransaction();
                try{
                    //echo '<pre>LL';print_r($dataArr);die;
                    $payrollgroupModel->update_payroll_group($dataArr,$id);
                    $trDb->commit();
                    
                    $baseUrl = new Zend_View_Helper_BaseUrl();
                    $this->_helper->flashMessenger('Payroll category and rolles updated successfully.');
                    $this->getResponse()->setRedirect($baseUrl->baseUrl().'/index.php/payrollgroup');

                    //$this->_redirect('payrollgroup');
                } catch (Exception $ex) {
                    die("exception");
                    $trDb->rollBack();
                    $exception = $ex->getMessage();
                    if(!empty($exception)){
                        $error=TRUE;
                        $error=TRUE;
                        $err_msg_arr['header_messsage']=$e->getMessage();
                    }else{
                        $error=TRUE;
                        $err_msg_arr['header_messsage']="Unknown error arises to save the payroll group data,Please try again.";
                    }
                    $this->view->error=TRUE;
                }
            }else{
                //echo '<pre>';print_r($err_msg_arr);die;
                $this->view->error=TRUE;
            }
        }else{
            $rs_main_roll_details=$payrollgroupModel->get_main_roll_details($id);
            $this->view->rs_main_roll_details=$rs_main_roll_details;
            $this->view->main_roll_id=$id;
            
            //$rsPayrolllGroupDetails=$payrollgroupModel->get_details_by_id($id);
            $rsPayrolllGroupCategoryDetails=$payrollgroupModel->get_category_details_by_id($id);
            //echo '<pre>';print_r($rsPayrolllGroupDetails);die;
            $this->view->error=$error;
            $this->view->err_msg_arr=$err_msg_arr;
            //$this->view->group_details=$rsPayrolllGroupDetails;
            $this->view->group_category_details=$rsPayrolllGroupCategoryDetails;
        }
        
    }
    
    function deleteAction(){
        $emptyFlag=0;
        $report_opt = array();
        $popConfigPermission = array();
        $auth = Zend_Auth::getInstance();
        $candidateid= $this->_request->getParam('cid');
        if($auth->hasIdentity()){
            $loginUserId = $auth->getStorage()->read()->id;
            $loginuserRole = $auth->getStorage()->read()->emprole;
            $loginuserGroup = $auth->getStorage()->read()->group_id;
        }
        
        $employeeModel = new Default_Model_Employee();
        $currentOrgHead = $employeeModel->getCurrentOrgHead();

        if(empty($currentOrgHead)){
                $this->addorganisationhead($loginUserId);
        }else{
            if(sapp_Global::_checkprivileges(PREFIX,$loginuserGroup,$loginuserRole,'add') == 'Yes'){
                    array_push($popConfigPermission,'prefix');
            }
            if(sapp_Global::_checkprivileges(IDENTITYCODES,$loginuserGroup,$loginuserRole,'edit') == 'Yes'){
                    array_push($popConfigPermission,'identitycodes');
            }
            if(sapp_Global::_checkprivileges(EMPLOYMENTSTATUS,$loginuserGroup,$loginuserRole,'add') == 'Yes'){
                    array_push($popConfigPermission,'empstatus');
            }
            if(sapp_Global::_checkprivileges(JOBTITLES,$loginuserGroup,$loginuserRole,'add') == 'Yes'){
                    array_push($popConfigPermission,'jobtitles');
            }
            if(sapp_Global::_checkprivileges(POSITIONS,$loginuserGroup,$loginuserRole,'add') == 'Yes'){
                    array_push($popConfigPermission,'position');
            }
        }
        $payrollgroupModel = new Default_Model_Payrollgroup();
        $this->view->popConfigPermission = $popConfigPermission;
        $id = $this->_request->getParam('id');
        $rsPayrolllGroupDetails=$payrollgroupModel->get_roll_details_by_id($id);
        //echo '<pre>';print_r($rsPayrolllGroupDetails);die;
        $baseUrl = new Zend_View_Helper_BaseUrl();
        //error_reporting(E_ALL|E_STRICT);
        //ini_set('display_errors', 'on');
        if(!empty($rsPayrolllGroupDetails)){
            $trDb = Zend_Db_Table::getDefaultAdapter();
            $trDb->beginTransaction();
            try{
                //$where = array('payroll_group_id=?'=>$id);
                //$data=array('status'=>2);
                //$employeeModel->update_payroll_group($data,$where,'payroll_groups');
                $payrollgroupModel->delete_roll_category_data($id);
                $trDb->commit();
                $this->_helper->flashMessenger('Payroll group deleted successfully.');
            } catch (Exception $ex) {
                $this->_helper->flashMessenger($ex->getMessage().' .Please try again');
            }
        }else{
            $this->_helper->flashMessenger('Invalid group index selected.Please try again');
        }
        $this->getResponse()->setRedirect($baseUrl->baseUrl().'/index.php/payrollgroup');
    }
    
}

