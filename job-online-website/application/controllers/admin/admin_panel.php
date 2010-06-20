<?php

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
class admin_panel extends Controller {
    public function __construct() {
        parent::Controller();
        $this->load->helper("field_type");
    }

    /**
     * @Decorated
     * @Secured(role = "Administrator")
     */
    public function index() {
        $data = "Admin panel for administrator! (Thông tin hướng dẫn quản lý database việc làm)";
        $this->output->set_output($data);
    //    $this->load->view("admin/left_menu_bar",NULL);
    }

    /**
     * @Decorated
     * @Secured(role = "Administrator")
     */
    public function manage_user($id = "all", $start_index = 1) {

    }


    protected function render_list_forms_view($id, $build_form, $show_in_page, $join_filter = array()) {
        $this->load->model("forms_manager");
        $this->load->library('table');
        $filter = array();
        if(is_numeric($id)) {
            $filter = array("FormID"=>$id);
        }
        $forms = $this->forms_manager->find_by_filter($filter, $join_filter);

        $actions = '<div class="actions" >';
        $actions .= anchor('admin/form_controller/form_details/[FormID]', 'Edit', array('title' => 'Edit Details'));
        $actions .= (" | ".anchor('admin/form_controller/form_builder/[FormID]', 'Build form', array('title' => 'Build form')));
        $actions .= "</div>";
        
        $data_table = $this->class_mapper->DataListToDataTable("Form",$forms, $actions);

        $data["table_name"] = "forms";
        $data["data_table"] = $data_table;
        $data["data_table_heading"] = array('FormID', 'FormName','Description',"Actions");
        $data["data_editable_fields"] = array('FormName'=>TRUE,'Description'=>TRUE);
        $data["edit_in_place_uri"] = "admin/admin_panel/save_data_table_cell/";

        if($show_in_page) {
            $this->load->view("global_view/data_grid",$data);
            return "";
        }
        else {
            return $this->load->view("global_view/data_grid",$data, TRUE);
        }
    }

    protected function render_list_fields_view($id, $show_in_page) {
        $this->load->model("field_manager");
        $this->load->library('table');
        $filter = array();
        if(is_numeric($id)) {
            $filter = array("FieldID"=>$id);
        }
        $fields = $this->field_manager->find_by_filter($filter);        
        $actions = anchor('admin/field_controller/field_details/[FieldID]', 'Edit', array('title' => 'Edit Details','class'=>'iframe use_fancybox'));        
        $data_table = $this->class_mapper->DataListToDataTable("Field",$fields,$actions);

        $data["table_name"] = "fields";
        $data["data_table"] = $data_table;
        $data["data_table_heading"] = array('FieldID', 'FieldTypeID','FieldName','Rules','Actions');
        $data["data_editable_fields"] = array('FieldID'=>FALSE, 'ObjectID'=>TRUE, 'FieldTypeID'=>TRUE,'FieldName'=>TRUE,'ValidationRules'=>TRUE,'Actions'=>FALSE);
        $data["edit_in_place_uri"] = "admin/admin_panel/save_data_table_cell/";
        $data["description"] = $this->load->view("form/field_validation_guide","",TRUE);

        if($show_in_page) {
            $this->load->view("global_view/data_grid",$data);
            return "";
        }
        else {
            return $this->load->view("global_view/data_grid",$data, TRUE);
        }
    }



    /**
     * 
     * @Secured(role = "Administrator")
     */
    public function save_data_table_cell() {
        echo $this->input->post("editable_field_value");
        //TODO

//        $editable_field_name = ($this->input->post("editable_field_name"));
//        $tokens = explode("-", $editable_field_name);
//
//        $table = $tokens[0] ;
//        $id = $tokens[1];
//        $primary_key_field = Process::$PRIMARY_KEY_FIELDS;
//        if($primary_key_field == $tokens[2] ) {
//            return $this->input->post("editable_field_value");
//        }
//
//        $data = array(
//            $tokens[2] => $this->input->post("editable_field_value")
//        );
//        $this->db->where($primary_key_field, $id);
//        $this->db->update($table, $data);
//
//        echo $this->input->post("editable_field_value");
    }



   

}
?>
