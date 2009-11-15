 <?php if($is_login == FALSE) { ?>
     <?php echo validation_errors(); ?>
     <?php echo form_open('welcome/login'); ?>

        <div style="width:98%;font-weight:bold" >
            <div>
                <label for="user_email" >Email</label>
                <input id="user_email" type="text" name="email" value="trieu@drdvietnam.com" style="width:100%;" />
            </div>
            <div style="margin-top:5px;" >
                <label for="user_password" >Password</label>
                <input id="user_password" type="password" name="password" value="123456" style="width:100%;"/>
            </div>
            <input type="submit" value="Login" />
        </div>
        <input type="hidden" name="url_redirect" value="<?php if(isset ($_GET['url_redirect'])) echo $_GET['url_redirect']; ?>" />
        
     <?php echo form_close(''); ?>

     <?php echo anchor('welcome/activate', 'Activate'); ?>
     <?php echo anchor('welcome/register', 'Register'); ?>
 <?php } else { ?>

<div>
    <p>
 <?php
 if(LANGUAGE_INDEX_PAGE == "tiengviet.php"){
    echo "Chào mừng ".$first_name;
 }
 else {
    echo "Welcome ".$first_name;
 }
 ?>,
    </p>
</div>
<div>
    <?php echo anchor('welcome/logout', 'Logout'); ?>
</div>
<?php } ?>