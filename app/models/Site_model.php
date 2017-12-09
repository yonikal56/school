<?php

class Site_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->database_installer();
    }
    
    public function database_installer() {
        $database_tables = [
            'users' => ['username' => 'TEXT','salt' => 'TEXT','password' => 'TEXT','permissions' => 'TEXT'],
            'follow' => ['username' => 'TEXT','time' => 'INT','changed'=>'TEXT','`from`'=>'TEXT','`to`'=>'TEXT'],
            'pages' => ['title'=>'TEXT','machine_name'=>'TEXT','content'=>'TEXT','time'=>'INT','keywords'=>'TEXT','description'=>'TEXT'],
            'menu' => ['title'=>'TEXT','internal'=>'INT','url'=>'TEXT','parent_ID'=>'INT','position'=>'INT','`order`'=>'INT'],
            'categories' => ['title'=>'TEXT','machine_name'=>'TEXT','`order`'=>'INT'],
            'links' => ['url'=>'TEXT','position'=>'TEXT','image'=>'TEXT','`order`'=>'INT','title'=>'TEXT'],
            'settings' => ['machine_name'=>'TEXT','content'=>'TEXT','name'=>'TEXT','type'=>'TEXT'],
            'notices' => ['time'=>'INT','title'=>'TEXT','document'=>'TEXT'],
            'galleries' => ['title'=>'TEXT','machine_name'=>'TEXT','slider'=>'INT','images'=>'TEXT'],
            'archive' => ['`table`'=>'TEXT','rows'=>'TEXT'],
            'uploads' => ['name'=>'TEXT','time'=>'INT','username'=>'TEXT'],
            'calender' => ['name'=>'TEXT','times'=>'TEXT','layer'=>'TEXT']
        ];
        $inserts = [
            'settings' => [
                ['machine_name'=>'notices_limit','content'=>10,'name'=>'הגבלת הודעות','type'=>'number'],
                ['machine_name'=>'user_connection_time','content'=>5,'name'=>'מספר דקות שהמשתמש מחובר לאחר חוסר פעילות','type'=>'number'],
                ['machine_name'=>'panel_pagination','content'=>15,'name'=>'כמות שורות המוצגת בדף אחד בפאנל','type'=>'number']
            ]
        ];
        
        
        foreach ($database_tables as $table_name => $table_parameters) {
            $query = $this->db->query("SHOW TABLES LIKE ?", [$table_name]);
            if($query->num_rows() == 0)
            {
                $query = "CREATE TABLE " . $table_name . "(ID INT NOT NULL AUTO_INCREMENT,";
                foreach ($table_parameters as $field => $type) {
                    $binds[] = $field;
                    $binds[] = $type;
                    $query .= "{$field} {$type} NOT NULL,";
                }
                $query .= "PRIMARY KEY (ID)) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8";
                $result = $this->db->query($query);

                if(isset($inserts[$table_name])) {
                    foreach($inserts[$table_name] as $insert_value) {
                        $this->db->insert($table_name, $insert_value);
                    }
                }
            }
        }
    }
    
    public function get($table = 'settings', $where = [], $order_by = null, $limit = null) {
        if($limit != null) {
            if(is_array($limit)) {
                $this->db->limit($limit[0], $limit[1]);
            }
            else {
                $this->db->limit($limit);
            }
        }
        if($order_by != null) {
            $orders = explode(' ', $order_by);
            $this->db->order_by($orders[0], $orders[1]);
        }
        if(count($where)) {
            return $this->db->get_where($table, $where)->result_array();
        }
        else {
            return $this->db->get($table)->result_array();
        }
    }
    
    public function insert($table = 'settings', $inserts = []) {
        $this->db->insert($table, $inserts);
        return $this->db->insert_id();
    }
    
    public function update($table = 'settings', $where = [], $updates = []) {
        $replace_in = [base_url(), '../../../../'];
        $replace_out = ['{base}', '{base}'];
        foreach ($updates as $key => $value) {
            if(is_array($value)) {
                $this->db->set($key, str_replace($replace_in, $replace_out, $value[0]), str_replace($replace_in, $replace_out, $value[1]));
            }
            else {
                $this->db->set($key, str_replace($replace_in, $replace_out, $value));
            }
        }
        $this->db->update($table, [], $where);
        if($this->db->affected_rows() >=0) {
            return true;
        } 
        else {
            return false; 
        }
    }
    
    public function delete($table = 'settings', $where = [], $limit = null) {
        $row = $this->get($table, $where);
        if(isset($row[0])) {
            if($table != 'archive') {
                $this->archive->add_archive($table, json_encode($row[0]));
            }
            if($limit != null) {
                $this->db->delete($table, $where, $limit);
            }
            else {
                $this->db->delete($table, $where);
            }
        }
        return $this->db->affected_rows();
    }
    
    public function get_tables_list() {
        $list_of_tables = [];
        $tables = $this->db->query("SHOW TABLES")->result_array();
        foreach ($tables as $table) {
            $list_of_tables[] = reset($table);
        }
        return $list_of_tables;
    }
}