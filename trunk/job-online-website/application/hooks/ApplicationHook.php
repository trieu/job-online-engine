<?php

require_once 'annotations/annotations.php';
require_once 'annotations/Secured.php';
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

    /**
     *
     * @return ReflectionAnnotatedMethod
     */
    protected function getReflectedController() {
        if($this->reflectedController == NULL) {
            try {
                $this->reflectedController = new ReflectionAnnotatedMethod($this->controllerName,$this->controllerMethod);
            } catch (ReflectionException $e) {
                ApplicationHook::logError($this->controllerName.".".$this->controllerMethod." is NOT reflected!");
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
            if($reflection !=NULL ) {
                if($reflection->hasAnnotation('Secured') && $this->CI->redux_auth->logged_in() == FALSE) {
                    ApplicationHook::logInfo("-> CheckRole for ".$this->controllerName.".".$this->controllerMethod);
                    $annotation = $reflection->getAnnotation('Secured');
                    //TODO
                    redirect( ApplicationHook::$LOGIN_URL . $this->controllerRequest);
                }
            }
        }
    }

    /**
     * Decorate the final view and response to client
     *
     */
    public function decoratePage() {
        if($this->isValidControllerRequest()) {
            $reflection =  $this->getReflectedController();
            if($reflection !=NULL ) {
                if($reflection->hasAnnotation('Decorated')) {
                    ApplicationHook::logInfo("->Decorate page for ".$this->controllerName.".".$this->controllerMethod);

                    $this->setSiteLanguage();
                    $data = $this->processFinalViewData();
                    echo trim( $this->CI->load->view("decorator/page_template",$data,TRUE) );
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
        $data = array(
            'page_title' => $this->CI->page_decorator->getPageTitle(),
            'meta_tags' => $this->CI->page_decorator->getPageMetaTags(),
            'page_header' => $this->decorateHeader(),
            'left_navigation' => $this->decorateLeftNavigation(),
            'page_content' => $this->decoratePageContent(),
            'page_footer' => $this->decorateFooter()
        );
        $data['controller'] = $this->controllerName."/".$this->controllerMethod;
        $data['page_respone_time'] =  $this->endAndGetResponseTime();
        $data['session_id'] = $this->CI->session->userdata('session_id');
        return $data;
    }

    protected function decorateHeader() {
        return trim( $this->CI->load->view("decorator/header", '', TRUE) );
    }

    protected function decorateLeftNavigation() {
    //TODO check is admin role here
        $is_login = $this->CI->redux_auth->logged_in();
        if($is_login) {
            if($this->controllerName == "admin_panel" && TRUE) {
                return trim( $this->CI->load->view("admin/left_menu_bar",NULL,TRUE) );
            }
            else if($this->controllerName == "job_seeker" && $this->CI->redux_auth->profile()->group == "user") {
                    return trim( $this->CI->load->view("global_view/left_menu_bar",NULL,TRUE) );
           }
//           else if($this->controllerName == "employer" && $this->CI->redux_auth->profile()->group == "user") {
//                   return trim( $this->CI->load->view("global_view/left_menu_bar",NULL,TRUE) );
//           }
           else {
                $data = array(
                    'is_login' => TRUE
                   ,'first_name' => $this->CI->redux_auth->profile()->first_name
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
        return "<br><b>Rendering time: ".$diff_time." miliseconds</b><br>";
    }

    public static function logInfo($text) {
        $ci = &get_instance();
        $ci->load->library('FirePHP');
        $ci->firephp->info("  ".$text);
    }

    public static function logError($text) {
        $ci = &get_instance();
        $ci->load->library('FirePHP');
        $ci->firephp->error("  ".$text);
    }

    public static function log($text) {
        $ci = &get_instance();
        $ci->load->library('FirePHP');
        $ci->firephp->log("".$text);
    }
}
?>
