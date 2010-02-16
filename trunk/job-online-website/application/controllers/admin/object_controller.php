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
 * @property object_manager $object_manager
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
    public function create_object($classID ) {
        $this->load->model("objectclass_manager");
        $this->load->model("process_manager");
        if($classID > 0) {
            $object_class = $this->objectclass_manager->find_by_id($classID);
            $data["object_class"] = $object_class;
            foreach ($object_class->getUsableProcesses() as $pro) {
                $data["objectCacheHTML"] = $this->process_manager->getIndentityProcessHTMLCache($pro->getProcessID());
                break;
            }
            $this->load->view("admin/create_object",$data);
        }
    }

    /**
     * @Decorated
     * @Secured(role = "Administrator")
     */
    public function do_process($classID, $ObjectID, $ProcessID ) {
        $this->load->model("object_manager");
        $this->load->model("process_manager");

        //$object->getObjectClassID()

        ApplicationHook::logInfo($ProcessID."-".$ObjectID);

    }

    /**
     * @Decorated
     * @Secured(role = "Administrator")
     */
    public function do_form($classID, $ObjectID, $FormID ) {
        $this->load->model("object_manager");        
        $this->load->model("object_html_cache_manager");
        $this->load->model("forms_manager");

        $data = array();
        $data["objectID"] = $ObjectID;
        $data["classID"] = $classID;
        $data["object"] = $this->object_manager->getObjectInstanceInForm($ObjectID, $FormID);
        $data["form"] = $this->forms_manager->find_by_id($FormID);
        $data["cache"] = $this->object_html_cache_manager->get_saved_cache_html(Form::$HTML_DOM_ID_PREFIX, $FormID);
        $this->load->view("admin/object_do_form_view",$data);
    }

    /**
     * @Decorated
     * @Secured(role = "Administrator")
     */
    public function edit( $objID ) {
        $this->load->model("object_manager");
        $this->load->model("objectclass_manager");
        $this->load->model("process_manager");

        $obj = $this->object_manager->getObjectInstance($objID);
        $classID = $obj->getObjectClassID();
        if($classID > 0) {
            $object_class = $this->objectclass_manager->find_by_id($classID);
            $data["object_class"] = $object_class;
            $data["object"] = $obj;

            foreach ($object_class->getUsableProcesses() as $pro) {
                $data["objectCacheHTML"] = $this->process_manager->getIndentityProcessHTMLCache($pro->getProcessID());
                break;
            }

            $this->load->view("admin/create_object",$data);
        }
    }

    /**     
     * @Secured(role = "Administrator")
     */
    public function save($ObjectClassID , $ObjectID = -1 ) {
        $this->load->model("object_manager");
        $this->load->model("field_manager");
        if($ObjectClassID > 0) {       
            $obj = new Object();
            $obj->setObjectClassID($ObjectClassID);
            $obj->setObjectID($ObjectID);            
            $obj->setFieldValues( json_decode($this->input->post("FieldValues")) );

            $ok = $this->object_manager->save($obj);
            $data = array();
            $data["info_message"] = "Save successfully !";
            $data["redirect_url"] = site_url("admin/object_controller/list_all/".$ObjectClassID);
            $this->load->view("global_view/info_and_redirect",$data);
        }
    }

    /**
     * @Decorated
     * @Secured(role = "Administrator")
     */
    public function list_all($ObjectClassID ) {
        $this->load->model("object_manager");
        $this->load->model("objectclass_manager");

        $data = array();
        $data["objects"] = $this->object_manager->getAllObjectsInClass($ObjectClassID);
        $data["objectClass"] = $this->objectclass_manager->find_by_id($ObjectClassID);

        $this->load->view("admin/all_objects_in_class_list_view",$data);
    }
}
?>
