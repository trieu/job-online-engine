<?php
addScriptFile("js/jquery/jquery.form.js");

$smtp_user = $user_profile->email;
$smtp_pass = "";
if ($user_profile->ext_info != NULL) {
    $ext_info_json = json_decode($user_profile->ext_info);
    $smtp_user = $ext_info_json->smtp_account->smtp_user;
    $smtp_pass = $ext_info_json->smtp_account->smtp_pass;
}
?>
<h3 class="vietnamese_english" >
    Cài đặt dịch vụ email cho người quản lý database
    /Set up the Email Service for Database Manager
</h3>
<form id="form_config_email_service" action="<?php echo site_url("services/email_service/save_config_user_email") ?>" method="POST">
    Email Address: <input type="text" name="smtp_user" value="<?php echo $smtp_user; ?>" size="50" /><br><br>
    Password: <input type="password" name="smtp_pass" value="<?php echo $smtp_pass; ?>" size="30" /><br><br>
    
    <input type="submit" value="Okay" />
    <input type="button" value="Cancel" name="Cancel" />
</form>
<br>
<div id="form_config_result" style="font: bold 20px serif; color: #33be40;background-color: lavender;"></div>
<br>
<h3 class="vietnamese_english" >
    Bạn có thể gửi 1 email nháp đến địa chỉ email trên.
    /You can send a test email to your account here
</h3>
<input type="button" value="Test Email Service" name="" onclick="test_email_service()" />
<br><br>
<div id="test_email_result" style="background-color: lavender;"></div>
<script type="text/javascript">
    function test_email_service(){
        var url = "<?php echo site_url("services/email_service/test_email_service") ?>";
        var callback = function(html){
            jQuery("#test_email_result").html(html);
        };
        var data = {to_addresses: ""};
        data.to_addresses = jQuery('#form_config_email_service').find('input[name="smtp_user"]').val();
        jQuery.post(url, data , callback);
    }
    function init_form_config_email_service(){      
        var options = {
            target: '#form_config_result' ,
            beforeSubmit: function(){ jQuery("#form_config_result").html("Saving, please wait ..."); }
        };
        // bind form using 'ajaxForm'
        jQuery('#form_config_email_service').ajaxForm(options);
        
    }
    jQuery(document).ready(function(){
        init_form_config_email_service();
    });
</script>