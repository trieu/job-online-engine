<!DOCTYPE html> 
<html> 
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1"> 
        <?php foreach ($page_decorator->getPageMetaTags() as $name => $content) { ?>
            <meta name="<?php echo $name; ?>" content="<?php echo $content; ?>" />
        <?php } ?>
        <title><?php echo $page_decorator->getPageTitle(); ?></title> 

        <link rel="stylesheet"  href="<?php echo base_url() ?>common-assets/css/jquery.mobile.min.css"/>         
        <script type="text/javascript" src="<?php echo base_url() ?>common-assets/js/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>common-assets/js/jquery/jquery.mobile.min.js"></script>
    </head> 
    <body> 
        <div data-role="page">

            <div data-role="header">
                <a href="<?php site_url('/unit-tests/mobileweb') ?>" data-icon="home" data-iconpos="notext"  class="ui-btn-left">Home</a>
                <h1><?php echo $page_decorator->getPageTitle(); ?></h1>                
            </div><!-- /header -->

            <div data-role="content">	                
                <ul data-role="listview" >
                    <li><a href="#"><?php echo $page_content; ?></a></li>
                    <li><a href="#">Audi</a></li>
                    <li><a href="#">BMW</a></li>
                </ul>
            </div><!-- /content -->

            <div data-role="footer">
                <h4><?php echo $page_decorator->getPageFooter(); ?></h4>
            </div><!-- /footer -->
        </div><!-- /page -->

    </body>
</html>