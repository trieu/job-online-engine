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

    public function delete($object) {
    }
    
    public function find_by_id($id) {
        $filter = array($this->table_name.".FormID" => $id);
        $list = $this->find_by_filter($filter);
        //ApplicationHook::log($list[0]->getFormName());
        if(count($list) == 1) {
            return $list[0];
        }
        return NULL;
    }

    public function save($object ) {
        $data_array = $this->class_mapper->classToArray("Form", $object);

        $id = -1;       
        if($object->getFormID() > 0) {
            $this->update($data_array);
            $id = $object->getFormID();
        }
        else {
            $id = $this->insert($data_array);
        }

        $this->db->trans_start();
        $this->db->delete("form_process", array("FormID"=>$id));       
        foreach ($object->getProcessIDs() as $pid ) {
            if($id > 0 && $pid > 0){                
                $this->db->insert("form_process", array("FormID"=>$id,"ProcessID"=>$pid) );
            }
        }
        $this->db->trans_complete();
    }

    protected function insert($data_array) {
        $this->db->insert($this->table_name, $data_array);
        if($this->db->affected_rows()>0){
            return $this->db->insert_id();
        }
        return -1;
    }

    protected function update($data_array) {
        $key_field_name = "FormID";
        $id = $data_array[$key_field_name];
        unset($data_array[$key_field_name]);
        $this->db->where($key_field_name, $id);
        $this->db->update($this->table_name, $data_array);
        if($this->db->affected_rows()>0){
            return $id;
        }
        return -1;
    }

    public function find_by_filter($filter = array(), $join_filter = array()) {
        return $this->select_db_helper($filter,  $this->table_name , "Form",$join_filter);
    }

    public function delete_by_id($id) {
        $this->db->delete("field_form", "FormID = ".$id);
        $this->db->delete($this->table_name, "FormID = ".$id);
        if($this->db->affected_rows()>0) {
            return $id;
        }
        return -1;
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
        //ApplicationHook::logInfo($this->db->last_query());
        $list["processes"] = $processes;
        return $list;
    }
    public function updateByField($id,$editable_field_name,$editable_field_value) {
    }

    public function getAllFormsOfObjectClass($classID){
       $sql =   "SELECT forms.FormID, forms.FormName
                FROM forms
                INNER JOIN form_process
                ON form_process.FormID = forms.FormID
                AND form_process.ProcessID IN
                (
                SELECT class_using_process.ProcessID
                FROM class_using_process
                WHERE class_using_process.ObjectClassID = ?
                )";
       $query = $this->db->query($sql,array($classID));
       return $query->result_array();
    }
}
?>
