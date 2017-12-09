<?php

class Pages_model extends CI_Model {
    private $pages = [];
    
    public function __construct() {
        parent::__construct();
        $this->load_pages();
    }
    
    public function load_pages() {
        $this->pages = $this->site_model->get('pages',[],'time DESC');
    }

    public function get_pages() {
        return $this->pages;
    }
    
    public function get_page($id) {
        foreach ($this->pages as $page) {
            if($page['ID'] == $id) {
                return $page;
            }
        }
        return [];
    }
    
    public function get_page_by_machine_name($machine_name) {
        foreach ($this->pages as $page) {
            if($page['machine_name'] == $machine_name) {
                return $page;
            }
        }
        return [];
    }
    
    public function get_panel_pages($page, $per_page) {
        return array_slice($this->pages, ($page-1)*$per_page, $per_page);
    }
    
    public function add_page($title, $machine_name, $content, $keywords, $description) {
        $new_page = [
            'title' => $title,
            'machine_name' => $machine_name,
            'content' => $content,
            'time' => time(),
            'keywords' => $keywords,
            'description' => $description
        ];
        $inserted_id = $this->site_model->insert('pages', $new_page);
        $new_page['ID'] = $inserted_id;
        array_unshift($this->pages, $new_page);
        return $inserted_id;
    }
    
    public function delete_page($id) {
        $this->site_model->delete('pages', ['ID' => $id], 1);
        $this->load_pages();
    }
    
    public function edit_page($id, $updates) {
        foreach($this->pages as $pkey => $page) {
            if($page['ID'] == $id) {
                foreach ($updates as $key => $value) {
                    $page[$key] = $value;
                }
                $this->pages[$pkey] = $page;
            }
        }
        return $this->site_model->update('pages', ['ID' => $id], $updates);
    }
}