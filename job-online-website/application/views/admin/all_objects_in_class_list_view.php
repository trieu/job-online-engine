<style type="text/css">
    .context_menu_trigger span {
        min-width: 102px;
    }
    .context_menu_trigger {
        border-top: blue solid 1px;
        padding: 10px 10px 10px 50px;
    }
    .context_menu_trigger .id{
       color: blue;
       font-size: 16px;
       font-weight: bold;
       margin-left: -40px;
    }
    .context_menu_trigger .field_name{
       color:#1C94C4;
       font-size: 13px;
       font-weight: bold;
    }
    .context_menu_trigger .field_value{
       color:#000000;
       font-size: 15.5px;
       font-weight: bold;
    }
    .context_menu_trigger .actions{     
       text-align: right;
       padding-right: 40px;
       color: blue;
    }

</style>
<?php if( ! isset ($in_search_mode) ) { ?>

    <?php
    addScriptFile("js/jquery.contextmenu/jquery.contextmenu.js");
    addCssFile("js/jquery.contextmenu/style.css");
    ?>
<script type="text/javascript">
    jQuery(document).ready(function() {
        var f = function(){
            jQuery(this).contextMenu({ menu: "context_menu_ui", leftButton: true},contextMenuHandler);
            jQuery(this).mouseover(function(){
                // jQuery(this).css("background-color", "#FFFF99");
            });
            jQuery(this).click(function(){
                jQuery(".context_menu_trigger").css("background-color", "#FFF");
                jQuery(this).css("background-color", "#FFFF99");
            });
            jQuery(this).mouseout(function(){
                // jQuery(this).css("background-color", "#FFF");
            });
        };
        jQuery(".context_menu_trigger").each(f);
    });
    function contextMenuHandler(action, el, pos) {
        var params = "";
        if( action.indexOf("ProcessID_") == 0 ) {
            params = "/" + <?echo $objectClass->getObjectClassID(); ?> + "/" + jQuery(el).attr("id").replace("object_row_","") + "/" + action.replace("ProcessID_","");
           // window.location = "<?= site_url("admin/object_controller/do_process")?>" + params;
           // TODO
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
        <a href="#EditObject" >
            @Action: Edit
        </a>
    </li>
<?php foreach ($objectClass->getUsableProcesses() as $idx => $p) {
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
    <?php }
} ?>
</ul>

    <?php } ?>


<div style="margin-bottom: 20px;">
    <h3><?= $objectClass->getObjectClassName()  ?> </h3>
    <b>Display <?= $total_records = count($objects) ?> records</b>
</div>


<?php if($total_records > 0) {
    foreach ($objects as $objID => $fields ) { ?>
<div class="context_menu_trigger focusable_text" id="object_row_<?= $objID ?>">
     <div class="id">ID: <?php echo $objID; ?></div>
            <?php
            foreach ($fields as $field ) {
                if( isset ($field['FieldID'])) {
                    ?>
    <div style="margin-top: 3px;">
        <span class="field_name"><?php echo $field['FieldName'];?></span>
        <span class="field_value"><?php echo $field['FieldValue'];?></span>
    </div>
                    <?php
                }
                else {
                    ?>
    <div style="margin-top: 3px;">
        <span class="field_name"><?php echo $field['FieldName'];?></span>
        <span class="field_value"><?php echo $field['FieldValue'];?></span>
    </div>
                    <?php
                }
            }
            ?>
    <div class="actions" >
          <?= anchor('admin/object_controller/edit/'.$objID , 'More Details', array('title' => 'Edit')) ?>
    </div>
</div>
        <?php } ?>
    <?php } else { ?>
<div>
    <b>No results were found!</b>
</div>
    <?php } ?>