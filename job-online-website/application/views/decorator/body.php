<style type="text/css">
    .user_link {
        margin-top: 12px;
    }
    .user_link a{
        font-weight: bold;
    }
</style>
<div>
    <div style="display: none;">
        <b> DRD Information Planning</b> is the system that all processes in DRD can be defined, managed and searched.
    </div>

    <h3>Chào mừng bạn đến với hệ thống database việc làm DRD</h3>
    <div class="user_link">
        Để đăng ký mới về thông tin người tìm việc, vui chọn liên kết sau:
        <?php action_url_a('user/public_object_controller/create_object/1',lang('register_new_jobseeker')); ?>
    </div>
    <div class="user_link">
        Để đăng ký mới về thông tin nhà tuyển dụng , vui chọn liên kết sau:        
        <?php action_url_a('user/public_object_controller/create_object/2',lang('register_new_employer')); ?>
        
    </div>
    <div class="user_link" style="display: none;">
        Để đăng ký mới về thông tin công việc, vui chọn liên kết sau: 
        <?php action_url_a('user/public_object_controller/create_object/4', "Đăng ký mới công việc"); ?>
    </div>

    <div style="margin-top: 40px">
        <div>
            <b>Video hướng dẫn cách đăng ký mới 1 Job Seeker</b>
        </div>
        <div>
            <object width="480" height="385"><param name="movie" value="http://www.youtube.com/v/fo2oNirOgJ8&hl=en_US&fs=1&color1=0x006699&color2=0x54abd6"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/fo2oNirOgJ8&hl=en_US&fs=1&color1=0x006699&color2=0x54abd6" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385"></embed></object>
        </div>
    </div>

    <div style="margin-top: 50px">
        <i>
            Hiện tai trang web database việc làm DRD được hỗ trợ tốt trên phiên bản mới nhất của trình duyện web
            Mozila Firefox.
            Bạn có thể download ở đây:
        </i>
        <br>
        <a target="_blank" href="http://www.mozilla.com/vi/" title="Download Firefox">
            <b>
                Download Firefox Browser
            </b>
        </a>
    </div>
</div>