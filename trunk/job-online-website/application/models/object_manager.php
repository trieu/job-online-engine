<?php

require_once 'application/classes/Object.php';

/**
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property CI_DB_active_record $db
 */
class object_manager extends data_manager {

    public function __construct() {
        parent::__construct();
        $this->table_name = "objects";
    }

    public function save($obj) {
        $data_array = $this->class_mapper->classToArray("Object", $obj);
        $id = -1;
        if($obj->getObjectID() > 0) {
            $id = $this->update($data_array);
            $id = $obj->getObjectID();
        }
        else {
            $id = $this->insert($data_array);
        }

        $this->db->trans_start();
        foreach ($obj->getFieldValues() as $field_value) {
            $field_value['ObjectID'] = $id;
            $field_value['FieldValueID'] = -1;
            $this->load->model("field_value_manager");
            $this->field_value_manager->save($field_value);
        }
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
        $key_field_name = "ObjectID";
        $id = $data_array[$key_field_name];
        unset($data_array[$key_field_name]);
        $this->db->where($key_field_name, $id);
        $this->db->update($this->table_name, $data_array);
        if($this->db->affected_rows()>0) {
            return $id;
        }
        return -1;
    }


    public function delete_by_id($id) {
    }

    public function find_by_id($id) {
        $query = $this->db->get_where($this->table_name, array('ObjectClassID' => $id));
        foreach ($query->result_array() as $data_row) {
            $pro = new ObjectClass();
            return $pro = $this->class_mapping($data_row, "ObjectClass", $pro);
        }
    }
    public function find_by_filter($filter = array(), $join_filter = array()) {
        return $this->select_db_helper($filter, $this->table_name, "Object");
    }
    public function delete($object) {
    }

    public function get_dependency_instances() {
        $list = array();
        return $list;
    }
    public function updateByField($id,$editable_field_name,$editable_field_value) {
    }
}
?>
