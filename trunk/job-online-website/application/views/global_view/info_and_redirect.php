<div class="ui-widget" id="page_info">
    <div style="padding: 0pt 0.7em; margin-top: 20px;" class="ui-state-highlight ui-corner-all">
        <span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-info"></span>
        <h3><?= $info_message ?></h3>
        <? if (isset ($redirect_url)): ?>
        Vui lòng chọn link sau để trờ về danh sách <br>
           <a href="<?= $redirect_url ?>" ><?= $redirect_url ?></a>
        <? endif; ?>        
    </div>
</div>
<div class="ui-widget" id="page_iframe_info">
    <div style="padding: 0pt 0.7em; margin-top: 20px;" class="ui-state-highlight ui-corner-all">
        <span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-info"></span>
        <h3><?= $info_message ?></h3>
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
            window.location = "<?= $redirect_url ?>";
        <? else: ?>
            parent.window.location.reload();
        <? endif; ?>        
    }

<? if (isset ($reload_page)): ?>
    <? if ($reload_page): ?>
        setTimeout(redirectTo,3300);
    <? else: ?>
        setTimeout(redirectTo,3300);
    <? endif; ?>
<? endif; ?>
</script>