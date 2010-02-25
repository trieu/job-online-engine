<?php

/**
 * Description of home
 *
 * @property page_decorator $page_decorator
 * @property gdata_spreadsheet $gdata_spreadsheet
 *
 * @author Trieu Nguyen. Email: tantrieuf31@gmail.com
 */
class myAccountingBook extends Controller {
    public function __construct() {
        parent::Controller();
    }

    /**
     * @DecoratedForMobile
     */
    public function index() {
        $data = array();
        $this->page_decorator->setPageTitle("Job Management System at DRD");
        $this->load->view("myAccountingBook/main_view",$data);
    }

}
?>
