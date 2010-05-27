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
    public function list_all($ObjectClassID ) {
        $this->load->model("object_manager");
        $this->load->model("objectclass_manager");

        $objectClass = $this->objectclass_manager->find_by_id($ObjectClassID);
        
        if($objectClass != NULL) {
            $data = array();
            $data["objectClass"] = $objectClass;
            $data["objects"] = $this->object_manager->getAllObjectsInClass($objectClass->getObjectClassID());

            $this->load->library('pagination');
            $config['base_url'] = 'http://localhost/job-online-website/tiengviet.php/admin/object_controller/list_all/1';
            $config['total_rows'] = '60';
            $config['per_page'] = '20';
            $config['page_query_string'] = TRUE;
            $this->pagination->initialize($config);
            $data["pagination_links"] = $this->pagination->create_links();

            $this->load->view("admin/all_objects_in_class_list_view",$data);
        }
        else { 
            throw new RuntimeException("ObjectClass not found for ID: $ObjectClassID", 500);
        }        
    }

    /**
     * @Decorated
     * @Secured(role = "Administrator")
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

        $this->load->view("admin/all_objects_in_class_list_view",$data);
    }

    /**
     * @Decorated
     * @Secured(role = "Administrator")
     */
    public function delete( $objID , $classID ) {
        $this->load->model("object_manager");
        $data = array();
        if( $this->object_manager->delete_by_id($objID) ){            
            $data["info_message"] = "Delete successful! ";            
        }
        else {
             $data["info_message"] = "Object can not found, delete fail!! ";
        }
        $data["redirect_url"] = site_url("admin/object_controller/list_all/".$classID);
        $this->load->view("global_view/info_and_redirect",$data);
    }
}
?>
