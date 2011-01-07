<?php
addScriptFile("js/jquery/jquery.form.js");
addScriptFile("js/jquery/jquery.json.js");
addScriptFile("js/jquery/jquery.field.min.js");

//validation plugin
addCssFile("js/jquery.validation.engine/validationEngine.jquery.css");
addScriptFile("js/jquery.validation.engine/jquery.validationEngine-en.js");
addScriptFile("js/jquery.validation.engine/jquery.validationEngine.js");

?>

<style type="text/css">
label {
    margin-right:5px;    font-weight:bold;
}
fieldset { border:1px solid green; margin: 12px 5px 5px 5px; }
legend {
  padding: 0.2em 0.5em;
  border:1px solid blue;
  color:blue;
  font-size:90%;
  text-align:right;
  font-weight: bold;
}
.process_forms > div > div {    
    margin: 5px 3px 3px 5px;
}
.process_forms > div > div p {
   font-weight: bold; margin: 10px 0 4px -2px !important;
   font-size:19px; background:#fff4c8;
}
.process_forms hr {
    visibility: visible !important;
    border:thin solid !important;
}
.process_forms .form_name {
    background-color: #CCFFFF;
    color: blue;
    margin-top: 16px;
    font-weight: bold;
}
.process_forms .form_name a{
     text-decoration: none !important;
}
.process_forms label {
    cursor: pointer;
}
#object_instance_form_navigation ol li{
    clear: none !important;
    margin: 3px 0 0 3px !important;
}
.to_top {
    margin-left: 10px;
    font-size: 10px;
}
</style>

<h3><?php echo $object_class->getObjectClassName() ?></h3>

<a name="top_of_form"></a>

<form id="object_instance_form" action="<?php echo site_url("user/public_object_controller/save/".$object_class->getObjectClassID()) ?>" accept="utf-8" method="post">
    <div class="input_info" id="object_instance_div" >
        <div class="ajax_loader display_none" ></div>
            <?php foreach ($object_class->getUsableProcesses() as $pro) {                
                if( strpos($pro->getDescription(), "#not_show_on_create#") === FALSE ){
                ?>
                <fieldset class="process_forms">
                <legend><?php echo $pro->getProcessName() ?></legend>
                <div>
                    <?php
                    foreach ($objectHTMLCaches[$pro->getProcessID()] as $caches){                      
                        foreach ( $caches as $cName => $cValue ){
                            if($cName === "FormName") {
                                echo "<div class='form_name'><a name='$cValue' href='javascript:void(0)'>$cValue</a></div><hr>";
                            }
                            if($cName === "cacheContent") {
                                echo html_entity_decode( $cValue );
                            }
                            if($cName === "javascriptContent") {
                                echo "<script type='text/javascript'>".$cValue."</script>";
                            }
                        }
                    }                   
                    ?>
                </div>
                </fieldset>
            <?php } } ?>
        <center>
            <input type="submit" class="button" value="Save" title="Save to database" />
            <input type="button" class="button" value="Cancel"  title="Cancel and back" onclick="history.back();" />
        </center>
    </div>
</form>
<a name="submit_form" href='javascript:void(0)'></a>

<?php //echo print_r($objectHTMLCaches) ?>

