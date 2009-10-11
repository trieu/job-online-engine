<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * page_decorator
 */
class page_decorator {

    protected $CI;
    protected $pageTitle;
    protected $pageMetaTags= array();

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

}
