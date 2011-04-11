<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');


if ( ! function_exists('renderSelectField') ) {
    function renderSelectField($input_name,$input_id = "" ,array $data_list = array(), $label_name = "",array $selected_list = array(),$selectBoxExtAttr = "", $ValidationRules = "" ) {
        $html = "";

        if($label_name == "") {
            $label_name = $input_name;
        }
        if($input_id == "") {
            $input_id = $input_name;
        }

        $html = $html .  '<div id="wrapper_'.$input_id.'" >';
        $attributes = array(
            'class' => 'vietnamese_english ',
            'style' => '',
        );
        $html = $html . form_label($label_name, $input_id, $attributes);

        $selectBoxExtAttr = $selectBoxExtAttr . 'id="'.$input_id.'"';
        $selectBoxExtAttr = $selectBoxExtAttr . 'class="'.$ValidationRules.'"';

        $html = $html . form_dropdown($input_name, $data_list, $selected_list, $selectBoxExtAttr);
        $html = $html . "</div>";
        return $html;
    }
}

if ( ! function_exists('renderInputField') ) {
    function renderInputField($input_name, $input_id = "", $input_value = "", $label_name = "", $ValidationRules = "" ) {
        $html = "";

        if($label_name == "") {
            $label_name = $input_name;
        }
        if($input_id == "") {
            $input_id = $input_name;
        }

        $html = '<div id="wrapper_'.$input_id.'" class="textinput_wrapper" >';
        $attributes = array(
            'class' => 'vietnamese_english',
            'style' => '',
        );
        $html = $html . form_label($label_name, $input_id, $attributes);

        $data = array(
            'name'        => $input_name,
            'id'          => $input_id,
            'value'       => $input_value,            
            'size'        => '50' ,
            'class'       => $ValidationRules
        );
        $html = $html .  form_input($data);
        $html = $html .  "</div>";
        return $html;
    }
}


if ( ! function_exists('renderTextArea') ) {
    function renderTextArea($field_name, $field_value = "", $field_label = "", $ValidationRules = "" ) {
        $html = "";

        if($field_label == "") {
            $field_label = $field_name;
        }

        $CI =& get_instance();
       
        $data = array(
            'field_name' => $field_name ,
            'field_value' => $field_value ,
            'field_label' => $field_label,
            'rules'       => $ValidationRules
        );

        $html = $CI->load->view('form/field_type_templates/TextArea.php', $data, true);

        return $html;
    }
}

if ( ! function_exists('renderSelectBox') ) {
    function renderSelectBox($field_name, $option_list = array(), $field_label = "", $isMultiple = false, $ValidationRules = "" ) {
        $html = "";
        if($field_label == "") {
            $field_label = $field_name;
        }
        $CI =& get_instance();
        $data = array(
            'field_name' => $field_name ,
            'option_list' => $option_list ,
            'field_label' => $field_label ,
            'isMultiple' => $isMultiple ,
            'rules'       => $ValidationRules
        );
        $html = $CI->load->view('form/field_type_templates/SelectBox.php', $data, true);
        return $html;
    }
}

if ( ! function_exists('renderDropDownCheckList') ) {
    function renderDropDownCheckList($field_name, $option_list = array(), $field_label = "", $ValidationRules = "" ) {
        $html = "";
        if($field_label == "") {
            $field_label = $field_name;
        }
        $CI =& get_instance();
        $data = array(
            'field_name' => $field_name ,
            'option_list' => $option_list ,
            'field_label' => $field_label ,            
            'rules'       => $ValidationRules
        );
        $html = $CI->load->view('form/field_type_templates/DropDownCheckList.php', $data, true);
        return $html;
    }
}


if ( ! function_exists('renderCheckBoxs') ) {
    function renderCheckBoxs($field_name, $description, $option_list = array(), $ValidationRules = "") {
        $html = "";

        $CI =& get_instance();
        $CI->load->helper("random_password");

        $data = array(
            'field_name' => $field_name ,
            'option_list' => $option_list ,
            'description' => $description ,
            'rules'       => $ValidationRules
        );

        $html = $CI->load->view('form/field_type_templates/CheckBox.php', $data, true);

        return $html;
    }
}

if ( ! function_exists('renderRadioButtons') ) {
    function renderRadioButtons($field_name, $description, $option_list = array(), $ValidationRules = "") {
        $html = "";

        $CI =& get_instance();
        $CI->load->helper("random_password");

        $data = array(
            'field_name' => $field_name ,
            'option_list' => $option_list ,
            'description' => $description ,
            'rules'       => $ValidationRules
        );

        $html = $CI->load->view('form/field_type_templates/RadioButton.php', $data, true);
        return $html;
    }
}

if ( ! function_exists('renderDatepicker') ) {
    function renderDatepicker($field_name, $field_label, $ValidationRules = "") {
        $html = "";

        $CI =& get_instance();

        $data = array(
            'field_name' => $field_name ,           
            'field_label' => $field_label ,
            'rules'       => $ValidationRules
        );

        $html = $CI->load->view('form/field_type_templates/Datepicker.php', $data, true);
        return $html;
    }
}

if ( ! function_exists('renderGoogleDocs') ) {
    function renderGoogleDocs($field_name, $field_label, $ValidationRules = "") {
        $html = "";

        $CI =& get_instance();

        $data = array(
            'field_name' => $field_name ,
            'field_label' => $field_label ,
            'rules'       => $ValidationRules
        );

        $html = $CI->load->view('form/field_type_templates/GoogleDocs.php', $data, true);
        return $html;
    }
}

?>