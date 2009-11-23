<?php

class Object {

    private $ObjectID = -1;
    private $ObjectPrefixKey = "";
    private $ObjectClassID = -1;
    private $ObjectRefKey = "";

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


}
?>
