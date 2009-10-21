<?php

require_once 'application/classes/FieldType.php';

/**
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property CI_DB_active_record $db
 */
class fieldtypes_manager extends data_manager {

    public function __construct() {
        $__construct = parent::__construct();
        $this->table_name = "fieldtype";
    }

    protected function insert($object) {
    }
    public function delete($object) {
    }
    public function find_by_id($id) {
    }
    public function save($object) {
    }
    protected function update($object) {
    }

    public function find_by_filter($filter = array()) {
        return $this->select_db_table($filter, $this->table_name, "FieldType");
    }

    public function delete_by_id($id) {
    }
    
}
?>
