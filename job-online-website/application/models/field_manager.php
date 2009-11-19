<?php

require_once 'application/classes/Field.php';
require_once 'application/classes/FieldType.php';

/**
 * @property CI_Loader $load
 * @property CI_DB_active_record $db
 */
class field_manager extends data_manager {

    public function __construct() {
        parent::__construct();
        $this->table_name = "fields";
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
        $data_array = $this->class_mapper->classToArray("Field", $object);

        $id = -1;
        if($object->getFieldID() > 0) {
            $this->update($data_array);
            $id = $object->getFieldID();
        }
        else {
            $id = $this->insert($data_array);
        }

        $this->db->trans_start();
      
        $this->db->trans_complete();
    }

    protected function insert($data_array) {
        $this->db->insert($this->table_name, $data_array);
        if($this->db->affected_rows()>0) {
            return $this->db->insert_id();
        }
        return -1;
    }

    protected function update($data_array) {
        $key_field_name = "FieldID";
        $id = $data_array[$key_field_name];
        unset($data_array[$key_field_name]);
        $this->db->where($key_field_name, $id);
        $this->db->update($this->table_name, $data_array);
        if($this->db->affected_rows()>0) {
            return $id;
        }
        return -1;
    }

    public function find_by_filter($filter = array(), $join_filter = array()) {
        return $this->select_db_helper($filter, $this->table_name, "Field");
    }

    public function delete_by_id($id) {
        
    }

    public function get_dependency_instances() {
        $list = array();
        $list["field_types"] = FieldType::getAvailableFieldType();
        return $list;
    }

    public function updateByField($id,$editable_field_name,$editable_field_value) {
    }
}
?>