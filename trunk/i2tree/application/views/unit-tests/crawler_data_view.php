<a id="data_url" href="#" target="_blank" ></a>
<div id="data_view" style="display: none;"></div>

<script type="text/javascript" >
    var setDataCallback = function(data) {
        jQuery('#data_url').html(data.url).attr('href',data.url);       
        jQuery('#data_view').html(data.content);
    };
    
    jQuery.cachedScript = function(url, options) {
        // allow user to set any option except for dataType, cache, and url
        options = $.extend(options || {}, {
            dataType: "script",
            cache: true,
            url: url,
            error: function() {               
                jQuery('#data_view').html('Resource is not found!').show();  
            }
        });
        // Use $.ajax() since it is more flexible than $.getScript
        // Return the jqXHR object so we can chain callbacks
        return jQuery.ajax(options);
    };

    jQuery.cachedScript('<?php echo $data_url ?>').done(function(script, textStatus) {
        jQuery('#data_view').slideDown();
    });
</script>
