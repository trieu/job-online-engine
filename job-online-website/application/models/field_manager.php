<?php

require_once 'application/classes/Field.php';

/**
 * @property CI_Loader $load
 * @property CI_DB_active_record $db
 */
class field_manager extends data_manager {

    public function __construct() {
        parent::__construct();
        $this->table_name = "fields";
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

    public function find_by_filter($filter = array(), $join_filter = array()) {
        return $this->select_db_helper($filter, $this->table_name, "Field");
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
    public function updateByField($id,$editable_field_name,$editable_field_value) {
    }
}
?>
