<?php
addScriptFile("js/jquery/jquery.form.js");
addScriptFile("js/jquery/jquery.json.js");
addScriptFile("js/jquery/jquery.jeditable.js");

//jquery.jqplot
addCssFile("js/jquery.jqplot/jquery.jqplot.css");
addScriptFile("js/jquery.jqplot/jquery.jqplot.min.js");
addScriptFile("js/jquery.jqplot/plugins/jqplot.pieRenderer.js");
addScriptFile("js/jquery.jqplot/plugins/jqplot.trendline.js");

require_once 'macros.php';
?>
<style type="text/css"> 
    .query_question > div{
        margin-top:6px;
        padding: 1px 5px 1px 5px;
        display: block;
        position:relative;
        width: 100%;
    }
    .input_info label {
        margin-right:5px;
        font-weight:bold;
    }
    .input_info form > div {
        margin-top: 5px;
    }
    fieldset div {
        margin-top:5px;
        margin-bottom:5px;
    }
    .input_info{
        border:thin solid!important;
    }
    .input_info legend {
        font-weight:bold;
        font-size: 14px;
    }
    .odd_row_field {
        background:silver none repeat scroll 0 0;        
        padding-bottom: 5px;
    }
    .even_row_field {
        background:lavender none repeat scroll 0 0;        
        padding-bottom: 5px;
    }
    #searched_field_form {
        width:98%; margin: 0 6px 0 4px; border:1px solid gray;padding-left: 5px;
    }
    #field_list_view {
        display:block; clear:both; 
    }
    .statistical_field_query{
        font-weight: bold;
    }
    #ObjectClassID {
        position: absolute; left: 200px;
    }
    #ProcessID {
        position: absolute; left: 200px;
    }
    #FormID {
        position: absolute; left: 200px;
    }
    .query_detail_wrapper {
        margin-top:5px; padding: 5px;
        font-weight:bold;
        border: 1px solid #f00; background: #ffc;
    }
    .query_detail_wrapper .query_detail_name {
        margin-left: 10px;
        font-family:'Lucida Grande',Tahoma,Verdana,Arial,sans-serif;
        font-size:16px; font-weight:bold;
        color: #f00;
    }
    .remove_query_field_handler {        
        float: right; font-size:16px; font-weight:bold; color: #f00;
    }
    #searched_field_form > select{
        color:red; font-size:15px; font-weight:bold;   margin:16px 0 16px 40%;  
    }   
</style>


