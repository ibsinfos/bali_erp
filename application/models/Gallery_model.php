<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Gallery_model extends CI_Model {

    private $shcool_id;

    public function __construct() {
        parent::__construct();        
        $this->running_year = $this->session->userdata('running_year');
        $this->school_id = $this->session->userdata('school_id');
    }

    public function get_galleries($whr=array(),$order_by='PG.id DESC',$whr_in=array()) {
        _year_cond('PG.running_year');
        _school_cond('PG.school_id');
        $this->db->select('PG.*,(CASE WHEN C.name IS NULL THEN "Common " ELSE C.name END) class_name,
                (SELECT count(*) FROM photo_gallery_images WHERE gallery_id=PG.id) image_count',false);
        $this->db->from('photo_galleries PG');
        $this->db->join('class C','C.class_id=PG.class_id','LEFT');
        $this->db->where($whr);
        foreach($whr_in as $wk=>$whrv){
            $this->db->where_in($wk,$whrv);
        }
        $this->db->order_by($order_by);
        return $this->db->get()->result(); 
    }

    public function get_galleries_for_parent_student($whr=array(),$order_by='PG.id DESC',$whr_in=array(),$student_id=false,$parent_id=false) {
        $pimages = $this->get_gallery_images_for_parent_student(array('IMT.user_type'=>'P','IMT.user_id'=>$parent_id));
        $simages = $this->get_gallery_images_for_parent_student(array('IMT.user_type'=>'S','IMT.user_id'=>$student_id));
        $gallery_ids = array();
        foreach($pimages as $img){
            $gallery_ids[] = $img->gallery_id;    
        }
        foreach($simages as $img){
            $gallery_ids[] = $img->gallery_id;    
        }
        $whr_in['PG.id'] = $gallery_ids;

        _year_cond('PG.running_year');
        _school_cond('PG.school_id');
        $this->db->select('PG.*,(CASE WHEN C.name IS NULL THEN "Common" ELSE C.name END) class_name,
                (SELECT count(*) FROM photo_gallery_images WHERE gallery_id=PG.id) image_count',false);
        $this->db->from('photo_galleries PG');
        $this->db->join('class C','C.class_id=PG.class_id','LEFT');
        $this->db->join('photo_gallery_images IM','IM.gallery_id=PG.id','LEFT');
        $this->db->where($whr);
        foreach($whr_in as $wk=>$whrv){
            if($whrv)
            $this->db->where_in($wk,$whrv);
        }
        $this->db->order_by($order_by);
        $this->db->group_by('PG.id');
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
        $return = array();
        _year_cond();
        _school_cond();
        $images = $this->db->order_by('title','ASC')->get_where('photo_gallery_images',$whr)->result();    
        foreach($images as $img){
            $img->peoples = $this->db->get_where('photo_gallery_image_tags',array('image_id'=>$img->id))->result();
            $img->faces = $this->db->get_where('photo_gallery_image_face_tags',array('image_id'=>$img->id))->result();  
            $return[] = $img;
        }
        return $return;
    }

    function get_gallery_images_for_parent_student($whr=array(),$whr_in=array()){
        $return = array();
        _year_cond('IM.running_year');
        _school_cond('IM.school_id');
        $this->db->select('IM.*');
        $this->db->from('photo_gallery_images IM');
        $this->db->join('photo_gallery_image_tags IMT','IMT.image_id=IM.id','LEFT');
        $this->db->where($whr);
        foreach($whr_in as $wk=>$whrv){
            if($whrv)
            $this->db->where_in($wk,$whrv);
        }
        $this->db->order_by('IM.title','ASC'); 
        $this->db->group_by('IM.id');
        $images = $this->db->get()->result();
        foreach($images as $img){
            $img->peoples = $this->db->get_where('photo_gallery_image_tags',array('image_id'=>$img->id))->result();
            $img->faces = $this->db->get_where('photo_gallery_image_face_tags',array('image_id'=>$img->id))->result();  
            $return[] = $img;
        }
        return $return;
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

    function save_gallery_tags($tags=array(),$img_id=false){
        $peoples = isset($tags['people'])?$tags['people']:array();
        $faces = isset($tags['face'])?$tags['face']:array();
        
        $this->db->delete('photo_gallery_image_tags',array('image_id'=>$img_id));
        $this->db->delete('photo_gallery_image_face_tags',array('image_id'=>$img_id));

        $save_batch = $save_face = array();
        foreach($peoples as $peo){
            $save_batch[] = array('image_id'=>$img_id,
                                  'user_name'=>$peo['user_name'],
                                  'user_type'=>$peo['user_type'],
                                  'user_gender'=>$peo['user_gender'],
                                  'user_id'=>$peo['user_id'],
                                  'created'=>date('Y-m-d H:i:s'),
                                  'school_id'=>_getSchoolid());
        }
        
        foreach($faces as $i=>$face){
            $save_face[] = array('image_id'=>$img_id,
                                 'user_name'=>$peoples[$i]['user_name'],
                                 'user_type'=>$peoples[$i]['user_type'],
                                 'user_gender'=>$peoples[$i]['user_gender'],
                                 'user_id'=>$peoples[$i]['user_id'],
                                 'mouesX'=>$face['mouesX'],
                                 'mouseY'=>$face['mouseY'],
                                 'imgW'=>$face['imgW'],
                                 'imgH'=>$face['imgY'],
                                 'created'=>date('Y-m-d H:i:s'),
                                 'school_id'=>_getSchoolid());
        }                       
        if($save_batch) 
            $this->db->insert_batch('photo_gallery_image_tags',$save_batch);  
        if($save_face)
            $this->db->insert_batch('photo_gallery_image_face_tags',$save_face);             
        return true;    
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

    function get_parents($whr=array(),$order_by='P.father_name ASC'){
        _school_cond('S.school_id');
        _year_cond('E.year');
        _school_cond('P.school_id');
        $this->db->select('P.*');
        $this->db->from('student S');
        $this->db->join('enroll E','E.student_id=S.student_id','LEFT');
        $this->db->join('parent P','P.parent_id=S.parent_id','LEFT');
        $this->db->where($whr); 
        $this->db->order_by($order_by);
        $this->db->group_by('P.parent_id');
        return $this->db->get()->result();    
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
