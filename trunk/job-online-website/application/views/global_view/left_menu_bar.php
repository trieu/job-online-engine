<style type="text/css" media="screen">
    .group_action {
        width: 200px;
        border: 1px solid #ccc;
        padding: 0px;
        margin: 0px;
    }
    .group_action h3 {
        height: 30px;
        font-weight: normal;
        background-color: #555;
        color: #fff;
        padding: 3px 0px 0px 3px;
        margin: 0px;

    }
    .group_action h3 a{
        color:white!important;
    }
    .group_action ul, .group_action ul li {
        padding: 3px;
        margin: 0px;
        list-style: none;
    }
    .group_action ul li {
        height: 30px;
        vertical-align: middle;
    }
    .group_action ul li a {
        display: block;
        border-bottom: 1px dashed #eee;
        text-decoration: none;
        font-weight: bold;
    }
</style>

<?php


$action_names  = array(
    "Đăng ký người tìm việc / Register new Job Seeker" => "user/public_object_controller/create_object/1"
    ,"Đăng ký nhà tuyển dụng / Register new Employer" => "user/public_object_controller/create_object/2"
    ,"Tìm kiếm / Search" => "admin/search"
    ,"Thống kê dữ liệu / Statistics" => "admin/search/load_form_statistics"
    ,"Xuất dữ liệu cho Excel / Export data for Excel" => "admin/search/load_form_export_data"
);
renderGroupOfActions("usergroup_menu","Menu", $action_names);
?>

<?php  function renderGroupOfActions($group_id, $group_name, $action_names) { ?>
<div class="group_action">
    <h3 onclick="jQuery('#<?= $group_id ?>').slideToggle('slow');">
        <a href="javascript:void(0) "><?= $group_name ?></a>
    </h3>
    <ul id="<?= $group_id ?>">
            <?php foreach ($action_names as $action_name => $action_uri) {
                echo '<li><a class="vietnamese_english" href="'.site_url($action_uri).'">'.$action_name.'</a></li>';
            }?>
    </ul>
</div>
<?php } ?>