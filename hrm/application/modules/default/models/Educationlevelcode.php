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

class Default_Model_Educationlevelcode extends Zend_Db_Table_Abstract
{
    protected $_name = 'main_educationlevelcode';
    protected $_primary = 'id';
	
	public function getEducationLevelCodeData($sort, $by, $pageNo, $perPage,$searchQuery)
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
            $where = "isactive = 1";
		
            if(!empty($school_id) && $school_id>0) {
                $where .= " AND school_id = '".$school_id."' ";
            }
            
            if($searchQuery)
                    $where .= " AND ".$searchQuery;
            $db = Zend_Db_Table::getDefaultAdapter();		

            $educationLevelCodeData = $this->select()
                                       ->setIntegrityCheck(false)	    					
                                               ->where($where)
                                       ->order("$by $sort") 
                                       ->limitPage($pageNo, $perPage);

            return $educationLevelCodeData;       		
	}
	public function getsingleEducationLevelCodeData($id)
	{
		
		
		$db = Zend_Db_Table::getDefaultAdapter();
		$eduLevelData = $db->query("SELECT * FROM main_educationlevelcode WHERE id = ".$id." AND isactive=1");
		$res = $eduLevelData->fetchAll();
		if (isset($res) && !empty($res)) 
		{	
			return $res;
		}
		else
			return 'norows';
		
	}
	
	public function SaveorUpdateEducationlevelData($data, $where)
	{
	    if($where != ''){
			$this->update($data, $where);
			return 'update';
		} else {
			$this->insert($data);
			$id=$this->getAdapter()->lastInsertId('main_educationlevelcode');
			return $id;
		}
		
	
	}
	
	public function getEducationlevelData()
	{
	  $select = $this->select()
						->setIntegrityCheck(false)
						->from(array('ed'=>'main_educationlevelcode'),array('ed.id','ed.educationlevelcode'))
					    ->where('ed.isactive = 1')
						->order('ed.educationlevelcode');
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
		$objName = 'educationlevelcode';
		
		$tableFields = array('action'=>'Action','educationlevelcode' => 'Education Level','description' => 'Description');
				
		$tablecontent = $this->getEducationLevelCodeData($sort, $by, $pageNo, $perPage,$searchQuery);      
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