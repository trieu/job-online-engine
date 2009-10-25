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
$obj = new Process();
$selected_groupID = array();
if(isset($obj_details)) {
    $obj = $obj_details;
    $selected_groupID =  array($obj->getGroupID());
}


$attributes = array('id' => 'process_info', 'class' => 'input_info');
echo form_fieldset('Process Information', $attributes);
echo form_open(site_url($action_uri), '');

echo renderInputField("ProcessID");
echo renderSelectField("GroupID", "groups", $groups, "Group Owner",$selected_groupID);
echo renderInputField("ProcessName","ProcessName",$obj->getProcessName(),"Process Name");

echo form_submit('mysubmit', 'Submit');
echo form_button("cancel", "Cancel", 'onclick="history.back();"');

echo form_close();
echo form_fieldset_close();
?>

<?php  if( isset ($related_views) && $id > 0) { ?>
<div style="margin-top:22px;">
    <b>This process has the following forms:</b>

    <div style="margin-top:7px;">
        <?php echo $related_views; ?>
    </div>
</div>
<?php } ?>


<script type="text/javascript" language="JavaScript">
    var id = <?=  $id ?>;

    jQuery(document).ready(function(){
        if(id > 0){
            jQuery("#ProcessID").val(id);
            jQuery("#ProcessID").attr("readonly", "readonly");
        }
        else {
            jQuery("#ProcessID").parent().hide();
        }
    });
</script>
