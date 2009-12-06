<?php

/**
 * @property field_manager $field_manager
 * @property field_options_manager $field_options_manager
 *
 * @property CI_DB_active_record $db
 * @property CI_Loader $load
 */
class field_value_manager extends data_manager {

    function field_value_manager() {
        parent::Model();
        $this->table_name = "fieldvalues";
    }
    public function save($data_array) {
        $id = -1;
        if($data_array['FieldValueID'] > 0) {
            $id = $this->update($data_array);
            $id = $data_array['FieldValueID'];
        }
        else {
            $id = $this->insert($data_array);
        }
    }
    protected function update($data_array) {
        $key_field_name = "FieldValueID";
        $id = $data_array[$key_field_name];
        unset($data_array[$key_field_name]);
        $this->db->where($key_field_name, $id);
        $this->db->update($this->table_name, $data_array);
        if($this->db->affected_rows()>0) {
            return $id;
        }
        return -1;
    }
    protected function insert($data_array) {
        $this->db->insert($this->table_name, $data_array);
        if($this->db->affected_rows()>0) {
            return $this->db->insert_id();
        }
        return -1;
    }

    public function delete_by_id($id) {

    }

    public function find_by_id($id) {
    }
    public function find_by_filter($filter, $join_filter = array()) {
    }

    public function delete($object) {
    }
    public function get_dependency_instances() {
    }
    public function updateByField($id,$editable_field_name,$editable_field_value) {
    }
}
?>
