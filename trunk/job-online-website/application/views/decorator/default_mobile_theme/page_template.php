<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta http-equiv="content-language" content="en" />       
        <?php foreach($page_decorator->getPageMetaTags() as $name => $content) { ?>
        <meta name="<?php echo $name;?>" content="<?php echo $content;?>" />
        <?php } ?>
        <base href="<?php echo base_url()?>" />
        <title><?php echo $page_decorator->getPageTitle(); ?></title>     
    </head>
    <body>
        <div >
            <?php echo $page_header ?>
        </div>
        <div>
            <?php echo $page_content ?>
        </div>
        <div >
            <?php echo $page_footer ?>
        </div>
    </body>
</html>