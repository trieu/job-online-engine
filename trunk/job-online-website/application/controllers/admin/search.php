<?php


/**
 * Search information
 *
 * @property page_decorator $page_decorator
 * @property class_mapper $class_mapper
 * @property CI_Loader $load
 * @property CI_DB_active_record $db
 * @property CI_Input $input
 *
 * @author Trieu Nguyen. Email: tantrieuf31@gmail.com
 */
class search extends Controller {

    public static $PROCESS_HINT = "process";
    public static $FORM_HINT = "form";
    public static $FIELD_HINT = "field";

    public function __construct() {
        parent::Controller();
        $this->load->helper("field_type");
    }

    /**
     * @Decorated
     * @Secured(role = "Administrator")
     */
    public function index() {
        $data = array();
        $this->load->view("global_view/search_query_view", $data);
    }

    /**
     * @Secured(role = "Administrator")
     *
     * FIXME more security here
     */
    function populate_query_helper() {
        $filterID = (int) $this->input->post("filterID");
        $what = $this->input->post("what");
        ApplicationHook::logInfo($what);
        ApplicationHook::logInfo($filterID);

        $options = array();

        if($what == self::$PROCESS_HINT) {
            $this->db->select("processes.*");
            $this->db->from("processes");
            $this->db->join("class_using_process", "processes.ProcessID = class_using_process.ProcessID");
            $this->db->where("class_using_process.ObjectClassID", $filterID);
            $query = $this->db->get();
            foreach ($query->result() as $row) {
                $option = new stdClass();
                $option->options_val = $row->ProcessID;
                $option->options_label = $row->ProcessName;
                array_push($options, $option);
            }
        }
        else if($what == self::$FORM_HINT) {
            $this->db->select("forms.*");
            $this->db->from("forms");
            $this->db->join("form_process", "forms.FormID = form_process.FormID");
            $this->db->where("form_process.ProcessID", $filterID);
            $query = $this->db->get();
            foreach ($query->result() as $row) {
                $option = new stdClass();
                $option->options_val = $row->FormID;
                $option->options_label = $row->FormName;
                array_push($options, $option);
            }
        }
        else if($what == self::$FIELD_HINT) {
//            $this->db->select("fields.*");
//            $this->db->from("fields");
//            $this->db->join("field_form", "fields.FieldID = field_form.FieldID");
//            $this->db->where("field_form.FormID", $filterID);
            $this->load->model("object_html_cache_manager");
            $this->load->model("forms_manager");
            $cache = $this->object_html_cache_manager->get_saved_cache_html(Form::$HTML_DOM_ID_PREFIX, $filterID);
            if($cache) {
                echo html_entity_decode($cache->getCacheContent());
                return;
            }
            else {
                echo "No fields available!";
            }
        }

        $data = array("options"=>$options);
        echo json_encode($data);
        return;
    }


    /**
     * @Secured(role = "Administrator")
     *
     * FIXME more security here
     */
    function do_search() {
        $classID = 1;
        $this->load->model("objectclass_manager");

        $sql = "(
                SELECT objects.ObjectID, fields.FieldName, fieldoptions.OptionName as FieldValue
                FROM objects
                INNER JOIN fieldvalues ON fieldvalues.ObjectID = objects.ObjectID
                INNER JOIN fields ON (fields.FieldID = fieldvalues.FieldID
                    AND fields.FieldTypeID >= 4
                    AND fields.FieldTypeID <= 7
                    AND fields.FieldID IN ( SELECT field_form.FieldID
                             FROM field_form, form_process, class_using_process
                             WHERE field_form.FormID = form_process.FormID AND form_process.ProcessID = class_using_process.ProcessID
                                   AND class_using_process.ProcessOrder = 0 AND class_using_process.ObjectClassID = ?
                                )
                )
                INNER JOIN fieldoptions ON fieldoptions.FieldOptionID = fieldvalues.FieldValue
                WHERE objects.ObjectClassID = ?
                )
                UNION
                (
                SELECT objects.ObjectID, fields.FieldName,  fieldvalues.FieldValue as FieldValue
                FROM objects
                INNER JOIN fieldvalues ON fieldvalues.ObjectID = objects.ObjectID
                INNER JOIN fields ON (fields.FieldID = fieldvalues.FieldID
                    AND fields.FieldTypeID >= 1
                    AND fields.FieldTypeID <= 3
                    AND fields.FieldID IN ( SELECT field_form.FieldID
                             FROM field_form, form_process, class_using_process
                             WHERE field_form.FormID = form_process.FormID AND form_process.ProcessID = class_using_process.ProcessID
                                   AND class_using_process.ProcessOrder = 0 AND class_using_process.ObjectClassID = ?
                                )
                )
                WHERE objects.ObjectClassID = ?
                )
                ";
        $query = $this->db->query($sql, array($classID, $classID, $classID, $classID));
        $record_set = $query->result_array();
        $objects = array();
        foreach ($record_set as $record) {
            if( ! isset ($objects[$record['ObjectID']]) ) {
                $objects[ $record['ObjectID'] ] = array();
            }
            $field = array("FieldName"=> $record['FieldName']  , "FieldValue" => $record['FieldValue'] );
            array_push( $objects[ $record['ObjectID'] ], $field );
        }
        ;


        $data = array();
        $data["in_search_mode"] = TRUE;
        $data["objects"] = $objects;
        $data["objectClass"] = $this->objectclass_manager->find_by_id($classID);

        echo $this->load->view("admin/all_objects_in_class",$data, TRUE);
    }
}
?>
