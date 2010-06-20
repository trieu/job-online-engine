<div align="right" style="text-align:right; height:34px; width:880px;">    

</div>

<h2><?= lang('home_page_heading') ?></h2>

<div style="font-weight:bold; margin: 10px 0px;" class="menu_bar">
    <?php action_url_a('', lang('home_page')); ?>   |
    <?php action_url_a('user/public_object_controller/list_objects/job_seekers', lang('job_seeker'), lang('job_seeker_a_title')); ?>   |
    <?php action_url_a('user/public_object_controller/list_objects/employers', lang('employer'),lang('employer_a_title')); ?>   |
    <?php action_url_a('user/public_object_controller/list_objects/jobs', lang('job'), lang('job_a_title')); ?>   |
    <?php action_url_a('admin/search', lang('search'), lang('search')); ?>   |

    <span style="display:none;">
    <?php action_url_a('home', lang('news_events')); ?>   |
    <?php action_url_a('home', lang('contact')); ?>   |
    </span>
    
    <?php 
        if($isGroupAdmin){
            echo anchor('admin/admin_panel', lang('admin_panel'));
        }
     ?>

    | <a href="http://docs.google.com/View?id=dgsrc7qn_345j7f5smgf" target="_blank" title="Hướng dẫn sử dụng (User Guide) for DRD Admin">Help</a>
</div>
<div class="box accessBox has-access">
    <div class="box access">
        <ul style="font-weight: bold;">
            <?php  if(LANGUAGE_INDEX_PAGE === "tiengviet.php") { ?>
            <li class="accessLanguage">Read this page in <a hreflang="en" href="javascript: switchPageToLanguage('tiengviet.php','english.php')">English</a></li>
            <?php } else if(LANGUAGE_INDEX_PAGE === "english.php") {?>
            <li class="accessLanguage">Ngôn ngữ <a hreflang="en" href="javascript: switchPageToLanguage('english.php','tiengviet.php')">Tiếng Việt</a></li>
            <?php } ?>
            <li><a id="page_leftnav_toggle" href="javascript: togglePageNavigation()">Hide Navigation</a></li>
        </ul>
        <hr/>
    </div>
</div>

<script type="text/javascript" language="JavaScript">
    function initTooltip(){jQuery("div[class='menu_bar'] a").bt({shrinkToFit:true,cssStyles:{fontFamily:'"Lucida Grande",Helvetica,Arial,Verdana,sans-serif',fontSize:'12px',padding:'10px 14px'}});}
    jQuery(document).ready(function(){if(!jQuery.browser["msie"]){initTooltip();}});

    function switchPageToLanguage(from, to){
        var currentUrl = window.location + "";;
        currentUrl = currentUrl.replace(from, to);
        window.location = currentUrl;
    };
</script>

