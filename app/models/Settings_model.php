<?php

class Settings_model extends CI_Model {
    private $settings = [];
    
    public function __construct() {
        parent::__construct();
        $this->load_setings();
    }
    
    public function load_setings() {
        $settings = $this->site_model->get();
        foreach ($settings as $setting) {
            $this->settings[$setting['machine_name']] = $setting;
        }
    }
    
    public function get_settings() {
        return $this->settings;
    }
    
    public function get_setting($name, $full = false) {
        if(isset($this->settings[$name])) {
            return ($full) ? $this->settings[$name] : $this->settings[$name]['content'];
        }
        return '';
    }
    
    public function edit_setting($name, $new_value) {
        if(isset($this->settings[$name])) {
            $this->settings[$name]['content'] = $new_value;
        }
        $this->site_model->update('settings', ['machine_name' => $name], ['content' => $new_value]);
    }
    
    private function add_setting($machine_name, $value, $name, $type) {
        if(!isset($this->settings[$machine_name])) {
            $setting = [
                'machine_name' => $machine_name,
                'content' => $value,
                'name' => $name,
                'type' => $type
            ];
            $id = $this->site_model->insert('settings', $setting);
            $setting['ID'] = $id;
            $this->settings[$machine_name] = $setting;
            return $id;
        }
        else {
            return false;
        }
    }
}