<style type="text/css">
    label {
        margin-right:5px;
        font-weight:bold;
    }
    form div {
        margin-top: 5px;
    }
    fieldset div {
        margin-top:15px;
        margin-bottom:5px;
    }
    .input_info{
        border:medium solid!important;
        padding: 11px;
    }
    textarea {
        font-size: 16px;
    }
</style>


<?php
addScriptFile("js/jquery.tokeninput/jquery.tokeninput.js");
addCssFile("js/jquery.tokeninput/token-input.css");

$obj = new Object();
if(isset($obj_details)) {
    $obj = $obj_details;
}

if($id <= 0 ) {
    setPageTitle("Create New Object");
}
else {
    setPageTitle("Edit Object ".$obj->getObjectClassName());
}

$attributes = array('id' => 'Object_info', 'class' => 'input_info');
echo form_fieldset('Object Information', $attributes);
echo form_open(site_url($action_uri), 'id="Object_details"');

echo renderInputField("ObjectID","ObjectID",$obj->getObjectClassID(),"ObjectID");

echo renderTextArea("dk", "valie", "dk label");

echo renderSelectBox("sl", array("1"=>"One", "2" => "Two"), " select box", TRUE);

echo renderCheckBoxs("test cb", "choose ?", array("1"=>"One", "2" => "Two"));
echo renderRadioButtons("test cb", "choose ?", array("1"=>"One", "2" => "Two"));

echo renderDatepicker("field_1234", "Date:");
?>



<div style="margin-top:32px">
    <input type="submit" value="Submit" />
    <input type="button" value="Cancel" onclick="history.back();" />
</div>

<?php
echo form_close();
echo form_fieldset_close();
?>


<script type="text/javascript">
    var id = <?=  $id ?>;

    jQuery(document).ready(function(){
        if(id > 0){
            jQuery("#ObjectID").val(id);
            jQuery("#ObjectID").attr("readonly", "readonly");
        }
        else {
            jQuery("#ObjectID").hide();
            jQuery("#ObjectID").parent().hide();
        }

        jQuery("#Object_details").submit(function(){

        });
    });

</script>



<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript">
    google.load("visualization", "1", {packages:["piechart"]});
    google.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Task');
        data.addColumn('number', 'Hours per Day');
        data.addRows(5);
        data.setValue(0, 0, 'Work');
        data.setValue(0, 1, 11);
        data.setValue(1, 0, 'Eat');
        data.setValue(1, 1, 2);
        data.setValue(2, 0, 'Commute');
        data.setValue(2, 1, 2);
        data.setValue(3, 0, 'Watch TV');
        data.setValue(3, 1, 2);
        data.setValue(4, 0, 'Sleep');
        data.setValue(4, 1, 7);

        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, {width: 400, height: 240, is3D: true, title: 'My Daily Activities'});
    }
</script>
<div id="chart_div"></div>