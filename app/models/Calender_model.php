<?php

class Calender_model extends CI_Model {
    private $calenders = [];
    
    public function __construct() {
        parent::__construct();
        $this->load_calender();
    }
    
    public function load_calender() {
        $this->calenders = $this->site_model->get('calender',[],'times DESC');
    }

    public function get_calender() {
        return $this->calenders;
    }
    
    public function get_match_time($time) {
        return date("Y-m-d", strtotime(str_replace('/', '-', $time)));
    }
    
    public function get_calander_events() {
        $events = [];
        foreach($this->calenders as $calender) {
            $events[] = "{
                title: '{$calender['name']}',
                start: '".$this->get_match_time($calender['times'])."'
            }";
        }
        return implode(",", $events);
    }
    
    public function get_calender_by_id($id) {
        foreach ($this->calenders as $event) {
            if($event['ID'] == $id) {
                return $event;
            }
        }
        return [];
    }
    
    public function get_panel_calender($page, $per_page) {
        return array_slice($this->calenders, ($page-1)*$per_page, $per_page);
    }
    
    public function add_calender($name, $times, $layer = "0") {
        $new_calender = [
            'name' => $name,
            'times' => $times,
            'layer' => $layer
        ];
        $inserted_id = $this->site_model->insert('calender', $new_calender);
        $new_calender['ID'] = $inserted_id;
        array_unshift($this->calenders, $new_calender);
        return $inserted_id;
    }
    
    public function delete_calender($id) {
        $this->site_model->delete('calender', ['ID' => $id], 1);
        $this->load_calender();
    }
    
    public function edit_calender($id, $updates) {
        foreach($this->calenders as $ckey => $calender) {
            if($calender['ID'] == $id) {
                foreach ($updates as $key => $value) {
                    $calender[$key] = $value;
                }
                $this->calenders[$ckey] = $calender;
            }
        }
        return $this->site_model->update('calender', ['ID' => $id], $updates);
    }
}