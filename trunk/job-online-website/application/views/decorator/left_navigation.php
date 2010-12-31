<?php function renderUserGroupOfActions($group_id, $group_name, $action_names, $isShow = TRUE) { ?>
    <div class="group_action">
        <h3 onclick="jQuery('#<?php echo $group_id ?>').slideToggle('slow');">
            <a href="javascript:void(0)" class="vietnamese_english" ><?php echo $group_name ?></a>
        </h3>
        <ul id="<?php echo $group_id ?>"  class="<?php if(!$isShow) echo "display_none"; ?>" >
            <?php foreach ($action_names as $action_name => $action_uri) {
                echo '<li><a class="vietnamese_english focusable_text" href="'.site_url($action_uri).'">'.$action_name.'</a></li>';
            }?>
        </ul>
    </div>
<?php } ?>

<?php if($is_login == FALSE): ?>
     <?php echo validation_errors(); ?>
     <?php echo form_open('welcome/login'); ?>

        <div style="width:98%;font-weight:bold" >            
            <div>
                <label for="user_email" >Email</label>
                <input id="user_email" type="text" name="email" value="" style="width:100%;" />
            </div>
            <div style="margin-top:5px;" >
                <label for="user_password" >Password</label>
                <input id="user_password" type="password" name="password" value="" style="width:100%;"/>
            </div>
            <div style="margin-top:8px; float: right;" >
                <input type="submit" value="Login" />
            </div>            
        </div>
        <input type="hidden" name="url_redirect" value="<?php if(isset ($_GET['url_redirect'])) echo $_GET['url_redirect']; ?>" />

     <?php echo form_close(''); ?>

     <div style="display: none;" >
        <?php echo anchor('welcome/activate', 'Activate'); ?>
        <?php echo anchor('welcome/register', 'Register'); ?>
     </div>
     
     <script type="text/javascript">togglePageNavigation(true);</script>
 <?php else: ?>   
        
    <div class="floating-menu" id="left_action_list" ></div>

    <?php
    $action_names  = array(
        "Đăng ký người tìm việc / Register new Job Seeker" => "user/public_object_controller/create_object/1"
        ,"Đăng ký nhà tuyển dụng / Register new Employer" => "user/public_object_controller/create_object/2"
        ,"Tìm kiếm / Search" => "admin/search"
        ,"Truy vấn dữ diệu / Database queries" => "admin/search/list_all_query_details"
        ,"Thống kê dữ liệu / Statistics" => "admin/search/load_form_statistics"
        ,"Xuất dữ liệu cho Excel / Export data for Excel" => "admin/search/load_form_export_data"
    );
    renderUserGroupOfActions("usergroup_menu","Menu", $action_names);
    ?>
   
<?php endif; ?>

