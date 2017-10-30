<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Default_PayrollcategoryController extends Zend_Controller_Action{
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
        $payrollcategoryModel = new Default_Model_Payrollcategory();
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

                    $sort = 'DESC';$by = 'pc.payroll_category_id';$pageNo = 1;$searchData = '';
                    $searchQuery = '';$searchArray='';
            }
            else
            {
                    $sort = ($this->_getParam('sort') !='')? $this->_getParam('sort'):'DESC';
                    $by = ($this->_getParam('by')!='')? $this->_getParam('by'):'pc.payroll_category_id';

                    if($dashboardcall == 'Yes')
                    $perPage = $this->_getParam('per_page',DASHBOARD_PERPAGE);
                    else
                    $perPage = $this->_getParam('per_page',PERPAGE);

                    $pageNo = $this->_getParam('page', 1);
                    $searchData = $this->_getParam('searchData');
                    $searchData = rtrim($searchData,',');
            }
            //$dataArr= $this->getcondition();
            //sapp_Payrollcal::pre($dataArr);die;
            //$data=sapp_Showpayrollcondition::get_payroll_condition_value(1);
            //sapp_Payrollcal::pre($data);die;
            $dataTmp = $payrollcategoryModel->getGrid($sort, $by, $perPage, $pageNo, $searchData,$call,$dashboardcall,$loginUserId);

            array_push($data,$dataTmp); 
            //sapp_Payrollcal::pre($data);die;
            $this->view->dataArray = $data;
            $this->view->call = $call;
        }
        else
        {
                //$this->addorganisationhead($loginUserId);

        }		
        $this->view->messages = $this->_helper->flashMessenger->getMessages(); //echo 'sdf'; die;
    }
    
    public function indexbackupAction(){
        $auth = Zend_Auth::getInstance();
        $popConfigPermission = array();
        if($auth->hasIdentity()){
            $loginUserId = $auth->getStorage()->read()->id;
            $loginuserRole = $auth->getStorage()->read()->emprole;
            $loginuserGroup = $auth->getStorage()->read()->group_id;
        }        
        
        $payrollcategoryModel = new Default_Model_Payrollcategory();
        
        $earnings = $payrollcategoryModel->getAllEarnings();
        $deductions=$payrollcategoryModel->getAllDeductions();
        if(empty($earnings)){
                
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
        $this->view->earnings = $earnings;
        $this->view->deductions=$deductions;
    }
    
    public function addAction(){
//        error_reporting(E_ALL);
//        ini_set('display_errors',1);
        $emptyFlag=0;
        $report_opt = array();
        $popConfigPermission = array();
        $auth = Zend_Auth::getInstance();
        $candidateid= $this->_request->getParam('cid');
        if($auth->hasIdentity()){
                $loginUserId = $auth->getStorage()->read()->id;
                $loginuserRole = $auth->getStorage()->read()->emprole;
                $loginuserGroup = $auth->getStorage()->read()->group_id;
                $school_id=1;
                try{
                    $school_id = $auth->getStorage()->read()->school_id;
                } catch (Exception $ex) {

                }
        }
        
        $payrollcategoryModel = new Default_Model_Payrollcategory();
        $payrollvalueModel = new Default_Model_Payrollvalue();
        $employeeModel = new Default_Model_Employee();
        $currentOrgHead = $employeeModel->getCurrentOrgHead();
	$categories=$payrollcategoryModel->payroll_get_all_category();
		
		
		
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
		$this->view->categories = $categories;
        $error=FALSE;
        $err_msg_arr=array();
        $this->view->error=FALSE;
        $this->view->err_msg_arr=$err_msg_arr;
        //$employeeform = new Default_Form_employee();
        if($this->getRequest()->isPost()){ //die("kkk");
            $category_name=trim($this->_request->getParam('category_name',null));
            $category_code=trim($this->_request->getParam('category_code',null));
            $category_value=trim($this->_request->getParam('category_value',null));
            $category_type=trim($this->_request->getParam('category_type',null));
            $numeric=trim($this->_request->getParam('numeric',null));
            $formula=trim($this->_request->getParam('formula',null));
            $if_var=trim($this->_request->getParam('if',null));
            $operator=trim($this->_request->getParam('operator',null));
            $condition=trim($this->_request->getParam('condition',null));
            $then_var=trim($this->_request->getParam('then',null));
            
            $dataArr=array();
            $dataArr1=array();
            $dataArr2=array();
            //echo $category_value.' = '.$category_code.' -- '.$category_name;die;
            if($category_name==""){
                $error=TRUE;
                $err_msg_arr['category_name']="Invalid data for 'Name'";
            }else{
                $rsNameArr=$payrollcategoryModel->is_name_exist($category_name);
                if(count($rsNameArr)==0){
                    $dataArr['name']=$category_name;
                }else{
                    $error=TRUE;
                    $err_msg_arr['category_name']=$category_name." is already exist in the payroll group.";
                }
            }
            
            if($category_code==""){
                $error=TRUE;
                $err_msg_arr['category_code']="Invalid data for code";
            }else{
                $dataArr['code']=$category_code;
            }
            $dataArr['school_id']=$school_id;
            
            if($category_value==""){
                $error=TRUE;
                $err_msg_arr['category_value']="Invalid data for category_value";
            }else{
                $dataArr1['category_value']=$category_value;
            }
            $dataArr1['school_id']=$school_id;
            if($category_type==""){
                $error=TRUE;
                $err_msg_arr['category_type']="Invalid data for category_type";
            }else{
                $dataArr['type']=$category_type;
            }
            if($category_value=="numeric"&&$numeric==""){
                $error=TRUE;
                $err_msg_arr['numeric']="Invalid data for numeric";
            }else{
                $dataArr1['numeric']=$numeric;
            }
            if($category_value=="formula"&&$formula==""){
                $error=TRUE;
                $err_msg_arr['formula']="Invalid data for formula";
            }else{
                $dataArr1['formula']=$formula;
            }
            if($category_value=="conditionwithformula"&&$if_var==""){
                $error=TRUE;
                $err_msg_arr['if']="Invalid data for if condition";
            }else{
                $dataArr1['if']=$if_var;
            }
             if($category_value=="conditionwithformula"&&$operator==""){
                $error=TRUE;
                $err_msg_arr['operator']="Invalid data for operator";
            }else{
                $dataArr1['operator']=$operator;
            }
             if($category_value=="conditionwithformula"&&$condition==""){
                $error=TRUE;
                $err_msg_arr['condition']="Invalid data for condition";
            }else{
                $dataArr1['condition']=$condition;
            }
             if($category_value=="conditionwithformula"&&$then_var==""){
                $error=TRUE;
                $err_msg_arr['then']="Invalid data for then";
            }else{
                $dataArr1['then']=$then_var;
            }
            
            if($category_value=="conditionwithformula")
            {
                $dataArr2['value_type_id']=2;
            }
             if($category_value=="formula")
            {
                $dataArr2['value_type_id']=1;
            }
             if($category_value=="numeric")
            {
                $dataArr2['value_type_id']=0;
                $dataArr2['school_id']=$school_id;
            }
            //echo '<pre>LL';print_r($err_msg_arr);die;
            if($error==FALSE){
                $trDb = Zend_Db_Table::getDefaultAdapter();
                $trDb->beginTransaction();
                try{
                    //echo '<pre>LL';print_r($dataArr);print_r($dataArr1);die;
                    $dataArr2['payroll_category_id']=$payrollcategoryModel->save_payroll_category($dataArr);
                    //echo '<pre>LL';print_r($dataArr);print_r($dataArr1);die;
                    $dataArr2['value_category_id']=$payrollcategoryModel->save_category_values($dataArr1,'');
                    $payrollvalueModel->save_payroll_value($dataArr2);
                    
                    $trDb->commit();
                    $this->view->error=FALSE;
                    $err_msg_arr['header_messsage']="Payroll category created successfully.";
                    $this->view->$err_msg_arr=$err_msg_arr;
                    $this->_redirect('payrollcategory');
                } catch (Exception $ex) {
                    $trDb->rollBack();
                    $exception = $ex->getMessage();
                    ($exception);die;
                    if(!empty($exception)){
                        $error=TRUE;
                        $error=TRUE;
                        $err_msg_arr['header_messsage']=$e->getMessage();
                    }else{
                        $error=TRUE;
                        $err_msg_arr['header_messsage']="Unknown error arises to save the payroll category data,Please try again.";
                    }
                    $this->view->error=TRUE;
                    $this->view->$err_msg_arr=$err_msg_arr;
                }
            }else{
                $this->view->error=TRUE;
                $this->view->err_msg_arr=$err_msg_arr;
            }
        }
    }
    public function validateAction()
    {
        
        //error_reporting(E_ALL);
        // ini_set('display_errors', 1);
        //$evalMath=new Payroll_Evalmath();
       
    }
    
    public function deleteAction(){
        //error_reporting(E_ALL);
        //ini_set('display_errors', 1);
        
        $id = $this->_request->getParam('id');
        $payrollcategoryModel = new Default_Model_Payrollcategory();
        $result=$payrollcategoryModel->details($id);
        $baseUrl = new Zend_View_Helper_BaseUrl();
        if(!empty($result)){
            $trDb = Zend_Db_Table::getDefaultAdapter();
            $trDb->beginTransaction();
            try{
                $rsCategoryRole=$payrollcategoryModel->is_category_conect_to_role($id);
                if(empty($rsCategoryRole)){
                    $rsPayrollValue= $payrollcategoryModel->payroll_value_details($id);
                    foreach($rsPayrollValue AS $k=>$v){
                        $payrollcategoryModel->delete_payroll_value($v['value_type_id'],$v['value_category_id']);
                    }
                    $payrollcategoryModel->delete($id);
                    $trDb->commit();
                    $this->_helper->flashMessenger('Payroll catetgory deleted successfully.');
                }else{
                    $this->_helper->flashMessenger('Payroll catetgory has been assigned to many roles, so unable to delete.');
                }
            } catch (Exception $ex) {
                //sapp_Payrollcal::pre($ex->getMessage());die;
                $this->_helper->flashMessenger($ex->getMessage().' .Please try again');
            }
        }else{
            $this->_helper->flashMessenger('Invalid category index selected.Please try again');
        }
        $this->getResponse()->setRedirect($baseUrl->baseUrl().'/index.php/payrollcategory');
    }
    
    function getcondition(){
        $payrollcategoryModel = new Default_Model_Payrollcategory();
        $dataArr=$payrollcategoryModel->get_condition(1);
        //sapp_Payrollcal::pre($dataArr);die;
    }
    
    function editAction(){
//        error_reporting(E_ALL);
//        ini_set('display_errors', 1);
        $emptyFlag=0;
        $report_opt = array();
        $popConfigPermission = array();
        $auth = Zend_Auth::getInstance();
        $candidateid= $this->_request->getParam('cid');
        if($auth->hasIdentity()){
                $loginUserId = $auth->getStorage()->read()->id;
                $loginuserRole = $auth->getStorage()->read()->emprole;
                $loginuserGroup = $auth->getStorage()->read()->group_id;
                try{
                    $school_id = $auth->getStorage()->read()->school_id;
                } catch (Exception $ex) {

                }
                /*try {
                    $school_id = $auth->getStorage()->read()->school_id;
                }catch(Exception AS $e){
                    
                }*/
        }
        
        $payrollcategoryModel = new Default_Model_Payrollcategory();
        $payrollvalueModel = new Default_Model_Payrollvalue();
        $employeeModel = new Default_Model_Employee();
        $currentOrgHead = $employeeModel->getCurrentOrgHead();
	$categories=$payrollcategoryModel->payroll_get_all_category();
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
        $error=FALSE;
        $err_msg_arr=array();
        $this->view->error=FALSE;
        $this->view->err_msg_arr=$err_msg_arr;
		$this->view->categories = $categories;
        $id = $this->_request->getParam('id');
        $this->view->id=$id;
        $empcategory = $this->_request->getParam('empcategory');
        $this->view->empcategory=$empcategory;
        
        if($empcategory == 1){
            Zend_Layout::getMvcInstance()->setLayoutPath(APPLICATION_PATH."/layouts/scripts/popup/");
        }
        
        $userid = $this->_request->getParam('userid');
        $this->view->userid=$userid;
        $payslipid = $this->_request->getParam('payslipid');
        $this->view->payslipid=$payslipid;
        $baseUrl = new Zend_View_Helper_BaseUrl();
        if($id==""){
            $this->_helper->flashMessenger('Invalid payroll category selected,Please try again.');
            $this->getResponse()->setRedirect($baseUrl->baseUrl().'/index.php/payrollcategory');
        }
        $categoryModel=new Default_Model_Payrollcategory();
        $categoryFullDetails=$categoryModel->get_full_details($id);
        //sapp_Payrollcal::pre($categoryFullDetails);
        $payrollConditionDetails=array();
        if($this->getRequest()->isPost()){
            /// post data
            $category_name=trim($this->_request->getParam('category_name',null));
            $category_code=trim($this->_request->getParam('category_code',null));
            $category_value=trim($this->_request->getParam('category_value',null));
            $category_type=trim($this->_request->getParam('category_type',null));
            $numeric=trim($this->_request->getParam('numeric',null));
            $formula=trim($this->_request->getParam('formula',null));
            $if_var=trim($this->_request->getParam('if',null));
            $operator=trim($this->_request->getParam('operator',null));
            $condition=trim($this->_request->getParam('condition',null));
            $then_var=trim($this->_request->getParam('then',null));
            
            $dataArr=array();
            $dataArr1=array();
            $dataArr2=array();
            
            if($category_name==""){
                $error=TRUE;
                $err_msg_arr['category_name']="Invalid data for 'Name'";
            }else{
                $dataArr['name']=$category_name;
            }
            
            /*if($category_code==""){
                $error=TRUE;
                $err_msg_arr['category_code']="Invalid data for code";
            }else{
                $dataArr['code']=$category_code;
            }
            
            if($category_value==""){
                $error=TRUE;
                $err_msg_arr['category_value']="Invalid data for category_value";
            }else{
                $dataArr1['category_value']=$category_value;
            }*/
            
            if($category_type==""){
                $error=TRUE;
                $err_msg_arr['category_type']="Invalid data for category_type";
            }else{
                $dataArr['type']=$category_type;
            }
            
            if($categoryFullDetails[0]['value_type_id']==0){
                if($numeric==""){
                    $error=TRUE;
                    $err_msg_arr['numeric']="Invalid data for numeric";
                }else{
                    $val=$numeric;
                }
            }
            
            /*if($category_value=="numeric"&&$numeric==""){
                $error=TRUE;
                $err_msg_arr['numeric']="Invalid data for numeric";
            }else{
                $val=$numeric;
            } */
            if($categoryFullDetails[0]['value_type_id']==1){
                if($formula==""){
                    $error=TRUE;
                    $err_msg_arr['formula']="Invalid data for formula";
                }else{
                    $val=$formula;
                }
            }
            
            
            if($category_value=="conditionwithformula"&&$if_var==""){
                $error=TRUE;
                $err_msg_arr['if']="Invalid data for if condition";
            }else{
                $dataArr1['if']=$if_var;
            }
            if($category_value=="conditionwithformula"&&$operator==""){
                $error=TRUE;
                $err_msg_arr['operator']="Invalid data for operator";
            }else{
                $dataArr1['operator']=$operator;
            }
             if($category_value=="conditionwithformula"&&$condition==""){
                $error=TRUE;
                $err_msg_arr['condition']="Invalid data for condition";
            }else{
                $dataArr1['condition']=$condition;
            }
             if($category_value=="conditionwithformula"&&$then_var==""){
                $error=TRUE;
                $err_msg_arr['then']="Invalid data for then";
            }else{
                $dataArr1['then']=$then_var;
            }
            
            $dataArr1['school_id']=$school_id;
            
            if($category_value=="conditionwithformula"){
                $dataArr2['value_type_id']=2;
            }
             if($category_value=="formula"){
                $dataArr2['value_type_id']=1;
            }
            
            if($category_value=="numeric"){
                $dataArr2['value_type_id']=0;
            }
            //sapp_Payrollcal::pre($err_msg_arr);
            //sapp_Payrollcal::pre($_POST);
            //sapp_Payrollcal::pre($dataArr);
            //sapp_Payrollcal::pre($categoryFullDetails);
            $value_category_id=$categoryFullDetails[0]['value_category_id'];
            //echo $value_category_id;
            //sapp_Payrollcal::pre($_POST);
            //die;
            if($error==FALSE){
                $trDb = Zend_Db_Table::getDefaultAdapter();
                $trDb->beginTransaction();
                try{
                    //echo '<pre>LL';print_r($dataArr);print_r($dataArr1);die;
                    $payrollcategoryModel->update_payroll_category($dataArr,$id);
                    //sapp_Payrollcal::pre($categoryFullDetails[0]['value_type_id']);die;
                    if($categoryFullDetails[0]['value_type_id']==0){
                        $payrollcategoryModel->update_payroll_category_value_numeric($val,$value_category_id);
                    }elseif($categoryFullDetails[0]['value_type_id']==1){
                        $payrollcategoryModel->update_payroll_category_value_formula($val,$value_category_id);
                    }elseif($categoryFullDetails[0]['value_type_id']==2){
                        $payrollcategoryModel->update_payroll_category_value_condition($dataArr1,$value_category_id);
                    }
                    
                    $trDb->commit();
                    $this->view->error=FALSE;
                    $this->_helper->flashMessenger('Payroll category updated successfully.');
                    //sapp_Payrollcal::pre($err_msg_arr);die;
                    $this->view->err_msg_arr=$err_msg_arr;
                    if($empcategory == 1){
                        $url = 'emppayslips/view/userid/'.$userid.'/payslipid/'.$payslipid;
                        echo '<script>parent.top.location=parent.top.location</script>';
                        //$this->_redirect('emppayslips/view/userid/'.$userid.'/payslipid/'.$payslipid);
                    } else {
                        $this->_redirect('payrollcategory');
                    }
                } catch (Exception $ex) {
                    $trDb->rollBack();
                    $exception = $ex->getMessage();
                    die($exception);die;
                    if(!empty($exception)){
                        $error=TRUE;
                        $error=TRUE;
                        $err_msg_arr['header_messsage']=$ex->getMessage();
                        $this->_helper->flashMessenger($err_msg_arr['header_messsage']);
                    }else{
                        $error=TRUE;
                        $err_msg_arr['header_messsage']="Unknown error arises to save the payroll category data,Please try again.";
                        $this->_helper->flashMessenger($err_msg_arr['header_messsage']);
                    }
                    $this->view->error=TRUE;
                    $this->view->err_msg_arr=$err_msg_arr;
                    if($empcategory == 1){
                        $this->_redirect('emppayslips/view/userid/'.$userid.'/payslipid/'.$payslipid);
                    } else {
                        $this->_redirect('payrollcategory');
                    }
                }
            }else{
                $this->view->error=TRUE;
                $this->view->err_msg_arr=$err_msg_arr;
            }
        }
        if($categoryFullDetails[0]['value_type_id']==2){
            $payrollConditionDetails=sapp_Showpayrollcondition::get_payroll_condition_value_arr_in_edit($categoryFullDetails[0]['value_formula']);
            $this->view->payrollConditionDetails= $payrollConditionDetails;
        }else{
            $this->view->payrollConditionDetails=$payrollConditionDetails;
        }
        //sapp_Payrollcal::pre($payrollConditionDetails);die;
        $this->view->categoryFullDetails=$categoryFullDetails;
    }
    
    public function addpopupAction()
	{
            $controllername = 'payrollcategory';
            $screenFlag = "";
            Zend_Layout::getMvcInstance()->setLayoutPath(APPLICATION_PATH."/layouts/scripts/popup/");
            $emptyFlag=0;
        $report_opt = array();
        $popConfigPermission = array();
        $auth = Zend_Auth::getInstance();
        $candidateid= $this->_request->getParam('cid');
        $userid = $this->_request->getParam('userid');
        $this->view->userid = $userid;
        $type = $this->_request->getParam('type');
        $this->view->type = $type;
        if($auth->hasIdentity()){
                $loginUserId = $auth->getStorage()->read()->id;
                $loginuserRole = $auth->getStorage()->read()->emprole;
                $loginuserGroup = $auth->getStorage()->read()->group_id;
                $school_id=1;
                try{
                    $school_id = $auth->getStorage()->read()->school_id;
                } catch (Exception $ex) {

                }
        }
        
        $payrollcategoryModel = new Default_Model_Payrollcategory();
        $payrollvalueModel = new Default_Model_Payrollvalue();
        $employeeModel = new Default_Model_Employee();
        $currentOrgHead = $employeeModel->getCurrentOrgHead();
        $categories=$payrollcategoryModel->payroll_get_all_category();
        
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
        $this->view->categories = $categories;
        $error=FALSE;
        $err_msg_arr=array();
        $this->view->error=FALSE;
        $this->view->err_msg_arr=$err_msg_arr;

        if($this->getRequest()->isPost()){ 
            $category_name=trim($this->_request->getParam('category_name',null));
            $category_code=trim($this->_request->getParam('category_code',null));
            $category_value=trim($this->_request->getParam('category_value',null));
            $category_type=trim($this->_request->getParam('category_type',null));
            $numeric=trim($this->_request->getParam('numeric',null));
            $formula=trim($this->_request->getParam('formula',null));
            $if_var=trim($this->_request->getParam('if',null));
            $operator=trim($this->_request->getParam('operator',null));
            $condition=trim($this->_request->getParam('condition',null));
            $then_var=trim($this->_request->getParam('then',null));
            
            $dataArr=array();
            $dataArr1=array();
            $dataArr2=array();

            if($category_name==""){
                $error=TRUE;
                $err_msg_arr['category_name']="Invalid data for 'Name'";
            }else{
                $dataArr['name']=$category_name;
//                $rsNameArr=$payrollcategoryModel->is_name_exist($category_name);
//                if(count($rsNameArr)==0){
//                    $dataArr['name']=$category_name;
//                }else{
//                    $error=TRUE;
//                    $err_msg_arr['category_name']=$category_name." is already exist in the payroll grooup.";
//                }
            }
            
            if($category_code==""){
                $error=TRUE;
                $err_msg_arr['category_code']="Invalid data for code";
            }else{
                $dataArr['code']=$category_code;
            }
            $dataArr['school_id']=$school_id;
            
            if($category_value==""){
                $error=TRUE;
                $err_msg_arr['category_value']="Invalid data for category_value";
            }else{
                $dataArr1['category_value']=$category_value;
            }
            $dataArr1['school_id']=$school_id;
            $dataArr1['emp_id']=$userid;
            if($category_type==""){
                $error=TRUE;
                $err_msg_arr['category_type']="Invalid data for category_type";
            }else{
                $dataArr['type']=$category_type;
            }
            $dataArr['emp_id']=$userid;
            if($category_value=="numeric"&&$numeric==""){
                $error=TRUE;
                $err_msg_arr['numeric']="Invalid data for numeric";
            }else{
                $dataArr1['numeric']=$numeric;
            }
            if($category_value=="formula"&&$formula==""){
                $error=TRUE;
                $err_msg_arr['formula']="Invalid data for formula";
            }else{
                $dataArr1['formula']=$formula;
            }
            if($category_value=="conditionwithformula"&&$if_var==""){
                $error=TRUE;
                $err_msg_arr['if']="Invalid data for if condition";
            }else{
                $dataArr1['if']=$if_var;
            }
             if($category_value=="conditionwithformula"&&$operator==""){
                $error=TRUE;
                $err_msg_arr['operator']="Invalid data for operator";
            }else{
                $dataArr1['operator']=$operator;
            }
             if($category_value=="conditionwithformula"&&$condition==""){
                $error=TRUE;
                $err_msg_arr['condition']="Invalid data for condition";
            }else{
                $dataArr1['condition']=$condition;
            }
             if($category_value=="conditionwithformula"&&$then_var==""){
                $error=TRUE;
                $err_msg_arr['then']="Invalid data for then";
            }else{
                $dataArr1['then']=$then_var;
            }
            
            if($category_value=="conditionwithformula")
            {
                $dataArr2['value_type_id']=2;
            }
             if($category_value=="formula")
            {
                $dataArr2['value_type_id']=1;
            }
             if($category_value=="numeric")
            {
                $dataArr2['value_type_id']=0;
                $dataArr2['school_id']=$school_id;
            }
            $dataArr2['emp_id'] = $userid;
            
            if($error==FALSE){
                $trDb = Zend_Db_Table::getDefaultAdapter();
                $trDb->beginTransaction();
                try{
                   // echo $userid;
                    //$dataArr2['emp_id']=$userid;print_r($dataArr2);die;
                    //echo '<pre>LL';print_r($dataArr);print_r($dataArr1);print_r($dataArr2);die;
                    $dataArr2['payroll_category_id']=$payrollcategoryModel->save_payroll_category($dataArr);
                    //echo '<pre>LL';print_r($dataArr);print_r($dataArr1);die;
                    $dataArr2['value_category_id']=$payrollcategoryModel->save_category_values($dataArr1,$userid);
                    $payrollvalueModel->save_payroll_value($dataArr2);
                    
                    $trDb->commit();
                    $this->view->error=FALSE;
                    $err_msg_arr['header_messsage']="Payroll category created successfully.";
                    $this->view->$err_msg_arr=$err_msg_arr;
                    //$this->_redirect('payrollcategory');
                } catch (Exception $ex) {
                    $trDb->rollBack();
                    $exception = $ex->getMessage();
                    ($exception);die;
                    if(!empty($exception)){
                        $error=TRUE;
                        $error=TRUE;
                        $err_msg_arr['header_messsage']=$e->getMessage();
                    }else{
                        $error=TRUE;
                        $err_msg_arr['header_messsage']="Unknown error arises to save the payroll category data,Please try again.";
                    }
                    $this->view->error=TRUE;
                    $this->view->$err_msg_arr=$err_msg_arr;
                }
                $close = 'close';
                $this->view->popup=$close;
                $_SESSION['reload'] = 1;
            }else{
                $this->view->error=TRUE;
                $this->view->err_msg_arr=$err_msg_arr;
            }
        }

	}
        
        function editpopupAction(){
//            error_reporting(E_ALL);
//            ini_set('display_errors', 1);
            $emptyFlag=0;
            $report_opt = array();
            $popConfigPermission = array();
            Zend_Layout::getMvcInstance()->setLayoutPath(APPLICATION_PATH."/layouts/scripts/popup/");
            $auth = Zend_Auth::getInstance();
            $candidateid= $this->_request->getParam('cid');
            if($auth->hasIdentity()){
                $loginUserId = $auth->getStorage()->read()->id;
                $loginuserRole = $auth->getStorage()->read()->emprole;
                $loginuserGroup = $auth->getStorage()->read()->group_id;
                try{
                    $school_id = $auth->getStorage()->read()->school_id;
                } catch (Exception $ex) {

                }
            }
        
            $payrollcategoryModel = new Default_Model_Payrollcategory();
            $payrollvalueModel = new Default_Model_Payrollvalue();
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
            $error=FALSE;
            $err_msg_arr=array();
            $this->view->error=FALSE;
            $this->view->err_msg_arr=$err_msg_arr;
            $id = $this->_request->getParam('id');
            $this->view->id=$id;
            $baseUrl = new Zend_View_Helper_BaseUrl();
            if($id==""){
                $this->_helper->flashMessenger('Invalid payroll category selected,Please try again.');
                $this->getResponse()->setRedirect($baseUrl->baseUrl().'/index.php/payrollcategory');
            }
            $categoryModel=new Default_Model_Payrollcategory();
            $categoryFullDetails=$categoryModel->get_full_details($id);

            $payrollConditionDetails=array();
            if($this->getRequest()->isPost()){
                // post data
                $category_name=trim($this->_request->getParam('category_name',null));
                $category_code=trim($this->_request->getParam('category_code',null));
                $category_value=trim($this->_request->getParam('category_value',null));
                $category_type=trim($this->_request->getParam('category_type',null));
                $numeric=trim($this->_request->getParam('numeric',null));
                $formula=trim($this->_request->getParam('formula',null));
                $if_var=trim($this->_request->getParam('if',null));
                $operator=trim($this->_request->getParam('operator',null));
                $condition=trim($this->_request->getParam('condition',null));
                $then_var=trim($this->_request->getParam('then',null));

                $dataArr=array();
                $dataArr1=array();
                $dataArr2=array();

                if($category_name==""){
                    $error=TRUE;
                    $err_msg_arr['category_name']="Invalid data for 'Name'";
                }else{
                    $dataArr['name']=$category_name;
                }
            
                if($category_type==""){
                    $error=TRUE;
                    $err_msg_arr['category_type']="Invalid data for category_type";
                }else{
                    $dataArr['type']=$category_type;
                }

                if($categoryFullDetails[0]['value_type_id']==0){
                    if($numeric==""){
                        $error=TRUE;
                        $err_msg_arr['numeric']="Invalid data for numeric";
                    }else{
                        $val=$numeric;
                    }
                }
            
                if($categoryFullDetails[0]['value_type_id']==1){
                    if($formula==""){
                        $error=TRUE;
                        $err_msg_arr['formula']="Invalid data for formula";
                    }else{
                        $val=$formula;
                    }
                }

                if($category_value=="conditionwithformula"&&$if_var==""){
                    $error=TRUE;
                    $err_msg_arr['if']="Invalid data for if condition";
                }else{
                    $dataArr1['if']=$if_var;
                }
                if($category_value=="conditionwithformula"&&$operator==""){
                    $error=TRUE;
                    $err_msg_arr['operator']="Invalid data for operator";
                }else{
                    $dataArr1['operator']=$operator;
                }
                 if($category_value=="conditionwithformula"&&$condition==""){
                    $error=TRUE;
                    $err_msg_arr['condition']="Invalid data for condition";
                }else{
                    $dataArr1['condition']=$condition;
                }
                 if($category_value=="conditionwithformula"&&$then_var==""){
                    $error=TRUE;
                    $err_msg_arr['then']="Invalid data for then";
                }else{
                    $dataArr1['then']=$then_var;
                }
            
                $dataArr1['school_id']=$school_id;

                if($category_value=="conditionwithformula"){
                    $dataArr2['value_type_id']=2;
                }
                 if($category_value=="formula"){
                    $dataArr2['value_type_id']=1;
                }

                if($category_value=="numeric"){
                    $dataArr2['value_type_id']=0;
                }
            
                $value_category_id=$categoryFullDetails[0]['value_category_id'];

                if($error==FALSE){
                    $trDb = Zend_Db_Table::getDefaultAdapter();
                    $trDb->beginTransaction();
                    try{
                        //echo '<pre>LL';print_r($dataArr);print_r($dataArr1);die;
                        $payrollcategoryModel->update_payroll_category($dataArr,$id);
                        //sapp_Payrollcal::pre($categoryFullDetails[0]['value_type_id']);die;
                        if($categoryFullDetails[0]['value_type_id']==0){
                            $payrollcategoryModel->update_payroll_category_value_numeric($val,$value_category_id);
                        }elseif($categoryFullDetails[0]['value_type_id']==1){
                            $payrollcategoryModel->update_payroll_category_value_formula($val,$value_category_id);
                        }elseif($categoryFullDetails[0]['value_type_id']==2){
                            $payrollcategoryModel->update_payroll_category_value_condition($dataArr1,$value_category_id);
                        }
                    
                        $trDb->commit();
                        $this->view->error=FALSE;
                        $this->_helper->flashMessenger('Payroll category updated successfully.');
                        //sapp_Payrollcal::pre($err_msg_arr);die;
                        $this->view->err_msg_arr=$err_msg_arr;
                        $this->_redirect('payrollcategory');
                    } catch (Exception $ex) {
                        $trDb->rollBack();
                        $exception = $ex->getMessage();
                        die($exception);die;
                        if(!empty($exception)){
                            $error=TRUE;
                            $error=TRUE;
                            $err_msg_arr['header_messsage']=$ex->getMessage();
                            $this->_helper->flashMessenger($err_msg_arr['header_messsage']);
                        }else{
                            $error=TRUE;
                            $err_msg_arr['header_messsage']="Unknown error arises to save the payroll category data,Please try again.";
                            $this->_helper->flashMessenger($err_msg_arr['header_messsage']);
                        }
                        $this->view->error=TRUE;
                        $this->view->err_msg_arr=$err_msg_arr;
                        $this->_redirect('payrollcategory');
                    }
                }else{
                    $this->view->error=TRUE;
                    $this->view->err_msg_arr=$err_msg_arr;
                }
            }
            if($categoryFullDetails[0]['value_type_id']==2){
                $payrollConditionDetails=sapp_Showpayrollcondition::get_payroll_condition_value_arr_in_edit($categoryFullDetails[0]['value_formula']);
                $this->view->payrollConditionDetails= $payrollConditionDetails;
            }else{
                $this->view->payrollConditionDetails=$payrollConditionDetails;
            }
            $this->view->categoryFullDetails=$categoryFullDetails;
        }
        
        public function editcategoryforemppopupAction($id){
            Zend_Layout::getMvcInstance()->setLayoutPath(APPLICATION_PATH."/layouts/scripts/popup/");
            $emptyFlag=0;
            $report_opt = array();
            $popConfigPermission = array();
            $auth = Zend_Auth::getInstance();
            $candidateid= $this->_request->getParam('cid');
            $userid= $this->_request->getParam('userid');
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

            $err_msg_arr=array();
            $error=FALSE;
            $this->view->groupcode=$payrollgroupModel->get_payroll_group_code_emp($userid);
            $id = $this->_request->getParam('id');
            $this->view->userid=$userid;
            $payslipid = $this->_request->getParam('payslipid');
            $this->view->payslipid=$payslipid;
            
            if($this->getRequest()->isPost()){
                if(array_key_exists('add_payroll_group_code_hidden', $_POST)){
                    $payroll_group_codes=$_POST['add_payroll_group_code_hidden'];
                }else{
                    $payroll_group_codes="";
                }
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
                        $this->_helper->flashMessenger('Payroll category and roles updated successfully.');
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
    
    public function deleteempcategoryAction(){
        $categoryid= $this->_request->getParam('cateId');
        $payrollcategoryModel = new Default_Model_Payrollcategory();
        
        $delete = '';
        $delete = $payrollcategoryModel->delete_emp_category($categoryid);
        echo $delete;
        exit();
    }
}