<?php

class Categories_model extends CI_Model {
    private $categories = [];
    
    public function __construct() {
        parent::__construct();
        $this->load_categories();
    }
    
    public function load_categories() {
        $this->categories = $this->site_model->get('categories',[],'`order` ASC');
    }

    public function get_categories() {
        return $this->categories;
    }
    
    public function get_panel_categories($page, $per_page) {
        return array_slice($this->categories, ($page - 1) * $per_page, $per_page);
    }
    
    public function get_category($id) {
        foreach ($this->categories as $category) {
            if($category['ID'] == $id) {
                return $category;
            }
        }
        return [];
    }
    
    public function add_category($title, $machine_name) {
        $order = count($this->categories);
        $category = [
            'title' => $title,
            'machine_name' => $machine_name,
            'order' => $order
        ];
        $id = $this->site_model->insert('categories', $category);
        $category['ID'] = $id;
        $this->categories[] = $category;
        return $id;
    }
    
    public function edit_category($id, $updates) {
        foreach($this->categories as $ckey => $category) {
            if($category['ID'] == $id) {
                foreach ($updates as $key => $value) {
                    $category[$key] = $value;
                }
                $this->categories[$ckey] = $category;
            }
        }
        return $this->site_model->update('categories', ['ID' => $id], $updates);
    }
    
    public function delete_category($id) {
        $category = $this->get_category($id);
        if(isset($category['title'])) {
            $this->site_model->update('categories', ['`order` >' => $category['order']], ['`order`' => ['`order`-1', false]]);
            $return = $this->site_model->delete('categories', ['ID' => $id], 1);
            $this->load_categories();
            return $return;
        }
    }
    
    public function change_order($id, $up = true) {
        $category = $this->get_category($id);
        if(count($category) != 0) {
            if($up && $category['order'] >= 1) {
                $this->site_model->update('categories', ['`order`' => $category['order'] - 1], ['`order`' => $category['order']]);
                $this->edit_category($id, ['`order`' => [$category['order']-1, false]]);
            } elseif(!$up && $category['order'] < count($this->categories) - 1) {
                $this->site_model->update('categories', ['`order`' => $category['order'] + 1], ['`order`' => $category['order']]);
                $this->edit_category($id, ['`order`' => [$category['order']+1, false]]);
            }
        }
    }
}