<?php

/**
 * public controler for non-admin
 *
 * @property page_decorator $page_decorator
 * @property CI_Loader $load
 *
 * @author Trieu Nguyen. Email: tantrieuf31@gmail.com
 */
class user_guide_controller extends Controller {
    public function __construct() {
        parent::__construct();
    }

    /**
     * @Decorated
     * @Secured(role = "user")
     */
    public function index() {
         $this->load->view("user/user_guide_view",NULL);
    }
   
}
?>
