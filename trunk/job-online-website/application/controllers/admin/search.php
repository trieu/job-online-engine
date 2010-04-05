<?php

/**
 * Search information
 *
 * @property page_decorator $page_decorator
 * @property class_mapper $class_mapper
 * @property CI_Loader $load
 * @property CI_DB_active_record $db
 * @property CI_Input $input
 * @property search_manager $search_manager
 * @property ci_pchart $ci_pchart
 *
 * @author Trieu Nguyen. Email: tantrieuf31@gmail.com
 */
class search extends Controller {

    public static $OBJECT_CLASS_HINT = "object_class";
    public static $PROCESS_HINT = "process";
    public static $FORM_HINT = "form";
    public static $FIELD_HINT = "field";
    public static $FIELD_OPTION_HINT = "field_option";

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
        //$this->load->view("global_view/search_query_view", $data);
        $this->load->view("admin/search_query_view", $data);
    }

    /**
     * @Secured(role = "Administrator")
     *
     * FIXME more security here
     */
    function populate_query_helper($returnAsHTML = "true") {
        $filterID = (int) $this->input->post("filterID");
        $what = $this->input->post("what");

        $options = array();
        if($what == self::$OBJECT_CLASS_HINT) {
            $this->db->select("objectclass.*");
            $this->db->from("objectclass");
            $query = $this->db->get();
            foreach ($query->result() as $row) {
                $option = new stdClass();
                $option->options_val = $row->ObjectClassID;
                $option->options_label = $row->ObjectClassName;
                array_push($options, $option);
            }
        }
        else if($what == self::$PROCESS_HINT) {
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
            if($returnAsHTML == "true") {
                $this->load->model("field_manager");
                $data = array();
                $data["fields"] = $this->field_manager->getFieldsInForm($filterID);
                echo $this->load->view("admin/searched_fields_hint",$data, TRUE);
                return;
            }
            else {
                $this->load->model("field_manager");
                $fields = $this->field_manager->getFieldsInForm($filterID);
                foreach ($fields as $field ) {
                    $option = new stdClass();
                    $option->options_val = $field->getFieldID();
                    $option->options_label = $field->getFieldName();
                    array_push($options, $option);
                }
            }
        }
        else if($what == self::$FIELD_OPTION_HINT) {
            $this->db->select("fieldoptions.FieldOptionID, fieldoptions.OptionName");
            $this->db->from("fieldoptions");
            $this->db->where("fieldoptions.FieldID", $filterID);
            $query = $this->db->get();
            foreach ($query->result() as $row) {
                $option = new stdClass();
                $option->options_val = $row->FieldOptionID;
                $option->options_label = $row->OptionName;
                array_push($options, $option);
            }
            ApplicationHook::logInfo($this->db->last_query());
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
        $this->load->model("search_manager");
        
        $FormID = $this->input->post("FormID");
        $ObjectClassID = $this->input->post("ObjectClassID");
        $ProcessID = $this->input->post("ProcessID");
        $query_fields = json_decode( $this->input->post("query_fields") );
        $csv_export =  $this->input->post("csv_export");

        try {
            $data = $this->search_manager->search_object_for_table_view($FormID, $ObjectClassID, $ProcessID, $query_fields);
            if($csv_export == "false") {
                // echo $this->load->view("admin/all_objects_in_class_list_view",$data, TRUE);
                echo $this->load->view("admin/all_objects_in_class",$data, TRUE);
            }
            else {
                $strData = $this->load->view("admin/all_objects_in_class_csv_export",$data, TRUE);
                $theFile = "search_results.csv";
                $fh = fopen($theFile, 'w') or die("can't open file");
                fwrite($fh, $strData  );
                fclose($fh);
                echo str_replace("index.php/","",site_url($theFile));
            }
        } catch (Exception $e) {
            echo $e->getTraceAsString();
        }
    }

    public function do_statistics($js_mode = TRUE) {
        $this->load->model("search_manager");
        
        $FormID = $this->input->post("FormID");
        $ObjectClassID = $this->input->post("ObjectClassID");
        $ProcessID = $this->input->post("ProcessID");
        $query_fields = json_decode( $this->input->post("query_fields") );

        $data = $this->search_manager->do_statistics_on_field($FormID, $ObjectClassID, $ProcessID, $query_fields);

       // $this->load->library("ci_pchart");
       // $this->ci_pchart->drawPieChart();

        echo json_encode($data);
    }
}
