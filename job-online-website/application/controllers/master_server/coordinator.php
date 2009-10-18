<?php

/**
 * Master coordinator for all mining-node engines (the workers).
 * The coordinator will manage workers, register each worker with worker table.
 *
 * @author Trieu Nguyen. Email: tantrieuf31@gmail.com
 */
class coordinator extends Controller {
    public function __construct() {
        parent::__construct();
    }

}
?>