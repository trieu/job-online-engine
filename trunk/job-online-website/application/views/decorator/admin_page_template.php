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
                margin-left: 230px;
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
            .response_time {
                font-weight:normal;
                font-size:small;
            }
        </style>
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
                    <?php echo anchor('job_seeker/number_question/1', lang('job_seeker')); ?>   |
                    <?php echo anchor('employer/number_question/1', lang('employer')); ?>   |
                    <?php echo anchor('home', lang('news_events')); ?>   |
                    <?php echo anchor('home', lang('contact')); ?>   |
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
                    <input id="session_id" type="hidden" name="" value=" <?=$session_id?>" />
                </span>
            </div>
        </div>
    </body>
</html>