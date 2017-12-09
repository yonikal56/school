<?php
defined('BASEPATH') OR exit('Access Denied!');

class Home extends MY_Controller {
    
	public function index()
	{
        $this->load_page();
	}
    
    public function page($page = 'home')
    {
        $page = $this->pages->get_page_by_machine_name($page);
        $this->data['sub_title'] = isset($page['title']) ? $page['title'] : '';
        $this->data['data'] = [
            'page' => $page,
            'full_page' => true
        ];
        $this->set_view('templates/page');
        $this->load_page();
    }
    
    public function calendar() {
        $this->data['sub_title'] = "לוח שנה";
        $this->data['data'] = [
            
        ];
        $this->set_view('templates/calendar');
        $this->load_page();
    }
    
    public function gallery($gallery = 'index')
    {
		$gallery = urldecode($gallery);
        $gallery = $this->galleries->get_gallery($gallery);
        $this->data['sub_title'] = isset($gallery['title']) ? $gallery['title'] : '';
        $this->data['data'] = [
            'gallery' => $gallery
        ];
        $this->set_view('templates/gallery');
        $this->load_page();
    }
}