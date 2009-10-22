
<b>Field list</b>
<div class="" style="display:block; width:200px; height:600px;overflow:scroll">
    <?php
        $field = new Field();
        foreach ($fields as $field ) :
    ?>
        <div class="draggable" style="width:150px;height:60px;">
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


<script type="text/javascript">
    jQuery(document).ready(function() {        
    });
</script>

<div style="display:none">
    <div class="draggable">
        <input type="text" name="__field_name__" value="" style="width: 100%;"/>
    </div>
    <div class="draggable">
        <textarea name="__field_name__" rows="4" cols="20" style="width: 100%;">
        </textarea>
    </div>
    <div class="draggable">
        <select name="__field_name__">
            <option>1</option>
            <option>2</option>
        </select>
    </div>
    <div class="draggable">
        <select name="__field_name__" multiple="true">
            <option>1</option>
            <option>2</option>
        </select>
    </div>
    <div class="draggable">
        <input type="checkbox" name="__field_name__" value="ON" />
    </div>
    <div class="draggable">
        <input type="radio"  name="__field_name__" value=""  />
    </div>
</div>