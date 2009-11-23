<style type="text/css">
    label {
        margin-right:5px;
        font-weight:bold;
    }
    form div {
        margin-top: 5px;
    }
    fieldset div {
        margin-top:15px;
        margin-bottom:5px;
    }
    .input_info{
        border:medium solid!important;
        padding: 11px;
    }
    textarea {
        font-size: 16px;
    }
</style>


<?php
addScriptFile("js/jquery.tokeninput/jquery.tokeninput.js");
addCssFile("js/jquery.tokeninput/token-input.css");

$obj = new ObjectClass();
if(isset($obj_details)) {
    $obj = $obj_details;
}

if($id <= 0 ) {
    setPageTitle("Create New Object Class");
}
else {
    setPageTitle("Edit Object Class ".$obj->getObjectClassName());
}

$attributes = array('id' => 'ObjectClass_info', 'class' => 'input_info');
echo form_fieldset('Object Class Information', $attributes);
echo form_open(site_url($action_uri), 'id="ObjectClass_details"');

echo renderInputField("ObjectClassID","ObjectClassID",$obj->getObjectClassID(),"ObjectClassID");
echo renderInputField("ObjectClassName","ObjectClassName",$obj->getObjectClassName(),"Object Class Name");

?>

<div>
    <label for="Description">Description:</label>
    <textarea id ="Description" name="Description" rows="4" cols="50"><?= $obj->getDescription() ?></textarea>
</div>

<div style="margin-top:32px">
    <input type="submit" value="Submit" />
    <input type="button" value="Cancel" onclick="history.back();" />
</div>

<?php
echo form_close();
echo form_fieldset_close();
?>


<script type="text/javascript">
    var id = <?=  $id ?>;

    jQuery(document).ready(function(){
        if(id > 0){
            jQuery("#ObjectClassID").val(id);
            jQuery("#ObjectClassID").attr("readonly", "readonly");
        }
        else {
            jQuery("#ObjectClassID").hide();
            jQuery("#ObjectClassID").parent().hide();
        }

        jQuery("#ObjectClass_details").submit(function(){
         
        });
    });

</script>
