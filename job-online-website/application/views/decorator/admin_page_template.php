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

        <link type="text/css" media="screen" rel="stylesheet" href="<?php echo base_url() ?>assets/css/style-general.css"/>
        <link type="text/css" media="screen" rel="stylesheet" href="<?php echo base_url() ?>assets/css/hope-general.css"/>
        <link type="text/css" media="screen" rel="stylesheet" href="<?php echo base_url() ?>assets/css/left_menu_style.css"/>
        <link type="text/css" media="screen" rel="stylesheet" href="<?php echo base_url() ?>assets/css/smoothness/jquery-ui-1.7.2.custom.css"/>
        <link type="text/css" media="screen" rel="stylesheet" href="<?php echo base_url() ?>assets/css/main_decorator.css"/>

        <?php foreach($page_decorator->getCssFiles() as $id => $file) { ?>
        <link type="text/css" media="screen" rel="stylesheet" href="<?php echo base_url()."assets/".$file; ?>"/>
            <?php } ?>

        <script type="text/javascript" src="<?= base_url()?>assets/js/jquery/jquery.min.js"></script>
    </head>
    <body onload="">
        <div id="page_container">
            <div id="page_top">

                <h2><?= lang('admin_page_heading') ?></h2>

                <div style="font-weight:bold; margin: 10px 0px;">
                    <?php echo anchor('', lang('home_page')); ?>   |
                    <?php echo anchor('admin/object_controller/list_objects/job_seekers', lang('job_seeker'), array("title"=>lang('job_seeker_a_title'))); ?>   |
                    <?php echo anchor('admin/object_controller/list_objects/jobs', lang('employer'), array("title"=>lang('employer_a_title'))); ?>   |
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
            <div id="page_leftnav">
                <?php echo $left_navigation ?>
            </div>
            <div id="page_content">
                <?php echo $page_content ?>
            </div>
            <div id="page_footer">
                <span class="response_time_span">
                    <?php echo $page_respone_time ?>
                    <input id="session_id" type="hidden" name="session_id" value="<?php echo $session_id?>" />
                </span>
            </div>
        </div>

        <script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery/jquery-ui-1.7.2.custom.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.bt/jquery.bt.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url()?>assets/js/commons.js"></script>
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