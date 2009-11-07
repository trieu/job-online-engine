<?php

require_once 'annotations/annotations.php';
require_once 'annotations/Secured.php';
require_once 'annotations/AjaxAction.php';
require_once 'annotations/Decorated.php';
require_once 'application/models/data_manager.php';

/**
 * My hook for application, do check role and decorate page using Annotations
 * @property CI_Loader CI->load
 * @property redux_auth CI->redux_auth
 * @author Trieu Nguyen. Email: tantrieuf31@gmail.com
 */
class ApplicationHook {

/**
 * CodeIgniter global
 *
 * @var string
 **/
    protected $CI;
    public static $LOGIN_URL = "";

    protected $controllerRequest;
    protected $controllerName = NULL;
    protected $controllerMethod = NULL;
    protected $reflectedController = NULL;
    public static $countMethodCall = 0;
    public static $CONTROLLERS_FOLDER_PATH = "";
    public static $controllers_map;
    protected $is_logged_in = FALSE;


    private function initHook() {
        try {
            $this->CI =& get_instance();
            $this->beginRequest();
            if(ApplicationHook::$LOGIN_URL == "") {
                ApplicationHook::$LOGIN_URL = base_url().$this->CI->config->item('index_page').'?c=welcome&m=login&url_redirect=';
            }
        } catch (Exception $e) {
            echo "Page error:<br>";
            echo $e->getMessage();
        }
    }

    public function __construct() {
        $this->initHook();
    }

    function ApplicationHook() {
        $this->initHook();
    }


    /**
     *
     * @return boolean
     */
    protected  function isValidControllerRequest() {
        if(ApplicationHook::$CONTROLLERS_FOLDER_PATH === "") {
            ApplicationHook::$CONTROLLERS_FOLDER_PATH = $this->CI->config->item('controllers_directory');
        }

        if($this->controllerName != NULL && $this->controllerMethod != NULL) {
            return  TRUE;
        }

        $index_page = $this->CI->config->item('index_page');
        $tokens = explode("/".$index_page."/", current_url());
        if(sizeof($tokens)>=2 ) {
            $routeTokens =  explode("/", $tokens[1]);
            $routeTokensSize = sizeof($routeTokens);
            if($routeTokensSize >= 2) {
                $c = 0;
                while(is_dir(ApplicationHook::$CONTROLLERS_FOLDER_PATH.$routeTokens[$c])) {
                    $c++;
                }
                $this->controllerName = $routeTokens[$c];

                $next_c = $c+1;
                if($routeTokensSize === $next_c ) {
                    $this->controllerMethod = "index";
                }
                else {
                    $this->controllerMethod = $routeTokens[$next_c];
                }

                $this->controllerRequest = $tokens[1];
                return TRUE;
            }
            else if($routeTokensSize===1 && strlen($routeTokens[0])>0 ) {
                    $this->controllerName = $routeTokens[0];
                    $this->controllerMethod = "index";
                    $this->controllerRequest = $tokens[1];
                    $this->shouldGoToAdminPanel($this->controllerName);
                    return  TRUE;
                }
        }
        else if(strrpos(current_url(), "/".$index_page)>0) {
                $this->controllerName = "home";
                $this->controllerMethod = "index";
                $this->controllerRequest = "";
                return  TRUE;
            }
        return FALSE;
    }

    protected function shouldGoToAdminPanel($controllerClassName) {
        if($controllerClassName == "admin"){
            redirect("admin/admin_panel");
        }
    }

    /**
     *
     * @return ReflectionAnnotatedMethod
     */
    protected function getReflectedController() {
        if($this->reflectedController == NULL) {
            try {
                $this->reflectedController = new ReflectionAnnotatedMethod($this->controllerName,$this->controllerMethod);
            } catch (ReflectionException $e) {
                ApplicationHook::logError($e->getTraceAsString());
                return NULL;
            }
        }
        return $this->reflectedController;
    }

