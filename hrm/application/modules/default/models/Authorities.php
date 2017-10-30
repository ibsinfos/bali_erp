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

class Default_Model_Authorities extends Zend_Db_Table_Abstract
{
    protected $_name = 'main_authorities';
    protected $_primary = 'id';
	
	public function getAuthoritiesData($sort, $by, $pageNo, $perPage,$searchQuery)
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
            $where = "a.isActive = '1'";

            if($searchQuery)
                    $where .= " AND ".$searchQuery;
            
            if(!empty($school_id) && $school_id>0) {
                //$where .= " AND et.school_id = '".$school_id."' ";
            }
            
            $db = Zend_Db_Table::getDefaultAdapter();		

            $authoritiesData = $this->select()
                                ->setIntegrityCheck(false)	
                                ->from(array('a'=>'main_authorities'),array('a.*'))
                                ->where($where)
                                ->order("$by $sort") 
                                ->limitPage($pageNo, $perPage);

            return $authoritiesData;       		
	}
        
	public function getsingleAuthorityData($id)
	{
            $db = Zend_Db_Table::getDefaultAdapter();
            $authorityData = $db->query("SELECT * FROM main_authorities WHERE id = ".$id." AND isActive='1'");
            $res = $authorityData->fetchAll();
            if (isset($res) && !empty($res)) 
            {	
                    return $res;
            }
            else
                    return 'norows';
	}
	
	public function SaveorUpdateAuthorityData($data, $where)
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
                $id=$this->getAdapter()->lastInsertId('main_authorities');
                return $id;
            }
	}
        
        public function getAuthoritiesOptions()
        {
            return $this->fetchAll("isActive = '1'")->toArray();
        }
		
	public function getAuthoritiesList()
	{
            $select = $this->select()
                        ->setIntegrityCheck(false)
                        ->from(array('a'=>'main_authorities'),array('a.id','a.name'))
                        ->where("a.isActive = '1'")
                        ->order('a.name');

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
		$objName = 'authorities';
		
		$tableFields = array('action'=>'Action','name' => 'Authority Name','description' => 'Description');
		$tablecontent = $this->getAuthoritiesData($sort, $by, $pageNo, $perPage,$searchQuery);     
		
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