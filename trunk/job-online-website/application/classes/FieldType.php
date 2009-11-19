<?php



class FieldType {
    public static $TEXT_BOX = 1;
    public static $TEXT_AREA = 2;
    public static $DATE_CHOOSER = 3;

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
        $field_types[FieldType::$DATE_CHOOSER] = "Date Chooser";
        $field_types[FieldType::$SELECT_BOX] = "Select Box";
        $field_types[FieldType::$MULTI_SELECT_BOX] = "Multi Select Box";
        $field_types[FieldType::$CHECK_BOX] = "Check Box";
        $field_types[FieldType::$RADIO_BUTTON] = "Radio Button";
        
      
        return $field_types;      
    }

     public static function getDefinedTypeName($type_id){
        $field_types = self::getAvailableFieldType();
        return $field_types[$type_id];
     }

}
?>
