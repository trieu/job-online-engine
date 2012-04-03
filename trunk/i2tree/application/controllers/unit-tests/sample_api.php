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

    private $sample_users = array(
        3 => array('id' => 3, 'name' => 'Scotty', 'email' => 'example3@example.com', 'fact' => 'Is a Scott!', array('hobbies' => array('fartings', 'bikes'))),
        4 => array('id' => 4, 'name' => 'Nguyễn Tấn Triều', 'email' => 'tantrieuf31@gmail.com', 'fact' => 'a software engineer')
    );
    
    
    //1: http://localhost/i2tree/index.php/oauth/index?client_id=hello-i2tree&redirect_uri=http://localhost/i2tree/index.php/unit-tests/&response_type=code&client_secret=e10adc3949ba59abbe56e057f20f883e&scope=user.details
    
    

    /**
     * @Api
     */
    public function classified_persons() {
        $this->load->library('oauth_resource_server');
        if (!$this->oauth_resource_server->has_scope(array('user.details'))) {
            // Error logic here - "access token does not have correct permission to user this API method"
            $this->output->set_output(json_encode(array('error_message' => 'access token does not have correct permission to user this API method')));
            return;
        }
        $output = json_encode($this->sample_users);
        $this->output->set_output($output);
    }

    /**
     * @Api
     */
    public function persons() {
        $output = json_encode($this->sample_users);
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
