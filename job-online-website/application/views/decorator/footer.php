<div style="font-weight:bold;margin-top:14px;">
    <?php echo anchor('', lang('home_page')); ?>   |
    <?php echo anchor('user/public_object_controller/list_objects/job_seekers', lang('job_seeker'), array("title"=>lang('job_seeker_a_title'))); ?>   |
    <?php echo anchor('user/public_object_controller/list_objects/employers', lang('employer'), array("title"=>lang('employer_a_title'))); ?>   |
    <?php echo anchor('user/public_object_controller/list_objects/jobs', lang('job'), array("title"=>lang('job_a_title'))); ?>   |


    <span style="display:none;">
        <?php echo anchor('home', lang('news_events')); ?>   |
        <?php echo anchor('home', lang('contact')); ?>   |
    </span>
</div>