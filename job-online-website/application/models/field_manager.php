<?php

require_once 'application/classes/Field.php';

/**
 * @property CI_Loader $load
 * @property CI_DB_active_record $db
 */
class field_manager extends data_manager {

    public function __construct() {
        parent::__construct();
    }

    protected function insert($object) {
    }
    public function delete($object) {
    }
    public function find_by_id($id) {
        $filter = array("FieldID" => $id);
        $list = $this->find_by_filter($filter);
        if(sizeof($list) == 1) {
            return $list[0];
        }
        return NULL;
    }
    public function save($object) {
    }
    protected function update($object) {
    }

    public function find_by_filter($filter = array()) {
        return $this->select_db_table($filter, "Fields", "Field");
    }

    public function delete_by_id($id) {
    }
}
?>
