<?php

class Archive_Model extends CI_Model {
    private $archive = [];
    
    public function __construct() {
        parent::__construct();
        $this->load_archive();
    }
    
    public function load_archive($limit = 50, $table = null) {
        if($table == null) {
            $this->archive = $this->site_model->get('archive',[],'ID DESC',$limit);
        }
        else {
            $this->archive = $this->site_model->get('archive',['table' => $table],'ID DESC',$limit);
        }
    }
    
    public function get_archive_number($table) {
        $i = 0;
        foreach ($this->archive as $archive) {
            if($archive['table'] == $table) {
                $i++;
            }
        }
        return $i;
    }

    public function get_archive($table = null, $page = 1, $per_page = 15) {
        if($table == null) {
            $archive_return = $this->archive;
        }
        else {
            $archive_return = [];
            foreach ($this->archive as $archive) {
                if($archive['table'] == $table) {
                    $archive_return[] = $archive;
                }
            }
        }
        return array_slice($archive_return, ($page - 1) * $per_page, $per_page);
    }
    
    public function add_archive($table, $rows) {
        $new_archive = [
            'table' => $table,
            'rows' => $rows
        ];
        $inserted_id = $this->site_model->insert('archive', $new_archive);
        return $inserted_id;
    }
    
    public function delete_archive($id) {
        $this->site_model->delete('archive', ['ID' => $id], 1);
        $this->load_archive();
    }
}