<?php
addScriptFile("js/jquery/jquery.form.js");
addScriptFile("js/jquery/jquery.json.js");

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
</style>

<fieldset class="input_info" style="margin-top: 10px;">
    <legend>Query Form</legend>
    <form id="query_builder_form" action="<?= site_url("admin/search/do_search")?>" accept="utf-8" method="post">
        <div class="query_question" >
             <div>
                 <div>
                    <b>Statistics by Field ?</b>
                    <span>(Only optional fields are use in Statistics)</span>
                    <input id="statistics_mode_true" type="radio" name="statistics_mode" value="true" onchange="setStatisticsMode(this)"/>
                    <label for="statistics_mode_true">Yes</label>
                    <input id="statistics_mode_false" type="radio" name="statistics_mode" value="false" onchange="setStatisticsMode(this)"/>
                    <label for="statistics_mode_false">No</label>
                </div>
            </div>
            <div>
                <label for="ObjectClassID">Object / Đối tượng cần tìm: </label>
                <select name="ObjectClassID" id="ObjectClassID" onchange="populateProcesses()" > </select>
            </div>
            <div>
                <label for="ProcessID">Process / Quy trình xử lý cần tìm: </label>
                <select name="ProcessID" id="ProcessID" onchange="populateForms()" ></select>
            </div>
            <div>
                <label for="FormID">Form / Form cần tìm: </label>
                <select name="FormID" id="FormID" onchange="populateFields()"></select>
            </div>            
            <div>
                <div id="question_holder_csv_export" style="margin-top: 8px;">
                    <b>CSV Export for Excel ?</b>
                    <input id="csv_export_true" type="radio" name="csv_export" value="true" />
                    <label for="csv_export_true">Yes</label>
                    <input id="csv_export_false" type="radio" name="csv_export" value="false" checked="true"/>
                    <label for="csv_export_false">No</label>
                </div>
                <div>
                    <b><a href="javascript:void(0)" onclick="toggleFieldList(this)">Hide</a> Field List</b>
                </div>
            </div> 
            <div id="field_list_view" >
                <div class="ajax_loader display_none" ></div>
                <table border="0" width="100%">
                    <thead>
                        <tr>
                            <th>Field List</th>
                            <th>Query Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="width:25%">
                                <div>
                                    <input style="width:95%" id="searched_field_hint_filter" type="text" name="" value="" />
                                </div>
                                <div class="content" ></div>
                            </td>
                            <td style="width:75%; vertical-align:top;">
                                <div id="searched_field_form" >
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div style="text-align: center;">
            <input type="submit" value="Search" />
            <input type="button" value="Reset" onclick="location.reload()" />
            <input type="button" value="Cancel" />            
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
        <option selected="selected" >OR</option>
        <option>AND</option>
    </select>
</div>

<?php jsMetaObjectScript(); ?>
<script type="text/javascript">
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
        };
        jQuery("#field_list_view .ajax_loader").show();
        jQuery.post(url, filter, handler);
    }

    function selectSearchedField(fieldID,fieldtypeID){
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
                    data[kv.name] = kv.value;
                }
            }
            data["query_fields"] = jQuery.toJSON( query_fields );

            var isCsvExport = jQuery("#csv_export_true").attr("checked");
            var searchCallback = function(responseText, statusText)  {
                if(isCsvExport){
                    GUI.toggletVisible("#query_search_results .content");
                    jQuery("#query_search_results .ajax_loader").hide();
                    reduceQueriedResultsByOperator(query_fields);
                    window.location = jQuery.trim(responseText);
                }
                else {
                    jQuery("#query_search_results .content").html(responseText);
                    GUI.toggletVisible("#query_search_results .content");
                    jQuery("#query_search_results .ajax_loader").hide();
                    reduceQueriedResultsByOperator(query_fields);
                    window.location = (window.location + "").split("#")[0] + "#query_search_results";
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
</script>