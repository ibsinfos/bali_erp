<?php

class Default_Model_Payrollpayslip extends Zend_Db_Table_Abstract{
    protected $_name = 'payroll_payslip';
    protected $_primary = 'id';
    
    public function add($dataArr){
        $auth = Zend_Auth::getInstance();

        if($auth->hasIdentity()){
            $school_id = $auth->getStorage()->read()->school_id;
            $dataArr['school_id'] = $school_id;
	}
        
        $this->insert($dataArr);
        $id=$this->getAdapter()->lastInsertId('payroll_payslip');
        return $id;
    }
    
    public function edit($dataArr,$id,$col='emp_id'){
        $db = Zend_Db_Table::getDefaultAdapter();
        $where = $this->getAdapter()->quoteInto($col.' = ?', $id);
        $sql="UPDATE `payroll_payslip` SET ";
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
        //echo '<pre>';print_r($sql);
        $db->query($sql);
    }
    
    public function update_payslip($dataArr,$id){
        $db = Zend_Db_Table::getDefaultAdapter();
        $where = $this->getAdapter()->quoteInto('id = ?', $id);
        $sql="UPDATE `payroll_payslip` SET ";
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
        //echo '<pre>';print_r($sql);
        $db->query($sql);
    }
    
    
    function get_all_employee(){
        $db = Zend_Db_Table::getDefaultAdapter();
        $sql="SELECT * FROM `main_employees_summary` WHERE `isActive`=1";
        $queryData=$db->query($sql);
        $rsData = $queryData->fetchAll();
        //echo '<pre>';print_r($rsData);die;
        return $rsData;
    }
    
    function get_all_employee_by_id($ids){
        $db = Zend_Db_Table::getDefaultAdapter();
        $sql="SELECT * FROM `main_employees_summary` WHERE user_id IN ('".$ids."') AND `isActive`=1";
        $queryData=$db->query($sql);
        $rsData = $queryData->fetchAll();
        //echo '<pre>';print_r($rsData);die;
        return $rsData;
    }
    
    function delete($id) {
        $db = Zend_Db_Table::getDefaultAdapter();
        $where1 = $this->getAdapter()->quoteInto('id = ?', $id);
        $sql="DELETE FROM `payroll_payslip` WHERE $where1";
        $db->query($sql);
    }
    
    public function isPayslipGneratedForEmployee($id,$month = '',$year=''){
        if($month == '' || $month == 0){
            $month = date('m',strtotime('-1 month'));
        } 
        if($year == ''){
            $year = date('Y');
        }
        $sql="SELECT * FROM `payroll_payslip` WHERE payslip_month='".$month."' AND payslip_year='".$year."' AND `emp_id`='$id' ORDER BY id DESC LIMIT 0,1";
//        $sql="SELECT * FROM `payroll_payslip` WHERE MONTH(`generate_date`)=MONTH(CURRENT_DATE()) AND YEAR(`generate_date`)=YEAR(CURRENT_DATE()) AND `emp_id`='$id' ORDER BY id DESC LIMIT 0,1";
        $db = Zend_Db_Table::getDefaultAdapter();
        $queryData=$db->query($sql);
        $rsData = $queryData->fetchAll();
        //echo '<pre>';print_r($rsData);die;
        return $rsData;
    }
    
    public function getEmployeCronPaylip($id){
        $sql="SELECT * FROM `payroll_payslip` WHERE `emp_id`='$id' AND MONTH(`generate_date`)='00' ORDER BY id DESC LIMIT 0,1";
        //die($sql);
        $db = Zend_Db_Table::getDefaultAdapter();
        $queryData=$db->query($sql);
        $rsData = $queryData->fetchAll();
        //echo '<pre>';print_r($rsData);die;
        return $rsData;
    }
    // NEW GENERATE FUNCTION
    public function generate($emp_id){
        $db = Zend_Db_Table::getDefaultAdapter();
        $sql="UPDATE `payroll_payslip` SET `status`=1,`generate_date`='".date('Y-m-d')."' WHERE `id`=".$payroll_payslip_id;
        $db->query($sql);
            return TRUE;
    }
    // OLD GENERATE FUNCTION
//    public function generate($payroll_payslip_id){
//        $db = Zend_Db_Table::getDefaultAdapter();
//        $sql="UPDATE `payroll_payslip` SET `status`=1,`generate_date`='".date('Y-m-d')."' WHERE `id`=".$payroll_payslip_id;
//        $db->query($sql);
//            return TRUE;
//    }
    
