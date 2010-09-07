<?php
addScriptFile("js/jquery/jquery.form.js");
addScriptFile("js/jquery/jquery.json.js");
addScriptFile("js/jquery/jquery.field.min.js");
addScriptFile("js/jquery.fancybox/jquery.fancybox.min.js");
addCssFile("js/jquery.fancybox/jquery.fancybox.css");
// $object_class = new ObjectClass();
$legend_text = "";
//foreach ($object_class->getUsableProcesses() as $pro) {
//    $legend_text .= $pro->getProcessName();
//    break;
//}
?>

<style type="text/css">   
    #accordion {
       margin-bottom:19px;
    }
    #accordion > *{
        font-size: 15.2px;
        font-family: Trebuchet,Tahoma,Verdana,Arial,sans-serif;
        color:#1C94C4;
    }
    #accordion .ui-accordion-header {
        font-weight: bold;
    }
    #accordion .ui-state-active {
       font-size:15px;
    }
    .form_name {
        clear: none!important;
        margin:4px 0 0 4px;
    }
    #object_instance_div {
        border: 1px #003399 solid;
        padding: 17px;
    }
    #object_instance_div div {
        margin-top: 5px;
    }
    #object_instance_div label {
        margin-right:5px;
        font-weight:bold;
    }
    .ui-tabs .ui-tabs-nav {
        height: 49px !important;
    }
</style>

<div id="tabs">
    <ul>
        <li>
            <a href="#object_info_tab_content" id="object_info_tab" >
                <span class="vietnamese_english">Thông tin chi tiết:/Information Details:</span>
                <span class="vietnamese_english"><?= $object_class->getObjectClassName() ?></span>
            </a>
        </li>
        <li>
            <a href="#automatic_search_tab_content" id="automatic_search_tab" class="vietnamese_english">
                Tìm kiếm dữ liệu tự động / Automatic Search
            </a>
        </li>
        <li style="display: none" >
            <a href="#communication_tab_content" id="communication_tab" class="vietnamese_english">
                Liên hệ Email / Contact by Email
            </a>
        </li>
        <li style="display: none" >
            <a href="#location_tab_content" id="location_tab" class="vietnamese_english">
                Tìm trên bản đồ / Search on map
            </a>
        </li>
    </ul>
    <div id="object_info_tab_content">
        <div id="accordion">
            <h3><a href="#"><?= $legend_text ?></a></h3>
            <div>
                <div class="input_info" id="object_instance_div" >
                    <div class="ajax_loader display_none" ></div>
                    <form id="object_instance_form" action="<?= site_url("user/public_object_controller/save/".$object_class->getObjectClassID()) ?>" accept="utf-8" method="post">
                        <?php
                        if(isset ($objectCacheHTML['cacheContent'])) {
                            echo html_entity_decode($objectCacheHTML['cacheContent']);
                        }
                        if(isset ( $objectCacheHTML['javascriptContent'] ) ) {
                            echo "<script type='text/javascript'>".$objectCacheHTML['javascriptContent']."</script>";
                        }
                        ?>
                    </form>
                </div>
            </div>
        </div>
        <div>
            <b class="vietnamese_english">
                Chọn một form để xem hoặc cập nhật thông tin /
                Select a form for editing
            </b>
            <ol>
                <?php foreach($formsOfObject as $form){?>
                <li class="form_name">
                    <a class="iframe use_fancybox vietnamese_english" href="<?php echo site_url("user/public_object_controller/ajax_edit_form/".$object->getObjectClassID()."/".$object->getObjectID()."/".$form["FormID"]) ?> ">
                    <?= $form["FormName"] ?>
                    </a>
                </li>
                <?php }?>
            </ol>
        </div>
    </div>
    <div id="automatic_search_tab_content">
        <p class="vietnamese_english" >This function helps us find the matched data more intelligent</p>
    </div>
    <div id="communication_tab_content">
        <p class="vietnamese_english" >This function helps us contact with the object using email</p>
        <div>            
            <label for="to_addresses" class="vietnamese_english">Gửi đến địa chỉ Email:/Send To Email Addresses:</label>
            <input id="to_addresses" type="text" name="to_addresses" value="" size="80" /> <br><br>

            <label for="email_subject" class="vietnamese_english">Chủ đề:/Subject:</label>
            <textarea id="email_subject" name="email_subject" rows="2" cols="80"></textarea> <br><br>

            <label for="email_message" class="vietnamese_english">Nội dung:/Content:</label>
            <textarea id="email_message" name="email_message" rows="10" cols="80"></textarea> <br><br>
            
            <input type="button" value="Send" onclick="sendEmailToHumanObject()" /><br>
            <div id="sendEmailToHumanObject_result" style="margin-top: 20px; background-color: lavender;"></div>
        </div>
    </div>
    <div id="location_tab_content">
        <p class="vietnamese_english" >This function helps us find the location data more intelligent</p>
    </div>
