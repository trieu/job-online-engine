<?php
require_once 'FieldType.php';

class Field {

    public static $HTML_DOM_ID_PREFIX = "field_";
    private $FieldID;
    private $ObjectID;
    private $FieldTypeID;
    private $FieldName;
    private $ValidationRules;


    public function __construct() {
        ;
    }

    public function getFieldID() {
        return $this->FieldID;
    }

    public function setFieldID($FieldID) {
        $this->FieldID = $FieldID;
    }

    public function getObjectID() {
        return $this->ObjectID;
    }

    public function setObjectID($ObjectID) {
        $this->ObjectID = $ObjectID;
    }

    public function getFieldTypeID() {
        return $this->FieldTypeID;
    }

    public function setFieldTypeID($FieldTypeID) {
        $this->FieldTypeID = $FieldTypeID;
    }

    public function getFieldName() {
        return $this->FieldName;
    }

    public function setFieldName($FieldName) {
        $this->FieldName = $FieldName;
    }

    public function getValidationRules() {
        return $this->ValidationRules;
    }

    public function setValidationRules($ValidationRules) {
        $this->ValidationRules = $ValidationRules;
    }


    public function buildFieldUI() {
        $CI = &get_instance();
        $CI->load->helper("field_type");
        $id =  Field::$HTML_DOM_ID_PREFIX . $this->getFieldID() ;
        if($this->getFieldTypeID() == FieldType::$TEXT_BOX) {
            return renderInputField($id,$id,"",$this->getFieldName());
        }
        else if($this->getFieldTypeID() == FieldType::$SELECT_BOX) {
            $options = array();
            return renderSelectField($id,$id,$options,$this->getFieldName());
        }
        return "<b>Undefined field</b>";
    }
}
?>
