<table width="100%">
    <tr>
        <td width="85%">
            <div class="page_logo">
                <?php action_url_a('', lang('home_page_heading'), lang('home_page')); ?>
            </div>
        </td>
        <td width="15%" >
             <?php if($is_login == TRUE): ?>
                <div style="font-weight: bold; white-space: nowrap;float: right;">
                    <span class="vietnamese_english" >Tên đăng nhập: / Login name: </span>
                    <a title="<?php echo $first_name;?>" href="javascript:"><?php echo $login_name;?></a>
                </div>
                <div style="margin-bottom: 15px;float: right;">
                    <?php action_url_a('welcome/logout', 'Logout'); ?>
                </div>
            <?php endif; ?>
        </td>
    </tr>
</table>

<div class="page_menu">
    <ul id="top_menu_bar" class="sf-menu">            
            <li class="current">
                <a href="javascript: " title="<?php echo lang('databases_title'); ?>"><?php echo lang('databases'); ?></a>
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
                <a href="javascript:" title="<?php echo lang('database_tools_title'); ?>" ><?php echo lang('database_tools'); ?></a>
                <ul>
                    <li>
                        <?php action_url_a('admin/search', lang('search'), lang('search_title')); ?>
                    </li>
                    <li>
                        <a href="<?php echo site_url("admin/search/load_form_statistics") ?>" class="vietnamese_english">Thống kê dữ liệu / Statistics</a>
                    </li>
                    <li>
                        <a href="<?php echo site_url("admin/search/load_form_export_data") ?>" class="vietnamese_english">Xuất dữ liệu Excel / Export data for Excel</a>
                    </li>
                    <li>
                        <a href="<?php echo site_url("services/email_service/config_user_email") ?>" class="vietnamese_english" >Dịch vụ Email / Email Service</a>
                    </li>
                </ul>
            </li>           
            <li>
                <a href="javascript:" title="" ><?php echo lang('options'); ?></a>
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
                <a href="<?php echo site_url("user/user_guide_controller") ?>" title="Hướng dẫn sử dụng (User Guide) for DRD Admin" class="vietnamese_english" >Hướng dẫn sử dụng/User Guide</a>
            </li>
            <li>
                <a href="http://code.google.com/p/job-online-engine/issues/list" target="_blank" title="Submit your issues" class="vietnamese_english" >Thông báo lỗi/Submit issues</a>
            </li>
            <?php
                if($isGroupAdmin){
                    echo '<li>'.anchor('admin/admin_panel', lang('admin_panel'),array("title"=>"Panel for Database Admin")).'</li>';
                }
            ?>
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