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
               params = "/" + <?php echo $objectClass->getObjectClassID() ?> + "/" + jQuery(el).attr("id").replace("object_row_","") + "/" + action.replace("ProcessID_","");
               window.location = "<?php echo site_url("admin/object_controller/do_process")?>" + params;
            }
            else if( action.indexOf("FormID_") == 0 ) {
               params = "/" + <?php echo $objectClass->getObjectClassID() ?> + "/" + jQuery(el).attr("id").replace("object_row_","") + "/" + action.replace("FormID_","");
               window.location = "<?php echo site_url("admin/object_controller/do_form")?>" + params;
            }
            else if(action == "EditObject"){
               params = "/" + jQuery(el).attr("id").replace("object_row_","");
               window.location = "<?php echo site_url("admin/object_controller/edit/")?>" + params;
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
                <a href="#ProcessID_<?php echo $p->getProcessID() ?>">
                   @Process: <?php echo $p->getProcessName(); ?>
                </a>
            </li>

            <?php foreach ($p->getUsableForms() as $form) { ?>
                <li>
                   <a href="#FormID_<?php echo $form->getFormID() ?>">
                         &nbsp;&nbsp; #Form: <?php echo $form->getFormName(); ?>
                    </a>
                </li>
            <?php } ?>

        <?php } ?>
    </ul>

<?php } ?>
<div class="search_data_results">
    <div>
        <h3 class="vietnamese_english"><?php echo $objectClass->getObjectClassName() ?> </h3>
        <div>
        <?php
            $total_records = count($objects);
            echo lang("result_number_label").$total_records;
        ?>
        </div>
    </div>

    <?php if($total_records > 0) { ?>
    <table border="1" style="margin: 10px 0 0 5px">
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
            <tr class="context_menu_trigger" id="object_row_<?php echo $objID ?>" >
                <td><?php echo $objID ?></td>
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
                        <?php echo anchor('user/public_object_controller/view/'.$objID , 'View', array('title' => 'Edit')) ?>
                    </div>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
     <?php } else { ?>
    <div>
        <b> <?php echo lang("no_result_text")?> </b>
    </div>
</div>
<?php } ?>