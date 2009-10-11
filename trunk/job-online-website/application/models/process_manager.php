<?php
require_once 'application/classes/Process.php';

/**
 * @property class_mapper $class_mapper
 * @property CI_Loader $load
 * @property CI_DB_active_record $db
 */
class process_manager extends data_manager {

    public function __construct() {
        parent::__construct();
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

    public function save($process) {
        $data_array = $this->class_mapper->classToArray("Process", $process);
        if($process->getProcessID() > 0) {
            $this->update($data_array);
        }
        else {
            $this->insert($data_array);
        }
    }

    protected function insert($data_array) {
        $this->db->insert("Processes", $data_array);
    }

    protected function update($data_array) {
        $key_field_name = "ProcessID";
        $id = $data_array[$key_field_name];
        unset($data_array[$key_field_name]);
        $this->db->where($key_field_name, $id);
        $this->db->update('Processes', $data_array);
    }

    /**
     * @access	public
     * @param	id
     * @return	Process
     */
    public function find_by_id($id) {
        $query = $this->db->get_where("Processes", array('ProcessID' => $id));
        foreach ($query->result_array() as $data_row) {
            $pro = new Process();
            return $pro = $this->class_mapping($data_row, "Process", $pro);
        }
    }


    /**
     * @access	public
     * @param	id
     * @return	array
     */
    public function find_by_filter($filter = array()) {
        $query = $this->db->get_where("Processes", $filter);
        $list = array();
        $idx = 0;
        foreach ($query->result_array() as $data_row) {
            $pro = new Process();
            $list[$idx++] = $this->class_mapping($data_row, "Process", $pro);
        }
        return $list;
    }

    public function delete($process) {
    }

    public function delete_by_id($id) {
    }

}


?>
