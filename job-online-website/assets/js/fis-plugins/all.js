jQuery(document).ready(function(){
    var css = 'border-width: initial;border-color: initial;overflow: hidden;width: 450px;height: 26px;border: none;';
    var src = 'http://localhost/job-online-website/assets/js/fis-plugins/fis-like.php';
    var iframe = $('<iframe scrolling="no" border="0"></iframe>').attr("src",src).attr('style',css);
    $("span.fis-like").html(iframe);
});