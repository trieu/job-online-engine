<?php
addScriptFile("js/jquery/jquery.form.js");
addScriptFile("js/jquery/jquery.json.js");
addScriptFile("js/jquery/jquery.field.min.js");
// $object_class = new ObjectClass();
$legend_text = "";
foreach ($object_class->getUsableProcesses() as $pro) {
    $legend_text .= $pro->getProcessName();
    break;
}
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
    legend {
        font-weight:bold;
        font-size: 15px;
    }
    #accordion > *{
        font-size: 15.2px;
        font-family: Trebuchet MS,Tahoma,Verdana,Arial,sans-serif;
        color:#1C94C4;
    }
    #accordion .ui-accordion-header {
        font-weight: bold;
    }
    #accordion .ui-state-active {
       font-size:15px;
    }
</style>

<h3><?= $object_class->getObjectClassName() ?></h3>
<div id="accordion">
	<h3><a href="#"><?= $legend_text ?></a></h3>
	<div>
            <div class="input_info" id="object_instance_div" >
                <div class="ajax_loader display_none" ></div>
                <form id="object_instance_form" action="<?= site_url("admin/object_controller/save/".$object_class->getObjectClassID()) ?>" accept="utf-8" method="post">
                    <?php
                    if(isset ($objectCacheHTML['cacheContent'])) {
                        echo html_entity_decode($objectCacheHTML['cacheContent']);
                    }
                    ?>
                    <input type="submit" value="OK" />
                    <input type="button" value="Cancel" onclick="history.back();" />
                </form>
            </div>
	</div>
	
</div>

<script type="text/javascript">
     jQuery(document).ready(initFormData);

     var checkboxHashmap = {};
     function initFormData(){
         var object_field = {};
         var ObjectID = -1;
         <?php
            if( isset ($object) ) {
                echo " object_field = ".json_encode($object->getFieldValues()).";\n";
                echo " ObjectID = ".$object->getObjectID().";\n";
            }
         ?>
         if(ObjectID > 0){
             var actionUrl = jQuery("#object_instance_form").attr("action") + "/" + ObjectID;
             jQuery("#object_instance_form").attr("action",actionUrl);
             for(var id in object_field) {
                var node_address = "#object_instance_form *[name*='field_" + object_field[id].FieldID +"']";

                //hacking for checkbox
                if( jQuery(node_address).attr("type") == "checkbox" ){
                    node_address += "[value='" + object_field[id].FieldValue + "']"
                    if(jQuery(node_address).length >0 ){
                        if(object_field[id].SelectedFieldValue == 1){
                            jQuery(node_address).attr("checked",true);
                            jQuery(node_address).attr("selected",true);
                        }
                        checkboxHashmap[jQuery(node_address).attr("id")] = jQuery(node_address).attr("id");
                        var n = jQuery(node_address).attr("name") + "FVID_" + object_field[id].FieldValueID;
                        jQuery(node_address).attr("name",n);
                    }
                }
                else {
                    jQuery(node_address).setValue( object_field[id].FieldValue );
                    var n = jQuery(node_address).attr("name") + "FVID_" + object_field[id].FieldValueID;
                    jQuery(node_address).attr("name",n);
                }
             }; 
             for(var id in object_field){
                var toks = id.split("FVID_");
                var node_address = "#object_instance_form *[name='field_" + toks[0] +"']";
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
         
         jQuery("#accordion").accordion({ collapsible: true });
     }

     function initSaveObjectForm(){
        jQuery('#object_instance_form').submit(function() {
            //jQuery(this).ajaxSubmit({beforeSubmit: preSubmitCallback});
            var data = {};
            data["FieldValues"] = [];            
            var addedCheckBoxIds = {};

            var hashmap = jQuery(this).serializeArray();
            for(var i=0; i< hashmap.length; i++){
                var toks3 = hashmap[i].name.split("FVID_");
                var record = {};
                record["FieldID"] =  new Number( toks3[0].replace("field_",""));
                record["FieldValueID"] =  new Number(toks3[1]);
                record["FieldValue"] = hashmap[i].value;
                record["SelectedFieldValue"] = false;

                var node = "input[type='checkbox'][name='" + hashmap[i].name + "']";
                if( jQuery(node).length > 0 ){
                    record["SelectedFieldValue"] = jQuery(node).attr("checked");
                    addedCheckBoxIds[jQuery(node).attr("id")] = true;
                }
                data["FieldValues"].push(record);
            }
            for(var id in checkboxHashmap){
                if(id != null && addedCheckBoxIds[id] != true) {
                    var toks = jQuery("#" + id).attr("name").split("FVID_");
                    var record = {};
                    record["FieldID"] =  new Number( toks[0].replace("field_",""));
                    record["FieldValueID"] =  new Number(toks[1]);
                    record["FieldValue"] = jQuery("#" + id).val();
                    record["SelectedFieldValue"] = jQuery("#" + id).attr("checked");
                    data["FieldValues"].push(record);
                }
            }
            data["FieldValues"] = jQuery.toJSON( data["FieldValues"] );

            var callback = function(responseText, statusText)  {
                jQuery("#object_instance_div").append(responseText);
                jQuery("#object_instance_div .ajax_loader").hide();
            };
            jQuery("#object_instance_div .ajax_loader").show();
            jQuery("#object_instance_div form").hide();
            jQuery.post( jQuery(this).attr("action"), data, callback );
            return false;
        });
    }
</script>