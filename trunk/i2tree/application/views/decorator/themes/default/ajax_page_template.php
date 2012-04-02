<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta http-equiv="content-language" content="en" />       
        <?php foreach($page_decorator->getPageMetaTags() as $name => $content) { ?>
        <meta name="<?php echo $name;?>" content="<?php echo $content;?>" />
        <?php } ?>
        <base href="<?php echo base_url()?>" />
        <title></title>

        <link type="text/css" media="screen" rel="stylesheet" href="<?php echo base_url() ?>assets/css/style-general.css"/>
        <link type="text/css" media="screen" rel="stylesheet" href="<?php echo base_url() ?>assets/css/hope-general.css"/>
        <link type="text/css" media="screen" rel="stylesheet" href="<?php echo base_url() ?>assets/css/left_menu_style.css"/>
        <link type="text/css" media="screen" rel="stylesheet" href="<?php echo base_url() ?>assets/css/smoothness/jquery.ui.custom.css"/>
        <link type="text/css" media="screen" rel="stylesheet" href="<?php echo base_url() ?>assets/css/main_decorator.css"/>

        <?php foreach($page_decorator->getCssFiles() as $id => $file) { ?>
        <link type="text/css" media="screen" rel="stylesheet" href="<?php echo base_url()."assets/".$file; ?>"/>
        <?php } ?>

        <script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery/jquery.ui.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery/jquery.cookies.js"></script>
         <script type="text/javascript" >
            var $PAGE_LANGUAGE_KEY = "<?php echo str_replace(EXT,"", LANGUAGE_INDEX_PAGE) ; ?>";
        </script>
    </head>
    <body style="display: none;">
        <div>
            <?php echo $page_content ?>
        </div>        
        <?php foreach($page_decorator->getScriptFiles() as $id => $file) { ?>
        <script type="text/javascript" src="<?php echo base_url()."assets/".$file; ?>"></script>
        <?php } ?>
       <script type="text/javascript">
            jQuery(document).ready(function(){
                jQuery("body > div[style='text-align: center;']").remove();
                language_saparator();
                jQuery("body").show();
            });

            function language_saparator(){
                jQuery(".vietnamese_english").each(function(){
                    var toks = jQuery(this).html().split("/");
                    if(toks.length == 2){
                        if($PAGE_LANGUAGE_KEY == "tiengviet"){
                            jQuery(this).html( toks[0] );
                        }
                        else if($PAGE_LANGUAGE_KEY == "english"){
                            jQuery(this).html( toks[1] );
                        }
                    };
                });
            }
        </script>
    </body>
</html>