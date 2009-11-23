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


if ( ! function_exists('renderTextArea') ) {
    function renderTextArea($field_name, $field_value = "", $field_label = "" ) {
        $html = "";

        if($field_label == "") {
            $field_label = $field_name;
        }

        $CI =& get_instance();
       
        $data = array(
            'field_name' => $field_name ,
            'field_value' => $field_value ,
            'field_label' => $field_label
        );

        $html = $CI->load->view('form/field_type_templates/TextArea.php', $data, true);

        return $html;
    }
}

if ( ! function_exists('renderSelectBox') ) {
    function renderSelectBox($field_name, $option_list = array(), $field_label = "", $isMultiple = false ) {
        $html = "";

        if($field_label == "") {
            $field_label = $field_name;
        }

        $CI =& get_instance();

        $data = array(
            'field_name' => $field_name ,
            'option_list' => $option_list ,
            'field_label' => $field_label ,
            'isMultiple' => $isMultiple
        );

        $html = $CI->load->view('form/field_type_templates/SelectBox.php', $data, true);

        return $html;
    }
}


?>