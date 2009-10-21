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
        $this->load->helper("field_type");
        $this->load->view("form/form_view",$data);
    }

    /** @Decorated */
    public function save_object($object_name) {
        if($object_name == "Process") {
            $this->load->model("process_manager");
            $pro = new Process();
            $pro->setProcessID($this->input->post("ProcessID"));
            $pro->setGroupID($this->input->post("GroupID"));
            $pro->setProcessName($this->input->post("ProcessName"));
            $this->process_manager->save($pro);
        }
        $this->output->set_output("Save ".$object_name." successfully!");
    }

    /**
     * @Decorated
     */
    public function list_processes($id = "all",$start_index = 1) {
        $this->load->model("process_manager");
        $this->load->library('table');
        $filter = array();
        if(is_numeric($id)) {
            $filter = array("ProcessID"=>$id);
        }
        $processses = $this->process_manager->find_by_filter($filter);
        $actions = anchor('admin/admin_panel/form_builder/', 'View Details', array('title' => 'View Details'));
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
     */
    public function list_forms($id = "all") {
        $this->load->model("forms_manager");
        $this->load->library('table');
        $filter = array();
        if(is_numeric($id)) {
            $filter = array("FormID"=>$id);
        }
        $forms = $this->forms_manager->find_by_filter($filter);

        $actions = anchor('admin/admin_panel/form_builder/[FormID]', 'Build form', array('title' => 'Build form'));
        $data_table = $this->class_mapper->DataListToDataTable("Form",$forms, $actions);

        $data["table_name"] = "forms";
        $data["data_table"] = $data_table;
        $data["data_table_heading"] = array('FormID', 'FormName',"Actions");
        $data["data_editable_fields"] = array('FormID'=>FALSE, 'FormName'=>TRUE,'Actions'=>FALSE);
        $data["edit_in_place_uri"] = "admin/admin_panel/save_data_table_cell/";
        $this->load->view("global_view/data_grid",$data);
    }

    /**
     * @Decorated
     */
    public function list_fields($id = "all") {
        $this->load->model("field_manager");
        $this->load->library('table');
        $filter = array();
        if(is_numeric($id)) {
            $filter = array("FieldID"=>$id);
        }
        $fields = $this->field_manager->find_by_filter($filter);
        $actions = anchor('admin/fields/edit/[FieldID]', 'Edit Details', array('title' => 'Edit Details'));
        $data_table = $this->class_mapper->DataListToDataTable("Field",$fields,$actions);

        $data["table_name"] = "fields";
        $data["data_table"] = $data_table;
        $data["data_table_heading"] = array('FieldID', 'ObjectID', 'FieldTypeID','FieldName','ValidationRules','Actions');
        $data["data_editable_fields"] = array('FieldID'=>FALSE, 'ObjectID'=>TRUE, 'FieldTypeID'=>TRUE,'FieldName'=>TRUE,'ValidationRules'=>TRUE,'Actions'=>FALSE);
        $data["edit_in_place_uri"] = "admin/admin_panel/save_data_table_cell/";
        $data["description"] = $this->load->view("form/field_validation_guide","",TRUE);
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
    public function form_builder($id = -1) {
        if($id === -1) {
            redirect(site_url("admin/admin_panel/list_forms"));
        }

        $this->load->model("forms_manager");
        $this->load->model("object_html_cache_manager");
        $data["form"] = $this->forms_manager->find_by_id($id);
        $data["form_cache"] = $this->object_html_cache_manager->get_saved_cache_html(Form::$HTML_DOM_ID_PREFIX,$id);
        $data["palette_content"] = $this->loadPaletteContent();
        $this->load->view("form/form_builder",$data);
    }

    public function saveFormBuilderResult() {
        $Fields_Form_JSON = $this->input->post("Fields_Form_JSON");

        ApplicationHook::logInfo($Fields_Form_JSON);

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
        if($existed_record == count($Fields_Form_JSON)) {
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
