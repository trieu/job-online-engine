<?php

class Form {
    public static $HTML_DOM_ID_PREFIX = "form_";
    private $FormID;
    private $FormName;


    public function __construct() {
        ;
    }

    public function getFormID() {
        return $this->FormID;
    }

    public function setFormID($FormID) {
        $this->FormID = $FormID;
    }

    public function getFormName() {
        return $this->FormName;
    }

    public function setFormName($FormName) {
        $this->FormName = $FormName;
    }


}
?>
