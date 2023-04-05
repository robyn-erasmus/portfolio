(function ($) {
    "use strict";

    var count = 1;
    var position = $(window).scrollTop();

    animateElement();
    stopAnimateOnScroll();
    placeholderToggle();
    setSlowScroll();
    setMenu();
    setActiveMenuItem();
    setCustomizerClass();
    setDataNumberForSections();
    setTotalPageNumber();
    $(".site-content").fitVids();
    loadMoreArticleIndex();

    $(window).on('load', function () {
        $('#toggle').on("click", multiClickFunctionStop);
        setHash();
        $('.doc-loader').fadeOut();
    });

    $(window).on('resize', function () {
        setActiveMenuItem();
    });

    $(window).on('scroll', function () {
        animateElement();
        setActiveMenuItem();
    });


//------------------------------------------------------------------------
//Helper Methods -->
//------------------------------------------------------------------------


    function stopAnimateOnScroll() {
        $("html, body").on("scroll mousedown wheel DOMMouseScroll mousewheel keyup touchmove", function () {
            $("html, body").stop();
        });
    }

    function placeholderToggle() {
        $('input, textarea').on('focus', function () {
            $(this).data('placeholder', $(this).attr('placeholder'));
            $(this).attr('placeholder', '');
        });
        $('input, textarea').on('blur', function () {
            $(this).attr('placeholder', $(this).data('placeholder'));
        });
    }

    function setSlowScroll() {
        $('#header-main-menu ul li a[href^="#"], a.button, .slow-scroll, .num-comments a, .elementor-button').on("click", function (e) {
            if ($(this).attr('href') === '#') {
                e.preventDefault();
            } else {
                if (!$(e.target).is('.sub-arrow')) {
                    if ($(window).width() < 1360) {
                        $('body').removeClass("open done");
                        $('#toggle').removeClass('on');
                    }
                    $('html, body').animate({scrollTop: $(this.hash).offset().top}, 1500);
                    return false;
                }
            }

        });
    }

    function multiClickFunctionStop(e) {
        e.preventDefault();
        $('#toggle').off("click");
        $('#toggle').toggleClass("on");
        $('body').toggleClass("open").delay(300).queue(function (next) {
            $(this).toggleClass("done");
            $('#toggle').on("click", multiClickFunctionStop);
            next();
        });
    }

    function setCustomizerClass() {
        if ($('#cocobasic-customizer-style').length) {
            $('body').addClass('ccb-css');
        }
    }

    function setMenu() {
        //Fix for default menu
        $(".default-menu ul:first").addClass('sm sm-clean main-menu');

        if (!$('.top-pagination').length) {
            $('.menu-wrapper').addClass('no-top-padding');
        }

        $('.one-page-section').each(function () {
            $(this).find('a:first').attr('href', ajax_var.webUrl + $(this).find('a:first').attr('href'));
        });

        $('.main-menu').smartmenus({
            subMenusSubOffsetX: 1,
            subMenusSubOffsetY: -8,
            markCurrentItem: true
        });

        var $mainMenu = $('.main-menu').on('click', 'span.sub-arrow', function (e) {
            var obj = $mainMenu.data('smartmenus');
            if (obj.isCollapsible()) {
                var $item = $(this).parent(),
                        $sub = $item.parent().dataSM('sub');
                $sub.dataSM('arrowClicked', true);
            }
        }).bind({
            'beforeshow.smapi': function (e, menu) {
                var obj = $mainMenu.data('smartmenus');
                if (obj.isCollapsible()) {
                    var $menu = $(menu);
                    if (!$menu.dataSM('arrowClicked')) {
                        return false;
                    }
                    $menu.removeDataSM('arrowClicked');
                }
            }
        });
    }

    function setActiveMenuItem() {
        var currentSection = null;
        var c = $('.site-content .op-section.section-active').data("num");
        var scroll = $(window).scrollTop();
        $('.op-section').each(function () {
            var element = $(this).attr('id');
            if ($('#' + element).is('*')) {
                if ($(window).scrollTop() >= $('#' + element).offset().top - 150) {
                    currentSection = element;
                }
            }
        });
        $('#header-main-menu ul li').removeClass('current').find('a[href*="#' + currentSection + '"]').parent().addClass('current');
        $('.site-content .op-section').removeClass('section-active');
        $('#' + currentSection).addClass('section-active');

        if (c !== $('#' + currentSection).data("num")) {
            c = $('#' + currentSection).data("num");
            $('.current-num span').animate({"opacity": '0', "left": "-5px"}, 150, function () {
                $(this).text(c).animate({"opacity": '1', "left": "0"}, 150);
                $('.current-big-num').text(c).data("num");
            });
        }

        position = scroll;
    }

    function setHash() {
        var hash = location.hash;
        if ((hash !== '') && ($(hash).length))
        {
            $('html, body').animate({scrollTop: $(hash).offset().top}, 1);
            $('html, body').animate({scrollTop: $(hash).offset().top}, 1);
        } else {
            $(window).scrollTop(1);
            $(window).scrollTop(0);
        }
    }

    function setTotalPageNumber() {
        if ($('.site-content .op-section').length) {
            $('.total-pages-num').html(('0' + $('.site-content .op-section').length).slice(-2));
        } else {
            $('.total-pages-num').html('01');
        }
    }

    function setDataNumberForSections() {
        var k = 1;
        $('.site-content .op-section').each(function () {
            $(this).data('num', ('0' + k).slice(-2));
            k++;
        });
    }

    function animateElement() {
        $(".animate").each(function (i) {
            var top_of_object = $(this).offset().top;
            var bottom_of_window = $(window).scrollTop() + $(window).height();
            if ((bottom_of_window - 70) > top_of_object) {
                $(this).addClass('show-it');
            }
        });
    }

    function loadMoreArticleIndex() {
        if (parseInt(ajax_var.posts_per_page_index) < parseInt(ajax_var.total_index)) {
            $('.more-posts').css('visibility', 'visible');
            $('.more-posts').animate({opacity: 1}, 1500);
        } else {
            $('.more-posts, .more-posts-index-holder').css('display', 'none');
        }

        $('.more-posts:visible').on('click', function () {
            $('.more-posts').css('display', 'none');
            $('.more-posts-loading').css('display', 'inline-block');
            count++;
            loadArticleIndex(count);
        });
    }

    function loadArticleIndex(pageNumber) {
        $.ajax({
            url: ajax_var.url,
            type: 'POST',
            data: "action=infinite_scroll_index&page_no_index=" + pageNumber + '&loop_file_index=loop-index&security=' + ajax_var.nonce,
            success: function (html) {
                $('.blog-holder').imagesLoaded(function () {
                    $(".blog-holder").append(html);
                    setTimeout(function () {
                        animateElement();
                        if (count == ajax_var.num_pages_index) {
                            $('.more-posts').css('display', 'none');
                            $('.more-posts-loading').css('display', 'none');
                            $('.no-more-posts').css('display', 'inline-block');
                        } else {
                            $('.more-posts').css('display', 'inline-block');
                            $('.more-posts-loading').css('display', 'none');
                            $(".more-posts-index-holder").removeClass('stop-loading');
                        }
                    }, 100);
                });
            }
        });
        return false;
    }

})(jQuery);