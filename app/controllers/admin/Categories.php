<?php
defined('BASEPATH') OR exit('Access Denied!');

class Categories extends Admin_Controller {
    public function __construct() {
        parent::__construct();
        $this->data['sub_title'] = 'ניהול קטגוריות';
        if(!$this->users->has_permission($this->users->user['username'], 'manage_categories')) {
            redirect(base_url().'admin/dashboard');
        }
    }
    
	public function index($page = 1) {
        $this->set_view('admin/show_categories');
        $this->data['data']['page'] = $page;
        $this->data['data']['categories'] = $this->categories->get_panel_categories($page, $this->panel_pagination);
        if(count($this->data['data']['categories']) == 0 && $page != 1) {
            $page = 1;
            $this->data['data']['page'] = $page;
            $this->data['data']['categories'] = $this->categories->get_panel_categories($page, $this->panel_pagination);
        }
        $config['base_url'] = base_url().'admin/categories/';
        $config['total_rows'] = count($this->categories->get_categories());
        $config['per_page'] = $this->panel_pagination;
        $config['use_page_numbers'] = TRUE;

        $this->pagination->initialize($config);

        $this->data['data']['pagination'] = $this->pagination->create_links();
        $this->load_page();
	}
    
    public function delete($id, $page) {
        $this->categories->delete_category($id);
        redirect(base_url().'admin/categories/'.$page);
    }
    
    public function add() {
        $this->form_validation->set_rules('title', 'כותרת', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('machine_name', 'כתובת URL אישית', 'trim|required|max_length[15]');
        if($this->form_validation->run()) {
            $this->categories->add_category($this->input->post('title'), $this->input->post('machine_name'));
            redirect(base_url().'admin/categories');
        }
        $this->index();
    }
    
    public function edit($id = null, $page = 1) {
        if($id == null) {
            redirect(base_url().'admin/categories/'.$page);
        } else {
            $this->set_view('admin/edit_cateogories');
            $this->data['data']['page'] = $page;
            $this->data['data']['category'] = $this->categories->get_category($id);
            if(count($this->data['data']['category']) == 0) {
                redirect(base_url().'admin/categories/'.$page);
            }
            $this->form_validation->set_rules('title', 'כותרת', 'trim|required|max_length[50]');
            $this->form_validation->set_rules('machine_name', 'כתובת URL אישית', 'trim|required|max_length[15]');
            if($this->form_validation->run()) {
                $this->categories->edit_category($id, ['title' => $this->input->post('title'), 'machine_name' => $this->input->post('machine_name')]);
                redirect(base_url().'admin/categories/'.$page);
            }
        }
        $this->load_page();
    }
    
    public function up($id = null, $page = 1) {
        $this->categories->change_order($id, true);
        redirect(base_url().'admin/categories/'.$page);
    }
    
    public function down($id = null, $page = 1) {
        $this->categories->change_order($id, false);
        redirect(base_url().'admin/categories/'.$page);
    }
}