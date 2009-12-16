<style type="text/css">
    .odd_row_field {
        background:silver none repeat scroll 0 0;
        width:170px;
        padding-bottom: 5px;
    }
    .even_row_field {
        background:lavender none repeat scroll 0 0;
        width:170px;
        padding-bottom: 5px;
    }
</style>

<div style="display:block; width:100%; border:1px solid silver;" >
    <b>Field list</b>
    <a class="iframe use_fancybox" href="<?= site_url("admin/field_controller/field_details/-1/".$FormID) ?>">Create a field</a>
    <div style="display:block; height:600px;overflow:scroll; margin-bottom:25px;">
        <?php
            $field = new Field();
            foreach ($fields as $idx => $field ) :
        ?>
            <div class="draggable focusable_text <?php if($idx%2 == 1) echo "odd_row_field"; else echo "even_row_field";?>" >
                <div id="<?= Field::$HTML_DOM_ID_PREFIX.$field->getFieldID() ?>" title="<?= $field->getFieldName() ?>">
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
                <Br/>
                <a class="iframe use_fancybox" href="<?= site_url("admin/field_controller/field_details/".$field->getFieldID()."/".$FormID) ?>">Edit</a> |
                <a class="iframe use_fancybox" href="<?= site_url("admin/field_controller/remove_field_from_form/".$field->getFieldID()."/".$FormID) ?>">Remove</a>
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
                'overlayShow': true , 'frameWidth': 800, 'frameHeight': 530
            }
        );
    });
</script>