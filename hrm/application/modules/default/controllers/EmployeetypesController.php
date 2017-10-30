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

class Default_EmployeetypesController extends Zend_Controller_Action
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
            $emptypesmodel = new Default_Model_Employeetypes();
            $call = $this->_getParam('call');
            if($call == 'ajaxcall')
            $this->_helper->layout->disableLayout();

            $view = Zend_Layout::getMvcInstance()->getView();
            $objname = $this->_getParam('objname');
            $refresh = $this->_getParam('refresh');
            $dashboardcall = $this->_getParam('dashboardcall',null);
            $data = array();		$searchQuery = '';		
            $searchArray = array();		$tablecontent='';

            if($refresh == 'refresh')
            {
                if($dashboardcall == 'Yes')
                $perPage = DASHBOARD_PERPAGE;
                else
                $perPage = PERPAGE;

                $sort = 'DESC';$by = 'et.modified_date';$pageNo = 1;$searchData = '';$searchQuery = '';
                $searchArray = array();
            }
            else
            {
                $sort = ($this->_getParam('sort') !='')? $this->_getParam('sort'):'DESC';
                $by = ($this->_getParam('by')!='')? $this->_getParam('by'):'et.modified_date';
                if($dashboardcall == 'Yes')
                $perPage = $this->_getParam('per_page',DASHBOARD_PERPAGE);
                else
                $perPage = $this->_getParam('per_page',PERPAGE);

                $pageNo = $this->_getParam('page', 1);
                $searchData = $this->_getParam('searchData');
                $searchData = rtrim($searchData,',');
            }
            $dataTmp = $emptypesmodel->getGrid($sort,$by,$perPage,$pageNo,$searchData,$call,$dashboardcall);
            array_push($data,$dataTmp);
            $this->view->dataArray = $data;
            $this->view->call = $call ;
            $this->view->messages = $this->_helper->flashMessenger->getMessages();
	}
        
        public function addAction()
	{
//            error_reporting(E_ALL);
//            ini_set('display_errors',1);
            $emptyFlag=0;
            $msgarray = array();
            $auth = Zend_Auth::getInstance();
            if($auth->hasIdentity()){
                $loginUserId = $auth->getStorage()->read()->id;
                $loginuserRole = $auth->getStorage()->read()->emprole;
                $loginuserGroup = $auth->getStorage()->read()->group_id;
                $school_id = $auth->getStorage()->read()->school_id;
                    
            }
		
	    $popConfigPermission = sapp_Global::_checkprivileges(PREFIX,$loginuserGroup,$loginuserRole,'add');
	    $this->view->popConfigPermission = $popConfigPermission;

            $emptypesform = new Default_Form_employeetypes();
            $emptypesform->setAttrib('action',BASE_URL.'employeetypes/add');
            $emptypesmodel = new Default_Model_Employeetypes();
            
            $this->view->form = $emptypesform;

            if($this->getRequest()->getPost())
            {
                    $msgarray = $this->save($emptypesform);			
            }
            $this->view->msgarray = $msgarray;	
	}

       public function editAction()
	{
		$emptyFlag=0;
		$msgarray = array();
		$auth = Zend_Auth::getInstance();
		if($auth->hasIdentity()){
			$loginUserId = $auth->getStorage()->read()->id;
			$loginuserRole = $auth->getStorage()->read()->emprole;
			$loginuserGroup = $auth->getStorage()->read()->group_id;
                        $school_id = $auth->getStorage()->read()->school_id;
		}
		
		$id = $this->getRequest()->getParam('id');
		$callval = $this->getRequest()->getParam('call');
		if($callval == 'ajaxcall')
		$this->_helper->layout->disableLayout();

		$emptypesform = new Default_Form_employeetypes();
		$emptypesform->submit->setLabel('Update');
		$emptypesmodel = new Default_Model_Employeetypes();
		$objName = 'employeetypes';
		try
		{
			if($id)
			{
				$data = $emptypesmodel->getsingleEmployeeTypeData($id);
				
				if(!empty($data) && $data != 'norows')
				{
					$emptypesform->populate($data[0]);
					$this->view->form = $emptypesform;
					$this->view->controllername = $objName;
					$this->view->id = $id;
					$this->view->ermsg = '';
					$emptypesform->setAttrib('action',BASE_URL.'employeetypes/edit');
				}
				else
				{
					$this->view->ermsg = 'norecord';
				}
			}
		}
		catch(Exception $e)
		{
			$this->view->ermsg = 'nodata';
		}
		if($this->getRequest()->getPost()){
			$result = $this->save($emptypesform);
			$this->view->msgarray = $result;
		}
	}
        
	public function viewAction()
	{
		$id = $this->getRequest()->getParam('id');
		$callval = $this->getRequest()->getParam('call');
		if($callval == 'ajaxcall')
		$this->_helper->layout->disableLayout();
		$objName = 'employeetypes';
		$emptypesform = new Default_Form_employeetypes();
		$emptypesform->removeElement("submit");
		$emptypesmodel = new Default_Model_Employeetypes();

		$elements = $emptypesform->getElements();
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
			if($id)
			{
				$data = $emptypesmodel->getsingleEmployeeTypeData($id);
					
				if(!empty($data) && $data != 'norows')
				{
					$emptypesform->populate($data[0]);
					
					$this->view->form = $emptypesform;
					$this->view->controllername = $objName;
					$this->view->id = $id;
					$this->view->data = $data[0];
					$this->view->ermsg = '';
				}
				else
				{
					$this->view->ermsg = 'norecord';
				}
			}
		}
		catch(Exception $e)
		{
			$this->view->ermsg = 'nodata';
		}
	}

	public function addpopupAction()
	{
		Zend_Layout::getMvcInstance()->setLayoutPath(APPLICATION_PATH."/layouts/scripts/popup/");
		$auth = Zend_Auth::getInstance();
                $popConfigPermission = array();
		if($auth->hasIdentity())
		{
			$loginUserId = $auth->getStorage()->read()->id;
                        $loginuserRole = $auth->getStorage()->read()->emprole;
			$loginuserGroup = $auth->getStorage()->read()->group_id;
		}
        if(sapp_Global::_checkprivileges(JOBTITLES,$loginuserGroup,$loginuserRole,'add') == 'Yes'){
			array_push($popConfigPermission,'jobtitles');
		}
		if(sapp_Global::_checkprivileges(POSITIONS,$loginuserGroup,$loginuserRole,'add') == 'Yes'){
			array_push($popConfigPermission,'position');
		}
        $this->view->popConfigPermission = $popConfigPermission;
		$id = $this->getRequest()->getParam('unitId');
		if($id == '')
		$id = $loginUserId;
		// For open the form in popup...
		$empjobhistoryform = new Default_Form_empjobhistory();
		$emptyFlag=0;
		$msgarray = array();
		$employeeModel = new Default_Model_Employee();
		$positionModel = new Default_Model_Positions();
		$departmentModel = new Default_Model_Departments();
		$jobtitleModel = new Default_Model_Jobtitles();
		$clientsModel = new Timemanagement_Model_Clients();

		/* To check business unit exists for that particular employee
		 If exists then bring departments for that particular business unit else bring all departments
		 */
		$employeeArr = $employeeModel->getActiveEmployeeData($id);
		if(!empty($employeeArr))
		{
			if(isset($employeeArr[0]['businessunit_id']) && $employeeArr[0]['businessunit_id'] !='')
			{
				$departmentArr = $departmentModel->getDepartmentList($employeeArr[0]['businessunit_id']);
				if(!empty($departmentArr))
				{
					$empjobhistoryform->department->addMultiOption('','Select Department');
					foreach ($departmentArr as $departmentres){
						$empjobhistoryform->department->addMultiOption($departmentres['id'],$departmentres['deptname']);

					}
				}
				else
				{
					$msgarray['department'] = 'Departments are not added yet.';
					$emptyFlag++;
				}
			}
			else
			{
				$departmentArr = $departmentModel->getTotalDepartmentList();
				if(!empty($departmentArr))
				{
					$empjobhistoryform->department->addMultiOption('','Select Department');
					foreach ($departmentArr as $departmentres){
						$empjobhistoryform->department->addMultiOption($departmentres['id'],$departmentres['deptname']);

					}
				}
				else
				{
					$msgarray['department'] = 'Departments are not added yet.';
					$emptyFlag++;
				}
			}
		}
		$positionArr = $positionModel->getTotalPositionList();
		$empjobhistoryform->positionheld->addMultiOption('','Select Position');
		if(!empty($positionArr))
		{
			foreach ($positionArr as $positionres){
				$empjobhistoryform->positionheld->addMultiOption($positionres['id'],$positionres['positionname']);	
			}
		}else
		{
			$msgarray['positionheld'] = 'Positions are not configured yet.';
			$emptyFlag++;
		}
		$jobtitleArr = $jobtitleModel->getJobTitleList();
		$empjobhistoryform->jobtitleid->addMultiOption('','Select Job Title');
		if(!empty($jobtitleArr))
		{
			foreach ($jobtitleArr as $jobtitleres){
				$empjobhistoryform->jobtitleid->addMultiOption($jobtitleres['id'],$jobtitleres['jobtitlename']);
					
			}
		}
		else
		{
			$msgarray['jobtitleid'] = 'Job titles are not configured yet.';
			$emptyFlag++;
		}
		$clientsArr = $clientsModel->getActiveClientsData();
		$empjobhistoryform->client->addMultiOption('','Select a Client');
		if(!empty($clientsArr))
		{
			foreach ($clientsArr as $clientsres){
				$empjobhistoryform->client->addMultiOption($clientsres['id'],$clientsres['client_name']);
			}
		}
		else
		{
			$msgarray['client'] = 'Clients are not configured yet.';
			$emptyFlag++;
		}
		$empjobhistoryform->setAttrib('action',BASE_URL.'empjobhistory/addpopup/unitId/'.$id);
		$this->view->form = $empjobhistoryform;
		$this->view->controllername = 'empjobhistory';
		$this->view->msgarray = $msgarray;
		$this->view->emptyFlag = $emptyFlag;
		if($this->getRequest()->getPost())
		{
			$result = $this->save($empjobhistoryform,$id);
			$this->view->msgarray = $result;
		}

	}

	public function viewpopupAction()
	{
		Zend_Layout::getMvcInstance()->setLayoutPath(APPLICATION_PATH."/layouts/scripts/popup/");
		$auth = Zend_Auth::getInstance();
		if($auth->hasIdentity())
		{
			$loginUserId = $auth->getStorage()->read()->id;
		}
		$id = $this->getRequest()->getParam('id');
		if($id == '')
		$id = $loginUserId;
		$callval = $this->getRequest()->getParam('call');
		if($callval == 'ajaxcall')
		$this->_helper->layout->disableLayout();
		$objName = 'empjobhistory';
		$empjobhistoryform = new Default_Form_empjobhistory();
		$empjobhistoryModel = new Default_Model_Empjobhistory();
		$employeeModel = new Default_Model_Employee();
		$positionModel = new Default_Model_Positions();
		$departmentModel = new Default_Model_Departments();
		$jobtitleModel = new Default_Model_Jobtitles();
		$empjobhistoryform->removeElement("submit");
		$elements = $empjobhistoryform->getElements();
		$clientsModel = new Timemanagement_Model_Clients();
		
		if(count($elements)>0)
		{
			foreach($elements as $key=>$element)
			{
				if(($key!="Cancel")&&($key!="Edit")&&($key!="Delete")&&($key!="Attachments")){
					$element->setAttrib("disabled", "disabled");
				}
			}
		}
		if($id)
		{
			$data = $empjobhistoryModel->getsingleEmpJobHistoryData($id);
			if(!empty($data))
			{
				$positionheldArr = 'norows';
				if(is_numeric($data[0]['positionheld']))
				{
					$positionheldArr = $positionModel->getsinglePositionData($data[0]['positionheld']);
				}
				if($positionheldArr != 'norows'){
					$empjobhistoryform->positionheld->addMultiOption($positionheldArr[0]['id'],$positionheldArr[0]['positionname']);
					$data[0]['positionheld']=$positionheldArr[0]['positionname'];
				}
				else{
					$data[0]['positionheld']="";
				}
				$departmentArr = array();
				if(is_numeric($data[0]['department']))
				{
					$departmentArr = $departmentModel->getSingleDepartmentData($data[0]['department']);
				}
				if(!empty($departmentArr))
				{
					$empjobhistoryform->department->addMultiOption($departmentArr['id'],$departmentArr['deptname']);
					$data[0]['department']=$departmentArr['deptname'];
				}
				else
				{
					$data[0]['department']="";
				}
				$jobtitleArr = 'norows';
				if(is_numeric($data[0]['jobtitleid']))
				{				
					$jobtitleArr = $jobtitleModel->getsingleJobTitleData($data[0]['jobtitleid']);
				
					if($jobtitleArr !='norows')
					{
						$empjobhistoryform->jobtitleid->addMultiOption($jobtitleArr[0]['id'],$jobtitleArr[0]['jobtitlename']);
						$data[0]['jobtitleid']=$jobtitleArr[0]['jobtitlename'];
					}
					else
					{
						$data[0]['jobtitleid']="";
					}
				}
				$clientsArr = array();
				if(is_numeric($data[0]['client_id']))
				{				
					$clientsArr = $clientsModel->getClientDetailsById($data[0]['client_id']);
				}
				if(!empty($clientsArr))
				{
					$empjobhistoryform->client->addMultiOption($clientsArr[0]['id'],$clientsArr[0]['client_name']);
					$data[0]['client_id']=$clientsArr[0]['client_name'];
				}
                else
				{
					$data[0]['client_id']=  "";
				}					
				$empjobhistoryform->populate($data[0]);
				if(isset($data[0]['start_date']) && $data[0]['start_date'] !='')
				{
					$start_date = sapp_Global::change_date($data[0]['start_date'], 'view');
					$empjobhistoryform->start_date->setValue($start_date);
				}
				if(isset($data[0]['end_date']) && $data[0]['end_date'] !='')
				{
					$end_date = sapp_Global::change_date($data[0]['end_date'], 'view');
					$empjobhistoryform->end_date->setValue($end_date);
				}
               
			}
			$this->view->controllername = $objName;
			$this->view->id = $id;
			$this->view->data = $data[0];
			$this->view->form = $empjobhistoryform;
		}
	}

	public function editpopupAction()
	{
		Zend_Layout::getMvcInstance()->setLayoutPath(APPLICATION_PATH."/layouts/scripts/popup/");
		$auth = Zend_Auth::getInstance();
		if($auth->hasIdentity())
		{
			$loginUserId = $auth->getStorage()->read()->id;
		}
		$id = $this->getRequest()->getParam('id');
		$userid = $this->getRequest()->getParam('unitId');
		if($id == '')
		$id = $loginUserId;
		// For open the form in popup...
		$empjobhistoryform = new Default_Form_empjobhistory();
		$empjobhistoryModel = new Default_Model_Empjobhistory();
		$employeeModel = new Default_Model_Employee();
		$positionModel = new Default_Model_Positions();
		$departmentModel = new Default_Model_Departments();
		$jobtitleModel = new Default_Model_Jobtitles();
		$clientsModel = new Timemanagement_Model_Clients();
		
		if($id)
		{
			$employeeArr = $employeeModel->getActiveEmployeeData($userid);
			if(!empty($employeeArr))
			{
				if(isset($employeeArr[0]['businessunit_id']) && $employeeArr[0]['businessunit_id'] !='')
				{
					$departmentArr = $departmentModel->getDepartmentList($employeeArr[0]['businessunit_id']);
					if(!empty($departmentArr))
					{
						$empjobhistoryform->department->addMultiOption('','Select Department');
						foreach ($departmentArr as $departmentres){
							$empjobhistoryform->department->addMultiOption($departmentres['id'],$departmentres['deptname']);
						}
					}
				}else
				{
					$departmentArr = $departmentModel->getTotalDepartmentList();
					if(!empty($departmentArr))
					{
						$empjobhistoryform->department->addMultiOption('','Select Department');
						foreach ($departmentArr as $departmentres){
							$empjobhistoryform->department->addMultiOption($departmentres['id'],$departmentres['deptname']);

						}
					}
				}
			}

			$positionArr = $positionModel->getTotalPositionList();
			if(!empty($positionArr))
			{
				$empjobhistoryform->positionheld->addMultiOption('','Select Position');
				foreach ($positionArr as $positionres){
					$empjobhistoryform->positionheld->addMultiOption($positionres['id'],$positionres['positionname']);

				}
			}
			$jobtitleArr = $jobtitleModel->getJobTitleList();
			if(!empty($jobtitleArr))
			{
				$empjobhistoryform->jobtitleid->addMultiOption('','Select Job Title');
				foreach ($jobtitleArr as $jobtitleres){
					$empjobhistoryform->jobtitleid->addMultiOption($jobtitleres['id'],$jobtitleres['jobtitlename']);

				}
			}
			$clientsArr = $clientsModel->getActiveClientsData();
			if(!empty($clientsArr))
			{
				$empjobhistoryform->client->addMultiOption('','Select a Client');
				foreach ($clientsArr as $clientsres){
					$empjobhistoryform->client->addMultiOption($clientsres['id'],$clientsres['client_name']);
				}
			}			
			$data = $empjobhistoryModel->getsingleEmpJobHistoryData($id);
			if(!empty($data))
			{
				$empjobhistoryform->populate($data[0]);
				$empjobhistoryform->setDefault('department',$data[0]['department']);
				$empjobhistoryform->setDefault('positionheld',$data[0]['positionheld']);
				$empjobhistoryform->setDefault('jobtitleid',$data[0]['jobtitleid']);
				$empjobhistoryform->setDefault('client',$data[0]['client_id']);
				if(isset($data[0]['start_date']) && $data[0]['start_date'] !='')
				{
					$start_date = sapp_Global::change_date($data[0]['start_date'], 'view');
					$empjobhistoryform->start_date->setValue($start_date);
				}
				if(isset($data[0]['end_date']) && $data[0]['end_date'] !='')
				{
					$end_date = sapp_Global::change_date($data[0]['end_date'], 'view');
					$empjobhistoryform->end_date->setValue($end_date);
				}

			}
		}
		$empjobhistoryform->setAttrib('action',BASE_URL.'empjobhistory/editpopup/unitId/'.$userid);
		$this->view->form = $empjobhistoryform;
		$this->view->controllername = 'empjobhistory';

		if($this->getRequest()->getPost())
		{	
			$result = $this->save($empjobhistoryform,$userid);
			$this->view->msgarray = $result;
		}

	}


	public function save($emptypesform)
	{
            $auth = Zend_Auth::getInstance();
            if($auth->hasIdentity()){
                $loginUserId = $auth->getStorage()->read()->id;
                try {
                    $school_id = $auth->getStorage()->read()->school_id;
                }
                catch(Exception $e){
                }
            }
            $emptypesmodel = new Default_Model_Employeetypes();
            if($emptypesform->isValid($this->_request->getPost())){
                $id = $this->_request->getParam('id');
                $title = $this->_request->getParam('title');
                $description = $this->_request->getParam('description');
                $date = new Zend_Date();
                $actionflag = '';
                $tableid  = '';
                $data = array(
                    'title'=>trim($title),
                            'description'=>trim($description),
                                    'modified_date'=>gmdate("Y-m-d H:i:s")

                    );
			if($id!=''){
				$where = array('id=?'=>$id);
				$actionflag = 2;
			}
			else
			{
				$data['date_added'] = gmdate("Y-m-d H:i:s");
				$data['isActive'] = 1;
                                $data['school_id'] = $school_id;
				$where = '';
				$actionflag = 1;
			}
			$Id = $emptypesmodel->SaveorUpdateEmptypesData($data, $where);
			if($Id == 'update')
			{
				$tableid = $id;
				$this->_helper->getHelper("FlashMessenger")->addMessage(array("success"=>"Employee type updated successfully."));
			}
			else
			{
				$tableid = $Id;
				$this->_helper->getHelper("FlashMessenger")->addMessage(array("success"=>"Employee type added successfully."));
			}
			$menuID = POSITIONS;
			$result = sapp_Global::logManager($menuID,$actionflag,$loginUserId,$tableid);
			$this->_redirect('employeetypes');
		}else
		{
			$messages = $emptypesform->getMessages();
			foreach ($messages as $key => $val)
			{
				foreach($val as $key2 => $val2)
				{
					$msgarray[$key] = $val2;
					break;
				}
			}
			return $msgarray;

		}

	}
	
        public function deleteAction()
	{
		$auth = Zend_Auth::getInstance();
		if($auth->hasIdentity()){
			$loginUserId = $auth->getStorage()->read()->id;
		}
		$id = $this->_request->getParam('objid');
		$deleteflag=$this->_request->getParam('deleteflag');
		$messages['message'] = ''; $messages['msgtype'] = '';$messages['flagtype'] = '';
		$actionflag = 3;
		if($id)
		{
			$emptypesmodel = new Default_Model_Employeetypes();
			$data = array('isActive'=>'0','modified_date'=>gmdate("Y-m-d H:i:s"));
			$where = array('id=?'=>$id);
			$emptype_data = $emptypesmodel->getsingleEmployeeTypeData($id);
			$Id = $emptypesmodel->SaveorUpdateEmptypesData($data, $where);
			if($Id == 'update')
			{
				$messages['message'] = 'Employee type deleted successfully.';
				$messages['msgtype'] = 'success';
			}
			else
			{	 $messages['message'] = 'Employee type cannot be deleted.';
			$messages['msgtype'] = 'error';
			}
		}
		else
		{
			$messages['message'] = 'Employee type cannot be deleted.';
			$messages['msgtype'] = 'error';
		}
			// delete success message after delete in view
			if($deleteflag==1)
			{
				if(	$messages['msgtype'] == 'error')
				{
					$this->_helper->getHelper("FlashMessenger")->addMessage(array("error"=>$messages['message'],"msgtype"=>$messages['msgtype'] ,'deleteflag'=>$deleteflag));
				}
				if(	$messages['msgtype'] == 'success')
				{
					$this->_helper->getHelper("FlashMessenger")->addMessage(array("success"=>$messages['message'],"msgtype"=>$messages['msgtype'],'deleteflag'=>$deleteflag));
				}
			}
		$this->_helper->json($messages);

	}
}