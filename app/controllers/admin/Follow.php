<?php
defined('BASEPATH') OR exit('Access Denied!');

class Follow extends Admin_Controller {
    public function __construct() {
        parent::__construct();
        $this->data['sub_title'] = 'ניהול מעקב';
        if(!$this->users->has_permission($this->users->user['username'], 'follow_users')) {
            redirect(base_url().'admin/dashboard');
        }
    }
    
	public function index($page = 1) {
        $this->set_view('admin/show_follow');
        $this->data['data']['page'] = $page;
        $this->data['data']['follow'] = $this->follow->get_panel_follow($page, $this->panel_pagination);
        if(count($this->data['data']['follow']) == 0 && $page != 1) {
            $page = 1;
            $this->data['data']['page'] = $page;
            $this->data['data']['follow'] = $this->follow->get_panel_follow($page, $this->panel_pagination);
        }
        $config['base_url'] = base_url().'admin/follow/';
        $config['total_rows'] = count($this->follow->get_follows());
        $config['per_page'] = $this->panel_pagination;
        $config['use_page_numbers'] = TRUE;

        $this->pagination->initialize($config);

        $this->data['data']['pagination'] = $this->pagination->create_links();
        $this->load_page();
	}
    
    public function delete($id, $page) {
        $this->follow->delete_follow($id);
        redirect(base_url().'admin/follow/'.$page);
    }
}