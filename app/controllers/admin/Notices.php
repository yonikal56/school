<?php
defined('BASEPATH') OR exit('Access Denied!');

class Notices extends Admin_Controller {
    public function __construct() {
        parent::__construct();
        $this->data['sub_title'] = 'ניהול עדכונים';
    }
    
	public function index($page = 1) {
        if($this->users->has_permission($this->users->user['username'], 'manage_notices')) {
            $this->set_view('admin/show_notices');
            $this->data['data']['page'] = $page;
            $this->data['data']['notices'] = $this->notices->get_panel_notices($page, $this->panel_pagination);
            if(count($this->data['data']['notices']) == 0 && $page != 1) {
                $page = 1;
                $this->data['data']['page'] = $page;
                $this->data['data']['notices'] = $this->notices->get_panel_notices($page, $this->panel_pagination);
            }
            $config['base_url'] = base_url().'admin/notices/';
            $config['total_rows'] = $this->notices->get_notices_number();
            $config['per_page'] = $this->panel_pagination;
            $config['use_page_numbers'] = TRUE;

            $this->pagination->initialize($config);

            $this->data['data']['pagination'] = $this->pagination->create_links();
            $this->load_page();
        } else {
            redirect(base_url() . 'admin/dashboard');
        }
	}
    
    public function delete($id, $page) {
        if($this->users->has_permission($this->users->user['username'], 'manage_notices')) {
            $this->notices->delete_notice($id);
            redirect(base_url().'admin/notices/'.$page);
        }
    }
    
    public function add() {
        $this->form_validation->set_rules('title', 'כותרת', 'trim|required|min_length[10]|max_length[50]');
        if($this->form_validation->run()) {
            $this->notices->add_notice($this->input->post('title'), $this->input->post('document'));
            redirect(base_url().'admin/notices');
        }
        $this->index();
    }
    
    public function edit($id = null, $page = 1) {
        if($id == null) {
            redirect(base_url().'admin/notices/'.$page);
        } else {
            $this->set_view('admin/edit_notices');
            $this->data['data']['page'] = $page;
            $this->data['data']['notice'] = $this->notices->get_notice($id);
            if(count($this->data['data']['notice']) == 0) {
                redirect(base_url().'admin/notices/'.$page);
            }
            $this->form_validation->set_rules('title', 'כותרת', 'trim|required|min_length[10]|max_length[50]');
            if($this->form_validation->run()) {
                $this->notices->edit_notice($id, ['title' => $this->input->post('title'), 'document' => $this->input->post('document')]);
                redirect(base_url().'admin/notices/'.$page);
            }
        }
        $this->load_page();
    }
}