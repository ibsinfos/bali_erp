<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Gallery_model extends CI_Model {

    private $shcool_id;

    public function __construct() {
        parent::__construct();        
        $this->running_year = $this->session->userdata('running_year');
        $this->school_id = $this->session->userdata('school_id');
    }

    public function get_galleries($whr=array()) {
        _year_cond('PG.running_year');
        _school_cond('PG.school_id');
        $this->db->select('PG.*,(CASE WHEN C.name IS NULL THEN "FOR ALL" ELSE C.name END) class_name,
                (SELECT count(*) FROM photo_gallery_images WHERE gallery_id=PG.id) image_count',false);
        $this->db->from('photo_galleries PG');
        $this->db->join('class C','C.class_id=PG.class_id','LEFT');
        $this->db->where($whr);
        return $this->db->get()->result(); 
    }

    public function save_gallery($data) {
        $flag = false;
        if(isset($data['id']) && $data['id']){
            $this->db->update('photo_galleries', $data, array('id'=>$data['id']));
            $flag = $data['id'];
        }else{
            $this->db->insert('photo_galleries', $data);
            $flag = $this->db->insert_id();
        }
        return $flag;
    }

    function get_gallery_record($id){
        $this->db->select('PG.*,C.name class_name,(SELECT count(*) FROM photo_gallery_images WHERE gallery_id=PG.id) image_count');
        $this->db->from('photo_galleries PG');
        $this->db->join('class C','C.class_id=PG.class_id','LEFT');
        $this->db->where(array('PG.id'=>$id));
        return $this->db->get()->row(); 
    }

    function gallery_delete($whr=array()){
        return $this->db->delete('photo_galleries',$whr);
    }

    //Gallery Images
    function get_gallery_images($whr=array()){
        return $this->db->order_by('title','ASC')->get_where('photo_gallery_images',$whr)->result();    
    }

    function save_gallery_image($data=array()){
        
        $flag = false;
        if(isset($data['id']) && $data['id']){
            $this->db->update('photo_gallery_images', $data, array('id'=>$data['id']));
            $flag = $data['id'];
        }else{
            $this->db->insert('photo_gallery_images', $data);
            $flag = $this->db->insert_id();
        }
        return $flag;    
    }

    function get_gallery_img($whr=array()){
        $this->db->select('PI.*,PG.class_id');
        $this->db->from('photo_gallery_images PI');
        $this->db->join('photo_galleries PG','PG.id=PI.gallery_id','LEFT');
        $this->db->where($whr);
        return $this->db->get()->row(); 
    }

    function delete_gallery_img($img_id=false){
        $img = $this->db->get_where('photo_gallery_images',array('id'=>$img_id))->row();   
        if($img){
            $this->S3_model->delfile($img->thumb);
            $this->S3_model->delfile($img->main);
        }
        $this->db->delete('photo_gallery_images',array('id'=>$img_id)); 
        return $img;
    }


    //Other Functions
    function get_classes($whr=array()){
        _school_cond();
        $this->db->where($whr);
        $this->db->order_by('name_numeric','ASC');
        return $this->db->get_where('class')->result();    
    }

    function get_teachers($whr=array()){
        _school_cond();
        $this->db->where($whr);
        $this->db->order_by('name','ASC');
        return $this->db->get('teacher')->result();    
    }

    function get_parents($whr=array(),$orderby='father_name ASC'){
        _school_cond();
        $this->db->where($whr);
        $this->db->order_by($orderby);
        return $this->db->get('parent')->result();    
    }
    

    function get_students($whr=array()){
        _school_cond('S.school_id');
        _year_cond('E.year');
        $this->db->select('S.*');
        $this->db->from('student S');
        $this->db->join('enroll E','E.student_id=S.student_id','LEFT');
        $this->db->where($whr); 
        $this->db->order_by('S.name','ASC');
        return $this->db->get()->result();    
    }

}
