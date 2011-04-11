<?php
addScriptFile("js/jquery.fancybox/jquery.fancybox.min.js");
addCssFile("js/jquery.fancybox/jquery.fancybox.css");
addScriptFile("js/jquery.tablednd/jquery.tablednd.js");
addScriptFile("js/jquery/jquery.json.js");

addCssFile("js/jquery.ui.checklist/ui.dropdownchecklist.css");
addScriptFile("js/jquery.ui.checklist/ui.dropdownchecklist.js");
?>
<style type="text/css" media="screen">
    .resizable {       
        background-color: lavender;
        margin: 4px;
        height:auto;
    }
    #form_builder_container {
        border:1px solid #DDDDDD;
        min-height: 450px;
        width: 98%;
        padding: 5px; 
    }
    #form_builder_script {
        width: 98%;
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
    .form_builder_control {
        margin: 10px 0 0 11px;
    }
</style>

<strong>
<?php
foreach ($related_objects["processes"] as $proID => $proName) {
    echo "Process: ".$proName;
}
?>
</strong>

<div class="form_builder_control">
    <input type="button" value="Save" onclick="save_object_form()" />
    <input type="button" value="Cancel" onclick="history.back()" />
    <input type="button" value="Reset" onclick="reset_build_the_form()" style="margin-left:7px;" title="Clear and rebuild UI of Form" />
</div>

<table border="0">
    <thead>
        <tr>
            <th>Form: <?php echo $form->getFormName() ?></th>
            <th>Fields in Form</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td width="80%" style="vertical-align: top">
                <div>
                    <div id="form_builder_container" >
                        <?php
                            if(isset ($cache)){
                                echo html_entity_decode($cache->getCacheContent());
                            }
                         ?>
                    </div>
                    <div style="margin-top: 10px;">
                        <label for="form_builder_script"><b>JavaScript Content</b></label>
                        <?php
                            echo '<textarea id="form_builder_script" cols="80" rows="20">';
                            if(isset ($cache)){
                                echo ($cache->getJavascriptContent());
                            }
                            echo '</textarea>';
                        ?>              
                    </div>
                </div>
            </td>
            <td width="20%" style="vertical-align: top">
                <div id="list_field_form" >
                    <?php echo $palette_content ?>
                </div>
            </td>
        </tr>
    </tbody>
</table>


<script type="text/javascript">
    jQuery(document).ready(function() {
        autoBuildForm();       
    });

    function cleanFormGUIBeforeSubmit(){
        jQuery("#form_builder_container").find("input[type='text']").val("");
        jQuery(".hasDatepicker").removeClass("hasDatepicker");
    }

    var is_html_cache_changed = false;
    function save_object_form(){
        cleanFormGUIBeforeSubmit();

        var data = {};        
        data["ObjectClass"] = "<?php echo Form::$HTML_DOM_ID_PREFIX ?>";
        data["ObjectPK"] = <?php echo $form->getFormID() ?>;
        jQuery("#form_builder_container div[class='resizable ui-resizable']").each(function(){
            jQuery(this).removeAttr("class");
        });
        jQuery("#form_builder_container div[class*='ui-resizable-handle']").remove();
        data["CacheContent"] =  jQuery("#form_builder_container").html();
        data["JavascriptContent"] = jQuery.trim(jQuery("#form_builder_script").val());
        
        //auto-mapping field from DOM into fieldOrderArr array
        var FieldOrderList = [];
        jQuery("#form_builder_container").find("div[id*='wrapper_']").each(function(){
        var fieldId = jQuery(this).attr('id').replace('wrapper_field_','');
            FieldOrderList.push(fieldId);
        });
        data["FieldOrderList"] = jQuery.toJSON(FieldOrderList);

        var uri = "<?php echo site_url("admin/form_controller/saveFormBuilderResult") ?>";
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
        data["ObjectClass"] = "<?php echo Form::$HTML_DOM_ID_PREFIX ?>";
        data["ObjectPK"] = <?php echo $form->getFormID() ?>;
        var uri = "<?php echo site_url("admin/form_controller/reset_build_the_form") ?>";

        var callback =  function(id){
            var html = "";
            if(id > 0){
                html = "Reset form successfully!";                
                jQuery("#form_builder_container *").remove();
                jQuery("#form_builder_container").html("");
                jQuery("#form_builder_script").val("");
            }
            else{
                html = "Build form fail!";
            }
            alert(html);
            window.location.reload();
        };
        jQuery.post(uri, data, callback );
    }

    var field_form_num = 0;
    function autoBuildForm(){
        var uri = "<?php echo site_url("admin/field_controller/renderFieldUI") ?>/";
        field_form_num = jQuery("#form_builder_container > div").length;
        var must_build = jQuery("#list_field_form div[id*='<?php echo Field::$HTML_DOM_ID_PREFIX ?>']").length;

        if(field_form_num == must_build) {
            //enough, do not poke server            
            var sc = jQuery("#form_builder_script").val();
            jQuery("#form_builder_container").append( makeScriptTag(sc) );
            initCustomeFormUIMode();
        }
        else {
            var f = function(){
                var id = jQuery(this).attr("id").replace("<?php echo Field::$HTML_DOM_ID_PREFIX ?>","");
                var callback = function(html){
                    html = "<div class='resizable'>" + html + "</div>";
                    var sc = findScriptInHTML(html);
                    if(sc != ""){
                        var scBuilder = jQuery("#form_builder_script");
                        sc += scBuilder.val();
                        scBuilder.val(sc);
                        jQuery("#form_builder_container").append(html).append( makeScriptTag(sc) );
                    } else {
                        jQuery("#form_builder_container").append(html);
                    }
                    
                    field_form_num = field_form_num + 1;
                    if(field_form_num == must_build) {
                        initCustomeFormUIMode();
                    }                    
                };
                jQuery.get( uri + id ,{}, callback );
            };
            jQuery("#list_field_form div[id*='<?php echo Field::$HTML_DOM_ID_PREFIX ?>']").each(f);
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

