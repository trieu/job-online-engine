<?php
addScriptFile("js/jquery/jquery.form.js");
$ext_info_json = json_decode($user_profile->ext_info);
$smtp_user = $ext_info_json->smtp_account->smtp_user;
$smtp_pass = $ext_info_json->smtp_account->smtp_pass;
?>
<h3 class="vietnamese_english" >
    Cài đặt dịch vụ email cho người quản lý database
    /Set up the Email Service for Database Manager
</h3>
<form action="<?php echo site_url("services/email_service/save_config_user_email") ?>" method="POST">
   Email Address: <input type="text" name="smtp_user" value="<?php echo $user_profile->email;?>" /><br><br>
   Password: <input type="text" name="smtp_pass" value="<?php echo $smtp_pass;?>" /><br><br>
   <input type="submit" value="Okay" />
   <input type="button" value="Cancel" name="Cancel" />
</form>

<br><br>
<input type="button" value="Test Email Account" name="" onclick="test_email()" />
<br><br>
<div id="test_email_result"></div>
<script type="text/javascript">
    function test_email(){
        var url = "<?php echo site_url("services/email_service/send_email") ?>";
        var callback = function(html){
            jQuery("#test_email_result").html(html);
        };
        jQuery.post(url, {}, callback);
    }
</script>