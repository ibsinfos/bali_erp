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

class Default_Model_Payrollgroup extends Zend_Db_Table_Abstract
{
    protected $_name = 'payroll_groups';
    protected $_primary = 'payroll_group_id';		

    public function getAllGroups(){
        $db = Zend_Db_Table::getDefaultAdapter();
        $groupData = $db->query("SELECT * FROM payroll_groups WHERE status=1");
        $rsGroupData = $groupData->fetchAll();
        return $rsGroupData;
    }
    
    public function get_payroll_group_code(){
        $db = Zend_Db_Table::getDefaultAdapter();
        $catData = $db->query("SELECT * FROM payroll_category WHERE status=1 AND emp_id IS NULL");
        $rsCateResult = $catData->fetchAll();
        return $rsCateResult;
    }
    
    public function get_payroll_group_code_emp($userid){
        $db = Zend_Db_Table::getDefaultAdapter();
        $catData = $db->query("SELECT * FROM payroll_category WHERE status=1 AND emp_id = '".$userid."'");
        $rsCateResult = $catData->fetchAll();
        return $rsCateResult;
    }
    
    function is_name_exist($name){
        $db = Zend_Db_Table::getDefaultAdapter();
        $nameData = $db->query("SELECT * FROM payroll_groups WHERE `name`='".$name."' AND status=1");
        $rsNammeResult = $nameData->fetchAll();
        return $rsNammeResult;
    }
    
    function is_group_name_code_exist($code){
        $db = Zend_Db_Table::getDefaultAdapter();
        $nameData = $db->query("SELECT * FROM payroll_groups WHERE `payroll_group_code`='".$code."' AND status=1");
        $rsNammeResult = $nameData->fetchAll();
        return $rsNammeResult;
    }
    
    function save_payroll_group($dataArr,$id){
        $db = Zend_Db_Table::getDefaultAdapter();
        $nameData = $db->query("SELECT * FROM payroll_group_category WHERE `group_id`='".$id."'");
        $rsNammeResult = $nameData->fetchAll();
        if(!empty($rsNammeResult))
            return FALSE;
        
        $payroll_group_code=$dataArr['payroll_group_codes'];
        unset($dataArr['payroll_group_codes']);
        /*$this->insert($dataArr);
        $group_id=$this->getAdapter()->lastInsertId('payroll_groups');
        $db = Zend_Db_Table::getDefaultAdapter();
        //$payroll_group_code_arr= explode(',', $payroll_group_code);*/
        $payroll_group_code_arr= $payroll_group_code;
        foreach ($payroll_group_code_arr As $k => $v){
            //$sql="SELECT `payroll_category_id` FROM `payroll_category` WHERE `code`='".$v."' AND status=1";
            //$queryObj = $db->query($sql);
            //$rs = $queryObj->fetchAll();
            $dbInsert = new Zend_Db_Table(array('name' =>'payroll_group_category'));
            //$insDataArr=array('group_id'=>$group_id,'category_id'=>$rs[0]['payroll_category_id']);
            $insDataArr=array('group_id'=>$id,'category_id'=>$v);
            $dbInsert->insert($insDataArr);
        }
        return TRUE;
    }
    
    function update_payroll_group($dataArr,$id){
        //error_reporting(E_ALL|E_STRICT);
        //ini_set('display_errors', 'on');
        $payroll_group_code=$dataArr['payroll_group_codes'];
        unset($dataArr['payroll_group_codes']);
        $db = Zend_Db_Table::getDefaultAdapter();
        //$where = $this->getAdapter()->quoteInto('payroll_group_id = ?', $id);
        $where1 = $this->getAdapter()->quoteInto('group_id = ?', $id);
        //echo $where1;die;
        //print_r($dataArr);die;
        /*$sql="UPDATE `payroll_groups` SET ";
        $SetStr="";
        foreach ($dataArr AS $k => $v){
            $SetClearStr=$this->getAdapter()->quoteInto($k.' = ?', $v);
            if($SetStr==""){
                $SetStr=$SetClearStr;
            }else{
                $SetStr.=",".$SetClearStr;
            }
        }
        $sql.=$SetStr." WHERE ".$where;
        $db->query($sql);*/
        $payroll_group_code_arr= $payroll_group_code;
        if(!empty($payroll_group_code_arr)){
            $sql="DELETE FROM `payroll_group_category` WHERE $where1";
            //die($sql);
            $db->query($sql);
            foreach ($payroll_group_code_arr As $k => $v){
                $dbInsert = new Zend_Db_Table(array('name' =>'payroll_group_category'));
                $insDataArr=array('group_id'=>$id,'category_id'=>$v);
                $dbInsert->insert($insDataArr);
            }
        }
    }
    
    function delete_data($id){
        $db = Zend_Db_Table::getDefaultAdapter();
        //$sql="UPDATE `payroll_groups` SET `status`=2 WHERE `payroll_group_id`='".$id."'";
        //echo $sql;die;
        //$db->query($sql);
        $where = $this->getAdapter()->quoteInto('payroll_group_id = ?', $id);
        $where1 = $this->getAdapter()->quoteInto('group_id = ?', $id);
        $this->delete($where);
        $sql="DELETE FROM `payroll_group_category` WHERE $where1";
        $db->query($sql);
        return TRUE;
    }
    
