
<?php
$action_names  = array(
    "Create new process" => "admin/admin_panel/add_new_process"
    ,"Update process" => "admin/admin_panel/list_processes"
    ,"List all processes" => "admin/admin_panel/list_processes");
renderGroupOfActions("manage_process","Manage Processes", $action_names);

$action_names  = array(
       "Create new Forms"=> ""
       ,"Update Forms"=> ""
       ,"List all Forms"=> "admin/admin_panel/list_forms"
       ,"Build form"=> "admin/admin_panel/form_builder");
renderGroupOfActions("manage_form","Manage Forms", $action_names);

$action_names  = array(
    "Create new Fields"=> ""
    , "Update Fields"=> ""
    , "List all Fields"=> "admin/admin_panel/list_fields");
renderGroupOfActions("manage_fields","Manage Fields", $action_names);
?>

<?php  function renderGroupOfActions($group_id, $group_name, $action_names) { ?>
<div class="group_action">
    <h3 onclick="jQuery('#<?= $group_id ?>').slideToggle('slow');">
        <a href="javascript:void(0) "><?= $group_name ?></a>
    </h3>
    <ul id="<?= $group_id ?>">
            <?php foreach ($action_names as $action_name => $action_uri) {
                echo '<li><a href="'.site_url($action_uri).'">'.$action_name.'</a></li>';
            }?>
    </ul>
</div>
<?php } ?>