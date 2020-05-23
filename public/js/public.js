(function ($) {
	"use strict";
	$(function () {
		// Place your public-facing JavaScript here
		//ia_cc_set_cookie("ia_cookie_choices_accept","",365);
		var ia_cc_accept = ia_cc_get_cookie("ia_cookie_choices_accept");
		
		if ( ia_cc_accept != 'true' ) {
			
			if ( (ia_cc_show_location == 'top') || (ia_cc_show_location == 'fixed_top') ) {
				console.log(ia_cc_show_location);
				$("body").prepend('<div id="ia-cookie-choices" class="ia-shift-wrap">'+ia_cc_text_to_show+'</div>');
				if (ia_cc_show_location == 'fixed_top') {
					$("#ia-cookie-choices").css("position","fixed");
					$("#ia-cookie-choices").css("left","0px");
					$("#ia-cookie-choices").css("top","0px");
				}
				$("#ia-cookie-choices").css("background-color",ia_cc_background_color);
				$("#ia-cookie-choices").css("color",ia_cc_font_color);
				$("#ia-cookie-choices a").css("color",ia_cc_font_color);
				$("#ia-cookie-choices a:hover").css("color",ia_cc_font_color);
				$("#ia-cookie-choices").css("border-bottom","solid 1px " + ia_cc_font_color);
				$("#ia-cookie-choices-button").css("background-color",ia_cc_font_color);
				$("#ia-cookie-choices-button").css("color",ia_cc_background_color);
				ia_cc_hide_cookie_choices();
				
			} else if ( (ia_cc_show_location == 'bottom') || (ia_cc_show_location == 'fixed_bottom') ) {
				
				$("body").append('<div id="ia-cookie-choices" class="ia-shift-wrap">'+ia_cc_text_to_show+'</div>');
				if (ia_cc_show_location == 'fixed_bottom') {
					$("#ia-cookie-choices").css("position","fixed");
					$("#ia-cookie-choices").css("left","0px");
					$("#ia-cookie-choices").css("bottom","0px");
				}
				$("#ia-cookie-choices").css("background-color",ia_cc_background_color);
				$("#ia-cookie-choices").css("color",ia_cc_font_color);
				$("#ia-cookie-choices a").css("color",ia_cc_font_color);
				$("#ia-cookie-choices a:hover").css("color",ia_cc_font_color);
				$("#ia-cookie-choices").css("border-top","solid 1px " + ia_cc_font_color);
				$("#ia-cookie-choices-button").css("background-color",ia_cc_font_color);
				$("#ia-cookie-choices-button").css("color",ia_cc_background_color);
				ia_cc_hide_cookie_choices();
				
			}
	
			if ( (ia_cc_mobile_show_location == 'top') || (ia_cc_mobile_show_location == 'fixed_top') ) {
				
				$("body").prepend('<div id="ia-cookie-choices-mobile" class="ia-shift-wrap">'+ia_cc_text_to_show_mobile+'</div>');
				if (ia_cc_mobile_show_location == 'fixed_top') {
					$("#ia-cookie-choices-mobile").css("position","fixed");
					$("#ia-cookie-choices-mobile").css("left","0px");
					$("#ia-cookie-choices-mobile").css("top","0px");
				}
				$("#ia-cookie-choices-mobile").css("background-color",ia_cc_background_color);
				$("#ia-cookie-choices-mobile").css("color",ia_cc_font_color);
				$("#ia-cookie-choices-mobile a").css("color",ia_cc_font_color);
				$("#ia-cookie-choices-mobile").css("border-bottom","solid 1px " + ia_cc_font_color);
				$("#ia-cookie-choices-mobile-button").css("background-color",ia_cc_font_color);
				$("#ia-cookie-choices-mobile-button").css("color",ia_cc_background_color);
				ia_cc_hide_cookie_choices();
				
			} else if ( (ia_cc_mobile_show_location == 'bottom') || (ia_cc_mobile_show_location == 'fixed_bottom') ) {
				
				$("body").append('<div id="ia-cookie-choices-mobile" class="ia-shift-wrap">'+ia_cc_text_to_show_mobile+'</div>');
				if (ia_cc_mobile_show_location == 'fixed_bottom') {
					$("#ia-cookie-choices-mobile").css("position","fixed");
					$("#ia-cookie-choices-mobile").css("left","0px");
					$("#ia-cookie-choices-mobile").css("bottom","0px");
				}
				$("#ia-cookie-choices-mobile").css("background-color",ia_cc_background_color);
				$("#ia-cookie-choices-mobile").css("color",ia_cc_font_color);
				$("#ia-cookie-choices-mobile a").css("color",ia_cc_font_color);
				$("#ia-cookie-choices-mobile").css("border-top","solid 1px " + ia_cc_font_color);
				$("#ia-cookie-choices-mobile-button").css("background-color",ia_cc_font_color);
				$("#ia-cookie-choices-mobile-button").css("color",ia_cc_background_color);
				ia_cc_hide_cookie_choices();
				
			}
		}
		
		$("#ia-cookie-choices-button").click(function() {
			ia_cc_set_cookie("ia_cookie_choices_accept","true",365);
			$("#ia-cookie-choices").remove();
			$("#ia-cookie-choices-mobile").remove();
		});
		$("#ia-cookie-choices-mobile-button").click(function() {
			ia_cc_set_cookie("ia_cookie_choices_accept","true",365);
			$("#ia-cookie-choices").remove();
			$("#ia-cookie-choices-mobile").remove();
		});
		
		function ia_cc_hide_cookie_choices() {
			if ( parseInt(ia_cc_hide_timeout) > 0 ) {
				setTimeout(function(){ 
					ia_cc_set_cookie("ia_cookie_choices_accept","true",365); 
					$("#ia-cookie-choices").remove(); 
				}, 
				parseInt(ia_cc_hide_timeout)*1000);
			}
		}
	});
}(jQuery));




function ia_cc_set_cookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires + "; path=/";
}

function ia_cc_get_cookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
    }
    return "";
}