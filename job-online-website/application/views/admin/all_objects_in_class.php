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

<!-- Right Click Menu -->
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
            $field_num_vector =  array();
            foreach ($objects as $objID => $fields ) {                
                $field_num_vector[$objID] = count($fields);
            }
            
            function cmp($a,$b){
                if($a > $b){
                    return -1;
                }
                else if($a < $b){
                    return +1;
                }
                return 0;
            }
            uasort($field_num_vector, 'cmp');

            $max_field_num = 0;
            $max_field_key =  key($field_num_vector);
            if($max_field_key != NULL){
                $max_field_num = $field_num_vector[ $max_field_key ];
            }
       
            $fields = $objects[ key($field_num_vector) ];
            foreach ($fields as $field ) {
                echo "<th>". $field['FieldName'] . "</th>";
            }
            ?>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($objects as $objID => $fields ) { ?>
        <tr class="context_menu_trigger" id="object_row_<?= $objID ?>" >
            <td><?= $objID ?></td>
            <?php
                for ($i = 0; $i < $max_field_num ; $i++ ) {
                    if( isset ($fields[ $i ])){
                        echo "<td>". $fields[ $i ]['FieldValue'] ."</td>";
                    }
                    else {
                        echo "<td></td>";
                    }
                }
             ?>
            <td>
                <div>                    
                    <?= anchor('admin/object_controller/edit/'.$objID , 'Edit', array('title' => 'Edit')) ?>                    
                </div>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
 <?php } ?>
