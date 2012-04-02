<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Welcome extends CI_Controller {

    /**
     * @Decorated
     */
    public function index() {
        //$this->load->view('welcome_message');
        $this->page_decorator->setPageMetaTag("description", "i2tree framework");
        $this->page_decorator->setPageMetaTag("keywords", "i2tree, web framework, information framework");
        $this->page_decorator->setPageMetaTag("author", "Trieu Nguyen");
        $this->page_decorator->setPageTitle("i2tree framework");

        $data = array();
        $this->load->view("welcome_message", $data);
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