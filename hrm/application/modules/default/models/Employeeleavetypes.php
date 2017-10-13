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

class Default_Model_Employeeleavetypes extends Zend_Db_Table_Abstract
{
    protected $_name = 'main_employeeleavetypes';
    protected $_primary = 'id';
	
	public function getEmployeeLeaveData($sort, $by, $pageNo, $perPage,$searchQuery)
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
		
		if($searchQuery)
			$where .= " AND ".$searchQuery;
                
                if(!empty($school_id) && $school_id>0) {
                    $where .= " AND e.school_id = '".$school_id."' ";
                }
                
		$db = Zend_Db_Table::getDefaultAdapter();		
		
		$employeeLeaveData = $this->select()
    					   ->setIntegrityCheck(false)	
                           ->from(array('e'=>'main_employeeleavetypes'),array('e.id','e.numberofdays','e.isactive','e.leavetype','e.leavecode','leavepreallocated'=>'if(e.leavepreallocated=1,"Yes","No")','leavepredeductable'=>'if(e.leavepredeductable=1,"Yes","No")','e.description'))						   
						   ->where($where)
    					   ->order("$by $sort") 
    					   ->limitPage($pageNo, $perPage);
		
		return $employeeLeaveData;       		
	}
	public function getsingleEmployeeLeavetypeData($id)
	{
		
		$db = Zend_Db_Table::getDefaultAdapter();
		$leaveData = $db->query("SELECT * FROM main_employeeleavetypes WHERE id = ".$id." AND isactive=1");
		$res = $leaveData->fetchAll();
		if (isset($res) && !empty($res)) 
		{	
			return $res;
		}
		else
			return 'norows';
	}
	
	public function getLeavetypeDataByID($id)
	{
	    $select = $this->select()
						->setIntegrityCheck(false)
						->from(array('e'=>'main_employeeleavetypes'),array('e.*'))
					    ->where('e.isactive = 1 AND e.id='.$id.' ');
		return $this->fetchAll($select)->toArray();
	
	}
	
	public function SaveorUpdateEmployeeLeaveTypeData($data, $where)
	{
            $auth = Zend_Auth::getInstance();
            if($auth->hasIdentity()){
                try {
                    $school_id = $auth->getStorage()->read()->school_id;
                }
                catch(Exception $e){
                }
            }
            
            if($where != ''){
                    $this->update($data, $where);
                    return 'update';
            } else {
                    $data['school_id'] = $school_id;
                    $this->insert($data);
                    $id=$this->getAdapter()->lastInsertId('main_employeeleavetypes');
                    return $id;
            }

	}
	
	public function getactiveleavetype()
	{
	 	$select = $this->select()
    					   ->setIntegrityCheck(false)	
                           ->from(array('e'=>'main_employeeleavetypes'),array('e.id','e.leavetype','e.numberofdays','e.leavepredeductable'))
						   ->where('e.isactive = 1');  		   					   				
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
		$objName = 'employeeleavetypes';
		
		$tableFields = array('action'=>'Action','leavetype' => 'Leave Type','numberofdays' => 'Number Of Days','leavecode'=>'Leave Code','leavepreallocated'=>'Is Pre Allocated','leavepredeductable'=>'Is Deductible','description' => 'Description');
		
		$bool_arr = array('' => 'All',1 => 'Yes',2 => 'No');	
		$tablecontent = $this->getEmployeeLeaveData($sort, $by, $pageNo, $perPage,$searchQuery);
		
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
			'dashboardcall'=>$dashboardcall,
			'searchArray' => $searchArray,
                        'call'=>$call,
                        'search_filters' => array(
                           'leavepreallocated' => array(
                               'type' => 'select',
                               'filter_data' => $bool_arr,
                           ), 
                            'leavepredeductable' => array(
                               'type' => 'select',
                               'filter_data' => $bool_arr,
                           ), 
                        ),
			);			    
				
		return $dataTmp;
	}
	
	public function checkDuplicateLeaveType($leaveTypeName)
	{
		$db = Zend_Db_Table::getDefaultAdapter();
		$qry = "select count(*) as count from main_employeeleavetypes el where el.leavetype='".$leaveTypeName."' AND el.isactive=1 ";
		$res = $db->query($qry)->fetchAll();
		return $res;
	}
}