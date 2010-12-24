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
    private $ValidationRules = "searchable";

    /**
     * @EntityField(is_db_field=FALSE)
     */
    private $FieldOptions = array();

    /**
     * @EntityField(is_db_field=FALSE)
     */
    private $FormIDs = array();

    /**
     * @EntityField(is_db_field=FALSE)
     */
    private $OrderInForm = 0;


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

    public function getFieldOptionsAsArray() {
        $arr = array();
        foreach ($this->getFieldOptions() as $record) {
            $arr[ $record['FieldOptionID'] ] = $record['OptionName'];
        }
        return $arr;
    }

    public function setFieldOptions($FieldOptions) {

        $this->FieldOptions = $FieldOptions;
    }

    public function getFormIDs() {
        return $this->FormIDs;
    }

    public function setFormIDs($FormIDs) {
        $this->FormIDs = $FormIDs;
    }

    public function addToForm($FormID) {       
        array_push($this->FormIDs, (int)$FormID );
    }

    public function getOrderInForm() {
        return $this->OrderInForm;
    }

    public function setOrderInForm($OrderInForm) {
        if($OrderInForm >= 0){
            $this->OrderInForm = $OrderInForm;
        }
    }

    public function buildFieldUI() {
        $CI = &get_instance();
        $CI->load->helper("field_type");
        $id =  Field::$HTML_DOM_ID_PREFIX . $this->getFieldID() ;
        $rules = $this->getValidationRules();
        if($this->getFieldTypeID() == FieldType::$TEXT_BOX) {
            return renderInputField($id,$id,"",$this->getFieldName(),$rules);
        }
        else if($this->getFieldTypeID() == FieldType::$TEXT_AREA) {
            return renderTextArea($id, "", $this->getFieldName(),$rules);
        }
        else if($this->getFieldTypeID() == FieldType::$SELECT_BOX) {
            return renderSelectBox($id, $this->getFieldOptionsAsArray(), $this->getFieldName(), FALSE,$rules);
        }
        else if($this->getFieldTypeID() == FieldType::$MULTI_SELECT_BOX) {
            return renderSelectBox($id, $this->getFieldOptionsAsArray(), $this->getFieldName(), TRUE,$rules);
        }
        else if($this->getFieldTypeID() == FieldType::$CHECK_BOX) {
            return renderCheckBoxs($id, $this->getFieldName(),$this->getFieldOptionsAsArray(),$rules);
        }
        else if($this->getFieldTypeID() == FieldType::$RADIO_BUTTON) {
            return renderRadioButtons($id, $this->getFieldName(),$this->getFieldOptionsAsArray(),$rules);
        }
        else if($this->getFieldTypeID() == FieldType::$DATE_PICKER) {
            return renderDatepicker($id, $this->getFieldName(),$rules);
        }
        else if($this->getFieldTypeID() == FieldType::$GOOGLE_DOCS) {
            return renderGoogleDocs($id, $this->getFieldName(),$rules);
        }
        return "<div>Undefined field</div>";
    }
}
?>
