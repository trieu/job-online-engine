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
 * @property forms_manager $forms_manager
 *
 * @author Trieu Nguyen. Email: tantrieuf31@gmail.com
 */
class form_controller extends admin_panel {

    public function __construct() {
        parent::__construct();
    }

    /**
     * @Decorated
     * @Secured(role = "Administrator")
     */
    public function form_details($id = -1) {
        $this->load->helper("field_type");
        $this->load->model("forms_manager");
        $data = array();
        $data["action_uri"] = "admin/form_controller/save";
        $data["id"] = $id;
        if($id > 0) {
            $data["obj_details"] = $this->forms_manager->find_by_id($id);
            $data["related_objects"] = $this->forms_manager->get_related_objects($id);
        }
        $this->load->view("admin/form_details",$data);
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
    public function save() {
        $this->load->model("forms_manager");
        $form = new Form();
        $form->setFormID($this->input->post("FormID"));
        $form->setFormName($this->input->post("FormName"));
        $form->setDescription($this->input->post("Description"));
        
        $ProcessIDs = explode("&", $this->input->post("ProcessIDs") );
        foreach ($ProcessIDs as $p_id) {
            ApplicationHook::log($p_id);
            $form->addProcessID($p_id);
        }
        
        $this->forms_manager->save($form);
        $this->output->set_output("Save  successfully!");
    }

    /**
     * @Decorated
     * @Secured(role = "Administrator")
     */
    public function form_builder($id = -1) {
        if($id === -1) {
            redirect(site_url("admin/form_controller/list_forms/all/true"));
        }

        $this->load->model("forms_manager");
        $this->load->model("object_html_cache_manager");
        $data["form"] = $this->forms_manager->find_by_id($id);
        $data["form_cache"] = $this->object_html_cache_manager->get_saved_cache_html(Form::$HTML_DOM_ID_PREFIX,$id);
        $data["palette_content"] = $this->loadPaletteContent();
        $this->load->view("admin/form_builder",$data);
    }

    public function loadPaletteContent() {
        $palette_content = "";
        $this->load->model("field_manager");
        $data["fields"] = $this->field_manager->find_by_filter();
        $palette_content = $this->load->view("admin/field_palette",$data,TRUE);
        return $palette_content;
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
                $this->db->insert("field_form", $record);
            }
            else {
                //ApplicationHook::logInfo($record->FieldID." FieldID already in table Field_Form");
                //ApplicationHook::logInfo($record->FormID." FormID already in table Field_Form");
            }
        }
        //ApplicationHook::logError("existed_record ".$existed_record);
        //ApplicationHook::logError("Fields_Form_JSON " . count($Fields_Form_JSON));
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

}
?>
