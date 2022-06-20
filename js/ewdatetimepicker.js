/**
 * Create Date/Time Picker (for PHPMaker 2021)
 * @license Copyright (c) e.World Technology Limited. All rights reserved.
 */
ew.dateTimePickerOptions={keepInvalid:!0},ew.createDateTimePicker=function(e,t,a){if(!t.includes("$rowindex$")){var i=jQuery,o=ew.getElement(t,e),n=ew.getElement("sv_"+t,e),r=i(n||o),c="",s=ew.DATETIME_WITHOUT_SECONDS;if(o&&!r.data("DateTimePicker")&&!r.parent().data("DateTimePicker")){var l=function(e,t){return 5==e||9==e?t?9:5:6==e||10==e?t?10:6:7==e||11==e?t?11:7:12==e||15==e?t?15:12:13==e||16==e?t?16:13:14==e||17==e?t?17:14:e},d=(a=Object.assign({},ew.dateTimePickerOptions,a)).format;switch(d>100&&(d-=100,s=!0),0==d?d=ew.DATE_FORMAT_ID:1==d?d=l(ew.DATE_FORMAT_ID,!0):2==d&&(d=l(ew.DATE_FORMAT_ID,!1)),d){case 5:c="YYYY/MM/DD";break;case 6:c="MM/DD/YYYY";break;case 7:c="DD/MM/YYYY";break;case 9:c="YYYY/MM/DD HH:mm"+(s?"":":ss");break;case 10:c="MM/DD/YYYY HH:mm"+(s?"":":ss");break;case 11:c="DD/MM/YYYY HH:mm"+(s?"":":ss");break;case 12:c="YY/MM/DD";break;case 13:c="MM/DD/YY";break;case 14:c="DD/MM/YY";break;case 15:c="YY/MM/DD HH:mm"+(s?"":":ss");break;case 16:c="MM/DD/YY HH:mm"+(s?"":":ss");break;case 17:c="DD/MM/YY HH:mm"+(s?"":":ss")}c=c.replace(/\//g,ew.DATE_SEPARATOR).replace(/:/g,ew.TIME_SEPARATOR),a.format=c,a.locale||(a.locale=ew.LANGUAGE_ID.toLowerCase());var p=!i.isBoolean(a.inputGroup)||a.inputGroup;delete a.inputGroup,a.debug=a.debug||ew.DEBUG;var u={id:t,form:e,enabled:!0,inputGroup:p,options:a};i((function(){if(i(document).trigger("datetimepicker",[u]),u.enabled){if(!1!==u.inputGroup){var t=r,a="datetimepicker_"+e+r.attr("id");$btn=i('<button class="btn btn-default" type="button"><i class="far fa-calendar-alt"></i></button>').on("click",(function(){t.removeClass("is-invalid")})),r.addClass("datetimepicker-input").attr("data-target","#"+a).wrap('<div class="input-group date" id="'+a+'" data-target-input="nearest"></div>').after(i('<div class="input-group-append" data-target="#'+a+'" data-toggle="datetimepicker"></div>').append($btn)).on("focus",(function(){t.tooltip("hide").tooltip("disable")})).on("blur",(function(){t.tooltip("enable")})),r=r.parent().on("change.datetimepicker",(function(e){e.date&&(o.value=e.date.format(u.options.format))}))}else r.addClass("datetimepicker-input").attr({"data-toggle":"datetimepicker","data-target":"#"+r.attr("id")}).on("change.datetimepicker",(function(e){e.date&&(o.value=e.date.format(u.options.format))})).on("focus",(function(){r.tooltip("hide").tooltip("disable")})).on("blur",(function(){r.tooltip("enable")}));u.options.locale&&moment.locale()!=u.options.locale?loadjs(ew.PATH_BASE+"moment/locale/"+u.options.locale+".js",(function(){moment.localeData().postformat=function(e){return e},moment.updateLocale(u.options.locale,{invalidDate:ew.language.phrase("InvalidDate")}),r.datetimepicker(u.options)})):(moment.updateLocale(u.options.locale,{invalidDate:ew.language.phrase("InvalidDate")}),r.datetimepicker(u.options))}}))}}};