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
    legend {
        font-weight:bold;
        font-size: 15px;
    }
</style>

<?php
// $object_class = new ObjectClass();
$legend_text = "";
$legend_text = $object_class->getObjectClassName()." - ";
foreach ($object_class->getUsableProcesses() as $pro) {
    $legend_text .= $pro->getProcessName();
    break;
}

?>

<fieldset class="input_info">
    <legend><?= $legend_text ?></legend>
    <form id="object_instance_form" action="<?= site_url("admin/object_controller/save/".$object_class->getObjectClassID()) ?>" accept="utf-8" method="post">
        <?php
        if(isset ($objectCacheHTML['cacheContent'])) {
            echo html_entity_decode($objectCacheHTML['cacheContent']);
        }
        ?>
        <input type="submit" value="OK" />
        <input type="button" value="Cancel" onclick="history.back();" />
    </form>
</fieldset>

<script type="text/javascript">
     jQuery(document).ready(function(){
        jQuery("#object_instance_form").submit(function(){
            var ids = "";
            jQuery("#data_suggestion_container p[class^='token-']").each(function(){
                ids += (jQuery(this).attr("class").replace("token-","") + "&");
            });
            jQuery("#form_details input[name='ProcessIDs']").val(ids);
        });
        initFormData();
     });

     function initFormData(){
         var object_field = {};
         var ObjectID = -1;
         <?php
            addScriptFile("js/jquery/jquery.field.min.js");
            if( isset ($object) ) {
                echo " object_field = ".json_encode($object->getFieldValues()).";\n";
                echo " ObjectID = ".$object->getObjectID().";\n";
            }
         ?>
         if(ObjectID > 0){
             var actionUrl = jQuery("#object_instance_form").attr("action") + "/" + ObjectID;
             jQuery("#object_instance_form").attr("action",actionUrl);
             for(var id in object_field){
                var toks = id.split("FVID_");
                var node_address = "#object_instance_form *[name='field_" + toks[0] +"']";
                jQuery(node_address).setValue( object_field[id] );
                var n = jQuery(node_address).attr("name") + "FVID_" + toks[1];
                jQuery(node_address).attr("name",n);
             }
         }
         else {
             var f = function(){
                 var n = jQuery(this).attr("name")+"FVID_0";
                 jQuery(this).attr("name",n);
             };
             jQuery("#object_instance_form *[name*='field_']").each(f);
         }
     }


</script>
