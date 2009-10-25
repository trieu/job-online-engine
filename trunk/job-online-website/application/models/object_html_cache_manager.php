<?php

require_once 'application/classes/ObjectHTMLCache.php';

/**
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property CI_DB_active_record $db
 */
class object_html_cache_manager extends data_manager {

    public function __construct() {
        parent::__construct();
        $this->table_name = "objecthtmlcaches";
    }

    function get_saved_cache_id($objectClass,$objectPK) {
        $filter = array("objectClass"=>$objectClass, "objectPK" => $objectPK);
        $this->db->select("cacheID");
        $query = $this->db->get_where($this->table_name, $filter);
        $arr = $query->result_array();
        if( count($arr) > 0 ) {

            return $arr[0]["cacheID"] ;
        }
        else {
            return -1;
        }
    }

    function get_saved_cache_html($objectClass,$objectPK) {
        $filter = array("objectClass"=>$objectClass, "objectPK" => $objectPK);
        $this->db->select("cacheContent");
        $query = $this->db->get_where($this->table_name, $filter);
        $arr = $query->result_array();
        if( count($arr) > 0 ) {
            return $arr[0]["cacheContent"] ;
        }
        else {
            return "";
        }
    }

    public function save($html_cache) {
        $cacheID = $this->get_saved_cache_id($html_cache->getObjectClass(), $html_cache->getObjectPK());
        $data_array = $this->class_mapper->classToArray("ObjectHTMLCache", $html_cache);
        if($cacheID > 0) {
            $data_array["cacheID"] = $cacheID;
            return $this->update($data_array);
        }
        else {
            return $this->insert($data_array);
        }
    }

    protected function insert($data_array) {
        $this->db->insert($this->table_name, $data_array);
        if( $this->db->affected_rows() > 0 ) {
            return $this->db->insert_id();
        }
        return -1;
    }

    protected function update($data_array) {
        $key_field_name = "cacheID";
        $id = $data_array[$key_field_name];
        unset($data_array[$key_field_name]);
        $this->db->where($key_field_name, $id);
        $this->db->update($this->table_name, $data_array);
        if( $this->db->affected_rows() > 0 ) {
            return $id;
        }
        return -1;
    }

    /**
     * @access	public
     * @param	id
     * @return	Process
     */
    public function find_by_id($id) {

    }


    /**
     * @access	public
     * @param	id
     * @return	array
     */
    public function find_by_filter($filter = array(), $join_filter = array()) {
        return $this->select_db_table($filter, $this->table_name, "ObjectHTMLCache");
    }

    public function delete($process) {
    }

    public function delete_by_id($id) {
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

}
?>
