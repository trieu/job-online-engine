<?php
require_once 'admin_panel.php';

/**
 * Description of admin_panel
 *
 * @property page_decorator $page_decorator
 * @property class_mapper $class_mapper
 * @property CI_Loader $load
 * @property CI_DB_active_record $db
 *
 * @property field_manager $field_manager
 *
 * @author Trieu Nguyen. Email: tantrieuf31@gmail.com
 */
class process_controller extends admin_panel {
    public function __construct() {
        parent::__construct();
    }

   
    /**
     * @Decorated
     * @Secured(role = "Administrator")
     */
    public function process_details($id = -1) {        
        $this->load->model("process_manager");
        $data = $this->process_manager->get_dependency_instances();
        $data["action_uri"] = "admin/process_controller/save";
        $data["id"] = $id;
        if($id > 0) {
            $data["obj_details"] = $this->process_manager->find_by_id($id);
        }

        $join_filter = array("form_process" => "form_process.FormID = forms.FormID AND form_process.ProcessID = ".$id);
        $data["related_views"] = $this->render_list_forms_view("all",FALSE, FALSE,$join_filter);

        $this->load->view("admin/process_details",$data);
    }

    /**
     * @Decorated
     * @Secured(role = "Administrator")
     */
    public function list_processes($id = "all",$start_index = 1) {
        $this->load->model("process_manager");
        $this->load->library('table');
        $filter = array();
        if(is_numeric($id)) {
            $filter = array("ProcessID"=>$id);
        }
        $processses = $this->process_manager->find_by_filter($filter);
        $actions = anchor('admin/process_controller/process_details/[ProcessID]', 'Edit', array('title' => 'Edit'));
        $data_table = $this->class_mapper->DataListToDataTable("Process",$processses,$actions);

        $data["table_name"] = "processes";
        $data["data_table"] = $data_table;
        $data["data_table_heading"] = array('ProcessID','ProcessName', 'Description','Actions');
        $data["data_editable_fields"] = array('ProcessName'=>TRUE,'Description'=>TRUE);

        $GroupID_Opts =  array("type"=>"select","data"=> ($this->process_manager->get_select_field_options("groups")) );
        $data["editable_type_fields"] = array('GroupID'=>$GroupID_Opts);
        $data["edit_in_place_uri"] = "admin/admin_panel/save_data_table_cell/";

        $pagination_config = array();
        $pagination_config['base_url'] = site_url("admin/process_controller/list_processes");
        $pagination_config['total_rows'] = $this->process_manager->count_total();
        $pagination_config['per_page'] = 2;
        $data["pagination_config"] = $pagination_config;

        $this->load->view("global_view/data_grid",$data);
    }

    /**
     * @Decorated
     * @Secured(role = "Administrator")
     */
    public function save() {
        $id = $this->input->post("ProcessID");
      
        $this->load->model("process_manager");
        $obj = new Process();
        $obj->setProcessID($id);
        $obj->setProcessName($this->input->post("ProcessName"));
        $obj->setDescription($this->input->post("Description"));
        $this->process_manager->save($obj);
        $this->output->set_output("Save successfully!");
       
    }

    public function getProcessesAsJson() {
        ApplicationHook::log($this->input->post("q"));
        $this->load->model("process_manager");
        $processses = $this->process_manager->find_by_filter();
        $arr = array();
        foreach ($processses as $p) {
            $obj = new StdClass;
            $obj->id = $p->getProcessID();
            $obj->name = $p->getProcessName();
            array_push($arr, $obj);
        }
        echo json_encode($arr);
    }

}
?>
