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
    .input_info form div {
        margin-top: 5px;
    }
    fieldset div {
        margin-top:5px;
        margin-bottom:5px;
    }
    .input_info{
        border:medium solid!important;        
    }
    .input_info legend {
        font-weight:bold;
        font-size: 14px;
    }
</style>

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
        <input type="button" value="Load fields" onclick="populateFields()" />
        <fieldset class="input_info" style="margin-top: 10px;">
            <legend>Enter the searched fields</legend>
            <div id="field_list_view" >
                <div class="ajax_loader display_none" ></div>
                <div class="content" ></div>
            </div>
        </fieldset>
    </div>
    <div style="text-align: center;">
        <input type="submit" value="Search" />
        <input type="button" value="Cancel" />
    </div>
</form>

<div id="query_search_results" style="margin-top: 10px;">
    <div class="ajax_loader display_none" ></div>
    <div class="content" ></div>
</div>

<script type="text/javascript">
    function populateClasses(){

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

    function initSearchForm(){
        // pre-submit callback
        var preSubmitCallback = function(formData, jqForm, options) {
            GUI.toggletVisible("#query_search_results .content");
            //console.log(formData);
            var data = {};
            data["query_fields"] = [];
            for(var i in formData){
                var kv = formData[i];
                if(kv.name.indexOf("field_") == 0){
                    kv.type = jQuery("#query_builder_form").find("*[name='"+ kv.name +"'][value='"+ kv.value +"']").attr("type");
                    kv.name = kv.name.replace("field_", "");
                    data["query_fields"].push(kv);
                }
                else {
                    data[kv.name] = kv.value;
                }
            }
            data["query_fields"] = jQuery.toJSON(data["query_fields"]);
            //console.log(data);
            var searchCallback = function(responseText, statusText)  {
                jQuery("#query_search_results .content").html(responseText);
                GUI.toggletVisible("#query_search_results .content");
                jQuery("#query_search_results .ajax_loader").hide();
            };
            jQuery("#query_search_results .ajax_loader").show();
            jQuery.post( jQuery(jqForm).attr("action") ,data , searchCallback);

            return false;
        };
        jQuery('#query_builder_form').submit(function() {
            jQuery(this).ajaxSubmit({beforeSubmit: preSubmitCallback});
            return false;
        });
    }

    jQuery(document).ready(function(){
        populateProcesses();
        initSearchForm();
    });
</script>