    public function generate_bulk($bulkPayslipGenerateIdStr){
        $sql="UPDATE `payroll_payslip` SET `status`=1,`generate_date`='".date('Y-m-d')."' WHERE `id` IN(".$bulkPayslipGenerateIdStr.")";
        //die($sql);
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->query($sql);
        return TRUE;
    }
    
    public function get_data_with_filter($month="",$roll_id="",$emp_name="",$year=""){
        if($year==""){
            $year=date('Y');
        }
        if($month==""){
            $month=date('m');
        }
        $where=" pp.payslip_month='".$month."' AND pp.payslip_year=".$year;
        if($roll_id!=""){
            $where.=" AND mes.emprole='".$roll_id."'";
        }
        if($emp_name!=""){
            $where.=" AND CONCAT(mes.firstname,' ',mes.lastname) LIKE '%".$emp_name."%'";
        }
       $sql="SELECT mes.user_id,mes.firstname,mes.lastname,mes.employeeId,mes.emprole_name,pp.net_pay,pp.generate_date,pp.id FROM "
                . " payroll_payslip AS pp LEFT JOIN main_employees_summary AS mes ON(pp.emp_id=mes.user_id) "
                . " WHERE $where";
        //die($sql);
        $db = Zend_Db_Table::getDefaultAdapter();
        $queryData=$db->query($sql);
        $rsData = $queryData->fetchAll();
        //echo '<pre>';print_r($rsData);die;
        return $rsData;
    }
    
    public function get_all_employee_generated_payslip(){
        if($month==""){
            $month=date('m')-1;
        }
        $where=" MONTH(pp.generate_date)='".$month."' AND YEAR(pp.generate_date)=".date('Y');
        $sql="SELECT mes.user_id,mes.firstname,mes.lastname,mes.employeeId,mes.emprole_name,pp.net_pay,pp.generate_date FROM "
                . " payroll_payslip AS pp LEFT JOIN main_employees_summary AS mes ON(pp.emp_id=mes.user_id) "
                . " WHERE $where";
        //die($sql);
        $db = Zend_Db_Table::getDefaultAdapter();
        $queryData=$db->query($sql);
        $rsData = $queryData->fetchAll();
        //echo '<pre>';print_r($rsData);die;
        return $rsData;
    }
     
    public function get_data($id){
        $sql="SELECT * FROM `payroll_payslip` WHERE `id`='$id'";
        //die($sql);
        $db = Zend_Db_Table::getDefaultAdapter();
        $queryData=$db->query($sql);
        $rsData = $queryData->fetchAll();
        //echo '<pre>';print_r($rsData);die;
        return $rsData;
    }
    
    public function getPayslipByMonthAndUserid($userid,$month,$year){
//        if($month == 12) { $month = '01'; }
//        else { $month = $month+1; }
        if($month=='') {
            $month = date('m');
        }
        if($year==''){
            $year = date('Y');
        }
        $where=" WHERE pp.emp_id = '".$userid."' AND pp.payslip_month='".$month."' AND pp.payslip_year=".$year;
        
        $sql="SELECT * FROM `payroll_payslip` pp ". $where;
        
        $db = Zend_Db_Table::getDefaultAdapter();
        $queryData=$db->query($sql);
        $rsData = $queryData->fetchAll();
        return $rsData;
    }
    
    public function getEmpLastPayslip($userid){
         $where=" WHERE pp.emp_id = '".$userid."'";
        
        $sql="SELECT * FROM `payroll_payslip` pp ". $where." ORDER BY id DESC LIMIT 0,1";
        
        $db = Zend_Db_Table::getDefaultAdapter();
        $queryData=$db->query($sql);
        $rsData = $queryData->fetchAll();
        return $rsData;
    }
}