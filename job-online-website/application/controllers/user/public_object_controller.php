<?php

/**
 * public controler for non-admin
 *
 * @property page_decorator $page_decorator
 * @property class_mapper $class_mapper
 * @property CI_Loader $load
 * @property CI_DB_active_record $db *
 * @property field_manager $field_manager
 * @property object_manager $object_manager
 * @property cloud_storage_manager $cloud_storage_manager
 *
 * @author Trieu Nguyen. Email: tantrieuf31@gmail.com
 */
class public_object_controller extends Controller {

    public function __construct() {
        parent::__construct();
    }

    protected function getBloggerService() {
        $this->load->library('gdata_blogger_service');
        $this->load->library('AES');

        $email = $this->config->item('google_email');
        $password = $this->config->item('aes256_encrypted_password');
        $password = AesCtr::decrypt($password, $email, 256);
        $loginParams = array('email' => $email, 'password' => $password);
        $bloggerService = gdata_blogger_service::getInstance($loginParams);
        $bloggerService->blogID = $this->config->item('db_id');
        return $bloggerService;
    }

    /**
     * @Decorated
     * @Secured(role = "user")
     */
    public function create_object($classID) {
        $this->load->model("objectclass_manager");
        $this->load->model("process_manager");
        if ($classID > 0) {
            $object_class = $this->objectclass_manager->find_by_id($classID);
            $data["object_class"] = $object_class;
            $data["objectHTMLCaches"] = array();
            foreach ($object_class->getUsableProcesses() as $pro) {
                $data["objectHTMLCaches"][$pro->getProcessID()] = $this->process_manager->getProcessHTMLCaches($pro->getProcessID());
            }
            $this->load->view("user/create_object", $data);
        }
    }

    /**
     * @Decorated
     * @Secured(role = "user")
     */
    public function edit($objID) {
        $this->load->model("object_manager");
        $this->load->model("forms_manager");
        $this->load->model("objectclass_manager");
        $this->load->model("process_manager");

        $obj = $this->object_manager->getObjectInstance($objID);
        $classID = $obj->getObjectClassID();
        if ($classID > 0) {
            $object_class = $this->objectclass_manager->find_by_id($classID);
            $data["object_class"] = $object_class;
            $data["object"] = $obj;
            $data["formsOfObject"] = $this->forms_manager->getAllFormsOfObjectClass($classID);

            foreach ($object_class->getUsableProcesses() as $pro) {
                $data["objectCacheHTML"] = $this->process_manager->getIndentityProcessHTMLCache($pro->getProcessID());
                break;
            }

            $this->load->view("user/object_primary_view", $data);
        }
    }

    /**
     * @Decorated
     * @Secured(role = "user")
     */
    public function object_details($objID) {
        $this->load->model("object_manager");
        $this->load->model("forms_manager");
        $this->load->model("objectclass_manager");
        $this->load->model("process_manager");

        $obj = $this->object_manager->getObjectInstance($objID);
        $classID = $obj->getObjectClassID();
        if ($classID > 0) {
            $data = array();
            $object_class = $this->objectclass_manager->find_by_id($classID);
            $data["object"] = $obj;
            $data["formsOfObject"] = $this->forms_manager->getAllFormsOfObjectClass($classID);
            $data["objectClass"] = $object_class;
            $data["objects"] = $this->object_manager->getAllObjectsInClass($classID);

            $this->load->view("user/object_details_view", $data);
        }
    }

    /**
     * @Decorated
     * @Secured(role = "user")
     */
    public function do_form($classID, $ObjectID, $FormID) {
        $this->load->model("object_manager");
        $this->load->model("object_html_cache_manager");
        $this->load->model("forms_manager");

        $data = array();
        $data["objectID"] = $ObjectID;
        $data["classID"] = $classID;
        $data["object"] = $this->object_manager->getObjectInstanceInForm($ObjectID, $FormID);
        $data["form"] = $this->forms_manager->find_by_id($FormID);
        $data["cache"] = $this->object_html_cache_manager->get_saved_cache_html(Form::$HTML_DOM_ID_PREFIX, $FormID);
        $this->load->view("user/object_do_form_view", $data);
    }

    /**
     * @AjaxAction
     * @Secured(role = "user")
     */
    public function ajax_edit_form($classID, $ObjectID, $FormID) {
        $this->do_form($classID, $ObjectID, $FormID);
    }

    /**
     * @Secured(role = "user")
     */
    public function save($ObjectClassID, $ObjectID = -1) {
        $this->load->model("object_manager");
        $this->load->model("field_manager");
        if ($ObjectClassID > 0) {
            $obj = new Object();
            $obj->setObjectClassID($ObjectClassID);
            $obj->setObjectID($ObjectID);
            $obj->setFieldValues(json_decode($this->input->post("FieldValues")));

            $id = $this->object_manager->save($obj);
            if ($id > 0) {
                $data = array();
                $data["info_message"] = "Đã lưu dữ liệu/ Saved!";
                $data["redirect_url"] = site_url("user/public_object_controller/list_all/" . $ObjectClassID) . "#" . $id;
                $this->load->view("global_view/simple_message_info", $data);
            } else {
                echo "Insert new object failed!";
            }
        }
    }

