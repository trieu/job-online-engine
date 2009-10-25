<?php

require_once 'application/classes/Form.php';

/**
 * @property CI_Loader $load
 * @property CI_DB_active_record $db
 */
class forms_manager extends data_manager {

    public function __construct() {
        parent::__construct();
        $this->table_name = "forms";
    }
    protected function insert($object) {
    }
    public function delete($object) {
    }
    public function find_by_id($id) {
        $filter = array($this->table_name.".FormID" => $id);
        $list = $this->find_by_filter($filter);
        if(count($list) == 1) {
            return $list[0];
        }
        return NULL;
    }
    public function save($object) {
    }
    protected function update($object) {
    }

    public function find_by_filter($filter = array(), $join_filter = array()) {
        return $this->select_db_table($filter,  $this->table_name , "Form",$join_filter);
    }

    public function delete_by_id($id) {
    }

    public function get_dependency_instances() {
        $list = array();
        $this->db->select("ProcessID, ProcessName");
        $this->db->from("processes");
        $query = $this->db->get();
        $processes = array();
        foreach ($query->result_array() as $row) {
            $processes[$row["ProcessID"]] = $row["ProcessName"];
        }
        $list["processes"] = $processes;
        return $list;
    }

    public function get_related_objects($id) {
        $list = array();
        $this->db->select("processes.ProcessID, processes.ProcessName");
        $this->db->from("processes");
        $this->db->join("form_process", "form_process.ProcessID = processes.ProcessID AND form_process.FormID = ".$id);
        $query = $this->db->get();
        $processes = array();
        foreach ($query->result_array() as $row) {
            $processes[$row["ProcessID"]] = $row["ProcessName"];
        }
        ApplicationHook::logInfo($this->db->last_query());
        $list["processes"] = $processes;
        return $list;
    }
}
?>
