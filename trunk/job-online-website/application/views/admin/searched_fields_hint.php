<div style="display:block; border:1px solid silver;" >
    <div style="display:block; height:420px;overflow:scroll; margin-bottom:10px;">
        <?php
            $field = new Field();
            foreach ($fields as $idx => $field ) :
            $ext_css_class = " odd_row_field ";
            if( $idx % 2 === 1) {
                $ext_css_class = " even_row_field ";
            }
            if( FieldType::isSelectableType($field->getFieldTypeID()) && $field->getFieldTypeID() != FieldType::$CHECK_BOX ) {
                $ext_css_class .= " selectable_field ";
            }
        ?>
            <div class="draggable focusable_text <?php echo $ext_css_class;?> " >
                <div id="<?php echo Field::$HTML_DOM_ID_PREFIX.$field->getFieldID() ?>" title="<?php echo $field->getFieldName() ?>" >
                    <?php
                        if(strlen($field->getFieldName()) < 50){
                            echo $field->getFieldName();
                        }
                        else {
                            echo substr($field->getFieldName(), 0, 50)."...";
                        }
                    ?>
                    <br>
                    <a href="javascript:void(0)" title="Add this field" onclick="selectSearchedField(<?php echo $field->getFieldID() ?>,<?php echo $field->getFieldTypeID() ?>)">Add</a>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</div>