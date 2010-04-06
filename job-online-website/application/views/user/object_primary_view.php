<?php
addScriptFile("js/jquery/jquery.form.js");
addScriptFile("js/jquery/jquery.json.js");
addScriptFile("js/jquery/jquery.field.min.js");
addScriptFile("js/jquery.fancybox/jquery.fancybox.min.js");
addCssFile("js/jquery.fancybox/jquery.fancybox.css");
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
        font-family: Trebuchet,Tahoma,Verdana,Arial,sans-serif;
        color:#1C94C4;
    }
    #accordion .ui-accordion-header {
        font-weight: bold;
    }
    #accordion .ui-state-active {
       font-size:15px;
    }
    ol li {
        clear: none!important;
        margin:4px 0 0 4px;
    }
</style>

<h3><?= $object_class->getObjectClassName() ?></h3>

<div>
    <b>Chọn một form để xem hoặc cập nhật thông tin</b>
    <ol>
        <?php foreach($formsOfObject as $form){?>
        <li>
            <a class="iframe use_fancybox" href="<?php echo site_url("user/public_object_controller/ajax_edit_form/".$object->getObjectClassID()."/".$object->getObjectID()."/".$form["FormID"]) ?> ">
            <?= $form["FormName"] ?>
            </a>
        </li>
        <?php }?>
    </ol>
</div>
<div id="accordion">
    <h3><a href="#"><?= $legend_text ?></a></h3>
    <div>
        <div class="input_info" id="object_instance_div" >
            <div class="ajax_loader display_none" ></div>
            <form id="object_instance_form" action="<?= site_url("user/public_object_controller/save/".$object_class->getObjectClassID()) ?>" accept="utf-8" method="post">
                <?php
                if(isset ($objectCacheHTML['cacheContent'])) {
                    echo html_entity_decode($objectCacheHTML['cacheContent']);
                }
                if(isset ( $objectCacheHTML['javascriptContent'] ) ) {
                    echo "<script type='text/javascript'>".$objectCacheHTML['javascriptContent']."</script>";
                }
                ?>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    function initFancyBoxLinks(frameWidth, frameHeight){
        var w = 800, h = 530;
        if( typeof frameWidth == "undefined" ){
            frameWidth = w;
        }
        if( typeof frameHeight == "undefined"){
            frameHeight = w;
        }

        jQuery("a.use_fancybox").fancybox(
            {
                'hideOnContentClick': false , 'hideOnOverlayClick':false,
                'enableEscapeButton':true, 'autoDimensions' : false,
                'zoomSpeedIn': 300, 'zoomSpeedOut': 300,
                'overlayShow': true , 'frameWidth': frameWidth , 'frameHeight': frameHeight
            }
        );
    }

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
         
         jQuery("#accordion").accordion({ collapsible: true });
         initFancyBoxLinks(800, 600);
     }    
</script>