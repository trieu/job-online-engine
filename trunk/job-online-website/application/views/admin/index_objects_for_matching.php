<style type="text/css">
fieldset { border:1px solid green; margin: 12px 5px 5px 5px; }
legend {
  padding: 0.2em 0.5em;
  border:1px solid blue;
  color:blue;
  font-size:90%;
  text-align:right;
  font-weight: bold;
}
</style>

<fieldset>
    <legend>Set up the Index for Matching Engine</legend>
    <div style="margin: 27px 5px 10px">
        <input type="radio" checked name="index_as_new" value="true" /> Create new Index for All Objects <br>
        <input type="radio" name="index_as_new" value="false" /> Update increasementally the index for All Objects: <br>

        <input type="button" value="Do indexing all objects" onclick="index_all_objects()" />

        <div id="index_all_objects_working" style="display: none; font-weight: bold; font-size: 17px;">Working ...</div>
        <div id="index_all_objects_result"></div>
    </div>
</fieldset>

<script  type="text/javascript">
    function index_all_objects(){
        var callback = function(html){
            jQuery("#index_all_objects_result").html(html);
            jQuery("#index_all_objects_working").hide();
        };

        var url = "<?= site_url('admin/search_indexer/index_all_objects/') ?>";
        var index_as_new = jQuery("input[name='index_as_new']:checked").val();
        url += ("/"+index_as_new);
        jQuery.get(url , {}, callback);
        jQuery("#index_all_objects_working").show();
    }
</script>