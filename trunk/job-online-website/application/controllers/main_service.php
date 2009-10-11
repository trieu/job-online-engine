<?php
/**
 * Description of MainService
 * @property CI_Input $input
 * @author Trieu Nguyen
 */
class Main_Service extends Controller {
    public static $controller_name = "main_service";

    private $dev_mode = false;
    function __construct() {
        parent::Controller();
        $this->load->helper('url');
    }

    public function index() {
        $this->load->view('test_ajax_service');
    }

    public function testCrossSite($a,$callback) {
        $answer = $a;

        if(is_string($answer)) {
            echo $callback."('".$answer."');";
        }
        else if(is_object($answer)) {
                echo $callback."(".json_encode($answer).");";
        }
    }

    public function handler() {
        $service_name = $this->input->get_post("service_name");
        $service_method = $this->input->get_post("service_method");
        $params =  json_decode($this->input->get_post("service_method_params", TRUE), TRUE) ;
        $service_id = $this->input->get_post("service_id");

        if($this->dev_mode) {
            echo($service_id);
            foreach ($params   as $p) {
                echo $p."<br>";
            }
        }
        try {
            require_once 'application/ajax_service/'.$service_name.".php";
            $service = new ReflectionClass($service_name);
            $method = $service->getMethod($service_method);

            $method->invokeArgs($service,$params);
        } catch (Exception $e) {
            echo $e->getTraceAsString();
        }
    }

    private function autoLoadModel() {
        $classesDirectory = 'application/ajax_service/';
        $classesExtension = '.php';
        // require_once all classes in that directory
        $d = dir($classesDirectory);
        while (false !== ($entry = $d->read())) {
        // Check extension
            if (substr($entry, -(strlen($classesExtension))) == $classesExtension) {
                require_once($classesDirectory.$entry);
            //print_r($entry);
            }
        }
        $d->close();
    // print_r(get_declared_classes());;
    }

    public static function  parseArrayToObject($array) {
        $object = new stdClass();
        if (is_array($array) && count($array) > 0) {
            foreach ($array as $name=>$value) {
                $name = strtolower(trim($name));
                if (!empty($name)) {
                    $object->$name = $value;
                }
            }
        }
        return $object;
    }

    public static function parseObjectToArray($object) {
        $array = array();
        if (is_object($object)) {
            $array = get_object_vars($object);
        }
        return $array;
    }
}
?>
