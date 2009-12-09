<?php
require_once 'admin_panel.php';


/**
 * Description of admin_panel
 *
 * @property page_decorator $page_decorator
 * @property class_mapper $class_mapper
 * @property CI_Loader $load
 * @property CI_Output $output
 * @property CI_DB_active_record $db
 *
 * @property objectclass_manager $objectclass_manager
 * @property process_manager $process_manager * 
 *
 * @author Trieu Nguyen. Email: tantrieuf31@gmail.com
 */
class objectclass_controller extends admin_panel {
    public function __construct() {
        parent::__construct();
    }

    /**
     * @Decorated
     * @Secured(role = "Administrator")
     */
    public function show_details($id = -1) {
        $this->load->model("objectclass_manager");
        $this->load->model("process_manager");
        $data = $this->objectclass_manager->get_dependency_instances();
        $data["action_uri"] = "admin/objectclass_controller/save";
        $data["id"] = $id;
        if($id > 0) {
            $data["obj_details"] = $this->objectclass_manager->find_by_id($id);
        }
        $data["related_views"] = "";
        $data["available_processes"] =  $this->process_manager->find_by_filter();
        $this->load->view("admin/objectclass_details",$data);
    }

    /**
     * @Decorated
     * @Secured(role = "Administrator")
     */
    public function show($id = "all",$start_index = 1) {
        $this->load->model("objectclass_manager");
        $this->load->library('table');

        $filter = array();
        if(is_numeric($id)) {
            $filter = array("ObjectClassID"=>$id);
        }
        $classes = $this->objectclass_manager->find_by_filter($filter);
        $actions = anchor('admin/objectclass_controller/show_details/[ObjectClassID]', 'View Details', array('title' => 'View Details'));
        $actions .= " | ";
        $actions .= anchor('admin/object_controller/create_object/[ObjectClassID]', 'Create', array('title' => 'Create new'));
        $actions .= " | ";
        $actions .= anchor('admin/object_controller/list_all/[ObjectClassID]', 'List', array('title' => 'List'));
        $data_table = $this->class_mapper->DataListToDataTable("ObjectClass",$classes,$actions);

        $data["table_name"] = "classes";
        $data["data_table"] = $data_table;
        $data["data_table_heading"] = array('ObjectClassID', 'ObjectClassName', 'Descripttion','Actions');
        $data["data_editable_fields"] = array('ObjectClassName'=>TRUE, 'Description' => TRUE);

        $pagination_config = array();
        $pagination_config['base_url'] = site_url("admin/objectclass_controller/show");
        $pagination_config['total_rows'] = $this->objectclass_manager->count_total();
        $pagination_config['per_page'] = 2;
        $data["pagination_config"] = $pagination_config;

        $this->load->view("global_view/data_grid",$data);
    }

    /**
     * @Decorated
     * @Secured(role = "Administrator")
     */
    public function save() {
        $this->load->model("objectclass_manager");
        $obj = new ObjectClass();
        $obj->setObjectClassID($this->input->post("ObjectClassID"));
        $obj->setObjectClassName($this->input->post("ObjectClassName"));
        $obj->setDescription($this->input->post("Description"));
        $obj->setUsableProcesses( json_decode($this->input->post("UsableProcesses") ) );

        $this->objectclass_manager->save($obj);
        $this->output->set_output("Save successfully!");
    }

  

}
?>
