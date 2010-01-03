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
    public function save($record) {
        //var_dump($record);
        //echo  $record->FieldValueID;
        $id = -1;
        if($record->FieldValueID > 0) {
            $id = $this->update($record);
            //$id = $record->FieldValueID;
        }
        else {
            $id = $this->insert($record);
        }
    }
    protected function update($record) {
        $key_field_name = "FieldValueID";
        $id = $record->$key_field_name;
        unset($record->$key_field_name);
        $this->db->where($key_field_name, $id);
        $this->db->update($this->table_name, $record);
        if($this->db->affected_rows()>0) {
            return $id;
        }
        return -1;
    }
    protected function insert($record) {
        $this->db->insert($this->table_name, $record);
        if($this->db->affected_rows()>0) {
            return $this->db->insert_id();
        }
        return -1;
    }

    public function delete_by_id($id) {

    }

    public function find_by_id($id) {
        $query = $this->db->get_where($this->table_name, array('ObjectID' => $id));
        foreach ($query->result_array() as $data_row) {
            $pro = new Object();
            return $pro = $this->class_mapping($data_row, "Object", $pro);
        }
    }
    public function find_by_filter($filter = array(), $join_filter = array()) {
        return $this->select_db_helper($filter, $this->table_name, "Object");
    }

    public function delete($object) {
    }
    public function get_dependency_instances() {
    }
    public function updateByField($id,$editable_field_name,$editable_field_value) {
    }
}
?>
