 <?php if($is_login == FALSE): ?>
     <?php echo validation_errors(); ?>
     <?php echo form_open('welcome/login'); ?>

        <div style="width:98%;font-weight:bold" >
            <div>

            </div>
            <div>
                <label for="user_email" >Email</label>
                <input id="user_email" type="text" name="email" value="" style="width:100%;" />
            </div>
            <div style="margin-top:5px;" >
                <label for="user_password" >Password</label>
                <input id="user_password" type="password" name="password" value="" style="width:100%;"/>
            </div>
            <input type="submit" value="Login" />
        </div>
        <input type="hidden" name="url_redirect" value="<?php if(isset ($_GET['url_redirect'])) echo $_GET['url_redirect']; ?>" />

     <?php echo form_close(''); ?>

     <?php echo anchor('welcome/activate', 'Activate'); ?>
     <?php echo anchor('welcome/register', 'Register'); ?>
 <?php else: ?>
    <div>
        <b>
     <?php
     if(LANGUAGE_INDEX_PAGE == "tiengviet.php"){
        echo "User: ".$first_name;
     }
     else {
        echo "User: ".$first_name;
     }
     ?>
        </b>
    </div>
    <div style="margin-bottom: 15px;">
        <?php echo anchor('welcome/logout', 'Logout'); ?>
    </div>
        
    <div class="floating-menu" id="left_action_list" ></div>

<?php endif; ?>