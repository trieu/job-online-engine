
<? function importContainerBox($container_name, $data_list, $is_multi_select) { ?>

<style type="text/css">
    #container_ui_box .selected_element {
        background:#FFFF99 none repeat scroll 0 0;
    }
</style>

<div id="container_ui_box">
    <ul style="height:54px !important;" >
        <li><a href="#tabs-1"><?=$container_name?></a></li>
        <li><a href="#tabs-2">Create new <?=$container_name?></a></li>
    </ul>
    <div id="tabs-1">
        <div id="container_list" style="overflow-y:auto; height: 135px; margin-left: 15px; margin-bottom:5px;">
            <?php foreach ($data_list as $key  => $val) { ?>
            <div style="margin-bottom:5px">
                <input type="checkbox" id="element_<?= $key ?>" name="<?= $val ?>" onClick="container_ui_box.setSelectedRow(jQuery('#element_<?= $key ?>'))" />
                <label for="element_<?= $key ?>" onClick="container_ui_box.setSelectedRow(jQuery('#element_<?= $key ?>'))" >
                        <?= $val ?>
                </label>
            </div>
            <?php }	?>
        </div>
    </div>
    <div id="tabs-2">
        <div style="width: 90%; margin-left: 7px;">
            <div>Name<span style="color: red;">*</span>:<br/>
                <input id="containerName" type="text" style="width:100%"/>
                <div id="nameErrorMsg" style="color:red; text-align:right" ></div>
            </div>
        </div>
        <div style="text-align:center" >
            <input type="button" value="OK" />
            <input type="button" value="Cancel" />
        </div>
    </div>
</div>

<script type="text/javascript">
    var container_ui_box = {};
    container_ui_box.setSelectedRow = function(node){
        if( jQuery(node).attr('checked') ){
            jQuery(node).parent().addClass('selected_element');
        }
        else {
            jQuery(node).parent().removeClass('selected_element');
        }
    };
    jQuery(document).ready(function(){
        jQuery("#container_ui_box").tabs();
    });
</script>

<? } ?>