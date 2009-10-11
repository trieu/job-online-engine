<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <?php foreach($meta_tags as $name => $content){ ?>
        <meta name="<?php echo $name;?>" content="<?php echo $content;?>" />
        <?php } ?>

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="content-language" content="en" >
        <title><?php echo $page_title; ?></title>
        <base href="<?php echo base_url()?>" />

        <link type="text/css" rel="stylesheet" href="<?= base_url() ?>assets/css/style-general.css"/>
        <link type="text/css" rel="stylesheet" href="<?= base_url() ?>assets/css/hope-general.css"/>
        <link type="text/css" rel="stylesheet" href="<?= base_url() ?>assets/css/smoothness/jquery-ui-1.7.2.custom.css"/>
        <style type="text/css" media="screen">
            #container
            {
                width: 98%;
                margin: 10px auto;
                background-color: #fff;
                color: #333;               
                line-height: 130%;
            }

            #top
            {
                padding: .5em;
                background-color: white;
                border-bottom: 1px solid gray;
            }

            #top h1
            {
                padding: 0;
                margin: 0;
            }

            #leftnav
            {
                float: left;
                width: 160px;
                margin: 0;
                padding: 1em;
            }

            #content
            {
                margin-left: 300px;
                border-left: 1px solid gray;
                padding: 1em;
                max-width: 36em;
            }

            #footer
            {
                clear: both;
                margin: 0;
                padding: .5em;
                color: #333;
                background-color: #ddd;
                border-top: 1px solid gray;
            }

            #leftnav p { margin: 0 0 1em 0; }
            #content h2 { margin: 0 0 .5em 0; }

        </style>
        <!--
        <script type="text/javascript" charset="utf-8" src="http://www.google.com/jsapi"></script>
         -->
        
        <script language="JavaScript" src="<?= base_url()?>assets/js/jquery/jquery.min.js"></script>
        <script language="JavaScript" src="<?= base_url()?>assets/js/jquery/jquery-ui-1.7.2.custom.min.js"></script>
        <script type="text/javascript" charset="utf-8">
            // Load jQuery
           // google.load("jquery", "1");
           // google.load("jqueryui", "1");
           
           var LanguageChooser = {};
           LanguageChooser.setLanguageBySession = function(){
               var lang_code = jQuery("head meta[http-equiv='content-language']").attr("content");
           }
        </script>
       
<?php if($controller == "job_seeker/number_question"){ ?>
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
                <input id="session_id" type="hidden" name="" value=" <?=$session_id?>" />
            </div>
        </div>
    </body>
</html>