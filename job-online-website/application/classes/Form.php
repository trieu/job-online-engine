<?php

class Form {
    public static $HTML_DOM_ID_PREFIX = "form_";

    /**
    * @EntityField( is_primary_key=TRUE )
    */
    private $FormID = -1;

   /**
    * @EntityField
    */
    private $FormName;

   /**
    * @EntityField
    */
    private $Description = "";

   /**
    * @EntityField( is_db_field=FALSE)
    */
    private $ProcessIDs = array();


    public function __construct() {}

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
    public function getDescription() {
        return $this->Description;
    }

    public function setDescription($Description) {
        $this->Description = $Description;
    }

    public function getProcessIDs() {
        return $this->ProcessIDs;
    }

    public function setProcessIDs($ProcessIDs) {
        $this->ProcessIDs = $ProcessIDs;
    }

    public function addProcessID($ProcessID) {
        array_push($this->ProcessIDs, (int)$ProcessID);
    }


}
?>
