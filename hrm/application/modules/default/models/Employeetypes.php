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

class Default_Model_Employeetypes extends Zend_Db_Table_Abstract
{
    protected $_name = 'main_employeetypes';
    protected $_primary = 'id';
	
	public function getEmployeetypesData($sort, $by, $pageNo, $perPage,$searchQuery)
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
            $where = "et.isActive = '1'";

            if($searchQuery)
                    $where .= " AND ".$searchQuery;
            
            if(!empty($school_id) && $school_id>0) {
                //$where .= " AND et.school_id = '".$school_id."' ";
            }
            
            $db = Zend_Db_Table::getDefaultAdapter();		

            $emptypesData = $this->select()
                                ->setIntegrityCheck(false)	
                                ->from(array('et'=>'main_employeetypes'),array('et.*'))
                                ->where($where)
                                ->order("$by $sort") 
                                ->limitPage($pageNo, $perPage);

            return $emptypesData;       		
	}
        
	public function getsingleEmployeeTypeData($id)
	{
            $db = Zend_Db_Table::getDefaultAdapter();
            $emptypeData = $db->query("SELECT * FROM main_employeetypes WHERE id = ".$id." AND isActive='1'");
            $res = $emptypeData->fetchAll();
            if (isset($res) && !empty($res)) 
            {	
                    return $res;
            }
            else
                    return 'norows';
	}
	
	public function SaveorUpdateEmptypesData($data, $where)
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
                $id=$this->getAdapter()->lastInsertId('main_employeetypes');
                return $id;
            }
	}
        
        public function getEmptypesOptions()
        {
            return $this->fetchAll("isActive = '1'")->toArray();
        }
		
	public function getEmptypesList()
	{
            if(!empty($jobtitle_id))
            {
                $select = $this->select()
                            ->setIntegrityCheck(false)
                            ->from(array('et'=>'main_employeetypes'),array('et.id','et.title'))
                            ->where("et.isActive = '1'")
                            ->order('et.title');
                
                return $this->fetchAll($select)->toArray();
            }
            else 
                return array();
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
		$objName = 'employeetypes';
		
		$tableFields = array('action'=>'Action','title' => 'Employee Type','description' => 'Description');
		$tablecontent = $this->getEmployeetypesData($sort, $by, $pageNo, $perPage,$searchQuery);     
		
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
			'add' =>'add','call'=>$call,'dashboardcall'=>$dashboardcall
		);			
		return $dataTmp;
	}
	       
}