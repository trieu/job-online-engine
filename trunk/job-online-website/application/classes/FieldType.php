<?php



class FieldType {
    public static $TEXT_BOX = 1;
    public static $SELECT_BOX = 2;
    public static $MULTI_SELECT_BOX = 3;
    public static $RADIO_BUTTON = 4;
    public static $DATE_CHOOSER = 5;
    public static $CHECK_BOX = 6;

    private $FieldTypeID;
    private $FieldTypeName;

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


}
?>
