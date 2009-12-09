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
                $data["objectCacheHTML"] = $this->process_manager->getIndentityProcessView($pro->getProcessID());
                break;
            }

            $this->load->view("admin/create_object",$data);
        }
    }

    /**
     * @Decorated
     * @Secured(role = "Administrator")
     */
    public function save($ObjectClassID ) {
        $this->load->model("object_manager");
        $this->load->model("field_manager");

        if($ObjectClassID > 0) {

            $posted_key_data = array_keys($_POST);
            $obj = new Object();
            $obj->setObjectClassID($ObjectClassID);

            $FieldValues = array();
            foreach ($posted_key_data as $key) {
                $FieldValue = $this->input->post($key);
                ApplicationHook::logInfo($key."->".$FieldValue." pos = ".strpos($key,Field::$HTML_DOM_ID_PREFIX));

                if( strpos($key,Field::$HTML_DOM_ID_PREFIX) ==0 ) {
                    $FieldID = (int)str_replace(Field::$HTML_DOM_ID_PREFIX, "", $key);
                    $record = array("FieldID"=>$FieldID, "FieldValue" => $FieldValue);
                    $obj->addFieldValue($record);
                    //$FieldValues[$FieldID] = $FieldValue;
                }
            }

            $ok = $this->object_manager->save($obj);
            $this->output->set_output("OK = ".$ok);
        }
    }

    /**
     * @Decorated
     * @Secured(role = "Administrator")
     */
    public function list_all($ObjectClassID ) {
        $this->load->model("object_manager");
        $data = array();
        $data["objects"] = $this->object_manager->getAllObjectsInClass($ObjectClassID);

        $this->load->view("admin/all_objects_in_class",$data);
    }
}
?>
