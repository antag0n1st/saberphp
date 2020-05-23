var lightbox_active = false;

var carouseltimer = {};
var slidertimer = {};

var product_category_w;
var product_category_h;
var header_h;

var entry_left_sidebar_offset_top = -1;
var ia_scrolling_entry_left_sidebar = false;

(function ($) {
    "use strict";

    $(document).ready(function () {



        /*
         if ( $(window).width() < 768 ) {
         
         var mobile_menu_width =  Math.round($(window).width()*0.6);
         $("#ia-mobile-nav-wrap").css("width",mobile_menu_width+"px");
         $("body").css("overflow-x","hidden");
         $("body").css("left", -1*mobile_menu_width + "px");
         $(".ia-shift-wrap").css("left","60%");
         $("#ia-mobile-nav-wrap").css("left","0");
         
         $(window).on('load',function() {
         
         $(".ia-shift-wrap").css("left","60%");
         });
         }
         */

        if ($("#ia-float-left-content-sidebar").length > 0) {
            ia_scrolling_entry_left_sidebar = true;
            $("#ia-float-left-content-sidebar").css("margin-top", "12px");
            var float_sidebar_w = $("#ia-float-left-content-sidebar").width();
            var entry_content_w = $("#ia-float-left-content-sidebar").parent().parent().width();
            $("#ia-float-left-content-sidebar").parent().css("width", float_sidebar_w + "px");
            $("#ia-float-right-entry-content").css("width", entry_content_w - 12 - float_sidebar_w + "px");
        }

        $(window).on('load',function () {

            var float_footer_h = 0;
            if ($("#ia-phone-float-footer").length > 0) {
                float_footer_h = $("#ia-phone-float-footer").height();
                $("#ia-back-to-top").css("bottom", float_footer_h + parseInt($("#ia-back-to-top").css("bottom")) + "px");
                $("body").css("padding-bottom", float_footer_h + parseInt($("body").css("padding-bottom")) + "px");
            }
            //ia-cookie-choices
            var cookie_choices_h = 0;
            if (($("#ia-cookie-choices").length > 0) && ($("#ia-cookie-choices").css("bottom") == '0px')) {
                cookie_choices_h = $("#ia-cookie-choices").height();
                ;
                $("#ia-back-to-top").css("bottom", 12 + cookie_choices_h + parseInt($("#ia-back-to-top").css("bottom")) + "px");
            }

            $("#ia-phone-float-footer-close").click(function () {
                $("#ia-phone-float-footer").css("bottom", "100%");
                var float_footer_h = $("#ia-phone-float-footer").height();
                $("#ia-back-to-top").css("bottom", parseInt($("#ia-back-to-top").css("bottom")) - float_footer_h + "px");
                $("body").css("padding-bottom", parseInt($("body").css("padding-bottom")) - float_footer_h + "px");
                return false;
            });
        });

        if (ia_scrolling_sidebar) {

            $(window).on('load',function () {
                // weave your magic here after everything is loaded.

                if ($(window).width() > 767) {

                    $(window).scroll(function () {

                        if(!$(".sidebar").offset()){
                            return;
                        }
                       // 

                        if ($(window).width() > 767) {
                            if (sidebar_offset_top == -1) {
                                sidebar_offset_top = $(".sidebar").offset().top;
                            }
                            if (($(window).scrollTop() > sidebar_offset_top) &&
                                    (($('.sidebar').height() + $(window).scrollTop() - sidebar_offset_top) < $("#content").height())) {
                                $('.sidebar').css('margin-top', $(window).scrollTop() - sidebar_offset_top + 24 + "px");
                                //console.log( $('.sidebar').height() + $(window).scrollTop() - sidebar_offset_top +" - "+$("#content").height());
                            } else if ($(window).scrollTop() > sidebar_offset_top) {
                                $('.sidebar').css('margin-top', $("#content").height() - $('.sidebar').height() + "px");
                            } else {
                                sidebar_offset_top = -1;
                                $('.sidebar').css('margin-top', "0px");
                            }
                        } else {
                            sidebar_offset_top = -1;
                            $('.sidebar').css('margin-top', "0px");
                        }

                    });

                }
            });
        }


        if (ia_scrolling_entry_left_sidebar) {

            $(window).on('load',function () {
                // weave your magic here after everything is loaded.

                if ($(window).width() > 767) {

                    $(window).scroll(function () {

                        if ($(window).width() > 767) {
                            if (entry_left_sidebar_offset_top == -1) {
                                entry_left_sidebar_offset_top = $("#ia-float-left-content-sidebar").offset().top;
                            }
                            if (($(window).scrollTop() > entry_left_sidebar_offset_top) &&
                                    (($('#ia-float-left-content-sidebar').height() + $(window).scrollTop() - entry_left_sidebar_offset_top) < $("#ia-float-right-entry-content").height())) {
                                $('#ia-float-left-content-sidebar').css('margin-top', $(window).scrollTop() - entry_left_sidebar_offset_top + 24 + "px");
                                //console.log( $('#ia-float-left-content-sidebar').height() + $(window).scrollTop() - sidebar_offset_top +" - "+$("#content .entry-content").height());
                            } else if ($(window).scrollTop() > entry_left_sidebar_offset_top) {
                                $('#ia-float-left-content-sidebar').css('margin-top', $("#ia-float-right-entry-content").height() - $('#ia-float-left-content-sidebar').height() + "px");
                            } else {
                                entry_left_sidebar_offset_top = -1;
                                $('#ia-float-left-content-sidebar').css('margin-top', "12px");
                            }
                        } else {
                            entry_left_sidebar_offset_top = -1;
                            $('#ia-float-left-content-sidebar').css('margin-top', "12px");
                        }

                    });

                }
            });
        }


        var attach_width = $(".entry-attachment-bigimage").width();
        var attach_height = Math.round(attach_width * 9 / 16);
        $(".entry-attachment-bigimage").css("height", attach_height + "px");

        //wait to for all images to be loaded
        $(window).on('load',function () {


            // code for ia slider widget
            $(".ia-slider").each(function (index) {
                var id = $(this).parent().attr("id");

                var li = $(this).find("ul > li").first();
                li.addClass("selected");

                var first = $(this).find("ul > li").first();
                var last = $(this).find("ul > li").last();
                $(this).find("ul").prepend('<li>' + last.html() + '</li>');
                $(this).find("ul").append('<li>' + first.html() + '</li>');


                var li_width = $(this).width();
                $(this).find("ul > li").css("width", li_width + "px");
                $(this).find("ul > li").css("display", "block");
                var li_height = li.height();

                var ul_width = 0;
                var ul_height = li_height;
                var thumbs = parseInt($(this).find("ul > li").length);
                ul_width = thumbs * li_width;

                $(this).css("height", ul_height + "px");
                $(this).find("ul").css("height", ul_height + "px");
                $(this).find("ul").css("width", ul_width + "px");
                $(this).find("ul").css("position", "absolute");
                $(this).find("ul").css("left", -1 * li_width + "px");

                var h3_size = Math.round(li_width * 0.03);
                if (h3_size < 10) {
                    h3_size = 10;
                }
                $(this).find("ul li a h3").css("font-size", h3_size + "px");

                if ($(this).find("ul > li").length > 1) {
                    slidertimer[id] = setTimeout(function () {
                        changeSlider(id)
                    }, 4000);
                }

                $(this).find(".ia-slider-button-right").click(function () {
                    var id = $(this).parent().parent().attr("id");
                    clearTimeout(slidertimer[id]);

                    var ul = $("#" + id).find("ul");
                    var width = ul.parent().width();
                    var left = parseInt(ul.css("left"));

                    var now = ul.find(".selected");
                    if (now.next().length > 0) {
                        var next = now.next();
                        ul.animate({left: (left - width)}, 500, function () {
                            now.parent().find(".selected").removeClass("selected");
                            next.addClass("selected");
                            if (next.next().length == 0) {
                                ul.css("left", -1 * width + "px");
                                var first = ul.find("li").first().next();
                                first.parent().find(".selected").removeClass("selected");
                                first.addClass("selected");
                            }
                            slidertimer[id] = setTimeout(function () {
                                changeSlider(id)
                            }, 5000);
                        });
                    }

                    return false;
                });

                $(this).find(".ia-slider-button-left").click(function () {
                    var id = $(this).parent().parent().attr("id");
                    clearTimeout(slidertimer[id]);

                    var ul = $("#" + id).find("ul");
                    var width = ul.parent().width();
                    var left = parseInt(ul.css("left"));

                    var now = ul.find(".selected");
                    if (now.prev().length > 0) {
                        var prev = now.prev();
                        ul.animate({left: (left + width)}, 500, function () {
                            now.parent().find(".selected").removeClass("selected");
                            prev.addClass("selected");
                            if (prev.prev().length == 0) {
                                var count = ul.find("li").length - 1;
                                ul.css("left", -1 * (count - 1) * width + "px");
                                var last = ul.find("li").last().prev();
                                last.parent().find(".selected").removeClass("selected");
                                last.addClass("selected");
                            }
                            slidertimer[id] = setTimeout(function () {
                                changeSlider(id)
                            }, 5000);
                        });
                    }
                    return false;
                });
            });

            // code for ia carousel widget
            if ($(window).width() >= 768) {
                $(".ia-carousel").each(function (index) {
                    $(this).find(".ia-carousel-container").css("width", $(this).find(".ia-carousel-container").width() + "px");

                    var ul_width = 0;
                    var ul_height = 0;
                    var li_width = 0;
                    $(this).find("ul > li").each(function (index) {
                        li_width = $(this).width() + 2 * parseInt($(this).css("padding-left"));
                        ul_height = $(this).height();
                        $(this).css("width", li_width + "px");
                        ul_width = ul_width + li_width;
                    });
                    $(this).css("height", ul_height + "px");
                    $(this).find(".ia-carousel-buttons").css("height", ul_height + "px");
                    $(this).find(".ia-carousel-buttons svg").css("height", ul_height + "px");


                    $(this).find(".ia-carousel-container").css("height", ul_height + "px");

                    $(this).find("ul").css("height", ul_height + "px");
                    $(this).find("ul").css("width", ul_width + "px");
                    $(this).find("ul").css("position", "absolute");
                    $(this).find("ul").css("left", "0px");

                    if ($(this).find("ul > li").length > 1) {
                        var id = $(this).parent().attr("id");
                        //setTimeout( function(){changeCarousel(id)}, 4000 );
                        carouseltimer[id] = setTimeout(function () {
                            changeCarousel(id)
                        }, 4000);
                    }

                    $(this).hover(
                            function () {
                                var id = $(this).parent().attr("id");
                                clearTimeout(carouseltimer[id]);
                            },
                            function () {
                                var id = $(this).parent().attr("id");
                                carouseltimer[id] = setTimeout(function () {
                                    changeCarousel(id)
                                }, 4000);
                            }
                    );

                    $(this).find(".ia-carousel-button-right").click(function () {
                        var id = $(this).parent().parent().attr("id");
                        clearTimeout(carouseltimer[id]);

                        var ul = $("#" + id).find("ul");
                        var width = $("#" + id).find(".ia-carousel-container").width();
                        var left = parseInt(ul.css("left"));

                        if (-1 * (left - width) < (ul.width() - width)) {
                            ul.animate({left: (left - width)}, 500, function () {
                                //carouseltimer[id] = setTimeout( function(){changeCarousel(id)}, 6000 );
                            });
                        } else {
                            ul.animate({left: 0}, 500, function () {
                                //carouseltimer[id] = setTimeout( function(){changeCarousel(id)}, 6000 );
                            });
                        }
                        return false;
                    });

                    $(this).find(".ia-carousel-button-left").click(function () {
                        var id = $(this).parent().parent().attr("id");
                        clearTimeout(carouseltimer[id]);

                        var ul = $("#" + id).find("ul");
                        var width = $("#" + id).find(".ia-carousel-container").width();
                        var left = parseInt(ul.css("left"));

                        if ((left + width) <= 0) {
                            ul.animate({left: (left + width)}, 500, function () {
                                //carouseltimer[id] = setTimeout( function(){changeCarousel(id)}, 6000 );
                            });
                        } else {
                            ul.animate({left: (width - ul.width())}, 500, function () {
                                //carouseltimer[id] = setTimeout( function(){changeCarousel(id)}, 6000 );
                            });
                        }
                        return false;
                    });

                });
            }


            //GALLERY ATTACHMENT PAGE --------------------------------------------------------------
            var attach_img_width = $(".entry-attachment-bigimage img").width();
            var attach_img_height = $(".entry-attachment-bigimage img").height();

            if ((attach_img_width / attach_img_height) < (16 / 9)) {
                $(".entry-attachment-bigimage img").css("height", (attach_height - 24) + "px");
                $(".entry-attachment-bigimage img").css("width", "auto");
                var attach_img_width = $(".entry-attachment-bigimage img").width();
                $(".entry-attachment-bigimage img").css("margin-left", Math.round((attach_width - attach_img_width) / 2) + "px");
            } else {
                $(".entry-attachment-bigimage img").css("width", attach_width + "px");
                $(".entry-attachment-bigimage img").css("height", "auto");
                var attach_img_height = $(".entry-attachment-bigimage img").height();
                $(".entry-attachment-bigimage img").css("margin-top", Math.round((attach_height - 24 - attach_img_height) / 2) + "px");
            }
            $(".entry-attachment-bigimage img").animate({opacity: 1}, 500, function () {
            });
            //GALLERY ATTACHMENT PAGE --------------------------------------------------------------
        });


        function changeSlider(id) {

            var ul = $("#" + id).find("ul");
            clearTimeout(slidertimer[id]);

            var width = ul.parent().width();
            var left = parseInt(ul.css("left"));

            var now = ul.find(".selected");
            if (now.next().length > 0) {
                var next = now.next();
                ul.animate({left: (left - width)}, 500, function () {
                    now.parent().find(".selected").removeClass("selected");
                    next.addClass("selected");
                    if (next.next().length == 0) {
                        ul.css("left", -1 * width + "px");
                        var first = ul.find("li").first().next();
                        first.parent().find(".selected").removeClass("selected");
                        first.addClass("selected");
                    }
                    slidertimer[id] = setTimeout(function () {
                        changeSlider(id)
                    }, 5000);
                });
            }
        }


        function changeCarousel(id) {

            var ul = $("#" + id).find("ul");
            clearTimeout(carouseltimer[id]);

            var width = $("#" + id).find(".ia-carousel-container").width();
            var left = parseInt(ul.css("left"));

            if (-1 * (left - width) < (ul.width() - width)) {
                ul.animate({left: (left - width)}, 500, function () {
                    carouseltimer[id] = setTimeout(function () {
                        changeCarousel(id)
                    }, 6000);
                });
            } else {
                ul.animate({left: 0}, 500, function () {
                    carouseltimer[id] = setTimeout(function () {
                        changeCarousel(id)
                    }, 6000);
                });
            }
        }


        $.fn.imgLoad = function (callback) {
            return this.each(function () {
                if (callback) {
                    if (this.complete || /*for IE 10-*/ $(this).height() > 0) {
                        callback.apply(this);
                    } else {
                        $(this).on('load', function () {
                            callback.apply(this);
                        });
                    }
                }
            });
        };


        // PRIMARY SEARCH --------------------------------------------------------------
        $('#ia-site-navigation-search a').click(function () {
            if ($("#ia-primary-search-panel-wrap").css("display") === 'block') {
                $("#ia-primary-search-panel-wrap").animate({
                    opacity: 0
                }, 500, function () {
                    $("#ia-primary-search-panel-wrap").css("display", "none");
                });
            } else {
                $("#ia-primary-search-panel-wrap").css("display", "block");
                $("#ia-primary-search-panel-wrap").animate({opacity: 1}, 500);
                $('html, body').animate({scrollTop: $('#ia-primary-search-panel-wrap').offset().top - 10}, 'slow');
                $("#ia-primary-search-text").focus();
            }
            return false;
        });

        $("#ia-primary-search-text").focusout(function () {
            if ($("#ia-primary-search-panel-wrap").css("display") === 'block') {
                $("#ia-primary-search-panel-wrap").animate({
                    opacity: 0
                }, 0, function () {
                    $("#ia-primary-search-panel-wrap").css("display", "none");
                });
            }
        });

        $("#ia-primary-search-text").keydown(function (e) {
            if ((e.keyCode || e.which) == 27) {
                if ($("#ia-primary-search-panel-wrap").css("display") === 'block') {
                    $("#ia-primary-search-panel-wrap").animate({
                        opacity: 0
                    }, 0, function () {
                        $("#ia-primary-search-panel-wrap").css("display", "none");
                    });
                }
            }
        });

        $("#ia-primary-search-panel-close").click(function () {
            if ($("#ia-primary-search-panel-wrap").css("display") === 'block') {
                $("#ia-primary-search-panel-wrap").animate({
                    opacity: 0
                }, 0, function () {
                    $("#ia-primary-search-panel-wrap").css("display", "none");
                });
            }
            return false;
        });
        // PRIMARY SEARCH --------------------------------------------------------------



        //MOBILE SEARCH --------------------------------------------------------------
        $('#ia-mobile-search').click(function () {
            if ($("#ia-mobile-search-panel").css("display") === 'table') {
                $("#ia-mobile-search-panel").animate({
                    opacity: 0
                }, 0, function () {
                    $("#ia-mobile-search-panel").css("display", "none");
                });
            } else {
                $("#ia-mobile-search-panel").css("display", "table");
                $("#ia-mobile-search-panel").animate({
                    opacity: 1
                }, 0);
                $("#ia-mobile-search-text").focus();
            }
            return false;
        });
        //MOBILE SEARCH --------------------------------------------------------------

        //OFFCANVAS MENU --------------------------------------------------------------
        $('#ia-mobile-menu-toggle').click(function () {


            if (parseInt($("#ia-mobile-nav-overlay").css("left")) == 0) {
                $("#sthoverbuttons").css("display", "block");
                $("html").css("overflow", "auto");
                $("body").css("overflow", "auto");
                $(".ia-shift-wrap").animate({
                    left: 0
                }, 0, function () {
                    $(".ia-shift-wrap").css("left", "0px");
                });
                $("#ia-mobile-nav-overlay").animate({
                    left: "-100%"
                }, 0);
            } else {
                $("#sthoverbuttons").css("display", "none");
                $("html").css("overflow", "hidden");
                $("body").css("overflow", "hidden");
                //var screen_w = $(window).width();
                //$("#ia-mobile-nav-wrap").css("width", Math.round($(window).width()*0.6)+"px");
                $("body").css("overflow-x", "hidden");
                $(".ia-shift-wrap").animate({
                    left: "60%"
                }, 0);
                $("#ia-mobile-nav-overlay").animate({
                    left: 0
                }, 0);
            }
            return false;
        });
        $('#ia-mobile-menu-close').click(function () {
            $("#sthoverbuttons").css("display", "block");
            $("html").css("overflow", "auto");
            $("body").css("overflow", "auto");
            $(".ia-shift-wrap").animate({
                left: 0
            }, 0, function () {
                $(".ia-shift-wrap").css("left", "0px");
            });
            $("#ia-mobile-nav-overlay").animate({
                left: "-100%"
            }, 0);
            return false;
        });

        //OFFCANVAS MENU --------------------------------------------------------------



        //AUTHOR INFO --------------------------------------------------------------
        $(".ia-tabs-navigation li a").click(function () {

            var url = $(this).attr("href");

            if (!$(this).parent().hasClass("active")) {
                $(this).parent().parent().find(".active").removeClass("active");
                $(this).parent().addClass("active");

                $(this).parent().parent().parent().find(".ia-tabs-content").find(".active").removeClass("active");
                $(url).addClass("active");
            }
            return false;
        });
        //AUTHOR INFO --------------------------------------------------------------


        //BACK TO TOP --------------------------------------------------------------
        $(window).scroll(function () {
            if ($(this).scrollTop() > 100) {
                $('#ia-back-to-top').fadeIn();
            } else {
                $('#ia-back-to-top').fadeOut();
            }
        });

        $('#ia-back-to-top').click(function () {
            $("html, body").animate({
                scrollTop: 0
            }, 800);
            return false;
        });
        //BACK TO TOP --------------------------------------------------------------


        $(window).resize(function () {

            resize_sliders();
            resize_ligthbox();

            if ($(window).width() < 768) {

            }

            if ($("#ia-float-left-content-sidebar").length > 0) {
                var float_sidebar_w = $("#ia-float-left-content-sidebar").width();
                var entry_content_w = $("#ia-float-left-content-sidebar").parent().parent().width();
                $("#ia-float-left-content-sidebar").parent().css("width", float_sidebar_w + "px");
                $("#ia-float-right-entry-content").css("width", entry_content_w - 12 - float_sidebar_w + "px");
            }
        });


        /* LIGHTBOX CODE --------------------------------------------------------------------------- */
        $("#content .entry-content a img").click(function () {

            //check if parent link is img
            var url = $(this).parent().attr("href");
            var alt = $(this).attr("alt");
            var url_parts = url.split(".");
            var total = url_parts.length - 1;

            var ext = url_parts[total];
            if ((ext == 'jpg') || (ext == 'jpeg') || (ext == 'png') || (ext == 'gif')) {
                //show image

                if ($("#ia_lightbox_image_loader").length == 0) {
                    $("body").append('<div id="ia_lightbox_image_loader"></div>');
                    $("#ia_lightbox_image_loader").css("position", "fixed");
                    $("#ia_lightbox_image_loader").css("left", "0px");
                    $("#ia_lightbox_image_loader").css("top", "-5000px");
                }

                if ($("#ia_lightbox_bigimage").length == 0) {
                    $("body").append('<div id="ia_lightbox_bigimage"><img src="#"></div>');
                    $("#ia_lightbox_bigimage").css("position", "fixed");
                    $("#ia_lightbox_bigimage").css("z-index", "11");
                    $("#ia_lightbox_bigimage").css("left", "-5000px");
                    $("#ia_lightbox_bigimage").css("top", "0px");
                    $("#ia_lightbox_bigimage").css("background", "#fff");
                    $("#ia_lightbox_bigimage").css("padding", "12px");

                    $("#ia_lightbox_bigimage").append('<div id="ia_lightbox_image_close"><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="16px" height="14px" viewBox="0 0 16 14" enable-background="new 0 0 16 14" xml:space="preserve" class="close-icon"><g><polygon points="11.98,14 0.417,0 4.018,0 15.584,14 	"/></g><g><polygon points="4.021,14 15.584,0 11.982,0 0.417,14 "/></g></svg></div>');
                    $("#ia_lightbox_image_close").css("position", "absolute");
                    $("#ia_lightbox_image_close").css("z-index", "2");
                    $("#ia_lightbox_image_close").css("top", "12px");
                    $("#ia_lightbox_image_close").css("right", "12px");
                    $("#ia_lightbox_image_close").css("padding", "8px 12px");
                    //$("#ia_lightbox_image_close").css("width","16px");
                    //$("#ia_lightbox_image_close").css("height","14px");
                    $("#ia_lightbox_image_close").css("background", "#ffffff");
                    $("#ia_lightbox_image_close").css("cursor", "pointer");

                    $("#ia_lightbox_bigimage").append('<div id="ia_lightbox_image_title"></div>');
                    $("#ia_lightbox_image_title").css("position", "absolute");
                    $("#ia_lightbox_image_title").css("z-index", "2");
                    $("#ia_lightbox_image_title").css("top", "-1.7em");
                    $("#ia_lightbox_image_title").css("left", "0px");
                    $("#ia_lightbox_image_title").css("font-size", "1.6em");
                    $("#ia_lightbox_image_title").css("height", "1.6em");
                    $("#ia_lightbox_image_title").css("overflow", "hidden");
                    $("#ia_lightbox_image_title").css("color", "#ffffff");


                    $("#ia_lightbox_bigimage").append('<div id="ia_lightbox_social_native"></div>');
                    $("#ia_lightbox_social_native").css("position", "relative");
                    $("#ia_lightbox_social_native").css("z-index", "2");
                    $("#ia_lightbox_social_native").css("width", "100%");
                    $("#ia_lightbox_social_native").css("padding-top", "10px");




                    //place google buttton
                    $("#ia_lightbox_social_native").append('<div class="ia_lightbox_social_native_button"><div class="g-plus" data-action="share" data-annotation="bubble"></div></div>');
//place google buttton
                    //$("#ia_lightbox_social_native").append('<div class="ia_lightbox_social_native_button"><a id="ia_lightbox_social_pintrest" href="//www.pinterest.com/pin/create/button/?url='+ia_current_url_for_social+'&media=&description=" data-pin-do="buttonPin" data-pin-config="beside" data-pin-color="red"><img src="//assets.pinterest.com/images/pidgets/pinit_fg_en_rect_red_20.png" /></a></div>');
                    //place facebook buttton
                    $("#ia_lightbox_social_native").append('<div class="ia_lightbox_social_native_button"><iframe src="//www.facebook.com/plugins/like.php?href=' + ia_current_url_for_social + '&amp;width&amp;layout=button_count&amp;action=like&amp;show_faces=false&amp;share=true&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:21px;" allowTransparency="true"></iframe></div>');
                    load_social();

                    $(".ia_lightbox_social_native_button").css("display", "block");
                    $(".ia_lightbox_social_native_button").css("position", "relative");
                    $(".ia_lightbox_social_native_button").css("float", "left");
                    $(".ia_lightbox_social_native_button").css("margin-right", "20px");
                }

                /*
                 if ( $("#ia_lightbox_image_preloader").length == 0) {
                 $("body").append('<div id="ia_lightbox_image_preloader">Loading</div>');
                 $("#ia_lightbox_image_preloader").css("position","fixed");
                 $("#ia_lightbox_image_preloader").css("z-index","2");
                 $("#ia_lightbox_image_preloader").css("top","0px");
                 $("#ia_lightbox_image_preloader").css("left","0px");
                 $("#ia_lightbox_image_preloader").css("display","none");
                 }
                 */

                if ($("#ia_lightbox_image_carpet").length == 0) {
                    $("body").append('<div id="ia_lightbox_image_carpet"></div>');
                    $("#ia_lightbox_image_carpet").css("position", "fixed");
                    $("#ia_lightbox_image_carpet").css("z-index", "9");
                    $("#ia_lightbox_image_carpet").css("left", "-5000px");
                    $("#ia_lightbox_image_carpet").css("top", "0px");
                    $("#ia_lightbox_image_carpet").css("background", "#000");
                    $("#ia_lightbox_image_carpet").css("opacity", "0");
                    $("#ia_lightbox_image_carpet").width(0);
                    $("#ia_lightbox_image_carpet").height(0);

                    $("#ia_lightbox_image_carpet").click(function ()
                    {
                        lightbox_close();
                        return false;
                    });

                    $("#ia_lightbox_image_close").click(function ()
                    {
                        lightbox_close();
                        return false;
                    });
                }

                if ($("#content .entry-content").data("lightbox-images") == undefined) {
                    lightbox_count_images();
                }
                $(this).addClass('lightbox_selected');
                lightbox_load_image(url, alt);
                registerKeys();
                return false;
            }

        });
        /* LIGHTBOX CODE --------------------------------------------------------------------------- */


        function lightbox_load_image(url, alt) {

            var padding = parseInt($("#ia_lightbox_bigimage").css("padding-top"));
            var iWindowWidth = $(window).width();
            var iWindowHeight = $(window).height();
            var iImgMaxWidth = Math.round(iWindowWidth * 0.9) - 2 * padding;
            var iImgMaxHeight = Math.round(iWindowHeight * 0.75) - 2 * padding;

            var iTotalLightboxImages = $("#content .entry-content").data("lightbox-images");


            $("#ia_lightbox_image_carpet").width(iWindowWidth);
            $("#ia_lightbox_image_carpet").height(iWindowHeight);
            $("#ia_lightbox_image_carpet").css("left", "0px");
            $("#ia_lightbox_image_carpet").animate({opacity: 0.7}, 300);

            //$("#ia_lightbox_image_preloader").css("display","block");
            //$("#ia_lightbox_image_preloader").css("top",Math.round((iWindowHeight-$("#ia_lightbox_image_preloader").css)/2)+'px');
            //$("#ia_lightbox_image_preloader").css("left",Math.round((iWindowWidth-$("#ia_lightbox_image_preloader").width())/2)+'px');

            $("#ia-preloader").css("display", "block");
            $("#ia-preloader").css("top", Math.round((iWindowHeight - $("#ia-preloader").height()) / 2) + 'px');
            $("#ia-preloader").css("left", Math.round((iWindowWidth - $("#ia-preloader").width()) / 2) + 'px');

            var imgSurce = url;

            $("#ia_lightbox_social_pintrest").attr("href", '//www.pinterest.com/pin/create/button/?url=' + ia_current_url_for_social + '&media=' + encodeURIComponent(imgSurce) + '&description=' + encodeURIComponent(alt));
            $("#ia_lightbox_image_loader").html('<img src="' + imgSurce + '">');
            $("#ia_lightbox_image_loader img").load(function () {

                $("#ia-preloader").css("display", "none");

                var imgWidthReal = $("#ia_lightbox_image_loader > img").width();
                var imgHeightReal = $("#ia_lightbox_image_loader > img").height();

                if ((imgWidthReal < iImgMaxWidth) && (imgHeightReal < iImgMaxHeight))
                {
                    var imgWidth = imgWidthReal;
                    var imgHeight = imgHeightReal;
                } else
                {
                    if ((imgWidthReal / imgHeightReal) > (iImgMaxWidth / iImgMaxHeight))
                    {
                        var imgWidth = iImgMaxWidth;
                        var imgHeight = Math.round(imgWidth * imgHeightReal / imgWidthReal);
                    } else
                    {
                        var imgHeight = iImgMaxHeight;
                        var imgWidth = Math.round(imgHeight * imgWidthReal / imgHeightReal);
                    }
                }



                $("#ia_lightbox_image_title").text('');
                $("#ia_lightbox_bigimage").animate({opacity: 0}, 300, function () {

                    var imgLeft = Math.round((iWindowWidth - imgWidth) / 2) - padding;
                    var imgTop = Math.round((iWindowHeight - imgHeight) / 2) - padding;
                    $(this).find('img').attr('src', imgSurce);
                    $(this).css("top", imgTop + 'px');
                    $(this).css("left", imgLeft + 'px');
                    //$(this).width(imgWidth);
                    // $(this).height(imgHeight);
                    $(this).find('img').width(imgWidth);
                    $(this).find('img').height(imgHeight);

                    if (iTotalLightboxImages > 1) {
                        //var iButtonsTop = Math.round( (iWindowHeight - $("#ia_lightbox_image_left").height())/2 );
                        var button_width = $(".ia_lightbox_image_button").width();
                        var button_height = $(".ia_lightbox_image_button").height();

                        var iButtonsTop = Math.round((iWindowHeight - button_height) / 2);
                        var iButtonsLeft = Math.round((iWindowWidth - imgWidth) / 2) - button_width;

                        $(".ia_lightbox_image_button").css("padding-top", iButtonsTop + "px");
                        $(".ia_lightbox_image_button").css("padding-bottom", iButtonsTop + "px");

                        $("#ia_lightbox_image_left").css("padding-right", iButtonsLeft + "px");
                        $("#ia_lightbox_image_right").css("padding-left", iButtonsLeft + "px");

                        //$("#ia_lightbox_image_right").css("top",iButtonsTop+"px");
                        $("#ia_lightbox_image_left").css("display", "block");
                        $("#ia_lightbox_image_right").css("display", "block");
                    }

                    $(this).animate({opacity: 1}, 500, function () {
                        if (alt != '') {
                            $("#ia_lightbox_image_title").text(alt);
                        }
                    });
                    lightbox_active = true;

                });
            });
        }
        function lightbox_close() {
            $("#ia_lightbox_image_left").css("display", "none");
            $("#ia_lightbox_image_right").css("display", "none");
            $(".lightbox_selected").removeClass('lightbox_selected');
            $("#ia_lightbox_image_carpet").animate({opacity: 0}, 300, function () {
                $(this).css("left", "-5000px");
                $(this).width(0);
                $(this).height(0);
            });

            $("#ia_lightbox_bigimage").animate({opacity: 0}, 300, function () {
                $(this).css("left", "-5000px");
                //$(this).width(0);
                //$(this).height(0);			
            });
            lightbox_active = false;
            unregisterKeys();
        }
        function resize_ligthbox() {

            if (lightbox_active) {
                var lightbox = $("#ia_lightbox_bigimage");

                var padding = parseInt(lightbox.css("padding-top"));
                var iWindowWidth = $(window).width();
                var iWindowHeight = $(window).height();
                var iImgMaxWidth = Math.round(iWindowWidth * 0.9) - 2 * padding;
                var iImgMaxHeight = Math.round(iWindowHeight * 0.9) - 2 * padding;

                $("#ia_lightbox_image_carpet").width(iWindowWidth);
                $("#ia_lightbox_image_carpet").height(iWindowHeight);

                var imgWidthReal = $("#ia_lightbox_image_loader > img").width();
                var imgHeightReal = $("#ia_lightbox_image_loader > img").height();

                if ((imgWidthReal < iImgMaxWidth) && (imgHeightReal < iImgMaxHeight))
                {
                    var imgWidth = imgWidthReal;
                    var imgHeight = imgHeightReal;
                } else
                {
                    if ((imgWidthReal / imgHeightReal) > (iImgMaxWidth / iImgMaxHeight))
                    {
                        var imgWidth = iImgMaxWidth;
                        var imgHeight = imgWidth * imgHeightReal / imgWidthReal;
                    } else
                    {
                        var imgHeight = iImgMaxHeight;
                        var imgWidth = imgHeight * imgWidthReal / imgHeightReal;
                    }
                }

                var imgLeft = Math.round((iWindowWidth - imgWidth) / 2) - padding;
                var imgTop = Math.round((iWindowHeight - imgHeight) / 2) - padding;

                lightbox.css("top", imgTop + 'px');
                lightbox.css("left", imgLeft + 'px');
                lightbox.width(imgWidth);
                lightbox.height(imgHeight);
                lightbox.find('img').width(imgWidth);
                lightbox.find('img').height(imgHeight);
            }
        }
        function lightbox_count_images() {

            var iCounter = 0;
            $("#content .entry-content a img").each(function (index) {
                var url = $(this).parent().attr("href");
                var url_parts = url.split(".");
                var total = url_parts.length - 1;

                var ext = url_parts[total];
                if ((ext == 'jpg') || (ext == 'jpeg') || (ext == 'png') || (ext == 'gif')) {
                    $(this).data("lightbox-image", iCounter);
                    $(this).addClass("ia_lightbox_image-" + iCounter);
                    iCounter++;
                }
            });
            if (iCounter > 1) {
                $("body").append('<div id="ia_lightbox_image_left" class="ia_lightbox_image_button"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="20px" height="60px" viewBox="0 0 20 60" enable-background="new 0 0 20 60" xml:space="preserve"><polygon class="slider-button-icon" points="12,0 20,0 8,30 20,60 12,60 0,30 "/></svg></div>');
                $("body").append('<div id="ia_lightbox_image_right" class="ia_lightbox_image_button"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="20px" height="60px" viewBox="0 0 20 60" enable-background="new 0 0 20 60" xml:space="preserve"><polygon class="slider-button-icon" points="8,0 0,0 12,30 0,60 8,60 20,30 "/></svg></div>');
                $(".ia_lightbox_image_button").css("position", "fixed");
                $(".ia_lightbox_image_button").css("top", "0px");
                $(".ia_lightbox_image_button").css("cursor", "pointer");
                $(".ia_lightbox_image_button").css("z-index", "10");
                $(".ia_lightbox_image_button").css("display", "none");
                $(".ia_lightbox_image_button").css("fill", "rgba(255,255,255,0.6)");
                $(".ia_lightbox_image_button").css("margin", "0px");

                $("#ia_lightbox_image_left").css("left", "0px");
                $("#ia_lightbox_image_right").css("right", "0px");

                $("#ia_lightbox_image_left").css("padding-left", "10px");
                $("#ia_lightbox_image_right").css("padding-right", "10px");


                $("#ia_lightbox_image_left").click(function () {
                    lightbox_prev();
                });

                $("#ia_lightbox_image_right").click(function () {
                    lightbox_next();
                });

                $(".ia_lightbox_image_button").hover(
                        function () {
                            $(this).find(".slider-button-icon").css("fill", "rgba(255,255,255,1)");
                        }, function () {
                    $(this).find(".slider-button-icon").css("fill", "rgba(255,255,255,0.6)");
                }
                );

            }
            $("#content .entry-content").data("lightbox-images", iCounter);
        }
        function lightbox_prev() {
            var i = parseInt($(".lightbox_selected").data("lightbox-image"));
            var iTotal = parseInt($("#content .entry-content").data("lightbox-images")) - 1;
            if (i == 0) {
                i = iTotal;
            } else {
                i--;
            }
            $(".lightbox_selected").removeClass('lightbox_selected');
            var prev_img = $(".ia_lightbox_image-" + i);
            prev_img.addClass('lightbox_selected');
            var url = prev_img.parent().attr("href");
            var alt = prev_img.attr("alt");
            lightbox_load_image(url, alt);
        }
        function lightbox_next() {
            var i = parseInt($(".lightbox_selected").data("lightbox-image"));
            var iTotal = parseInt($("#content .entry-content").data("lightbox-images")) - 1;
            if (i == iTotal) {
                i = 0;
            } else {
                i++;
            }
            $(".lightbox_selected").removeClass('lightbox_selected');
            var next_img = $(".ia_lightbox_image-" + i);
            next_img.addClass('lightbox_selected');
            var url = next_img.parent().attr("href");
            var alt = next_img.attr("alt");
            lightbox_load_image(url, alt);
        }
        function registerKeys() {
            $("body").keydown(function (e) {
                if ((e.keyCode || e.which) == 27)
                {
                    lightbox_close();
                }
                // left arrow
                if ((e.keyCode || e.which) == 37)
                {
                    lightbox_prev();
                }
                // right arrow
                if ((e.keyCode || e.which) == 39)
                {
                    lightbox_next();
                }
            });
        }
        function unregisterKeys() {
            $("body").unbind("keydown");
        }
        function load_social() {

            (function (d) {
                var f = d.getElementsByTagName('SCRIPT')[0], p = d.createElement('SCRIPT');
                p.type = 'text/javascript';
                p.async = true;
                p.src = '//assets.pinterest.com/js/pinit.js';
                f.parentNode.insertBefore(p, f);
            }(document));

            (function () {
                var po = document.createElement('script');
                po.type = 'text/javascript';
                po.async = true;
                po.src = 'https://apis.google.com/js/platform.js';
                var s = document.getElementsByTagName('script')[0];
                s.parentNode.insertBefore(po, s);
            })();
        }


        function resize_sliders() {

            $(".ia-slider").each(function (index) {
                var id = $(this).parent().attr("id");
                clearTimeout(slidertimer[id]);

                var li = $(this).find("ul > li").first();
                var left = parseInt($(this).find("ul").css("left"));
                var old_li_width = parseInt(li.width());
                var li_count_left = Math.round(left / old_li_width);

                var slider_width = $(this).width();
                var li_width = slider_width;
                var li_height = li_width * li.height() / li.width();
                $(this).find("ul > li").css("width", li_width + "px");


                var ul_height = li_height;
                var thumbs = parseInt($(this).find("ul > li").length);
                var ul_width = thumbs * li_width;

                $(this).css("height", ul_height + "px");
                $(this).find("ul").css("height", ul_height + "px");
                $(this).find("ul").css("width", ul_width + "px");
                $(this).find("ul").css("position", "absolute");
                $(this).find("ul").css("left", (li_count_left * li_width) + "px");

                var h3_size = Math.round(li_width * 0.03);
                if (h3_size < 10) {
                    h3_size = 10;
                }
                $(this).find("ul li a h3").css("font-size", h3_size + "px");

                if ($(this).find("ul > li").length > 1) {
                    slidertimer[id] = setTimeout(function () {
                        changeSlider(id)
                    }, 4000);
                }
            });

        }




        /* SLIDER CODE --------------------------------------------------------------------------- */
        var slider_id = "#ia-main-slider-container";
        var small_slides_w = 0;
        var small_slides_h = 0;
        var big_slides_w = 0;
        var big_slides_h = 0;
        var ia_main_slider_timeout;

        $(window).on('load',function () {

            //fix height of the small thumb containers
            small_slides_w = Math.round($(slider_id).find(".ia-slide-small").width());
            small_slides_h = Math.round(($(slider_id).find(".ia-main-slider").height() / 2));

            $(slider_id + " .ia-slide-small").each(function (index) {
                $(this).css("height", small_slides_h + "px");

                var image = new Image();
                image.src = $(this).find("img").attr('src');
                image.onload = function () {
                    $(slider_id + " .ia-slide-small").each(function (index) {

                        if (image.src == $(this).find("img").attr("src")) {

                            var img_w = $(this).find("img").width();
                            var img_h = $(this).find("img").height();
                            //console.log( img_w + ' x ' + img_h + ' - ' + small_slides_w + ' x ' + small_slides_h);
                            if ((img_w / img_h) > (small_slides_w / small_slides_h)) {
                                $(this).find("img").css("width", "auto");
                                $(this).find("img").css("height", small_slides_h + "px");
                            } else {
                                $(this).find("img").css("width", small_slides_w + "px");
                                $(this).find("img").css("height", "auto");
                            }
                        }
                    });
                }

            });

            big_slides_w = Math.round($(slider_id).find(".ia-slide-big").width());
            big_slides_h = Math.round($(slider_id).find(".ia-main-slider").height());

            $(slider_id + " .ia-slide-big").each(function (index) {

                var image = new Image();
                image.src = $(this).find("img").attr('src');
                image.onload = function () {
                    $(slider_id + " .ia-slide-big").each(function (index) {

                        if (image.src == $(this).find("img").attr("src")) {

                            var img_w = $(this).find("img").width();
                            var img_h = $(this).find("img").height();

                            if ((img_w / img_h) > (big_slides_w / big_slides_h)) {
                                $(this).find("img").css("width", "auto");
                                $(this).find("img").css("height", big_slides_h + "px");
                            } else {
                                $(this).find("img").css("width", big_slides_w + "px");
                                $(this).find("img").css("height", "auto");
                            }
                        }
                    });
                }
            });

            /*
             $(slider_id + " .ia-main-slider-frame").each(function(index) {
             
             if (index > 0) {
             $(this).css( "display", "none" );
             }
             });
             */
            //$(slider_id + " .ia-main-slider-frame").css( "display", "none" );
            //$(slider_id + " .ia-main-slider-frame.selected").css( "display", "block" );


            $(slider_id).data("ia-current-frame", "1");
            $(slider_id).data("ia-total-frames", $(slider_id).find(".ia-main-slider-frame").length);


            if ($(slider_id).find(".ia-main-slider-frame").length > 1) {
                ia_main_slider_timeout = setTimeout(function () {
                    changeIaMainSlider(slider_id)
                }, 5000);
            } else {
                $(slider_id).find(".ia-main-slide-nav").css("display", "none");
            }

            $(slider_id + " .ia-main-slider-frame").hover(
                    function () {
                        clearTimeout(ia_main_slider_timeout);
                    }, function () {
                var slider_id = "#" + $(this).parent().parent().parent().attr("id")
                ia_main_slider_timeout = setTimeout(function () {
                    changeIaMainSlider(slider_id)
                }, 5000);
            }
            );

            $(slider_id + " .ia-circle-nav").click(function (index) {
                var frame_no = $(this).data("circle-nav");
                clearTimeout(ia_main_slider_timeout);
                ia_main_slider_timeout = setTimeout(function () {
                    changeIaMainSlider(slider_id, frame_no)
                }, 0);
            });
        });


        function changeIaMainSlider(slider_id, clicked_frame) {
            clearTimeout(ia_main_slider_timeout);

            var clicked_frame = typeof clicked_frame !== 'undefined' ? clicked_frame : -1;

            var container = $(slider_id).find(".ia-main-slider");
            //var container = slider.find(".slider-items-container");
            var width = $(slider_id).width();
            var left = parseInt(container.css("margin-left"));
            var iCurrentFrame = parseInt($(slider_id).data("ia-current-frame"));
            var iTotalFrames = parseInt($(slider_id).data("ia-total-frames"));
            var iTotalCurrentSlides = container.find(".selected").length;

            var ia_main_slider_animation_right_out = 'fadeOutLeftSmall';
            var ia_main_slider_duration_out = '0.5';
            var ia_main_slider_delay_out = 0;

            var ia_main_slider_animation_right_in = 'fadeInRightSmall';
            var ia_main_slider_duration_in = '0.5';
            var ia_main_slider_delay_in = 0;


            var delay = 0;
            container.find(".selected").each(function (index) {
                $(this).addClass(ia_main_slider_animation_right_out + " animated");
                $(this).css("-webkit-animation-delay", delay + "s");
                $(this).css("animation-delay", delay + "s");
                $(this).css("-webkit-animation-duration", ia_main_slider_duration_out + "s");
                $(this).css("animation-duration", ia_main_slider_duration_out + "s");
                delay = delay + ia_main_slider_delay_out;

                $(this).one('webkitAnimationEnd oanimationend msAnimationEnd animationend', function () {
                    $(this).removeClass(ia_main_slider_animation_right_out + " animated");
                    $(this).css("opacity", "0");
                    $(this).css("left", "100%");
                    iTotalCurrentSlides--;

                    if (iTotalCurrentSlides == 0) {
                        $(slider_id).find('.ia-main-slider-frame-' + iCurrentFrame).removeClass("selected");
                        $(slider_id).find('.ia-circle-nav-' + iCurrentFrame).removeClass("selected");

                        if (clicked_frame > 0) {
                            iCurrentFrame = clicked_frame;
                        } else {
                            if (iCurrentFrame < iTotalFrames) {
                                iCurrentFrame++;
                                //container.css("margin-left",(left-width)+"px");
                            } else {
                                iCurrentFrame = 1;
                                // container.css("margin-left","0px");
                            }
                        }
                        $(slider_id).find('.ia-main-slider-frame-' + iCurrentFrame).addClass("selected");
                        $(slider_id).find('.ia-circle-nav-' + iCurrentFrame).addClass("selected");

                        delay = 0;
                        container.find(".selected").each(function (index) {
                            $(this).css("left", "auto");
                            $(this).css("opacity", "1");
                            $(this).addClass(ia_main_slider_animation_right_in + " animated");
                            $(this).css("-webkit-animation-delay", delay + "s");
                            $(this).css("animation-delay", delay + "s");
                            $(this).css("-webkit-animation-duration", ia_main_slider_duration_in + "s");
                            $(this).css("animation-duration", ia_main_slider_duration_in + "s");
                            delay = delay + ia_main_slider_delay_in;
                            $(this).one('webkitAnimationEnd oanimationend msAnimationEnd animationend', function () {
                                $(this).removeClass(ia_main_slider_animation_right_in + " animated");
                            });
                        });
                        $(slider_id).data("ia-current-frame", iCurrentFrame);
                        ia_main_slider_timeout = setTimeout(function () {
                            changeIaMainSlider(slider_id)
                        }, 5000);
                    }
                });
            });
        }
    });

})(jQuery);




