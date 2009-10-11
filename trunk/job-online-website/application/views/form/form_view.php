<style type="text/css">
    label {
        margin-right:5px;
    }
    fieldset div {
        margin-top:15px;
        margin-bottom:5px;
    }
</style>

<?php

$attributes = array('id' => 'process_info', 'class' => 'input_info');
echo form_fieldset('Process Information', $attributes);
echo form_open(site_url($action_uri), '');

renderInputField("ProcessID");
renderSelectField("GroupID", "groups", $groups, "Group Owner");
renderInputField("ProcessName");
echo form_submit('mysubmit', 'Submit Post!');
echo form_button("cancel", "Cencal", 'onclick="history.back();"');

echo form_close();
echo form_fieldset_close();



function renderSelectField($input_name,$input_id = "" , $data_list = array(), $label_name = "" ) {
    if($label_name == "") {
        $label_name = $input_name;
    }
    if($input_id == "") {
        $input_id = $input_name;
    }

    echo "<div>";
    $attributes = array(
        'class' => '',
        'style' => 'color: #000;',
    );
    echo form_label($label_name, $input_id, $attributes);

    $extAttr = 'id="'.$input_id.'" onChange="alert(jQuery(this).val());"';

    echo form_dropdown($input_name, $data_list,"",$extAttr);
    echo "</div>";
}

function renderInputField($input_name,$input_id = "" , $input_value = "", $label_name = "" ) {
    if($label_name == "") {
        $label_name = $input_name;
    }
    if($input_id == "") {
        $input_id = $input_name;
    }

    echo "<div>";
    $attributes = array(
        'class' => '',
        'style' => 'color: #000;',
    );
    echo form_label($label_name, $input_id, $attributes);

    $data = array(
        'name'        => $label_name,
        'id'          => $input_id,
        'value'       => $input_value,
        'maxlength'   => '100',
        'size'        => '50',
        'style'       => 'width:50%',
    );
    echo form_input($data);
    echo "</div>";
}

?>



<script type="text/javascript" language="JavaScript">
    jQuery(document).ready(function(){
        // jQuery("#ProcessID").parent().hide();
    });
</script>
