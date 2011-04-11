<div id="wrapper_<?php echo $field_name ?>" >
    <label for="<?php echo $field_name ?>" class="vietnamese_english" ><?php echo $field_label ?></label>
    <select id="<?php echo $field_name ?>" dropdownchecklist="true" name="<?php echo $field_name ?>" class="<?php echo $rules ?>" multiple="multiple" style="white-space: nowrap; width: 75%;height: 80px;display: none;" >
        <?php foreach ($option_list as $key => $value) { ?>
        <option value="<?php echo $key ?>" class="vietnamese_english" ><?php echo $value ?></option>
        <?php } ?>
    </select>

    <!--SCRIPT
    jQuery(document).ready(function(){
        var f = function(){
            var opts = {icon: {}, width: 260, maxDropHeight: 210};
            jQuery("#<?php echo $field_name ?>").dropdownchecklist(opts);
        };
        setTimeout(f, 500);
    });
    -->
</div>