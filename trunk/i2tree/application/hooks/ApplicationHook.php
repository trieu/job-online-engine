<?php

require_once 'annotations/annotations.php';
require_once 'annotations/Secured.php';
require_once 'annotations/AjaxAction.php';
require_once 'annotations/Decorated.php';
require_once 'annotations/Api.php';
require_once 'annotations/DecoratedForMobile.php';
require_once 'annotations/EntityField.php';

/**
 * The hook for application, do check role and decorate page using Annotations
 * @property CI_Loader CI->load
 * @property redux_auth CI->redux_auth
 * @author Trieu Nguyen. Email: tantrieuf31@gmail.com
 */
class ApplicationHook {

    /**
     * CodeIgniter global
     *
     * @var string
     * */
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
    protected $is_in_admin_domain = FALSE;
    protected $user_profile = FALSE;

    private function initHook() {
        try {
            $this->CI = & get_instance();
            $this->beginRequest();
            if (ApplicationHook::$LOGIN_URL == "") {
                ApplicationHook::$LOGIN_URL = site_url('user_account/login/') . '?url_redirect=';
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
    protected function shouldApplyDecorator() {
        if (ApplicationHook::$CONTROLLERS_FOLDER_PATH === "") {
            ApplicationHook::$CONTROLLERS_FOLDER_PATH = $this->CI->config->item('controllers_directory');
        }

        if ($this->controllerName != NULL && $this->controllerMethod != NULL) {
            return TRUE;
        }

        $index_page = $this->CI->config->item('index_page');
        $tokens = explode("/" . $index_page . "/", current_url());
        if (sizeof($tokens) >= 2) {
            $routeTokens = explode("/", $tokens[1]);

            if (isset($routeTokens[0]) && strtolower($routeTokens[0]) === 'oauth') {
                //skip oauth case ?
                return FALSE;
            }

            $routeTokensSize = sizeof($routeTokens);
            if ($routeTokensSize >= 2) {
                $c = 0;
                while (is_dir(ApplicationHook::$CONTROLLERS_FOLDER_PATH . $routeTokens[$c])) {
                    if ($routeTokens[$c] == "admin") {
                        $this->is_in_admin_domain = TRUE;
                        $c++;
                        break;
                    }
                    $c++;
                }
                $this->controllerName = $routeTokens[$c];

                $next_c = $c + 1;
                if ($routeTokensSize === $next_c) {
                    $this->controllerMethod = "index";
                } else {
                    $this->controllerMethod = $routeTokens[$next_c];
                }

                $this->controllerRequest = $tokens[1];
                return TRUE;
            } else if ($routeTokensSize === 1 && strlen($routeTokens[0]) > 0) {
                $this->controllerName = $routeTokens[0];
                $this->controllerMethod = "index";
                $this->controllerRequest = $tokens[1];
                $this->shouldGoToAdminPanel($this->controllerName);
                return TRUE;
            }
        } else if (strrpos(current_url(), "/" . $index_page) > 0) {
            $this->controllerName = "welcome";
            $this->controllerMethod = "index";
            $this->controllerRequest = "";
            return TRUE;
        }
        return FALSE;
    }

    protected function shouldGoToAdminPanel($controllerClassName) {
        if ($controllerClassName === "admin") {
            redirect("admin/admin_panel");
        }
    }

    protected function getThemeNameFromActionController($reflection = FALSE) {
        if ($reflection === FALSE) {
            $reflection = $this->getReflectedController();
        }
        $themeName = $reflection->getAnnotation('Decorated')->themeName;
        $themeName .= "/";
        return $themeName;
    }

    /**
     *
     * @return ReflectionAnnotatedMethod
     */
    protected function getReflectedController() {
        if ($this->reflectedController == NULL) {
            try {
                $this->reflectedController = new ReflectionAnnotatedMethod($this->controllerName, $this->controllerMethod);
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
        $this->setSiteLanguage();
        if ($this->shouldApplyDecorator()) {
            $reflection = $this->getReflectedController();
            $this->is_logged_in = $this->CI->redux_auth->logged_in();
            if ($reflection != NULL) {
                if ($reflection->hasAnnotation('Secured') && $this->is_logged_in === FALSE) {
                    ApplicationHook::logInfo("-> CheckRole for " . $this->controllerName . "." . $this->controllerMethod);
                    $annotation = $reflection->getAnnotation('Secured');
                    //TODO
                    redirect(ApplicationHook::$LOGIN_URL . $this->controllerRequest);
                }
            }
        }
    }

    public static function getExpireTime($num_days = 1) {
        $offset = 60 * 60 * 24 * $num_days;
        //  return gmdate("D, d M Y H:i:s", time() + $offset) . " GMT";
        //FIXME
        return "";
    }

    public function setPageHeaderCached($num_days = 1) {
        //FIXME
        // Header("Cache-Control: must-revalidate");
        //  $ExpStr = "Expires: " . self::getExpireTime($num_days);
        // Header($ExpStr);
    }

    /**
     * Decorate the final view and response to client.
     * Each user group will be decorated by defferent theme template
     *
     */
    public function decoratePage() {
        if ($this->shouldApplyDecorator()) {
            $reflection = $this->getReflectedController();
            $this->is_logged_in = $this->CI->redux_auth->logged_in();
            if ($reflection != NULL) {
                if ($reflection->hasAnnotation('Decorated')) {
                    if (self::isMaintenanceEnabled()) {
                        echo "<h1>Server is on Maintenance Planning, please come back later</h1>";
                        return;
                    }
                    $themeName = $this->getThemeNameFromActionController($reflection);

                    $this->setPageHeaderCached();
                    $data = $this->processFinalViewData();
                    echo ( $this->CI->load->view("decorator/themes/" . $themeName . "page_template", $data, TRUE) );
                    return;
                } else if ($reflection->hasAnnotation('AjaxAction')) {
                    $this->setPageHeaderCached();
                    $data = array(
                        'page_decorator' => $this->CI->page_decorator,
                        'page_content' => ($this->CI->output->get_output())
                    );
                    echo $this->CI->load->view("decorator/ajax_page_template", $data, TRUE);
                    return;
                } else if ($reflection->hasAnnotation('DecoratedForMobile')) {
                    $this->setPageHeaderCached();
                    $data = array(
                        'page_decorator' => $this->CI->page_decorator,
                        'page_content' => ($this->CI->output->get_output())
                    );
                    echo $this->CI->load->view("decorator/themes/mobile/page_template", $data, TRUE);
                    return;
                } else if ($reflection->hasAnnotation('Api')) {
                    header('Content-Type: application/json');

                    //TODO

                    $annotation = $reflection->getAnnotation('Api');
                    if ($annotation->secured) {
                        //validate OAuth 2.0 token
                        $headers = getallheaders();
                        if (!isset($headers['Authorization'])) {
                            $http_code = 200;
                            $output = json_encode(array("error" => TRUE, "message" => "No authorized access to this API"));

                            header('HTTP/1.1: ' . $http_code);
                            header('Status: ' . $http_code);
                            header('Content-Length: ' . strlen($output));
                            echo $output;
                            return;
                        }
                    }
                    $http_code = 200;
                    $output = $this->CI->output->get_output();
                    header('HTTP/1.1: ' . $http_code);
                    header('Status: ' . $http_code);
                    header('Content-Length: ' . strlen($output));
                    echo $output;
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
        $PAGE_LANGUAGE_KEY = "vietnamese";
        if (defined('LANGUAGE_INDEX_PAGE')) {
            $this->CI->config->set_item('index_page', LANGUAGE_INDEX_PAGE);
            if (LANGUAGE_INDEX_PAGE === "english.php") {
                $PAGE_LANGUAGE_KEY = "english";
            }
        } else {
            define('LANGUAGE_INDEX_PAGE', 'index.php');
        }
        $this->CI->lang->load('fields', $PAGE_LANGUAGE_KEY);
    }

    /**
     *
     * @return array of data
     */
    protected function processFinalViewData() {
        $this->user_profile = $this->CI->redux_auth->profile();
        $page_content = $this->decoratePageContent();
        $data = array(
            'page_header' => $this->decorateHeader(),
            'left_navigation' => $this->decorateLeftNavigation(),
            'page_footer' => $this->decorateFooter(),
            'page_decorator' => $this->CI->page_decorator,
            'page_content' => $page_content
        );
        $data['controller'] = $this->controllerName . "/" . $this->controllerMethod;
        $data['page_respone_time'] = $this->endAndGetResponseTime();
        $data['session_id'] = $this->CI->session->userdata('session_id');
        return $data;
    }

    public static function get_tag($tag, $xml) {
        $tag = preg_quote($tag);
        preg_match_all("{<" . $tag . "[^>]*>(.*?)</" . $tag . ">}", $xml, $matches, PREG_PATTERN_ORDER);
        self::log(count($matches));
        foreach ($matches as $t) {
            self::logInfo(($t));
        }
        return $matches[1];
    }

    protected function decorateHeader() {
        try {
            $first_name = "Guest";
            $login_name = $first_name;
            if ($this->user_profile) {
                $first_name = $this->user_profile->first_name;
                $login_name = $first_name;
                $max_in_first_name = 15;
                if (strlen($login_name) > $max_in_first_name) {
                    $login_name = substr($login_name, 0, $max_in_first_name);
                }
            }
            $data = array(
                'is_login' => $this->is_logged_in
                , 'isGroupAdmin' => $this->isGroupAdmin()
                , 'first_name' => $first_name
                , 'login_name' => $login_name
            );
            $themeName = $this->getThemeNameFromActionController();
            return ($this->CI->load->view("decorator/themes/" . $themeName . "header", $data, TRUE));
        } catch (Exception $exc) {
            return '';
        }
    }

    protected function decorateLeftNavigation() {
        try {
            $themeName = $this->getThemeNameFromActionController();
            if ($this->is_logged_in) {
                $first_name = "Unknown";
                if ($this->user_profile) {
                    $first_name = $this->user_profile->first_name;
                }
                $data = array(
                    'is_login' => TRUE
                    , 'first_name' => $first_name
                );
                $loginBoxView = ($this->CI->load->view("decorator/themes/" . $themeName . "left_navigation", $data, TRUE));

                if ($this->is_in_admin_domain && $this->isGroupAdmin()) {
                    return $loginBoxView . "<hr>" . ($this->CI->load->view("admin/" . $themeName . "left_menu_bar", NULL, TRUE));
                } else {
                    return $loginBoxView;
                }
            } else {
                //FIXME
                $data = array(
                    'is_login' => FALSE
                );
                return ($this->CI->load->view("decorator/themes/" . $themeName . "left_navigation", $data, TRUE));
            }
        } catch (Exception $exc) {
            return '';
        }
    }

    protected function decoratePageContent() {
        return $this->CI->output->get_output();
    }

    protected function decorateFooter() {
        try {
            $themeName = $this->getThemeNameFromActionController();
            return ($this->CI->load->view("decorator/themes/" . $themeName . "footer", '', TRUE));
        } catch (Exception $exc) {
            return '';
        }
    }

    protected function beginRequest() {
        $this->CI->benchmark->mark('code_start');
    }

    protected function endAndGetResponseTime() {
        $this->CI->benchmark->mark('code_end');
        $diff_time = $this->CI->benchmark->elapsed_time('code_start', 'code_end');
        return $diff_time;
    }

    public static function logInfo($text) {
        if (ApplicationHook::isLogEnabled()) {
            $ci = &get_instance();
            // $ci->load->library('FirePHP');
            // $ci->firephp->info("  " . $text);
        }
    }

    public static function logError($text) {
        if (ApplicationHook::isLogEnabled()) {
            $ci = &get_instance();
            // $ci->load->library('FirePHP');
            // $ci->firephp->error("  " . $text);
        }
    }

    public static function log($text) {
        if (ApplicationHook::isLogEnabled()) {
            $ci = &get_instance();
            // $ci->load->library('FirePHP');
            // $ci->firephp->log("" . $text);
        }
    }

    public static function isLogEnabled() {
        $ci = &get_instance();
        return $ci->config->item('fire_php_log_enabled');
    }

    public static function isMaintenanceEnabled() {
        $ci = &get_instance();
        return $ci->config->item('maintenance_enabled');
    }

    protected function isGroupAdmin() {
        if ($this->is_logged_in == FALSE) {
            return FALSE;
        } else if (!$this->CI->redux_auth->profile()) {
            return FALSE;
        }
        return $this->CI->redux_auth->profile()->group === "admin";
    }

    protected function isGroupUser() {
        if ($this->is_logged_in == FALSE) {
            return FALSE;
        } else if (!$this->CI->redux_auth->profile()) {
            return FALSE;
        }
        return $this->CI->redux_auth->profile()->group === "user";
    }

    protected function isGroupOperator() {
        if ($this->is_logged_in == FALSE) {
            return FALSE;
        } else if (!$this->CI->redux_auth->profile()) {
            return FALSE;
        }
        return $this->CI->redux_auth->profile()->group === "operator";
    }

    protected function isTester() {
        if ($this->CI->redux_auth->profile()) {
            return $this->CI->redux_auth->profile()->username === 'tester';
        }
        return FALSE;
    }

}

?>