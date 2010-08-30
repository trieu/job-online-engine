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
</style>

<fieldset>
    <legend>1) Set up the Index for Matching Engine</legend>
    <div style="margin: 27px 5px 10px">
        <input type="radio" checked name="index_as_new" value="true" /> Create new Index for All Objects <br>
        <input type="radio" name="index_as_new" value="false" /> Update incrementally the index for All Objects: <br>

        <input type="button" value="Do indexing all objects" onclick="index_all_objects()" />

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
            <div id="ClassHolder" style="display:inline;height: 25px; width: 250px;background-color:#555555;color:#FFFFFF;" ></div>
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
                        <th class="vietnamese_english" >Matching Structure / Query Details</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="width:25%;vertical-align:top;">                           
                            <div class="content" ></div>
                        </td>
                        <td style="width:75%; vertical-align:top;">
                            <div id="matched_structure" >
                                <div id="class_2">
                                    <h4 class="ui-widget-header">Base Class</h4>
                                    <div class="ui-widget-content">
                                        <div id="class_2_name" style="height: 25px; width: 250px;background-color:#555555;color:#FFFFFF;" ></div>
                                        <ol> 
                                            <li class="placeholder">Add matched fields here</li>
                                        </ol> 
                                    </div> 
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <input type="button" value="Do indexing all objects" onclick="" />


    </div>
</fieldset>


<textarea style="display: none;" name="" rows="4" cols="20" onselect="selectedTextHandler(this)">Update incrementall</textarea>

<?php jsMetaObjectScript(); ?>
<script  type="text/javascript">
    function updateClassList(){
        populateProcesses();
        jQuery("#ClassHolder").html(jQuery("#ObjectClassID").find("option:selected").html());
    }

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

        var url = "<?= site_url('admin/search_indexer/index_all_objects/') ?>";
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
        var url = "<?= site_url("admin/search/populate_query_helper") ?>";
        var filter =  {what: "<?= search::$FIELD_HINT ?>" , filterID: val};
        var handler =  function(html){
            jQuery("#field_list_view .content").html( html );
            jQuery("#field_list_view .ajax_loader").hide();            
        };
        jQuery("#field_list_view .ajax_loader").show();
        jQuery.post(url, filter, handler);
    }    

    jQuery(document).ready(function(){        
        var callback = function(){            
            jQuery("#ClassHolder").html(jQuery("#ObjectClassID").find("option:selected").html());
        };
        populateClasses(callback);
         jQuery("#ClassHolder").draggable({helper:'clone'});
         jQuery("#class_2_name").droppable({              
                drop: function(event, ui) {
                    jQuery(this).html(jQuery(ui.draggable).html());
                }
         });
        
    });
</script>