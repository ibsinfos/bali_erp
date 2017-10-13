<?php

/* * ******************************************************************************* 
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
 * ****************************************************************************** */

class Default_Model_Payrollcategory extends Zend_Db_Table_Abstract {

    protected $_name = 'payroll_category';
    protected $_primary = 'payroll_category_id';

    public function getAllEarnings() {
        $db = Zend_Db_Table::getDefaultAdapter();
        $query="SELECT pc.`payroll_category_id`,pc.`name`, pc.`code`,pc.`type`, pv.`payroll_value_id`,pv.`value_type_id`, "
                . " (case "
                . " when (pv.`value_type_id` = 0) THEN "
                . "     ( SELECT pvn.`amount` FROM `payroll_value_numeric` AS pvn WHERE pvn.`value_category_id`=pv.`value_category_id` ) "
                . " when (pv.`value_type_id` = 1) THEN "
                . "     ( SELECT pvf.`formula` FROM `payroll_value_formula` AS pvf WHERE pvf.`value_category_id`=pv.`value_category_id` ) "
                . " when (`value_type_id` = 2) THEN "
                . "     ( SELECT pvc.`value_category_id` FROM `payroll_value_condition` AS pvc WHERE pvc.`value_category_id`=pv.`value_category_id`) "
                . " END) as value_formula "
                . " FROM `payroll_category` AS pc, `payroll_value` AS pv "
                . " WHERE pc.`payroll_category_id`=pv.`payroll_category_id` AND pc.`type`=0 ";
        //die($query);
        $usersData = $db->query($query);
        $usersResult = $usersData->fetchAll();
         $i = 0;
        foreach ($usersResult as $user) {
            if ($user['value_type_id'] == 2) {
                $condition = $this->get_condition($user['value_formula']);
                $output= "if ".$condition['if']." ".$condition['operator']. " ".$condition['condition']." then ".$condition['then'] ;
                $usersResult[$i]['value_formula'] = $output;
            }
            $i++;
        }

        return $usersResult;
    }

    public function getAllDeductions() {
        $db = Zend_Db_Table::getDefaultAdapter();
        $query="SELECT pc.`payroll_category_id`,pc.`name`, pc.`code`,pc.`type`, pv.`payroll_value_id`,pv.`value_type_id`, "
                . " (case "
                . " when (pv.`value_type_id` = 0) THEN "
                . "     ( SELECT pvn.`amount` FROM `payroll_value_numeric` AS pvn WHERE pvn.`value_category_id`=pv.`value_category_id` ) "
                . " when (pv.`value_type_id` = 1) THEN "
                . "     ( SELECT pvf.`formula` FROM `payroll_value_formula` AS pvf WHERE pvf.`value_category_id`=pv.`value_category_id` ) "
                . " when (`value_type_id` = 2) THEN "
                . "     ( SELECT pvc.`value_category_id` FROM `payroll_value_condition` AS pvc WHERE pvc.`value_category_id`=pv.`value_category_id`) "
                . " END) as value_formula "
                . " FROM `payroll_category` AS pc, `payroll_value` AS pv "
                . " WHERE pc.`payroll_category_id`=pv.`payroll_category_id` AND pc.`type`=1 ";
        $usersData = $db->query($query);
        $usersResult = $usersData->fetchAll();
        $i = 0;
        foreach ($usersResult as $user) {
            if ($user['value_type_id'] == 2) {
                $condition = $this->get_condition($user['value_formula']);
                $output= "if ".$condition['if']." ".$condition['operator']. " ".$condition['condition']." then ".$condition['then'] ;
                $usersResult[$i]['value_formula'] = $output;
            }
            $i++;
        }


        return $usersResult;
    }

