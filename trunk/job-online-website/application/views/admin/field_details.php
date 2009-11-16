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
require_once "macros.php";
addScriptFile("js/commons.js");

$obj = new Field();
if(isset($obj_details)) {
    $obj = $obj_details;
}

$attributes = array('id' => 'field_info', 'class' => 'input_info');
echo form_fieldset('Field Information', $attributes);
echo form_open(site_url($action_uri), '');

echo renderInputField("FieldID","FieldID",$obj->getFieldID());
echo renderSelectField("FieldTypeID", "FieldTypeID", $field_types, "Field Type");
?>

<a href="javascript:addFieldOptions();" title="Add Field Options">Add Field Options</a>

<?php
echo renderInputField("FieldName","FieldName",$obj->getFieldName());
echo renderInputField("ValidationRules","ValidationRules",$obj->getValidationRules());
echo form_submit('mysubmit', 'Submit');
echo form_button("cancel", "Cancel", 'onclick="history.back();"');

echo form_close();
echo form_fieldset_close();

?>

<span id="add_field_options_box" style="display:none;">
    <span>
        <form method="POST" action="<? site_url('field_controller/addFieldOption') ?>" accept="UTF-8">
            <textarea name="OptionName" style="width:100%;height:190px;"></textarea>
            <input type="hidden" name="FieldID" value="<?=  $id ?>" />
            <input type="submit" value="OK" />
            <input type="button" value="Cancel" onclick="Modalbox.hide()"/>
        </form>
    </span>
</span>


<script type="text/javascript" language="JavaScript">
    function addFieldOptions(){
        Modalbox.show("#add_field_options_box",{width:500,height:300,title:'Add Field Options'});
    }

    var id = <?=  $id ?>;

    jQuery(document).ready(function(){
        if(id > 0){
            jQuery("#FieldID").val(id);
            jQuery("#FieldID").attr("readonly", "readonly");
            jQuery("#FieldTypeID option[value='<?= $obj->getFieldTypeID() ?>']").attr("selected", "selected");
        }
        else {
            jQuery("#FieldID").parent().hide();            
        }
        jQuery("#ObjectID").parent().hide();
    });
</script>
