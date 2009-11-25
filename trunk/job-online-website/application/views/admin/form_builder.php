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
        height:30px;
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
    <?= html_entity_decode($form_cache) ?>
    <div class="resizable">
        Resizable1        
    </div>
    <div class="resizable">
        Resizable2
      
    </div>
    <div class="resizable">
        Resizable3
       
    </div>
    <div class="resizable">
        Resizable4       
    </div>
</div>

<div style="float:right; width:186px;" >
    <?= $palette_content ?>
</div>

<script type="text/javascript">
    jQuery(document).ready(function() {
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
        jQuery("#form_builder_container div.resizable").resizable(resizeOpts);
    });

    var is_html_cache_changed = false;
    function save_object_form(){
        var data = {};
        data["Fields_Form_JSON"] = jQuery.toJSON(FormBuilderScript.data_fields);
        data["ObjectClass"] = "<?= Form::$HTML_DOM_ID_PREFIX ?>";
        data["ObjectPK"] = <?= $form->getFormID();?>;
        data["CacheContent"] =  jQuery("#droppable").html();
        data["is_html_cache_changed"] = is_html_cache_changed;

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
            show_dialog(html);
        };
        jQuery.post(uri, data, callback );
    }

    function reset_build_the_form(){
        var data = {};
        data["ObjectClass"] = "<?= Form::$HTML_DOM_ID_PREFIX ?>";
        data["ObjectPK"] = <?= $form->getFormID(); ?>;

        var uri = "<?= site_url("admin/form_controller/reset_build_the_form") ?>";

        var callback =  function(id){
            var html = "";
            if(id > 0){
                html = "Reset form successfully!";
                FormBuilderScript.data_fields = [];
                jQuery("#droppable *").remove();
                jQuery("#droppable").html("");
            }
            else{
                html = "Build form fail!";
            }
            show_dialog(html);
        };
        jQuery.post(uri, data, callback );
    }
</script>

