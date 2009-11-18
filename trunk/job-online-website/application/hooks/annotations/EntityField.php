<?php
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
