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
<div style="display:block; width:180px; border:1px solid silver;" >
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
                    <br>
                    <a href="javascript:void(0)" title="Search this field">Select</a>
                </div> 
            </div>
        <?php endforeach ?>
    </div>
</div>