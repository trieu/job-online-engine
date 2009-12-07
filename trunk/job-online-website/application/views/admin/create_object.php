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
    <form id="create_object_instance_form" action="<?= site_url("admin/object_controller/save/".$object_class->getObjectClassID()) ?>" accept="utf-8" method="post">
        <?php
        if(isset ($objectCacheHTML['cacheContent'])) {
            echo html_entity_decode($objectCacheHTML['cacheContent']);
        }
        ?>
        <input type="submit" value="OK" />
        <input type="button" value="Cancel" />
    </form>
</fieldset>

<script type="text/javascript">
     jQuery(document).ready(function(){
        jQuery("#create_object_instance_form").submit(function(){
            var ids = "";
            jQuery("#data_suggestion_container p[class^='token-']").each(function(){
                ids += (jQuery(this).attr("class").replace("token-","") + "&");
            });
            jQuery("#form_details input[name='ProcessIDs']").val(ids);
        });
     });
</script>
