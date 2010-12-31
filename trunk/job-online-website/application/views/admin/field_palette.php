<style type="text/css">
    .odd_row_field {
        background:silver none repeat scroll 0 0;      
        padding-bottom: 5px;
    }
    .even_row_field {
        background:lavender none repeat scroll 0 0;       
        padding-bottom: 5px;
    }    
</style>

<div style="width:100%; border:1px solid silver;" >    
    <a class="iframe use_fancybox" href="<?php echo site_url("admin/field_controller/field_details/-1/".$FormID) ?>"><b>Create a field</b></a>
    <div style="height:600px;overflow:scroll; margin: 9px 0 25px 0;">
        <?php
            $field = new Field();
            foreach ($fields as $idx => $field ) :
        ?>
            <div class="draggable focusable_text <?php if($idx%2 == 1) echo "odd_row_field"; else echo "even_row_field";?>" >
                <div id="<?php echo Field::$HTML_DOM_ID_PREFIX.$field->getFieldID() ?>" title="<?php echo $field->getFieldName() ?>">
                        <?php                            
                            if(strlen($field->getFieldName()) < 50){
                                echo $field->getFieldName();
                            }
                            else {
                                echo substr($field->getFieldName(), 0, 50)."...";
                            }
                        ?>                    
                </div>
                <?php echo FieldType::getDefinedTypeName($field->getFieldTypeID()); ?>
                <br/>
                <a class="iframe use_fancybox" href="<?php echo site_url("admin/field_controller/field_details/".$field->getFieldID()."/".$FormID) ?>">Edit</a> |
                <a class="iframe use_fancybox" href="<?php echo site_url("admin/field_controller/remove_field_from_form/".$field->getFieldID()."/".$FormID) ?>">Remove</a>
            </div>
        <?php endforeach ?>
    </div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function() {
       jQuery("a.use_fancybox").fancybox(
            {
                'hideOnContentClick': false , 'hideOnOverlayClick':false,
                'enableEscapeButton':true,
                'zoomSpeedIn': 300, 'zoomSpeedOut': 300,
                'overlayShow': true , 'frameWidth': 820, 'frameHeight': 590
            }
        );
    });
</script>