    /**
     * Check role of user, if no authentication, redirect to Login Page
     *
     */
    public function checkRole() {
        if($this->isValidControllerRequest() ) {
            $reflection = $this->getReflectedController();
            $this->is_logged_in = $this->CI->redux_auth->logged_in();
            if($reflection !=NULL ) {
                if($reflection->hasAnnotation('Secured') && $this->is_logged_in  === FALSE) {
                    ApplicationHook::logInfo("-> CheckRole for ".$this->controllerName.".".$this->controllerMethod);
                    $annotation = $reflection->getAnnotation('Secured');
                    //TODO
                    redirect( ApplicationHook::$LOGIN_URL . $this->controllerRequest);
                }
            }
        }
    }

    public static function getExpireTime($num_days = 1) {
        $offset = 60 * 60 * 24 * $num_days;
        return gmdate("D, d M Y H:i:s", time() + $offset) . " GMT";
    }

    public function setPageHeaderCached($num_days = 1) {
        Header("Cache-Control: must-revalidate");
        $ExpStr = "Expires: " . self::getExpireTime($num_days);
        Header($ExpStr);
    }

    /**
     * Decorate the final view and response to client.
     * Each user group will be decorated by defferent theme template
     *
     */
    public function decoratePage() {
        if($this->isValidControllerRequest()) {
            $reflection =  $this->getReflectedController();
            $this->is_logged_in = $this->CI->redux_auth->logged_in();
            if($reflection !=NULL ) {
                if($reflection->hasAnnotation('Decorated')) {
                    $this->setPageHeaderCached();
                    ApplicationHook::logInfo("->Decorate page for ".$this->controllerName.".".$this->controllerMethod);
                    $this->setSiteLanguage();
                    $data = $this->processFinalViewData();

                    if($this->isGroupUser()) {
                        echo ( $this->CI->load->view("decorator/page_template", $data, TRUE) );
                    }
                    else if($this->isGroupAdmin() && $this->controllerName == "admin_panel") {
                            echo ( $this->CI->load->view("decorator/admin_page_template", $data, TRUE) );
                        }
                        else {
                            echo ( $this->CI->load->view("decorator/page_template", $data, TRUE) );
                        }

                    return;
                }
            }
        }
        echo $this->CI->output->get_output();
        $this->CI->benchmark->mark('code_end');
    //ApplicationHook::logInfo("Rendering time: ".$this->CI->benchmark->elapsed_time('code_start', 'code_end'));
    }

    /**
     * Auto detect language for site base on the index file name
     * The default is Vietnamese
     */
    protected function setSiteLanguage() {
        $_lang = "vietnamese";
        if ( defined('LANGUAGE_INDEX_PAGE') ) {
            $this->CI->config->set_item('index_page', LANGUAGE_INDEX_PAGE);
            if(LANGUAGE_INDEX_PAGE === "english.php") {
                $_lang = "english";
            }
        }
        else {
            define('LANGUAGE_INDEX_PAGE', 'tiengviet.php');
        }
        $this->CI->lang->load('fields',$_lang);
    }

    /**
     *
     * @return array of data
     */
    protected function processFinalViewData() {
        $this->CI->load->library('session');

        $page_content = $this->decoratePageContent();       
        
        $data = array(            
			'page_decorator' => $this->CI->page_decorator,
            'page_header' => $this->decorateHeader(),
            'left_navigation' => $this->decorateLeftNavigation(),
            'page_content' => $page_content,
            'page_footer' => $this->decorateFooter()
        );
        $data['controller'] = $this->controllerName."/".$this->controllerMethod;
        $data['page_respone_time'] =  $this->endAndGetResponseTime();
        $data['session_id'] = $this->CI->session->userdata('session_id');
        return $data;
    }

    public static function get_tag( $tag, $xml ) {
        $tag = preg_quote($tag);
        preg_match_all("{<".$tag."[^>]*>(.*?)</".$tag.">}",  $xml,  $matches,PREG_PATTERN_ORDER);
        self::log(count($matches));
        foreach ($matches as $t) {
            
            self::logInfo(($t));
        }
        return $matches[1];
    }



