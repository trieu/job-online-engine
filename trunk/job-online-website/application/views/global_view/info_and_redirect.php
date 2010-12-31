<div class="ui-widget" id="page_info">
    <div style="padding: 0pt 0.7em; margin-top: 20px;" class="ui-state-highlight ui-corner-all">
        <span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-info"></span>
        <h3><?php echo $info_message ?></h3>
        <? if (isset ($redirect_url)): ?>
        Vui lòng chọn link sau để trờ về danh sách <br>
           <a href="<?php echo $redirect_url ?>" ><?php echo $redirect_url ?></a>
        <? endif; ?>        
    </div>
</div>
<div class="ui-widget" id="page_iframe_info">
    <div style="padding: 0pt 0.7em; margin-top: 20px;" class="ui-state-highlight ui-corner-all">
        <span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-info"></span>
        <h3><?php echo $info_message ?></h3>
        <a href="javascript: parent.window.location.reload();">Refresh Page</a>
    </div>
</div>

<script type="text/javascript" >
    
    function isInIFrame() {
        if(typeof parent != "undefined" ){
                jQuery("#page_info").hide();
                jQuery("#page_iframe_info").show();                
        }
    }
    isInIFrame();
    
    function redirectTo(){
        <? if (isset ($redirect_url)): ?>
            jQuery("#page_info").show();
            jQuery("#page_iframe_info").hide();
            window.location = "<?php echo $redirect_url ?>";
        <? else: ?>
            parent.window.location.reload();
        <? endif; ?>        
    }

<? if (isset ($reload_page)): ?>
    <? if ($reload_page): ?>
        jQuery("#page_info").show();
        jQuery("#page_iframe_info").hide();
        setTimeout(redirectTo,3600);
    <? else: ?>
        setTimeout(redirectTo,3600);
    <? endif; ?>
<? endif; ?>
</script>