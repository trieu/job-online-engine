<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <?php foreach($meta_tags as $name => $content) { ?>
        <meta name="<?php echo $name;?>" content="<?php echo $content;?>" />
        <?php } ?>

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="content-language" content="en" >
        <title><?php echo $page_title; ?></title>
        <base href="<?= base_url()?>" />

        <link type="text/css" media="screen" rel="stylesheet" href="<?= base_url() ?>assets/css/style-general.css"/>
        <link type="text/css" media="screen" rel="stylesheet" href="<?= base_url() ?>assets/css/hope-general.css"/>
        <link type="text/css" media="screen" rel="stylesheet" href="<?= base_url() ?>assets/css/left_menu_style.css"/>
        <link type="text/css" media="screen" rel="stylesheet" href="<?= base_url() ?>assets/css/smoothness/jquery-ui-1.7.2.custom.css"/>
        <link type="text/css" media="screen" rel="stylesheet" href="<?= base_url() ?>assets/css/main_decorator.css"/>           
        
        <!--
        <script type="text/javascript" charset="utf-8" src="http://www.google.com/jsapi"></script>
        -->

        <script language="JavaScript" src="<?= base_url()?>assets/js/jquery/jquery.min.js"></script>
        <script language="JavaScript" src="<?= base_url()?>assets/js/jquery/jquery-ui-1.7.2.custom.min.js"></script>

    </head>
    <body onload="">
        <div id="container">
            <div id="top">
                <h2>Administration Panel for Job Online</h2>
                <div style="font-weight:bold; margin: 10px 0px;">
                    <?php echo anchor('', lang('home_page')); ?>   |
                    <?php echo anchor('admin/admin_panel', lang('admin_panel')); ?>
                </div>
                <div class="box accessBox has-access">
                    <div class="box access">
                        <ul>
                            <?php  if(LANGUAGE_INDEX_PAGE === "tiengviet.php") { ?>
                            <li class="accessLanguage">This page in <a hreflang="en" href="<?= base_url() ?>english.php">English</a></li>
                            <?php } else if(LANGUAGE_INDEX_PAGE === "english.php") {?>
                            <li class="accessLanguage">Xem trang bằng <a hreflang="en" href="<?= base_url() ?>tiengviet.php">Tiếng Việt</a></li>
                                <?php } ?>

                            <li class="accessInfo"><a accesskey="0" href="http://drdvietnam.com/access">Hỗ trợ tiếp cận thông tin</a></li>
                            <li class="layoutStyle">
                                Giao diện:
                                <ul>
                                    <li>Thông thường</li>
                                    <li><a href="http://drdvietnam.com/zoom/page/splash">Phóng to</a></li>
                                </ul>
                            </li>
                        </ul>
                        <hr/>
                    </div>
                </div>

            </div>
            <div id="leftnav">
                <?= $left_navigation ?>
            </div>
            <div id="content">
                <?= $page_content ?>
            </div>
            <div id="footer">
                <span class="response_time_span">
                    <?= $page_respone_time ?>
                    <input id="session_id" type="hidden" name="session_id" value="<?=$session_id?>" />
                </span>
            </div>
        </div>
    </body>
</html>