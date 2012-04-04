<!DOCTYPE HTML>
<html>
    <head>        
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta http-equiv="content-language" content="en" />
        <meta http-equiv="expires" content="<?php echo(ApplicationHook::getExpireTime(1))?>" />

        <?php foreach($page_decorator->getPageMetaTags() as $name => $content) { ?>
        <meta name="<?php echo $name;?>" content="<?php echo $content;?>" />
        <?php } ?>

        <title><?php echo $page_decorator->getPageTitle(); ?></title>
        <base href="<?php echo base_url()?>" />
                
        <link rel="stylesheet" href="<?php echo base_url() ?>common-assets/css/main_decorator.css"/>
        <link rel="stylesheet" href="<?php echo base_url() ?>common-assets/css/smoothness/jquery.ui.custom.css"/>
        
        <?php foreach($page_decorator->getCssFiles() as $id => $file) { ?>
        <link rel="stylesheet" href="<?php echo base_url()."common-assets/".$file; ?>"/>
        <?php } ?>

        <script type="text/javascript" src="<?php echo base_url()?>common-assets/js/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url()?>common-assets/js/jquery/jquery.ui.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url()?>common-assets/js/jquery/jquery.cookies.js"></script>
        <script type="text/javascript" src="<?php echo base_url()?>common-assets/js/commons.js"></script>
        <script type="text/javascript" >
            var $PAGE_LANGUAGE_KEY = "<?php echo str_replace(EXT,"", LANGUAGE_INDEX_PAGE) ; ?>";
        </script>

        <link rel="stylesheet" href="<?php echo base_url() ?>common-assets/js/jquery.superfish/superfish.css"/>
        <script type="text/javascript" src="<?php echo base_url()?>common-assets/js/jquery.superfish/superfish.js"></script>
        <script type="text/javascript" src="<?php echo base_url()?>common-assets/js/jquery.bt/jquery.bt.min.js"></script>
        
        <?php foreach($page_decorator->getScriptFiles() as $id => $file) { ?>
        <script type="text/javascript" src="<?php echo base_url()."common-assets/".$file; ?>"></script>
        <?php } ?>
    </head>
    <body >
        <div id="page_container">
            <div id="page_top">
                <?php echo $page_header ?>
            </div>
            <div id="page_body">
                <div id="page_leftnav" >
                    <?php echo $left_navigation ?>
                </div>
                <div id="page_content">
                    <?php echo $page_content ?>
                </div>
            </div>            
            <div id="page_footer">
                <?php echo $page_footer ?>
            </div>            
        </div>
        
        <div>
            <div class='processing_time'>
                <span>
                    Processing Time: <?php echo $page_respone_time ?> seconds
                </span>
                <span>-</span>
                <span>
                    Power by:  <a target="_blank" href="http://code.google.com/p/job-online-engine/" title="The engine for Flexible Information System">i2tree</a>
                </span>                
            </div>
            <input id="session_id" type="hidden" name="session_id" value="<?php echo $session_id?>" />
        </div>
        
    </body>
</html>