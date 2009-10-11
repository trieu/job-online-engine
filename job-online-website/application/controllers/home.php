<?php

/**
 * Description of home
 *
 * @property page_decorator $page_decorator
 *
 * @author Trieu Nguyen. Email: tantrieuf31@gmail.com
 */
class home extends Controller {
    public function __construct() {
        parent::Controller();        
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
        //ApplicationHook::logInfo($ran_pass);

        $this->load->database();

        $this->db->cache_on();
        $query = $this->db->query("SELECT COUNT(id) as number FROM users");
        $this->db->cache_off();

        foreach ($query->result() as $row) {
            ApplicationHook::logInfo($row->number);
        }
        
        $data = array();
        $this->load->view("decorator/body",$data);
        
    }

    public function clear_all_caches(){
        $this->db->cache_delete_all();
    }
}
?>
