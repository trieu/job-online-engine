<?php
require_once 'application/classes/ObjectClass.php';

/**
 * @property class_mapper $class_mapper
 * @property CI_Loader $load
 * @property CI_DB_active_record $db
 */
class objectclass_manager extends data_manager {

    public function __construct() {
        parent::__construct();
        $this->table_name = "objectclass";
    }

    public function get_dependency_instances() {
        $list = array();
      
        return $list;
    }

    public function save($obj) {
        $data_array = $this->class_mapper->classToArray("ObjectClass", $obj);
        if($obj->getObjectClassID() > 0) {
            $this->update($data_array);
        }
        else {
            $this->insert($data_array);
        }
    }

    protected function insert($data_array) {
        $this->db->insert($this->table_name, $data_array);
    }

    protected function update($data_array) {
        $key_field_name = "ObjectClassID";
        $id = $data_array[$key_field_name];
        unset($data_array[$key_field_name]);
        $this->db->where($key_field_name, $id);
        $this->db->update($this->table_name, $data_array);
    }

    /**
     * @access	public
     * @param	id
     * @return	Process
     */
    public function find_by_id($id) {
        $query = $this->db->get_where($this->table_name, array('ObjectClassID' => $id));
        foreach ($query->result_array() as $data_row) {
            $pro = new ObjectClass();
            return $pro = $this->class_mapping($data_row, "ObjectClass", $pro);
        }
    }

    /**
     * @access	public
     * @param	id
     * @return	array
     */
    public function find_by_filter($filter = array(), $join_filter = array()) {
       return $this->select_db_helper($filter, $this->table_name, "ObjectClass");
    }

    public function delete($process) {
    }

    public function delete_by_id($id) {
    }

    public function updateByField($id,$editable_field_name,$editable_field_value) {
    }
}


?>
