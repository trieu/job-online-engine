<div id="wrapper_<?php echo $field_name ?>" class="datapicker_wrapper">
    <label for="<?php echo $field_name ?>" class="vietnamese_english" ><?php echo $field_label ?>:</label>
    <input id="<?php echo $field_name ?>" name="<?php echo $field_name ?>" type="text" value="" class="<?php echo $rules ?>" />
    <!--SCRIPT
        var <?php echo $field_name ?>_init = function(){
            var options = {autoSize: true , constrainInput: true };
            <?php  if(LANGUAGE_INDEX_PAGE == "tiengviet.php") { ?>
            options.dateFormat = 'dd/mm/yy';
            options.changeYear = true;
            options.yearRange = '1950:2010';
            options.dayNamesMin = ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'];
            options.monthNames = ['Tháng 1,','Tháng 2,','Tháng 3,','Tháng 4,','Tháng 5,','Tháng 6,','Tháng 7,','Tháng 8,','Tháng 9,','Tháng 10,','Tháng 11,','Tháng 12,'];
            options.nextText = 'Tháng kế tiếp' ;
            options.prevText = 'Tháng trước' ;
            <? } ?>
            jQuery("#<?php echo $field_name ?>").datepicker(options);
        };
        <?php echo $field_name ?>_init();
    -->
</div>
