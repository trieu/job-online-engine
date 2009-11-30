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
require_once 'macros.php';
addScriptFile("js/jquery.tokeninput/jquery.tokeninput.js");
addScriptFile("js/commons.js");
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

<div id="data_suggestion_container">
    <?php
    $selected_processes = array();
    $template = '<li class="token-input-token" ><p class="token-[id]">[name]</p><span class="token-input-delete-token">x</span></li>';
    $tokens = "";
    if(count($obj->getUsableProcesses())>0) {
        foreach ($obj->getUsableProcesses() as $key => $val) {
            $tem = str_replace( "[id]", $key,$template);
            $tem = str_replace("[name]", $key." - ".$val->getProcessName(), $tem);
            $tokens = $tokens . $tem;
        }
    }
    ?>
    <b>This object can do:</b>
    <input type="text" id="data_suggestion" name="ProcessIDs" />
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

    function setIdentityProcess(){
        jQuery("#data_suggestion_container .token-input-list li").attr("title","");
        jQuery("#data_suggestion_container .token-input-list li").css("background-color","");
        jQuery("#data_suggestion_container .token-input-list li:first").attr("title","Identity Process");
        jQuery("#data_suggestion_container .token-input-list li:first").css("background-color","yellow");
    }

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
            var ids = "";
            jQuery("#data_suggestion_container p[class^='token-']").each(function(){
                ids += (jQuery(this).attr("class").replace("token-","") + "&");
            });
            jQuery("#form_details input[name='ProcessIDs']").val(ids);
        });

        jQuery("#data_suggestion").tokenInput("/job-online-website/index.php/admin/process_controller/getProcessesAsJson", {
            hintText: "Type in the name of process",
            noResultsText: "No results",
            searchingText: "Searching...",
            method: "POST"
        });
        jQuery("#data_suggestion_container").find(".token-input-list").prepend('<?= $tokens ?>');
        jQuery("#data_suggestion_container .token-input-delete-token").click(function(){ jQuery(this).parent().remove();} );

        var sortOpts = {
            axis: "y",
            containment: jQuery("#data_suggestion_container").find(".token-input-list"),
            cursor: "move",
            distance: 3
        };
        jQuery("#data_suggestion_container").find(".token-input-list").sortable(sortOpts);
        setIdentityProcess();

    });

</script>


<?php
$data_list= array();
foreach ($available_processes as $p) {
    $data_list[$p->getProcessID()] = $p->getProcessName();
}
echo importContainerBox("Available Process", $data_list, TRUE);
 ?>