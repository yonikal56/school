<?php
defined('BASEPATH') OR exit('Access Denied!');

class Galleries extends Admin_Controller {
    public function __construct() {
        parent::__construct();
        $this->data['sub_title'] = 'ניהול גלריות';
        if(!$this->users->has_permission($this->users->user['username'], 'manage_gallery')) {
            redirect(base_url() . 'admin/dashboard');
        }
    }
    
	public function index($page = 1) {
        $this->set_view('admin/show_galleries');
        $this->data['data']['page'] = $page;
        $this->data['data']['galleries'] = $this->galleries->get_panel_galleries($page, $this->panel_pagination);
        if(count($this->data['data']['galleries']) == 0 && $page != 1) {
            $page = 1;
            $this->data['data']['page'] = $page;
            $this->data['data']['galleries'] = $this->galleries->get_panel_galleries($page, $this->panel_pagination);
        }
        $config['base_url'] = base_url().'admin/galleries/';
        $config['total_rows'] = count($this->galleries->get_galleries());
        $config['per_page'] = $this->panel_pagination;
        $config['use_page_numbers'] = TRUE;

        $this->pagination->initialize($config);

        $this->data['data']['pagination'] = $this->pagination->create_links();
        $this->load_page();
	}
    
    public function delete($id, $page) {
        $gallery = $this->galleries->get_gallery_by_id($id);
        if(count($gallery)) {
            $this->galleries->delete_gallery($id);
            redirect(base_url().'admin/galleries/'.$page);
        }
        redirect(base_url().'admin/galleries/'.$page);
    }
    
    public function add() {
        $this->form_validation->set_rules('title', 'כותרת', 'trim|required|min_length[3]|max_length[50]');
        $this->form_validation->set_rules('machine_name', 'כתובת URL אישית', 'trim|required');
        if($this->form_validation->run()) {
            $this->galleries->add_gallery($this->input->post("title"), $this->input->post("machine_name"), (int) $this->input->post('slider'), "");
            redirect(base_url().'admin/galleries/1');
        }
        $this->index(1);
    }
    
    public function edit($id = null, $page = 1) {
        if($id == null) {
            redirect(base_url().'admin/galleries/'.$page);
        } else {
            $this->set_view('admin/edit_gallery');
            $this->data['data']['page'] = $page;
            $this->data['data']['gallery'] = $this->galleries->get_gallery_by_id($id);
            if(count($this->data['data']['gallery']) == 0) {
                redirect(base_url().'admin/galleries/'.$page);
            }
            $this->form_validation->set_rules('title', 'כותרת', 'trim|required|min_length[3]|max_length[50]');
            $this->form_validation->set_rules('machine_name', 'כתובת URL אישית', 'trim|required');
            if($this->form_validation->run()) {
                $this->galleries->edit_gallery($id, [
                    'title' => $this->input->post('title'),
                    'machine_name' => $this->input->post('machine_name'),
                    'slider' => (int) $this->input->post('slider'),
                    'images' => join(';',$this->input->post('images'))
                ]);
                redirect(base_url().'admin/galleries/'.$page);
            }
        }
        $this->load_page();
    }
}