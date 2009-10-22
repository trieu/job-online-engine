<style type="text/css">
    label {
        margin-right:5px;
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

$attributes = array('id' => 'process_info', 'class' => 'input_info');
echo form_fieldset('Process Information', $attributes);
echo form_open(site_url($action_uri), '');

echo renderInputField("ProcessID");
echo renderSelectField("GroupID", "groups", $groups, "Group Owner");
echo renderInputField("ProcessName");
echo form_submit('mysubmit', 'Submit');
echo form_button("cancel", "Cancel", 'onclick="history.back();"');

echo form_close();
echo form_fieldset_close();

?>



<script type="text/javascript" language="JavaScript">
    var id = <?=  $id ?>;

    jQuery(document).ready(function(){
        if(id > 0){
            jQuery("#ProcessID").val(id);
        }
        else {
            jQuery("#ProcessID").parent().hide();
        }
    });
</script>
