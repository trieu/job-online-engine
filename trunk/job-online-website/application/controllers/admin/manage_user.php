<?php

/**
 * Search information
 *
 * @property page_decorator $page_decorator
 * @property class_mapper $class_mapper
 * @property CI_Loader $load
 * @property CI_DB_active_record $db
 * @property CI_Input $input
 * @property redux_auth_model $redux_auth_model
 * @property ci_pchart $ci_pchart
 *
 * @author Trieu Nguyen. Email: tantrieuf31@gmail.com
 */
class manage_user extends Controller {

    public function __construct() {
        parent::Controller();       
    }

    /**
     * @Decorated
     * @Secured(role = "Administrator")
     */
    public function index() {
       $this->list_all_users();
    }


    /**
     * @Decorated
     * @Secured(role = "Administrator")
     */
    public function list_all_users() {
        $data = array();

        echo "TODO";
    }

     /**
     * @Decorated
     * @Secured(role = "Administrator")
     */
    public function add_new_user() {
        $data = array();

        echo "TODO";
    }

    /**
     * @Decorated
     * @Secured(role = "Administrator")
     */
    public function delete_user() {
        $data = array();

        echo "TODO";
    }

    /**
     * @Decorated
     * @Secured(role = "Administrator")
     */
    public function edit_user($password) {
        $data = array();
        $this->load->model("redux_auth_model");
        echo $this->redux_auth_model->hash_password($password);
        
    }

    
}