    public function get_earings_of_employee($user_id) {
        $db = Zend_Db_Table::getDefaultAdapter();
        $query = "SELECT pc.`payroll_category_id`,pc.`name`, pc.`code`,pc.`type`, pv.`payroll_value_id`,pv.`value_type_id`,`emprole_name`,
(case when (pv.`value_type_id` = 0) 
 THEN
     ( SELECT pvn.`amount` FROM `payroll_value_numeric` AS pvn WHERE pvn.`value_category_id`=pv.`value_category_id` )
 when (`value_type_id` = 1)
 THEN 
  ( SELECT pvf.`formula` FROM `payroll_value_formula` AS pvf WHERE pvf.`value_category_id`=pv.`value_category_id` )

 when (`value_type_id` = 2)
 THEN 
  ( SELECT pvc.`value_category_id` FROM `payroll_value_condition` AS pvc WHERE pvc.`value_category_id`=pv.`value_category_id` )
 END)
 as value_formula

FROM `payroll_category` AS pc, `payroll_group_category` AS pgc, `payroll_value` AS pv,`main_employees_summary` AS mes  
WHERE pc.`payroll_category_id`=pgc.`category_id` AND pc.`payroll_category_id`=pv.`payroll_category_id` AND pc.`type`=0 AND
mes.`emprole`=pgc.`group_id` AND mes.`user_id`=" . $user_id;
        $usersData = $db->query($query);
        $usersResult = $usersData->fetchAll();

        return $usersResult;
    }

    public function get_deductions_of_employee($user_id) {
        $db = Zend_Db_Table::getDefaultAdapter();
        $query = "SELECT pc.`payroll_category_id`,pc.`name`, pc.`code`,pc.`type`, pv.`payroll_value_id`,pv.`value_type_id`,`emprole_name`,
(case when (pv.`value_type_id` = 0) 
 THEN
     ( SELECT pvn.`amount` FROM `payroll_value_numeric` AS pvn WHERE pvn.`value_category_id`=pv.`value_category_id` )
 when (`value_type_id` = 1)
 THEN 
  ( SELECT pvf.`formula` FROM `payroll_value_formula` AS pvf WHERE pvf.`value_category_id`=pv.`value_category_id` )

 when (`value_type_id` = 2)
 THEN 
  ( SELECT pvc.`value_category_id` FROM `payroll_value_condition` AS pvc WHERE pvc.`value_category_id`=pv.`value_category_id` )
 END)
 as value_formula

FROM `payroll_category` AS pc, `payroll_group_category` AS pgc, `payroll_value` AS pv,`main_employees_summary` AS mes  
WHERE pc.`payroll_category_id`=pgc.`category_id` AND pc.`payroll_category_id`=pv.`payroll_category_id` AND pc.`type`=1 AND
mes.`emprole`=pgc.`group_id` AND mes.`user_id`=" . $user_id;
        $usersData = $db->query($query);
        $usersResult = $usersData->fetchAll();

        return $usersResult;
    }

    function is_name_exist($name) {
        $db = Zend_Db_Table::getDefaultAdapter();
        $nameData = $db->query("SELECT * FROM payroll_category WHERE `name`='" . $name . "'");
        $rsNammeResult = $nameData->fetchAll();
        return $rsNammeResult;
    }

    function save_payroll_category($dataArray) {
        $this->insert($dataArray);
        $id = $this->getAdapter()->lastInsertId('payroll_category');
        return $id;
    }

    function save_category_values($dataArray,$emp_id) {
        if ($dataArray['category_value'] == "numeric") {
            $payroll_value_numeric_db = new Default_Model_Payrollvaluenumeric();
            $value_category_id = $payroll_value_numeric_db->save_payroll_value_numeric(array("amount" => $dataArray['numeric'],"emp_id" => $emp_id));
            return $value_category_id;
        }
        if ($dataArray['category_value'] == "formula") {
            $payroll_value_numeric_db = new Default_Model_Payrollvalueformula();
            $value_category_id = $payroll_value_numeric_db->save_payroll_value_formula(array("formula" => $dataArray['formula'],"emp_id" => $emp_id));
            return $value_category_id;
        }
        if ($dataArray['category_value'] == "conditionwithformula") {
            $payroll_value_formula_db = new Default_Model_Payrollvalueformula();
            $payroll_value_condition_db = new Default_Model_Payrollvaluecondition();
            $data['if_id'] = $payroll_value_formula_db->save_payroll_value_formula(array("formula" => $dataArray['if'],"emp_id" => $emp_id));
            $data['operator'] = $dataArray['operator'];
            $data['condition_id'] = $payroll_value_formula_db->save_payroll_value_formula(array("formula" => $dataArray['condition'],"emp_id" => $emp_id));
            $data['then_id'] = $payroll_value_formula_db->save_payroll_value_formula(array("formula" => $dataArray['then'],"emp_id" => $emp_id));
            $data['emp_id'] = $emp_id;
            $value_category_id = $payroll_value_condition_db->save_payroll_value_condition($data);
            return $value_category_id;
        }
    }

