<div>
    <label for="<?= $field_name ?>" class="vietnamese_english" ><?= $field_label ?></label>
    <select name="<?= $field_name ?>"   <?php if($isMultiple){ ?> multiple="multiple" <?php } ?>    >
        <?php foreach ($option_list as $key => $value) { ?>
        <option value="<?= $key ?>" class="vietnamese_english" ><?= $value ?></option>
        <?php } ?>
    </select>
</div>