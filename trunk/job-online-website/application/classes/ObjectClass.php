<?php

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
    private $Description;

    /**
     * @EntityField( is_db_field=FALSE)
     */
    private $Objects = array();

    /**
     * @EntityField( is_db_field=FALSE)
     */
    private $IdentityProcess = null;

    /**
     * @EntityField( is_db_field=FALSE)
     */
    private $OtherUsableProcesses = array();


    public function __construct() {
        ;
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

    public function getIdentityProcess() {
        return $this->IdentityProcess;
    }

    public function setIdentityProcess($IdentityProcess) {
        $this->IdentityProcess = $IdentityProcess;
    }

    public function getOtherUsableProcesses() {
        return $this->OtherUsableProcesses;
    }

    public function setOtherUsableProcesses($OtherUsableProcesses) {
        $this->OtherUsableProcesses = $OtherUsableProcesses;
    }





}
?>
