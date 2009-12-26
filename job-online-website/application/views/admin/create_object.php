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

<?php
// $object_class = new ObjectClass();
$legend_text = "";
foreach ($object_class->getUsableProcesses() as $pro) {
    $legend_text .= $pro->getProcessName();
    break;
}
?>

<script type="text/javascript">
     jQuery(document).ready(initFormData);

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
     }


</script>

<h3><?= $object_class->getObjectClassName() ?></h3>
<div id="accordion">
	<h3><a href="#"><?= $legend_text ?></a></h3>
	<div>
            <div class="input_info">
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

	<h3><a href="#">Section 2</a></h3>
	<div>
            <p>
            Sed non urna.
            </p>
	</div>

	<h3><a href="#">Section 3</a></h3>
	<div>
            <p>
            Nam enim risu
            </p>
	</div>	
</div>

