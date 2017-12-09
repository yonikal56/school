<?php
defined('BASEPATH') OR exit('Access Denied!');

class Links extends Admin_Controller {
    public function __construct() {
        parent::__construct();
        $this->data['sub_title'] = 'ניהול לינקים';
        if(!$this->users->has_permission($this->users->user['username'], 'manage_links')) {
            redirect(base_url() . 'admin/dashboard');
        }
    }
    
	public function index($page = 1, $position = 0) {
        $this->set_view('admin/show_links');
        $this->data['data']['page'] = $page;
        $this->data['data']['position'] = $position;
        $this->data['data']['links'] = $this->links->get_panel_links($position, $page, $this->panel_pagination);
        if(count($this->data['data']['links']) == 0 && $page != 1) {
            $page = 1;
            $this->data['data']['page'] = $page;
            $this->data['data']['links'] = $this->links->get_panel_links($position, $page, $this->panel_pagination);
        }
        $config['suffix'] = '/'.$position;
        $config['uri_segment'] = 3;
        $config['base_url'] = base_url().'admin/links/';
        $config['total_rows'] = count($this->links->get_links($position));
        $config['per_page'] = $this->panel_pagination;
        $config['use_page_numbers'] = TRUE;

        $this->pagination->initialize($config);

        $this->data['data']['pagination'] = $this->pagination->create_links();
        $this->load_page();
	}
    
    public function delete($id, $page) {
        $link = $this->links->get_link($id);
        if(count($link)) {
            $this->links->delete_link($id);
            redirect(base_url().'admin/links/'.$page.'/'.$link['position']);
        }
        redirect(base_url().'admin/menu/'.$page);
    }
    
    public function add($position = 0) {
        $this->form_validation->set_rules('title', 'כותרת', 'trim|required|min_length[3]|max_length[50]');
        $this->form_validation->set_rules('url', 'URL', 'trim|required');
        if($this->form_validation->run()) {
            $this->links->add_link($this->input->post('title'), $this->input->post('url'), $position, $this->input->post('image'));
            redirect(base_url().'admin/links/1/'.$position);
        }
        $this->index(1, $position);
    }
    
    public function up($id = null, $page = 1) {
        $link = $this->links->get_link($id);
        if(count($link)) {
            $this->links->change_order($id, true);
            redirect(base_url().'admin/links/'.$page.'/'.$link['position']);
        }
        redirect(base_url().'admin/links/'.$page);
    }
    
    public function down($id = null, $page = 1) {
        $link = $this->links->get_link($id);
        if(count($link)) {
            $this->links->change_order($id, false);
            redirect(base_url().'admin/links/'.$page.'/'.$link['position']);
        }
        redirect(base_url().'admin/links/'.$page);
    }
    
    public function edit($id = null, $page = 1) {
        if($id == null) {
            redirect(base_url().'admin/links/'.$page);
        } else {
            $this->set_view('admin/edit_links');
            $this->data['data']['page'] = $page;
            $this->data['data']['link'] = $this->links->get_link($id);
            if(count($this->data['data']['link']) == 0) {
                redirect(base_url().'admin/links/'.$page);
            }
            $this->form_validation->set_rules('title', 'כותרת', 'trim|required|min_length[3]|max_length[50]');
            $this->form_validation->set_rules('url', 'URL', 'trim|required');
            if($this->form_validation->run()) {
                $this->links->edit_link($id, [
                    'title' => $this->input->post('title'),
                    'url' => $this->input->post('url'),
                    'image' => $this->input->post('image')
                ]);
                redirect(base_url().'admin/links/'.$page.'/'.$this->data['data']['link']['position']);
            }
        }
        $this->load_page();
    }
}