<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * page_decorator
 */
class page_decorator {

    protected $CI;
    protected $pageTitle;
    protected $pageMetaTags= array();
    protected $scriptFiles = array();
    protected $cssFiles = array();

    /**
     * __construct
     *
     * @return void
     * @author Trieu Nguyen
     **/
    public function __construct() {
        $this->CI =& get_instance();
        $pageMetaTags = array();
    }

    public function setPageMetaTag($name,$content) {
        $this->pageMetaTags[$name] = $content;
    }

    public function getPageTitle() {
        return $this->pageTitle;
    }

    public function getPageMetaTags() {
        return $this->pageMetaTags;
    }

    public function setPageTitle($pageTitle) {
        $this->pageTitle = trim($pageTitle);
    }

    public function getScriptFiles() {
        return $this->scriptFiles;
    }

    public function addScriptFile($relative_path) {
        array_push($this->scriptFiles, $relative_path);
    }

    public function addScriptFiles( $relative_paths = array() ) {
        $this->scriptFiles = $relative_paths;
    }

    public function getCssFiles() {
        return $this->cssFiles;
    }

    public function addCssFile($relative_path) {
        array_push($this->cssFiles, $relative_path);
    }

    public function addCssFiles( $relative_paths = array() ) {
        $this->cssFiles = $relative_paths;
    }
}
