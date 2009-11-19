<style type="text/css">
    label {
        margin-right:5px;
        display:block;
        font-weight:bold;
    }
    fieldset div {
        margin-top:15px;
        margin-bottom:5px;
    }
    .input_info{
        border:medium solid!important;
    }
</style>

<?php
require_once "macros.php";
addScriptFile("js/commons.js");
addScriptFile("js/jquery/jquery.json.js");

$obj = new Field();
if(isset($obj_details)) {
    $obj = $obj_details;
}

$attributes = array('id' => 'field_info', 'class' => 'input_info');
echo form_fieldset('Field Information', $attributes);
echo form_open(site_url($action_uri), 'id="field_details_form"');

echo renderInputField("FieldID","FieldID",$obj->getFieldID());
echo renderSelectField("FieldTypeID", "FieldTypeID", $field_types, "Field Type");
?>

<div>
    <input type="hidden" id="field_option_data" name="field_option_data" value="" />
    <ul id="field_option_data_ul" style="display:none;">
        <li></li>
    </ul>
</div>

<?php
echo renderInputField("FieldName","FieldName",$obj->getFieldName());
echo renderInputField("ValidationRules","ValidationRules",$obj->getValidationRules());
echo form_submit('mysubmit', 'Submit');
echo form_button("cancel", "Cancel", 'onclick="history.back();"');

echo form_close();
echo form_fieldset_close();

?>



<div id="add_field_options_box" style="display:none;">    
    <div >
        <form id="add_field_option_form" method="post" action="<? site_url('field_controller/addFieldOption') ?>" accept-charset="UTF-8">
            <textarea name="OptionName" style="width:100%;height:190px;" cols="40" rows="3"></textarea>
            <div class="confirmation" style="font-weight:bold; font-size:16; margin:5px; display:none;">
                Added successfully, add more ?
            </div>
            <input type="button" value="OK"  />
            <input type="button" value="Cancel" onclick="Modalbox.hide()" />
        </form>
    </div>
</div>


<script type="text/javascript" language="JavaScript">
    function callAddFieldOptionBox(){       
        Modalbox.show("#add_field_options_box",{width:500,height:300,title:'Add Field Options'});
        Modalbox.contentSelector("textarea[name='OptionName']").show();
        Modalbox.contentSelector("div[class='confirmation']").hide();
        Modalbox.contentSelector("input[value='OK']").click(
            function(){
                addFieldOptionData();               
            }
        );        
    }

    function FieldType_Handler(){
        jQuery("#FieldTypeID").change(function(){
            var isSelectableField = jQuery(this).val() == <?= FieldType::$SELECT_BOX ?>;
            isSelectableField = isSelectableField || jQuery(this).val() == <?= FieldType::$MULTI_SELECT_BOX ?>;
            isSelectableField = isSelectableField || jQuery(this).val() == <?= FieldType::$CHECK_BOX ?>;
            isSelectableField = isSelectableField || jQuery(this).val() == <?= FieldType::$RADIO_BUTTON ?>;
            
            if(isSelectableField){
                callAddFieldOptionBox();
                 jQuery("#field_option_data_ul").show();
            }
            else {
                 jQuery("#field_option_data_ul").hide();
            }
        });
    }

    var field_option_data = [];
    var isAddMore = false;
    function addFieldOptionData(){
        if(isAddMore){
            Modalbox.contentSelector("textarea[name='OptionName']").show();
            Modalbox.contentSelector("div[class='confirmation']").hide();
            isAddMore = false;
        }
        else {
            var OptionName = Modalbox.contentSelector("textarea[name='OptionName']").val();
            Modalbox.contentSelector("textarea[name='OptionName']").val("");
            var FieldID = <?= $id ?>;
            field_option_data.push([FieldID,OptionName]);
            jQuery("#field_option_data_ul").append("<li>"+ OptionName + "</li>")
            Modalbox.contentSelector("textarea[name='OptionName']").hide();
            Modalbox.contentSelector("div[class='confirmation']").show();
            isAddMore = true;
        }
    }

    var id = <?= $id ?>;

    jQuery(document).ready(function(){
        if(id > 0){
            jQuery("#FieldID").val(id);
            jQuery("#FieldID").attr("readonly", "readonly");
            jQuery("#FieldTypeID option[value='<?= $obj->getFieldTypeID() ?>']").attr("selected", "selected");
        }
        else {
            jQuery("#FieldID").parent().hide();            
        }
        jQuery("#ObjectID").parent().hide();
        jQuery("#field_details_form").submit(function(){
             jQuery("#field_option_data").val(jQuery.toJSON(field_option_data));
        });
        FieldType_Handler();
    });
</script>

<?php
$map_data = array_map(
    create_function('$x', 'return $x * 2;'),
    array(1, 2, 3, 4, 5)
  );
print_r($map_data);

$reduced_data = array_reduce($map_data, create_function('$x, $y', 'return $x + $y;'));
print $reduced_data;
?>