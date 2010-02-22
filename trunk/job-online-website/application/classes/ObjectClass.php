<?php

require_once 'Process.php';

class ObjectClass {

    /**
     * @EntityField( is_primary_key=TRUE )
     */
    private $ObjectClassID = -1;

    /**
     * @EntityField
     */
    private $ObjectClassName;

    /**
     * @EntityField
     */
    private $AccessDataURI;

    /**
     * @EntityField
     */
    private $Description;

    /**
     * @EntityField( is_db_field=FALSE)
     */
    private $Objects = array();

    /**
     * @EntityField( is_db_field=FALSE)
     */
    private $UsableProcesses = array();

    public function __construct() {
//        $pro = new Process();
//        $pro->setProcessID(1);
//        $pro->setProcessName("Working");
//        array_push($this->UsableProcesses, $pro);
//
//        $pro = new Process();
//        $pro->setProcessID(3);
//        $pro->setProcessName("Eating");
//        array_push($this->UsableProcesses, $pro);
    }

    public function getObjectClassID() {
        return $this->ObjectClassID;
    }

    public function setObjectClassID($ObjectClassID) {
        $this->ObjectClassID = $ObjectClassID;
    }

    public function getObjectClassName() {
        return $this->ObjectClassName;
    }

    public function setObjectClassName($ObjectClassName) {
        $this->ObjectClassName = $ObjectClassName;
    }

    public function getAccessDataURI() {
        if( $this->AccessDataURI == NULL) {
            $this->AccessDataURI = "";
        }
        return $this->AccessDataURI;
    }

    public function setAccessDataURI($AccessDataURI) {
        $this->AccessDataURI = $AccessDataURI;
    }

    public function getDescription() {
        return $this->Description;
    }

    public function setDescription($Description) {
        $this->Description = $Description;
    }
    
    public function getObjects() {
        return $this->Objects;
    }

    public function setObjects($Objects) {
        $this->Objects = $Objects;
    }

    public function getUsableProcesses() {
        return $this->UsableProcesses;
    }

    public function setUsableProcesses($UsableProcesses) {
        $this->UsableProcesses = $UsableProcesses;
    }






}
?>
