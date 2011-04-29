<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" content="">
        <title>Welcome to CodeIgniter</title>

        <style type="text/css">
            body {
                background-color: #fff;
                margin: 40px;
                font-family: Lucida Grande, Verdana, Sans-serif;
                font-size: 14px;
                color: #4F5155;
            }
            a {
                color: #003399;
                background-color: transparent;
                font-weight: normal;
            }
            h1 {
                color: #444;
                background-color: transparent;
                border-bottom: 1px solid #D0D0D0;
                font-size: 16px;
                font-weight: bold;
                margin: 24px 0 2px 0;
                padding: 5px 0 6px 0;
            }
            code {
                font-family: Monaco, Verdana, Sans-serif;
                font-size: 12px;
                background-color: #f9f9f9;
                border: 1px solid #D0D0D0;
                color: #002166;
                display: block;
                margin: 14px 0 14px 0;
                padding: 12px 10px 12px 10px;
            }
        </style>
        

    </head>
    <body>

        <h1>Welcome to CodeIgniter, test social plugin!</h1>

        <p>The page you are looking at is being generated dynamically by CodeIgniter.</p>

        <p>If you would like to edit this page you'll find it located at:</p>
        <code>application/views/welcome_message.php</code>

        <p>The corresponding controller for this page is found at:</p>
        <code>application/controllers/welcome.php</code>

        <p>If you are exploring CodeIgniter for the very first time, you should start by reading the <a target="_blank" href="<?php echo ("http://localhost/ci_user_guide") ?>/">User Guide</a>.</p>


        <p><br />Page rendered in {elapsed_time} seconds</p>


    <div id="fb-root"></div>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
    <script src="http://connect.facebook.net/en_US/all.js"></script>
    <script>

        FB.init({
            appId  : '369633221982',
            status : true, // check login status
            cookie : true, // enable cookies to allow the server to access the session
            xfbml  : true  // parse XFBML
        });
        FB.getLoginStatus(function(response) {            
            if (response.session) {
                // logged in and connected user, someone you know 
                fb_login_status(response.session.uid); 				
            } else {
                // no user session available, someone you dont know
                fb_logout_status();
            }
			jQuery(document).ready(function(){
				jQuery('#fb_status').show();
			});		            
        });
        FB.Event.subscribe('auth.sessionChange', function(response) {
            if (response.session) {
                // logged in and connected user, someone you know                
                fb_login_status(response.session.uid);                
            } else {
                // no user session available, someone you dont know
                fb_logout_status();
            }				
        });
        
        function fb_login_status(currentFbUserId){
            jQuery('#fb_status_logout').show();
            jQuery('#fb_status_login').hide();
			var query = FB.Data.query('select name, uid, email from user where uid={0}', currentFbUserId);
			query.wait(function(rows) {                   
				jQuery('#fb_user_name').html(rows[0].name + '; Email: ' + rows[0].email);
			});
        }
        function fb_logout_status(){
            jQuery('#fb_status_login').show();
            jQuery('#fb_status_logout').hide();
			jQuery('#fb_user_name').html('');
        }
        function doFbLogout(){
            FB.logout(function(response) { 
                fb_logout_status(); 
            });
        }
		
    </script>

    <div id="fb_status" style="display: none;">
        <div id="fb_status_login">
            <fb:login-button show-faces="true" width="200" max-rows="1" perms="email"  ></fb:login-button>
        </div>
        <div id="fb_status_logout">
            <div id="fb_user_name"></div>
            <input type="button" value="FB Logout" onclick="doFbLogout()" />
        </div>
    </div>

</body>
</html>