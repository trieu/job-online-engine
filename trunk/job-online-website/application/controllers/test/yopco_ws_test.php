<?php

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
class yopco_ws_test extends Controller {
    public function __construct() {
        parent::Controller();
    }

    /** @Decorated */
    public function login() {
        $this->page_decorator->setPageMetaTag("description", "Home page");
        $this->page_decorator->setPageMetaTag("keywords", "Home page");
        $this->page_decorator->setPageMetaTag("author", "Trieu Nguyen");
        $this->page_decorator->setPageTitle("test_decorator");

        $data = array("test2" => false);

        $this->load->view("test/form_login",$data);
    }   

   
}




?>
