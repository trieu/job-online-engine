<?php



class ObjectHTMLCache {
    private $cacheID;
    private $objectClass;
    private $objectPK;
    private $cacheContent;


    public function __construct() {
        ;
    }

    public function getCacheID() {
        return $this->cacheID;
    }

    public function setCacheID($cacheID) {
        $this->cacheID = $cacheID;
    }

    public function getObjectClass() {
        return $this->objectClass;
    }

    public function setObjectClass($objectClass) {
        $this->objectClass = trim($objectClass);
    }

    public function getObjectPK() {
        return $this->objectPK;
    }

    public function setObjectPK($objectPK) {
        $this->objectPK = ($objectPK);
    }

    public function getCacheContent() {
        return $this->cacheContent;
    }

    public function setCacheContent($cacheContent) {
        $this->cacheContent = trim($cacheContent);
    }


}
?>
