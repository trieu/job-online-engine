<div class="ui-widget" id="page_info">
    <div style="padding: 0pt 0.7em; margin-top: 20px;" class="ui-state-highlight ui-corner-all">
        <span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-info"></span>
        <h3><?= $info_message ?></h3>
        <? if (isset ($redirect_url)): ?>
        Vui lòng chọn link sau để trờ về danh sách <br>
           <a href="javascript: redirectTo()" ><?= $redirect_url ?></a>
        <? endif; ?>        
    </div>
</div>

<script type="text/javascript" >        
    function redirectTo(){
        <? if (isset ($redirect_url)): ?>
            if(typeof parent == "object" ) {
                parent.window.location = "<?= $redirect_url ?>";
            }
            else {
                window.location = "<?= $redirect_url ?>";
            }
        <? else: ?>
            parent.window.location.reload();
        <? endif; ?>        
    }

<? if (isset ($reload_page)): ?>
    <? if ($reload_page): ?>
        setTimeout(redirectTo,2000);
    <? else: ?>
        setTimeout(redirectTo,2000);
    <? endif; ?>
<? endif; ?>
</script>