<div style="font-weight:bold;margin-top:14px;">
    <?php echo anchor('', lang('home_page')); ?>   |    
    <?php action_url_a('admin/search', lang('search'), lang('search')); ?>   |
    <?php
        if($isGroupAdmin){
            echo anchor('admin/admin_panel', lang('admin_panel'));
        }
    ?>
    | <a href="http://docs.google.com/View?id=dgsrc7qn_345j7f5smgf" target="_blank" title="Hướng dẫn sử dụng (User Guide) for DRD Admin">Help</a>
</div>
