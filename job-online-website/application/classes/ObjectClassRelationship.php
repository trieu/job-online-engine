<?php

class ObjectClassRelationship {
    const ONE_TO_ONE = "1-1";
    const ONE_TO_MANY = "1-n";
    const MANY_TO_MANY = "n-n";

    /**
     * @EntityField( is_primary_key=TRUE )
     */
    private $ObjectClassSelfID = -1;

    /**
     * @EntityField( is_primary_key=TRUE )
     */
    private $ObjectClassOtherID = -1;

    /**
     * @EntityField
     */
    private $ConstraintType = self::MANY_TO_MANY;

    /**
     * @EntityField
     */
    private $Explanation = "";

    protected $CI;
    public function __construct() {
        $this->CI = &get_instance();
    }

    public function getObjectClassSelfID() {
        return $this->ObjectClassSelfID;
    }

    public function setObjectClassSelfID($ObjectClassSelfID) {
        $this->ObjectClassSelfID = $ObjectClassSelfID;
    }

    public function getObjectClassOtherID() {
        return $this->ObjectClassOtherID;
    }

    public function setObjectClassOtherID($ObjectClassOtherID) {
        $this->ObjectClassOtherID = $ObjectClassOtherID;
    }

    public function getConstraintType() {
        return $this->ConstraintType;
    }

    public function setConstraintType($ConstraintType) {
        $this->ConstraintType = $ConstraintType;
    }

    public function getExplanation() {
        return $this->Explanation;
    }

    public function setExplanation($Explanation) {
        $this->Explanation = $Explanation;
    }

    
    public function createThis() {
        $this->setObjectClassSelfID($this->CI->input->post("ObjectClassSelfID"));
        $this->setObjectClassOtherID($this->CI->input->post("ObjectClassOtherID"));
        $this->setConstraintType($this->CI->input->post("ConstraintType"));
        $this->setExplanation($this->CI->input->post("Explanation"));

        ApplicationHook::logInfo($this->getExplanation());
        ApplicationHook::logInfo($this->getConstraintType());
    }

    public function readThis() {

    }

    public function updateThis() {

    }

    public function deleteThis() {

    }
}
?>
