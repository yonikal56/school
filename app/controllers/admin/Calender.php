<?php
defined('BASEPATH') OR exit('Access Denied!');

class Calender extends Admin_Controller {
    public function __construct() {
        parent::__construct();
        $this->data['sub_title'] = 'ניהול לוח שנה';
        if(!$this->users->has_permission($this->users->user['username'], 'manage_calender')) {
            redirect(base_url() . 'admin/dashboard');
        }
    }
    
	public function index($page = 1) {
        $this->set_view('admin/show_calender');
        $this->data['data']['page'] = $page;
        $this->data['data']['calender'] = $this->calender->get_panel_calender($page, $this->panel_pagination);
        if(count($this->data['data']['calender']) == 0 && $page != 1) {
            $page = 1;
            $this->data['data']['page'] = $page;
            $this->data['data']['calender'] = $this->calendar->get_panel_calender($page, $this->panel_pagination);
        }
        $config['base_url'] = base_url().'admin/calender/';
        $config['total_rows'] = count($this->calender->get_calender());
        $config['per_page'] = $this->panel_pagination;
        $config['use_page_numbers'] = TRUE;

        $this->pagination->initialize($config);

        $this->data['data']['pagination'] = $this->pagination->create_links();
        $this->load_page();
	}
    
    public function delete($id, $page) {
        $this->calender->delete_calender($id);
        redirect(base_url().'admin/calender/'.$page);
    }
    
    public function add() {
        $this->form_validation->set_rules('title', 'אירוע', 'trim|required|min_length[5]|max_length[50]');
        $this->form_validation->set_rules('times', 'תאריכים', 'trim|required|min_length[10]|max_length[50]');
        if($this->form_validation->run()) {
            $this->calender->add_calender($this->input->post('title'), $this->input->post('times'));
            redirect(base_url().'admin/calender');
        }
        $this->index();
    }
    
    public function edit($id = null, $page = 1) {
        if($id == null) {
            redirect(base_url().'admin/calender/'.$page);
        } else {
            $this->set_view('admin/edit_calender');
            $this->data['data']['page'] = $page;
            $this->data['data']['event'] = $this->calender->get_calender_by_id($id);
            if(count($this->data['data']['event']) == 0) {
                redirect(base_url().'admin/calender/'.$page);
            }
            $this->form_validation->set_rules('title', 'אירוע', 'trim|required|min_length[5]|max_length[50]');
            $this->form_validation->set_rules('times', 'תאריכים', 'trim|required|min_length[10]|max_length[50]');
            if($this->form_validation->run()) {
                $this->calender->edit_calender($id, ['name' => $this->input->post('title'), 'times' => $this->input->post('times')]);
                redirect(base_url().'admin/calender/'.$page);
            }
        }
        $this->load_page();
    }
}