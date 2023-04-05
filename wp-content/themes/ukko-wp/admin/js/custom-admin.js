(function ($) {

    "use stict";

    // COLORS                         
    wp.customize('cocobasic_preloader_background_color', function (value) {
        value.bind(function (to) {
            var inlineStyle, customColorCssElemnt;
            inlineStyle = '<style class="custom-color-css1">';

            inlineStyle += '.doc-loader { background-color: ' + to + ' !important; }';            

            inlineStyle += '</style>';

            customColorCssElemnt = $('.custom-color-css1');

            if (customColorCssElemnt.length) {
                customColorCssElemnt.replaceWith(inlineStyle);
            } else {
                $('head').append(inlineStyle);
            }

        });
    });

    wp.customize('cocobasic_body_background_color', function (value) {
        value.bind(function (to) {
            var inlineStyle, customColorCssElemnt;
            inlineStyle = '<style class="custom-color-css2">';
            
            inlineStyle += 'body.ccb-css:before, .ccb-css .content-holder, .ccb-css .footer-content { background-color: ' + to + '; }';            

            inlineStyle += '</style>';

            customColorCssElemnt = $('.custom-color-css2');

            if (customColorCssElemnt.length) {
                customColorCssElemnt.replaceWith(inlineStyle);
            } else {
                $('head').append(inlineStyle);
            }

        });
    });

    wp.customize('cocobasic_global_color', function (value) {
        value.bind(function (to) {
            var inlineStyle, customColorCssElemnt;
            inlineStyle = '<style class="custom-color-css3">';

            inlineStyle += 'body.ccb-css a:hover, .ccb-css .global-color, .ccb-css .site-title:hover, .ccb-css .current-num, .ccb-css .sm-clean a.current, .ccb-css .sm-clean a:hover, .ccb-css .sm-clean a:active, .ccb-css .sm-clean a.highlighted, .ccb-css .sm-clean ul a:hover, .ccb-css .sm-clean ul a:active, .ccb-css .sm-clean ul a.highlighted, .ccb-css .sm-clean li.current > a, .ccb-css .sm-clean a span.sub-arrow, .ccb-css .more-posts:hover, .ccb-css .tags-holder a:hover, .ccb-css .replay-at-author, .search.ccb-css .nav-links .current, .archive.ccb-css .nav-links .current, .ccb-css .more-posts-portfolio:hover { color: ' + to + '; }';                                    
            inlineStyle += '.ccb-css .global-background-color, .ccb-css .site-title:hover:before, body.ccb-css .tags-holder a, .ccb-css blockquote.wp-block-quote, .ccb-css .close-icon, .ccb-css .owl-theme .owl-dots .owl-dot.active span { background-color: ' + to + '; }';                                    
            inlineStyle += 'body.ccb-css .tags-holder a { border-color: ' + to + '; }';                                    

            inlineStyle += '</style>';

            customColorCssElemnt = $('.custom-color-css3');

            if (customColorCssElemnt.length) {
                customColorCssElemnt.replaceWith(inlineStyle);
            } else {
                $('head').append(inlineStyle);
            }

        });
    });
    
})(jQuery);