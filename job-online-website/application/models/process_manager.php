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
        $this->table_name = "processes";
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

    public function get_select_field_options($table_name) {
        $list = array();
        $this->db->select("id, name, description");
        $this->db->from($table_name);
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $list[$row["id"]] = $row["name"].", ".$row["description"];
        }
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
        $this->db->insert($this->table_name, $data_array);
    }

    protected function update($data_array) {
        $key_field_name = "ProcessID";
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
        $query = $this->db->get_where($this->table_name, array('ProcessID' => $id));
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
    public function find_by_filter($filter = array(), $join_filter = array()) {
       return $this->select_db_helper($filter, $this->table_name, "Process");
    }

    public function delete($process) {
    }

    public function delete_by_id($id) {
    }

    public function updateByField($id,$editable_field_name,$editable_field_value) {
    }

    public function getIndentityProcessView($id) {
        $sql =  " SELECT cacheContent, javascriptContent ";
        $sql .= " FROM objecthtmlcaches";
        $sql .= " WHERE objectClass = 'form_' ";
        $sql .= " AND objectPK ";
        $sql .= " IN (SELECT forms.FormID FROM forms";
        $sql .= "     INNER JOIN form_process";
        $sql .= "     ON form_process.FormID = forms.FormID AND form_process.ProcessID = ?";
        $sql .= "    );";
        
        $q = $this->db->query($sql, array($id));
        foreach ($q->result_array() as $record){            
            return $record;
        }
        return array();
    }
}


?>
