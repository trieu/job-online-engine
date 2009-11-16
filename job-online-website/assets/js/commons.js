/**
  * wrapper jQuery.dialog box
  *
  */
var Modalbox = {};
Modalbox.popup = false;
Modalbox.defaultOptions = {};
Modalbox.currentBoxSeletor = "div:visible[class='ui-dialog generic-dialog has-title ui-draggable ui-resizable']";
Modalbox.defaultBoxHTML = '<div title="Dialog Title" style="display:none" ><div class="loading-animation"></div></div>';

Modalbox.show = function(content_id,options){
    var content = jQuery(content_id).val();
    if(content == ""){
        content = jQuery(content_id).html();
    }
    if(content == ""){
        alert("content of modal box is empty!");
        return false;
    }
    Modalbox.hide();
    if(options instanceof Object){
        options["modal"] = true;       
        Modalbox.popup = jQuery(Modalbox.defaultBoxHTML).dialog(options);
        jQuery(Modalbox.popup).append(content);
        jQuery(".loading-animation").hide();
        jQuery("a.ui-dialog-titlebar-close").click(function(){
            Modalbox.hide();
        });
        return Modalbox.popup;
    }
    else {
        alert("Param options is not valid!");
    }
}

Modalbox.showLoading = function() {
    jQuery(".loading-animation").show();
}

Modalbox.hideLoading = function() {
    jQuery(".loading-animation").hide();
}

Modalbox.updateContent = function(content_id){
    if(Modalbox.popup != false){
        jQuery(".ui-dialog-content *").remove();
        jQuery(".ui-dialog-content").html("");
        var content = "";
        try{
            if(content_id[0] == "#"){
                content = jQuery(content_id).html();
            }
            else {
                content = content_id;
            }
            if(content == ""){
                content = jQuery(content_id).val();
            }
            if(content == ""){
                alert("content of modal box is empty!" + content_id);
                return false;
            }
        }catch(e){
            alert(e);
        }

        jQuery(Modalbox.popup).append(content);
        Modalbox.autoCenter();
    }
}

Modalbox.appendContent = function(content){
    if(Modalbox.popup != false){
        jQuery(Modalbox.popup).append(content);
        Modalbox.autoCenter();
    }
}

Modalbox.autoCenter = function(){
    //var pageWidth = jQuery(document).width();
    //var pageHeight = jQuery(document).height();
    jQuery(window).scrollTop(10);
    var viewportWidth = (window.innerWidth ? window.innerWidth : jQuery(window).width())/2;
    var viewportHeight = (window.innerHeight ? window.innerHeight : jQuery(window).height())/2;
    var w = jQuery(Modalbox.currentBoxSeletor).width()/2;
    var h = jQuery(Modalbox.currentBoxSeletor).height()/2;
    var left = viewportWidth - w;
    var top = viewportHeight - h;
    jQuery(Modalbox.currentBoxSeletor).css("left",left +"px").css("top",top +"px");
}

Modalbox.updateHeight = function(num){
    if(Modalbox.popup != false){
        jQuery(Modalbox.currentBoxSeletor).height(num);
        Modalbox.autoCenter();
    }
}

Modalbox.updateWidth = function(num){
    if(Modalbox.popup != false){
        jQuery(Modalbox.currentBoxSeletor).width(num);
        Modalbox.autoCenter();
    }
}

Modalbox.updateHeightWidth = function(h,w){
    if(Modalbox.popup != false){
        jQuery(Modalbox.currentBoxSeletor).height(h);
        jQuery(Modalbox.currentBoxSeletor).width(w);
        Modalbox.autoCenter();
    }
}

Modalbox.contentSelector = function(selector){
    if(Modalbox.popup != false){
        return jQuery(".ui-dialog-content "+selector);
    }
}

Modalbox.hide = function(){
    if(Modalbox.popup != false){
       jQuery(Modalbox.popup).dialog('close');
        Modalbox.popup = false;
        jQuery("div[class='ui-dialog generic-dialog has-title ui-draggable ui-resizable']").remove();
        jQuery("div[class='ui-dialog-overlay']").remove();
    }
}


var ScriptUtil = {};
ScriptUtil.subString = function(str, strLength) {
    var l = new Number(strLength);
    if(str.trim().length > l) {
        return (str.substring(0,l)+"...");
    }
    else {
        return (str);
    }
}