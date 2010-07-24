<div>
    <p class="vietnamese_english" ><?= $description ?></p>
    <?php
        foreach ($option_list as $key => $value) {
            $id = get_random_password();
     ?>
        <div class="radiobutton_wrapper">
            <input type="radio" id="<?= $id  ?>" name="<?= $field_name ?>" value="<?= $key ?>" />
            <label for="<?= $id  ?>" class="vietnamese_english" ><?= $value  ?></label>
        </div>
    <?php } ?>
</div>