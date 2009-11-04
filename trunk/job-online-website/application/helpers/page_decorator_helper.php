<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');


if ( ! function_exists('addCssFile') ) {
    function addCssFile($relative_path){
		$CI = &get_instance();
		$CI->page_decorator->addCssFile($relative_path);
    }
}

if ( ! function_exists('addCssFiles') ) {
    function addCssFiles($relative_paths){
		$CI = &get_instance();
		$CI->page_decorator->addCssFiles($relative_paths);
    }
}

if ( ! function_exists('addScriptFile') ) {
    function addScriptFile($relative_path){
		$CI = &get_instance();
		$CI->page_decorator->addScriptFile($relative_path);
    }
}

if ( ! function_exists('addScriptFiles') ) {
    function addScriptFiles($relative_paths){
		$CI = &get_instance();
		$CI->page_decorator->addScriptFiles($relative_paths);
    }
}

if ( ! function_exists('setPageTitle') ) {
    function setPageTitle($pageTitle){
		$CI = &get_instance();
		$CI->page_decorator->setPageTitle($pageTitle);
    }
}

?>