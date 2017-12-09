<?php
defined('BASEPATH') OR exit('Access Denied!');

class Uploads extends Admin_Controller {
    public function __construct() {
        parent::__construct();
        $this->data['sub_title'] = 'ניהול קבצים';
        if(!$this->users->has_permission($this->users->user['username'], 'manage_uploads')) {
            redirect(base_url() . 'admin/dashboard');
        }
        $this->data['data']['errors'] = [];
        $this->data['data']['success-message'] = '';
    }
    
	public function index($page = 1) {
        $this->set_view('admin/show_uploads');
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->upload();
        }
        $this->data['data']['page'] = $page;
        $this->data['data']['uploads'] = $this->uploads->get_uploads($page, $this->panel_pagination);
        if(count($this->data['data']['uploads']) == 0 && $page != 1) {
            $page = 1;
            $this->data['data']['page'] = $page;
            $this->data['data']['uploads'] = $this->uploads->get_uploads($page, $this->panel_pagination);
        }
        $config['base_url'] = base_url().'admin/uploads/';
        $config['total_rows'] = $this->uploads->get_uploads_number();
        $config['per_page'] = $this->panel_pagination;
        $config['use_page_numbers'] = TRUE;

        $this->pagination->initialize($config);

        $this->data['data']['pagination'] = $this->pagination->create_links();
        $this->load_page();
	}
    
    public function delete($id, $page) {
        $this->uploads->delete_file($id);
        redirect(base_url().'admin/uploads/'.$page);
    }
    
    public function upload() {
        $data = $this->uploads->upload_files($_FILES, $this->users->user['username']);
        $this->data['data']['errors'] = $data['errors'];
        $uploaded = $data['uploaded'];
        if(count($uploaded) >= 1) {
            $this->data['data']['success-message'] = count($uploaded)." קבצים עלו בהצלחה";
        }
    }
}