<?php

class Default_Model_Paymentprotection extends Zend_Db_Table_Abstract{
    protected $_name = 'main_wps_report';
    protected $_primary = 'id';
    
    public function add($dataArr){
        $auth = Zend_Auth::getInstance();

        if($auth->hasIdentity()){
            $school_id = $auth->getStorage()->read()->school_id;
            $dataArr['school_id'] = $school_id;
	}
        
        $sql="SELECT * FROM `main_wps_report` WHERE payslip_id='".$dataArr['payslip_id']."' AND `emp_id`='".$dataArr['emp_id']."' AND wps_month='".$dataArr['wps_month']."' AND wps_year='".$dataArr['wps_year']."' ORDER BY id DESC LIMIT 0,1";
        $db = Zend_Db_Table::getDefaultAdapter();
        $queryData=$db->query($sql);
        $rsData = $queryData->fetchAll();
        if(count($rsData) == 0){
            $this->insert($dataArr);
            $id=$this->getAdapter()->lastInsertId('main_wps_report');
            return $id;
        } else {
            return 0;
        }
    }
    
    public function get_data_with_filter($month="",$empstatus="",$emp_name="",$year=''){
        if($month==""){
            $month=date('m')-1;
        }
        if($year==""){
            $year=date('Y');
        }
        $where=" pp.payslip_month='".$month."' AND pp.payslip_year=".$year;
        if($empstatus!=""){
            $where.=" AND mes.emp_status_id='".$empstatus."'";
        }
        if($emp_name!=""){
            $where.=" AND CONCAT(LOWER(mes.firstname),' ',LOWER(mes.lastname)) LIKE '%".strtolower($emp_name)."%'";
        }
        
        $sql="SELECT mwr.id as wps_id,mes.user_id,mes.firstname,mes.lastname,mes.employeeId,mes.emprole_name,mwr.payslip_id as payslip_uid,mwr.emp_id,mwr.created_date,pp.net_pay FROM main_wps_report AS mwr LEFT JOIN main_employees_summary AS mes ON(mwr.emp_id=mes.user_id) LEFT JOIN payroll_payslip as pp ON pp.id=mwr.payslip_id WHERE $where";

        $db = Zend_Db_Table::getDefaultAdapter();
        $queryData=$db->query($sql);
        $rsData = $queryData->fetchAll();
        return $rsData;
    }
    
    public function get_all_employee_generated_wps($empstatus,$month){
        if($month==""){
            $month=date('m');
        }
        if($empstatus!=''){
            $where=" pp.payslip_month='".$month."' AND pp.payslip_year='".date('Y')."' AND mes.emp_status_id='".$empstatus."'";
        } else {
            $where=" pp.payslip_month='".$month."' AND pp.payslip_year='".date('Y')."'";
        }
        $sql="SELECT mwr.id as wps_id,mes.user_id,mes.firstname,mes.lastname,mes.employeeId,mes.emprole_name,mwr.payslip_id as payslip_uid,mwr.emp_id,mwr.created_date FROM main_wps_report AS mwr LEFT JOIN main_employees_summary AS mes ON(mwr.emp_id=mes.user_id) LEFT JOIN payroll_payslip as pp ON pp.id=mwr.payslip_id WHERE $where";

        $db = Zend_Db_Table::getDefaultAdapter();
        $queryData=$db->query($sql);
        $rsData = $queryData->fetchAll();
        
        return $rsData;
    }
    
    public function get_data_by_id($id){
        $sql="SELECT * FROM `main_wps_report` WHERE `id`='$id'";
        $db = Zend_Db_Table::getDefaultAdapter();
        $queryData=$db->query($sql);
        $rsData = $queryData->fetchAll();
        return $rsData;
    }
}