    /**
     * @Decorated
     * @Secured(role = "user")
     */
    public function list_all($ObjectClassID) {
        $this->load->model("object_manager");
        $this->load->model("objectclass_manager");

        $objectClass = $this->objectclass_manager->find_by_id($ObjectClassID);

        if ($objectClass != NULL) {
            $data = array();
            $data["objectClass"] = $objectClass;
            $data["objects"] = $this->object_manager->getAllObjectsInClass($objectClass->getObjectClassID());
            $this->load->view("user/all_objects_in_class_list_view", $data);
        } else {
            throw new RuntimeException("ObjectClass not found for ID: $ObjectClassID", 500);
        }
    }

    /**
     * @Decorated
     * @Secured(role = "user")
     */
    public function list_objects($AccessDataURI = '/', $startIndex = 0, $total_rs = 0) {
        $this->load->model("object_manager");
        $this->load->model("objectclass_manager");

        $objectClass = $this->objectclass_manager->find_by_uri($AccessDataURI);

        if ($objectClass != NULL) {
            $data = array();
            $data["objectClass"] = $objectClass;
            $data["objects"] = $this->object_manager->getAllObjectsInClass($objectClass->getObjectClassID(), $startIndex, $total_rs);

            $config = array();
            $config['base_url'] = "";
            $config['total_rows'] = 100;
            $config['per_page'] = 1;
            $config['current_page'] = 1;
            $data["pagination_config"] = $config;
        } else {
            throw new RuntimeException("ObjectClass not found for ID: $ObjectClassID", 500);
        }

        $this->load->view("user/all_objects_in_class_list_view", $data);
    }

    /**
     * @Decorated
     * @Secured(role = "user")
     */
    public function list_matched_objects_of($AccessDataURI = '/') {
        $this->load->model("object_manager");
        $this->load->model("objectclass_manager");

        $objectClass = $this->objectclass_manager->find_by_uri($AccessDataURI);

        if ($objectClass != NULL) {
            $data = array();
            $data["objectClass"] = $objectClass;
            $data["objects"] = $this->object_manager->getAllObjectsInClass($objectClass->getObjectClassID(), $startIndex, $total_rs);

            $config = array();
            $config['base_url'] = "";
            $config['total_rows'] = 100;
            $config['per_page'] = 1;
            $config['current_page'] = 1;
            $data["pagination_config"] = $config;
        } else {
            throw new RuntimeException("ObjectClass not found for ID: $ObjectClassID", 500);
        }
        $this->load->view("user/all_objects_in_class_list_view", $data);
    }

    /**
     * @Decorated
     * @Secured(role = "user")
     *
     * @param Long $ObjectClassID
     * @param Long $filterByObjectId
     */
    public function moveObjectValuesToCloudDB($classID, $objId) {
        $this->load->model("cloud_storage_manager");
        $this->load->model("object_manager");

        $objData = $this->object_manager->get_raw_data_objects($classID, $objId);
        $json_text = json_encode($objData);

        $bloggerService = $this->getBloggerService();
        $categories = array("object_class_" . $classID);
        $docId = $bloggerService->createPost($objId, $json_text, TRUE, $categories);

        $obj = new Object();
        $obj->setObjectClassID($classID);
        $obj->setObjectID($objId);
        $obj->setObjectRefKey($docId);

        $id = $this->object_manager->save($obj);
        if ($id == $objId) {
            $this->output->set_output("Moved successfully with documentId: " . $docId);
        } else {
            $this->output->set_output("0");
        }
    }

    /**
     * @Decorated
     * @Secured(role = "user")
     *
     * @param Long $ObjectClassID
     * @param Long $filterByObjectId
     */
    public function viewObjectFromCloudDB($objId) {
        $this->page_decorator->setPageTitle("View data");
        $this->load->model("cloud_storage_manager");
        $this->load->model("object_manager");

        $bloggerService = $this->getBloggerService();
        //  $query = new Zend_Gdata_Query('http://www.blogger.com/feeds/1672527029385884909/posts/default?q="content"');

        $row = $this->object_manager->getDocIdAndClassIdOfObject($objId);

        $data = array();
        if ($row != NULL) {
            $docId = $row->ObjectRefKey;
            $classId = $row->ObjectClassID;

            $thePost = $bloggerService->getThePost($docId);
           // $jsonObjValues = json_decode($thePost->content->text);
          //  $justLog = $thePost->title->text . '<BR>' . print_r($jsonObjValues, TRUE);
          //  $this->output->set_output($jsonObjValues);
            $data["jsonObjValues"] = $thePost->content->text;

            $this->load->model("objectclass_manager");
            $this->load->model("process_manager");
            
            $object_class = $this->objectclass_manager->find_by_id($classId);
            $data["object_class"] = $object_class;
            $data["objectHTMLCaches"] = array();
            foreach ($object_class->getUsableProcesses() as $pro) {
                $data["objectHTMLCaches"][$pro->getProcessID()] = $this->process_manager->getProcessHTMLCaches($pro->getProcessID());
            }
            $this->load->view("user/object_view", $data);
        } else {
            $this->output->set_output("Not found!");
        }
    }

}