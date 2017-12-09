<?php

class Links_model extends CI_Model {
    private $links = [];
    
    public function __construct() {
        parent::__construct();
        $this->load_links();
    }
    
    public function load_links() {
        $this->links = $this->site_model->get('links',[],'`order` ASC');
    }
    
    public function get_positions() {
        $positions = [];
        foreach ($this->links as $link) {
            if(!in_array($link['position'], $positions)) {
                $positions[] = $link['position'];
            }
        }
        return $positions;
    }

    public function get_links($position) {
        $links = [];
        foreach ($this->links as $link) {
            if($link['position'] == $position) {
                $links[] = $link;
            }
        }
        return $links;
    }
    
    public function get_panel_links($position, $page, $per_page) {
        $links = [];
        foreach ($this->links as $link) {
            if($link['position'] == $position) {
                $links[] = $link;
            }
        }
        return array_slice($links, ($page-1)*$per_page, $per_page);
    }
    
    public function add_link($title, $url, $position, $image) {
        $order = count($this->get_links($position));
        $link = [
            'url' => $url,
            'position' => $position,
            'image' => $image,
            'order' => $order,
            'title' => $title
        ];
        $id = $this->site_model->insert('links', $link);
        $link['ID'] = $id;
        $this->links[] = $link;
        return $id;
    }
    
    public function get_link($id) {
        foreach ($this->links as $link) {
            if($link['ID'] == $id) {
                return $link;
            }
        }
    }
    
    public function edit_link($id, $updates) {
        foreach($this->links as $lkey => $link) {
            if($link['ID'] == $id) {
                foreach ($updates as $key => $value) {
                    $link[$key] = $value;
                }
                $this->links[$lkey] = $link;
            }
        }
        return $this->site_model->update('links', ['ID' => $id], $updates);
    }
    
    public function delete_link($id) {
        $link = $this->get_link($id);
        if(isset($link['title'])) {
            $this->site_model->update('links', ['position' => $link['position'], '`order` >' => $link['order']], ['`order`' => ['`order`-1', false]]);
            $return = $this->site_model->delete('links', ['ID' => $id], 1);
            $this->load_links();
            return $return;
        }
    }
    
    public function change_order($id, $up = true) {
        $link = $this->get_link($id);
        if(count($link) != 0) {
            if($up && $link['order'] >= 1) {
                $this->site_model->update('links', ['`order`' => $link['order'] - 1, 'position' => $link['position']], ['`order`' => $link['order']]);
                $this->edit_link($id, ['order' => $link['order']-1]);
            } elseif(!$up && $link['order'] < count($this->get_links($link['position'])) - 1) {
                $this->site_model->update('links', ['`order`' => $link['order'] + 1, 'position' => $link['position']], ['`order`' => $link['order']]);
                $this->edit_link($id, ['order' => $link['order']+1]);
            }
        }
    }
}