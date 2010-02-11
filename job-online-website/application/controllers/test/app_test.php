<?php
require_once "application/classes/Process.php";

/**
 *  Local testing the application
 * @author Trieu Nguyen
 *
 * @property process_manager $process_manager
 * @property class_mapper $class_mapper
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property CI_DB_active_record $db
 */
class app_test extends Controller {
    public function __construct() {
        parent::Controller();
    }


    /** @Secured(role = "admin", level = 2) */
    public function listDRDStaff() {
        if($this->redux_auth->logged_in() == TRUE) {
            echo "loged";
        }
        else {
            echo "Not loged";
        }
    }

    /** @Secured */
    public function test() {
        echo "test";
    }




    /** @Decorated */
    public function test_decorator() {
        $this->page_decorator->setPageMetaTag("description", "Home page");
        $this->page_decorator->setPageMetaTag("keywords", "Home page");
        $this->page_decorator->setPageMetaTag("author", "Trieu Nguyen");
        $this->page_decorator->setPageTitle("test_decorator");

        $data = array("test2" => false);

        $this->load->view("decorator/body",$data);
    }

    /**
     * @Secured
     * @Decorated
     */
    public function test_decorator2() {
        $this->page_decorator->setPageMetaTag("description", "Home page");
        $this->page_decorator->setPageMetaTag("keywords", "Home page");
        $this->page_decorator->setPageMetaTag("author", "Trieu Nguyen");
        $this->page_decorator->setPageTitle("test_decorator2");

        $data = array("test2" => true);

        $this->load->view("decorator/body",$data);
    }

    /** @Decorated */
    public function test_form() {
        $this->load->model("process_manager");
        $data = $this->process_manager->get_dependency_instances();
        $this->load->view("form/form_view",$data);
    }

    /** @Decorated */
    public function test_save_form() {
        $pro = new Process();
        $pro->setProcessID($this->input->post("ProcessID"));
        $pro->setGroupID($this->input->post("GroupID"));
        $pro->setProcessName($this->input->post("ProcessName"));

        $this->load->model("process_manager");
        $this->process_manager->save($pro);
        //echo "OK";
    }

    public function test_data_manager($id = "all") {
        app_test::BEGIN_TEST();

        $this->load->library("class_mapper");

        $this->load->model("process_manager");
        $filter = array();
        if(is_numeric($id)) {
            $filter = array("ProcessID"=>$id);
        }
        $processses = $this->process_manager->find_by_filter($filter);
        $data_table = $this->class_mapper->DataListToDataTable("Process",$processses);


        //echo $pro->getProcessName()." == ";
        $this->load->library('table');
        $tmpl = array (
            'table_open'          => '<table border="1" cellpadding="4" cellspacing="0">',

            'heading_row_start'   => '<tr>',
            'heading_row_end'     => '</tr>',
            'heading_cell_start'  => '<th>',
            'heading_cell_end'    => '</th>',

            'row_start'           => '<tr>',
            'row_end'             => '</tr>',
            'cell_start'          => '<td>',
            'cell_end'            => '</td>',

            'row_alt_start'       => '<tr>',
            'row_alt_end'         => '</tr>',
            'cell_alt_start'      => '<td>',
            'cell_alt_end'        => '</td>',

            'table_close'         => '</table>'
        );

        $this->table->set_template($tmpl);
        $this->table->set_heading(array('ProcessID', 'GroupID', 'ProcessName'));
        echo $this->table->generate($data_table);

        app_test::END_TEST();
    }


    public function test_mapper() {
        app_test::BEGIN_TEST();

        $query = $this->db->get("Processes");
        $list = array();
        $i = 0;

        $this->load->library("class_mapper",array("Process"));
        $this->class_mapper->parseClass("Process");
        foreach ($query->result_array() as $data_row) {
            $process = new Process();
            $this->class_mapper->dataRowMappingToObject($data_row, $process);
            $list[$i++] = $process;
        }
        foreach ($list as $p) {
            echo $p->getProcessName()." ";
        }

        app_test::END_TEST();
    }

    private static $start = 0;
    public static function BEGIN_TEST() {
        app_test::$start = microtime(true);
    }
    public static function END_TEST() {
        $elapsed = microtime(true) - app_test::$start;
        echo "<br><b>That took $elapsed seconds.</b><br>";
    }
}




?>
