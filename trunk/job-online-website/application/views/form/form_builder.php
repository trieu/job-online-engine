<style type="text/css" media="screen">
    .draggable { width: 100%; height: 50px; padding: 0.5em; float: left; margin: 5px 5px 5px 0;cursor:move;background-color:lavender }
    #draggable { width: 60px; height: 50px; padding: 0.5em; float: left; margin: 5px 5px 5px 0;cursor:move;background-color:gray }
    #droppable { 
        width: 700px; height: 500px;
        padding: 0.5em; float: left;
        margin: 20px 10px 10px 10px;
        background-color:lavender!important;
        border:1px solid #FCEFA1;
    }
    #droppable div {
        margin: 5px 0px;
    }
    #droppable label {
        margin-right: 5px;
    }

    .table_dnd tr.myDragClass td {
        color: yellow!important;
        background-color: black!important;
    }
    .table_dnd tr.myHoverClass td {
        background:#FFFF99 none repeat scroll 0 0;
    }
    .table_dnd td.dragHandle {

    }
    .table_dnd td.showDragHandle {
        background-image: url(images/updown2.gif);
        background-repeat: no-repeat;
        background-position: center center;
        cursor: move;
    }
    .tDnD_whileDrag {
        background-color: #eee;
    }
    .table_dnd tr.alt td {
        background-color: #ecf6fc;
    }
    .table_dnd tr:hover {

    }
</style>

<div>
    <input type="button" value="Save" onclick="save_object_form()" />
    <input type="button" value="Cancel" onclick="" />
    <input type="button" value="Reset" onclick="reset_build_the_form()" style="margin-left:7px;" />
</div>
<div id="droppable" >
    <?= html_entity_decode($form_cache) ?>
</div>
<div style="float:right; width:186px;" >
    <?= $palette_content ?>
</div>

<div id="generic_dialog" title="Dialog Title" style="display:none" ></div>
<textarea id="save_form_dialog" name="" rows="4" cols="20" style="display:none" >
</textarea>

<script type="text/JavaScript" src="<?= base_url()?>assets/js/jquery/jquery.json.js"></script>
<script type="text/JavaScript" src="<?= base_url()?>assets/js/jquery.tablednd/jquery.tablednd.js"></script>
<script type="text/javascript">
    var dialog = false;

    var is_html_cache_changed = false;
    function save_object_form(){
        var data = {};
        data["Fields_Form_JSON"] = jQuery.toJSON(FormBuilderScript.data_fields);        
        data["ObjectClass"] = "<?= Form::$HTML_DOM_ID_PREFIX ?>";
        data["ObjectPK"] = <?= $form->getFormID(); ?>;
        data["CacheContent"] =  jQuery("#droppable").html();
        data["is_html_cache_changed"] = is_html_cache_changed;

        var uri = "<?= site_url("admin/admin_panel/saveFormBuilderResult") ?>";
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

        var uri = "<?= site_url("admin/admin_panel/reset_build_the_form") ?>";

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

        var callback = function(html){
            html = "<tr><td>"+html+"</td><td>#</td></tr>";
            if(jQuery("#droppable table").length == 0){
                jQuery("#droppable").html("<table cellspacing='0' cellpadding='2' class='table_dnd'></table>");
                jQuery("#droppable table").append(html);               
            }
            else {
                jQuery("#droppable table").append(html);
            }
            jQuery("#droppable table").tableDnD({
                onDragClass: "myDragClass",
                onDrop: function(table, row) {                   
                    is_html_cache_changed = true;
                },
                onDragStart: function(table, row) {
                }
            });
            jQuery("#droppable table tr:last").mouseover(function(){
                jQuery(this).addClass("myHoverClass");
            });
            jQuery("#droppable table tr:last").mouseout(function(){
                jQuery(this).removeClass("myHoverClass");
            });
            is_html_cache_changed = true;

            var record = {};
            record["FieldID"] = new Number(id);
            record["FormID"] = <?= $form->getFormID(); ?>;
            FormBuilderScript.data_fields.push(record);
        };
        jQuery.get(uri,{}, callback );
    }



    function initDragAndDrop(){
        jQuery(".draggable").draggable({helper:'clone'});
        jQuery("#droppable").droppable({
            drop: FormBuilderScript.dropHandler
        });
    }

    function makeSortableTable(){
        if(jQuery("#droppable table").length == 1){
            jQuery("#droppable table").tableDnD({
                onDragClass: "myDragClass",
                onDrop: function(table, row) {
                    is_html_cache_changed = true;
                },
                onDragStart: function(table, row) {

                }
            });
            jQuery("#droppable table tr").mouseover(function(){
                jQuery(this).addClass("myHoverClass");
            });
            jQuery("#droppable table tr").mouseout(function(){
                jQuery(this).removeClass("myHoverClass");
            });
        }
    }

    jQuery(document).ready(function() {        
        initDragAndDrop();
        makeSortableTable();  
    });
</script>