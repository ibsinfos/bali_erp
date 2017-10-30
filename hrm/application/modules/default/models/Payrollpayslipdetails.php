<?php

class Default_Model_Payrollpayslipdetails extends Zend_Db_Table_Abstract{
    protected $_name = 'payroll_payslip_details';
    protected $_primary = 'id';
    
    public function add($dataArr){
//        error_reporting(E_ALL|E_STRICT);
//        ini_set('display_errors', 'on');
        $db = Zend_Db_Table::getDefaultAdapter();
        $chkExist = "SELECT * FROM `payroll_payslip_details` WHERE `payroll_payslip_id`='".$dataArr['payroll_payslip_id']."' AND payroll_category_id = '".$dataArr['payroll_category_id']."'";
        //die($sql);
        $queryData=$db->query($chkExist);
        $rsData = $queryData->fetchAll();
        if(count($rsData) == 0) {
            $this->insert($dataArr);
            $id=$this->getAdapter()->lastInsertId('payroll_payslip_details');
            return $id;
        } else {
            return 0;
        }
    }
    
    public function editpayslipdata($dataArr,$id){
        $db = Zend_Db_Table::getDefaultAdapter();
        $where = $this->getAdapter()->quoteInto('id = ?', $id);
        $sql="UPDATE `payroll_payslip_details` SET ";
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
    
    function get_details_by_employee_id($userId,$payslip_id = ''){
        $db = Zend_Db_Table::getDefaultAdapter();
        $sql="SELECT * FROM `payroll_payslip` WHERE `emp_id`='".$userId."' ORDER BY id DESC LIMIT 0,1";
        //die($sql);
        $queryData=$db->query($sql);
        $rsData = $queryData->fetchAll();
        //sapp_Payrollcal::pre($rsData);die;
        if(!empty($rsData)){
            $sql="SELECT ppd.value,pc.name,pc.code,pc.type FROM `payroll_payslip_details` As ppd JOIN `payroll_category` AS pc ON(ppd.payroll_category_id=pc.payroll_category_id) WHERE ppd.`payroll_payslip_id`='".$payslip_id."' ";
            //sapp_Payrollcal::pre($sql);die;
            $queryData=$db->query($sql);
            $rsData = $queryData->fetchAll();
            return $rsData;
        }else{
            return array();
        }
    }
    
    function get_current_net_pay($userId,$payslipid = ''){
        $db = Zend_Db_Table::getDefaultAdapter();
        $sql="SELECT * FROM `payroll_payslip` WHERE `emp_id`='".$userId."' and id = '".$payslipid."' ORDER BY id DESC LIMIT 0,1";
        //die($sql);
        $queryData=$db->query($sql);
        $rsData = $queryData->fetchAll();
        return $rsData;
    }
    
    function get_data_by_category_id($category_id,$payslip_id){
        $db = Zend_Db_Table::getDefaultAdapter();
        $sql="SELECT *  FROM `payroll_payslip_details` WHERE `payroll_category_id`='".$category_id."' AND payroll_payslip_id='".$payslip_id."'";
        $queryData=$db->query($sql);
        $rsData = $queryData->fetchAll();
        return $rsData;
    }
}