<div id="wrapper_<?= $field_name ?>" class="datapicker_wrapper">
    <label for="<?= $field_name ?>" class="vietnamese_english" ><?= $field_label ?>:</label>
    <a id="manage_gdoc_<?= $field_name ?>" class="" href="#">Google Docs</a>
    <input id="<?= $field_name ?>" name="<?= $field_name ?>" type="text" value="" class="<?= $rules ?>" style="width: 90%" />
    
    <div  style="text-align:center;" >
        <iframe id="gdoc_view_<?= $field_name ?>" src="" frameborder="0" width="99%" height="220" style="display: none;"></iframe>
    </div>
    <!--SCRIPT
        var <?php echo $field_name ?>_init = function(){
            var f = function(){
                var s = $(this).val();
                //if( s.indexOf("https://docs.google.com/View?id=") == 0 )
                {
                    $("#gdoc_view_<?= $field_name ?>").attr('src',s).show();
                }
            };
            $("#<?= $field_name ?>").change(f);
            var gdocsManage = function(){
             //   setGoogleDocsFieldForNode = $(this);
               // var url = "http://google-docs-service.drd-vn-database.com/";
               var url = "https://docs.google.com/#all";
                var win2 = window.open(url, "Google Docs", "width=1100,height=700,scrollbars=yes,location=yes");
                return false;
            };
            $("#manage_gdoc_<?= $field_name ?>").click(gdocsManage);            
        };
        <?php echo $field_name ?>_init();
    -->
</div>
