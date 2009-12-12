<?php

class FieldValue {
    private $FieldValueID = 0;
    private $FieldID = 0;
    private $ObjectID = -1;
    private $FieldValue = "";

    public function __construct() {
        ;
    }

    public function getFieldValueID() {
        return $this->FieldValueID;
    }

    public function setFieldValueID($FieldValueID) {
        $this->FieldValueID = $FieldValueID;
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

    public function getFieldValue() {
        return $this->FieldValue;
    }

    public function setFieldValue($FieldValue) {
        $this->FieldValue = $FieldValue;
    }
}
?>
