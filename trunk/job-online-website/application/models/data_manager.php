<?php
require_once 'application/libraries/class_mapper.php';

/**
 *
 * @property CI_Loader $load
 * @property CI_DB_active_record $db
 */
abstract class data_manager extends Model {
    protected $class_mapper;
    protected $table_name = NULL;

    public function __construct() {
        parent::__construct();
        $this->class_mapper = new class_mapper();
    }

    /**
     * abstract method save a object
     *
     * @access	public
     * @param	object
     * @return	object
     */
    abstract public function save($object);

    /**
     * abstract method insert a new object
     *
     * @access	protected
     * @param	object
     * @return	object
     */
    abstract protected function insert($object);

    /**
     * abstract method update a existed object
     *
     * @access	protected
     * @param	object
     * @return	object
     */
    abstract protected function update($object);

    /**
     * abstract method delete a existed object
     *
     * @access	public
     * @param	object
     * @return	object
     */
    abstract public function delete($object);

    /**
     * abstract method find a existed object by the identity
     *
     * @access	public
     * @param	id
     * @return	object
     */
    abstract public function find_by_id($id);

    /**
     * abstract method find a existed object by the identity
     *
     * @access	public
     * @param	id
     * @return	long
     */
    abstract public function delete_by_id($id);

    /**
     * abstract method find a existed object by the filter array
     *
     * @access	public
     * @param	filter
     * @return	object
     */
    abstract public function find_by_filter($filter = array());

    /**
     * method count total records in table
     *
     * @access	public
     * @return	int
     */
    public function count_total(){
        if($this->table_name != null){
            return $this->db->count_all($this->table_name);
        }
        else {
            ApplicationHook::logError("this->table_name is NULL!");
            return 0;
        }
    }

    /**
     * Overidable method for mapping from database row into object
     *
     * @access	protected
     * @param	$data_row, $class_name, $object
     * @return	object
     */
    protected function class_mapping($data_row, $class_name, $object ) {
        if($data_row != NULL && $class_name != NULL && $object != NULL) {
            $this->class_mapper->parseClass($class_name);
            return $this->class_mapper->dataRowMappingToObject($data_row, $object);
        }
        return NULL;
    }

    /**
     * Overidable method for select table from database and mapping to array of object
     *
     * @access	protected
     * @param	$filter, $table_name, $class_name
     * @return	$list = array();
     */
    protected function select_db_table(array $filter, $table_name, $class_name) {
        $query = $this->db->get_where($table_name, $filter);
        $list = array();
        $idx = 0;
        foreach ($query->result_array() as $data_row) {
            $pro = new $class_name();
            $list[$idx++] = $this->class_mapping($data_row, $class_name, $pro);
        }
        return $list;
    }

}
?>
