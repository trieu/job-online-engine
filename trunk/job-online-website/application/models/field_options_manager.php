<?php

/**
 * @property CI_Loader $load 
 * @property CI_DB_active_record $db
 */
class field_options_manager extends data_manager {

    public function __construct() {
        parent::__construct();
        $this->table_name = "fields";
    }

   
    public function find_by_filter($filter,$join_filter) {
    }

    public function save($object) {
    }
    
    public function find_by_id($id) {
    }

    public function get_dependency_instances() {
    }
    
    public function delete($object) {
    }

    protected function insert($object) {
    }
    
    protected function update($object) {
    }

    public function delete_by_id($id) {
    }
    
    public function updateByField($id,$editable_field_name,$editable_field_value) {
    }
}
?>