    protected function decorateHeader() {
        $data["isGroupAdmin"] = $this->isGroupAdmin() === TRUE;
        return trim( $this->CI->load->view("decorator/header", $data, TRUE) );
    }

    protected function decorateLeftNavigation() {
        if($this->is_logged_in) {
            if($this->controllerName == "admin_panel" && $this->isGroupAdmin()) {
                return trim( $this->CI->load->view("admin/left_menu_bar",NULL,TRUE) );
            }
            else if($this->controllerName == "job_seeker" && $this->isGroupUser()) {
                    return trim( $this->CI->load->view("global_view/left_menu_bar",NULL,TRUE) );
                }
                //           else if($this->controllerName == "employer" && $this->CI->redux_auth->profile()->group == "user") {
                //                   return trim( $this->CI->load->view("global_view/left_menu_bar",NULL,TRUE) );
                //           }
                else {
                    $first_name = "";
                    if( $this->CI->redux_auth->profile() ){
                        $first_name = $this->CI->redux_auth->profile()->first_name;
                    }
                    $data = array(
                        'is_login' => TRUE
                        ,'first_name' => $first_name
                    );
                    return trim( $this->CI->load->view("decorator/left_navigation", $data, TRUE) );
                }
        }
        else {
        //FIXME
            $data = array(
                'is_login' => FALSE
            );
            return trim( $this->CI->load->view("decorator/left_navigation", $data, TRUE) );
        }
    }

    protected function decoratePageContent() {
        $pagintor_view = "";
        if($this->controllerName == "job_seeker" || $this->controllerName == "employer") {
            $tem_data = array('controllerName'=>$this->controllerName);
            $pagintor_view =  $this->CI->load->view("global_view/question_url",$tem_data,TRUE);
        }
        return trim( $this->CI->output->get_output() ).$pagintor_view;
    }

    protected function decorateFooter() {
        return trim( $this->CI->load->view("decorator/footer", '', TRUE) );
    }

    protected function beginRequest() {
        $this->CI->benchmark->mark('code_start');
    }

    protected function endAndGetResponseTime() {
        $this->CI->benchmark->mark('code_end');
        $diff_time = 1000 * $this->CI->benchmark->elapsed_time('code_start', 'code_end');
        return "<br/><b>Rendering time: ".$diff_time." miliseconds</b><br/>";
    }

    public static function logInfo($text) {
        if(ApplicationHook::isLogEnabled()) {
            $ci = &get_instance();
            $ci->load->library('FirePHP');
            $ci->firephp->info("  ".$text);
        }
    }

    public static function logError($text) {
        if(ApplicationHook::isLogEnabled()) {
            $ci = &get_instance();
            $ci->load->library('FirePHP');
            $ci->firephp->error("  ".$text);
        }
    }

    public static function log($text) {
        if(ApplicationHook::isLogEnabled()) {
            $ci = &get_instance();
            $ci->load->library('FirePHP');
            $ci->firephp->log("".$text);
        }
    }

    public static function isLogEnabled() {
        $ci = &get_instance();
        return  $ci->config->item('fire_php_log_enable');
    }

    protected function isGroupAdmin() {
        if($this->is_logged_in == FALSE) {
            return FALSE;
        }
        else if( ! $this->CI->redux_auth->profile() ){
            return FALSE;
        }
        return $this->CI->redux_auth->profile()->group === "admin";
    }

    protected function isGroupUser() {
        if($this->is_logged_in == FALSE) {
            return FALSE;
        }
        else if( ! $this->CI->redux_auth->profile() ){
            return FALSE;
        }
        return $this->CI->redux_auth->profile()->group === "user";
    }

    protected function isGroupOperator() {
        if($this->is_logged_in == FALSE) {
            return FALSE;
        }
        else if( ! $this->CI->redux_auth->profile() ){
            return FALSE;
        }
        return $this->CI->redux_auth->profile()->group === "operator";
    }
}
?>
