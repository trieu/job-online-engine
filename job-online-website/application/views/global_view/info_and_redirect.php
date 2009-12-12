<div class="ui-widget">
    <div style="padding: 0pt 0.7em; margin-top: 20px;" class="ui-state-highlight ui-corner-all">
        <span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-info"></span>
        <h3><?= $info_message ?></h3>
        <a href="<?= $redirect_url ?>" >Redirecting to <?= $redirect_url ?></a>       
    </div>
</div>

<script type="text/javascript" >
    function redirectTo(){
        window.location = "<?= $redirect_url ?>";
    }
    setTimeout(redirectTo,3000);
</script>