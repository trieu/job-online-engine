<style type="text/css">
    label {
        margin-right:5px;
        display:block;
        font-weight:bold;
    }
    fieldset div {
        margin-top:15px;
        margin-bottom:5px;
    }
    .input_info{
        border:medium solid!important;
    }
</style>

<?php

$attributes = array('id' => 'field_info', 'class' => 'input_info');
echo form_fieldset('Field Information', $attributes);
echo form_open(site_url($action_uri), '');

echo renderInputField("FieldID");
echo renderInputField("ObjectID");
echo renderSelectField("FieldTypeID", "fieldtypes", $groups, "Field Type");
echo renderInputField("FieldName");
echo renderInputField("ValidationRules");
echo form_submit('mysubmit', 'Submit');
echo form_button("cancel", "Cancel", 'onclick="history.back();"');

echo form_close();
echo form_fieldset_close();

?>



<script type="text/javascript" language="JavaScript">
    var id = <?=  $id ?>;

    jQuery(document).ready(function(){
        if(id > 0){
            jQuery("#FieldID").val(id);
            jQuery("#FieldID").attr("readonly", "readonly");
        }
        else {
            jQuery("#FieldID").parent().hide();            
        }
        jQuery("#ObjectID").parent().hide();
    });
</script>
