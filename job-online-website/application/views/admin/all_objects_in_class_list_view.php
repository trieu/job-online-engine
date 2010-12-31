<style type="text/css">
    .object_holder span {
        min-width: 102px;
    }
    .object_holder {
        border-top: blue solid 1px;
        padding: 10px 10px 10px 50px;
    }
    .object_holder .id{
       color: blue;
       font-size: 16px;
       font-weight: bold;
       margin-left: -40px;
    }
    .object_holder .field_name{
       color:#1C94C4;
       font-size: 13px;
       font-weight: bold;
    }
    .object_holder .field_value{
       color:#000000;
       font-size: 15.5px;
       font-weight: bold;
    }
    .object_holder .actions{
       text-align: right;
       padding-right: 40px;
       color: blue;
    }
    .object_holder .actions a:HOVER{
      font-weight: bold; color: red;
    }
</style>
<?php if( ! isset ($in_search_mode) ) { ?>

    <?php
    addScriptFile("js/jquery.contextmenu/jquery.contextmenu.js");
    addCssFile("js/jquery.contextmenu/style.css");
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function() {
            var f = function(){
                jQuery(this).mouseover(function(){
                    // jQuery(this).css("background-color", "#FFFF99");
                });
                jQuery(this).click(function(){
                    jQuery(".object_holder").css("background-color", "#FFF");
                    jQuery(this).css("background-color", "#FFFF99");
                });
                jQuery(this).mouseout(function(){
                    // jQuery(this).css("background-color", "#FFF");
                });
            };
            jQuery(".object_holder").each(f);
            initConfirmation();
        });
        function initConfirmation(){
            var f = function(){
                var href = jQuery(this).attr("href");
                jQuery(this).attr("href","javascript:void(0)");
                jQuery(this).click(function(){
                    if(confirm("Delete ?")){
                        window.location = href;
                    }
                });
            };
            jQuery("a.confirmation").each(f);
        }
    </script>
    <?php } ?>


<div style="margin-bottom: 20px;">   
    <h3><?php echo $objectClass->getObjectClassName()  ?> </h3>
    <b>
        Display <?php echo $total_records = count($objects) ?> records <br/>
       <?php echo anchor('user/public_object_controller/create_object/'.$objectClass->getObjectClassID(), "Đăng ký ". $objectClass->getObjectClassName() ." mới"); ?>
    </b>
</div>


<?php if($total_records > 0) {
    foreach ($objects as $objID => $fields ) { ?>
        <div class="object_holder focusable_text" id="object_row_<?php echo $objID ?>">
            <a name="<?php echo $objID; ?>"></a>
             <div class="id">ID: <?php echo $objID; ?></div>
                    <?php
                    foreach ($fields as $field ) {
                        if( isset ($field['FieldID'])) {
                            ?>
            <div style="margin-top: 3px;">
                <span class="field_name"><?php echo $field['FieldName'];?></span>
                <span class="field_value"><?php echo $field['FieldValue'];?></span>
            </div>
                            <?php
                        }
                        else {
                            ?>
            <div style="margin-top: 3px;">
                <span class="field_name"><?php echo $field['FieldName'];?></span>
                <span class="field_value"><?php echo $field['FieldValue'];?></span>
            </div>
                            <?php
                        }
                    }
                    ?>
            <div class="actions" >
               <?php echo anchor('user/public_object_controller/edit/'.$objID , 'Xem chi tiết/View Details', array('class'=>'vietnamese_english')) ?>
                <br>
               <?php echo anchor('admin/object_controller/delete/'.$objID."/".$objectClass->getObjectClassID() , 'Xoá/Delete', array('class' => 'confirmation vietnamese_english')) ?>
            </div>
        </div>
      <?php }           
        } else {
      ?>
<div>
    <b>No results were found!</b>
</div>
    <?php } ?>