<?php
require_once 'application/classes/Process.php';



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
    }

    /**
     * @Decorated
     * @Secured(role = "Administrator")
     */
    public function index() {
        $data = "Admin panel for administrator! (Thông tin hướng dẫn quản lý website việc làm)";
        $this->output->set_output($data);
    //    $this->load->view("admin/left_menu_bar",NULL);
    }

    /**
     * @Decorated
     * @Secured(role = "Administrator")
     */
    public function process_details($id = -1) {
        $this->load->helper("field_type");
        $this->load->model("process_manager");
        $data = $this->process_manager->get_dependency_instances();
        $data["action_uri"] = "admin/admin_panel/save_object/Process";
        $data["id"] = $id;
        if($id > 0){
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
    public function form_details($id = -1) {
        $this->load->helper("field_type");
        $this->load->model("forms_manager");
        $data = $this->forms_manager->get_dependency_instances();
        $data["action_uri"] = "admin/admin_panel/save_object/Form";
        $data["id"] = $id;
        if($id > 0){
            $data["obj_details"] = $this->forms_manager->find_by_id($id);
            $data["related_objects"] = $this->forms_manager->get_related_objects($id);
        }
        $this->load->view("admin/form_details",$data);
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
    public function save_object($object_name) {
        if($object_name == "Process") {
            $this->load->model("process_manager");
            $obj = new Process();
            $obj->setProcessID($this->input->post("ProcessID"));
            $obj->setGroupID($this->input->post("GroupID"));
            $obj->setProcessName($this->input->post("ProcessName"));
            $this->process_manager->save($obj);
        }
        else if($object_name == "Form") {
                $this->load->model("forms_manager");
                $obj = new Form();
                $obj->setProcessID($this->input->post("ProcessID"));
                $obj->setGroupID($this->input->post("GroupID"));
                $obj->setProcessName($this->input->post("ProcessName"));
                $this->process_manager->save($obj);
            }
        else if($object_name == "Field") {
                $this->load->model("field_manager");
                $obj = new Field();
                $obj->setProcessID($this->input->post("ProcessID"));
                $obj->setGroupID($this->input->post("GroupID"));
                $obj->setProcessName($this->input->post("ProcessName"));
                $this->process_manager->save($obj);
            }
        $this->output->set_output("Save ".$object_name." successfully!");
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
        $actions = anchor('admin/admin_panel/process_details/[ProcessID]', 'View Details', array('title' => 'View Details'));
        $data_table = $this->class_mapper->DataListToDataTable("Process",$processses,$actions);

        $data["table_name"] = "processes";
        $data["data_table"] = $data_table;
        $data["data_table_heading"] = array('ProcessID', 'GroupID', 'ProcessName','Actions');
        $data["data_editable_fields"] = array('ProcessID'=>FALSE, 'GroupID'=>TRUE,'ProcessName'=>TRUE,'Actions'=>FALSE);

        $GroupID_Opts =  array("type"=>"select","data"=> ($this->process_manager->get_select_field_options("groups")) );
        $data["editable_type_fields"] = array('GroupID'=>$GroupID_Opts);
        $data["edit_in_place_uri"] = "admin/admin_panel/save_data_table_cell/";

        $pagination_config = array();
        $pagination_config['base_url'] = site_url("admin/admin_panel/list_processes");
        $pagination_config['total_rows'] = $this->process_manager->count_total();
        $pagination_config['per_page'] = 2;
        $data["pagination_config"] = $pagination_config;

        $this->load->view("global_view/data_grid",$data);
    }

    /**
     * @Decorated
     * @Secured(role = "Administrator")
     */
    public function list_forms($id = "all", $build_form = false) {
        $this->render_list_forms_view($id, $build_form, TRUE);
    }

    /**
     * @Decorated
     * @Secured(role = "Administrator")
     */
    public function list_fields($id = "all") {
        $this->render_list_fields_view($id, TRUE);
    }

    protected function render_list_forms_view($id, $build_form, $show_in_page, $join_filter = array()) {
        $this->load->model("forms_manager");
        $this->load->library('table');
        $filter = array();
        if(is_numeric($id)) {
            $filter = array("FormID"=>$id);
        }
        $forms = $this->forms_manager->find_by_filter($filter, $join_filter);

        $actions = anchor('admin/admin_panel/form_details/[FormID]', 'View Details', array('title' => 'View Details'));
        
        $actions = $actions ." | ".anchor('admin/admin_panel/form_builder/[FormID]', 'Build form', array('title' => 'Build form'));
        
        $data_table = $this->class_mapper->DataListToDataTable("Form",$forms, $actions);

        $data["table_name"] = "forms";
        $data["data_table"] = $data_table;
        $data["data_table_heading"] = array('FormID', 'FormName',"Actions");
        $data["data_editable_fields"] = array('FormID'=>FALSE, 'FormName'=>TRUE,'Actions'=>FALSE);
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
        $actions = anchor('admin/fields/edit/[FieldID]', 'View Details', array('title' => 'View Details'));
        $data_table = $this->class_mapper->DataListToDataTable("Field",$fields,$actions);

        $data["table_name"] = "fields";
        $data["data_table"] = $data_table;
        $data["data_table_heading"] = array('FieldID', 'ObjectID', 'FieldTypeID','FieldName','ValidationRules','Actions');
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
     * @AjaxAction
     * @Secured(role = "Administrator")
     */
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
     * @Secured(role = "Administrator")
     */
    public function form_builder($id = -1) {
        if($id === -1) {
            redirect(site_url("admin/admin_panel/list_forms/all/true"));
        }

        $this->load->model("forms_manager");
        $this->load->model("object_html_cache_manager");
        $data["form"] = $this->forms_manager->find_by_id($id);
        $data["form_cache"] = $this->object_html_cache_manager->get_saved_cache_html(Form::$HTML_DOM_ID_PREFIX,$id);
        $data["palette_content"] = $this->loadPaletteContent();
        $this->load->view("form/form_builder",$data);
    }

    /**
     * @AjaxAction
     * @Secured(role = "Administrator")
     */
    public function reset_build_the_form() {
        $this->load->model("forms_manager");
        $this->load->model("object_html_cache_manager");

        $this->db->delete("field_form", array("FormID" => $this->input->post("ObjectPK") ));

        $cache = new ObjectHTMLCache();
        $cache->setObjectClass( $this->input->post("ObjectClass") );
        $cache->setObjectPK( $this->input->post("ObjectPK") );
        $cache->setCacheContent("");
        echo $this->object_html_cache_manager->save($cache);
    }

    /**
     * @AjaxAction
     * @Secured(role = "Administrator")
     */
    public function saveFormBuilderResult() {

        $is_html_cache_changed = $this->input->post("is_html_cache_changed");
        $Fields_Form_JSON = $this->input->post("Fields_Form_JSON");
        $Fields_Form_JSON = json_decode($Fields_Form_JSON);

        $existed_record = 0;
        foreach ($Fields_Form_JSON as $record) {
            $this->db->select("COUNT(*)");
            $this->db->from('field_form');
            $this->db->where("FieldID", $record->FieldID );
            $this->db->where("FormID", $record->FormID );
            $c = $this->db->count_all_results();
            $existed_record = $existed_record + $c;

            if($c == 0) {
                $this->db->insert("Field_Form", $record);
            }
            else {
            //                        ApplicationHook::logInfo($record->FieldID." FieldID already in table Field_Form");
            //                        ApplicationHook::logInfo($record->FormID." FormID already in table Field_Form");
            }
        }
        //        ApplicationHook::logError("existed_record ".$existed_record);
        //        ApplicationHook::logError("Fields_Form_JSON " . count($Fields_Form_JSON));
        if(($existed_record == count($Fields_Form_JSON)) && $is_html_cache_changed == "false") {
            echo -100;
            return ;
        }
        $this->load->model("object_html_cache_manager");
        $cache = new ObjectHTMLCache();
        $cache->setObjectClass( $this->input->post("ObjectClass") );
        $cache->setObjectPK( $this->input->post("ObjectPK") );
        $cache->setCacheContent( $this->input->post("CacheContent") );
        echo $this->object_html_cache_manager->save($cache);
    }


    public function loadPaletteContent() {
        $palette_content = "";
        $this->load->model("field_manager");
        $this->load->model("fieldtypes_manager");

        $data["fields"] = $this->field_manager->find_by_filter();

        $fieldtypes = $this->fieldtypes_manager->find_by_filter();
        $fieldtype = new FieldType();
        $map = array();
        foreach ($fieldtypes as $fieldtype) {
            $map[$fieldtype->getFieldTypeID()] = $fieldtype->getFieldTypeName();
        }
        $data["fieldtypes"] = $map;
        $palette_content = $this->load->view("admin/field_palette",$data,TRUE);
        return $palette_content;
    }

    /**
     * @AjaxAction
     * @Secured(role = "Administrator")
     */
    public function renderFieldUI($field_id) {
        $this->load->model("field_manager");
        $field = new Field();
        $field = $this->field_manager->find_by_id($field_id);
        echo $field->buildFieldUI();
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
