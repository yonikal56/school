<?php
defined('BASEPATH') OR exit('Access Denied!');

class Settings extends Admin_Controller {
    public function __construct() {
        parent::__construct();
        $this->data['sub_title'] = 'הגדרות אתר';
        //if($this->users->has_permission($this->users->user['username'], 'manage_notices')) {
        //    
        //}
    }
    
	public function index($page = 1) {
        $this->set_view('admin/show_settings');
        $this->data['data']['page'] = $page;
        $this->data['data']['settings'] = $this->settings->get_settings();
        $this->data['data']['success-message'] = '';
        foreach ($this->data['data']['settings'] as $setting) {
            if($this->users->has_permission($this->users->user['username'], 'edit_'.$setting['machine_name'])) {
                $this->form_validation->set_rules($setting['machine_name'], $setting['name'], 'required'.(($setting['type'] == 'number') ? '|integer' : ''));
            }
        }
        if($this->form_validation->run()) {
            foreach ($this->data['data']['settings'] as $setting) {
                if($this->users->has_permission($this->users->user['username'], 'edit_'.$setting['machine_name'])) {
                    if($setting['content'] != $this->input->post($setting['machine_name'])) {
                        $this->settings->edit_setting($setting['machine_name'], $this->input->post($setting['machine_name']));
                    }
                }
            }
            $this->data['data']['success-message'] = 'שמרת את הנתונים בהצלחה';
        }
        $this->load_page();
	}
    
    public function edit() {
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