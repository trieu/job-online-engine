<?php

class Object {

    private $ObjectID = -1;
    private $ObjectPrefixKey = "";
    private $ObjectClassID = -1;
    private $ObjectRefKey = "";

    /**
     * @EntityField( is_db_field=FALSE)
     */
    private $FieldValues = array();

    public function __construct() {
        ;
    }

    public function getObjectID() {
        return $this->ObjectID;
    }

    public function setObjectID($ObjectID) {
        $this->ObjectID = $ObjectID;
    }

    public function getObjectPrefixKey() {
        return $this->ObjectPrefixKey;
    }

    public function setObjectPrefixKey($ObjectPrefixKey) {
        $this->ObjectPrefixKey = $ObjectPrefixKey;
    }

    public function getObjectClassID() {
        return $this->ObjectClassID;
    }

    public function setObjectClassID($ObjectClassID) {
        $this->ObjectClassID = $ObjectClassID;
    }

    public function getObjectRefKey() {
        return $this->ObjectRefKey;
    }

    public function setObjectRefKey($ObjectRefKey) {
        $this->ObjectRefKey = $ObjectRefKey;
    }

    public function getFieldValues() {
        return $this->FieldValues;
    }

    public function setFieldValues($FieldValues) {
        $this->FieldValues = $FieldValues;
    }

    public function addFieldValue($FieldValue) {
        array_push($this->FieldValues, $FieldValue);
    }
}
?>
