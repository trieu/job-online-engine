<div>
    <p><?= $description ?></p>
    <?php
        foreach ($option_list as $key => $value) {
            $id = get_random_password();
     ?>
            <input type="radio" id="<?= $id  ?>" name="<?= $field_name ?>" value="<?= $key ?>" />
            <label for="<?= $id  ?>"><?= $value  ?></label>
            <br/>
    <?php } ?>
</div>