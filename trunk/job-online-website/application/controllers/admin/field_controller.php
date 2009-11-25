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
     * @AjaxAction
     * @Secured(role = "Administrator")
     */
    public function field_details($fieldID = -1, $formID = -1) {
        $this->load->helper("field_type");
        $this->load->model("field_manager");
        $data = $this->field_manager->get_dependency_instances();
        $data["action_uri"] = "admin/field_controller/save";
        $data["id"] = $fieldID;
        $data["FormID"] = $formID;
        if($fieldID > 0) {
            $data["obj_details"] = $this->field_manager->find_by_id($fieldID);
            $data["related_objects"] = array();
        }
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
     * @AjaxAction
     * @Secured(role = "Administrator")
     */
    public function save() {
        $this->load->model("field_manager");

        $field = new Field();
        $field->setFieldID( $this->input->post("FieldID") );
        $field->setFieldTypeID( $this->input->post("FieldTypeID") );
        $field->setFieldName( $this->input->post("FieldName") );
        $field->setValidationRules( $this->input->post("ValidationRules") );
        $field->setFieldOptions( json_decode( $this->input->post("field_option_data") ) );
        $field->addToForm( $this->input->post("FormID") );

        $this->field_manager->save($field);

        if(FieldType::isSelectableType($field->getFieldTypeID())) {
            $this->load->model("field_options_manager");
            foreach ($field->getFieldOptions() as $arr) {
                $this->field_options_manager->save($arr);
            }
        }

        $this->output->set_output("Save successfully!");
    }

    public function addFieldOption() {
        $fieldID = $this->input->post("FieldID");
        $optionName = $this->input->post("OptionName");

        ApplicationHook::logInfo($fieldID. " - ". $optionName);
    }
}
?>
