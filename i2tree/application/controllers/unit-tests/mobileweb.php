<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MobileWeb extends CI_Controller {

    /**
     * @DecoratedForMobile
     */
    public function index() {
        //$this->load->view('welcome_message');
        $this->page_decorator->setPageMetaTag("description", "i2tree framework");
        $this->page_decorator->setPageMetaTag("keywords", "i2tree, web framework, information framework");
        $this->page_decorator->setPageMetaTag("author", "Trieu Nguyen");
        $this->page_decorator->setPageTitle("i2tree framework");

        $this->output->set_output("I'm mobile web");
    }

}