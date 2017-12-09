<?php

class Menus_model extends CI_Model {
    private $menus = ['top' => [], 'side' => []];
    
    public function __construct() {
        parent::__construct();
        $this->load_menu();
    }
    
    public function get_named_position($num) {
        switch($num) {
            case 0:
                return 'top';
            case 1:
                return 'side';
            default:
                return 'unknown';
        }
    }
    
    public function get_unnamed_position($name) {
        switch($name) {
            case 'top':
                return 0;
            case 'side':
                return 1;
            default:
                return 'unknown';
        }
    }
    
    public function load_menu() {
        $this->menus = ['top' => [], 'side' => []];
        $this->get_admin_dropdown();
        $menus = $this->site_model->get('menu',[],'ORDER ASC');
        foreach($menus as $menu) {
            $this->menus[$this->get_named_position($menu['position'])][] = $menu;
        }
    }
    
    public function get_admin_dropdown()
    {
        if(($this->users->if_connected()))
        {
            $to_add = [
                ['internal'=>0,'url'=>'admin/dashboard','title'=>'ניהול אתר','ID'=>'-1','parent_ID'=>'0']
            ];
            $permissions = [
                ['name'=>'ניהול ארכיון','value'=>'manage_archive','url'=>'admin/archive'],
                ['name'=>'ניהול לוח שנה','value'=>'manage_calender','url'=>'admin/calender'],
                ['name'=>'ניהול קטגוריות','value'=>'manage_categories','url'=>'admin/categories'],
                ['name'=>'ניהול גלריות','value'=>'manage_gallery','url'=>'admin/galleries'],
                ['name'=>'ניהול לינקים','value'=>'manage_links','url'=>'admin/links'],
                ['name'=>'ניהול תפריט','value'=>'manage_menu','url'=>'admin/menu/1/side'],
                ['name'=>'ניהול עדכונים','value'=>'manage_notices','url'=>'admin/notices'],
                ['name'=>'ניהול דפים','value'=>'manage_pages','url'=>'admin/pages'],
                ['name'=>'ניהול קבצים','value'=>'manage_uploads','url'=>'admin/uploads'],
                ['name'=>'ניהול משתמשים','value'=>'manage_users','url'=>'admin/users'],
                ['name'=>'מעקב פעולות משתמשים','value'=>'follow_users','url'=>'admin/follow'],
            ];
			$to_add[] = ['internal'=>0,'url'=>'admin/updatePass','title'=>'שינוי סיסמא','ID'=>'-2','parent_ID'=>'-1'];
            foreach ($permissions as $permission) {
                if($this->users->has_permission($this->users->user['username'], $permission['value'])) {
                    $to_add[] = ['internal'=>0,'url'=>$permission['url'],'title'=>$permission['name'],'ID'=>'-2','parent_ID'=>'-1'];
                }
            }
            $to_add[] = ['internal'=>0,'url'=>'admin/logout','title'=>'התנתקות','ID'=>'-2','parent_ID'=>'-1'];
            foreach($to_add as $item)
            {
                $this->menus['side'][] = $item;
            }
        }
    }

    public function get_menu($name, $parentID = 0, $type="nav nav-pills") {
        $current_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $menus = $this->get_menu_by_parent($name, $parentID);
        $str = '<ul class="'.$type.'">';
        foreach ($menus as $menu) {
            $link = ($menu['internal'] == 0 ? base_url() . $menu['url'] : $menu['url']);
            $str .= "<li class='dropdown".($current_link == $link ? " active" : "")."'><a href='".$link."'>{$menu['title']}</a>";
            if(count($this->get_menu_by_parent($name, $menu['ID']))) {
                $str .= $this->get_menu($name, $menu['ID'], "dropdown-menu");
            }
            $str .= '</li>';
        }
        $str .= '</ul>';
        return $str;
    }
    
    public function get_menu_arr($name, $parentID = 0) {
        $menus = $this->get_menu_by_parent($name, $parentID);
        $arr = [];
        foreach ($menus as $menu) {
            $arr[$menu['ID']] = $menu;
            if(count($this->get_menu_by_parent($name, $menu['ID']))) {
                $arr[$menu['ID']]['sub'] = $this->get_menu_arr($name, $menu['ID']);
            }
        }
        return $arr;
    }
    
