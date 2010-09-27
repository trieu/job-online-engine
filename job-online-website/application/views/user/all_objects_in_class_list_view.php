<style type="text/css">
    .context_menu_trigger span {
        min-width: 102px;
    }
    .context_menu_trigger {
        border-top: blue solid 1px;
        padding: 10px 10px 10px 50px;
    }
    .context_menu_trigger .id{
       color: blue;
       font-size: 16px;
       font-weight: bold;
       margin-left: -40px;
    }
    .context_menu_trigger .field_name{
       color:#1C94C4;
       font-size: 13px;
       font-weight: bold;
    }
    .context_menu_trigger .field_value{
       color:#000000;
       font-size: 15.5px;
       font-weight: bold;
    }
    .context_menu_trigger .actions{     
       text-align: right;
       padding-right: 40px;
       color: blue;
    }
    #total_filter_num_wrapper {
        font-weight: bold;color: #2266BB;background-color: #FFFF66; margin: 5px;padding-left: 10px;
    }
</style>
<?php if( ! isset ($in_search_mode) ) { ?>
    <?php
    addScriptFile("js/jquery.pagination/jquery.pagination.js");
    addCssFile("js/jquery.pagination/style.css");
    addScriptFile("js/jquery.contextmenu/jquery.contextmenu.js");
    addCssFile("js/jquery.contextmenu/style.css");
    ?>
<script type="text/javascript">
    jQuery(document).ready(function() {
        initContextMenu();
        initPagination();
        setTimeout(populateQuickFilter, 1000);
        
    });
    
    function initContextMenu(){
        var f = function(){
            jQuery(this).contextMenu({ menu: "context_menu_ui", leftButton: true},contextMenuHandler);
            jQuery(this).mouseover(function(){
                // jQuery(this).css("background-color", "#FFFF99");
            });
            jQuery(this).click(function(){
                jQuery(".context_menu_trigger").css("background-color", "#FFF");
                jQuery(this).css("background-color", "#FFFF99");
            });
            jQuery(this).mouseout(function(){
                // jQuery(this).css("background-color", "#FFF");
            });
        };
        jQuery(".context_menu_trigger").each(f);
    }
    function contextMenuHandler(action, el, pos) {
        var params = "";
        if( action.indexOf("FormID_") == 0 ) {
            params = "/" + <?= $objectClass->getObjectClassID() ?> + "/" + jQuery(el).attr("id").replace("object_row_","") + "/" + action.replace("FormID_","");
            window.location = "<?= site_url("user/public_object_controller/do_form")?>" + params;
        }
        else if( action.indexOf("FormID_") == 0 ) {
            params = "/" + <?= $objectClass->getObjectClassID() ?> + "/" + jQuery(el).attr("id").replace("object_row_","") + "/" + action.replace("FormID_","");
            window.location = "<?= site_url("user/public_object_controller/do_form")?>" + params;
        }
        else if(action == "EditObject"){
            params = "/" + jQuery(el).attr("id").replace("object_row_","");
            window.location = "<?= site_url("user/public_object_controller/edit/")?>" + params;
        }
    }

    var pagination_config = null;
    <?php
    if(isset ($pagination_config)) {
        echo "pagination_config = ".json_encode($pagination_config).";";
    }
    ?>
    function initPagination() {
        if(pagination_config != null){
            // First Parameter: number of items
            // Second Parameter: options object
            jQuery("div.pagination").pagination( pagination_config["total_rows"], {
                items_per_page: pagination_config["per_page"] ,
                callback:handlePaginationClick
            });
            setPaginationLink();
            jQuery("div.pagination").find("a[page_index='"+ pagination_config['current_page'] +"']").click();
        }
    }
    function setPaginationLink(){
        jQuery("div.pagination a").each(function(){
            var text = jQuery.trim(jQuery(this).html());
            jQuery(this).attr("href", "javascript:void("+text+")");
            if(text == "Next"){
               // jQuery(this).attr("href", "javascript:alert('next')");
            }
            else if(text == "Prev") {
               // jQuery(this).attr("href", "javascript:alert('prev')");
            }
        });
    }

    function handlePaginationClick(new_page_index, pagination_container) {
        setPaginationLink();
    }

    function populateQuickFilter(){
        var fieldnames = {};
        jQuery("#page_content .field_name").each(function(){
            var fn = jQuery.trim(jQuery(this).html());
            if(fieldnames[fn] == null){
                fieldnames[fn] = fn;
                var tagOption = '<option value="'+ fn +'">'+ fn +'</option>';
                jQuery("#quick_filter_field_name").append(tagOption);
            }
        });
        jQuery("#quick_filter_ok").click(function(){
            jQuery("div[id*='object_row_']").hide();
            var sfn = jQuery("#quick_filter_field_name option:selected").html();
            var sfv = jQuery.trim(jQuery("#quick_filter_field_value").val());
            var c = 0;
            jQuery("#page_content .field_name").each(function(){
                var fn = jQuery(this).html();
                var fv = jQuery(this).next().html();
                if(fn.search(sfn) >= 0 && fv.search(sfv) >= 0) {
                    jQuery(this).parent().parent().show();
                    c = c + 1;
                }
            });
            var text = c + ' ' + jQuery('#ObjectClassName').html();
            jQuery("#total_filter_num").html(text).parent().show();
        });
        jQuery("#quick_filter_reset").click(function(){
             jQuery("div[id*='object_row_']").show();
        });
        jQuery("#quick_filter_div").show();
    }
</script>
<ul id="context_menu_ui" class="contextMenu">
    <li><a href="#EditObject" >@Action: Edit</a></li>
<?php foreach ($objectClass->getUsableProcesses() as $idx => $p) {
    if($idx == 0) continue;
    ?>
    <li>
        <a href="#ProcessID_<?= $p->getProcessID() ?>">
            @Process: <?php echo $p->getProcessName(); ?>
        </a>
    </li>

    <?php foreach ($p->getUsableForms() as $form) { ?>
    <li>
        <a href="#FormID_<?= $form->getFormID() ?>">
            &nbsp;&nbsp; #Form: <?php echo $form->getFormName(); ?>
        </a>
    </li>
    <?php }
} ?>
</ul>

    <?php } ?>


