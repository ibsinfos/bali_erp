<?php

class sapp_Showpayrollcondition{
    var $suppress_errors = false;
    var $last_error = null;
    public function __construct() {
        
    }
    
    public static function get_payroll_condition_value($value_id){
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
        $PayrollConditionString=$returnarr['if'].' '.$returnarr['operator'].' '.$returnarr['condition'].' then '.$returnarr['then'];
        return $PayrollConditionString;
    }
    
    public static function get_payroll_condition_value_arr($value_id){
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
        //$PayrollConditionString=$returnarr['if'].' '.$returnarr['operator'].' '.$returnarr['condition'].' then '.$returnarr['then'];
        return $returnarr;
    }
    
    public static function get_payroll_condition_value_arr_in_edit($value_id){
        $payroll_value_formula_db = new Default_Model_Payrollvalueformula();
        $payroll_value_condition_db = new Default_Model_Payrollvaluecondition();
        $condition = $payroll_value_condition_db->get_condition_from_id($value_id)[0];
        //print_r($condition);
        $if = $payroll_value_formula_db->get_formula_from_id($condition['if_id']);
        
        $condition_formula = $payroll_value_formula_db->get_formula_from_id($condition['condition_id']);
        $then = $payroll_value_formula_db->get_formula_from_id($condition['then_id']);
        $returnarr['if']=$if;
        $returnarr['operator']=$condition['operator'];
        $returnarr['condition']=$condition_formula;
        $returnarr['then']=$then;
        //$PayrollConditionString=$returnarr['if'].' '.$returnarr['operator'].' '.$returnarr['condition'].' then '.$returnarr['then'];
        return $returnarr;
    }
    
    public static function get_payroll_value_by_category_code($code){
        
    }
}