<fieldset class="input_info" style="margin-top: 10px;">
    <legend class="vietnamese_english" >Form tìm kiếm thông tin - Thống kê / Form for Information Retrieval - Statistics</legend>
    <?php
    if(isset ($the_query_details)){
        $text = '<div class="query_detail_wrapper" >';
        $text .= '<span class="vietnamese_english query_detail_label" > Tên câu truy vấn dữ liệu:/Name of query:</span>';
        $text .= '<span class="vietnamese_english query_detail_name editable_text" id="query_filters-'.$the_query_details->id.'-query_name">'.$the_query_details->query_name.'</span>';
        $text .= '</div>';
        echo $text;
        //echo $the_query_details->query_details;
    }
    ?>
    <form id="query_builder_form" action="<?= site_url("admin/search/do_search")?>" accept="utf-8" method="post">
        <div class="query_question" >            
            <div>
                <label for="ObjectClassID" class="vietnamese_english" >Đối tượng quản lý / Business Object: </label>
                <select name="ObjectClassID" id="ObjectClassID" onchange="populateProcesses()" > </select>
            </div>
            <div>
                <label for="ProcessID" class="vietnamese_english" >Quy trình xử lý thông tin / Process: </label>
                <select name="ProcessID" id="ProcessID" onchange="populateForms()" ></select>
            </div>
            <div>
                <label for="FormID" class="vietnamese_english" >Form dữ liệu / Form : </label>
                <select name="FormID" id="FormID" onchange="populateFields()"></select>
            </div>
            <div id="statistics_setting">
                 <div>
                    <b class="vietnamese_english" > Sử dụng báo cáo thống kế /Use Statistics ?</b>
                    <input id="statistics_mode_true" type="radio" name="statistics_mode" value="true" onchange="setStatisticsMode(this)"/>
                    <label for="statistics_mode_true" class="vietnamese_english" >Đồng ý / Yes</label>
                    <input id="statistics_mode_false" type="radio" name="statistics_mode" value="false" onchange="setStatisticsMode(this)"/>
                    <label for="statistics_mode_false" class="vietnamese_english">Không / No</label>
                </div>
            </div>
            <div>
                <div id="question_holder_csv_export" style="margin-top: 8px;">
                    <b class="vietnamese_english"> Xuất dữ liệu cho Excel / CSV Export for Excel ?</b>
                    <input id="csv_export_true" type="radio" name="csv_export" value="true" />
                    <label for="csv_export_true" class="vietnamese_english" >Đồng ý / Yes</label>
                    <input id="csv_export_false" type="radio" name="csv_export" value="false" checked="true"/>
                    <label for="csv_export_false" class="vietnamese_english">Không / No</label>
                </div>
                <div>
                    <b><a href="javascript:void(0)" onclick="toggleFieldList(this)">Hide</a></b>
                </div>
            </div> 
            <div id="field_list_view" >
                <div class="ajax_loader display_none" ></div>
                <table border="0" width="100%">
                    <thead>
                        <tr>
                            <th class="vietnamese_english" >Danh sách trường dữ liệu / Field List</th>
                            <th class="vietnamese_english" >Chi tiết tìm kiếm / Query Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="width:25%;vertical-align:top;">
                                <div style="display: none;">
                                    <input style="width:95%" id="searched_field_hint_filter" type="text" name="" value="" />
                                </div>
                                <div class="content" ></div>
                            </td>
                            <td style="width:75%; vertical-align:top;">
                                <div id="searched_field_form" ></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div style="text-align: center;">
            <input type="submit" title="Search" value="Search" />
            <input type="button" title="Save this query to database" value="Save this query" onclick="saveSearchQueryObj()" />
            <input type="button" title="Reload this query" value="Reload" onclick="location.reload()" />
            <input type="button" value="Cancel" onclick="history.back()" />
        </div>
    </form>
</fieldset>

<a name="query_search_results" href="#query_search_results"></a>
<div id="query_search_results" style="margin-top: 10px;">
    <div class="ajax_loader display_none" ></div>
    <div class="content" ></div>    
</div>
<div id="statistics_diagram_list" style="margin-top: 5px"></div>

<div id="query_operator_tpl" class="display_none" >
    <select id="@=name@">
        <option selected="selected" >AND</option>
        <option  >OR</option>        
    </select>
</div>

