<?php

 if (!defined('BASEPATH'))
        exit('No direct script access allowed');

    class S3_model extends CI_Model
    {
        static $bucket = 'sharadtechnologies';
        private $_bucket = 'sharadtechnologies';
        function __construct()
        {
            $this->load->library('s3');  
            parent::__construct();
        }
        
        
        function upload($files,$path)
        {
            //echo $files;
            // $input=$this->s3->inputFile($files);
            return $this->s3->putObjectFile($files,'sharadtechnologies',$path, S3::ACL_PRIVATE);
        }
        
        function download($path)
        {
            $filename = $path;
            $filename = explode('/', str_replace(DIRECTORY_SEPARATOR, '/', $filename));
            $filename = end($filename);
            $this->s3->getObject('sharadtechnologies',$path,'uploads'.DIRECTORY_SEPARATOR.$filename);
            return "uploads".DIRECTORY_SEPARATOR.$filename;                    
        }

        function makedir($name,$path)
        {
            
        }

        function deldir($path)
        {
            
        }


        function delfile($path)
        {
           $filename = $path;
           $filename = explode('/', str_replace(DIRECTORY_SEPARATOR, '/', $filename));
           $filename = end($filename);
           $this->s3->deleteObject('sharadtechnologies',$path);
           return 1;      
        }

        function get_all_files()
        {
            return $this->s3->listBuckets();
        }

        function get_file($bucket,$url)
        {  
            $contents=(array)$this->s3->getObject($bucket,'');
            $body[]=$contents['body'];
            $files=(array)$body[0];
            $contents=$files['Contents'];
            $result=[];
            foreach ($contents as $content)
            {
                    $key=(array)$content->Key;
                    $key=$key[0];
                    if (strpos($key, $url) !== false) {
                    $result[]=$content;
                    }
            }
            return $result ;
        }

        function get_objects($obj=false){
            $contents=(array)$this->s3->getObject($this->_bucket,'');
            $body[] = $contents['body'];
            $files = (array)$body[0];
            $contents = $files['Contents'];
            $result = [];
            foreach ($contents as $content)
            {
                $key=(array)$content->Key;
                $key=$key[0];
                if (strpos($key, $obj) !== false) {
                    $result[]=$content;
                }
            }
            return $result;
        }
}
