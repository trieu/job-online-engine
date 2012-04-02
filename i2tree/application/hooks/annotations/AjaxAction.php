<?php
require_once(dirname(__FILE__).'/annotations.php');

/**
 * Description of AjaxAction
 *
 * @author Trieu Nguyen. Email: tantrieuf31@gmail.com
 */
class AjaxAction  extends Annotation {
    public $reponseText = "";
    public $errorCode = -1;
    public $redirectUrl = "";
}
?>
