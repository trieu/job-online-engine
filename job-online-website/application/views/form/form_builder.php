<style type="text/css" media="screen">
    .draggable { width: 100%; height: 50px; padding: 0.5em; float: left; margin: 5px 5px 5px 0;cursor:move;background-color:lavender }
    #draggable { width: 60px; height: 50px; padding: 0.5em; float: left; margin: 5px 5px 5px 0;cursor:move;background-color:gray }
    #droppable { width: 700px; height: 500px; padding: 0.5em; float: left; margin: 10px; background-color:lavender!important; border:1px solid #FCEFA1;}
    #droppable div {
        margin: 5px 0px;
    }
    #droppable label {
        margin-right: 5px;
    }
</style>

<div style="visibility: hidden; position: absolute; left: 0px; top: 250px; z-index: 20; width: 180px;display:none" id="basessm">
    <div onmouseout="" onmouseover="" style="position: absolute; left: 0px; top: 100pt; z-index: 20; visibility: visible;" id="thessm">
        <?= $palette_content ?>
    </div>
</div>

<div>
    <input type="button" value="Save" onclick="save_object_form()" />
    <input type="button" value="Cancel" onclick="" />
    <input type="button" value="Reset" onclick="reset_build_the_form()" style="margin-left:7px;" />
</div>

<div id="droppable" class="" >
    <?= html_entity_decode($form_cache) ?>
</div>
<div style="float:right; width:186px;" >
    <?= $palette_content ?>    
</div>

<div id="generic_dialog" title="Dialog Title" style="display:none" ></div>

<textarea id="save_form_dialog" name="" rows="4" cols="20" style="display:none" >

</textarea>

<script language="JavaScript" src="<?= base_url()?>assets/js/jquery/jquery.json.js"></script>
<script type="text/javascript">
    var dialog = false;

    function save_object_form(){
        var data = {};
        data["Fields_Form_JSON"] = jQuery.toJSON(FormBuilderScript.data_fields);        
        data["ObjectClass"] = "<?= Form::$HTML_DOM_ID_PREFIX ?>";
        data["ObjectPK"] = <?= $form->getFormID(); ?>;
        data["CacheContent"] =  jQuery("#droppable").html();

        var uri = "<?= site_url("admin/admin_panel/saveFormBuilderResult") ?>";
        jQuery.post(uri, data,
            function(id){
                var html = "";
                if(id > 0){
                    html = "Build form successfully!";
                }
                else  if(id == -100){
                    html = "You have not changed form, so nothing to update!";
                }
                else{
                    html = "Build form fail!";
                }
                show_dialog(html);
            }
        );
    }

    function reset_build_the_form(){
        var data = {};        
        data["ObjectClass"] = "<?= Form::$HTML_DOM_ID_PREFIX ?>";
        data["ObjectPK"] = <?= $form->getFormID(); ?>;      

        var uri = "<?= site_url("admin/admin_panel/reset_build_the_form") ?>";
        jQuery.post(uri, data,
            function(id){
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
            }
        );
    }

    function show_dialog(content){
        if(content == null) { content = ""; }
        var opts = {};
        opts["modal"] = true;
        //        opts["open"] = function(event, ui)
        //        {
        //            jQuery(this).append("kk");
        //        };
        if(!dialog){
            dialog = jQuery("#generic_dialog").dialog(opts);
            jQuery(dialog).html("<div>"+content+"</div>");
        }
        else {
            jQuery(dialog).dialog( 'open' );          
            jQuery(dialog).html("<div>"+content+"</div>");
        }        
    }

    function initPalette(){
        var left = jQuery(window).width() - jQuery("#basessm").width() - 25;
        jQuery('#basessm').css("left",left+"px");
        jQuery(window).scroll(function()
        {
            jQuery('#basessm').animate({top:jQuery(window).scrollTop()+"px" },{queue: false, duration: 350});
        });
    }

    var FormBuilderScript = new Object();
    FormBuilderScript.data_fields = [];
    FormBuilderScript.dropHandler = function(event, ui) {
        var id = jQuery(ui.draggable).find("div[id*='<?= Field::$HTML_DOM_ID_PREFIX ?>']").attr("id").replace("<?= Field::$HTML_DOM_ID_PREFIX ?>","");
        var uri = "<?= site_url("admin/admin_panel/renderFieldUI") ?>/" + id;
        jQuery.get(uri, {},
        function(html){
            jQuery("#droppable").append(html);

            var record = {};
            record["FieldID"] = new Number(id);
            record["FormID"] = <?= $form->getFormID(); ?>;
            FormBuilderScript.data_fields.push(record);
        }
    );
    }

    function initDragAndDrop(){
        jQuery(".draggable").draggable({helper:'clone'});
        jQuery("#droppable").droppable({
            drop: FormBuilderScript.dropHandler
        });
    }

    jQuery(document).ready(function() {
        //initPalette();
        initDragAndDrop();
    });
</script>
