<?php
defined('BASEPATH') OR exit('Access Denied!');

class Menu extends Admin_Controller {
    public function __construct() {
        parent::__construct();
        $this->data['sub_title'] = 'ניהול תפריט';
        if(!$this->users->has_permission($this->users->user['username'], 'manage_menu')) {
            redirect(base_url() . 'admin/dashboard');
        }
    }
    
    public function index($page = 1, $position = 'top') {
        $this->set_view('admin/show_menu');
        $this->data['data']['page'] = $page;
        $this->data['data']['position'] = $position;
        $this->data['data']['hebrew_menu'] = ($position == "top" ? 'תפריט עליון' : 'תפריט צד');
        $this->data['data']['menus_names'] = $this->menus->get_all_menu($position);
        $this->data['data']['menu'] = $this->menus->get_panel_menu($position, $page, $this->panel_pagination);
        if(count($this->data['data']['menu']) == 0 && $page != 1) {
            $page = 1;
            $this->data['data']['page'] = $page;
            $this->data['data']['menu'] = $this->menus->get_panel_menu($position, $page, $this->panel_pagination);
        }
        $config['suffix'] = '/'.$position;
        $config['uri_segment'] = 3;
        $config['base_url'] = base_url().'admin/menu/';
        $config['total_rows'] = $this->menus->get_panel_number($position);
        $config['per_page'] = $this->panel_pagination;
        $config['use_page_numbers'] = TRUE;

        $this->pagination->initialize($config);

        $this->data['data']['pagination'] = $this->pagination->create_links();
        $this->load_page();
	}
    
    public function delete($id, $page) {
        $menu = $this->menus->get_menu_item($id);
        if(count($menu)) {
            $this->menus->delete_menu_item($id);
            redirect(base_url().'admin/menu/'.$page.'/'.$this->menus->get_named_position($menu['position']));
        }
        redirect(base_url().'admin/menu/'.$page);
    }
    
    public function add($position = 0) {
        $this->form_validation->set_rules('title', 'כותרת', 'trim|required|min_length[3]|max_length[50]');
        $this->form_validation->set_rules('url', 'URL', 'trim|required');
        if($this->form_validation->run()) {
            $this->menus->add_menu_item($this->input->post('title'), (int) $this->input->post('internal'), $this->input->post('url'), $this->input->post('parent_ID'), $this->menus->get_unnamed_position($position));
            redirect(base_url().'admin/menu/1/'.$position);
        }
        $this->index(1, $position);
    }
    
    public function up($id = null, $page = 1) {
        $menu = $this->menus->get_menu_item($id);
        if(count($menu)) {
            $this->menus->change_order($id, true);
            redirect(base_url().'admin/menu/'.$page.'/'.$this->menus->get_named_position($menu['position']));
        }
        redirect(base_url().'admin/menu/'.$page);
    }
    
    public function down($id = null, $page = 1) {
        $menu = $this->menus->get_menu_item($id);
        if(count($menu)) {
            $this->menus->change_order($id, false);
            redirect(base_url().'admin/menu/'.$page.'/'.$this->menus->get_named_position($menu['position']));
        }
        redirect(base_url().'admin/menu/'.$page);
    }
    
    public function edit($id = null, $page = 1) {
        $this->set_view('admin/edit_menu');
        $this->data['data']['page'] = $page;
        $this->data['data']['menu'] = $this->menus->get_menu_item($id);
        if(count($this->data['data']['menu']) == 0) {
            redirect(base_url().'admin/menu/'.$page);
        }
        $this->form_validation->set_rules('title', 'כותרת', 'trim|required|min_length[3]|max_length[50]');
        $this->form_validation->set_rules('url', 'URL', 'trim|required');
        if($this->form_validation->run()) {
            $this->menus->edit_menu($id, [
                'title' => $this->input->post('title'),
                'url' => $this->input->post('url'),
                'internal' => (int) $this->input->post('internal')
            ]);
            redirect(base_url().'admin/menu/'.$page.'/'.$this->menus->get_named_position($this->data['data']['menu']['position']));
        }
        $this->load_page();
    }
}