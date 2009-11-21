<?php

require_once 'application/classes/FieldOption.php';

/**
 * @property CI_Loader $load
 * @property CI_DB_active_record $db
 */
class field_options_manager extends data_manager {

    public function __construct() {
        parent::__construct();
        $this->table_name = "fieldoptions";
    }


    public function find_by_filter($filter = array(), $join_filter = array()) {
        return $this->select_db_helper($filter, $this->table_name, "FieldOption");
    }


    public function save($data_array) {
        $id = -1;
        if($data_array->FieldOptionID > 0) {
            $id = $this->update($data_array);
        }
        else {
            $id = $this->insert($data_array);
        }
        return $id;
    }

    public function find_by_id($id) {
        $filter = array("FieldOptionID" => $id);
        $list = $this->find_by_filter($filter);
        if(sizeof($list) == 1) {
            return $list[0];
        }
        return NULL;
    }

    public function get_dependency_instances() {
    }

    public function delete($object) {
    }

    protected function insert($data_array) {
        $this->db->insert($this->table_name, $data_array);
        if($this->db->affected_rows()>0) {
            return $this->db->insert_id();
        }
        return -1;
    }

    protected function update($data_array) {        
        $id = $data_array->FieldOptionID;
        unset($data_array->FieldOptionID);
        $this->db->where("FieldOptionID", $id);
        $this->db->update($this->table_name, $data_array);
        if($this->db->affected_rows()>0) {
            return $id;
        }
        return -1;
    }

    public function delete_by_id($id) {
        $key_field_name = "FieldOptionID";
        $this->db->delete($this->table_name, array($key_field_name => $id));
    }

    public function updateByField($id,$editable_field_name,$editable_field_value) {
    }
}
?>
