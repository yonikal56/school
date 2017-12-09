<?php
defined('BASEPATH') OR exit('Access Denied!');

class Pages extends Admin_Controller {
    public function __construct() {
        parent::__construct();
        $this->data['sub_title'] = 'ניהול דפים';
        if(!$this->users->has_permission($this->users->user['username'], 'manage_pages')) {
            redirect(base_url().'admin/dashboard');
        }
    }
    
	public function index($page = 1) {
        $this->set_view('admin/show_pages');
        $this->data['data']['page'] = $page;
        $this->data['data']['pages'] = $this->pages->get_panel_pages($page, $this->panel_pagination);
        if(count($this->data['data']['pages']) == 0 && $page != 1) {
            $page = 1;
            $this->data['data']['page'] = $page;
            $this->data['data']['pages'] = $this->pages->get_panel_pages($page, $this->panel_pagination);
        }
        $config['base_url'] = base_url().'admin/pages/';
        $config['total_rows'] = count($this->pages->get_pages());
        $config['per_page'] = $this->panel_pagination;
        $config['use_page_numbers'] = TRUE;

        $this->pagination->initialize($config);

        $this->data['data']['pagination'] = $this->pagination->create_links();
        $this->load_page();
	}
    
    public function delete($id, $page) {
        $this->pages->delete_page($id);
        redirect(base_url().'admin/pages/'.$page);
    }
    
    public function add() {
        $this->form_validation->set_rules('title', 'כותרת', 'trim|required|min_length[3]|max_length[50]');
        $this->form_validation->set_rules('machine_name', 'כתובת URL אישית', 'trim|required|min_length[3]|max_length[20]');
        if($this->form_validation->run()) {
            $this->pages->add_page($this->input->post('title'), $this->input->post('machine_name'), $this->input->post('content'), $this->input->post('keywords'), $this->input->post('description'));
            redirect(base_url().'admin/pages');
        }
        $this->index();
    }
    
    public function edit($id = null, $page = 1) {
        if($id == null) {
            redirect(base_url().'admin/pages/'.$page);
        } else {
            $this->set_view('admin/edit_pages');
            $this->data['data']['page'] = $page;
            $this->data['data']['page_item'] = $this->pages->get_page($id);
            if(count($this->data['data']['page_item']) == 0) {
                redirect(base_url().'admin/pages/'.$page);
            }
            $this->form_validation->set_rules('title', 'כותרת', 'trim|required|min_length[3]|max_length[50]');
            $this->form_validation->set_rules('machine_name', 'כתובת URL אישית', 'trim|required|min_length[3]|max_length[20]');
            if($this->form_validation->run()) {
                $this->pages->edit_page($id, [
                    'title' => $this->input->post('title'),
                    'machine_name' => $this->input->post('machine_name'),
                    'content' => $this->input->post('content'),
                    'keywords' => $this->input->post('keywords'),
                    'description' => $this->input->post('description')
                ]);
                redirect(base_url().'admin/pages/'.$page);
            }
        }
        $this->load_page();
    }
}