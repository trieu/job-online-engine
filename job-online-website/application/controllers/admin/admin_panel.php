<?php

require_once "application/classes/Process.php";

/**
 * Description of admin_panel
 *
 * @property page_decorator $page_decorator
 * @property class_mapper $class_mapper
 * @property CI_Loader $load
 * @property CI_DB_active_record $db
 *
 * @author Trieu Nguyen. Email: tantrieuf31@gmail.com
 */
class admin_panel extends Controller {
    public function __construct() {
        parent::Controller();
    }


    /**
     * @Decorated
     */
    public function index() {
        $data = "Admin panel";
        $this->output->set_output($data);
    //    $this->load->view("admin/left_menu_bar",NULL);

    }

    /**
     * @Decorated
     */
    public function add_new_process() {
        $this->load->model("process_manager");
        $data = $this->process_manager->get_dependency_instances();
        $data["action_uri"] = "admin/admin_panel/save_object/Process";
        $this->load->view("form/form_view",$data);
    }

    /** @Decorated */
    public function save_object($object_name) {
        if($object_name == "Process") {
            $pro = new Process();
            $pro->setProcessID($this->input->post("ProcessID"));
            $pro->setGroupID($this->input->post("GroupID"));
            $pro->setProcessName($this->input->post("ProcessName"));

            $this->load->model("process_manager");
            $this->process_manager->save($pro);
        }
        $this->output->set_output("Save ".$object_name." successfully!");
    }

    /**
     * @Decorated
     */
    public function list_processes($id = "all") {
        $this->load->model("process_manager");
        $this->load->library('table');
        $filter = array();
        if(is_numeric($id)) {
            $filter = array("ProcessID"=>$id);
        }
        $processses = $this->process_manager->find_by_filter($filter);
        $data_table = $this->class_mapper->DataListToDataTable("Process",$processses);

        $data["table_name"] = "Processes";
        $data["data_table"] = $data_table;
        $data["data_table_heading"] = array('ProcessID', 'GroupID', 'ProcessName');
        $data["edit_in_place_uri"] = "admin/admin_panel/save_data_table_cell/";
        $this->load->view("global_view/data_grid",$data);
    }
	
	/**
     * @Decorated
     */
    public function list_forms($id = "all") {
        $this->load->model("process_manager");
        $this->load->library('table');
        $filter = array();
        if(is_numeric($id)) {
            $filter = array("ProcessID"=>$id);
        }
        $processses = $this->process_manager->find_by_filter($filter);
        $data_table = $this->class_mapper->DataListToDataTable("Process",$processses);

        $data["table_name"] = "Processes";
        $data["data_table"] = $data_table;
        $data["data_table_heading"] = array('ProcessID', 'GroupID', 'ProcessName');
        $data["edit_in_place_uri"] = "admin/admin_panel/save_data_table_cell/";
        $this->load->view("global_view/data_grid",$data);
    }
	
	/**
     * @Decorated
     */
    public function list_fields($id = "all") {
        $this->load->model("process_manager");
        $this->load->library('table');
        $filter = array();
        if(is_numeric($id)) {
            $filter = array("ProcessID"=>$id);
        }
        $processses = $this->process_manager->find_by_filter($filter);
        $data_table = $this->class_mapper->DataListToDataTable("Process",$processses);

        $data["table_name"] = "Processes";
        $data["data_table"] = $data_table;
        $data["data_table_heading"] = array('ProcessID', 'GroupID', 'ProcessName');
        $data["edit_in_place_uri"] = "admin/admin_panel/save_data_table_cell/";
        $this->load->view("global_view/data_grid",$data);
    }

    public function save_data_table_cell() {
        $editable_field_name = ($this->input->post("editable_field_name"));
        $tokens = explode("-", $editable_field_name);
		
        $table = $tokens[0] ;
        $id = $tokens[1];
        $primary_key_field = Process::$PRIMARY_KEY_FIELDS;
        if($primary_key_field == $tokens[2] ) {
            return $this->input->post("editable_field_value");
        }

        $data = array(
            $tokens[2] => $this->input->post("editable_field_value")
        );
        $this->db->where($primary_key_field, $id);
        $this->db->update($table, $data);
        
        echo $this->input->post("editable_field_value");
    }

    /**
     * @Decorated
     */
    public function form_builder() {
        $data[""] = "";
        $this->load->view("form/form_builder",$data);
    }

    /**
     * EndsWith
     * Tests whether a text ends with the given
     * string or not.
     *
     * @param     string
     * @param     string
     * @return    bool
     */
    private function EndsWith($Haystack, $Needle) {
        return strrpos($Haystack, $Needle) === strlen($Haystack)-strlen($Needle);
    }

}
?>
