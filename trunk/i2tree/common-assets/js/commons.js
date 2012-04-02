if(window.console == null) {
    var f = function(){};
    window.console = {log: f};
}

/**
  * wrapper jQuery.dialog box
  *
  */
var Modalbox = {};
Modalbox.popup = false;
Modalbox.defaultOptions = {};
Modalbox.currentBoxSeletor = "div:visible[class='ui-dialog ui-widget ui-widget-content ui-corner-all ui-draggable ui-resizable']";
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
        jQuery(Modalbox.popup).find("*").remove();
        jQuery(Modalbox.popup).html("");
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
        return jQuery(Modalbox.popup).find(selector);
    }
}

Modalbox.hide = function(){
    if(Modalbox.popup != false){
       jQuery(Modalbox.popup).dialog('close');
        Modalbox.popup = false;       
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

var GUI = {};
GUI.toggletVisible = function(selector){
    return jQuery(selector).toggleClass("not_visible");
}

jQuery.fn.serializeObject = function() {
   var o = {};
   var a = this.serializeArray();
   jQuery.each(a, function() {
       if (o[this.name]) {
           if (!o[this.name].push) {
               o[this.name] = [o[this.name]];
           }
           o[this.name].push(this.value || '');
       } else {
           o[this.name] = this.value || '';
       }
   });
   return o;
};

function findScriptInHTML(html) {
    var s = html.indexOf("<!--SCRIPT") + 10;
    if(s > 10){
        var e = html.indexOf("-->") ;
        var scriptContent = html.substring( s, e);
        return jQuery.trim(scriptContent);
    }
    return "";
}

function makeScriptTag(scriptContent) {
    var script = document.createElement('script');
    script.type = 'text/javascript';
    script.innerHTML = scriptContent;
    return script;
}

function initFancyBoxLinks(frameWidth, frameHeight){
    var w = 800, h = 530;
    if( typeof frameWidth == "undefined" ){
        frameWidth = w;        
    }
    if( typeof frameHeight == "undefined"){
        frameHeight = w;
    }
    
    jQuery("a.use_fancybox").fancybox(
        {
            'hideOnContentClick': false , 'hideOnOverlayClick':false,
            'enableEscapeButton':true, 'autoDimensions' : false,
            'zoomSpeedIn': 300, 'zoomSpeedOut': 300,
            'overlayShow': true , 'frameWidth': frameWidth , 'frameHeight': frameHeight
        }
    );
}

function togglePageNavigation(force_show){
    if(force_show) {
        jQuery("#page_leftnav").attr('status', 'show');
    }
    if( jQuery("#page_leftnav").attr('status') == 'hide'){
        jQuery("#page_leftnav").hide();
        jQuery("#page_content").css("margin-left","0px");
        jQuery("#page_leftnav_toggle").html("Show Navigation");
        jQuery.cookies.set('toggle_page_navigation','hide', {path:'/',expires: 7});
        jQuery("#page_leftnav").attr('status','show');
    }
    else {
        jQuery("#page_leftnav").show();
        jQuery("#page_content").css("margin-left","230px");
        jQuery("#page_leftnav_toggle").html("Hide Navigation");
        jQuery.cookies.set('toggle_page_navigation','show', {path:'/',expires: 7});
        jQuery("#page_leftnav").attr('status','hide');
    }
};
jQuery(document).ready(function(){
    var state = jQuery.cookies.get('toggle_page_navigation');
    if(state == null) {state = 'show';}
    jQuery("#page_leftnav").attr('status', state);
    togglePageNavigation();
});

 function language_saparator(){  
    jQuery(".vietnamese_english").each(function(){
        var toks = jQuery(this).html().split("/");
        if(toks.length == 2){
            if($PAGE_LANGUAGE_KEY == "tiengviet"){
                jQuery(this).html( jQuery.trim(toks[0]) );
            }
            else if($PAGE_LANGUAGE_KEY == "english"){
                jQuery(this).html( jQuery.trim(toks[1]) );
            }
        };
    });
};

var setGoogleDocsFieldForNode = false;
function setGoogleDocsField(doc_id) {
    doc_id = doc_id.replace("#", "");
    var url = "https://docs.google.com/document/pub?id=" + doc_id;
    setGoogleDocsFieldForNode.val(url);
    alert(doc_id);
}

//set up confirmation alert for each link has class 'confirmation'
jQuery(document).ready(function() {
    var f = function(){
        var href = jQuery(this).attr("href");
        var text = jQuery(this).html() + " ?";
        jQuery(this).attr("href","javascript:").attr("action",href);
        jQuery(this).click(function(){
            if(confirm(text)){
                window.location.href = href;                
            }
            return false;
        });
    };
    jQuery("a.confirmation").each(f);
});