    function payroll_get_all_category() {
        $db = Zend_Db_Table::getDefaultAdapter();
        $usersData = $db->query("SELECT * FROM payroll_category where status=1");
        $usersResult = $usersData->fetchAll();
        return $usersResult;
    }

    function get_all_earning_deduction($userId) {
        $db = Zend_Db_Table::getDefaultAdapter();
        $query = "SELECT pc.`payroll_category_id`,pc.`name`, pc.`code`,pc.`type`, pv.`payroll_value_id`,pv.`value_type_id`,`emprole_name`,
(case when (pv.`value_type_id` = 0) 
 THEN
     ( SELECT pvn.`amount` FROM `payroll_value_numeric` AS pvn WHERE pvn.`value_category_id`=pv.`value_category_id` )
 when (`value_type_id` = 1)
 THEN 
  ( SELECT pvf.`formula` FROM `payroll_value_formula` AS pvf WHERE pvf.`value_category_id`=pv.`value_category_id` )

 when (`value_type_id` = 2)
 THEN 
  ( SELECT pvc.`value_category_id` FROM `payroll_value_condition` AS pvc WHERE pvc.`value_category_id`=pv.`value_category_id` )
 END)
 as value_formula

FROM `payroll_category` AS pc, `payroll_group_category` AS pgc, `payroll_value` AS pv,`main_employees_summary` AS mes  
WHERE pc.`payroll_category_id`=pgc.`category_id` AND pc.`payroll_category_id`=pv.`payroll_category_id` AND
mes.`emprole`=pgc.`group_id` AND mes.`user_id`=" . $userId;
        //echo $query;die;
        $usersData = $db->query($query);
        $usersResult = $usersData->fetchAll();
        return $usersResult;
    }
    
    function get_emp_earning_deduction($userId) {
        $db = Zend_Db_Table::getDefaultAdapter();
        $query = "SELECT pc.`payroll_category_id`,pc.`name`, pc.`code`,pc.`type`, pv.`payroll_value_id`,pv.`value_type_id`,`emprole_name`,
(case when (pv.`value_type_id` = 0) 
 THEN
     ( SELECT pvn.`amount` FROM `payroll_value_numeric` AS pvn WHERE pvn.`value_category_id`=pv.`value_category_id` )
 when (`value_type_id` = 1)
 THEN 
  ( SELECT pvf.`formula` FROM `payroll_value_formula` AS pvf WHERE pvf.`value_category_id`=pv.`value_category_id` )

 when (`value_type_id` = 2)
 THEN 
  ( SELECT pvc.`value_category_id` FROM `payroll_value_condition` AS pvc WHERE pvc.`value_category_id`=pv.`value_category_id` )
 END)
 as value_formula

FROM `payroll_category` AS pc,`payroll_value` AS pv,`main_employees_summary` AS mes  
WHERE pc.`payroll_category_id` = pv.`payroll_category_id` AND mes.`user_id`=" . $userId." AND pc.emp_id = '".$userId."'";
        //echo $query;die;
        $usersData = $db->query($query);
        $usersResult = $usersData->fetchAll();
        return $usersResult;
    }
    

    function delete_category($category_id) {
        $db = Zend_Db_Table::getDefaultAdapter();
        $query = "SELECT * FROM `payroll_group_category` WHERE `category_id`=" . $category_id;
        $result = $db->query($query);
        //print_r($result);
        //die;
    }

    function get_condition($value_id) {
        $payroll_value_formula_db = new Default_Model_Payrollvalueformula();
        $payroll_value_condition_db = new Default_Model_Payrollvaluecondition();
        $condition = $payroll_value_condition_db->get_condition_from_id($value_id)[0];
        //print_r($condition);
        $if = $payroll_value_formula_db->get_formula_from_id($condition['if_id']);
        switch ($condition['operator']){
            case "gt":
                $opertator =">";
                break;
            case "lt":
                $opertator ="<";
                break;
            case "ge":
                $opertator =">=";
                break;
            case "le":
                $opertator ="<=";
                break;
            case "et":
                $opertator ="==";
                break;
            default:
                $opertator ="==";
                break;
                
        }
        $condition_formula = $payroll_value_formula_db->get_formula_from_id($condition['condition_id']);
        $then = $payroll_value_formula_db->get_formula_from_id($condition['then_id']);
        $returnarr['if']=$if;
        $returnarr['operator']=$opertator;
        $returnarr['condition']=$condition_formula;
        $returnarr['then']=$then;
        //sapp_Payrollcal::pre($returnarr);die;
        return $returnarr;
    }
    
