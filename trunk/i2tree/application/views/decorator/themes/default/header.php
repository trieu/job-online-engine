<table width="100%">
    <tr>
        <td width="85%">
            <div class="page_logo">
                <?php action_url_a('', lang('home_page_heading'), lang('home_page')); ?>
            </div>
        </td>
        <td width="15%" >
            <div style="float: right">
                <?php if($is_login == TRUE): ?>                
                    <span class="vietnamese_english" >User: </span>
                    <a title="<?php echo $first_name;?>" href="javascript:"><?php echo $login_name;?></a>              
                    <?php action_url_a('user_account/logout', 'Logout'); ?>              
                <?php endif; ?>
            </div>
        </td>
    </tr>
</table>

<div class="page_menu">
    <ul id="top_menu_bar" class="sf-menu">            
            <li class="current">
                <a href="javascript:" title="">Actions</a>
                <ul>
                    <li>
                        <a href="javascript: " title="Item Manager">Item</a>
                        <ul>
                            <li><?php action_url_a('#','Create'); ?></li>
                            <li><?php action_url_a('#', 'List'); ?></li>
                        </ul>
                    </li>                   
                  
                </ul>
            </li>            
            
    </ul>
</div>

<script type="text/javascript" language="JavaScript">
    function initTooltip(selector){jQuery(selector).bt({shrinkToFit:true,cssStyles:{fontFamily:'"Lucida Grande",Helvetica,Arial,Verdana,sans-serif',fontSize:'12px',padding:'10px 14px'}});}
    jQuery(document).ready(function(){
        if(!jQuery.browser["msie"]){
            initTooltip("#top_menu_bar a");
        }        
        jQuery('#top_menu_bar').superfish();
    });

    function switchPageToLanguage(from, to){
        var currentUrl = window.location + "";
        if(currentUrl == "<?php echo base_url(); ?>" ){
            currentUrl += "tiengviet.php";
        }
        currentUrl = currentUrl.replace(from, to);
        window.location = currentUrl;
    };
</script>