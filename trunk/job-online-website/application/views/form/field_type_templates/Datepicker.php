<div>
    <label for="<?= $field_name ?>"><?= $field_label ?>:</label>
    <input id="<?= $field_name ?>" type="text" value="" />
</div>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery("#<?= $field_name ?>").datepicker();
    });
</script>