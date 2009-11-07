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
class field_controller extends admin_panel {
    public function __construct() {
        parent::__construct();
    }


    /**
     * @Decorated
     * @Secured(role = "Administrator")
     */
    public function field_details($id = -1) {
        $this->load->helper("field_type");
        $this->load->model("field_manager");
        $data = $this->field_manager->get_dependency_instances();
        $data["action_uri"] = "admin/admin_panel/save_object/Field";
        $data["id"] = $id;
        $this->load->view("admin/field_details",$data);
    }
    
    /**
     * @Decorated
     * @Secured(role = "Administrator")
     */
    public function list_fields($id = "all") {
        $this->render_list_fields_view($id, TRUE);
    }
 /**
     * @Decorated
     * @Secured(role = "Administrator")
     */
    public function save() {
        $this->load->model("field_manager");
        $field = new Field();
        $this->field_manager->save($field);       
        $this->output->set_output("Save successfully!");
    }
}
?>
