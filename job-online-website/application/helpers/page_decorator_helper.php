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

if ( ! function_exists('action_url') ) {
    function action_url($uri){
        if ( defined('LANGUAGE_INDEX_PAGE') ){
            return base_url().LANGUAGE_INDEX_PAGE."/".$uri;
        }
        return site_url($uri);
    }
}

if ( ! function_exists('action_url_a') ) {
    function action_url_a($uri, $link_name, $title = "", $css_class = ""){
        $url = action_url($uri);
        if($title == ""){
            $title = $link_name;
        }
        echo '<a class="vietnamese_english '.$css_class.'" href="'.$url.'" title="'.$title.'" >'.$link_name."</a>";
    }
}

if ( ! function_exists('show_the_excerpt') ) {
    function show_the_excerpt($str, $length) {
      $str = strip_tags($str,"<b><br><p>");
      $str = explode(" ", $str);
      if(count($str) > $length){
          return implode(" " , array_slice($str, 0, $length))." [...]";
      }
      return implode(" " , array_slice($str, 0, $length));
    }
}
?>