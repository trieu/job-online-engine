<?php
addScriptFile("js/jquery.fancybox/jquery.fancybox.min.js");
addCssFile("js/jquery.fancybox/jquery.fancybox.css");
addScriptFile("js/jquery.tablednd/jquery.tablednd.js");
addScriptFile("js/jquery/jquery.json.js");
?>
<style type="text/css" media="screen">
    .resizable {       
        background-color: lavender;
        margin: 4px;
        height:auto;
    }
    #form_builder_container {
        border:1px solid #DDDDDD;
        clear:right;
        height:500px;
        overflow:auto;
        position:relative;
        width:700px;
        margin: 20px 10px 10px 10px;
        padding: 5px; float: left;
    }

    #form_builder_container div {
        margin: 5px 0px;
    }
    #form_builder_container label {
        margin-right: 5px;
    }

    #fancy_outer {
        z-index: 1100 !important;
    }
</style>

<div>
    <input type="button" value="Save" onclick="save_object_form()" />
    <input type="button" value="Cancel" onclick="history.back()" />
    <input type="button" value="Reset" onclick="reset_build_the_form()" style="margin-left:7px;" />
</div>

<div id="form_builder_container" >
    <?= html_entity_decode($cache->getCacheContent()) ?>
</div>

<div id="list_field_form" style="float:right; width:186px;" >
    <?= $palette_content ?>
</div>

<script type="text/javascript">
    jQuery(document).ready(function() {
        autoBuildForm();       
    });

    var is_html_cache_changed = false;
    function save_object_form(){
        var data = {};        
        data["ObjectClass"] = "<?= Form::$HTML_DOM_ID_PREFIX ?>";
        data["ObjectPK"] = <?= $form->getFormID() ?>;
        jQuery("#form_builder_container div[class='resizable ui-resizable']").each(function(){
            jQuery(this).removeAttr("class");
        });
        jQuery("#form_builder_container div[class*='ui-resizable-handle']").remove();
        data["CacheContent"] =  jQuery("#form_builder_container").html();
        data["JavascriptContent"] = "";

        var uri = "<?= site_url("admin/form_controller/saveFormBuilderResult") ?>";
        var callback =  function(id){
            var html = "";
            if(id > 0){
                html = "Build form successfully!";                
                is_html_cache_changed = false;                
            }
            else  if(id == -100){
                html = "You have not changed form, so nothing to update!";
            }
            else{
                html = "Build form fail!";
            }
            alert(html);
            setTimeout( function(){ location.reload(); } , 1000);
        };
        jQuery.post(uri, data, callback );
    }

    function reset_build_the_form(){
        var data = {};
        data["ObjectClass"] = "<?= Form::$HTML_DOM_ID_PREFIX ?>";
        data["ObjectPK"] = <?= $form->getFormID() ?>;
        var uri = "<?= site_url("admin/form_controller/reset_build_the_form") ?>";

        var callback =  function(id){
            var html = "";
            if(id > 0){
                html = "Reset form successfully!";                
                jQuery("#form_builder_container *").remove();
                jQuery("#form_builder_container").html("");
            }
            else{
                html = "Build form fail!";
            }
            alert(html);
        };
        jQuery.post(uri, data, callback );
    }

    var field_form_num = 0;
    function autoBuildForm(){
        var uri = "<?= site_url("admin/field_controller/renderFieldUI") ?>/";
        field_form_num = jQuery("#form_builder_container > div").length;
        var must_build = jQuery("#list_field_form div[id*='<?= Field::$HTML_DOM_ID_PREFIX ?>']").length;

        if(field_form_num == must_build) {
            initCustomeFormUIMode();
        }
        else {
            var f = function(){
                var id = jQuery(this).attr("id").replace("<?= Field::$HTML_DOM_ID_PREFIX ?>","");
                var callback = function(html){
                    html = "<div class='resizable'>" + html + "</div>";
                    jQuery("#form_builder_container").append(html);
                    field_form_num = field_form_num + 1;
                    if(field_form_num == must_build) {
                        initCustomeFormUIMode();
                    }
                };
                jQuery.get( uri + id ,{}, callback );
            };
            jQuery("#list_field_form div[id*='<?= Field::$HTML_DOM_ID_PREFIX ?>']").each(f);
        }
    }

    function initCustomeFormUIMode() {
        var sortOpts = {
            axis: "y",
            containment: '#form_builder_container',
            cursor: "move",
            distance: 3
        };
        jQuery("#form_builder_container").sortable(sortOpts);

        var resizeOpts = {
            maxWidth : 700 - 5 ,
            maxHeight: 800 ,
            minHeight: 40,
            minWidth : 60
        };
        jQuery("#form_builder_container > div").each(function(){
            jQuery(this).addClass("resizable");
        });
        jQuery("#form_builder_container > div").resizable(resizeOpts);
    }
</script>

