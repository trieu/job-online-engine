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

    public function find_by_filter($filter = array(), $join_filter = array()) {
        return $this->select_db_table($filter, $this->table_name, "FieldType");
    }

    public function delete_by_id($id) {
    }

    public function get_dependency_instances() {
        $list = array();
        $this->db->select("id, name, description");
        $this->db->from("groups");
        $query = $this->db->get();
        $groups = array();
        foreach ($query->result_array() as $row) {
            $groups[$row["id"]] = $row["name"]." - ".$row["description"];
        }
        $list["groups"] = $groups;
        return $list;
    }

}
?>