    function get_details_by_id($id){
        $db = Zend_Db_Table::getDefaultAdapter();
        $detailsArr = $db->query("SELECT * FROM payroll_groups WHERE `payroll_group_id`='".$id."' AND status=1");
        $rsDetails = $detailsArr->fetchAll();
        return $rsDetails;
    }
    
    function get_category_details_by_id($id){
        $db = Zend_Db_Table::getDefaultAdapter();
        $sql="SELECT pc.* FROM payroll_group_category AS pgc JOIN payroll_category AS pc ON(pgc.category_id=pc.payroll_category_id) WHERE pgc.group_id='".$id."'";
        //die($sql);
        $detailsArr = $db->query($sql);
        $rsDetails = $detailsArr->fetchAll();
        return $rsDetails;
    }
    
    function get_all_main_roles(){
        $db = Zend_Db_Table::getDefaultAdapter();
        $sql="SELECT * FROM  main_roles";

        $detailsArr = $db->query($sql);
        $rsDetails = $detailsArr->fetchAll();
        return $rsDetails;
    }
    
    function get_main_roll_details($id){
        $db = Zend_Db_Table::getDefaultAdapter();
        $sql="SELECT * FROM  main_roles WHERE id='".$id."'";
        //die($sql);
        $detailsArr = $db->query($sql);
        $rsDetails = $detailsArr->fetchAll();
        return $rsDetails;   
    }
    
    function get_roll_details_by_id($id){
        $db = Zend_Db_Table::getDefaultAdapter();
        $sql="SELECT * FROM  main_roles WHERE id=".$id;
        //die($sql);
        $detailsArr = $db->query($sql);
        $rsDetails = $detailsArr->fetchAll();
        return $rsDetails;   
    }
    
    function delete_roll_category_data($id){
        $db = Zend_Db_Table::getDefaultAdapter();
        $where1 = $this->getAdapter()->quoteInto('group_id = ?', $id);
        $sql="DELETE FROM `payroll_group_category` WHERE $where1";
        $db->query($sql);
        return TRUE;
    }
    
    public function getGrid($sort,$by,$perPage,$pageNo,$searchData,$call,$dashboardcall,$exParam1='',$exParam2='',$exParam3='',$exParam4='')
    {
        $searchQuery = '';
        $tablecontent = '';
        $emptyroles=0;
        $searchArray = array();
        $data = array();
        $id='';
        $dataTmp = array();
        
    	$auth = Zend_Auth::getInstance();
    	$request = Zend_Controller_Front::getInstance();
     	if($auth->hasIdentity()){
            $loginUserGroup = $auth->getStorage()->read()->group_id;
            $loginUserRole = $auth->getStorage()->read()->emprole;
        }

        if($searchData != '' && $searchData!='undefined')
        {
            $searchValues = json_decode($searchData);
			
            foreach($searchValues as $key => $val)
            {				
                $searchQuery .= $key." like '%".$val."%' AND ";				
                $searchArray[$key] = $val;
            }
            $searchQuery = rtrim($searchQuery," AND");					
        }
        $objName = 'payrollgroup';
				        
        $tableFields = array('action'=>'Action','rolename'=>'Name');
		   
        $tablecontent = $this->getPayrollGroupsData($sort,$by,$pageNo,$perPage,$searchQuery,'',$exParam1);  
		
        $dataTmp = array(
                        'userid'=>$id,
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
                        'menuName' => 'Payroll Main Roles',
                        'dashboardcall'=>$dashboardcall,
                        'add'=>'add',
                        'call'=>$call,
                        'search_filters' => array(
                            'astatus' => array('type'=>'select',
                            'filter_data'=>$filterArray))
                        );	
        return $dataTmp;
    }
    
    public function getPayrollGroupsData($sort,$by,$pageNo,$perPage,$searchQuery,$managerid='',$loginUserId)
    {
    	$auth = Zend_Auth::getInstance();
    	$request = Zend_Controller_Front::getInstance();
     	if($auth->hasIdentity()){
            $loginUserGroup = $auth->getStorage()->read()->group_id;
            $loginUserRole = $auth->getStorage()->read()->emprole;
        }
	
        $controllerName = $request->getRequest()->getControllerName();
        //the below code is used to get data of employees from summary table.
        $payrollGroupData=""; 

        $where = " ";

        if($searchQuery != '')
            $where .= " AND ".$searchQuery;
        if(trim($where)!="" )
            $where.=" AND mr.isactive=1";
        else
            $where.=" mr.isactive=1";
        
       //echo 
        $payrollGroupData = $this->select()
                                ->setIntegrityCheck(false)	
                                ->from(
                                        array('mr' => 'main_roles'),'*')
                                ->where($where)
                                ->order("$by $sort")
                                ->limitPage($pageNo, $perPage);
       //die;
        
        return $payrollGroupData;       		
    }
    
}