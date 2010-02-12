<?php

/**
 * Description of home
 *
 * @property page_decorator $page_decorator
 * @property gdata_spreadsheet $gdata_spreadsheet
 *
 * @author Trieu Nguyen. Email: tantrieuf31@gmail.com
 */
class gdata extends Controller {
    public function __construct() {
        parent::Controller();
    }

    /**
     * @Decorated
     */
    public function index() {
        $this->load->library('gdata_spreadsheet');
        $data = array();
        $this->page_decorator->setPageTitle("Job Management System at DRD");

        $email = "tantrieuf31.database@gmail.com";
        $pass = "Mycatisfat@31";
        $spreadsheetId = "tPF0KO8zz8gIB75IZB6fMcQ";
        $worksheetId = "od6";
        $this->gdata_spreadsheet->connect($email, $pass, $spreadsheetId, $worksheetId);
        $this->gdata_spreadsheet->countRowAndCollumn();
        $data["getRowCount1"] =  $this->gdata_spreadsheet->getRowCount();
        $data["getColumnCount1"] =  $this->gdata_spreadsheet->getColumnCount();

        $rowArray = array();
        $rowArray["id"] = 55;
        $rowArray["name"] = "Trieu 2.55";
        $data["insertRowIntoWorkSheet"] = $this->gdata_spreadsheet->insertRowIntoWorkSheet($rowArray);

        $this->gdata_spreadsheet->countRowAndCollumn();
        $data["getRowCount2"] =  $this->gdata_spreadsheet->getRowCount();
        $data["getColumnCount2"] =  $this->gdata_spreadsheet->getColumnCount();


        $this->load->view("mashup/spreadsheet_view",$data);
    }

}
?>
