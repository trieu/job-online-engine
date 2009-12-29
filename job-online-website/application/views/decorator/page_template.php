<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta http-equiv="content-language" content="en" />
        <meta http-equiv="expires" content="<?php echo(ApplicationHook::getExpireTime(1))?>" />

        <?php foreach($page_decorator->getPageMetaTags() as $name => $content) { ?>
        <meta name="<?php echo $name;?>" content="<?php echo $content;?>" />
        <?php } ?>

        <title><?php echo $page_decorator->getPageTitle(); ?></title>
        <base href="<?php echo base_url()?>" />

        <link type="text/css" media="screen" rel="stylesheet" href="<?= base_url() ?>assets/css/style-general.css"/>
        <link type="text/css" media="screen" rel="stylesheet" href="<?= base_url() ?>assets/css/hope-general.css"/>
        <link type="text/css" media="screen" rel="stylesheet" href="<?= base_url() ?>assets/css/left_menu_style.css"/>
        <link type="text/css" media="screen" rel="stylesheet" href="<?= base_url() ?>assets/css/smoothness/jquery-ui-1.7.2.custom.css"/>
        <link type="text/css" media="screen" rel="stylesheet" href="<?= base_url() ?>assets/css/main_decorator.css"/>

        <?php foreach($page_decorator->getCssFiles() as $id => $file) { ?>
        <link type="text/css" media="screen" rel="stylesheet" href="<?php echo base_url()."assets/".$file; ?>"/>
        <?php } ?>

        <script type="text/javascript" src="<?= base_url()?>assets/js/jquery/jquery.min.js"></script>    
    </head>
    <body>
        <div id="page_container">
            <div id="page_top">
                <?= $page_header ?>
            </div>
            <div id="page_leftnav">
                <?= $left_navigation ?>
            </div>
            <div id="page_content">
                <?= $page_content ?>
            </div>
            <div id="page_footer">
                <?= $page_footer ?>
            </div>
            <div>
                <?= $page_respone_time ?>
                <input id="session_id" type="hidden" name="session_id" value="<?=$session_id?>" />
            </div>
        </div>
        <script type="text/javascript" src="<?= base_url()?>assets/js/jquery/jquery-ui-1.7.2.custom.min.js"></script>
        <script type="text/javascript" src="<?= base_url()?>assets/js/jquery.bt/jquery.bt.min.js"></script>
        <script type="text/javascript" src="<?= base_url()?>assets/js/commons.js"></script>
        <?php foreach($page_decorator->getScriptFiles() as $id => $file) { ?>
        <script type="text/javascript" src="<?php echo base_url()."assets/".$file; ?>"></script>
        <?php } ?>
        <script type="text/javascript">
            jQuery(document).ready(function(){
                jQuery("body > div[style='text-align: center;']").remove();
            });
        </script>   
    </body>
</html>