    function details($id){
        $db = Zend_Db_Table::getDefaultAdapter();
        $sql="SELECT * FROM `".$this->_name."` WHERE `".$this->_primary."`=$id";
        $detailsData = $db->query($sql);
        $detailsResult = $detailsData->fetchAll();
        return $detailsResult;
    }
    
    function is_category_conect_to_role($id){
        $sql="SELECT * FROM `payroll_group_category` WHERE `category_id`=".$id;
        $db = Zend_Db_Table::getDefaultAdapter();
        $detailsData = $db->query($sql);
        $detailsResult = $detailsData->fetchAll();
        return $detailsResult;
    }
    
    function payroll_value_details($id){
        $sql="SELECT * FROM `payroll_value` where `payroll_category_id`=".$id;
        $db = Zend_Db_Table::getDefaultAdapter();
        $detailsData = $db->query($sql);
        $detailsResult = $detailsData->fetchAll();
        return $detailsResult;
    }
    
    function delete_payroll_value($value_type_id,$id){
        if($value_type_id==2){
            $this->delete_all_payroll_value_condition($id);
        }
        $tableArr=array('0'=>'payroll_value_numeric','1'=>'payroll_value_formula','2'=>'payroll_value_condition');
        $sql="DELETE FROM `".$tableArr[$value_type_id]."` WHERE `value_category_id`=".$id;
        //echo $sql;die;
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->query($sql);
    }
    
    function delete($id){
        $sql="DELETE FROM `".$this->_name."` WHERE `".$this->_primary."`=".$id;
        $sql1="DELETE FROM `payroll_value` WHERE `payroll_category_id`=".$id;
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->query($sql);
        $db->query($sql1);
    }
    
    function get_full_details($id){
        $db = Zend_Db_Table::getDefaultAdapter();
        $query="SELECT pc.`payroll_category_id`,pc.`name`, pc.`code`,pc.`type`, pv.*, "
                . " (case "
                . " when (pv.`value_type_id` = 0) THEN "
                . "     ( SELECT pvn.`amount` FROM `payroll_value_numeric` AS pvn WHERE pvn.`value_category_id`=pv.`value_category_id` ) "
                . " when (pv.`value_type_id` = 1) THEN "
                . "     ( SELECT pvf.`formula` FROM `payroll_value_formula` AS pvf WHERE pvf.`value_category_id`=pv.`value_category_id` ) "
                . " when (`value_type_id` = 2) THEN "
                . "     ( SELECT pvc.`value_category_id` FROM `payroll_value_condition` AS pvc WHERE pvc.`value_category_id`=pv.`value_category_id`) "
                . " END) as value_formula "
                . " FROM `payroll_category` AS pc, `payroll_value` AS pv "
                . " WHERE pc.`payroll_category_id`=pv.`payroll_category_id` AND pc.payroll_category_id=".$id;
        //die($query);
        $usersData = $db->query($query);
        $usersResult = $usersData->fetchAll();
        return $usersResult;
    }
    
    function update_payroll_category($dataArr,$id) {
        $db = Zend_Db_Table::getDefaultAdapter();
        $where = $this->getAdapter()->quoteInto('payroll_category_id = ?', $id);
        $sql="UPDATE `payroll_category` SET ";
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
        $db->query($sql);
        return FALSE;
    }
    
    function update_payroll_category_value_numeric($val,$id){
        $db = Zend_Db_Table::getDefaultAdapter();
        $where = $this->getAdapter()->quoteInto('value_category_id = ?', $id);
        $sql="UPDATE `payroll_value_numeric` SET `amount`='".$val."' WHERE $where";
        $db->query($sql);
        return FALSE;
    }
    
