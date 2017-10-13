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

class Default_PayslipgenerateController extends Zend_Controller_Action
{ 
    
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

    public function indexAction(){
        $auth = Zend_Auth::getInstance();
        $popConfigPermission = array();
        if($auth->hasIdentity()){
            $loginUserId = $auth->getStorage()->read()->id;
            $loginuserRole = $auth->getStorage()->read()->emprole;
            $loginuserGroup = $auth->getStorage()->read()->group_id;
        }
        
        $PayslipgenerateModel = new Default_Model_Payslipgenerate();
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
        $AllEmployee=$PayslipgenerateModel->getAllEmployees($loginUserId);
        $this->view->AllEmployee=$AllEmployee;    
    }

    public function preparepayslipAction(){
    	echo 'hello';die;
    }
	
}

