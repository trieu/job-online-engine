<div id="wrapper_<?php echo $field_name ?>" >
    <p class="vietnamese_english" ><?php echo $description ?></p>
    <?php
        foreach ($option_list as $key => $value) {
            $id = get_random_password();
     ?>
        <div class="radiobutton_wrapper">
            <input type="radio" id="<?php echo $id  ?>" name="<?php echo $field_name ?>" value="<?php echo $key ?>" class="<?php echo $rules ?>" />
            <label for="<?php echo $id  ?>" class="vietnamese_english" ><?php echo $value  ?></label>
        </div>
    <?php } ?>
</div>