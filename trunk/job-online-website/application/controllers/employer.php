<?php

/**
 * 
 *
 * @property page_decorator $page_decorator
 *
 * @author Trieu Nguyen. Email: tantrieuf31@gmail.com
 */
class employer extends Controller {
    public function __construct() {
        parent::Controller();
        $this->load->scaffolding('groups');
    }

    /**
     * @Decorated
     */
    public function index() {
        $this->page_decorator->setPageMetaTag("description", "Home page");
        $this->page_decorator->setPageMetaTag("keywords", "Home page");
        $this->page_decorator->setPageMetaTag("author", "Trieu Nguyen");
        $this->page_decorator->setPageTitle("Job Management System at DRD");

        $this->load->helper('random_password');
        $ran_pass = get_random_password(10, 12, TRUE, TRUE, FALSE);
        ApplicationHook::logInfo($ran_pass);

        $data = array();
        $this->load->view("decorator/body",$data);
    }

    /**
     * @Decorated
     */
    public function number_question($num) {
        $data = array();
        $this->load->view("employer/question_".$num,$data);
    }

}
?>
