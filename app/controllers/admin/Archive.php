<?php
defined('BASEPATH') OR exit('Access Denied!');

class Archive extends Admin_Controller {
    public function __construct() {
        parent::__construct();
        $this->data['sub_title'] = 'ניהול ארכיון';
        if(!$this->users->has_permission($this->users->user['username'], 'manage_archive')) {
            redirect(base_url() . 'admin/dashboard');
        }
    }
    
	public function index($page = 1, $table = null) {
        $this->set_view('admin/show_archive');
        $this->data['data']['page'] = $page;
        if($table == null) {
            $table = $this->archive->get_archive()[0]['table'];
        }
        $this->data['data']['archive'] = $this->archive->get_archive($table, $page, $this->panel_pagination);
        if(count($this->data['data']['archive']) == 0 && $page != 1) {
            $page = 1;
            $this->data['data']['page'] = $page;
            $this->data['data']['archive'] = $this->archive->get_archive($table, $page, $this->panel_pagination);
        }
        if(count($this->data['data']['archive']) == 0) { 
            if($table == null) {
                redirect (base_url().'admin/dashboard'); 
            } else {
                redirect (base_url().'admin/archive'); 
            }
        }
        foreach($this->data['data']['archive'] as $key => $archive_item) {
            $archive_item['rows'] = json_decode($archive_item['rows'], true);
            if($table == 'users') {
                unset($archive_item['rows']['salt']);
                unset($archive_item['rows']['password']);
            }
            $this->data['data']['archive'][$key] = $archive_item;
        }
        $this->data['data']['table'] = $table;
        $this->data['data']['columns'] = array_keys($this->data['data']['archive'][0]['rows']);
        $tables = $this->site_model->get_tables_list();
        foreach ($tables as $table_name) {
            if($table_name != 'archive' && $this->archive->get_archive_number($table_name) >= 1) {
                $this->data['data']['tables'][] = $table_name;
            }
        }
        $config['suffix'] = '/'.$table;
        $config['uri_segment'] = 3;
        $config['base_url'] = base_url().'admin/archive/';
        $config['total_rows'] = $this->archive->get_archive_number($table);
        $config['per_page'] = $this->panel_pagination;
        $config['use_page_numbers'] = TRUE;

        $this->pagination->initialize($config);

        $this->data['data']['pagination'] = $this->pagination->create_links();
        $this->load_page();
	}
    
    public function delete($id, $page = 1, $table) {
        $this->archive->delete_archive($id);
        redirect(base_url().'admin/archive/'.$page.'/'.$table);
    }
}