<div style="margin-bottom: 20px;">   
    <h3 class="vietnamese_english" id="ObjectClassName" ><?= $objectClass->getObjectClassName()  ?> </h3>
    <b>
        <span class="vietnamese_english">
            Tổng cộng: <?= $total_records = count($objects) ?>  /
            Total: <?= $total_records = count($objects) ?> records
        </span>
        <br/>
        
       <?php echo anchor('user/public_object_controller/create_object/'.$objectClass->getObjectClassID(), "Đăng ký ". $objectClass->getObjectClassName() ." mới"); ?>
    </b>
    <div style="margin-top: 10px; display: none;" id="quick_filter_div" >
        <select id="quick_filter_field_name" ></select>
        <input id="quick_filter_field_value" type="text" value="" size="80" />
        <input id="quick_filter_ok" type="button" value="Filter" />
        <input id="quick_filter_reset" type="button" value="Show All" />
    </div>
    <div id="total_filter_num_wrapper" style="display: none;">
        <span id="total_filter_num" ></span>
        <span class="vietnamese_english"> được tìm thấy/found</span>
    </div>
    
</div>


<?php if($total_records > 0) { ?>

<div class='pagination' style="text-align:center"></div>
<br><br>

    <?php foreach ($objects as $objID => $fields ) { ?>
        <div class="context_menu_trigger focusable_text" id="object_row_<?= $objID ?>">
            <a name="<?php echo $objID; ?>"></a>
             <div class="id">
                 <span>ID: <?php echo $objID; ?></span>
                 <span style="padding-left: 10px; "><?php action_url_a('user/public_object_controller/edit/'.$objID,"Edit"); ?></span>
             </div>
            <?php
            foreach ($fields as $field ) {
                if( isset ($field['FieldID'])) {
                    ?>
                    <div style="margin-top: 3px;">
                        <span class="field_name vietnamese_english"><?php echo $field['FieldName'];?></span>
                        <span class="field_value"><?php echo $field['FieldValue'];?></span>
                    </div>
                    <?php
                }
                else {
                    ?>
                    <div style="margin-top: 3px;">
                        <span class="field_name vietnamese_english"><?php echo $field['FieldName'];?></span>
                        <span class="field_value"><?php echo $field['FieldValue'];?></span>
                    </div>
                    <?php
                }
            }
            ?>
            <div class="actions" >

            </div>
        </div>
        <?php } ?>

<div class='pagination' style="text-align:center"></div>

    <?php } else { ?>
<div>
    <b>No results were found!</b>
</div>
    <?php } ?>