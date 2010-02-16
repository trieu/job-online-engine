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
        //$this->load->view("global_view/search_query_view", $data);
        $this->load->view("admin/search_query_view", $data);
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
            $this->load->model("field_manager");
            $data = array();
            $data["fields"] = $this->field_manager->getFieldsInForm($filterID);
            echo $this->load->view("admin/searched_fields_hint",$data, TRUE);
            return;
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
    function do_search($csv_export = "false") {
        $this->load->model("search_manager");
        try {
            if($csv_export == "false") {
                $data = $this->search_manager->search_object();
                echo $this->load->view("admin/all_objects_in_class",$data, TRUE);
            }
            else {
                $data = $this->search_manager->search_object();
                $strData = $this->load->view("admin/all_objects_in_class_csv_export",$data, TRUE);

                //$query = $this->search_manager->search_object(TRUE);
                //$this->load->helper('csv');
                //$strData = query_to_csv($query, TRUE);
                
                $theFile = "search_results.csv";
                $fh = fopen($theFile, 'w') or die("can't open file");
                fwrite($fh, $strData  );
                fclose($fh);
            }
        } catch (Exception $e) {
            echo $e->getTraceAsString();
        }
    }
}