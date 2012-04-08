<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MobileWeb extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    /**
     * @Decorated(themeName = "appstore")
     */
    public function appstore() {
        //$this->load->view('welcome_message');
        $this->page_decorator->setPageMetaTag("description", "i2tree framework");
        $this->page_decorator->setPageTitle("Mobile App");

        $this->output->set_output("I'm appstore");
    }

    /**
     * @DecoratedForMobile
     */
    public function index() {
        //$this->load->view('welcome_message');
        $this->page_decorator->setPageMetaTag("description", "i2tree framework");
        $this->page_decorator->setPageTitle("f");

        $this->output->set_output("I'm mobile web");
    }

}