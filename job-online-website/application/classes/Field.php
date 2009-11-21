<?php
require_once 'FieldType.php';

class Field {

    public static $HTML_DOM_ID_PREFIX = "field_";

   /**
    * @EntityField( is_primary_key=TRUE )
    */
    private $FieldID;

   /**
    * @EntityField
    */
    private $FieldTypeID;

   /**
    * @EntityField
    */
    private $FieldName;

   /**
    * @EntityField
    */
    private $ValidationRules;

   /**
    * @EntityField(is_db_field=FALSE)
    */
    private $FieldOptions = array();


    public function __construct() {
        ;
    }

    public function getFieldID() {
        return $this->FieldID;
    }

    public function setFieldID($FieldID) {
        $this->FieldID = $FieldID;
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
    public function getFieldOptions() {
        return $this->FieldOptions;
    }

    public function setFieldOptions($FieldOptions) {
        
        $this->FieldOptions = $FieldOptions;
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
