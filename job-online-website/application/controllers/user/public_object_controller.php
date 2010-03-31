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
 * @property object_manager $object_manager
 *
 * @author Trieu Nguyen. Email: tantrieuf31@gmail.com
 */
class public_object_controller extends Controller {
    public function __construct() {
        parent::__construct();
    }

    /**
     * @Decorated     
     */
    public function create_object($classID ) {
        $this->load->model("objectclass_manager");
        $this->load->model("process_manager");
        if($classID > 0) {
            $object_class = $this->objectclass_manager->find_by_id($classID);
            $data["object_class"] = $object_class;
            $data["objectHTMLCaches"] = array();
            foreach ($object_class->getUsableProcesses() as $pro) {
                $data["objectHTMLCaches"][$pro->getProcessID()] = $this->process_manager->getProcessHTMLCaches( $pro->getProcessID() );
            }
            $this->load->view("user/create_object",$data);
        }
    }


    /**
     * @Decorated     
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
        $this->load->view("user/object_do_form_view",$data);
    }



    /**   
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
            $data["redirect_url"] = site_url("user/public_object_controller/list_all/".$ObjectClassID);
            $this->load->view("global_view/info_and_redirect",$data);
        }
    }

    /**
     * @Decorated
     */
    public function list_all($ObjectClassID ) {
        $this->load->model("object_manager");
        $this->load->model("objectclass_manager");

        $objectClass = $this->objectclass_manager->find_by_id($ObjectClassID);

        if($objectClass != NULL) {
            $data = array();
            $data["objectClass"] = $objectClass;
            $data["objects"] = $this->object_manager->getAllObjectsInClass($objectClass->getObjectClassID());
            $this->load->view("user/all_objects_in_class_list_view",$data);
        }
        else {
            throw new RuntimeException("ObjectClass not found for ID: $ObjectClassID", 500);
        }
    }

    /**
     * @Decorated    
     */
    public function list_objects( $AccessDataURI = '/' ) {
        $this->load->model("object_manager");
        $this->load->model("objectclass_manager");

        $objectClass = $this->objectclass_manager->find_by_uri($AccessDataURI);

        if($objectClass != NULL) {
            $data = array();
            $data["objectClass"] = $objectClass;
            $data["objects"] = $this->object_manager->getAllObjectsInClass($objectClass->getObjectClassID());
        }
        else {
            throw new RuntimeException("ObjectClass not found for ID: $ObjectClassID", 500);
        }

        $this->load->view("user/all_objects_in_class_list_view",$data);
    }
}
?>
