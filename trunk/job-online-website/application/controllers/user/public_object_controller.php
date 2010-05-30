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
     * @Secured(role = "user")
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
     * @Secured(role = "user")
     */
    public function edit( $objID ) {
        $this->load->model("object_manager");
        $this->load->model("forms_manager");
        $this->load->model("objectclass_manager");
        $this->load->model("process_manager");

        $obj = $this->object_manager->getObjectInstance($objID);
        $classID = $obj->getObjectClassID();
        if($classID > 0) {
            $object_class = $this->objectclass_manager->find_by_id($classID);
            $data["object_class"] = $object_class;
            $data["object"] = $obj;
            $data["formsOfObject"] = $this->forms_manager->getAllFormsOfObjectClass($classID);;
            
            foreach ($object_class->getUsableProcesses() as $pro) {
                $data["objectCacheHTML"] = $this->process_manager->getIndentityProcessHTMLCache($pro->getProcessID());
                break;
            }

            $this->load->view("user/object_primary_view",$data);
        }
    }


    /**
     * @Decorated
     * @Secured(role = "user")
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
     * @AjaxAction
     * @Secured(role = "user")
     */
    public function ajax_edit_form($classID, $ObjectID, $FormID ) {
        $this->do_form($classID, $ObjectID, $FormID);
    }



    /**
     * @Secured(role = "user")
     */
    public function save($ObjectClassID , $ObjectID = -1 ) {
        $this->load->model("object_manager");
        $this->load->model("field_manager");
        if($ObjectClassID > 0) {
            $obj = new Object();
            $obj->setObjectClassID($ObjectClassID);
            $obj->setObjectID($ObjectID);
            $obj->setFieldValues( json_decode($this->input->post("FieldValues")) );

            $id = $this->object_manager->save($obj);
            if($id > 0) {
                $data = array();
                $data["info_message"] = "Đã lưu dữ liệu/ Saved!";
                $data["redirect_url"] = site_url("user/public_object_controller/list_all/".$ObjectClassID)."#".$id;
                $this->load->view("global_view/simple_message_info",$data);
            }
            else {
                echo "Insert new object failed!";
            }
        }
    }

   

    /**
     * @Decorated
     * @Secured(role = "user")
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
     * @Secured(role = "user")
     */
    public function list_objects( $AccessDataURI = '/' ) {
        $this->load->model("object_manager");
        $this->load->model("objectclass_manager");

        $objectClass = $this->objectclass_manager->find_by_uri($AccessDataURI);

        if($objectClass != NULL) {
            $data = array();
            $data["objectClass"] = $objectClass;
            $data["objects"] = $this->object_manager->getAllObjectsInClass($objectClass->getObjectClassID());

            $pagination_config = array();
            $pagination_config['base_url'] = site_url("admin/objectclass_controller/show");
            $pagination_config['total_rows'] = $this->objectclass_manager->count_total();
            $pagination_config['per_page'] = 2;
            $data["pagination_config"] = $pagination_config;
        }
        else {
            throw new RuntimeException("ObjectClass not found for ID: $ObjectClassID", 500);
        }

        $this->load->view("user/all_objects_in_class_list_view",$data);
    }
}
?>
