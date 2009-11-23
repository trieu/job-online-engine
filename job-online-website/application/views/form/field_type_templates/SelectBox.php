<div>
    <label for="<?= $field_name ?>"><?= $field_label ?></label>
    <select name="<?= $field_name ?>"   <?php if($isMultiple){ ?> multiple="multiple" <?php } ?>    >
        <?php foreach ($option_list as $key => $value) { ?>
        <option value="<?= $key ?>"><?= $value ?></option>
        <?php } ?>
    </select>
</div>