</div>


<script type="text/javascript">
    function initFancyBoxLinks(frameWidth, frameHeight){
        var w = 800, h = 530;
        if( typeof frameWidth == "undefined" ){
            frameWidth = w;
        }
        if( typeof frameHeight == "undefined"){
            frameHeight = w;
        }

        jQuery("a.use_fancybox").fancybox(
            {
                'hideOnContentClick': false , 'hideOnOverlayClick':false,
                'enableEscapeButton':true, 'autoDimensions' : false,
                'zoomSpeedIn': 300, 'zoomSpeedOut': 300,
                'overlayShow': true , 'frameWidth': frameWidth , 'frameHeight': frameHeight
            }
        );
    }

     jQuery(document).ready(initFormData);

     var checkboxHashmap = {};
     function initFormData(){
         var object_field = {};
         var ObjectID = -1;
         <?php
            if( isset ($object) ) {
                echo " object_field = ".json_encode($object->getFieldValues()).";\n";
                echo " ObjectID = ".$object->getObjectID().";\n";
            }
         ?>
         if(ObjectID > 0){
             var actionUrl = jQuery("#object_instance_form").attr("action") + "/" + ObjectID;
             jQuery("#object_instance_form").attr("action",actionUrl);
             for(var id in object_field) {
                var node_address = "#object_instance_form *[name='field_" + object_field[id].FieldID +"']";

                //hacking for checkbox
                if( jQuery(node_address).attr("type") == "checkbox" ){
                    node_address += "[value='" + object_field[id].FieldValue + "']";
                    if(jQuery(node_address).length >0 ){
                        if(object_field[id].SelectedFieldValue == 1){
                            jQuery(node_address).attr("checked",true);                            
                        }
                        checkboxHashmap[jQuery(node_address).attr("id")] = jQuery(node_address).attr("id");
                        var n = jQuery(node_address).attr("name") + "FVID_" + object_field[id].FieldValueID;
                        jQuery(node_address).attr("name",n);
                    }
                }
                else {
                    jQuery(node_address).setValue( object_field[id].FieldValue );
                    var n = jQuery(node_address).attr("name") + "FVID_" + object_field[id].FieldValueID;
                    jQuery(node_address).attr("name",n);
                }
             }; 
             for(var id in object_field){
                var toks = id.split("FVID_");
                var node_address = "#object_instance_form *[name='field_" + toks[0] +"']";
                var n = jQuery(node_address).attr("name") + "FVID_" + toks[1];
                jQuery(node_address).attr("name",n);
             };
             var f = function(){
                 var n = jQuery(this).attr("name");
                 if( n.split("FVID_").length < 2 ){
                    jQuery(this).attr("name", n + "FVID_0" );
                 }
             };
             jQuery("#object_instance_form *[name*='field_']").each(f);
         }
         else {
             var f = function(){
                 var n = jQuery(this).attr("name")+"FVID_0";
                 jQuery(this).attr("name",n);
             };
             jQuery("#object_instance_form *[name*='field_']").each(f);
         }         
         initFancyBoxLinks(800, 600);

         jQuery("#tabs").tabs();
         initTabRequest();
         initHowCanCommunicateObject();
     }

     function initTabRequest(){
        var toks = location.href.split("#");
        if(toks.length == 2){
         var tabId = toks[1].replace('_content','');
         jQuery("#" + tabId).click();
        }
     }

     function initHowCanCommunicateObject(){
        var email_addresses = "";
        var f = function(){
            email_addresses += (jQuery.trim(jQuery(this).val()) + " ");
        };
        jQuery("#object_instance_form").find("input[class*='email']").each(f);
        if( email_addresses != "" ) {
            jQuery("#communication_tab").parent().slideDown();
        }
        jQuery("#to_addresses").val(jQuery.trim(email_addresses))
     }

     function sendEmailToHumanObject() {
        var url = "<?php echo site_url("services/email_service/send_email") ?>";
        var callback = function(html){
            jQuery("#sendEmailToHumanObject_result").html(html);
        };
        var data = {};
        data.to_addresses = jQuery("#to_addresses").val();
        data.email_subject = jQuery("#email_subject").val();
        data.email_message = jQuery("#email_message").val();
        jQuery.post(url, data , callback);
     }

     function initWhereCanFindObject(){

     }
</script>