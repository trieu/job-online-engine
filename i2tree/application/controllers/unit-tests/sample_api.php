<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class sample_api extends CI_Controller {

    /**
     * @Decorated
     */
    public function index() {
        //$this->load->view('welcome_message');      
        $this->page_decorator->setPageTitle("i2tree: sample api test");

        $output = 'sample api test';
        $this->output->set_output($output);
    }

    /**
     * @Api
     */
    public function persons() {
        $users = array(
            3 => array('id' => 3, 'name' => 'Scotty', 'email' => 'example3@example.com', 'fact' => 'Is a Scott!', array('hobbies' => array('fartings', 'bikes'))),
            4 => array('id' => 4, 'name' => 'Nguyễn Tấn Triều', 'email' => 'tantrieuf31@gmail.com', 'fact' => 'a software engineer')
        );
        $output = json_encode($users);
        $this->output->set_output($output);
    }

    /**
     * @Api(secured = TRUE)    
     */
    public function important_persons() {
        $users = array(
            1 => array('id' => 1, 'name' => 'Some Guy', 'email' => 'example1@example.com', 'fact' => 'Loves swimming'),
            2 => array('id' => 2, 'name' => 'Person Face', 'email' => 'example2@example.com', 'fact' => 'Has a huge face'),
            3 => array('id' => 3, 'name' => 'Scotty', 'email' => 'example3@example.com', 'fact' => 'Is a Scott!', array('hobbies' => array('fartings', 'bikes'))),
            4 => array('id' => 4, 'name' => 'Nguyễn Tấn Triều', 'email' => 'tantrieuf31@gmail.com', 'fact' => 'a software engineer')
        );
        $output = json_encode($users);
        $this->output->set_output($output);
    }

}
