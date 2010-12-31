<?php
addScriptFile("js/jquery/jquery.form.js");
addScriptFile("js/jquery/jquery.json.js");
addScriptFile("js/jquery/jquery.jeditable.js");

require_once 'macros.php';
?>

<style type="text/css">
    fieldset { border:1px solid green; margin: 12px 5px 5px 5px; }
    legend {
        padding: 0.2em 0.5em;
        border:1px solid blue;
        color:blue;
        font-size:90%;
        text-align:right;
        font-weight: bold;
    }
    fieldset > div > div {
        margin: 9px 0;
    }
    .odd_row_field {
        background:silver none repeat scroll 0 0;
        padding-bottom: 5px;
    }
    .even_row_field {
        background:lavender none repeat scroll 0 0;
        padding-bottom: 5px;
    }
    .ui-draggable { cursor: pointer!important; }
    .ui-draggable:hover {background-color: greenyellow!important;  }
    .ui-sortable li  { cursor: pointer!important; }
    .ui-sortable li:hover  { background-color: greenyellow!important; color:red; }

    .drap_holder { border: 2px solid #555555; color:red; display:inline; }
    .field_list li {  border: 2px solid #555555; }

    .drap_active { border: #ffcc00 solid 2px !important; background-color: greenyellow; }
    .drap_hover { background-color: coral; }
    .drop_holder { border: 2px solid #555555; color:red; }
</style>

<fieldset>
    <legend>1) Set up the Index for Matching Engine</legend>
    <div style="margin: 27px 5px 10px">
        <input type="radio" checked name="index_as_new" value="true" /> Create new Index for All Objects <br>
        <input type="radio" name="index_as_new" value="false" /> Update incrementally the index for All Objects: <br>
        <div style="float: right">
            <input type="button" value="Do indexing all objects" onclick="index_all_objects()" />
        </div>

        <div id="index_all_objects_working" style="display: none; font-weight: bold; font-size: 17px;">Working ...</div>
        <div id="index_all_objects_result"></div>
    </div>
</fieldset>

<fieldset>
    <legend>2) Mapping The Class Structure</legend>
    <div style="margin: 27px 5px 10px">
        <div>
            <label for="ObjectClassID" class="vietnamese_english" >Đối tượng quản lý / Business Object: </label>
            <select name="ObjectClassID" id="ObjectClassID" onchange="updateClassList();" ></select>
        </div>        
        <div>
            <label for="ProcessID" class="vietnamese_english" >Quy trình xử lý thông tin / Process: </label>
            <select name="ProcessID" id="ProcessID" onchange="populateForms()" ></select>
        </div>
        <div>
            <label for="FormID" class="vietnamese_english" >Form dữ liệu / Form : </label>
            <select name="FormID" id="FormID" onchange="populateFields()"></select>
        </div>
        <div id="field_list_view" >
            <div class="ajax_loader display_none" ></div>
            <table border="0" width="100%">
                <thead>
                    <tr>
                        <th class="vietnamese_english" >Danh sách trường dữ liệu / Field List</th>
                        <th class="vietnamese_english" colspan="2" >Matching Structure / Query Details</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="width:24%;vertical-align:top;">
                            <div style="margin-bottom: 20px;">
                                <div class="vietnamese_english">Current Class Name:</div>
                                <div id="ClassHolder" class="drap_holder" style="height: 25px; width: 250px;" ></div>
                            </div>
                            <div class="content" ></div>
                        </td>
                        <td style="width:38%; vertical-align:top;">
                            <div id="BaseClass">
                                <h4 class="ui-widget-header">Base Class</h4>
                                <div class="ui-widget-content">
                                    <div id="BaseClassName" class_id="0" class="drop_holder" style="height: 25px; width: 250px;" >Base Class Name</div>
                                    <ol id="BaseClassFields" class="field_list" mode="insert" >
                                        <li class="placeholder">Add base fields here</li>
                                    </ol>
                                </div>
                            </div>
                        </td>
                        <td style="width:38%;vertical-align:top;">
                            <div id="MatchedClass">
                                <h4 class="ui-widget-header">Matched Class</h4>
                                <div class="ui-widget-content">
                                    <div id="MatchedClassName" class_id="0" class="drop_holder" style="height: 25px; width: 250px;" >Matched Class Name</div>
                                    <ol id="MatchedClassFields" class="field_list" mode="insert" >
                                        <li class="placeholder">Add matched fields here</li>
                                    </ol>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div style="float: right">
            <input type="button" value="Save matched Structure" onclick="doSaveMatchedStructure()" />
            <input type="button" value="Clear Structure" onclick="doResetMatchedStructure()" />
        </div>
    </div>
</fieldset>


<textarea style="display: none;" name="" rows="4" cols="20" onselect="selectedTextHandler(this)">Update incrementall</textarea>

<?php jsMetaObjectScript(); ?>
<script  type="text/javascript">
    function selectedTextHandler(myArea){
        if (typeof(myArea.selectionStart) != "undefined") {            
            var selection = myArea.value.substr(myArea.selectionStart, myArea.selectionEnd - myArea.selectionStart);            
            alert(selection);
        }
    }

    function index_all_objects(){
        var callback = function(html){
            jQuery("#index_all_objects_result").html(html);
            jQuery("#index_all_objects_working").hide();
        };
        var url = "<?php echo site_url('admin/search_indexer/index_all_objects/') ?>";
        var index_as_new = jQuery("input[name='index_as_new']:checked").val();
        url += ("/"+index_as_new);
        jQuery.get(url , {}, callback);
        jQuery("#index_all_objects_working").show();
    }

    function populateFields(){
        var val = jQuery("#FormID").val();
        if(val == null){
            alert("Please select a form for loading fields");
        }
        var url = "<?php echo site_url("admin/search/populate_query_helper") ?>";
        var filter =  {what: "<?php echo search::$FIELD_HINT ?>" , filterID: val};
        var handler =  function(html){
            jQuery("#field_list_view .content").html( html );
            jQuery("#field_list_view .ajax_loader").hide();

            jQuery("#field_list_view .content").find("a").remove();
            jQuery("#field_list_view div.draggable").draggable({helper:'clone'});
        };
        jQuery("#field_list_view .ajax_loader").show();
        jQuery.post(url, filter, handler);
    }

    function updateClassList(){
        populateProcesses();

        var ClassHolder = jQuery("#ClassHolder");
        var selectedClass = jQuery("#ObjectClassID").find("option:selected");
        ClassHolder.html(selectedClass.html());
        ClassHolder.attr("class_id" , selectedClass.val());
    }

    jQuery(document).ready(function(){
        var ClassHolder = jQuery("#ClassHolder");
        ClassHolder.draggable({helper:'clone'});

        populateClasses(function(){
            var selectedClass = jQuery("#ObjectClassID").find("option:selected");
            ClassHolder.html(selectedClass.html());
            ClassHolder.attr("class_id" , selectedClass.val());
        });

        var ClassNameDropHandler = function(event, ui) {
            if(jQuery(ui.draggable).hasClass("drap_holder")){
                var class_id = jQuery(ui.draggable).attr("class_id");
                jQuery(this).attr("class_id" , class_id );
                var newText = jQuery.trim(jQuery(ui.draggable).text());
                jQuery(this).html(newText);
                doLoadMatchedStructure();
            }
        };
        var ClassFieldsDropHandler = function(event, ui) {
            var classId = jQuery(this).prev("div[class_id]").attr("class_id");
            var isFieldInClass = ClassHolder.attr("class_id") == classId;
            var field_id = jQuery(ui.draggable).find("div[id*='field_']").attr("id");
            var notHasField = ! (jQuery(this).find("li[field_id='" + field_id + "']").length > 0);
            var isValidNode = ! jQuery(ui.draggable).hasClass("drap_holder");
            isValidNode = isValidNode && (jQuery(ui.draggable).attr("class").indexOf("sortable") < 0);

            if( isValidNode && isFieldInClass && notHasField ){
                jQuery(this).find(".placeholder").slideUp("slow", function(){ jQuery(this).remove(); });
                jQuery("<li></li>").text(ui.draggable.text()).attr("field_id",field_id).appendTo(this);
            }
        };

        jQuery("#BaseClassName").droppable({
            activeClass: "drap_active",
            hoverClass: "drap_hover",
            accept: ".drap_holder",
            drop: ClassNameDropHandler
        });
        jQuery("#BaseClassFields").droppable({
            activeClass: "drap_active",
            hoverClass: "drap_hover",
            accept: ":not(.drap_holder)",
            drop: ClassFieldsDropHandler
        }).sortable({
            items: "li:not(.placeholder)",
            sort: function() {
                jQuery(this).removeClass("ui-state-default");
            }
        });

        jQuery("#MatchedClassName").droppable({
            activeClass: "drap_active",
            hoverClass: "drap_hover",
            accept: ".drap_holder",
            drop: ClassNameDropHandler
        });
        jQuery("#MatchedClassFields").droppable({
            activeClass: "drap_active",
            hoverClass: "drap_hover",
            accept: ":not(.drap_holder)",
            drop: ClassFieldsDropHandler
        }).sortable({
            items: "li:not(.placeholder)",
            sort: function() {               
                jQuery(this).removeClass("ui-state-default");
            }
        });
    });

    function getMatchedStructure() {
        var matchStructure = {BaseClassID: '0', MatchedClassID: '0', MatchedStructure: ""};
        matchStructure.BaseClassID = (jQuery("#BaseClassName").attr("class_id"));
        matchStructure.MatchedClassID = (jQuery("#MatchedClassName").attr("class_id"));

        var Structure = {};
        var MatchedClassFields = jQuery("#MatchedClassFields");
        jQuery("#BaseClassFields").find("li:not(.placeholder)").each(
            function(i,e){
                var baseFieldId = jQuery(e).attr("field_id").replace("field_", "");
                i++;
                var matchedField = MatchedClassFields.find("li:nth-child("+i+")");
                if(matchedField.length == 1){
                    var matchedFieldId = matchedField.attr("field_id").replace("field_", "");
                    Structure[baseFieldId] = matchedFieldId;
                }
            }
        );
        matchStructure.MatchedStructure = jQuery.toJSON(Structure);
        return matchStructure;
    };

    function doSaveMatchedStructure() {
        var data = getMatchedStructure();
        var url = "<?php echo site_url('admin/search_indexer/save_matched_class_structure/') ?>";
        if(jQuery("#BaseClassFields").attr("mode") == "update" && jQuery("#MatchedClassFields").attr("mode") == "update") {
            url += '/update';
        }
        var callback = function(rs){
            alert(rs);
        };
        jQuery.post(url, data, callback);
    }

    function doResetMatchedStructure() {
        jQuery("#BaseClassName").attr("class_id","0").html("Base Class Name");
        jQuery("#MatchedClassName").attr("class_id","0").html("Matched Class Name");

        jQuery("#BaseClassFields").find("li:not(.placeholder)").remove();
        jQuery("#BaseClassFields").html('<li class="placeholder">Add base fields here</li>');

        jQuery("#MatchedClassFields").find("li:not(.placeholder)").remove();
        jQuery("#MatchedClassFields").html('<li class="placeholder">Add matched fields here</li>');
    }
    
    function doLoadMatchedStructure() {
        var url = "<?php echo site_url('admin/search_indexer/load_matched_class_structure/') ?>";
        var callback = function(json){
            var list = jQuery.evalJSON(json);
            if(list.length == 1){
                var MatchedStructure = jQuery.evalJSON(list[0].MatchedStructure);                
                var arr_ids = [];
                for(var k in MatchedStructure){
                    arr_ids.push(k);
                    arr_ids.push(MatchedStructure[k]);
                }
                var getFieldUrl = "<?php echo site_url('admin/field_controller/getFieldNamesByIDs/') ?>";
                var getFieldHandler = function(rs2){
                    var field_map = jQuery.evalJSON(rs2);
                    var Bnode = jQuery("#BaseClassFields");
                    var Mnode = jQuery("#MatchedClassFields");
                    jQuery(Bnode).find("li").slideUp("slow", function(){ jQuery(this).remove(); });
                    jQuery(Mnode).find("li").slideUp("slow", function(){ jQuery(this).remove(); });

                    for(var k in MatchedStructure){
                        var base_field_id = k;
                        var matched_field_id = MatchedStructure[k];
                        var bfnode = '<li field_id="'+ base_field_id + '">'+ field_map[base_field_id] +'</li>';
                        var mfnode = '<li field_id="'+ matched_field_id + '">'+ field_map[matched_field_id] +'</li>';                        
                        Bnode.append(bfnode);
                        Mnode.append(mfnode);
                    }
                    Bnode.attr("mode", "update");
                    Mnode.attr("mode", "update");
                };
                jQuery.post(getFieldUrl, {'array_ids': jQuery.toJSON(arr_ids) }, getFieldHandler);
            }
        };
        var n1 = jQuery("#BaseClassName").attr("class_id");
        var n2 = jQuery("#MatchedClassName").attr("class_id");
        if(n1 != "0" && n2 != "0" ) {
            var data = {'BaseClassID' : n1, 'MatchedClassID' : n2};
            jQuery.post(url, data, callback);
        }        
    }
</script>