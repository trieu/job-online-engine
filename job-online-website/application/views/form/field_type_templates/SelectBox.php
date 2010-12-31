<div id="wrapper_<?php echo $field_name ?>" >
    <label for="<?php echo $field_name ?>" class="vietnamese_english" ><?php echo $field_label ?></label>
    <select id="<?php echo $field_name ?>" name="<?php echo $field_name ?>" class="<?php echo $rules ?>"  <?php if($isMultiple){ ?> multiple="multiple" <?php } ?>    >
        <?php foreach ($option_list as $key => $value) { ?>
        <option value="<?php echo $key ?>" class="vietnamese_english" ><?php echo $value ?></option>
        <?php } ?>
    </select>
</div>