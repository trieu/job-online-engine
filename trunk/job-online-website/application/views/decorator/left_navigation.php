 <?php if($is_login == FALSE) { ?>
     <?php echo validation_errors(); ?>
     <?php echo form_open('welcome/login'); ?>
<table style="width:255px!important;">
    <tbody>
        <tr>
            <td>Email</td>
            <td><?php echo form_input('email', set_value('email','trieu@drdvietnam.com')); ?></td>
        </tr>
        <tr>
            <td>Password</td>
            <td><?php echo form_password('password','123456'); ?></td>
        </tr>
        <tr>
            <td colspan="2"><?php echo form_submit('submit', 'Login'); ?></td>
        </tr>
    </tbody>
</table>
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