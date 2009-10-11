<?php

class Process {
    public static $PRIMARY_KEY_FIELDS = "ProcessID";
    public static $DATABASE_TABLE = "Processes";
    public static $RELATIONS = array("Processes.GroupID => groups.id | groups.name");

    private $ProcessID = -1;
    private $GroupID = -1;
    private $ProcessName = "";
   

    public function __construct() {
        ;
    }

    public function getProcessID() {
        return $this->ProcessID;
    }

    public function setProcessID($ProcessID) {
        $this->ProcessID = $ProcessID;
    }

    public function getGroupID() {
        return $this->GroupID;
    }

    public function setGroupID($GroupID) {
        $this->GroupID = $GroupID;
    }

    public function getProcessName() {
        return $this->ProcessName;
    }

    public function setProcessName($ProcessName) {
        $this->ProcessName = $ProcessName;
    }

}
?>
