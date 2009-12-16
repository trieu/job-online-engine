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
    public function objectDoProcess($ObjectID, $ProcessID ) {
        $this->load->model("object_manager");
        $this->load->model("process_manager");
        ApplicationHook::logInfo($ProcessID."-".$ObjectID);

    }

    /**
     * @Decorated
     * @Secured(role = "Administrator")
     */
    public function objectDoForm($ObjectID, $FormID ) {
        $this->load->model("object_manager");
        $this->load->model("process_manager");
        ApplicationHook::logInfo($FormID."-".$ObjectID);

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
     * @Decorated
     * @Secured(role = "Administrator")
     */
    public function save($ObjectClassID , $ObjectID = -1 ) {
        $this->load->model("object_manager");
        $this->load->model("field_manager");

        if($ObjectClassID > 0) {

            $posted_key_data = array_keys($_POST);
            $obj = new Object();
            $obj->setObjectClassID($ObjectClassID);
            $obj->setObjectID($ObjectID);

            $FieldValues = array();
            foreach ($posted_key_data as $key) {
                $FieldValue = $this->input->post($key);
                ApplicationHook::logInfo($key."->".$FieldValue." pos = ".strpos($key,Field::$HTML_DOM_ID_PREFIX));

                if( strpos($key,Field::$HTML_DOM_ID_PREFIX) ==0 ) {
                    $tokens = explode("FVID_", $key);
                    if( count($tokens)==2 ) {
                        $FieldID = (int)str_replace(Field::$HTML_DOM_ID_PREFIX, "", $tokens[0]);
                        $FieldValueID = (int)$tokens[1];
                        $record = array("FieldValueID" => $FieldValueID ,"FieldID"=>$FieldID, "FieldValue" => $FieldValue);
                        $obj->addFieldValue($record);
                    }
                    //$FieldValues[$FieldID] = $FieldValue;
                }
            }

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

        $this->load->view("admin/all_objects_in_class",$data);
    }
}
?>
