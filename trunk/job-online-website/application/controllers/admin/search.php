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
        $this->page_decorator->setPageTitle("Search and Statistics Form");
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
        if ($what == self::$OBJECT_CLASS_HINT) {
            $this->db->select("objectclass.*");
            $this->db->from("objectclass");
            $query = $this->db->get();
            foreach ($query->result() as $row) {
                $option = new stdClass();
                $option->options_val = $row->ObjectClassID;
                $option->options_label = $row->ObjectClassName;
                array_push($options, $option);
            }
        } else if ($what == self::$PROCESS_HINT) {
            $this->db->select("processes.*");
            $this->db->from("processes");
            $this->db->join("class_using_process", "processes.ProcessID = class_using_process.ProcessID");
            $this->db->where("class_using_process.ObjectClassID", $filterID);
            $this->db->order_by("ProcessOrder");
            $query = $this->db->get();
            foreach ($query->result() as $row) {
                $option = new stdClass();
                $option->options_val = $row->ProcessID;
                $option->options_label = $row->ProcessName;
                array_push($options, $option);
            }
        } else if ($what == self::$FORM_HINT) {
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
        } else if ($what == self::$FIELD_HINT) {
            if ($returnAsHTML == "true") {
                $this->load->model("field_manager");
                $data = array();
                $data["fields"] = $this->field_manager->getFieldsInForm($filterID);
                echo $this->load->view("admin/searched_fields_hint", $data, TRUE);
                return;
            } else {
                $this->load->model("field_manager");
                $fields = $this->field_manager->getFieldsInForm($filterID);
                foreach ($fields as $field) {
                    $option = new stdClass();
                    $option->options_val = $field->getFieldID();
                    $option->options_label = $field->getFieldName();
                    array_push($options, $option);
                }
            }
        } else if ($what == self::$FIELD_OPTION_HINT) {
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

        $data = array("options" => $options);
        echo json_encode($data);
        return;
    }

    /**
     * @Secured(role = "Administrator")
     */
    function do_search() {
        $this->load->model("search_manager");

        $FormID = $this->input->post("FormID");
        $ObjectClassID = $this->input->post("ObjectClassID");
        $ProcessID = $this->input->post("ProcessID");
        $query_fields = json_decode($this->input->post("query_fields"));
        $csv_export = $this->input->post("csv_export");

        try {
            $data = $this->search_manager->search_object_for_table_view($ObjectClassID, $query_fields);
            if ($csv_export == "false") {
                // echo $this->load->view("admin/all_objects_in_class_list_view",$data, TRUE);
                echo $this->load->view("admin/all_objects_in_class", $data, TRUE);
            } else {
                $strData = $this->load->view("admin/all_objects_in_class_csv_export", $data, TRUE);
                $theFile = "search_results.csv";
                $fh = fopen($theFile, 'w') or die("can't open file");
                fwrite($fh, $strData);
                fclose($fh);
                echo str_replace("index.php/", "", site_url($theFile));
            }
        } catch (Exception $e) {
            echo $e->getTraceAsString();
        }
    }

    /**
     * @Secured(role = "Administrator")
     */
    public function do_statistics($js_mode = TRUE) {
        $this->load->model("search_manager");

        $FormID = $this->input->post("FormID");
        $ObjectClassID = $this->input->post("ObjectClassID");
        $ProcessID = $this->input->post("ProcessID");
        $query_fields = json_decode($this->input->post("query_fields"));

        $data = $this->search_manager->do_statistics_on_field($ObjectClassID, $query_fields);

        // $this->load->library("ci_pchart");
        // $this->ci_pchart->drawPieChart();

        echo json_encode($data);
    }

    private function tripForSafeName ($str) {
        $str = str_replace("\n", " ", $str);
        $str = str_replace("'", "", $str);
        $str = str_replace("\"", "", $str);
        $str = str_replace("\\", "", $str);        
        return $str;
    }

    /**
     * @Secured(role = "Administrator")
     */
    public function save_query_details() {
        $id = (int) $this->input->post("id");
        $query_name = $this->input->post("query_name");
        $query_details = $this->input->post("query_details");
        $editable_field_name = $this->input->post("editable_field_name");
        $editable_field_value = $this->input->post("editable_field_value");
        $isAddNew = ($id == 0 && $editable_field_name == FALSE );
        $isUpdate = ($id > 0 || $editable_field_name != FALSE );

        $data = array();
        if( $query_name != FALSE){
            $data['query_name'] = $this->tripForSafeName($query_name);
        }
        if( $query_details != FALSE){
            $data['query_details'] = $query_details;
        }
        if ($isAddNew) {           
            $this->db->insert('query_filters', $data);
        } else if($isUpdate > 0) {
            if( $editable_field_name != FALSE) {
                $editable_field_name = str_replace("query_filters-","", $editable_field_name);
                $editable_field_name = str_replace("-query_name", "", $editable_field_name);                 
                $id = (int)$editable_field_name;
                $data['query_name'] = $this->tripForSafeName($editable_field_value);
            }            
            $this->db->where('id', $id);
            $this->db->update('query_filters', $data);
        }
        ApplicationHook::logInfo($this->db->last_query());
        if ($this->db->affected_rows() > 0) {
            if( $editable_field_name != FALSE) {
                echo $data['query_name'];
            }
            else {
                echo $this->db->insert_id();
            }
        } else {
            echo -1;
        }
    }

    /**
     * @Decorated
     * @Secured(role = "Administrator")
     */
    public function delete_query_details($id) {
        $this->page_decorator->setPageTitle("Delete query details, id= ".$id);
        $this->db->delete('query_filters', array('id' => $id));
        $data = array();
        if ($this->db->affected_rows() > 0) {
            $data["info_message"] = "Deleted query successfully!";
        } else {
            $data["info_message"] = "Delete query failed!";
        }
        $data["reload_page"] = TRUE;
        $data["redirect_url"] = site_url("admin/search/list_all_query_details");
        $this->load->view("global_view/info_and_redirect", $data);
    }

    /**
     * @Decorated
     * @Secured(role = "Administrator")
     */
    public function load_from_query_details($id = -1) {
        $query = $this->db->get_where('query_filters', array('id' => $id));
        $data = array();
        foreach ($query->result() as $row) {
            // echo $row->query_name;
            // echo $row->query_details;
            $data["the_query_details"] = $row;
            $this->page_decorator->setPageTitle($row->query_name);
        }
        $this->load->view("admin/search_query_view", $data);
    }

    /**
     * @Decorated
     * @Secured(role = "Administrator")
     */
    public function list_all_query_details() {
        $this->page_decorator->setPageTitle("List all saved queries");
        $this->db->select('id, query_name');
        $query = $this->db->get('query_filters');

        $actions_tpl = '<div class="actions" >';
        $actions_tpl .= anchor('admin/search/load_from_query_details/[id]', 'Load', array('title' => 'Load'));
        $actions_tpl .= " | ";
        $actions_tpl .= anchor('admin/search/delete_query_details/[id]', 'Delete', array('title' => 'Delete'));
        $actions_tpl .= "</div>";

        $data_table = array();
        foreach ($query->result_array() as $row_data) {
            $pattern_p = '[id]';
            $pos = strpos($actions_tpl, $pattern_p);
            if ($pos > 0) {
                $actions = str_replace($pattern_p, $row_data['id'], $actions_tpl);
                $row_data['Actions'] = $actions;
                array_push($data_table, $row_data);
            }
        }

        $this->load->library('table');
        $data["table_name"] = "query_filters";
        $data["data_table"] = $data_table;
        $data["data_table_heading"] = array('id', 'query_name', 'Actions');
        $data["data_editable_fields"] = array('query_name' => TRUE);
        $data["edit_in_place_uri"] = "admin/search/save_query_details";

        $data["Actions"] = $actions;

        $this->load->view("global_view/data_grid", $data);
    }

}
