<?php
addScriptFile("js/jquery.fancybox/jquery.fancybox.min.js");
addCssFile("js/jquery.fancybox/jquery.fancybox.css");
?>
<div style='margin: 50px 20px'>
    <h3>Admin panel for administrator</h3>
    <b>
    <a href="http://docs.google.com/View?id=dgsrc7qn_345j7f5smgf" target="_blank" title="Hướng dẫn sử dụng (User Guide) for DRD Admin" class="vietnamese_english iframe_fancybox_link" >Hướng dẫn sử dụng cho Admin/User Guide for Admin</a>
    </b>
</div>
<div style="margin: 30px">
    <div>
        <iframe src="http://docs.google.com/present/embed?id=dgsrc7qn_372dkgq3wfs&interval=5&size=l" frameborder="0" width="700" height="559"></iframe>
    </div>
</div>
<script type="text/javascript">
    jQuery(".iframe_fancybox_link").fancybox({
        'width'				: '98%',
        'height'			: '94%',
        'autoScale'     	: false,
        'transitionIn'		: 'none',
        'transitionOut'		: 'none',
        'type'				: 'iframe'
    });
</script>