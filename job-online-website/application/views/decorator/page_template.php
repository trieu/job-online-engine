<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="content-language" content="en" >
        <?php foreach($meta_tags as $name => $content) { ?>
        <meta name="<?php echo $name;?>" content="<?php echo $content;?>" />
        <?php } ?>

        <title><?php echo $page_title; ?></title>
        <base href="<?php echo base_url()?>" />

        <link type="text/css" media="screen" rel="stylesheet" href="<?= base_url() ?>assets/css/style-general.css"/>
        <link type="text/css" media="screen" rel="stylesheet" href="<?= base_url() ?>assets/css/hope-general.css"/>
        <link type="text/css" media="screen" rel="stylesheet" href="<?= base_url() ?>assets/css/left_menu_style.css"/>
        <link type="text/css" media="screen" rel="stylesheet" href="<?= base_url() ?>assets/css/smoothness/jquery-ui-1.7.2.custom.css"/>
        <link type="text/css" media="screen" rel="stylesheet" href="<?= base_url() ?>assets/css/main_decorator.css"/>

        <!--
        <script type="text/javascript" charset="utf-8" src="http://www.google.com/jsapi"></script>
        -->

        <script language="JavaScript" type="text/javascript" src="<?= base_url()?>assets/js/jquery/jquery.min.js"></script>
        <script language="JavaScript" type="text/javascript" src="<?= base_url()?>assets/js/jquery/jquery-ui-1.7.2.custom.min.js"></script>
        <script language="JavaScript" type="text/javascript" src="<?= base_url()?>assets/js/jquery.bt/jquery.bt.min.js"></script>
        <script type="text/javascript" charset="utf-8" >
            // Load jQuery
            // google.load("jquery", "1");
            // google.load("jqueryui", "1");

            var LanguageChooser = {};
            LanguageChooser.setLanguageBySession = function(){
                var lang_code = jQuery("head meta[http-equiv='content-language']").attr("content");
            }
        </script>

        <?php if($controller == "job_seeker/number_question") { ?>
        <link rel="stylesheet" href="<?= base_url()?>assets/css/js.css" type="text/css" />
        <?php } ?>

        <?php if($controller == "employer/number_question") {?>
        <link rel="stylesheet" href="<?= base_url()?>assets/css/emp.css" type="text/css" />
        <?php } ?>

    </head>
    <body onload="">
        <div id="container">
            <div id="top">
                <?= $page_header ?>
            </div>
            <div id="leftnav">
                <?= $left_navigation ?>
            </div>
            <div id="content">
                <?= $page_content ?>
            </div>
            <div id="footer">
                <?= $page_footer ?>
            </div>
            <div>
                <?= $page_respone_time ?>
                <input id="session_id" type="hidden" name="session_id" value="<?=$session_id?>" />
            </div>
        </div>
    </body>
</html>