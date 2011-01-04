<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Zend library include path
set_include_path(get_include_path() . PATH_SEPARATOR . "$_SERVER[DOCUMENT_ROOT]/job-online-website/application/libraries");

require_once 'Zend/Loader.php';
Zend_Loader::loadClass('Zend_Gdata');
Zend_Loader::loadClass('Zend_Gdata_Feed');
Zend_Loader::loadClass('Zend_Gdata_Query');
Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
Zend_Loader::loadClass('Zend_Gdata_App_AuthException');
Zend_Loader::loadClass('Zend_Http_Client');


class gdata_ci_loader {

    /**
     * Constructor
     *
     * @param	string $class class name
     */
    function __construct($params = array()) {

    }
}
