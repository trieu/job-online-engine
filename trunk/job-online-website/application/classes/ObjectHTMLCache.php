<?php



class ObjectHTMLCache {
    private $cacheID = 0;
    private $objectClass = "";
    private $objectPK = 0;
    private $cacheContent = "";
    private $javascriptContent = "";


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

    public function getJavascriptContent() {
        return $this->javascriptContent;
    }

    public function setJavascriptContent($javascriptContent) {
        $this->javascriptContent = $javascriptContent;
    }


}
?>
