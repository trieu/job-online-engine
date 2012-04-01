<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

set_include_path(get_include_path() . PATH_SEPARATOR . "$_SERVER[DOCUMENT_ROOT]/i2tree/application/libraries");

class CI_Zend {

    private static $_indexer = NULL;
    protected $CI;

    function __construct($class = NULL) {
        // include path for Zend Framework
        // alter it accordingly if you have put the 'Zend' folder elsewhere
        //ini_set('include_path',   ini_get('include_path') . PATH_SEPARATOR . APPPATH . 'libraries');
        $this->CI = & get_instance();
        $this->CI->load->helper('file');

        if ($class) {
            require_once (string) $class . EXT;
        } else {
            //ApplicationHook::logInfo("Zend Class Initialized");
        }
    }

    function load($class) {
        require_once (string) $class . EXT;
        //ApplicationHook::logInfo("Zend Class $class Loaded");
    }

    public function get_Zend_Search_Lucene($create_new_index = FALSE) {        
        Zend_Search_Lucene_Search_QueryParser::setDefaultEncoding('utf-8');
        Zend_Search_Lucene_Analysis_Analyzer::setDefault(new Zend_Search_Lucene_Analysis_Analyzer_Common_Utf8_CaseInsensitive() );
        
        if(self::$_indexer != NULL) {
            return self::$_indexer;
        }
        
        $search_lucene_directory = $this->CI->config->item('search_lucene_directory');
        $dir_path = $_SERVER['DOCUMENT_ROOT'] . $search_lucene_directory;
        //ApplicationHook::logInfo($dir_path);
       
        $files = get_filenames($dir_path);
        if(count($files) <= 1) {
            //not found index files, index as new
            $create_new_index = TRUE;
        }

        if($create_new_index) {
            self::$_indexer = Zend_Search_Lucene::create($dir_path, TRUE);
        } else {
            self::$_indexer = Zend_Search_Lucene::open($dir_path);
        }        
        
        return self::$_indexer;
    }

}