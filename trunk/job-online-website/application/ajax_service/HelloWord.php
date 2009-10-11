<?php
include_once "application/models/Friend.php";
include_once 'application/ajax_service/GWT_Service.php';
include_once 'application/ajax_service/GWT_RPC.php';

/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HelloWord
 *
 * @author Trieu Nguyen
 */


class HelloWord extends GWT_Service {
    function __construct() {
        parent::GWT_Service();
    }

    public static function  sayHi() {
        echo "test1";
    }

    public static function  callWith1Param($a) {
        echo "Hi, ".$a;
    }

    public static function  love($a,$b) {
        echo $a." LOVE ".$b;
    }

    public static function getFriend($id) {
        $myfriend = new Friend();
        $myfriend->setName("Huỳnh Tuyết Hồng");
        $myfriend->setPhoneNumber("8493849815");
        $myfriend->setBirthday("2/2/1983");
        $myfriend->setAge(26);
        GWT_RPC::response($myfriend);
    }

    public static function  gwt_rpc($a) {
        GWT_RPC::response($a);
    }
}
?>
