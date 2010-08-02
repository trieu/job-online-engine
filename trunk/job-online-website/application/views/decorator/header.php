<div class="page_logo"><?= lang('home_page_heading') ?></div>

<div class="page_menu">
    <ul id="top_menu_bar" class="sf-menu">
            <li class="current">
                <?php action_url_a('', lang('home_page')); ?>
            </li>
            <li>
                <a href="javascript: " title="Manage databases">Databases</a>
                <ul>
                    <li>
                        <a href="javascript: " title="<?php echo lang('job_seeker_a_title'); ?>"><?php echo lang('job_seeker'); ?></a>
                        <ul>
                            <li><?php action_url_a('user/public_object_controller/create_object/1',lang('register_new_jobseeker')); ?></li>
                            <li><?php action_url_a('user/public_object_controller/list_objects/job_seekers', lang('list_job_seeker'), lang('list_job_seeker_a_title')); ?></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript: " title="<?php echo lang('employer_a_title'); ?>"><?php echo lang('employer'); ?></a>
                        <ul>
                            <li><?php action_url_a('user/public_object_controller/create_object/2',lang('register_new_employer')); ?></li>
                            <li><?php action_url_a('user/public_object_controller/list_objects/employers', lang('list_employer'),lang('list_employer_a_title')); ?></li>
                        </ul>
                    </li>
                    <li>
                        <?php action_url_a('user/public_object_controller/list_objects/jobs', lang('job'), lang('job_a_title')); ?>
                    </li>
                </ul>
            </li>           
            <li>
                <?php action_url_a('admin/search', lang('search'), lang('search_title')); ?>
            </li>
            <?php
                if($isGroupAdmin){
                    echo '<li>'.anchor('admin/admin_panel', lang('admin_panel'),array("title"=>"Panel for Admin")).'</li>';
                }
            ?>
            <li>
                <a href="javascript:" title="Set Options of database" >Options</a>
                <ul>
                    <li>
                        <a hreflang="en" href="javascript: switchPageToLanguage('tiengviet.php','english.php')" title="Use database in English">Use database in English</a>
                    </li>
                    <li>
                        <a hreflang="en" href="javascript: switchPageToLanguage('english.php','tiengviet.php')" title="Ngôn ngữ hiển thị là tiếng Việt">Ngôn ngữ là Tiếng Việt</a>
                    </li>
                    <li>
                        <a id="page_leftnav_toggle" href="javascript: togglePageNavigation()" class="vietnamese_english" >Ẩn menu trái / Hide Left Navigation</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="http://docs.google.com/View?id=dgsrc7qn_345j7f5smgf" target="_blank" title="Hướng dẫn sử dụng (User Guide) for DRD Admin" class="vietnamese_english" >Hướng dẫn sử dụng/User Guide</a>
            </li>
            <li>
                <a href="http://code.google.com/p/job-online-engine/issues/list" target="_blank" title="Submit your issues" class="vietnamese_english" >Thông báo lỗi/Submit issues</a>
            </li>
    </ul>
</div>

<script type="text/javascript" language="JavaScript">
    function initTooltip(selector){jQuery(selector).bt({shrinkToFit:true,cssStyles:{fontFamily:'"Lucida Grande",Helvetica,Arial,Verdana,sans-serif',fontSize:'12px',padding:'10px 14px'}});}
    jQuery(document).ready(function(){
        if(!jQuery.browser["msie"]){
            initTooltip("#top_menu_bar a");
        }        
        jQuery('#top_menu_bar').superfish();
    });

    function switchPageToLanguage(from, to){
        var currentUrl = window.location + "";
        if(currentUrl == "<?php echo base_url(); ?>" ){
            currentUrl += "tiengviet.php";
        }
        currentUrl = currentUrl.replace(from, to);
        window.location = currentUrl;
    };
</script>