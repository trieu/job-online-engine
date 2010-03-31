<?php

class Process {
    public static $PRIMARY_KEY_FIELDS = "ProcessID";
    public static $DATABASE_TABLE = "Processes";
    public static $RELATIONS = array();

    private $ProcessID = -1;
    private $ProcessName = "";
    private $Description = "";

    /**
     * @EntityField( is_db_field=FALSE )
     */
    private $Options = array();

    /**
     * @EntityField( is_db_field=FALSE )
     */
    private $ProcessOrder = -1;


    public function __construct() {
        ;
    }

    public function getProcessID() {
        return $this->ProcessID;
    }

    public function setProcessID($ProcessID) {
        $this->ProcessID = $ProcessID;
    }

    public function getProcessName() {
        return $this->ProcessName;
    }

    public function setProcessName($ProcessName) {
        $this->ProcessName = $ProcessName;
    }
    public function getDescription() {
        return $this->Description;
    }

    public function setDescription($Description) {
        $this->Description = $Description;
    }

    public function getUsableForms() {
        if($this->ProcessID > 0) {
            $CI =& get_instance();
            $CI->load->model("forms_manager");
            return $CI->forms_manager->find_by_filter(array(),array("form_process"=>"form_process.FormID = forms.FormID AND form_process.ProcessID = ".$this->ProcessID));
        }
        return array();
    }


    public function getProcessOrder() {
        return $this->ProcessOrder;
    }

    public function setProcessOrder($ProcessOrder) {
        $this->ProcessOrder = $ProcessOrder;
    }


    public static function _compare(Process $a, Process $b) {
        if($a->getProcessOrder() > $b->getProcessOrder()) {
            return +1;
        }
        else if($a->getProcessOrder() < $b->getProcessOrder()) {
            return -1;
        }
        return 0;
    }

    public function getOptions() {
        return $this->Options;
    }

    public function setOption($key, $val) {
        $this->Options[$key] = $val;
    }

    public function getOptionsAsJSON() {
        return json_encode($this->Options);
    }

    public function setOptionsFromJSON($Options) {
        $this->Options = json_decode($Options);
    }


}
?>
