<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Welcome extends CI_Controller {

    /**
     * @Decorated
     */
    public function index() {
        //$this->load->view('welcome_message');
        $this->page_decorator->setPageMetaTag("description", "Home page");
        $this->page_decorator->setPageMetaTag("keywords", "Home page");
        $this->page_decorator->setPageMetaTag("author", "Trieu Nguyen");
        $this->page_decorator->setPageTitle("Job Management System at DRD");

        $data = array();
        $this->load->view("decorator/themes/default/body", $data);
    }

    /**
     * @Decorated
     * @Secured(role = "Administrator")
     */
    public function test() {
        $this->load->view('welcome_message');
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */