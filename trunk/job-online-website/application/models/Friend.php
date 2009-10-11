<?php
//include_once "system/libraries/Model.php";
class Friend  {

    private $gwt_class = "test.client.model.Friend";
    private $name = '';
    private $phoneNumber = '';
    private $birthday = '';
    private $age = 0;

    function Friend() {
    // Call the Model constructor
       // parent::Model();
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getBirthday() {
        return $this->birthday;
    }

    public function setBirthday($birthday) {
        $this->birthday = $birthday;
    }

    public function getPhoneNumber() {
        return $this->phoneNumber;
    }

    public function setPhoneNumber($phoneNumber) {
        $this->phoneNumber = $phoneNumber;
    }

    public function getGwt_class() {
        return $this->gwt_class;
    }

    public function getAge() {
        return $this->age;
    }

    public function setAge($age) {
        $this->age = $age;
    }





}
?>
