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
addScriptFile("js/jquery/jquery.field.min.js");

?>

<fieldset class="input_info">
    <legend><?= $form->getFormName() ?></legend>
    <form id="object_instance_form" action="<?= site_url("admin/object_controller/save/".$classID) ?>" accept="utf-8" method="post">
        <?php
        if(isset ($cache) ) {
            echo html_entity_decode($cache->getCacheContent());
        }
        ?>
        <input type="submit" value="OK" />
        <input type="button" value="Cancel" onclick="history.back();" />
    </form>
</fieldset>

<script type="text/javascript">
     jQuery(document).ready(initFormData);

     function initFormData(){
         var object_field = {};
         var ObjectID = <?= $objectID ?>;
         <?php            
            if( isset ($object) ) {
                echo " object_field = ".json_encode($object->getFieldValues()).";\n";                
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
             var f = function(){
                 var n = jQuery(this).attr("name");
                 if( n.split("FVID_").length < 2 ){
                    jQuery(this).attr("name", n + "FVID_0" );
                 }
             };
             jQuery("#object_instance_form *[name*='field_']").each(f);
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