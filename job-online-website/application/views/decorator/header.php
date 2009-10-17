<div align="right">
    <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" height="64" width="880">
        <param name="movie" value="images/banner.swf">
        <param name="quality" value="high">
        <embed src="home_files/banner.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" height="64" width="880">
    </object>
</div>    
<h1>Job Online</h1>
<div style="font-weight:bold; margin: 10px 0px;">
    <?php echo anchor('', lang('home_page')); ?>   |
    <?php echo anchor('job_seeker/number_question/1', lang('job_seeker')); ?>   |
    <?php echo anchor('employer/number_question/1', lang('employer')); ?>   |
    <?php echo anchor('home', lang('news_events')); ?>   |
    <?php echo anchor('home', lang('contact')); ?>   |
    <?php 
        if($isGroupAdmin){
            echo anchor('admin/admin_panel', lang('admin_panel'));
        }
     ?>
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
