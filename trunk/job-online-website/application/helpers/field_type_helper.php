<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');


if ( ! function_exists('renderSelectField') ) {
    function renderSelectField($input_name,$input_id = "" ,array $data_list = array(), $label_name = "",array $selected_list = array(),$selectBoxExtAttr = "" ) {
        $html = "";
        
        if($label_name == "") {
            $label_name = $input_name;
        }
        if($input_id == "") {
            $input_id = $input_name;
        }

        $html = $html .  "<div>";
        $attributes = array(
            'class' => '',
            'style' => '',
        );
        $html = $html . form_label($label_name, $input_id, $attributes);

        $selectBoxExtAttr = $selectBoxExtAttr . 'id="'.$input_id.'"';

        $html = $html . form_dropdown($input_name, $data_list, $selected_list, $selectBoxExtAttr);
        $html = $html . "</div>";
        return $html;
    }
}

if ( ! function_exists('renderInputField') ) {
    function renderInputField($input_name,$input_id = "" , $input_value = "", $label_name = "" ) {
        $html = "";

        if($label_name == "") {
            $label_name = $input_name;
        }
        if($input_id == "") {
            $input_id = $input_name;
        }

        $html = "<div>";
        $attributes = array(
            'class' => '',
            'style' => '',
        );
        $html = $html . form_label($label_name, $input_id, $attributes);

        $data = array(
            'name'        => $input_name,
            'id'          => $input_id,
            'value'       => $input_value,
            'maxlength'   => '100',
            'size'        => '50',
            'style'       => 'width:50%',
        );
        $html = $html .  form_input($data);
        $html = $html .  "</div>";
        return $html;
    }
}

?>