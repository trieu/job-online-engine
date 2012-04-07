<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class sample_api extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    private $sample_users = array(
        3 => array('id' => 3, 'name' => 'Scotty', 'email' => 'example3@example.com', 'fact' => 'Is a Scott!', array('hobbies' => array('fartings', 'bikes'))),
        4 => array('id' => 4, 'name' => 'Nguyễn Tấn Triều', 'email' => 'tantrieuf31@gmail.com', 'fact' => 'a software engineer')
    );

    /**
     * @Api
     */
    public function index() {
        $output = json_encode($this->sample_users);
        $this->output->set_output($output);
    }

    //1: GET http://localhost/i2tree/index.php/oauth/index?client_id=hello-i2tree&redirect_uri=http://localhost/i2tree/index.php/unit-tests/&response_type=code&client_secret=e10adc3949ba59abbe56e057f20f883e&scope=user.details&state=04042012
    //=> localhost/i2tree/index.php/unit-tests/?code=06776d83dfb1d36d8b660046c6cb6a28&state=
    //2: POST http://localhost/i2tree/index.php/oauth/access_token
    // params: client_id=hello-i2tree&client_secret=e10adc3949ba59abbe56e057f20f883e&redirect_uri=http%3A%2F%2Flocalhost%2Fi2tree%2Findex.php%2Funit-tests%2F&code=11aef0dd38b251150109b47ac91be867&grant_type=authorization_code
    //=> {"access_token":"3916f65b0af4687b30da58048815fab67416a874","error":0,"error_message":""}
    //3: GET: http://localhost/i2tree/index.php/unit-tests/sample_api/classified_persons?access_token=3916f65b0af4687b30da58048815fab67416a874

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
