<?php
addScriptFile("js/jquery/jquery.form.js");
addScriptFile("js/jquery/jquery.json.js");
addScriptFile("js/jquery/jquery.field.min.js");
?>

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

<fieldset class="input_info" id="object_instance_div"  >
    <legend><?= $form->getFormName() ?></legend>
    <div class="ajax_loader display_none" ></div>
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

     function initFormData() {
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

             for(var id in object_field) {
                var toks = id.split("FVID_");
                var node_address = "#object_instance_form *[name='field_" + toks[0] +"']";
                
                if(jQuery(node_address).length > 1){
                    //hacking for checkbox
                    jQuery(node_address).each(function(){
                        if(jQuery(this).attr("value") == object_field[id] )
                        {
                           jQuery(this).attr("checked",true);
                           jQuery(this).attr("selected",true);
                        }
                    });
                }
                else {
                    jQuery(node_address).setValue( object_field[id] );
                }
             };
             for(var id in object_field){
                var n = jQuery(node_address).attr("name") + "FVID_" + toks[1];
                jQuery(node_address).attr("name",n);
             };
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

        initSaveObjectForm();
     }

     function initSaveObjectForm(){
        var preSubmitCallback = function(formData, jqForm, options) {
            console.log(formData);
            var data = {};
            data["data_fields"] = [];

            data["data_fields"] = jQuery.toJSON(data["query_fields"]);
            console.log(data);
            var callback = function(responseText, statusText)  {
                jQuery("#object_instance_div").append(responseText);
                jQuery("#object_instance_div .ajax_loader").hide();
            };
            jQuery("#object_instance_div .ajax_loader").show();
            jQuery("#object_instance_div form").hide();
            jQuery.post( jQuery(jqForm).attr("action") ,data , callback);

            return false;
        };
        jQuery('#object_instance_form').submit(function() {
            jQuery(this).ajaxSubmit({beforeSubmit: preSubmitCallback});
            return false;
        });
    }
</script>