<?php
/********************************************************************************* 
 *  This file is part of Sentrifugo.
 *  Copyright (C) 2014 Sapplica
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

class Default_Model_Employmentstatus extends Zend_Db_Table_Abstract
{
    protected $_name = 'main_employmentstatus';
    protected $_primary = 'id';
	
	public function getEmploymentstatusData($sort, $by, $pageNo, $perPage,$searchQuery)
	{
            $auth = Zend_Auth::getInstance();
            if($auth->hasIdentity()){
                $loginUserId = $auth->getStorage()->read()->id;
                $loginuserGroup = $auth->getStorage()->read()->group_id;
                try {
                    $school_id = $auth->getStorage()->read()->school_id;
                }
                catch(Exception $e){
                }
            }

            $where = "e.isactive = 1";
            
            if(!empty($school_id) && $school_id>0) {
                $where .= " AND e.school_id = '".$school_id."' ";
            }
            
            if($searchQuery)
                    $where .= " AND ".$searchQuery;
            $db = Zend_Db_Table::getDefaultAdapter();		

           $employmentstatus = $this->select()
                                    ->setIntegrityCheck(false)
                                    ->from(array('e'=>'main_employmentstatus'),array( 'e.*'))
                                    ->joinLeft(array('es'=>'tbl_employmentstatus'), 'es.id=e.workcodename',array('employemnt_status'=>'es.employemnt_status'))  						   
                                    ->where($where)
                                    ->order("$by $sort") 
                                    ->limitPage($pageNo, $perPage);

            return $employmentstatus;       
	}
	public function getsingleEmploymentstatusData($id)
	{
		$row = $this->fetchRow("id = '".$id."' and isactive = 1");
		if (!$row) {
			
                    return array();
		}
                else
		return $row->toArray();
	}
        
       
	
	public function SaveorUpdateEmploymentStatusData($data, $where)
	{
            $auth = Zend_Auth::getInstance();
            if($auth->hasIdentity()){
                $school_id = $auth->getStorage()->read()->school_id;
            }
	    if($where != ''){
                $this->update($data, $where);
                return 'update';
            } else {
                $data['school_id'] = $school_id;
                $this->insert($data);
                $id=$this->getAdapter()->lastInsertId('main_employmentstatus');
                return $id;
            }	
	}
        /**
         * This function is used to get array of employement status for drop down list.
         * 
         * @return Array Array of employement status with names and ids.
         */
        public function getEmpStatusOptions()
        {
            $data = $this->fetchAll("isactive = 1")->toArray();
            $options = array();
            foreach($data as $emp)
            {
                $options[$emp['id']] = $emp['workcodename'];
            }
            return $options;
        }
		
        public function getEmploymentStatuslist()
        {
            $auth = Zend_Auth::getInstance();
            if($auth->hasIdentity()){
                $loginUserId = $auth->getStorage()->read()->id;
                $loginuserGroup = $auth->getStorage()->read()->group_id;
                try {
                    $school_id = $auth->getStorage()->read()->school_id;
                }
                catch(Exception $e){
                }
            }

            if(!empty($school_id) && $school_id>0) {
                $where = " AND e.school_id = '".$school_id."' ";
            }
            $select = $this->select()
                            ->setIntegrityCheck(false)
                            ->from(array('e'=>'main_employmentstatus'),array('e.id','e.workcodename','e.default_leaves','e.workcode'))
                            ->where('e.isactive = 1'.$where)
                            ->order('e.workcodename');
                return $this->fetchAll($select)->toArray();

        }
		
        public function getStatuslist($empstatusstr)
        {
            if($empstatusstr !='')
            $params = explode(",",$empstatusstr);

            $select = $this->select()
                        ->setIntegrityCheck(false)
                        ->from(array('e'=>'tbl_employmentstatus'),array('e.*'))
                        ->where('e.isactive = 1 AND id NOT IN(?)', $params)
                        ->order('e.employemnt_status');
            return $this->fetchAll($select)->toArray();
      }
		
        public function getCompleteStatuslist()
        {
            $select = $this->select()
                            ->setIntegrityCheck(false)
                            ->from(array('e'=>'tbl_employmentstatus'),array('e.*'))
                            ->where('e.isactive = 1 ')
                            ->order('e.employemnt_status');
            return $this->fetchAll($select)->toArray();


        }
		
		public function getParticularStatusName($id)
		{
		  $select = $this->select()
						->setIntegrityCheck(false)
						->from(array('e'=>'tbl_employmentstatus'),array('e.*'))
					    ->where('e.isactive = 1 AND e.id ='.$id.' ');
		  return $this->fetchAll($select)->toArray();
		
		}
		
		public function getEmpUserId($id)
		{
		 $select = $this->select()
						->setIntegrityCheck(false)
						->from(array('e'=>'main_employees'),array('e.user_id'))
					    ->where('e.isactive = 1 AND e.emp_status_id ='.$id.' ');
		  return $this->fetchAll($select)->toArray();
		}
		
		public function UpdateEmpLeaves($querystring)
		{
		  $db = Zend_Db_Table::getDefaultAdapter();
          
			$query =  "".$querystring." " ;		  
			$result = $db->query($query);
		
		}
		
		public function getempstatuslist()
		{
                    $auth = Zend_Auth::getInstance();
                    if($auth->hasIdentity()){
                        $loginUserId = $auth->getStorage()->read()->id;
                        $loginuserGroup = $auth->getStorage()->read()->group_id;
                        try {
                            $school_id = $auth->getStorage()->read()->school_id;
                        }
                        catch(Exception $e){
                        }
                    }
                    $select = $this->select()
                            ->setIntegrityCheck(false)
                            ->from(array('e'=>'main_employmentstatus'),array('e.*'))
                            ->joinLeft(array('es'=>'tbl_employmentstatus'), 'es.id=e.workcodename',array('statusname'=>'es.employemnt_status'))                                      ->where("e.isactive = 1 AND e.school_id = '".$school_id."'");
			return $this->fetchAll($select)->toArray();
		
		}
		
		public function getempstatusActivelist()
		{
                    $auth = Zend_Auth::getInstance();
                    if($auth->hasIdentity()){
                        $loginUserId = $auth->getStorage()->read()->id;
                        $loginuserGroup = $auth->getStorage()->read()->group_id;
                        try {
                            $school_id = $auth->getStorage()->read()->school_id;
                        }
                        catch(Exception $e){
                        }
                    }

		   $statusArr =array(8,9,10);
		   $select = $this->select()
							->setIntegrityCheck(false)
							->from(array('e'=>'main_employmentstatus'),array('e.*'))
							->joinLeft(array('es'=>'tbl_employmentstatus'), 'es.id=e.workcodename',array('statusname'=>'es.employemnt_status'))  						   
							->where("e.isactive = '1' AND es.id NOT IN(?) AND e.school_id = '".$school_id."'",$statusArr)
							->order('es.employemnt_status');
			return $this->fetchAll($select)->toArray();
		
		}
		
	public function getEmploymentStatusName($empstatusids)
	{
	   $empstatusArr = array();	
	   if($empstatusids !='')
	   $empstatusArr = explode(",",$empstatusids);
	   
	   $select = $this->select()
						->setIntegrityCheck(false)
						->from(array('e'=>'main_employmentstatus'),array('e.*'))
						->joinLeft(array('es'=>'tbl_employmentstatus'), 'es.id=e.workcodename',array('statusname'=>'es.employemnt_status'))  						   
						->where('e.isactive = 1 AND es.id IN(?)',$empstatusArr)
						->order('es.employemnt_status');
		return $this->fetchAll($select)->toArray(); 
	
	}
	public function getGrid($sort,$by,$perPage,$pageNo,$searchData,$call,$dashboardcall,$exParam1='',$exParam2='',$exParam3='',$exParam4='')
	{		
        $searchQuery = '';$tablecontent = '';  $searchArray = array();$data = array();$id='';
        $dataTmp = array();
		if($searchData != '' && $searchData!='undefined')
		{
			$searchValues = json_decode($searchData);
			foreach($searchValues as $key => $val)
			{
				$searchQuery .= " ".$key." like '%".$val."%' AND ";
				$searchArray[$key] = $val;
			}
			$searchQuery = rtrim($searchQuery," AND");					
		}

		/** search from grid - END **/
		$objName = 'employmentstatus';
				
		$tableFields = array('action'=>'Action','employemnt_status' =>'Work Code','workcode' => 'Work Short Code','description' => 'Description');
		
		$tablecontent = $this->getEmploymentstatusData($sort, $by,$pageNo,$perPage,$searchQuery);     
		$dataTmp = array(
			'sort' => $sort,
			'by' => $by,
			'pageNo' => $pageNo,
			'perPage' => $perPage,				
			'tablecontent' => $tablecontent,
			'objectname' => $objName,
			'extra' => array(),
			'tableheader' => $tableFields,
			'jsGridFnName' => 'getAjaxgridData',
			'jsFillFnName' => '',
			'searchArray' => $searchArray,
			'call'=>$call,'dashboardcall'=>$dashboardcall
		);		
			
		return $dataTmp;
	}
		
}