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
</style>

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
    echo ul($selected_processes);
    $selectBoxExtAttr = "id='ProcessID' size='4' multiple='multiple'";
    echo form_dropdown("ProcessID", $processes, $selected_processIDs, $selectBoxExtAttr);
    ?>
</div>

<div>
	<b>Processes</b>
	<input type="text" id="tokenize" name="ProcessID" />
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


<?php	
	addScriptFile("js/jquery.tokeninput/jquery.tokeninput.js");
	addCssFile("js/jquery.tokeninput/token-input.css");
	if($id <= 0 ){
		setPageTitle("Create New Form");
	}
	else {
		setPageTitle("Edit Form ".$obj->getFormName());
	}
?>


<style type="text/css">
	#container_ui_box .selected_element {
		background:#FFFF99 none repeat scroll 0 0;
	}
</style>
<div id="container_ui_box">
	<ul style="height:54px !important;" >
		<li><a href="#tabs-1">Processes</a></li>
		<li><a href="#tabs-2">Create new process</a></li>		
	</ul>
	<div id="tabs-1">
		<div id="container_list" style="overflow-y:auto; height: 135px; margin-left: 15px; margin-bottom:5px;">
			<?php foreach ($processes as $key  => $val) { ?>
				<div style="margin-bottom:5px">
					<input type="checkbox" id="element_<?= $key ?>" name="<?= $val ?>" onClick="container_ui_box.setSelectedRow(jQuery('#element_<?= $key ?>'))" />
					<label for="element_<?= $key ?>" onClick="container_ui_box.setSelectedRow(jQuery('#element_<?= $key ?>'))" >	
						<?= $val ?>
					</label>
				</div>
			<?php }	?>	
		</div>
	</div>
	<div id="tabs-2">
		<div style="width: 90%; margin-left: 7px;">
			<div>Name<span style="color: red;">*</span>:<br/>
				<input id="containerName" type="text" style="width:100%"/>
				<div id="nameErrorMsg" style="color:red; text-align:right" ></div>
			</div>
		</div>
		<div style="text-align:center" >
			<input type="button" value="OK" />
			<input type="button" value="Cancel" />
		</div>
	</div>
</div>
<script type="text/javascript">
	var container_ui_box = {};
	container_ui_box.setSelectedRow = function(node){
		if( jQuery(node).attr('checked') ){ 
			jQuery(node).parent().addClass('selected_element');
		}
		else {
			jQuery(node).parent().removeClass('selected_element');
		}
	};
	jQuery(document).ready(function(){
		jQuery("#container_ui_box").tabs();
    });
</script>

<script type="text/javascript">
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
	
	jQuery("#tokenize").tokenInput("/job-online-website/index.php/admin/process_controller/getProcessesAsJson", {
            hintText: "Type in the name of process",
            noResultsText: "No results",
            searchingText: "Searching...",
			method: "POST" 			
        });

</script>
