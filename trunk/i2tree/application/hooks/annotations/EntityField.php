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
 * @Target("property")
 */
class EntityField extends Annotation {
    public $is_primary_key = FALSE;
    public $is_foreign_key = FALSE;
    public $is_db_field = TRUE;
}
?>
