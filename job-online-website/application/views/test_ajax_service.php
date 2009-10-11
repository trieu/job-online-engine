<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Test Form</title>

        <script language="JavaScript" src="<?php echo base_url()?>assets/js/jquery/jquery.js"></script>
        <script language="JavaScript" src="<?php echo base_url()?>assets/js/jquery/jquery.form.js"></script>
        <script language="JavaScript" src="<?php echo base_url()?>assets/js/jquery/jquery.json.js"></script>

      <!--  
        <script language="JavaScript" src="<?php echo base_url()?>gwt/test.Test/test.Test.nocache.js"></script>
        -->

    </head>
    <body>

        <div style="display:block;">
            <h1>Test Ajax Service Form</h1>
            <form id="form_service"	action="<?php echo base_url()?>index.php/main_service/handler/"	method="POST">
                <input type="text" name="service_name" value="HelloWord" size="100" /> <br>
                <input type="text" name="service_method" value="callWith1Param"	size="100" /> <br>
                <input type="hidden" name="service_id" value="" size="100" />
                <textarea name="service_method_params" rows="10" cols="80">{"p0":" Nguyễn Tấn Triều và Huỳnh Tuyết Hồng"}</textarea> <br>
                <input type="button" value="Send" onclick="doSummit()" />
            </form>
        </div>


        <script language="JavaScript">
            var RemoteService = {};
            RemoteService.params = {service_id:-1, service_name:"", service_method:"", service_method_params:{}};
            RemoteService.callback = function(responseText, statusText)  {
                var obj = jQuery.secureEvalJSON(responseText.trim());
                alert(obj.answer);
            };
            RemoteService.callServer = function(){
                jQuery.post("<?php echo base_url()?>index.php/main_service/handler/",RemoteService.params,RemoteService.callback);
            };



            jQuery(document).ready(function(){

            });




            jQuery(document).ready(function () {
                // bind to the form's submit event
                jQuery('#form_service').submit(function() {
                    jQuery(this).ajaxSubmit( {success: handler} );
                    return false;
                });

                // post-submit callback
                var handler = function(responseText, statusText)  {
                    //var obj = jQuery.secureEvalJSON(responseText.trim());
                    alert(responseText);
//                     var obj = jQuery.secureEvalJSON(responseText.trim());
//                     console.log(obj);
//                     if(obj.answer != null){
//                        var answer = jQuery.secureEvalJSON(obj.answer);
//                        console.log(answer);
//                     }
                }
            });

            function doSummit(){
                var now = new Date().getTime();
                jQuery("#form_service input[name='service_id']").val(now);
                jQuery("#form_service").submit();
            }

            function callService(){
                RemoteService.params.service_id = new Date().getTime();
                RemoteService.params.service_name = jQuery("#form_service input[name='service_name']").val();
                RemoteService.params.service_method = jQuery("#form_service input[name='service_method']").val();
                RemoteService.params.service_method_params = jQuery("#form_service textarea[name='service_method_params']").val();
                RemoteService.callServer();
            }


            var callback = "h";
            var h = function(a){
                alert(a);
                var obj = jQuery.secureEvalJSON(a.trim());
                alert(obj.a);
                window[callback + "done"] = true;
            };

            function testService(){
                var url = "<?php echo base_url()?>index.php/main_service/testCrossSite/{a:'ji'}/h";
                var url1 = "http://localhost/k2/test.php?params={\"a\":\"aa\"}&callback=" + callback;

                // [1] Create a script element.
                var script = document.createElement("script");
                script.setAttribute("src", url1);
                script.setAttribute("id", "cross_site_script");
                script.setAttribute("type", "text/javascript");

                window[callback + "done"] = false;

                // [4] JSON download has 1-second timeout.
                setTimeout(function() {
                    if (!window[callback + "done"]) {
                        h(null);
                    }

                    // [5] Cleanup. Remove script and callback elements.
                    document.body.removeChild(script);

                    delete window[callback + "done"];
                }, 5000);

                // [6] Attach the script element to the document body.
                document.body.appendChild(script);
            }
        </script>



    </body>
</html>
