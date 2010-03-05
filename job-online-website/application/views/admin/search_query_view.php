<?php
addScriptFile("js/jquery/jquery.form.js");
addScriptFile("js/jquery/jquery.json.js");
?>
<style type="text/css"> 
    .query_question > div{
        margin-top:6px;
        display: block;
        position:relative;
        width: 100%;
    }
    .query_question > div > label{
        float: left;
        width: 38%;
        position:relative;
    }
    .query_question > div > select{
        float: left;
        width: 56%;
        position:relative;
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
</style>

<fieldset class="input_info" style="margin-top: 10px;">
    <legend>Search Form</legend>
    <form id="query_builder_form" action="<?= site_url("admin/search/do_search")?>" accept="utf-8" method="post">
        <div class="query_question" >
            <div>
                <label for="ObjectClassID">Searched Object / Đối tượng cần tìm</label>
                <select name="ObjectClassID" id="ObjectClassID" onchange="populateProcesses()" >
                    <option value="1" selected >Job Seeker / Người tìm việc</option>
                    <option value="2"  >Employers / Nhà tuyển dụng</option>
                    <option value="3">Job Coaches / </option>
                </select>
            </div>
            <div>
                <label for="ProcessID">Searched Process / Quy trình xử lý cần tìm</label>
                <select name="ProcessID" id="ProcessID" onchange="populateForms()" >
                </select>
            </div>
            <div>
                <label for="FormID">Searched Form / Form cần tìm</label>
                <select name="FormID" id="FormID" onchange="populateFields()">
                </select>
            </div>
         
            <input type="button" value="Hide field List" onclick="toggleFieldList(this)" />
            <span style="margin-left: 10px">
                <span >CSV Export:</span>
                <input id="csv_export_true" type="radio" name="csv_export" value="true" />
                <label for="csv_export_true">True</label>
                <input id="csv_export_false" type="radio" name="csv_export" value="false" checked="true"/>
                <label for="csv_export_false">False</label>
            </span>
         
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
            <input type="button" value="Cancel" />
        </div>
    </form>
</fieldset>

<a name="query_search_results" href="#query_search_results"></a>
<div id="query_search_results" style="margin-top: 10px;">
    <div class="ajax_loader display_none" ></div>
    <div class="content" ></div>
</div>

<div id="query_operator_tpl" class="display_none" >
    <select id="@=name@">
        <option selected="selected" >OR</option>
        <option>AND</option>
    </select>
</div>

<script type="text/javascript">
    function toggleFieldList(node){
        var th = jQuery("#field_list_view").find("table th:first");
        var td = jQuery("#field_list_view").find("table td:first");
        var val = jQuery(node).val();
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
        jQuery(node).val(val);
    }

    function populateClasses(){
        var url = "<?= site_url("admin/search/populate_query_helper")?>";
        var filter =  {what: "<?= search::$OBJECT_CLASS_HINT ?>"};
        var handler =  function(text){
            var data = jQuery.secureEvalJSON( text );
            var html = "";
            for(var i in data.options){
                html += ("<option value='" + data.options[i].options_val + "'>" + data.options[i].options_label + "</option>");
            }
            jQuery("#ObjectClassID").html( html );
            populateProcesses();
        };
        jQuery.post(url, filter, handler);
    }

    function populateProcesses(){
        var val = jQuery("#ObjectClassID").val();
        var url = "<?= site_url("admin/search/populate_query_helper")?>";
        var filter =  {what: "<?= search::$PROCESS_HINT ?>" , filterID: val};
        var handler =  function(text){
            var data = jQuery.secureEvalJSON( text );
            var html = "";
            for(var i in data.options){
                html += ("<option value='" + data.options[i].options_val + "'>" + data.options[i].options_label + "</option>");
            }
            jQuery("#ProcessID").html( html );
            populateForms();
        };
        jQuery.post(url, filter, handler);
    }
    function populateForms(){
        var val = jQuery("#ProcessID").val();
        var url = "<?= site_url("admin/search/populate_query_helper")?>";
        var filter =  {what: "<?= search::$FORM_HINT ?>" , filterID: val};
        var handler =  function(text){
            var data = jQuery.secureEvalJSON( text );
            var html = "";
            for(var i in data.options){
               html += ("<option value='" + data.options[i].options_val + "'>" + data.options[i].options_label + "</option>");
            }
            jQuery("#FormID").html( html );
            if(jQuery("#FormID").val() != null){
                populateFields();
            }
        };
        jQuery.post(url, filter, handler);
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
            jQuery("#field_list_view .ajax_loader").hide();
        };
        jQuery("#field_list_view .ajax_loader").show();
        jQuery.post(url, filter, handler);
    }
    function selectSearchedField(fieldID){
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

    function initSearchForm(){
        // pre-submit callback
        var preSubmitCallback = function(formData, jqForm, options) {
            GUI.toggletVisible("#query_search_results .content");
            //console.log(formData);
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
            //console.log(data);

            var isCsvExport = jQuery("#csv_export_false").attr("checked");

            var searchCallback = function(responseText, statusText)  {
                if(!isCsvExport){
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

            if(isCsvExport ) {
                jQuery.post( jQuery(jqForm).attr("action") ,data , searchCallback);
            }
            else {
                jQuery.post( jQuery(jqForm).attr("action")+"/true" ,data , searchCallback);
            }
            

            return false;
        };
        jQuery('#query_builder_form').submit(function() {
            jQuery(this).ajaxSubmit({beforeSubmit: preSubmitCallback});
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

    jQuery(document).ready(function(){
        populateClasses();
        initSearchForm();
    });
</script>