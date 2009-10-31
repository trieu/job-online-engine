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
    }
</style>
<sp
<?php
$obj = new Form();
$selected_processIDs = array();
$selected_processes = array();
if(isset($obj_details)) {
    $obj = $obj_details;
    $selected_processes = $related_objects["processes"];
    $i=0;
    foreach ($selected_processes as $key  => $val) {
        $selected_processIDs[$i++] = $key;
    }
}

$attributes = array('id' => 'form_info', 'class' => 'input_info');
echo form_fieldset('Form Information', $attributes);
echo form_open(site_url($action_uri), '');

echo renderInputField("FormID");
?>

<div style="margin-bottom:10px;">
    <div>
        <label for="ProcessID">Process manage this form: </label>
        <a href="javascript: showProcessList()">Set processes</a>
    </div>
    <?php
    echo "<span style='margin:0px!important;'>".ul($selected_processes)."</span>";
    $selectBoxExtAttr = "id='ProcessID' size='4 multiple='multiple'";
    echo form_dropdown("ProcessID", $processes, $selected_processIDs, $selectBoxExtAttr);
    ?>
</div>

<?php
echo renderInputField("FormName","FormName",$obj->getFormName(),"Form Name");
?>

<div style="margin:10px">
    <input type="submit" value="Submit" />
    <input type="button" value="Build interface" style="margin-right:12px;" onclick="buildFormUI();"/>
    <input type="button" value="Cancel" onclick="history.back();" />
</div>

<?php
echo form_close();
echo form_fieldset_close();
?>



<script type="text/javascript" language="JavaScript">
    var id = <?=  $id ?>;

    jQuery(document).ready(function(){
        if(id > 0){
            jQuery("#FormID").val(id);
            jQuery("#FormID").attr("readonly", "readonly");
            jQuery("#ProcessID").hide();
        }
        else {
            jQuery("#FormID").parent().hide();
        }
    });

    function showProcessList(){
        jQuery('#ProcessID').slideToggle();
    }

    function buildFormUI(){
        if(id > 0){
            window.location = "<?= site_url('admin/admin_panel/form_builder/'.$id)?>";
        }
    }
</script>
