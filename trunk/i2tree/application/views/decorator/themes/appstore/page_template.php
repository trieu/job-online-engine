<!DOCTYPE html> 
<html> 
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="distribution" content="global">
    <meta name="ROBOTS" content="NOINDEX, NOFOLLOW">

    <?php foreach ($page_decorator->getPageMetaTags() as $name => $content) { ?>
        <meta name="<?php echo $name; ?>" content="<?php echo $content; ?>" />
    <?php } ?>

    <base href="<?php echo base_url() ?>" />

    <title><?php echo $page_decorator->getPageTitle(); ?></title>

    <meta name="generator" content="i2tree 1.0">

    <style type="text/css" media="screen">
        <!-- @import url( http://themegalaxy.net/demo/draco/wp-content/themes/draco/style.css ); -->
    </style>
    <script type="text/javascript" src="<?php echo base_url() ?>common-assets/js/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>common-assets/themes/appstore/files/yetii.js"></script>
</head>
<body>

    <div id="wrap">

        <div id="header">

            <ul>
                <li class="page_item page-item-9 current_page_item"><a href="#" title="Home">Home</a></li>
                <li class="page_item page-item-2"><a href="#" title="About">About</a></li>
                <li class="page_item page-item-6"><a href="#" title="News">News</a></li>
                <li class="page_item page-item-4"><a href="#" title="Contact">Contact</a></li>
            </ul>

            <h1><a href="http://themegalaxy.net/demo/draco" title="Home"><?php echo $page_decorator->getPageTitle(); ?></a></h1>

        </div><!-- header -->
        <div id="featured">

            <div class="news">

                <h3>Latest News</h3>

                <ul class="newss">                               

                    <li><a href="#" rel="bookmark" title="Permanent Link to test post four"><span>August 23, 2008</span>test post four</a></li>

                    <li><a href="#" rel="bookmark" title="Permanent Link to test post three"><span>August 23, 2008</span>test post three</a></li>

                    <li><a href="#" rel="bookmark" title="Permanent Link to Test post two"><span>August 23, 2008</span>Test post two</a></li>

                    <li><a href="#" rel="bookmark" title="Permanent Link to Test post one"><span>August 23, 2008</span>Test post one</a></li>

                    <li><a href="#" rel="bookmark" title="Permanent Link to Hello world!"><span>August 22, 2008</span>Hello world!</a></li>

                </ul>

            </div> <!-- news -->




            <h2 style="background-image: url(http://themegalaxy.net/demo/draco/wp-content/themes/draco/images/monitor.gif);">Save time with OurApp!</h2>

            <p>It
                is a long established fact that a reader will be distracted by the
                readable content of a page when looking at its layout. the readable
                content of a page when looking at its layout.<br><br>

                <a class="button" href="#">View Demo</a> <a class="button" href="#">Download</a></p>



        </div><!-- featured -->

        <div id="tab-container-1">


            <div id="menu">

                <a href="javascript:tabber1.previous()"><img src="common-assets/themes/appstore/files/left.gif" alt="Previous" class="left" border="0"></a><a href="javascript:tabber1.next()"><img src="common-assets/themes/appstore/files/right.gif" alt="Next" class="right" border="0"></a>

                <ul id="tab-container-1-nav">


                    <li><a class="active" href="#tab1">Our Product <span><img src="<?php echo base_url() ?>common-assets/themes/appstore/files/selected.gif" alt="Selected" border="0"></span></a></li>

                    <li><a class="" href="#tab2">Features <span><img src="<?php echo base_url() ?>common-assets/themes/appstore/files/selected.gif" alt="Selected" border="0"></span></a></li>

                    <li><a class="" href="#tab3">Gallery <span><img src="<?php echo base_url() ?>common-assets/themes/appstore/files/selected.gif" alt="Selected" border="0"></span></a></li>

                    <li><a class="" href="#tab4">Reviews <span><img src="<?php echo base_url() ?>common-assets/themes/appstore/files/selected.gif" alt="Selected" border="0"></span></a></li>

                    <li><a class="" href="#tab5">Benefits <span><img src="<?php echo base_url() ?>common-assets/themes/appstore/files/selected.gif" alt="Selected" border="0"></span></a></li>

                    <li><a class="" href="#tab6">News <span><img src="<?php echo base_url() ?>common-assets/themes/appstore/files/selected.gif" alt="Selected" border="0"></span></a></li>

                </ul>

            </div><!-- menu -->

            <div id="content" class="home">

                <div style="display: block;" class="tab" id="tab1">


                    <img src="common-assets/themes/appstore/files/demo.jpg" alt="Demo" class="demoimg" border="0">

                    <h4>The Best App you ever installed?</h4>
                    <p>It is a long established fact that <a href="#">a reader will be distracted</a>
                        by the readable content of a page when looking at its layout. the
                        readable content of a page when looking at its layout. It is a long
                        established fact that a reader will be distracted by the readable
                        content </p>
                    <p>It is a long established fact that a reader will be <a href="#">distracted</a> by the readable content of a page when looking at its layout. the readable content of a page when looking at its layout.</p>



                </div> <!-- tab1 -->        


                <div style="display: none;" class="tab" id="tab2">


                    <img src="common-assets/themes/appstore/files/draco3.jpg" alt="Demo" class="demoimg" border="0">

                    <h4>Some of our features</h4>
                    <p>It is a long established fact that a reader will be <a href="#">distracted</a> by the readable content of a page when looking at its layout. the readable content of a page when looking at its layout.</p>
                    <p>It is a long established fact that <a href="#">a reader will be distracted</a>
                        by the readable content of a page when looking at its layout. the
                        readable content of a page when looking at its layout. It is a long
                        established fact that a reader will be distracted by the readable
                        content </p>



                </div> <!-- tab2 -->        


                <div style="display: none;" class="tab" id="tab3">


                    <img src="common-assets/themes/appstore/files/demo.jpg" alt="Demo" class="demoimg" border="0">

                    <h4>Our Gallery</h4>
                    <p>It is a long established fact that <a href="#">a reader willis a long established fact that </a><a href="#">a reader will be  be distracted</a>
                        by the readable content of a page when looking at its layout. the
                        readable content of a pastablished fact that a reader will be
                        distracted by the readable content </p>
                    <p>It is a long established fact that a reader will be <a href="#">distracted</a> by the readable content of a page when looking at its layout. the readable content of a page when looking at its layout.</p>



                </div> <!-- tab3 -->        


                <div style="display: none;" class="tab" id="tab4">


                    <img src="common-assets/themes/appstore/files/draco3.jpg" alt="Demo" class="demoimg" border="0">

                    <h4>Some Reviews</h4>
                    <p>It is a long established fact that <a href="#">a reader willis a long established fact that </a><a href="#">a reader will be  be distracted</a>
                        by the readable content of a page when looking at its layout. the
                        readable content of a pastablished fact that a reader will be
                        distracted by the readable content </p>
                    <p>It is a long established fact that a reader will be <a href="#">distracted</a> by the readable content of a page when looking at its layout. the readable content of a page when looking at its layout.</p>



                </div> <!-- tab4 -->        


                <div style="display: none;" class="tab" id="tab5">


                    <img src="common-assets/themes/appstore/files/demo.jpg" alt="Demo" class="demoimg" border="0">

                    <h4>Lot’s of Benefits</h4>
                    <p>It is a long established fact that <a href="#">a reader willis a long established flong established fact that </a><a href="#">a reader willis aact that </a><a href="#">a reader will be  be distracted</a>
                        by the readablg at its layout. the readable content of a pastablished
                        fact that a reader will be distracted by the readable content </p>
                    <p>It is a long estabhat a reader will be <a href="#">distracted</a> by the readable content of a page when looking at its layout. the readable content of a page when looking at its layout.</p>



                </div> <!-- tab5 -->        


                <div style="display: none;" class="tab" id="tab6">


                    <img src="common-assets/themes/appstore/files/draco3.jpg" alt="Demo" class="demoimg" border="0">

                    <h4>The News</h4>
                    <p>It is a long established s a long estabs a long estabfact that a
                        reader willis a long established flong established fact that reader
                        willis aact that by the readablg at its layout. the readable content of
                        a pastablished fact that a reader will be distracted by the readable
                        content </p>
                    <p>It is a long estabhat a reader will be <a href="#">distracted</a> by the readable content of a page when looking at its layout. the readable content of a page when looking at its layout.</p>



                </div> <!-- tab6 -->        




                <div class="clear"></div>
            </div> <!-- content -->
            <div class="contentshade"></div>

        </div> <!-- tab-container-1 -->

        <script type="text/javascript">
            var tabber1 = new Yetii({
                id: 'tab-container-1'
            });
        </script>


        <div id="footer">

            <div class="rightt">

                <h5>Press</h5>

                <p>It is a long established fact that <a href="http://themegalaxy.net/demo/draco/%5C%22#%5C%22">a reader will be distracted</a>
                    by the readable content of a page when looking at its layout. the
                    readable content of a page when looking at its layout. It is a long
                    established fact that a reader will be distracted by the readable
                    content</p>

            </div><!-- right -->

            <div class="leftt">

                <h5>About Us</h5>

                <p></p><p>It is a long established fact that <a href="http://themegalaxy.net/demo/draco/%5C%27#%5C%27">a reader will be distracted</a>
                    by the readable content of a page when looking at its layout. the
                    readable content of a page when looking at its layout. It is a long
                    established fact that a reader will be distracted by the readable
                    content </p>

                <p>It is a long established fact that a reader will be <a href="http://themegalaxy.net/demo/draco/%5C%27#%5C%27">distracted</a> by the readable content of a page when looking at its layout. the readable content of a page when looking at its layout.</p>

            </div> <!-- left -->

        </div><!-- footer -->

        <ul id="footerr" class="hoome">

            <!-- You can not change this line if you are using single license --> <a href="http://themegalaxy.net/" target="_blank" title="Premium WordPress Themes, ThemeGalaxy"><img src="common-assets/themes/appstore/files/themegalaxy.gif" alt="Out of the world WordPress Themes" border="0"></a>

            <li class="page_item page-item-9 current_page_item"><a href="http://themegalaxy.net/demo/draco" title="Home">Home</a></li>
            <li class="page_item page-item-2"><a href="http://themegalaxy.net/demo/draco/about/" title="About">About</a></li>
            <li class="page_item page-item-6"><a href="http://themegalaxy.net/demo/draco/news/" title="News">News</a></li>
            <li class="page_item page-item-4"><a href="http://themegalaxy.net/demo/draco/contact/" title="Contact">Contact</a></li>

        </ul>

    </div><!-- wrap -->	

</body>
</html>