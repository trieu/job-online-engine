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
     var checkboxHashmap = {};
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
                        var isEquals = jQuery(this).attr("value") == object_field[id] ;
                        //console.log(jQuery(this).attr("value") + " == " + object_field[id] +" isEquals " + isEquals);
                        if(isEquals)
                        {
                           jQuery(this).attr("checked",true);
                           jQuery(this).attr("selected",true);
                           var n = jQuery(this).attr("name") + "FVID_" + toks[1];
                           jQuery(this).attr("name",n);
                        }
                        if(jQuery(this).attr("type") == "checkbox"){
                            checkboxHashmap[jQuery(this).attr("id")] = jQuery(this).attr("id");
                        }
                    });
                }
                else {
                    jQuery(node_address).setValue( object_field[id] );
                    var n = jQuery(node_address).attr("name") + "FVID_" + toks[1];
                    jQuery(node_address).attr("name",n);
                }
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
            var data = {};
            var records = {};
            for(var i in formData){
                var toks = formData[i].name.split("FVID_");
                var record = {};
                record["FieldID"] =  new Number( toks[0].replace("field_",""));
                record["FieldValueID"] =  new Number(toks[1]);
                record["FieldValue"] = formData[i].value;

                var k = record["FieldID"] + "" +  record["FieldValueID"];
                if(record["FieldValue"].length > 6){
                    k +=  record["FieldValue"].substring(0,6);
                }
                else {
                    k +=  record["FieldValue"];
                }
                records[k] = (record);
            }
            console.log(formData);
            for(var id in checkboxHashmap){
                var toks = jQuery("#" + id).attr("name").split("FVID_");
                var record = {};
                var value = -1;
                if( jQuery("#" + id).attr("checked")){
                    value = jQuery("#" + id).val();
                }
                record["FieldID"] =  new Number( toks[0].replace("field_",""));
                record["FieldValueID"] =  new Number(toks[1]);
                record["FieldValue"] = value;

                var k = record["FieldID"]  + "" +  record["FieldValueID"] + record["FieldValue"];
                records[k] = (record);
            }
            console.log(records);
            var list = [];
            for(var k in records){
                list.push(records[k]);
            }
            data["FieldValues"] = jQuery.toJSON(list);

            var callback = function(responseText, statusText)  {
                jQuery("#object_instance_div").append(responseText);
                jQuery("#object_instance_div .ajax_loader").hide();
            };
            jQuery("#object_instance_div .ajax_loader").show();
            jQuery("#object_instance_div form").hide();
            jQuery.post( jQuery(jqForm).attr("action"), data, callback );
            return false;
        };

        jQuery('#object_instance_form').submit(function() {
            //jQuery(this).ajaxSubmit({beforeSubmit: preSubmitCallback});
            var data = {};
            data["FieldValues"] = [];
            var tokens = jQuery(this).formSerialize().split("&");
            var addedCheckBoxIds = {};
            for(var i in tokens){               
                var toks2 = tokens[i].split("=");
                var toks3 = toks2[0].split("FVID_");
                var record = {};
                record["FieldID"] =  new Number( toks3[0].replace("field_",""));
                record["FieldValueID"] =  new Number(toks3[1]);
                record["FieldValue"] = toks2[1];
                record["SelectedFieldValue"] = false;

                var node = "input[type='checkbox'][name='" + toks2[0] + "']";
                if( jQuery(node).length > 0 ){
                    record["SelectedFieldValue"] = jQuery(node).attr("checked");
                    addedCheckBoxIds[jQuery(node).attr("id")] = true;
                }
                data["FieldValues"].push(record);
            }
            for(var id in checkboxHashmap){
                if(addedCheckBoxIds[id] != true) {
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
            console.log(data);
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