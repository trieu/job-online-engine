
<?php
$action_names  = array(
    "Create new process" => "admin/process_controller/process_details"
    ,"List all processes" => "admin/process_controller/list_processes"
);
renderGroupOfActions("manage_process","Manage Processes", $action_names);

$action_names  = array(
   "Create new Forms"=> "admin/form_controller/form_details"
   ,"List all Forms"=> "admin/form_controller/list_forms"
);
renderGroupOfActions("manage_form","Manage Forms", $action_names);

$action_names  = array(   
    "List all Fields"=> "admin/field_controller/list_fields");
renderGroupOfActions("manage_fields","Manage Fields", $action_names);

$action_names  = array(
    "Create new Object"=> "admin/objectclass_controller/show_details"
    , "List all Objects"=> "admin/objectclass_controller/show");
renderGroupOfActions("manage_object_classes","Manage Object", $action_names);
?>

<?php  function renderGroupOfActions($group_id, $group_name, $action_names) { ?>
<div class="group_action">
    <h3 onclick="jQuery('#<?= $group_id ?>').slideToggle('slow');">
        <a href="javascript:void(0)"><?= $group_name ?></a>
    </h3>
    <ul id="<?= $group_id ?>">
            <?php foreach ($action_names as $action_name => $action_uri) {
                echo '<li class="focusable_text"><a href="'.site_url($action_uri).'">'.$action_name.'</a></li>';
            }?>
    </ul>
</div>
<?php } ?>