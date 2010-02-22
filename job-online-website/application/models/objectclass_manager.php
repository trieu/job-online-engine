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
        $this->db->trans_start();
        $data_array = $this->class_mapper->classToArray("ObjectClass", $obj);
        $id = -1;
        if($obj->getObjectClassID() > 0) {
            $id = $this->update($data_array);
            $id = $obj->getObjectClassID();
        }
        else {
            $id = $this->insert($data_array);
        }

        $rec = new stdClass();
        $rec->ObjectClassID = $id;
        $this->db->delete("class_using_process",array("ObjectClassID"=>$id));
        foreach ($obj->getUsableProcesses() as $ProcessOrder => $ProcessID) {
            $rec->ProcessID = $ProcessID;
            $rec->ProcessOrder = $ProcessOrder;
            $this->db->insert("class_using_process",$rec);
        }
        $this->db->trans_complete();
        return $id;
        //TODO save usable processes
    }

    protected function insert($data_array) {
        $this->db->insert($this->table_name, $data_array);
        if($this->db->affected_rows()>0) {
            return $this->db->insert_id();
        }
        return -1;
    }

    protected function update($data_array) {
        $key_field_name = "ObjectClassID";
        $id = $data_array[$key_field_name];
        unset($data_array[$key_field_name]);
        $this->db->where($key_field_name, $id);
        $this->db->update($this->table_name, $data_array);
        if($this->db->affected_rows()>0) {
            return $id;
        }
        return -1;
    }

    /**
     * @access	public
     * @param	id
     * @return	ObjectClass
     */
    public function find_by_id($id) {
        $query = $this->db->get_where($this->table_name, array('ObjectClassID' => $id));
        ApplicationHook::logInfo(sizeof($query->result_array()));
        return $this->row_data_mapper($query->result_array());
    }

    /**
     * @access	public
     * @param	AccessDataURI
     * @return	ObjectClass
     */
    public function find_by_uri($AccessDataURI) {
        $query = $this->db->get_where($this->table_name, array('AccessDataURI' => $AccessDataURI));
        return $this->row_data_mapper($query->result_array());
    }

    /**
     * @access	protected
     * @param	result_array , CI query result array
     * @return	ObjectClass
     */
    protected function row_data_mapper($result_array) {
        if( sizeof($result_array) != 1 ) {
            throw new InvalidArgumentException("ID or URI is not unique",500);
        }
        foreach ($result_array as $data_row) {
            $obj = new ObjectClass();
            $obj = $this->class_mapping($data_row, "ObjectClass", $obj);

            $sql =  " SELECT processes.*, class_using_process.ProcessOrder";
            $sql .= " FROM processes ";
            $sql .= " INNER JOIN class_using_process";
            $sql .= " ON processes.ProcessID = class_using_process.ProcessID AND class_using_process.ObjectClassID = ?";

            $q2 = $this->db->query($sql, array( $obj->getObjectClassID() ));
            $record_set = $q2->result_array();

            $processes = array();
            foreach ($record_set as $record) {
                $process = new Process();
                $process->setProcessID($record['ProcessID']);
                $process->setProcessName($record['ProcessName']);
                $process->setDescription($record['Description']);
                $process->setProcessOrder($record['ProcessOrder']);

                array_push($processes, $process);
            }
            usort($processes, array("Process", "_compare"));
            $obj->setUsableProcesses($processes);
            return $obj;
        }
        return NULL;
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
