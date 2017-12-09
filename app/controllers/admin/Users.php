<?php
defined('BASEPATH') OR exit('Access Denied!');

class Users extends Admin_Controller {
    public function __construct() {
        parent::__construct();
        $this->data['sub_title'] = 'ניהול משתמשים';
        if(!$this->users->has_permission($this->users->user['username'], 'manage_users')) {
            redirect(base_url().'admin/dashboard');
        }
    }
    
	public function index($page = 1) {
        $this->set_view('admin/show_users');
        $this->data['data']['page'] = $page;
        $this->data['data']['users'] = $this->users->get_panel_users($page, $this->panel_pagination);
        if(count($this->data['data']['users']) == 0 && $page != 1) {
            $page = 1;
            $this->data['data']['page'] = $page;
            $this->data['data']['users'] = $this->notices->get_panel_users($page, $this->panel_pagination);
        }
        $config['base_url'] = base_url().'admin/users/';
        $config['total_rows'] = count($this->users->get_users());
        $config['per_page'] = $this->panel_pagination;
        $config['use_page_numbers'] = TRUE;

        $this->pagination->initialize($config);

        $this->data['data']['pagination'] = $this->pagination->create_links();
        $this->load_page();
	}
    
    public function delete($id, $page) {
        $this->users->delete_user($id);
        redirect(base_url().'admin/users/'.$page);
    }
    
    public function add() {
        $this->form_validation->set_rules('username', 'שם משתמש', 'trim|required|min_length[3]|max_length[18]');
        $this->form_validation->set_rules('password', 'סיסמא', 'trim|required|min_length[6]|max_length[18]');
        if($this->form_validation->run()) {
            $this->users->register_user($this->input->post('username'), $this->input->post('password'), "");
            redirect(base_url().'admin/users');
        }
        $this->index();
    }
    
    public function edit($id = null, $page = 1) {
        if($id == null) {
            redirect(base_url().'admin/users/'.$page);
        } else {
            $this->set_view('admin/edit_users');
            $permissions = [
                ['name'=>'הכל','value'=>'all'],
                ['name'=>'ניהול ארכיון','value'=>'manage_archive'],
                ['name'=>'ניהול לוח שנה','value'=>'manage_calender'],
                ['name'=>'ניהול קטגוריות','value'=>'manage_categories'],
                ['name'=>'ניהול גלריות','value'=>'manage_gallery'],
                ['name'=>'ניהול לינקים','value'=>'manage_links'],
                ['name'=>'ניהול תפריט','value'=>'manage_menu'],
                ['name'=>'ניהול עדכונים','value'=>'manage_notices'],
                ['name'=>'ניהול דפים','value'=>'manage_pages'],
                ['name'=>'ניהול קבצים','value'=>'manage_uploads']
            ];
            $this->data['data']['page'] = $page;
            $this->data['data']['user'] = $this->users->get_user_by_id($id);
            $this->data['data']['user_permissions'] = explode(',', $this->data['data']['user']['permissions']);
            $this->data['data']['permissions'] = $permissions;
            if(count($this->data['data']['user']) == 0) {
                redirect(base_url().'admin/users/'.$page);
            }
            $this->form_validation->set_rules('permissions[]', 'הרשאות', 'trim|required');
            if($this->form_validation->run()) {
                $this->users->edit_user($id, [
                    'permissions' => join(',', $this->input->post('permissions[]'))
                ]);
                redirect(base_url().'admin/users/'.$page);
            }
        }
        $this->load_page();
    }
}