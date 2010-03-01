<?php if( ! isset ($in_search_mode) ) { ?>

    <?php
    addScriptFile("js/jquery.contextmenu/jquery.contextmenu.js");
    addCssFile("js/jquery.contextmenu/style.css");
    ?>

    <style type="text/css">
        .context_menu_trigger span {
            min-width: 102px;
        }
        .context_menu_trigger td:first {
            font-weight:bold;
        }
    </style>
    <script type="text/javascript">
        jQuery(document).ready(function() {
            var f = function(){
                jQuery(this).contextMenu({ menu: "context_menu_ui", leftButton: true},contextMenuHandler);
                jQuery(this).mouseover(function(){
                   // jQuery(this).css("background-color", "#FFFF99");
                });
                jQuery(this).click(function(){
                    jQuery("tr.context_menu_trigger").css("background-color", "#FFF");
                    jQuery(this).css("background-color", "#FFFF99");
                });
                jQuery(this).mouseout(function(){
                   // jQuery(this).css("background-color", "#FFF");
                });
            };
            jQuery("tr.context_menu_trigger").each(f);
        });
        function contextMenuHandler(action, el, pos) {
            var params = "";
            if( action.indexOf("ProcessID_") == 0 ) {
               params = "/" + <?= $objectClass->getObjectClassID() ?> + "/" + jQuery(el).attr("id").replace("object_row_","") + "/" + action.replace("ProcessID_","");
               window.location = "<?= site_url("admin/object_controller/do_process")?>" + params;
            }
            else if( action.indexOf("FormID_") == 0 ) {
               params = "/" + <?= $objectClass->getObjectClassID() ?> + "/" + jQuery(el).attr("id").replace("object_row_","") + "/" + action.replace("FormID_","");
               window.location = "<?= site_url("admin/object_controller/do_form")?>" + params;
            }
            else if(action == "EditObject"){
               params = "/" + jQuery(el).attr("id").replace("object_row_","");
               window.location = "<?= site_url("admin/object_controller/edit/")?>" + params;
            }
        }
    </script>  
    <ul id="context_menu_ui" class="contextMenu">
        <li>
            <a href="#EditObject">
               @Action: Edit
            </a>
        </li>
        <?php
            foreach ($objectClass->getUsableProcesses() as $idx => $p) {
                if($idx == 0) continue;
        ?>
            <li>
                <a href="#ProcessID_<?= $p->getProcessID() ?>">
                   @Process: <?php echo $p->getProcessName(); ?>
                </a>
            </li>

            <?php foreach ($p->getUsableForms() as $form) { ?>
                <li>
                   <a href="#FormID_<?= $form->getFormID() ?>">
                         &nbsp;&nbsp; #Form: <?php echo $form->getFormName(); ?>
                    </a>
                </li>
            <?php } ?>

        <?php } ?>
    </ul>

<?php } ?>

<div>
    <h3><?= $objectClass->getObjectClassName()  ?> </h3>
</div>
Display <?= $total_records = count($objects) ?> records

<?php if($total_records > 0) { ?>
<table border="1" style="margin-right: 30px">
    <thead>
        <tr>
            <th>ID</th>
            <?php
            $max_field_num = count($metadata_object);
            foreach ($metadata_object as $FieldName ) {
                echo "<th>".$FieldName."</th>";
            }
            ?>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>       
        <?php foreach ($objects as $objID => $data_map ) { ?>
        <tr class="context_menu_trigger" id="object_row_<?= $objID ?>" >
            <td><?= $objID ?></td>
            <?php
                $fields = $data_map["fields"];
                foreach ($metadata_object as $FieldID => $FieldName ) {
                    if( isset($fields[ $FieldID ]) ) {
                        echo "<td><span class='data_cell_f_".$FieldID ."'>". $fields[ $FieldID ]."</span></td>";                        
                    }
                    else {
                        echo "<td><span>&nbsp;</span></td>";
                    }
                }
             ?>
            <td>
                <div>
                    <?= anchor('admin/object_controller/edit/'.$objID , 'View', array('title' => 'Edit')) ?>
                </div>
            </td>
        </tr>
        <?php } ?>       
    </tbody>
</table>
 <?php } else { ?>
<div>
    <b>No results were found!</b>
</div>
<?php } ?>