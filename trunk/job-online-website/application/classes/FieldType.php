<?php



class FieldType {

    //the value's stored as text
    public static $TEXT_BOX = 1;
    public static $TEXT_AREA = 2;
    public static $DATE_PICKER = 3;
    public static $GOOGLE_DOCS = 8;

    //the value's stored as ref key to FieldOptions table
    public static $SELECT_BOX = 4;
    public static $MULTI_SELECT_BOX = 5;
    public static $RADIO_BUTTON = 6;
    public static $CHECK_BOX = 7;
    

    private $FieldTypeID = -1;
    private $FieldTypeName = "";

    public function __construct() {
        ;
    }

    public function getFieldTypeID() {
        return $this->FieldTypeID;
    }

    public function setFieldTypeID($FieldTypeID) {
        $this->FieldTypeID = $FieldTypeID;
    }

    public function getFieldTypeName() {
        return $this->FieldTypeName;
    }

    public function setFieldTypeName($FieldTypeName) {
        $this->FieldTypeName = $FieldTypeName;
    }

    public static function getAvailableFieldType() {
        $field_types = array();
        $field_types[FieldType::$TEXT_BOX] = "Text Box";
        $field_types[FieldType::$TEXT_AREA] = "Text Area";
        $field_types[FieldType::$DATE_PICKER] = "Date Picker";
        $field_types[FieldType::$SELECT_BOX] = "Select Box";
        $field_types[FieldType::$MULTI_SELECT_BOX] = "Multi Select Box";        
        $field_types[FieldType::$RADIO_BUTTON] = "Radio Button";
        $field_types[FieldType::$CHECK_BOX] = "Check Box";
        $field_types[FieldType::$GOOGLE_DOCS] = "Google Documents";
              
        return $field_types;      
    }

    /**
     *  Checj whether the FieldType in selectable group
     *
     * @param Integer $FieldTypeID
     * @return Boolean
     */
    public static function isSelectableType($type_id) {
        $isTrue = $type_id == FieldType::$SELECT_BOX;
        $isTrue = $isTrue || ($type_id == FieldType::$MULTI_SELECT_BOX );
        $isTrue = $isTrue || ($type_id == FieldType::$CHECK_BOX );
        $isTrue = $isTrue || ($type_id == FieldType::$RADIO_BUTTON );
        return $isTrue;
    }

     public static function getDefinedTypeName($type_id){
        $field_types = self::getAvailableFieldType();
        return $field_types[$type_id];
     }

}
?>
