<?php

class Follow_model extends CI_Model {
    private $follows = [];
    
    public function __construct() {
        parent::__construct();
        $this->load_follows();
    }
    
    public function load_follows() {
        $this->follows = $this->site_model->get('follow',[],'time DESC');
    }

    public function get_follows() {
        return $this->follows;
    }
    
    public function get_panel_follow($page, $per_page) {
        return array_slice($this->follows, ($page-1)*$per_page, $per_page);
    }
    
    public function get_follow($id) {
        foreach ($this->follows as $follow) {
            if($follow['ID'] == $id) {
                return $follow;
            }
        }
    }
    
    public function add_follow($username, $changed, $from, $to) {
        $follow = [
            'username' => $username,
            'time' => time(),
            'changed' => $changed,
            'from' => $from,
            'to' => $to
        ];
        $id = $this->site_model->insert('follow', $follow);
        $follow['ID'] = $id;
        array_unshift($this->follows, $follow);
        return $id;
    }
    
    public function delete_follow($id) {
        $link = $this->get_follow($id);
        if(isset($link['time'])) {
            $return = $this->site_model->delete('follow', ['ID' => $id], 1);
            $this->load_follows();
            return $return;
        }
    }
}