<?php jsMetaObjectScript(); ?>
<script type="text/javascript">
    var afterInitFormCallback = [];

    function toggleFieldList(node){
        var th = jQuery("#field_list_view").find("table th:first");
        var td = jQuery("#field_list_view").find("table td:first");
        var val = jQuery(node).html();
        if(val.search("Hide") >= 0){
            val = val.replace("Hide", "Show")
            th.hide();
            td.hide();
        }
        else {
            val = val.replace("Show", "Hide")
            th.show();
            td.show();
        }
        jQuery(node).html(val);
    }
   

    function populateFields(){
        var val = jQuery("#FormID").val();
        if(val == null){
            alert("Please select a form for loading fields");
        }
        var url = "<?= site_url("admin/search/populate_query_helper")?>";
        var filter =  {what: "<?= search::$FIELD_HINT ?>" , filterID: val};
        var handler =  function(html){
            jQuery("#field_list_view .content").html( html );
            
            if( jQuery("#statistics_mode_true:checked").length == 1 ) {
                jQuery("#field_list_view").find("table td .draggable").hide();
                jQuery("#field_list_view").find("table td .selectable_field").show();
            }

            jQuery("#field_list_view .ajax_loader").hide();
            jQuery(afterInitFormCallback).each(function(){ if(this instanceof Function) this.apply({}, []); });
        };
        jQuery("#field_list_view .ajax_loader").show();
        jQuery.post(url, filter, handler);
    }

    function selectSearchedField(fieldID,fieldtypeID, callbackAfterDone){
        if( jQuery("#statistics_mode_true:checked").length == 1 ) {
             var field_content = jQuery("#field_" + fieldID).attr("title");
             var html = "<div class='statistical_field_query' id='statistical_field_[fieldID]' fieldtypeid=[fieldtypeID]>" + field_content + "</div>";
             html = html.replace("[fieldID]", fieldID);
             html = html.replace("[fieldtypeID]", fieldtypeID);
             jQuery("#searched_field_form").append(html);
             jQuery("#field_" + fieldID).hide();
        }
        else {
            if( jQuery("#searched_field_form").find("#field_"+fieldID).length > 0)
                return;
            var uri = "<?= site_url("admin/field_controller/renderFieldUI") ?>/" + fieldID;
            var callback = function(html){
                if(jQuery("#searched_field_form").find("div").length > 0){
                    var operator = jQuery("#query_operator_tpl").html().replace("@=name@", "operator_f_"+ fieldID);
                    jQuery("#searched_field_form").append(operator);
                }
                jQuery("#searched_field_form").append(html);
                if(callbackAfterDone instanceof Function){
                    callbackAfterDone.apply({},[]);
                }
                var fieldWrapper = jQuery("#searched_field_form > div:last");
                var operatorNode = fieldWrapper.prev("select");
                fieldWrapper.addClass("editable_text");
                fieldWrapper.append('<a class="remove_query_field_handler" href="javascript:" title="Remove this field">X</a>');
                fieldWrapper.find("a.remove_query_field_handler").click(function(){
                   fieldWrapper.remove();
                   if(operatorNode.length > 0){
                       operatorNode.remove();
                   }
                });               
            };
            jQuery.get( uri ,{}, callback );
        }
    }

     var initSearchQuery = function(formData, jqForm, options) {
            GUI.toggletVisible("#query_search_results .content");
            var data = {};
            var query_fields = [];
            for(var i in formData){
                var kv = formData[i];
                if(kv.name.indexOf("field_") == 0){
                    kv.type = jQuery("#query_builder_form").find("*[name='"+ kv.name +"'][value='"+ kv.value +"']").attr("type");
                    kv.name = kv.name.replace("field_", "");
                    if( jQuery("#operator_f_" + kv.name).length > 0 )
                        kv.operator = jQuery("#operator_f_" + kv.name).val();
                    else
                        kv.operator = "";
                    query_fields.push(kv);
                }
                else {
                    data[kv.name] = jQuery.trim(kv.value);
                }
            }
            data["query_fields"] = jQuery.toJSON( query_fields );

            var isCsvExport = jQuery("#csv_export_true").attr("checked");
            var searchCallback = function(html, statusText)  {
                if(isCsvExport){
                    GUI.toggletVisible("#query_search_results .content");
                    jQuery("#query_search_results .ajax_loader").hide();
                    reduceQueriedResultsByOperator(query_fields);
                    window.location = jQuery.trim(html);
                }
                else {
                    jQuery("#query_search_results .content").html(html);
                    GUI.toggletVisible("#query_search_results .content");
                    jQuery("#query_search_results .ajax_loader").hide();
                    reduceQueriedResultsByOperator(query_fields);
                    window.location = (window.location + "").split("#")[0] + "#query_search_results";
                    language_saparator();
                }
            };
            jQuery("#query_search_results .ajax_loader").show();
            
            jQuery.post( jQuery(jqForm).attr("action") ,data , searchCallback);           
            return false;
    };

    var initStatisticsQuery = function(formData, jqForm, options) {
        jQuery("#query_search_results .ajax_loader").show();

        var query_fields = [];
        var f = function(){
            var id = new Number(jQuery(this).attr("id").replace("statistical_field_", ""));
            var fieldtypeid = new Number(jQuery(this).attr("fieldtypeid"));
            query_fields.push({"id":id,type:fieldtypeid});
        };
        jQuery("#searched_field_form").find("div[id*='statistical_field_']").each(f);

        formData.push( {"name": "query_fields" ,"value": jQuery.toJSON( query_fields )} );
        
        jQuery.post( jQuery(jqForm).attr("action"), formData , function(jsonText, statusText)  {
            //jQuery("#query_search_results .content").html(jsonText);
            processStatisticResults( jQuery.evalJSON(jsonText) );
            jQuery("#query_search_results .ajax_loader").hide();
        });        
        return false;
    };

    function initSearchForm(){
        // pre-submit callback
        jQuery('#query_builder_form').submit(function() {
            var isStatisticsMode = jQuery("#statistics_mode_true:checked").length == 1;
            if(isStatisticsMode)  {
               jQuery("#query_search_results .content").html("");
               jQuery(this).ajaxSubmit({beforeSubmit: initStatisticsQuery});
            }
            else {
               jQuery("#statistics_diagram_list").html("");
               jQuery(this).ajaxSubmit({beforeSubmit: initSearchQuery});
            }
            return false;
        });
    }

    function reduceQueriedResultsByOperator(query_fields){
       // console.log( query_fields );
        var f = function(){
            //console.log( jQuery(this).find(".data_cell") );
            jQuery(this).find("span[class*='data_cell']") .each(function(){
                var data_cell = jQuery(this).html();
                if( data_cell.length > 0 ){
                    //console.log(data_cell );
                }
            });
        };
        jQuery("#query_search_results").find("tr[id*='object_row_']").map(f);
    }

    function initStatisticsMode(){
        jQuery("#statistics_mode_false").attr("checked","true");
    }

    function setStatisticsMode(node) {
        var flag = jQuery(node).val();
        if(flag == "true"){
            jQuery("#field_list_view").find("table td .draggable").hide();
            jQuery("#field_list_view").find("table td .selectable_field").show();
            jQuery("#question_holder_csv_export").hide();
            jQuery("#query_builder_form").find("input[type='submit']").val("Do Statistics");
            jQuery("#query_builder_form").attr("action","<?= site_url("admin/search/do_statistics")?>");            
        }
        else {
            jQuery("#field_list_view").find("table td .draggable").show();
            jQuery("#question_holder_csv_export").show();
            jQuery("#query_builder_form").find("input[type='submit']").val("Search");
            jQuery("#query_builder_form").attr("action","<?= site_url("admin/search/do_search")?>");            
        }
        jQuery("#searched_field_form").html("");
    }

    function processStatisticResults(statistic_results){
        jQuery("#statistics_diagram_list div").remove();
        for(var k in statistic_results){
            var statistic_data = statistic_results[k];
            var fieldID = k.replace("statistic_fieldID_", "");
            var fieldName = jQuery("#statistical_field_"+fieldID).html();
            var data = [];
            data.push([]);

            var total = 0;
            jQuery(statistic_data).each(function(){
                total += this.frequency;
            });
            fieldName += (" (Total: " + total + " " + jQuery("#ObjectClassID option:checked").html() + " )");

            jQuery(statistic_data).each(function(){
                var record = [];
                var percent = Math.ceil((this.frequency * 100)/ total);
                record.push(this.OptionName + " (" + percent + "%) ");
                record.push( percent );
                data[0].push(record);
            });
            makePieChart(fieldID, fieldName, data);
        }
    }

    function makePieChart(fieldID, fieldName, data){
        //var data = [[['a',50],['b',40],['c',10]]];
        var titleText = 'Statistics for ' + fieldName;
        var diagram_key = "diagram_field_" + fieldID;

        var diagram_holder = '<div id="[ID]" style="margin-top:20px; margin-left:20px; width:96%; height:370px;"></div>';
        diagram_holder = diagram_holder.replace("[ID]", diagram_key);

        jQuery("#statistics_diagram_list").append(diagram_holder);        
        jQuery.jqplot.config.enablePlugins = true;
        var plot1 = jQuery.jqplot(diagram_key ,data , {
          title: titleText,
          seriesDefaults:{renderer:jQuery.jqplot.PieRenderer, trendline:{show:true}, rendererOptions:{sliceMargin:4}},
          legend:{show:true}
        });        
    }

    jQuery(document).ready(function(){
        jQuery("#field_list_view .ajax_loader").show();
        populateClasses();
        initSearchForm();
        initStatisticsMode();
    });

    var SearchQueryObj = {'id' : 0, 'query_name': "No name", 'query_details': [] };
    <?php
        if(isset ($the_query_details)){
            echo "SearchQueryObj.id = ".$the_query_details->id." ;\n";
            echo "SearchQueryObj.query_name ='".$the_query_details->query_name."' ;\n";
            echo "SearchQueryObj.query_details = ".$the_query_details->query_details." ;\n";
            echo "afterInitFormCallback.push(loadSearchQueryObj);\n";
        }
    ?>        
    
    function loadSearchQueryObj(){
        if(SearchQueryObj.id == 0){
            return;
        }
        var loadedCheckboxIds = {};
        var loadedFieldNum = 0;
        var sizeOfQuery = SearchQueryObj.query_details.query_fields.length;
        jQuery(SearchQueryObj.query_details.query_fields).each(function(){
            var fieldId = this.name;
            var fieldValue = this.value;
            var fieldType = this.type;
            var fieldtypeID = jQuery("#field_" + fieldId).attr(this.name);
            var callbackAfterDone = function(){
                if(fieldType == "checkbox") {
                    jQuery(SearchQueryObj.query_details.query_fields).each(function(){
                        jQuery("#field_list_view").find("input[name='field_" + this.name + "'][value='" + this.value + "']").attr("checked","checked" );
                    });
                } else if(fieldType == "select-one") {
                    jQuery("#field_list_view").find("select[id='field_" + fieldId+ "']").val(fieldValue);
                } else {
                    jQuery("#field_list_view").find("input[id='field_" + fieldId + "']").val(fieldValue);
                }
                loadedFieldNum++;
                if(loadedFieldNum == sizeOfQuery) {
                    //load done, now do searching
                    jQuery('#query_builder_form').ajaxSubmit({beforeSubmit: initSearchQuery});
                }
            };
            if( !(loadedCheckboxIds[fieldId]) ) {
                selectSearchedField(fieldId, fieldtypeID, callbackAfterDone);
            }            
            loadedCheckboxIds[fieldId] = true;
        });
        if(SearchQueryObj.id > 0){
            var node = jQuery("#query_filters-" + SearchQueryObj.id + "-query_name");
            node.editable("<?php echo site_url("admin/search/save_query_details"); ?>", {
                    type      : 'textarea',
                    rows      : 3,
                    width     : '98%',
                    cancel    : 'Cancel',
                    submit    : 'Save',
                    indicator : "<span style='color:red;font-weight:bold;'>Saving...</span>",
                    tooltip   : "Click to edit",
                    id   : 'editable_field_name',
                    name : 'editable_field_value'
             });             
         }
    };

    function saveSearchQueryObj() {
        // pre-submit callback
        var h = function(formData, jqForm, options) {
            var query_details = {};
            var query_fields = [];
            for(var i in formData){
                var kv = formData[i];
                if(kv.name.indexOf("field_") == 0){
                    kv.type = jQuery("#query_builder_form").find("*[name='"+ kv.name +"'][value='"+ kv.value +"']").attr("type");
                    kv.name = kv.name.replace("field_", "");
                    if( jQuery("#operator_f_" + kv.name).length > 0 )
                        kv.operator = jQuery("#operator_f_" + kv.name).val();
                    else
                        kv.operator = "";
                    query_fields.push(kv);
                }
                else {
                    query_details[kv.name] = jQuery.trim(kv.value);
                }
            }
            query_details["query_fields"] = query_fields;

            if(SearchQueryObj.id == 0) {
                var query_name = window.prompt("What is your name?","");
                SearchQueryObj.query_name = query_name;
            }

            SearchQueryObj.query_details = jQuery.toJSON(query_details);
            jQuery.post( "<?php echo site_url("admin/search/save_query_details")?>", SearchQueryObj , function(rs)  {
                
                    alert("Saved this query! ");
                
            });
            return false;
        };        
        jQuery('#query_builder_form').ajaxSubmit({beforeSubmit: h});
    };



    <?php if ( isset ($use_form_statistics) ) {?>
        jQuery("#statistics_setting").show();
        jQuery("#question_holder_csv_export").hide();        
        afterInitFormCallback.push(function(){
            jQuery("#statistics_mode_true").attr("checked", "checked");
            setStatisticsMode(jQuery("#statistics_mode_true"));
        });        
    <?php } ?>

    <?php if ( isset ($use_form_export_data) ) { ?>
        jQuery("#statistics_setting").hide();
        jQuery("#question_holder_csv_export").show();
        jQuery("#csv_export_true").attr("checked", "checked");
    <?php } ?>

</script>