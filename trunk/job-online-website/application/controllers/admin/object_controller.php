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
class object_controller extends admin_panel {
    public function __construct() {
        parent::__construct();
    }

    /**
     * @Decorated
     * @Secured(role = "Administrator")
     */
    public function show_details($id = -1) {      
        $this->load->model("object_manager");
        $data = $this->object_manager->get_dependency_instances();
        $data["action_uri"] = "admin/object_controller/save";
        $data["id"] = $id;
        if($id > 0) {
            $data["obj_details"] = $this->object_manager->find_by_id($id);
        }

        $data["related_views"] = "";

        $this->load->view("admin/object_details",$data);
    }

    /**
     * @Decorated
     * @Secured(role = "Administrator")
     */
    public function show($id = "all",$start_index = 1) {
        $this->load->model("object_manager");
        $this->load->library('table');
        $filter = array();
        if(is_numeric($id)) {
            $filter = array("ObjectClassID"=>$id);
        }
        $classes = $this->object_manager->find_by_filter($filter);
        $actions = anchor('admin/object_controller/show_details/[ObjectClassID]', 'View Details', array('title' => 'View Details'));
        $actions = $actions ." | ".anchor('admin/object_controller/create_object/[ObjectClassID]', 'Create a object', array('title' => 'Create a object'));
        $data_table = $this->class_mapper->DataListToDataTable("ObjectClass",$classes,$actions);

        $data["table_name"] = "classes";
        $data["data_table"] = $data_table;
        $data["data_table_heading"] = array('ObjectClassID', 'ObjectClassName', 'Descripttion','Actions');
        $data["data_editable_fields"] = array('ProcessName'=>TRUE);


        $pagination_config = array();
        $pagination_config['base_url'] = site_url("admin/object_controller/show");
        $pagination_config['total_rows'] = $this->object_manager->count_total();
        $pagination_config['per_page'] = 2;
        $data["pagination_config"] = $pagination_config;

        $this->load->view("global_view/data_grid",$data);
    }

    /**
     * @Decorated
     * @Secured(role = "Administrator")
     */
    public function save() {
        $this->load->model("object_manager");
        $obj = new ObjectClass();
        $obj->setObjectClassID($this->input->post("ObjectClassID"));
        $obj->setObjectClassName($this->input->post("ObjectClassName"));
        $obj->setDescription($this->input->post("Description"));

        $this->object_manager->save($obj);
        $this->output->set_output("Save successfully!");
    }
}
?>
