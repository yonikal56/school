<?php

class MY_Controller extends CI_Controller {
    
    protected $data = ['view' => 'home', 'data' => []];
    public $panel_pagination;
    
    public function __construct() {
        parent::__construct();
        
        //Global Form Errors
        $this->form_validation->set_message('required', 'חייב למעלה את השדה %s');
        $this->form_validation->set_message('min_length', 'השדה %s חייב להיות לפחות %d תווים');
        $this->form_validation->set_message('max_length', 'השדה %s חייב להיות עד %d תווים');
        
        //Models Loading
        $this->load->model('Archive_model', 'archive');
        $this->load->model('Settings_model', 'settings');
        $this->load->model('Users_model', 'users');
        $this->load->model('Notices_model', 'notices');
        $this->load->model('Menus_model', 'menus');
        $this->load->model('Links_model', 'links');
        $this->load->model('Categories_model', 'categories');
        $this->load->model('Pages_model', 'pages');
        $this->load->model('Follow_model', 'follow');
        $this->load->model('Galleries_model', 'galleries');
        $this->load->model('Uploads_model', 'uploads');
        $this->load->model('Calender_model', 'calender');
        
        $this->panel_pagination = $this->settings->get_setting('panel_pagination');
        $this->panel_pagination = $this->panel_pagination != '' ? $this->panel_pagination : 15;
    }
    
    public function load_page()
    {
        $this->load->view('templates/main', $this->data);
    }
    
    public function set_view($view)
    {
        $this->data['view'] = $view;
    }
}

class Admin_Controller extends MY_Controller {
    public function __construct() {
        parent::__construct();
        
        //Admins Form Validation
        $this->form_validation->set_message('check_details', 'שם משתמש או סיסמא לא נכונים');
        $this->form_validation->set_message('check_details2', 'סיסמא נוכחית לא נכונה');
        $this->form_validation->set_message('integer', 'השדה %s חייב להכיל ערך מספרי');
        
        //Login Validation
        if($this->uri->segment(2) != 'login') {
            if(!$this->users->if_connected()) {
                redirect(base_url() . 'admin/login');
            }
        } else {
            if($this->users->if_connected()) {
                redirect(base_url() . 'admin/dashboard');
            }
        }
    }
}
