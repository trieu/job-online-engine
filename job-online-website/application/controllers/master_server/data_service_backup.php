<?php

/**
 * 
 *
 * @property page_decorator $page_decorator
 *
 * @author Trieu Nguyen. Email: tantrieuf31@gmail.com
 */
class data_service_backup extends Controller {
    public function __construct() {
        parent::Controller();
       
    }


    public function index() {
        $arr = array();
        $arr["name"] = "master server triều";
        $arr["date"] = "111";
        $arr["class"] = "java.util.HashMap";
        echo json_encode($arr);
    }


}
?>
