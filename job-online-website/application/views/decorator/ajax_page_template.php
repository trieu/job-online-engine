<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta http-equiv="content-language" content="en" />       
        <?php foreach($page_decorator->getPageMetaTags() as $name => $content) { ?>
        <meta name="<?php echo $name;?>" content="<?php echo $content;?>" />
        <?php } ?>        
        <base href="<?= base_url()?>" />
        
        <link type="text/css" media="screen" rel="stylesheet" href="<?= base_url() ?>assets/css/style-general.css"/>
        <link type="text/css" media="screen" rel="stylesheet" href="<?= base_url() ?>assets/css/hope-general.css"/>
        <link type="text/css" media="screen" rel="stylesheet" href="<?= base_url() ?>assets/css/left_menu_style.css"/>
        <link type="text/css" media="screen" rel="stylesheet" href="<?= base_url() ?>assets/css/smoothness/jquery-ui-1.7.2.custom.css"/>
        <link type="text/css" media="screen" rel="stylesheet" href="<?= base_url() ?>assets/css/main_decorator.css"/>

        <?php foreach($page_decorator->getCssFiles() as $id => $file) { ?>
        <link type="text/css" media="screen" rel="stylesheet" href="<?php echo base_url()."assets/".$file; ?>"/>
        <?php } ?>

        <script type="text/javascript" src="<?= base_url()?>assets/js/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="<?= base_url()?>assets/js/jquery/jquery-ui-1.7.2.custom.min.js"></script>

        <?php foreach($page_decorator->getScriptFiles() as $id => $file) { ?>
        <script type="text/javascript" src="<?php echo base_url()."assets/".$file; ?>"></script>
        <?php } ?>
    </head>
    <body>
       <?= $page_content ?>           
    </body>
</html>