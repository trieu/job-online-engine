<b>Field list</b>
<div class="" style="display:block; width:200px; height:600px;overflow:scroll; margin-bottom:25px;">
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
            <?php echo $fieldtypes[$field->getFieldTypeID()] ?>
        </div>
    <?php endforeach ?>
</div>