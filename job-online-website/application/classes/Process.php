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
}
?>
