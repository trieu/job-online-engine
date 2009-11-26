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
    public function form_builder($formID = -1) {
        if($formID === -1) {
            redirect(site_url("admin/form_controller/list_forms/all/true"));
        }

        $this->load->model("forms_manager");
        $this->load->model("object_html_cache_manager");
        $data["form"] = $this->forms_manager->find_by_id($formID);
        $data["form_cache"] = $this->object_html_cache_manager->get_saved_cache_html(Form::$HTML_DOM_ID_PREFIX,$formID);
        $data["palette_content"] = $this->loadPaletteContent($formID);
        $this->load->view("admin/form_builder",$data);
    }

    public function loadPaletteContent($formID = -1) {
        $palette_content = "";
        $this->load->model("field_manager");
        $join_filter = array("field_form"=>"field_form.FieldID = fields.FieldID AND field_form.FormID = ".$formID);
        $data["fields"] = $this->field_manager->find_by_filter(array(),$join_filter);
        $data["FormID"] = $formID;
        $palette_content = $this->load->view("admin/field_palette",$data,TRUE);
        return $palette_content;
    }

    /** 
     * @Secured(role = "Administrator")
     */
    public function saveFormBuilderResult() {      
        $this->load->model("object_html_cache_manager");
        $cache = new ObjectHTMLCache();
        $cache->setObjectClass( $this->input->post("ObjectClass") );
        $cache->setObjectPK( $this->input->post("ObjectPK") );
        $cache->setCacheContent( $this->input->post("CacheContent") );
        $cache->setJavascriptContent( $this->input->post("JavascriptContent") );
        echo $this->object_html_cache_manager->save($cache);
    }

    /**
     * @Secured(role = "Administrator")
     */
    public function reset_build_the_form() {        
        $this->load->model("object_html_cache_manager");
        $cache = new ObjectHTMLCache();
        $cache->setObjectClass( $this->input->post("ObjectClass") );
        $cache->setObjectPK( $this->input->post("ObjectPK") );        
        echo $this->object_html_cache_manager->save($cache);
    }

}
?>
