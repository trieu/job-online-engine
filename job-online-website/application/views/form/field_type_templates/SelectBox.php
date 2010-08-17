<div id="wrapper_<?= $field_name ?>" >
    <label for="<?= $field_name ?>" class="vietnamese_english" ><?= $field_label ?></label>
    <select id="<?= $field_name ?>" name="<?= $field_name ?>" class="<?= $rules ?>"  <?php if($isMultiple){ ?> multiple="multiple" <?php } ?>    >
        <?php foreach ($option_list as $key => $value) { ?>
        <option value="<?= $key ?>" class="vietnamese_english" ><?= $value ?></option>
        <?php } ?>
    </select>
</div>