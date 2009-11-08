<?php

/**
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property CI_DB_active_record $db
 */
class object_manager extends data_manager {

    function object_manager() {
        parent::Model();
    }
    protected function update($object) {
    }
    public function delete_by_id($id) {
    }
    public function save($object) {
    }
    public function find_by_id($id) {
    }
    public function find_by_filter($filter, $join_filter = array()) {
    }
    protected function insert($object) {
    }
    public function delete($object) {
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
