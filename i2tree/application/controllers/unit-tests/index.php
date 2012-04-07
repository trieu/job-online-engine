<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class index extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    /**
     * @Decorated
     * @Secured
     */
    public function index() {
         if (ENVIRONMENT !== 'development') {
            return;
        }
        $controllers = array();
        $arr = $this->getDirectoryList(ApplicationHook::$CONTROLLERS_FOLDER_PATH . '/unit-tests/');
        foreach ($arr as $fileName) {
            $toks = explode(".", $fileName);
            if (count($toks) === 2 && $toks[1] === 'php' && $toks[0] !== 'index') {
                $controllers[$toks[0]] = $toks[0];
            }
        }
        $data = array(
            "controllers" => $controllers
        );
        $this->load->view("unit-tests/list_view", $data);
    }
  

    private function getDirectoryList($directory) {
        $results = array();
        // create a handler for the directory
        $handler = opendir($directory);

        // open directory and walk through the filenames
        while ($file = readdir($handler)) {
            // if file isn't this directory or its parent, add it to the results
            if ($file != "." && $file != "..") {
                $results[] = $file;
            }
        }
        closedir($handler);
        return $results;
    }

}