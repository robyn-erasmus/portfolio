(function ($) {
    "use stict";
    $(window).on('elementor/frontend/init', function () {

        elementorFrontend.hooks.addAction('frontend/element_ready/global', function () {
            setDataNumberForSections();
            setTotalPageNumber();
        });

        elementorFrontend.hooks.addAction('frontend/element_ready/coco-portfolio.default', function () {
            isotopeSetUp();
        });

        elementorFrontend.hooks.addAction('frontend/element_ready/coco-imageslider.default', function () {
            imageSliderSetUp();
        });
    });

    function isotopeSetUp() {
        $('.grid').imagesLoaded(function () {
            $('.grid').isotope({
                itemSelector: '.grid-item',
                transitionDuration: 0,
                masonry: {
                    columnWidth: '.grid-sizer'
                }
            });
            $('.grid').isotope('layout');
        });
    }

    function imageSliderSetUp() {
        $(".image-slider").each(function () {
            var speed_value = $(this).data('speed');
            var auto_value = $(this).data('auto');
            var hover_pause = $(this).data('hover');
            if (auto_value === true) {
                $(this).owlCarousel({
                    loop: true,
                    autoHeight: true,
                    smartSpeed: 1000,
                    autoplay: auto_value,
                    autoplayHoverPause: hover_pause,
                    autoplayTimeout: speed_value,
                    responsiveClass: true,
                    items: 1
                });
                $(this).on('mouseleave', function () {
                    $(this).trigger('stop.owl.autoplay');
                    $(this).trigger('play.owl.autoplay', [auto_value]);
                });
            } else {
                $(this).owlCarousel({
                    loop: true,
                    autoHeight: true,
                    smartSpeed: 1000,
                    autoplay: false,
                    responsiveClass: true,
                    items: 1
                });
            }
        });
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

})(jQuery);