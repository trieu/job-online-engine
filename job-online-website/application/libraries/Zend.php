<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

set_include_path(get_include_path() . PATH_SEPARATOR . "$_SERVER[DOCUMENT_ROOT]/job-online-website/application/libraries");

class CI_Zend {

    private $index_instance = NULL;
    protected $CI;

    function __construct($class = NULL) {
        // include path for Zend Framework
        // alter it accordingly if you have put the 'Zend' folder elsewhere
        //ini_set('include_path',   ini_get('include_path') . PATH_SEPARATOR . APPPATH . 'libraries');
        $this->CI = & get_instance();

        if ($class) {
            require_once (string) $class . EXT;
        } else {
            ApplicationHook::logInfo("Zend Class Initialized");
        }
    }

    function load($class) {
        require_once (string) $class . EXT;
        ApplicationHook::logInfo("Zend Class $class Loaded");
    }

    public function get_Zend_Search_Lucene($search_mode = true) {
        Zend_Search_Lucene_Analysis_Analyzer::setDefault(new Zend_Search_Lucene_Analysis_Analyzer_Common_Utf8());
        $search_lucene_directory = $this->CI->config->item('search_lucene_directory');
        $dir_path = $_SERVER['DOCUMENT_ROOT'] . $search_lucene_directory;
        ApplicationHook::logInfo($dir_path);
        
        if($search_mode) {
            $this->index_instance = new Zend_Search_Lucene($dir_path);
        } else {
            $this->index_instance = new Zend_Search_Lucene($dir_path, true);
        }
        
        return $this->index_instance;
    }

}