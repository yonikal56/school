<?php

class Users_Model extends CI_Model {
    private $users = [];
    public $user = [];
    private $userSession;
    private $passSession;
    private $lastSession;
    private $connectingMinutes;
    
    public function __construct() {
        parent::__construct();
        $this->userSession = 'agnon_admin_user';
        $this->passSession = 'agnon_admin_pass';
        $this->lastSession = 'agnong_admin_last';
        $this->connectingMinutes = $this->settings->get_setting('user_connection_time');
        $this->connectingMinutes = $this->connectingMinutes != '' ? $this->connectingMinutes : 5;
        $this->load_users();
    }
    
    public function load_users() {
        $this->users = $this->site_model->get('users');
        if($this->if_connected()) {
            $this->user = $this->get_user($this->session->userdata($this->userSession));
        }
    }
    
    public function if_connected() {
        if($this->session->userdata($this->userSession) && $this->session->userdata($this->passSession) && $this->session->userdata($this->lastSession)) {
            if($this->session->userdata($this->lastSession) < time() - $this->connectingMinutes*60) {
                $this->logout();
                return false;
            } else {
                $this->session->set_userdata($this->lastSession, time());
                return $this->check_details($this->session->userdata($this->userSession), $this->session->userdata($this->passSession), true);
            }
        }
        return false;
    }
    
    public function logout() {
        $this->session->unset_userdata([$this->userSession, $this->passSession]);
        $this->user = [];
    }
    
    public function login($username, $password) {
        if($this->check_details($username, $password)) {
            $this->user = $this->get_user($username);
            $details = [
                $this->userSession => $username,
                $this->passSession => $this->user['password'],
                $this->lastSession => time()
            ];
            $this->session->set_userdata($details);
            return true;
        }
        return false;
    }
    
    public function get_user($username) {
        foreach ($this->users as $user) {
            if($user['username'] == $username) {
                return $user;
            }
        }
        return [];
    }
    
    public function get_user_by_id($id) {
        foreach ($this->users as $user) {
            if($user['ID'] == $id) {
                return $user;
            }
        }
        return [];
    }
    
    public function get_users() {
        return $this->users;
    }
    
    public function get_panel_users($page, $per_page) {
        return array_slice($this->users, ($page - 1) * $per_page, $per_page);
    }
    
    public function check_details($username, $password, $encrypted = false) {
        foreach ($this->users as $user) {
            if($user['username'] == $username) {
                if($encrypted) {
                    return ($password == $user['password']);
                }
                else {
                    $pass = encrypt_password($password, $user['salt']);
                    return ($pass == $user['password']);
                }
            }
        }
        return false;
    }
    
    public function username_exists($username) {
        foreach ($this->users as $user) {
            if($user['username'] == $username) {
                return true;
            }
        }
        return false;
    }
    
    public function register_user($username, $password, $permissions) {
        if($this->username_exists($username)) {
            return false;
        }
        $salt = generate_salt(15);
        $pass = encrypt_password($password, $salt);
        $new_user = [
            'username' => $username,
            'salt' => $salt,
            'password' => $pass,
            'permissions' => $permissions
        ];
        $inserted_id = $this->site_model->insert('users', $new_user);
        $new_user['ID'] = $inserted_id;
        $this->users[] = $new_user;
        return $inserted_id;
    }
    
    public function edit_user($id, $updates) {
        foreach($this->users as $ukey => $user) {
            if($user['ID'] == $id) {
                foreach ($updates as $key => $value) {
                    $user[$key] = $value;
                }
                $this->users[$ukey] = $user;
            }
        }
        return $this->site_model->update('users', ['ID' => $id], $updates);
    }
    
    public function delete_user($id) {
        $this->site_model->delete('users', ['ID' => $id], 1);
        $this->load_users();
    }
    
    public function get_user_permissions($username) {
        $user = $this->get_user($username);
        if(isset($user['permissions'])) {
            return explode(',', $user['permissions']);
        }
        return [];
    }
    
    public function has_permission($username, $permission) {
        $permissions = $this->get_user_permissions($username);
        return (in_array($permission, $permissions)) || (in_array('all', $permissions));
    }
    
    public function add_permission($username, $permission) {
        $user = $this->get_user($username);
        if(isset($user['permissions'])) {
            $this->edit_user($user['ID'], ['permissions' => (($user['permissions'] == "") ? $permission : "{$user['permissions']},{$permission}")]);
        }
    }
    
    public function delete_permission($username, $del_per) {
        $user = $this->get_user($username);
        if(isset($user['permissions'])) {
            $new_permissions = [];
            foreach($this->get_user_permissions($username) as $permission) {
                if($permission != $del_per) {
                    $new_permissions[] = $permission;
                }
            }
            $this->edit_user($user['ID'], ['permissions' => join(',', $new_permissions)]);
        }
    }
}