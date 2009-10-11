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

echo renderInputField("ProcessID");
echo renderSelectField("GroupID", "groups", $groups, "Group Owner");
echo renderInputField("ProcessName");
echo form_submit('mysubmit', 'Submit Post!');
echo form_button("cancel", "Cencal", 'onclick="history.back();"');

echo form_close();
echo form_fieldset_close();

?>



<script type="text/javascript" language="JavaScript">
    jQuery(document).ready(function(){
        // jQuery("#ProcessID").parent().hide();
    });
</script>
