<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/
$hook['post_controller_constructor'] = array(
                                'class'    => 'ApplicationHook',
                                'function' => 'checkRole',
                                'filename' => 'ApplicationHook.php',
                                'filepath' => 'hooks',
                                'params'   => array()
                                );

$hook['display_override'] = array(
                                'class'    => 'ApplicationHook',
                                'function' => 'decoratePage',
                                'filename' => 'ApplicationHook.php',
                                'filepath' => 'hooks',
                                'params'   => array()
                                );



/* End of file hooks.php */
/* Location: ./system/application/config/hooks.php */