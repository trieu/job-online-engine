<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');


if ( ! function_exists('renderSelectField') ) {
    function renderSelectField($input_name,$input_id = "" ,array $data_list = array(), $label_name = "" ) {
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
            'style' => 'color: #000;',
        );
        $html = $html . form_label($label_name, $input_id, $attributes);

        $extAttr = 'id="'.$input_id.'" onChange="alert(jQuery(this).val());"';

        $html = $html . form_dropdown($input_name, $data_list,"",$extAttr);
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
            'style' => 'color: #000;',
        );
        $html = $html . form_label($label_name, $input_id, $attributes);

        $data = array(
            'name'        => $label_name,
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