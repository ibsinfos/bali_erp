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

class Default_AuthoritiesController extends Zend_Controller_Action
{

	private $options;
	public function preDispatch()
	{

	}

	public function init()
	{
		$this->_options= $this->getInvokeArg('bootstrap')->getOptions();
	}
	
        public function indexAction()
	{
//            error_reporting(E_ALL);
//            ini_set('display_errors', 1);
            $authoritiesmodel = new Default_Model_Authorities();
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

                $sort = 'DESC';$by = 'a.modified_date';$pageNo = 1;$searchData = '';$searchQuery = '';
                $searchArray = array();
            }
            else
            {
                $sort = ($this->_getParam('sort') !='')? $this->_getParam('sort'):'DESC';
                $by = ($this->_getParam('by')!='')? $this->_getParam('by'):'a.modified_date';
                if($dashboardcall == 'Yes')
                $perPage = $this->_getParam('per_page',DASHBOARD_PERPAGE);
                else
                $perPage = $this->_getParam('per_page',PERPAGE);

                $pageNo = $this->_getParam('page', 1);
                $searchData = $this->_getParam('searchData');
                $searchData = rtrim($searchData,',');
            }
            $dataTmp = $authoritiesmodel->getGrid($sort,$by,$perPage,$pageNo,$searchData,$call,$dashboardcall);
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

            $authoritiesform = new Default_Form_authorities();
            $authoritiesform->setAttrib('action',BASE_URL.'authorities/add');
            $authoritiesmodel = new Default_Model_Authorities();
            
            $this->view->form = $authoritiesform;

            if($this->getRequest()->getPost())
            {
                    $msgarray = $this->save($authoritiesform);			
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

		$authoritiesform = new Default_Form_authorities();
		$authoritiesform->submit->setLabel('Update');
		$authoritiesmodel = new Default_Model_Authorities();
		$objName = 'authorities';
		try
		{
			if($id)
			{
				$data = $authoritiesmodel->getsingleAuthorityData($id);
				
				if(!empty($data) && $data != 'norows')
				{
					$authoritiesform->populate($data[0]);
					$this->view->form = $authoritiesform;
					$this->view->controllername = $objName;
					$this->view->id = $id;
					$this->view->ermsg = '';
					$authoritiesform->setAttrib('action',BASE_URL.'authorities/edit');
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
			$result = $this->save($authoritiesform);
			$this->view->msgarray = $result;
		}
	}
        
	public function viewAction()
	{
		$id = $this->getRequest()->getParam('id');
		$callval = $this->getRequest()->getParam('call');
		if($callval == 'ajaxcall')
		$this->_helper->layout->disableLayout();
		$objName = 'authorities';
		$authoritiesform = new Default_Form_authorities();
		$authoritiesform->removeElement("submit");
		$authoritiesmodel = new Default_Model_Authorities();

		$elements = $authoritiesform->getElements();
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
				$data = $authoritiesmodel->getsingleAuthorityData($id);
					
				if(!empty($data) && $data != 'norows')
				{
					$authoritiesform->populate($data[0]);
					
					$this->view->form = $authoritiesform;
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

	public function save($authoritiesform)
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
            $authoritiesmodel = new Default_Model_Authorities();
            if($authoritiesform->isValid($this->_request->getPost())){
                $id = $this->_request->getParam('id');
                $name = $this->_request->getParam('name');
                $description = $this->_request->getParam('description');

                $actionflag = '';
                $tableid  = '';
                $data = array(
                    'name'=>trim($name),
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
			$Id = $authoritiesmodel->SaveorUpdateAuthorityData($data, $where);
			if($Id == 'update')
			{
				$tableid = $id;
				$this->_helper->getHelper("FlashMessenger")->addMessage(array("success"=>"Authority updated successfully."));
			}
			else
			{
				$tableid = $Id;
				$this->_helper->getHelper("FlashMessenger")->addMessage(array("success"=>"Authority added successfully."));
			}
			$menuID = AUTHORITIES;
			$result = sapp_Global::logManager($menuID,$actionflag,$loginUserId,$tableid);
			$this->_redirect('authorities');
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
			$authoritiesmodel = new Default_Model_Authorities();
			$data = array('isActive'=>'0','modified_date'=>gmdate("Y-m-d H:i:s"));
			$where = array('id=?'=>$id);
			$authority_data = $authoritiesmodel->getsingleAuthorityData($id);
			$Id = $authoritiesmodel->SaveorUpdateAuthorityData($data, $where);
			if($Id == 'update')
			{
				$messages['message'] = 'Authority deleted successfully.';
				$messages['msgtype'] = 'success';
			}
			else
			{	 $messages['message'] = 'Authority cannot be deleted.';
                                 $messages['msgtype'] = 'error';
			}
		}
		else
		{
			$messages['message'] = 'Authority cannot be deleted.';
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