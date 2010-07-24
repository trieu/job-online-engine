<div>
    <p class="vietnamese_english" ><?= $description ?></p>
    <?php
        foreach ($option_list as $key => $value) {
            $id = get_random_password();
     ?>
        <div class="checkbox_wrapper">
            <input type="checkbox" id="<?= $id  ?>" name="<?= $field_name ?>" value="<?= $key ?>" />
            <label for="<?= $id  ?>" class="vietnamese_english" ><?= $value  ?></label>           
        </div>
    <?php } ?>
</div>