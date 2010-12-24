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



<?php foreach ($objects as $objID => $fields) {
 ?>
    <div class="object_holder focusable_text" id="object_row_<?= $objID ?>">
        <a name="<?php echo $objID; ?>"></a>
        <div class="id">
            <span>ID: <?php echo $objID; ?></span>
        </div>
    <?php
    foreach ($fields as $field) {
        if (isset($field['FieldID'])) {
    ?>
            <div style="margin-top: 3px;">
                <span class="field_name vietnamese_english"><?php echo $field['FieldName']; ?></span>
                <span class="field_value"><?php echo $field['FieldValue']; ?></span>
            </div>
    <?php
        } else {
    ?>
            <div style="margin-top: 3px;">
                <span class="field_name vietnamese_english"><?php echo $field['FieldName']; ?></span>
                <span class="field_value"><?php echo $field['FieldValue']; ?></span>
            </div>
    <?php
        }
    }
    ?>
    <div class="actions" >
        <?php echo anchor('user/public_object_controller/edit/' . $objID, 'Xem chi tiết/View Details', array('class' => 'vietnamese_english')) ?>
    </div>
</div>   
<?php } ?>