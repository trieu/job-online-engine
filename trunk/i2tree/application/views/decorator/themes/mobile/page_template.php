<!DOCTYPE html> 
<html> 
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1"> 
        <?php foreach ($page_decorator->getPageMetaTags() as $name => $content) { ?>
            <meta name="<?php echo $name; ?>" content="<?php echo $content; ?>" />
        <?php } ?>
        <title><?php echo $page_decorator->getPageTitle(); ?></title> 

        <link rel="stylesheet" href="<?php echo base_url() ?>common-assets/css/light.min.css" />
        <link rel="stylesheet"  href="<?php echo base_url() ?>common-assets/css/jquery.mobile.structure-1.0.1.min.css"/>         
        <script type="text/javascript" src="<?php echo base_url() ?>common-assets/js/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>common-assets/js/jquery/jquery.mobile.min.js"></script>
    </head> 
    <body> 
        <!-- Start of login page --> 
        <div data-role="page" id="login" data-theme="a" >		 
            <div data-role="header"  > 
                <h1>Login</h1> 
            </div><!-- /header --> 

            <div data-role="content">							
                <div data-role="fieldcontain">					
                    <input type="text" name="name" id="name" value="" placeholder="Username" />
                </div>
                <div data-role="fieldcontain">
                    <input type="password" name="password" id="password" value="" placeholder="Password" />
                </div>
                <a href="javascript: loginToServer()" data-role="button" data-icon="check" data-theme="c" class="ui-btn ui-btn-icon-left ui-btn-corner-all ui-shadow ui-btn-hover-c ui-btn-up-c">
                    <span class="ui-btn-inner ui-btn-corner-all">
                        <span class="ui-btn-text">OK</span><span class="ui-icon ui-icon-check ui-icon-shadow"></span>
                    </span>
                </a>
            </div><!-- /content --> 

            <div data-role="footer"> 
                <h4>Page Footer</h4> 
            </div><!-- /footer --> 
        </div><!-- /page --> 

        <!-- Start of Worklist page --> 
        <div data-role="page" id="worklist"   > 		 
            <div data-role="header" data-theme="a"> 
                <h1>Worklist</h1> 
                <a href="#login" data-icon="home" data-iconpos="notext" data-direction="reverse" class="ui-btn-right jqm-home">Home</a> 
            </div><!-- /header --> 

            <div data-role="content"> 

                <ul data-role="listview"> 
                    <li> 
                        <img src="http://farm4.static.flickr.com/3222/2707565362_1bb79fa7d8.jpg" /> 
                        <h3><a href="#study_details">Broken Bells</a></h3> 
                        <p>Broken Bells</p> 
                    </li> 
                    <li> 
                        <img src="http://farm4.static.flickr.com/3222/2707565362_1bb79fa7d8.jpg" /> 
                        <h3><a href="#study_details">Warning</a></h3> 
                        <p>Hot Chip</p> 
                    </li>
                    <li> 
                        <img src="http://farm4.static.flickr.com/3222/2707565362_1bb79fa7d8.jpg" /> 
                        <h3><a href="#study_details">Hot Fuss</a></h3> 
                        <p>Killers</p> 
                    </li> 
                    <li>	
                        <img src="http://farm4.static.flickr.com/3222/2707565362_1bb79fa7d8.jpg" /> 
                        <h3><a href="#study_details">The Suburbs</a></h3> 
                        <p>Arcade Fire</p> 
                    </li> 
                </ul> 		 

            </div><!-- /content --> 
            <div data-role="footer"> 
                <h4>Page Footer</h4> 
            </div><!-- /footer --> 
        </div><!-- /page --> 

        <!-- Start of study_details page --> 
        <div data-role="page" id="study_details" data-theme="a" data-add-back-btn="true"  > 		 
            <div data-role="header"> 
                <h1>Study Details</h1> 
            </div><!-- /header --> 

            <div data-role="content">	
                <h2>MRI</h2>
                <img src="http://farm4.static.flickr.com/3222/2707565362_1bb79fa7d8.jpg" width="480" />			
            </div><!-- /content --> 

            <div data-role="footer"> 
                <h4>Page Footer</h4> 
            </div><!-- /footer --> 
        </div><!-- /page --> 


        <script type="text/javascript" >
            var baseURL = window.location.href;
            $(document).ready(function(){
                //alert('done');
            });
			
            function loginToServer(){				
                window.location.href = baseURL + "#worklist";
            }
        </script>

    </body>
</html>