    public function get_panel_menu($name, $page, $per_page) {
        $panel_menu = [];
        foreach($this->menus[$name] as $menu)
        {
            if($menu['ID'] != '-1' && $menu['ID'] != '-2')
            {
                $panel_menu[] = $menu;
            }
        }
        return array_slice($panel_menu, ($page-1)*$per_page, $per_page);
    }
    
    public function get_panel_number($name) {
        $panel_menu = [];
        foreach($this->menus[$name] as $menu)
        {
            if($menu['ID'] != '-1' && $menu['ID'] != '-2')
            {
                $panel_menu[] = $menu;
            }
        }
        return count($panel_menu);
    }
    
    public function get_menu_by_parent($name, $parentID) {
        $menus = [];
        foreach ($this->menus[$name] as $menu) {
            if($menu['parent_ID'] == $parentID) {
                $menus[] = $menu;
            }
        }
        return $menus;
    }
    
    public function add_menu_item($title, $internal, $url, $parentID, $position) {
        $order = count($this->get_menu_by_parent(($position == 0 ? 'top' : 'side'), $parentID));
        $menu = [
            'title' => $title,
            'internal' => $internal,
            'url' => $url,
            'parent_ID' => $parentID,
            'position' => $position,
            '`order`' => $order
        ];
        $id = $this->site_model->insert('menu', $menu);
        $menu['ID'] = $id;
        $this->menus[($menu['position'] == '0') ? 'top' : 'side'][] = $menu;
        return $id;
    }
    
    public function get_menu_item($id) {
        foreach($this->menus['top'] as $menu) {
            if($menu['ID'] == $id) {
                return $menu;
            }
        }
        foreach($this->menus['side'] as $menu) {
            if($menu['ID'] == $id) {
                return $menu;
            }
        }
    }
    
    public function delete_menu_item($id) {
        $menu = $this->get_menu_item($id);
        if(isset($menu['title'])) {
            $parent_menus_count = count($this->get_menu_by_parent((($menu['position'] == '0') ? 'top' : 'side'), $menu['parent_ID'])) - 1;
            $sub_menus = $this->get_menu_by_parent((($menu['position'] == '0') ? 'top' : 'side'), $id);
            $add = 0;
            $this->site_model->update('menu', ['parent_ID' => $menu['parent_ID'], '`order` >' => $menu['order']], ['`order`' => ['`order`-1', false]]);
            foreach($sub_menus as $sub_menu) {
                $this->site_model->update('menu', ['ID' => $sub_menu['ID']], ['parent_ID' => $menu['parent_ID'], '`order`' => ($parent_menus_count + $add++)]);
            }
            $this->site_model->delete('menu', ['ID' => $id], 1);
            $this->load_menu();
        }
    }
    
    public function get_all_menu($name) {
        return $this->menus[$name];
    }
    
    public function change_order($id, $up = true) {
        $menu = $this->get_menu_item($id);
        if(count($menu) != 0) {
            if($up && $menu['order'] >= 1) {
                $this->site_model->update('menu', ['`order`' => $menu['order'] - 1, 'parent_ID' => $menu['parent_ID']], ['`order`' => $menu['order']]);
                $this->site_model->update('menu', ['ID' => $id], ['`order`' => [$menu['order']-1, false]]);
            } elseif(!$up && $menu['order'] < count($this->get_menu_by_parent($this->get_named_position($menu['position']), $menu['parent_ID']))-1) {
                $this->site_model->update('menu', ['`order`' => $menu['order'] + 1, 'parent_ID' => $menu['parent_ID']], ['`order`' => $menu['order']]);
                $this->site_model->update('menu', ['ID' => $id], ['`order`' => [$menu['order']+1, false]]);
            }
        }
    }
    
    public function edit_menu($id, $updates) {
        $name = $this->get_menu_item($id)['name'];
        foreach($this->menus[$name] as $mkey => $menu) {
            if($menu['ID'] == $id) {
                foreach ($updates as $key => $value) {
                    $menu[$key] = $value;
                }
                $this->menus[$name][$mkey] = $menu;
            }
        }
        return $this->site_model->update('menu', ['ID' => $id], $updates);
    }
}