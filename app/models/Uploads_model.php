<?php

class Uploads_model extends CI_Model {
    private $uploads = [];
    
    public function __construct() {
        parent::__construct();
        $this->load_uploads();
    }
    
    public function load_uploads() {
        $this->uploads = $this->site_model->get('uploads',[],'time DESC');
    }

    public function get_uploads($page, $per_page) {
        return array_slice($this->uploads, ($page-1) * $per_page, $per_page);
    }
    
    public function get_uploads_number() {
        return count($this->uploads);
    }
    
    public function get_upload($id) {
        foreach($this->uploads as $file) {
            if($file['ID'] == $id) {
                return $file;
            }
        }
        return [];
    }
    
    public function set_upload_options()
    {
        $config['upload_path'] = FCPATH.'/uploads/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png|doc|docx|mp4|mp3|pptx|ppt|bmp|pdf';
        $config['remove_spaces'] = true;
        return $config;
    }
    
    public function upload_files($files, $uploader) {
        $uploaded = [];
        $errors = [];
        $cpt = count($_FILES['files']['name']);
        $this->load->library('upload');
        for($i=0; $i<$cpt; $i++)
        {
            $time = time();
            $_FILES['files']['name'] = str_replace(' ', '_',$files['files']['name'][$i]);
            $_FILES['files']['type'] = $files['files']['type'][$i];
            $_FILES['files']['tmp_name'] = $files['files']['tmp_name'][$i];
            $_FILES['files']['error'] = $files['files']['error'][$i];
            $_FILES['files']['size'] = $files['files']['size'][$i];

            $this->upload->initialize($this->set_upload_options());
            if (!$this->upload->do_upload('files')) {  
                $errors[]['error'] = $_FILES['files']['name']."-".$this->upload->display_errors();
            } else {
                $uploaded[] = $_FILES['files'];
                $new_file = [
                    'name' => $_FILES['files']['name'],
                    'time' => $time,
                    'username' => $uploader
                ];
                $inserted_id = $this->site_model->insert('uploads', $new_file);
                $new_file['ID'] = $inserted_id;
                array_unshift($this->uploads, $new_file);
            }
        }
        return ['errors' => $errors, 'uploaded' => $uploaded];
    }
    
    public function delete_file($id) {
        $file = $this->get_upload($id);
        unlink(FCPATH . '/uploads/'.$file['name']);
        $this->site_model->delete('uploads', ['ID' => $id], 1);
        $this->load_uploads();
    }
}