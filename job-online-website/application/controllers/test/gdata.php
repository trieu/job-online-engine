<?php

/**
 * Description of home
 *
 * @property page_decorator $page_decorator
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
        $this->page_decorator->setPageTitle("Job Management System at DRD");



        $data = array();
        $this->load->view("mashup/spreadsheet_view",$data);
    }

}
?>
