<div align="right" style="text-align:right; height:34px; width:880px;">    

</div>

<h2><?= lang('home_page_heading') ?></h2>

<div style="font-weight:bold; margin: 10px 0px;" class="menu_bar">
    <?php echo anchor('', lang('home_page')); ?>   |
    <?php echo anchor('admin/object_controller/list_all/1', lang('job_seeker'), array("title"=>lang('job_seeker_a_title'))); ?>   |
    <?php echo anchor('admin/object_controller/list_all/2', lang('employer'), array("title"=>lang('employer_a_title'))); ?>   |

    <span style="display:none;">
    <?php echo anchor('home', lang('news_events')); ?>   |
    <?php echo anchor('home', lang('contact')); ?>   |
    </span>
    
    <?php 
        if($isGroupAdmin){
            echo anchor('admin/admin_panel', lang('admin_panel'));
        }
     ?>

    | <a href="http://docs.google.com/View?id=dgsrc7qn_345j7f5smgf" target="_blank" title="Hướng dẫn sử dụng (User Guide) for DRD Admin">Hướng dẫn sử dụng (User Guide)</a>
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

<script type="text/javascript" language="JavaScript">
    function initTooltip(){jQuery("div[class='menu_bar'] a").bt({shrinkToFit:true,cssStyles:{fontFamily:'"Lucida Grande",Helvetica,Arial,Verdana,sans-serif',fontSize:'12px',padding:'10px 14px'}});}
    jQuery(document).ready(function(){if(!jQuery.browser["msie"]){initTooltip();}});
</script>

