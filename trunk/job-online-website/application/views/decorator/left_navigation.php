 <?php if($is_login == FALSE) { ?>
     <?php echo validation_errors(); ?>
     <?php echo form_open('welcome/login'); ?>

<div style="width:98%;font-weight:bold" >
    <div>
        <label>Email</label>
             <?php echo form_input('email', set_value('email','trieu@drdvietnam.com')); ?>
    </div>
    <div style="margin-top:5px;" >
        <label>Password</label>
             <?php echo form_password('password','123456'); ?>
    </div>
         <?php echo form_submit('submit', 'Login'); ?>
</div>
     
<input type="hidden" name="url_redirect" value="<?php if(isset ($_GET['url_redirect'])) echo $_GET['url_redirect']; ?>" />
     <?php echo form_close(''); ?>

     <?php echo anchor('welcome/activate', 'Activate'); ?>
     <?php echo anchor('welcome/register', 'Register'); ?>
 <?php } else { ?>
<div><p>Welcome <?php echo $first_name ?>,</p></div>
<div>
         <?php echo anchor('welcome/logout', 'Logout'); ?>
</div>
<?php } ?>