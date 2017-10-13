    <?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class School_Admin_model extends CI_Model {

    private $_table = "school_admin";
    private $_table_user_role_transaction = 'user_role_transaction';
    
    public function __construct() {
        parent::__construct();
    }
   
    public function save_admin($data) {
        $emailExist = $this->db->where('email',$data['email'])->get('school_admin')->row(); 
        if(!empty($emailExist) && $emailExist->school_admin_id>0){
            return 0;
        }
       $data['name'] = $data['first_name']." ".$data['last_name'];
       $this->db->insert('school_admin', $data);
       $ins = $this->db->insert_id();
        
        // Save data into HRM main_users table
        
        $hrmData = array(
            'emprole' => 1,
            'userstatus' => 'old',
            'firstname' => $data['first_name'],
            'lastname' => $data['last_name'],
            'userfullname' => $data['first_name']." ".$data['last_name'],
            'emailaddress' => $data['email'],
            'emppassword' => md5($data['original_pass']),
            'contactnumber' => $data['mobile'],
        ); 
       
        $ins1 = $this->db->insert('main_users', $hrmData);
        
        $link_data = array(
            'main_user_id' => $ins,
            'role_id' => 6,
            'user_type' => "SA",
            'original_user_type' => "SA"
            
        ); 
       
         $this->db->insert('user_role_transaction', $link_data);
 
        // Save data into FI sys_users table
        
        $fiPass = crypt($data['original_pass'],'ib_salt');
        $fiData = array(
            'status' => 'Active',
            'user_type' => 'Admin',
            'fullname' => $data['first_name']." ".$data['last_name'],
            'username' => $data['email'],
            'password' => $fiPass,
            'phonenumber' => $data['mobile'],
        ); 
        
        $ins1 = $this->db->insert('sys_users', $fiData); 
        
        return $ins;
    }
    
    public function update_admin($dataArray, $id) {
        $emailExist = $this->db->where("email='".$dataArray['email']."' AND school_admin_id!='".$id."'")->get('school_admin')->row();  
        if(!empty($emailExist) && $emailExist->school_admin_id>0){
            return 0;
        }
        $this->db->where('school_admin_id', $id);
        $this->db->update('school_admin', $dataArray);
        return true;
    }
    
    public function update_profile($dataArray, $admin_id){
        
        $this->db->where('school_admin_id', $admin_id);
        $this->db->update('school_admin', $dataArray);
        return true; 
    }
        
    public function updateadmin_password($dataArray, $admin_id) {
        $this->db->where('school_admin_id', $admin_id);
        $this->db->update('school_admin',$dataArray);

        $emailData = $this->db->where("school_admin_id='".$admin_id."'")->get('school_admin')->result_array();  

        $pass = $this->input->post('new_password');
        // Fi Update
        $fiPass = crypt($pass,'ib_salt');
        $fiData = array('password'=>$fiPass);
        $this->db->where('username', $emailData[0]['email']);
        $this->db->update('sys_users',$fiData);
        // HRM Update
        $hrmPass = md5($pass);
        $hrmData = array('emppassword'=>$hrmPass);
        $this->db->where('emailaddress', $emailData[0]['email']);
        $this->db->update('main_users',$hrmData);
        return true;
    }

    public function get_admin_array() {
        $this->db->where(array('status' => '1'));
        $this->db->order_by("first_name", "asc");
        $admin_array = $this->db->get('school_admin')->result_array();
        
        return $admin_array;
    }
    
    public function get_school_admin_list($school_id = '') {
        $this->db->where(array('status' => '1'));
        $this->db->order_by("first_name", "asc");
        $data = $this->db->get('school_admin')->result_array();
        
        if(count($data)){
            foreach($data as $k => $datum){
                $where = array('original_user_type' => 'SA', 'main_user_id' => $datum['school_admin_id'], 'school_id'=>$school_id);
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
    
    
    public function getSingleAdminData($adminId, $teacher_id) {
        if(!empty($teacher_id))
        {
            $this->db->where(array('teacher_id' => $teacher_id));
            $adminArray = $this->db->get('teacher')->result_array();
        }
        else
        {    
        $this->db->where(array('school_admin_id' => $adminId));
        $adminArray = $this->db->get('school_admin')->result_array();
        }
        return $adminArray[0];
    }
    
    public function get_admin_schools() {
        $this->db->select('mapp.uid,sc_admin.*,sc.name as school_name');
        $this->db->from('admin_school_mapping as mapp');
        $this->db->join( 'schools as sc' , 'sc.school_id = mapp.school_id', 'left' );
        $this->db->join( 'school_admin as sc_admin' , 'sc_admin.school_admin_id = mapp.admin_id', 'left' );

        $this->db->order_by("sc_admin.first_name", "asc");
        $admin_array = $this->db->get()->result_array();
        return $admin_array;
    }
    
    public function assign_school_admin($data) {
        $chkExist=$this->db->select()->from('admin_school_mapping')->where("admin_id='".$data['admin_id']."'")->get()->result_array();

        if(count($chkExist)>0){
            return 0;
        } else {
            $ins = $this->db->insert('admin_school_mapping', $data);

            $mailId = $this->db->select()->from('school_admin')->where("school_admin_id='".$data['admin_id']."'")->get()->row();

            $hrmData = array(
                'school_id' => $data['school_id']
            ); 

            $this->db->where('emailaddress', $mailId->email);
            $this->db->update("main_users", $hrmData);

            $this->db->where('username', $mailId->email);
            $this->db->update("sys_users", $hrmData);

            return $ins;
        }
    }
    
     function get_data_by_cols($columnName="*",$conditionArr=array(),$return_type="result",$sortByArr=array(),$limit=""){
        $this->db->select($columnName);
        $condition_type='and';
        if(array_key_exists('condition_type', $conditionArr)){
            if($conditionArr['condition_type']!=""){
                $condition_type=$conditionArr['condition_type'];
            }
        }
        unset($conditionArr['condition_type']);
        $condition_in_data_arr=array();
        $startCounter=0;
        $condition_in_column="";
        foreach($conditionArr AS $k=>$v){
            if($condition_type=='in'){
                if(array_key_exists('condition_in_data', $conditionArr)){
                    $condition_in_data_arr=  explode(',', $conditionArr['condition_in_data']);
                    $condition_in_column=$conditionArr['condition_in_col'];
                }

            }elseif($condition_type=='or'){
                if($startCounter==0){
                    $this->db->where($k,$v);
                }else{
                    $this->db->or_where($k,$v);
                }
            }elseif($condition_type=='and'){
                $this->db->where($k,$v);
            }
            $startCounter++;
        }

         if($condition_type=='in'){
             if(!empty($condition_in_data_arr))
                 $this->db->where_in($condition_in_column,$condition_in_data_arr);
        }

        if($limit!=""){
            $this->db->limit($limit);
        }
        
        if(!empty($sortByArr)) {
            foreach($sortByArr AS $key=>$val){
                $this->db->order_by($key,$val);
            }
        }

        if($return_type=='result'){
            $rs=$this->db->get($this->_table)->result();
        }else{
            $rs=$this->db->get($this->_table)->result_array();
        }

        return $rs;
    }
    
    function edit($dataArr,$conditionArr){
        foreach ($conditionArr AS $k=>$v){
            $this->db->where($k, $v);
        }
        $this->db->update($this->_table, $dataArr);
    }  
    
    public function delete_school_admin($id) {
        $this->db->where(array('uid' => $id));
        $return = $this->db->delete('admin_school_mapping');             
        return true;
    }

    function get_school_admin(){
        $school_id = '';
        if(($this->session->userdata('school_id'))) {
            $school_id = $this->session->userdata('school_id');
        }

        $this->db->select('sc_admin.*');
        $this->db->from('school_admin as sc_admin');
        $this->db->join( 'admin_school_mapping as mapp' , 'mapp.admin_id = sc_admin.school_admin_id');
        $this->db->where('mapp.school_id', $school_id);
        $data = $this->db->get()->result_array();
        return $data;
    }
}
