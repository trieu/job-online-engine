<?php
require_once(dirname(__FILE__).'/annotations.php');
/**
 * Description of Secured
 *
 * @author Trieu Nguyen
 * @Target("method")
 */
class Secured extends Annotation {
    const ROLE_USER = "User";
    const ROLE_ADMIN = "Administrator";
    const ROLE_OPERATOR = "Operator";

    public $role = Secured::ROLE_USER;
    public $level;
}
?>