    function update_payroll_category_value_formula($val,$id){
        $db = Zend_Db_Table::getDefaultAdapter();
        $where = $this->getAdapter()->quoteInto('value_category_id = ?', $id);
        $sql="UPDATE `payroll_value_formula` SET `formula`='".$val."' WHERE $where";
        $db->query($sql);
        return FALSE;
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
        $objName = 'payrollcategory';
				        
        $tableFields = array('action'=>'Action','name'=>'Category Name','code'=>'Category Code','e_d_type'=>'Category Type','value_formula'=>'Value');
		   
        $tablecontent = $this->getPayrollCategoryData($sort,$by,$pageNo,$perPage,$searchQuery,'',$exParam1); 
        
        //sapp_Payrollcal::pre($tablecontent);die;
		
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
                        'menuName' => 'Manage Payroll Category',
                        'dashboardcall'=>$dashboardcall,
                        'add'=>'add',
                        'call'=>$call,
                        'search_filters' => array(
                        'astatus' => array('type'=>'select'))
                    );	
        return $dataTmp;
    }
    
    public function getPayrollCategoryData($sort,$by,$pageNo,$perPage,$searchQuery,$managerid='',$loginUserId)
    {
    	$auth = Zend_Auth::getInstance();
    	$request = Zend_Controller_Front::getInstance();
     	if($auth->hasIdentity()){
            $loginUserGroup = $auth->getStorage()->read()->group_id;
            $loginUserRole = $auth->getStorage()->read()->emprole;
        }
	
        $controllerName = $request->getRequest()->getControllerName();
        //the below code is used to get data of employees from summary table.
        $payrollCategoryData=""; 

        $where = " pc.`payroll_category_id` = pv.`payroll_category_id`";

        if($searchQuery != '')
            $where .= " AND ".$searchQuery;
        
        $where .= " AND pc.emp_id IS NULL";

      $payrollCategoryData = $this->select()
                                ->setIntegrityCheck(false)	
                                ->from(
                                        array('pc' => 'payroll_category'),array('pc.`payroll_category_id` id,pc.`name`, pc.`code`,pv.`payroll_value_id`,pv.`value_type_id`, (case when (pv.`value_type_id` = 0) THEN ( SELECT pvn.`amount` FROM `payroll_value_numeric` AS pvn WHERE pvn.`value_category_id`=pv.`value_category_id` )when (pv.`value_type_id` = 1) THEN  ( SELECT pvf.`formula` FROM `payroll_value_formula` AS pvf WHERE pvf.`value_category_id`=pv.`value_category_id` )  when (`value_type_id` = 2) THEN  ( SELECT pvc.`value_category_id` FROM `payroll_value_condition` AS pvc WHERE pvc.`value_category_id`=pv.`value_category_id`) END) as value_formula,(CASE WHEN (pc.type = 0) THEN  "Earning" WHEN (pc.type = 1) THEN "Deduction" END) as e_d_type','pc.payroll_category_id' => 'pv.payroll_category_id')
                                        )
                                ->joinLeft(
                                        array('pv' => 'payroll_value'),'pc.payroll_category_id=pv.payroll_category_id',
                                        array('payroll_value_id'=>'pv.payroll_value_id','value_type_id'=>'pv.value_type_id')
                                        )
                                ->where($where)
                                ->order("$by $sort")
                                ->limitPage($pageNo, $perPage); //die;
       //die;
                                /*->from(array('pc' => 'payroll_category','pv' => 'payroll_value'),array('pc.`payroll_category_id`,pc.`name`, pc.`code`,pc.`type`, pv.`payroll_value_id`,pv.`value_type_id`, (case "" when (pv.`value_type_id` = 0) THEN      ( SELECT pvn.`amount` FROM `payroll_value_numeric` AS pvn WHERE pvn.`value_category_id`=pv.`value_category_id` )when (pv.`value_type_id` = 1) THEN  ( SELECT pvf.`formula` FROM `payroll_value_formula` AS pvf WHERE pvf.`value_category_id`=pv.`value_category_id` )  when (`value_type_id` = 2) THEN  ( SELECT pvc.`value_category_id` FROM `payroll_value_condition` AS pvc WHERE pvc.`value_category_id`=pv.`value_category_id`) "" END) as value_formula','pc.payroll_category_id' => 'pv.payroll_category_id','pc.type'=> 0))->where($where)->order("$by $sort")->limitPage($pageNo, $perPage); die;*/
        
//        $query="SELECT pc.`payroll_category_id`,pc.`name`, pc.`code`,pc.`type`, pv.`payroll_value_id`,pv.`value_type_id`, "
//                . " (case "
//                . " when (pv.`value_type_id` = 0) THEN "
//                . "     ( SELECT pvn.`amount` FROM `payroll_value_numeric` AS pvn WHERE pvn.`value_category_id`=pv.`value_category_id` ) "
//                . " when (pv.`value_type_id` = 1) THEN "
//                . "     ( SELECT pvf.`formula` FROM `payroll_value_formula` AS pvf WHERE pvf.`value_category_id`=pv.`value_category_id` ) "
//                . " when (`value_type_id` = 2) THEN "
//                . "     ( SELECT pvc.`value_category_id` FROM `payroll_value_condition` AS pvc WHERE pvc.`value_category_id`=pv.`value_category_id`) "
//                . " END) as value_formula "
//                . " FROM `payroll_category` AS pc, `payroll_value` AS pv "
//                . " WHERE pc.`payroll_category_id`=pv.`payroll_category_id` AND pc.`type`=0 ";
        //sapp_Payrollcal::pre($payrollCategoryData);die;
        return $payrollCategoryData;       		
    }
    
    function update_payroll_category_value_condition($dataArr,$id){
        $db = Zend_Db_Table::getDefaultAdapter();
        $payroll_value_condition_sql="SELECT * FROM `payroll_value_condition` WHERE `value_category_id`='$id'";
        //echo $payroll_value_condition_sql;die;
        $payroll_value_condition_details = $db->query($payroll_value_condition_sql);
        $payroll_value_condition_details_rs = $payroll_value_condition_details->fetchAll();
        //sapp_Payrollcal::pre($payroll_value_condition_details_rs);
        //sapp_Payrollcal::pre($dataArr);die;
        ///update if
        $update_sql_if="UPDATE `payroll_value_formula` SET `formula`='".$dataArr['if']."' WHERE `value_category_id`='".$payroll_value_condition_details_rs[0]['if_id']."'";
        $db->query($update_sql_if);
        
        $update_sql_opeprator="UPDATE `payroll_value_condition` SET `operator`='".$dataArr['operator']."' WHERE `value_category_id`='".$id."'";
        $db->query($update_sql_opeprator);
        
        $update_sql_opeprator="UPDATE `payroll_value_formula` SET `formula`='".$dataArr['condition']."' WHERE `value_category_id`='".$payroll_value_condition_details_rs[0]['condition_id']."'";
        $db->query($update_sql_opeprator);
        
        $update_sql_opeprator="UPDATE `payroll_value_formula` SET `formula`='".$dataArr['then']."' WHERE `value_category_id`='".$payroll_value_condition_details_rs[0]['then_id']."'";
        $db->query($update_sql_opeprator);
    }
    
    function delete_all_payroll_value_condition($id){
        $db = Zend_Db_Table::getDefaultAdapter();
        $all_payroll_value_condition_sql="SELECT * FROM `payroll_value_condition` WHERE `value_category_id`='$id'";
        $all_payroll_value_condition_details = $db->query($all_payroll_value_condition_sql)->fetchAll();
        //sapp_Payrollcal::pre($all_payroll_value_condition_details);die;
        $if_id_sql="DELETE FROM `payroll_value_formula` WHERE `value_category_id`=".$all_payroll_value_condition_details[0]['if_id'];
        $db->query($if_id_sql);
        $condition_id_sql="DELETE FROM `payroll_value_formula` WHERE `value_category_id`=".$all_payroll_value_condition_details[0]['condition_id'];
        $db->query($condition_id_sql);
        $then_id_sql="DELETE FROM `payroll_value_formula` WHERE `value_category_id`=".$all_payroll_value_condition_details[0]['then_id'];
        $db->query($then_id_sql);
        return FALSE;
    }
    
    function get_final_charges_of_payroll_category_by_code($code,$baseSal){
        error_reporting(E_ALL|E_STRICT);
        ini_set('display_errors', 'on');
        
        $db = Zend_Db_Table::getDefaultAdapter();
        /*$sql="SELECT `pv.value_type_id` FROM `payroll_category` AS pc JOIN `payroll_value` AS pv ON(pc.payroll_categoryy_id=pv.payroll_category_id) "
                . " (case "
                . " when (pv.`value_type_id` = 0) THEN "
                . "     ( SELECT pvn.`amount` FROM `payroll_value_numeric` AS pvn WHERE pvn.`value_category_id`=pv.`value_category_id` ) "
                . " when (pv.`value_type_id` = 1) THEN "
                . "     ( SELECT pvf.`formula` FROM `payroll_value_formula` AS pvf WHERE pvf.`value_category_id`=pv.`value_category_id` ) "
                . " when (`value_type_id` = 2) THEN "
                . "     ( SELECT pvc.`value_category_id` FROM `payroll_value_condition` AS pvc WHERE pvc.`value_category_id`=pv.`value_category_id`) "
                . " END) as value_formula  WHERE pc.code='".$code."'";
        echo $sql;die;*/
        
        
        $sql="SELECT pv.value_type_id, "
                . " (case "
                . " when (pv.`value_type_id` = 0) THEN "
                . "     ( SELECT pvn.`amount` FROM `payroll_value_numeric` AS pvn WHERE pvn.`value_category_id`=pv.`value_category_id` ) "
                . " when (pv.`value_type_id` = 1) THEN "
                . "     ( SELECT pvf.`formula` FROM `payroll_value_formula` AS pvf WHERE pvf.`value_category_id`=pv.`value_category_id` ) "
                . " when (`value_type_id` = 2) THEN "
                . "     ( SELECT pvc.`value_category_id` FROM `payroll_value_condition` AS pvc WHERE pvc.`value_category_id`=pv.`value_category_id`) "
                . " END) as value_formula "
                . " FROM `payroll_category` AS pc, `payroll_value` AS pv "
                . " WHERE pc.`payroll_category_id`=pv.`payroll_category_id` AND pc.code='".$code."'";
        
        $usersResult = $db->query($sql);
        //sapp_Payrollcal::pre($usersData);die;
        $usersData = $usersResult->fetchAll();
        //sapp_Payrollcal::pre($usersResult);die;
        if($usersData[0]['value_type_id']==0){
            return $usersData[0]['value_formula'];
        }else if($usersData[0]['value_type_id']==1){
            $formula=$usersData[0]['value_formula'];
            $payrollCal = new sapp_Payrollcal();
            $string = str_replace("%", "/100", $formula);
            $salaryCategoryKeyArr=array('BAS');
            $salaryCategoryValArr=array($baseSal);
            
            $str = 'y(' . strtolower('BAS') . ') = ' . strtolower($string);
            sapp_Payrollcal::pre('For '.$value['code'].' formula is : '.$str); //die;
            $payrollCal->evaluate($str);
            //echo "y($salaryCategoryValStr)";die;
            $calculatedValue = $payrollCal->e("y($baseSal)");//die;
            return $calculatedValue;
        }else if($usersData[0]['value_type_id']==2){
            return '0';
        }
    }
    
    function delete_emp_category($category_id){
        $db = Zend_Db_Table::getDefaultAdapter();
        $empCateData = $db->query("SELECT * FROM `payroll_category` WHERE `payroll_category_id`=" . $category_id);
        $empCateDataResult = $empCateData->fetchAll();

        $emp_id = $empCateDataResult[0]['emp_id'];
        
        $query1 = "SELECT * FROM `payroll_payslip_details` WHERE `payroll_category_id`=" . $category_id;
        $result1 = $db->query($query1);
        $resultData1 = $result1->fetchAll();

        $payslip_data=$db->query("SELECT * FROM `payroll_payslip` WHERE `emp_id`='".$emp_id."' and MONTH(generate_date)='".date('m',strtotime('-1 month'))."' and YEAR(generate_date)='".date('Y')."'");
        $payslip_data_result = $payslip_data->fetchAll();
        
        $net_pay = $payslip_data_result[0]['net_pay'];
        if($empCateDataResult[0]['type'] == 0) {
            $amountToDeduct = $resultData1[0]['value'];
            $net_pay = $net_pay - $amountToDeduct;
        } 
        if($empCateDataResult[0]['type'] == 1) {
            $amountToAdd = $resultData1[0]['value'];
            $net_pay = $net_pay + $amountToAdd;
        } 
        
        $updateNetPay = $db->query("UPDATE payroll_payslip SET net_pay = '".$net_pay."'");
        
        $query = "DELETE FROM `payroll_category` WHERE `payroll_category_id`=" . $category_id;
        $result = $db->query($query);
        
        $query1 = "DELETE FROM `payroll_payslip_details` WHERE `payroll_category_id`=" . $category_id;
        $result1 = $db->query($query1);
        
        return 1;
    }
    
    function get_category_data($cateid){
        $db = Zend_Db_Table::getDefaultAdapter();
        $query1 = "SELECT * FROM `payroll_category` WHERE `payroll_category_id`=" . $cateid;
        $result1 = $db->query($query1);
        $resultData1 = $result1->fetchAll();
        return $resultData1;
    }
}

?>