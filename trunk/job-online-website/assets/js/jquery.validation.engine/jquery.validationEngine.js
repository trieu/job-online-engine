/*
 * Inline Form Validation Engine 1.7, jQuery plugin
 *
 * Copyright(c) 2010, Cedric Dugas
 * http://www.position-relative.net
 *
 * Form validation engine allowing custom regex rules to be added.
 * Thanks to Francois Duquette and Teddy Limousin
 * and everyone helping me find bugs on the forum
 * Licenced under the MIT Licence
 */

(function(a){a.fn.validationEngine=function(b){if(a.validationEngineLanguage)allRules=a.validationEngineLanguage.allRules;else a.validationEngine.debug("Validation engine rules are not loaded check your external file");b=jQuery.extend({allrules:allRules,validationEventTriggers:"focusout",inlineValidation:true,returnIsValid:false,liveEvent:false,openDebug:true,unbindEngine:true,containerOverflow:false,containerOverflowDOM:"",ajaxSubmit:false,scroll:true,promptPosition:"topRight",success:false,beforeSuccess:function(){},
failure:function(){}},b);a.validationEngine.settings=b;a.validationEngine.ajaxValidArray=[];if(b.inlineValidation==true){if(!b.returnIsValid){allowReturnIsvalid=false;if(b.liveEvent){a(this).find("[class*=validate]").live(b.validationEventTriggers,function(g){a(g).attr("type")!="checkbox"&&c(this)});a(this).find("[class*=validate][type=checkbox]").live("click",function(){c(this)})}else{a(this).find("[class*=validate]").not("[type=checkbox]").bind(b.validationEventTriggers,function(){c(this)});a(this).find("[class*=validate][type=checkbox]").bind("click",
function(){c(this)})}firstvalid=false}var c=function(g){a.validationEngine.settings=b;if(a.validationEngine.intercept==false||!a.validationEngine.intercept){a.validationEngine.onSubmitValid=false;a.validationEngine.loadValidation(g)}else a.validationEngine.intercept=false}}if(b.returnIsValid)return a.validationEngine.submitValidation(this,b)?false:true;a(this).bind("submit",function(){a.validationEngine.onSubmitValid=true;a.validationEngine.settings=b;if(a.validationEngine.submitValidation(this,b)==
false){if(a.validationEngine.submitForm(this,b)==true)return false}else{b.failure&&b.failure();return false}});a(".formError").live("click",function(){a(this).fadeOut(150,function(){a(this).remove()})})};a.validationEngine={defaultSetting:function(){if(a.validationEngineLanguage)allRules=a.validationEngineLanguage.allRules;else a.validationEngine.debug("Validation engine rules are not loaded check your external file");settings={allrules:allRules,validationEventTriggers:"blur",inlineValidation:true,
containerOverflow:false,containerOverflowDOM:"",returnIsValid:false,scroll:true,unbindEngine:true,ajaxSubmit:false,promptPosition:"topRight",success:false,failure:function(){}};a.validationEngine.settings=settings},loadValidation:function(b){a.validationEngine.settings||a.validationEngine.defaultSetting();rulesParsing=a(b).attr("class");rulesRegExp=/\[(.*)\]/;getRules=rulesRegExp.exec(rulesParsing);if(getRules==null)return false;str=getRules[1];pattern=/\[|,|\]/;result=str.split(pattern);return a.validationEngine.validateCall(b,
result)},validateCall:function(b,c){function g(e,f){callerType=a(e).attr("type");if(callerType=="text"||callerType=="password"||callerType=="textarea")if(!a(e).val()){a.validationEngine.isError=true;h+=a.validationEngine.settings.allrules[f[i]].alertText+"<br />"}if(callerType=="radio"||callerType=="checkbox"){n=a(e).attr("name");if(a("input[name='"+n+"']:checked").size()==0){a.validationEngine.isError=true;h+=a("input[name='"+n+"']").size()==1?a.validationEngine.settings.allrules[f[i]].alertTextCheckboxe+
"<br />":a.validationEngine.settings.allrules[f[i]].alertTextCheckboxMultiple+"<br />"}}if(callerType=="select-one")if(!a(e).val()){a.validationEngine.isError=true;h+=a.validationEngine.settings.allrules[f[i]].alertText+"<br />"}if(callerType=="select-multiple")if(!a(e).find("option:selected").val()){a.validationEngine.isError=true;h+=a.validationEngine.settings.allrules[f[i]].alertText+"<br />"}}function j(e,f,k){customRule=f[k+1];pattern=eval(a.validationEngine.settings.allrules[customRule].regex);
if(!pattern.test(a(e).attr("value"))){a.validationEngine.isError=true;h+=a.validationEngine.settings.allrules[customRule].alertText+"<br />"}}function d(e,f,k){customString=f[k+1];if(customString==a(e).attr("value")){a.validationEngine.isError=true;h+=a.validationEngine.settings.allrules.required.alertText+"<br />"}}function o(e,f,k){customRule=f[k+1];funce=a.validationEngine.settings.allrules[customRule].nname;e=window[funce];if(typeof e==="function"){if(!e())a.validationEngine.isError=true;h+=a.validationEngine.settings.allrules[customRule].alertText+
"<br />"}}function l(e,f,k){customAjaxRule=f[k+1];postfile=a.validationEngine.settings.allrules[customAjaxRule].file;fieldValue=a(e).val();ajaxCaller=e;fieldId=a(e).attr("id");ajaxValidate=true;ajaxisError=a.validationEngine.isError;extraData=a.validationEngine.settings.allrules[customAjaxRule].extraData?a.validationEngine.settings.allrules[customAjaxRule].extraData:"";ajaxisError||a.ajax({type:"POST",url:postfile,async:true,data:"validateValue="+fieldValue+"&validateId="+fieldId+"&validateError="+
customAjaxRule+"&extraData="+extraData,beforeSend:function(){if(a.validationEngine.settings.allrules[customAjaxRule].alertTextLoad)if(a("div."+fieldId+"formError")[0])a.validationEngine.updatePromptText(ajaxCaller,a.validationEngine.settings.allrules[customAjaxRule].alertTextLoad,"load");else return a.validationEngine.buildPrompt(ajaxCaller,a.validationEngine.settings.allrules[customAjaxRule].alertTextLoad,"load")},error:function(m,p){a.validationEngine.debug("error in the ajax: "+m.status+" "+p)},
success:function(m){function p(r){for(x=0;x<ajaxErrorLength;x++)if(a.validationEngine.ajaxValidArray[x][0]==fieldId){a.validationEngine.ajaxValidArray[x][1]=r;existInarray=true}}m=eval("("+m+")");ajaxisError=m.jsonValidateReturn[2];customAjaxRule=m.jsonValidateReturn[1];fieldId=ajaxCaller=a("#"+m.jsonValidateReturn[0])[0];ajaxErrorLength=a.validationEngine.ajaxValidArray.length;existInarray=false;if(ajaxisError=="false"){p(false);if(!existInarray){a.validationEngine.ajaxValidArray[ajaxErrorLength]=
Array(2);a.validationEngine.ajaxValidArray[ajaxErrorLength][0]=fieldId;existInarray=a.validationEngine.ajaxValidArray[ajaxErrorLength][1]=false}a.validationEngine.ajaxValid=false;h+=a.validationEngine.settings.allrules[customAjaxRule].alertText+"<br />";a.validationEngine.updatePromptText(ajaxCaller,h,"",true)}else{p(true);a.validationEngine.ajaxValid=true;customAjaxRule||a.validationEngine.debug("wrong ajax response, are you on a server or in xampp? if not delete de ajax[ajaxUser] validating rule from your form ");
if(a.validationEngine.settings.allrules[customAjaxRule].alertTextOk)a.validationEngine.updatePromptText(ajaxCaller,a.validationEngine.settings.allrules[customAjaxRule].alertTextOk,"pass",true);else{ajaxValidate=false;a.validationEngine.closePrompt(ajaxCaller)}}}})}function s(e,f,k){confirmField=f[k+1];if(a(e).attr("value")!=a("#"+confirmField).attr("value")){a.validationEngine.isError=true;h+=a.validationEngine.settings.allrules.confirm.alertText+"<br />"}}function t(e,f,k){startLength=eval(f[k+1]);
endLength=eval(f[k+2]);feildLength=a(e).attr("value").length;if(feildLength<startLength||feildLength>endLength){a.validationEngine.isError=true;h+=a.validationEngine.settings.allrules.length.alertText+startLength+a.validationEngine.settings.allrules.length.alertText2+endLength+a.validationEngine.settings.allrules.length.alertText3+"<br />"}}function u(e,f,k){nbCheck=eval(f[k+1]);groupname=a(e).attr("name");groupSize=a("input[name='"+groupname+"']:checked").size();if(groupSize>nbCheck){a.validationEngine.showTriangle=
false;a.validationEngine.isError=true;h+=a.validationEngine.settings.allrules.maxCheckbox.alertText+"<br />"}}function v(e,f,k){nbCheck=eval(f[k+1]);groupname=a(e).attr("name");groupSize=a("input[name='"+groupname+"']:checked").size();if(groupSize<nbCheck){a.validationEngine.isError=true;a.validationEngine.showTriangle=false;h+=a.validationEngine.settings.allrules.minCheckbox.alertText+" "+nbCheck+" "+a.validationEngine.settings.allrules.minCheckbox.alertText2+"<br />"}}var h="";a(b).attr("id")||
a.validationEngine.debug("This field have no ID attribut( name & class displayed): "+a(b).attr("name")+" "+a(b).attr("class"));b=b;ajaxValidate=false;var n=a(b).attr("name");a.validationEngine.isError=false;a.validationEngine.showTriangle=true;callerType=a(b).attr("type");for(i=0;i<c.length;i++)switch(c[i]){case "optional":if(!a(b).val()){a.validationEngine.closePrompt(b);return a.validationEngine.isError}break;case "required":g(b,c);break;case "custom":j(b,c,i);break;case "exemptString":d(b,c,i);
break;case "ajax":a.validationEngine.onSubmitValid||l(b,c,i);break;case "length":t(b,c,i);break;case "maxCheckbox":u(b,c,i);groupname=a(b).attr("name");b=a("input[name='"+groupname+"']");break;case "minCheckbox":v(b,c,i);groupname=a(b).attr("name");b=a("input[name='"+groupname+"']");break;case "confirm":s(b,c,i);break;case "funcCall":o(b,c,i)}if(a("input[name='"+n+"']").size()>1&&(callerType=="radio"||callerType=="checkbox")){b=a("input[name='"+n+"'][type!=hidden]:first");a.validationEngine.showTriangle=
false}if(a.validationEngine.isError==true){var q="."+a.validationEngine.linkTofield(b);if(q!=".")a(q)[0]?a.validationEngine.updatePromptText(b,h):a.validationEngine.buildPrompt(b,h,"error");else a.validationEngine.updatePromptText(b,h)}else a.validationEngine.closePrompt(b);return a.validationEngine.isError?a.validationEngine.isError:false},submitForm:function(b){if(a.validationEngine.settings.ajaxSubmit){extraData=a.validationEngine.settings.ajaxSubmitExtraData?a.validationEngine.settings.ajaxSubmitExtraData:
"";a.ajax({type:"POST",url:a.validationEngine.settings.ajaxSubmitFile,async:true,data:a(b).serialize()+"&"+extraData,error:function(c,g){a.validationEngine.debug("error in the ajax: "+c.status+" "+g)},success:function(c){if(c=="true"){a(b).css("opacity",1);a(b).animate({opacity:0,height:0},function(){a(b).css("display","none");a(b).before("<div class='ajaxSubmit'>"+a.validationEngine.settings.ajaxSubmitMessage+"</div>");a.validationEngine.closePrompt(".formError",true);a(".ajaxSubmit").show("slow");
if(a.validationEngine.settings.success){a.validationEngine.settings.success&&a.validationEngine.settings.success();return false}})}else{c=eval("("+c+")");c.jsonValidateReturn||a.validationEngine.debug("you are not going into the success fonction and jsonValidateReturn return nothing");errorNumber=c.jsonValidateReturn.length;for(index=0;index<errorNumber;index++){fieldId=c.jsonValidateReturn[index][0];promptError=c.jsonValidateReturn[index][1];type=c.jsonValidateReturn[index][2];a.validationEngine.buildPrompt(fieldId,
promptError,type)}}}});return true}if(a.validationEngine.settings.beforeSuccess())return true;else if(a.validationEngine.settings.success){a.validationEngine.settings.unbindEngine&&a(b).unbind("submit");a.validationEngine.settings.success&&a.validationEngine.settings.success();return true}return false},buildPrompt:function(b,c,g,j){a.validationEngine.settings||a.validationEngine.defaultSetting();deleteItself="."+a(b).attr("id")+"formError";if(a(deleteItself)[0]){a(deleteItself).stop();a(deleteItself).remove()}var d=
document.createElement("div"),o=document.createElement("div");linkTofield=a.validationEngine.linkTofield(b);a(d).addClass("formError");g=="pass"&&a(d).addClass("greenPopup");g=="load"&&a(d).addClass("blackPopup");j&&a(d).addClass("ajaxed");a(d).addClass(linkTofield);a(o).addClass("formErrorContent");a.validationEngine.settings.containerOverflow?a(b).before(d):a("body").append(d);a(d).append(o);if(a.validationEngine.showTriangle!=false){var l=document.createElement("div");a(l).addClass("formErrorArrow");
a(d).append(l);if(a.validationEngine.settings.promptPosition=="bottomLeft"||a.validationEngine.settings.promptPosition=="bottomRight"){a(l).addClass("formErrorArrowBottom");a(l).html('<div class="line1"><!-- --\></div><div class="line2"><!-- --\></div><div class="line3"><!-- --\></div><div class="line4"><!-- --\></div><div class="line5"><!-- --\></div><div class="line6"><!-- --\></div><div class="line7"><!-- --\></div><div class="line8"><!-- --\></div><div class="line9"><!-- --\></div><div class="line10"><!-- --\></div>')}if(a.validationEngine.settings.promptPosition==
"topLeft"||a.validationEngine.settings.promptPosition=="topRight"){a(d).append(l);a(l).html('<div class="line10"><!-- --\></div><div class="line9"><!-- --\></div><div class="line8"><!-- --\></div><div class="line7"><!-- --\></div><div class="line6"><!-- --\></div><div class="line5"><!-- --\></div><div class="line4"><!-- --\></div><div class="line3"><!-- --\></div><div class="line2"><!-- --\></div><div class="line1"><!-- --\></div>')}}a(o).html(c);b=a.validationEngine.calculatePosition(b,c,g,j,d);
b.callerTopPosition+="px";b.callerleftPosition+="px";b.marginTopSize+="px";a(d).css({top:b.callerTopPosition,left:b.callerleftPosition,marginTop:b.marginTopSize,opacity:0});return a(d).animate({opacity:0.87},function(){return true})},updatePromptText:function(b,c,g,j){linkTofield=a.validationEngine.linkTofield(b);var d="."+linkTofield;g=="pass"?a(d).addClass("greenPopup"):a(d).removeClass("greenPopup");g=="load"?a(d).addClass("blackPopup"):a(d).removeClass("blackPopup");j?a(d).addClass("ajaxed"):
a(d).removeClass("ajaxed");a(d).find(".formErrorContent").html(c);b=a.validationEngine.calculatePosition(b,c,g,j,d);b.callerTopPosition+="px";b.callerleftPosition+="px";b.marginTopSize+="px";a(d).animate({top:b.callerTopPosition,marginTop:b.marginTopSize})},calculatePosition:function(b,c,g,j,d){if(a.validationEngine.settings.containerOverflow){callerleftPosition=callerTopPosition=0;callerWidth=a(b).width();inputHeight=a(d).height();c="-"+inputHeight}else{callerTopPosition=a(b).offset().top;callerleftPosition=
a(b).offset().left;callerWidth=a(b).width();inputHeight=a(d).height();c=0}if(a.validationEngine.settings.promptPosition=="topRight")if(a.validationEngine.settings.containerOverflow)callerleftPosition+=callerWidth-30;else{callerleftPosition+=callerWidth-30;callerTopPosition+=-inputHeight}if(a.validationEngine.settings.promptPosition=="topLeft")callerTopPosition+=-inputHeight-10;if(a.validationEngine.settings.promptPosition=="centerRight")callerleftPosition+=callerWidth+13;if(a.validationEngine.settings.promptPosition==
"bottomLeft"){callerHeight=a(b).height();callerTopPosition=callerTopPosition+callerHeight+15}if(a.validationEngine.settings.promptPosition=="bottomRight"){callerHeight=a(b).height();callerleftPosition+=callerWidth-30;callerTopPosition+=callerHeight+5}return{callerTopPosition:callerTopPosition,callerleftPosition:callerleftPosition,marginTopSize:c}},linkTofield:function(b){b=a(b).attr("id")+"formError";b=b.replace(/\[/g,"");return b=b.replace(/\]/g,"")},closePrompt:function(b,c){a.validationEngine.settings||
a.validationEngine.defaultSetting();if(c){a(b).fadeTo("fast",0,function(){a(b).remove()});return false}if(typeof ajaxValidate=="undefined")ajaxValidate=false;if(!ajaxValidate){linkTofield=a.validationEngine.linkTofield(b);closingPrompt="."+linkTofield;a(closingPrompt).fadeTo("fast",0,function(){a(closingPrompt).remove()})}},debug:function(b){if(!a.validationEngine.settings.openDebug)return false;a("#debugMode")[0]||a("body").append("<div id='debugMode'><div class='debugError'><strong>This is a debug mode, you got a problem with your form, it will try to help you, refresh when you think you nailed down the problem</strong></div></div>");
a(".debugError").append("<div class='debugerror'>"+b+"</div>")},submitValidation:function(b){var c=false;a.validationEngine.ajaxValid=true;a(b).find("[class*=validate]").size();a(b).find("[class*=validate]").each(function(){linkTofield=a.validationEngine.linkTofield(this);if(!a("."+linkTofield).hasClass("ajaxed"))return a.validationEngine.loadValidation(this)?c=true:""});ajaxErrorLength=a.validationEngine.ajaxValidArray.length;for(x=0;x<ajaxErrorLength;x++)if(a.validationEngine.ajaxValidArray[x][1]==
false)a.validationEngine.ajaxValid=false;if(c||!a.validationEngine.ajaxValid){if(a.validationEngine.settings.scroll)if(a.validationEngine.settings.containerOverflow){j=a(".formError:not('.greenPopup'):first").offset().top;b=a(a.validationEngine.settings.containerOverflowDOM).scrollTop();var g=-parseInt(a(a.validationEngine.settings.containerOverflowDOM).offset().top);j=b+j+g-5;a(a.validationEngine.settings.containerOverflowDOM+":not(:animated)").animate({scrollTop:j},1100)}else{var j=a(".formError:not('.greenPopup'):first").offset().top;
a(".formError:not('.greenPopup')").each(function(){testDestination=a(this).offset().top;if(j>testDestination)j=a(this).offset().top});a("html:not(:animated),body:not(:animated)").animate({scrollTop:j},1100)}return true}else return false}}})(jQuery);