<?php
defined('BASEPATH') OR exit('Access Denied!');

class Dashboard extends Admin_Controller {
    
	public function index() {
        $this->load_page();
	}
    
    public function login() {
        $this->form_validation->set_rules('username', 'שם משתמש', 'trim|required|max_length[20]');
        $this->form_validation->set_rules('password', 'סיסמא', 'trim|required|min_length[6]|max_length[20]|callback_check_details');
        if($this->form_validation->run()) {
            $this->users->login($this->input->post('username'), $this->input->post('password'));
            redirect(base_url().'admin/dashboard');
        }
        $this->set_view('admin/login');
        $this->load_page();
    }
    
    public function updatePass() {
        $this->form_validation->set_rules('password', 'סיסמא נוכחית', 'trim|required|min_length[6]|max_length[20]|callback_check_details2');
        $this->form_validation->set_rules('newPassword', 'סיסמא חדשה', 'trim|required|min_length[6]|max_length[20]');
        if($this->form_validation->run()) {
            $this->data['data']['success_message'] = 'הסיסמא עודכנה בהצלחה';
            $this->users->edit_user($this->users->user['ID'], [
                'password' => encrypt_password($this->input->post('newPassword'), $this->users->user['salt'])
            ]);
            $this->users->login($this->users->user['username'], $this->input->post('newPassword'));
        }
        $this->set_view('admin/edit_password');
        $this->load_page();
    }
    
    public function logout() {
        $this->users->logout();
        redirect(base_url().'admin/dashboard');
    }
    
    public function check_details() {
        return $this->users->check_details($this->input->post('username'), $this->input->post('password'));
    }
    
    public function check_details2() {
        return $this->users->check_details($this->users->user['username'], $this->input->post('password'));
    }
}