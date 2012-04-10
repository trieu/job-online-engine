<?php

function renderUserGroupOfActions($group_id, $group_name, $action_names, $isShow = TRUE) { ?>
    <div class="group_action">
        <h3 onclick="jQuery('#<?php echo $group_id ?>').slideToggle('slow');">
            <a href="javascript:void(0)" class="vietnamese_english" ><?php echo $group_name ?></a>
        </h3>
        <ul id="<?php echo $group_id ?>"  class="<?php if (!$isShow) echo "display_none"; ?>" >
            <?php
            foreach ($action_names as $action_name => $action_uri) {
                $hrefVal = site_url($action_uri);

                if ($action_uri === '#' || strpos($action_uri, 'javascript:') != FALSE) {
                    $hrefVal = 'javascript:';
                }

                echo '<li><a class="vietnamese_english focusable_text" href="' . $hrefVal . '">' . $action_name . '</a></li>';
            }
            ?>
        </ul>
    </div>
<?php } ?>

<?php if ($is_login == FALSE): ?>
    <?php echo validation_errors(); ?>
    <?php echo form_open('user_account/login'); ?>

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
    <input type="hidden" name="url_redirect" value="<?php if (isset($_GET['url_redirect'])) echo $_GET['url_redirect']; ?>" />

        <?php echo form_close(''); ?>

    <div style="display: none;" >
    <?php echo anchor('user_account/activate', 'Activate'); ?>
    <?php echo anchor('user_account/register', 'Register'); ?>
    </div>

<?php else: ?>   

    <div class="floating-menu" id="left_action_list" ></div>

    <?php
    $action_names = array(
        "unit-tests" => '/unit-tests/index'
    );
    renderUserGroupOfActions("usergroup_menu", "Menu", $action_names);
    ?>

<?php endif; ?>

