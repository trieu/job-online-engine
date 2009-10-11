<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once(dirname(__FILE__).'/annotations.php');
/**
 * Description of Secured
 *
 * @author Trieu Nguyen
 * @Target("method")
 */
class Secured extends Annotation {
    public $role;
    public $level;
}
?>
