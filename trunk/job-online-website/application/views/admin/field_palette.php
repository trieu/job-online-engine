

<div  style="display:block; width:100%; border:1px solid silver;">
    <b>Field list</b>
    <a class="iframe use_fancybox" href="<?= site_url("admin/field_controller/field_details/-1/".$FormID) ?>">Create a field</a>
    <div style="display:block; height:600px;overflow:scroll; margin-bottom:25px;">
        <?php
            $field = new Field();
            foreach ($fields as $field ) :
        ?>
            <div class="draggable focusable_text" style="width:150px;height:60px;">
                <div id="<?= Field::$HTML_DOM_ID_PREFIX.$field->getFieldID() ?>" >
                    <a href="javascript:void(0)" title="<?= $field->getFieldName() ?>">
                        <?php
                            if(strlen($field->getFieldName()) < 50){
                                echo $field->getFieldName();
                            }
                            else {
                                echo substr($field->getFieldName(), 0, 50)."...";
                            }
                        ?>
                    </a>
                </div>
                <?php echo FieldType::getDefinedTypeName($field->getFieldTypeID()); ?>
                <a class="iframe use_fancybox" href="<?= site_url("admin/field_controller/field_details/".$field->getFieldID()) ?>">Edit</a>
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