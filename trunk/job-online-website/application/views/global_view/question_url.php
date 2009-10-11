<div style="font-weight:bold;font-size:14px;">
    <?php
        $arr =   explode("/number_question/",current_url());
        $next = $arr[1] + 1;
        $prev = $arr[1] - 1;

        echo anchor($controllerName.'/number_question/'.$prev, 'Previous');
        echo "<span style='margin-left:10px'></span>";
        echo anchor($controllerName.'/number_question/'.$next, 'Next');
    ?>
</div>