<script type="text/javascript">togglePageNavigation(true);</script>
<script type="text/javascript">

    jQuery(document).ready(initFormData);

    var checkboxHashmap = {};
    function initFormData() {
            makeFormNavigation();
            var object_field = {};
            var ObjectID = -1;
                <?php if( isset ($object) ) {
                    echo " object_field = ".json_encode($object->getFieldValues()).";\n";
                    echo " ObjectID = ".$object->getObjectID().";\n";
                } ?>
                if(ObjectID > 0){
                     var actionUrl = jQuery("#object_instance_form").attr("action") + "/" + ObjectID;
                     jQuery("#object_instance_form").attr("action",actionUrl);
                     for(var id in object_field) {
                         var node_address = "#object_instance_form *[name='field_" + object_field[id].FieldID +"']";

                         //hacking for checkbox
                         if( jQuery(node_address).attr("type") == "checkbox" ){
                             node_address += "[value='" + object_field[id].FieldValue + "']"
                             if(jQuery(node_address).length >0 ){
                                 if(object_field[id].SelectedFieldValue == 1){
                                     jQuery(node_address).attr("checked",true);                                     
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
             };

             function initSaveObjectForm(){
                 jQuery('#object_instance_form').submit(function() {
                     if( ! jQuery(this).validationEngine({returnIsValid:true}) ) {
                         return false;
                     }
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
                         jQuery("#left_action_list").hide();
                         jQuery(window).scrollTop(10);
                         jQuery("#object_instance_div").html(responseText);
                         jQuery("#object_instance_div .ajax_loader").hide();
                     };
                     jQuery("#object_instance_div .ajax_loader").show();
                     jQuery("#object_instance_div form").hide();
                     jQuery.post( jQuery(this).attr("action"), data, callback );
                     return false;
                 });
             }

     function makeFormNavigation(){
         var left_action_list = jQuery("#left_action_list");
         var olHtml = "<ol>";
         jQuery("#object_instance_form").find("a[name]").each(function(){
             var name = jQuery(this).html();
             var link = location.href.split("#")[0] + "#" + name;
             olHtml = olHtml + ( "<li><a href='"+ link +"'>" + name + "</a></li>" );
             var to_home  = location.href.split("#")[0] + "#top_of_form";
             jQuery(this).parent().append( "<a class='to_top' href='"+ to_home +"'>Top of the form</a>");
         });
         olHtml += '<li><a href="'+ location.href.split("#")[0] +'#submit_form" class="vietnamese_english">Lưu vào database / Save to database</a></li> ';
         olHtml += "</ol>";
         left_action_list.html("<h4>Forms:</h4>" + olHtml).show();
         left_action_list.find('a').click(function(){ $(this).addClass('focused'); });

         initTooltip(jQuery("#object_instance_form").find("input"));         
     };

     function makeEffectsForCheckboxAndRadio(){
        var cssSelected = { 'color':'#f00' , 'font-style':'italic' , 'font-size':'18px'};        
        var hoverHandler = function(){
                jQuery(this).css(cssSelected);
        };
        jQuery("#object_instance_form").find("label[for]").each(function(){
            var labelNode = jQuery(this);
            var checkboxNode = jQuery("input[type='checkbox'][id='" + jQuery(this).attr("for") + "']");
            var radioNode = jQuery("input[type='radio'][id='" + jQuery(this).attr("for") + "']");

            if(checkboxNode.length == 1 ){
                var outHandler = function(){
                    if( ! jQuery(checkboxNode).attr('checked')){
                        jQuery(labelNode).removeAttr("style");
                    }
                };
                jQuery(labelNode).mouseover(hoverHandler).mouseout(outHandler);

                var cH = function(){
                    if( jQuery(this).attr("checked") ){
                        jQuery(labelNode).css(cssSelected);
                    }
                    else {
                        jQuery(labelNode).removeAttr("style");
                    }
                };
                checkboxNode.click(cH);               
            } else if(radioNode.length == 1 ) {
                 var outHandler = function(){
                    if( ! jQuery(radioNode).attr('checked') ){
                        jQuery(labelNode).removeAttr("style");
                    }
                };
                jQuery(labelNode).mouseover(hoverHandler).mouseout(outHandler);

                var cH = function(){
                    jQuery(this).parent().find("label[for]").removeAttr("style");
                    if( jQuery(this).attr("checked") ){
                        jQuery(labelNode).css(cssSelected);
                    }                    
                };
                radioNode.click(cH);
            }
        });
     }

    var backURL = "";
    jQuery(document).ready(function() {
        jQuery("#object_instance_form").validationEngine();
        makeEffectsForCheckboxAndRadio();
    });

    function setDataWithMetaData() {
        var jsonObjValues = <?php echo $jsonObjValues ?>;
        console.log(jsonObjValues);
        
        var f = function(){
            var FieldID = this.FieldID;
            var FieldValue = this.FieldValue;

            var fieldnode = $('#field_' + FieldID);
            if(fieldnode.length == 1){
                var type = fieldnode.attr('type');
                var nodeName = fieldnode[0].nodeName;
                if(type == "text" || nodeName == "TEXTAREA") {
                    var html = ": <span>" + FieldValue + "<\/span>";
                    fieldnode.hide().val(FieldValue);
                    $("#wrapper_field_"+ FieldID).append(html);
                } else if(nodeName == "SELECT"){
                    var selectedOpNode = fieldnode.find("option[value='"+ FieldValue +"']");
                    var html = ": <span>" + selectedOpNode.html() + "<\/span>";
                    fieldnode.hide().val(FieldValue);
                    $("#wrapper_field_"+ FieldID).append(html);
                }
            }
        };
        $(jsonObjValues).each(f);
    }
    $(setDataWithMetaData);

</script>