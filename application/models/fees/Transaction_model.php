<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Transaction_model extends CI_Model {

    private $_table_income = "fi_income";
    private $_table_expenditure = "fi_expenditure";
    private $_table_fi_category = "fi_category";

    public function __construct() {
        parent::__construct();
    }

    public function add($data) {
        if($data['transaction_type']=='1'){
            unset($data['transaction_type']);
            $this->db->insert($this->_table_income, $data);
        }
        else if($data['transaction_type']=='2'){
            unset($data['transaction_type']);
            $this->db->insert($this->_table_expenditure, $data);
        }
        return $this->db->insert_id();
    }

    function get_income_data(){
        $where = array('inc.fi_income_status'=>'1', 'inc.school_id'=>$this->session->userdata('school_id'));

        $this->db->select('inc.fi_income_id, inc.title, inc.amount, inc.date, inc.description, cat.category_name');
        $this->db->from($this->_table_income.' inc');
        $this->db->join($this->_table_fi_category.' cat', 'cat.fi_category_id = inc.fi_category_id');
        $this->db->where($where);
        $this->db->order_by('inc.fi_income_id', 'desc');
        return $this->db->get()->result_array();
    }

    function get_expense_data(){
        $where = array('exp.fi_expenditure_status'=>'1', 'exp.school_id'=>$this->session->userdata('school_id'));

        $this->db->select('exp.fi_expenditure_id, exp.title, exp.amount, exp.date, exp.description, cat.category_name');
        $this->db->from($this->_table_expenditure.' exp');
        $this->db->join($this->_table_fi_category.' cat', 'cat.fi_category_id = exp.fi_category_id');
        $this->db->where($where);
        $this->db->order_by('exp.fi_expenditure_id', 'desc');
        return $this->db->get()->result_array();
    }

    function do_delete($transaction_type, $id, $data){
        $UpdateData['delete_reason'] = $data;
        $UpdateData['deleted_at'] = date('d-m-Y');
        $UpdateData['deleted_by'] = $this->session->userdata('login_user_id');
        $UpdateData['user_type'] = $this->session->userdata('login_type');
        if($transaction_type=='income'){
            $UpdateData['fi_income_status'] = '0';
            
            $this->db->where('fi_income_id',$id);
            $this->db->update($this->_table_income, $UpdateData);
        }else if($transaction_type=='expense'){
            $UpdateData['fi_expenditure_status'] = '0';

            $this->db->where('fi_expenditure_id',$id);
            $this->db->update($this->_table_expenditure, $UpdateData);
        }    
    }

    function do_get_revert_data($RevertType,  $StartDate, $EndDate){
        if($RevertType == '1'){
            $where = array('inc.fi_income_status'=>'0', 'inc.school_id'=>$this->session->userdata('school_id'));

            $this->db->select('inc.fi_income_id, inc.amount, inc.delete_reason, inc.deleted_at, inc.deleted_by, inc.user_type, cat.category_name');
            $this->db->from($this->_table_income.' inc');
            $this->db->join($this->_table_fi_category.' cat', 'cat.fi_category_id = inc.fi_category_id');

            $this->db->where($where);

            $this->db->where('inc.deleted_at >=', date('d-m-Y', strtotime($StartDate)));
            $this->db->where('inc.deleted_at <=', date('d-m-Y', strtotime($EndDate)));

            $this->db->order_by('inc.fi_income_id', 'asc');
            $data = $this->db->get()->result_array();

            if(count($data)){
                if($data[0]['user_type']=='school_admin'){ 
                    $this->db->select('sa.first_name, sa.last_name');
                    $this->db->from('school_admin sa');
                    $this->db->where('sa.school_admin_id', $data[0]['deleted_by']);
                    $rs = $this->db->get()->row(); 
                    $data[0]['deleted_by_user_name'] = ucwords($rs->first_name.' '.$rs->last_name);
                }
            }
            return $data;
        }else if($RevertType == '2'){
            $where = array('exp.fi_expenditure_status'=>'0', 'exp.school_id'=>$this->session->userdata('school_id'));

            $this->db->select('exp.fi_expenditure_id, exp.amount, exp.delete_reason, exp.deleted_at, exp.deleted_by, exp.user_type, cat.category_name');
            $this->db->from($this->_table_expenditure.' exp');
            $this->db->join($this->_table_fi_category.' cat', 'cat.fi_category_id = exp.fi_category_id');

            $this->db->where($where);

            $this->db->where('exp.deleted_at >=', date('d-m-Y', strtotime($StartDate)));
            $this->db->where('exp.deleted_at <=', date('d-m-Y', strtotime($EndDate)));

            $this->db->order_by('exp.fi_expenditure_id', 'asc');
            $data = $this->db->get()->result_array();

            if(count($data)){
                if($data[0]['user_type']=='school_admin'){ 
                    $this->db->select('sa.first_name, sa.last_name');
                    $this->db->from('school_admin sa');
                    $this->db->where('sa.school_admin_id', $data[0]['deleted_by']);
                    $rs = $this->db->get()->row(); 
                    $data[0]['deleted_by_user_name'] = ucwords($rs->first_name.' '.$rs->last_name);
                }
            }
            return $data;
        }
    }
    
}
