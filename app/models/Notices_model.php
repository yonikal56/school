<?php

class Notices_model extends CI_Model {
    private $notices = [];
    private $notices_limit = 10;
    
    public function __construct() {
        parent::__construct();
        $this->notices_limit = $this->settings->get_setting('notices_limit');
        $this->notices_limit = $this->notices_limit != '' ? $this->notices_limit : 10;
        $this->load_notices();
    }
    
    public function load_notices() {
        $this->notices = $this->site_model->get('notices',[],'time DESC');
    }

    public function get_notices() {
        return array_splice($this->notices, 0, $this->notices_limit);
    }
    
    public function get_notices_number() {
        return count($this->notices);
    }
    
    public function get_notice($id) {
        foreach($this->notices as $nkey => $notice) {
            if($notice['ID'] == $id) {
                return $notice;
            }
        }
        return [];
    }
    
    public function get_panel_notices($page, $per_page) {
        return array_slice($this->notices, ($page - 1) * $per_page, $per_page);
    }
    
    public function add_notice($title, $document) {
        $new_notice = [
            'time' => time(),
            'title' => $title,
            'document' => $document
        ];
        $inserted_id = $this->site_model->insert('notices', $new_notice);
        $new_notice['ID'] = $inserted_id;
        array_unshift($this->notices, $new_notice);
        return $inserted_id;
    }
    
    public function delete_notice($id) {
        $this->site_model->delete('notices', ['ID' => $id], 1);
        $this->load_notices();
    }
    
    public function edit_notice($id, $updates) {
        foreach($this->notices as $nkey => $notice) {
            if($notice['ID'] == $id) {
                foreach ($updates as $key => $value) {
                    $notice[$key] = $value;
                }
                $this->notices[$nkey] = $notice;
            }
        }
        return $this->site_model->update('notices', ['ID' => $id], $updates);
    }
}