    <?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cashier_model extends CI_Model {

    private $_table = "accountant";
    private $_table_user_role_transaction = 'user_role_transaction';
    
    public function __construct() {
        parent::__construct();
    }
    
    public function get_school_cashier_list($school_id) {
        $this->db->select('accountant_id id, name fname, email, phone cell_phone');
        $this->db->where(array('accountant_status' => '1', 'acc_type' => '2', 'school_id'=>$school_id));
        $this->db->order_by("name", "asc");
        $data = $this->db->get($this->_table)->result_array();

        if(count($data)){
            foreach($data as $k => $datum){
                $where = array('original_user_type' => 'CASH', 'main_user_id' => $datum['id'], 'school_id'=>$school_id);
                $this->db->from($this->_table_user_role_transaction);
                $this->db->where($where);
                $query = $this->db->get();
                $exist = $query->num_rows();
                if($exist){
                    $role_id = $query->row()->role_id;
                    $data[$k]['role_id'] = $role_id;
                }else{
                    $data[$k]['role_id'] = '';
                }
            }
        }
        return $data;        
    }    
     
}
