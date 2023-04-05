<?php
/*
 * Register Theme Customizer
 */

add_action('customize_register', 'cocobasic_customize_register');

function cocobasic_customize_register($wp_customize) {

    function cocobasic_clean_html($value) {
        $allowed_html_array = cocobasic_allowed_html();
        $value = wp_kses($value, $allowed_html_array);
        return $value;
    }

    function cocobasic_sanitize_select($input, $setting) {
        $input = sanitize_key($input);
        $choices = $setting->manager->get_control($setting->id)->choices;
        return ( array_key_exists($input, $choices) ? $input : $setting->default );
    }

    class Cocobasic_Customize_Textarea_Control extends WP_Customize_Control {

        public $type = 'textarea';

        public function render_content() {
            ?>
            <label>
                <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                <textarea rows="5" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea($this->value()); ?></textarea>
            </label>
            <?php
        }

    }

    //------------------------- MENU SECTION ---------------------------------------------

    $wp_customize->add_section('cocobasic_menu_settings', array(
        'title' => esc_html__('Sidebar / Menu Settings', 'ukko-wp'),
        'priority' => 30
    ));


    $wp_customize->add_setting('cocobasic_custom_sitetitle', array(
        'default' => '',
        'sanitize_callback' => 'cocobasic_clean_html'
    ));

    $wp_customize->add_control('cocobasic_custom_sitetitle', array(
        'label' => esc_html__('Custom Site Title:', 'ukko-wp'),
        'section' => 'cocobasic_menu_settings',
        'settings' => 'cocobasic_custom_sitetitle'
    ));


    $wp_customize->add_setting('cocobasic_show_section_num', array(
        'default' => 'no',
        'sanitize_callback' => 'cocobasic_clean_html'
    ));

    $wp_customize->add_control('cocobasic_show_section_num', array(
        'label' => esc_html__('Show Top Sections Numbers', 'ukko-wp'),
        'section' => 'cocobasic_menu_settings',
        'settings' => 'cocobasic_show_section_num',
        'type' => 'radio',
        'choices' => array(
            'yes' => esc_html__('Yes', 'ukko-wp'),
            'no' => esc_html__('No', 'ukko-wp'),
    )));


    $wp_customize->add_setting('cocobasic_menu_text', array(
        'default' => '',
        'sanitize_callback' => 'cocobasic_clean_html'
    ));

    $wp_customize->add_control(new Cocobasic_Customize_Textarea_Control($wp_customize, 'cocobasic_menu_text', array(
        'label' => esc_html__('Social Text', 'ukko-wp'),
        'section' => 'cocobasic_menu_settings',
        'settings' => 'cocobasic_menu_text'
    )));




    //------------------------- END MENU SECTION ---------------------------------------------
    //
    //    
    //            
    //
    //
    //----------------------------- IMAGE SECTION  ---------------------------------------------

    $wp_customize->add_section('cocobasic_image_section', array(
        'title' => esc_html__('Images Section', 'ukko-wp'),
        'priority' => 33
    ));


    $wp_customize->add_setting('cocobasic_preloader', array(
        'default' => '',
        'capability' => 'edit_theme_options',
        'type' => 'option',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'cocobasic_preloader', array(
        'label' => esc_html__('Preloader Gif', 'ukko-wp'),
        'section' => 'cocobasic_image_section',
        'settings' => 'cocobasic_preloader'
    )));

    $wp_customize->add_setting('cocobasic_preloader_width', array(
        'default' => "50px",
        'sanitize_callback' => 'cocobasic_clean_html'
    ));

    $wp_customize->add_control('cocobasic_preloader_width', array(
        'label' => esc_html__('Preloader Width:', 'ukko-wp'),
        'section' => 'cocobasic_image_section',
        'settings' => 'cocobasic_preloader_width'
    ));

    //----------------------------- END IMAGE SECTION  ---------------------------------------------
    //
    //
    //
    //---------------------------------- COLORS SECTION --------------------


    $wp_customize->add_setting('cocobasic_preloader_background_color', array(
        'default' => '#ffffff',
        'type' => 'option',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color'
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'cocobasic_preloader_background_color', array(
        'label' => esc_html__('Preloader Background Color', 'ukko-wp'),
        'section' => 'colors',
        'settings' => 'cocobasic_preloader_background_color'
    )));


    $wp_customize->add_setting('cocobasic_body_background_color', array(
        'default' => '#fff0f0',
        'type' => 'option',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color'
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'cocobasic_body_background_color', array(
        'label' => esc_html__('Body Background Color', 'ukko-wp'),
        'section' => 'colors',
        'settings' => 'cocobasic_body_background_color'
    )));


    $wp_customize->add_setting('cocobasic_global_color', array(
        'default' => '#f44647',
        'type' => 'option',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color'
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'cocobasic_global_color', array(
        'label' => esc_html__('Global Color', 'ukko-wp'),
        'section' => 'colors',
        'settings' => 'cocobasic_global_color'
    )));



    //---------------------------------------- END COLORS SECTION ------------------------------------------------------
    //
    //
    //
    //---------------------------------- FOOTER SECTION --------------------

    if (function_exists('elementor_fail_php_version')) {

        $wp_customize->add_section('cocobasic_footer_section', array(
            'title' => esc_html__('Footer', 'ukko-wp'),
            'priority' => 99
        ));

        $wp_customize->add_setting('cocobasic_select_footer', array(
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'cocobasic_sanitize_select',
            'default' => '',
        ));


        $wp_customize->add_control('cocobasic_select_footer', array(
            'type' => 'select',
            'section' => 'cocobasic_footer_section',
            'label' => esc_html__('Custom footer layout', 'ukko-wp'),
            'description' => esc_html__('select one of Elementor templates', 'ukko-wp'),
            'choices' => cocobasic_create_elementor_library_list()
        ));
    }


    //---------------------------------------- END FOOTER SECTION ------------------------------------------------------
    //
    //
    //
    //
    //--------------------------------------------------------------------------
    $wp_customize->get_setting('cocobasic_preloader_background_color')->transport = 'postMessage';
    $wp_customize->get_setting('cocobasic_body_background_color')->transport = 'postMessage';
    $wp_customize->get_setting('cocobasic_global_color')->transport = 'postMessage';

    //--------------------------------------------------------------------------
    /*
     * If preview mode is active, hook JavaScript to preview changes
     */
    if ($wp_customize->is_preview() && !is_admin()) {
        add_action('customize_preview_init', 'cocobasic_customize_preview_js');
    }
}

/**
 * Bind Theme Customizer JavaScript
 */
function cocobasic_customize_preview_js() {
    wp_enqueue_script('cocobasic-customizer', get_template_directory_uri() . '/admin/js/custom-admin.js', array('customize-preview'), '', true);
}

/*
 * Generate CSS Styles
 */

class Cocobasic_Css {

    public static function cocobasic_theme_customized_style() {
        echo '<style id="cocobasic-customizer-style" type="text/css">' .
        cocobasic_generate_css('.doc-loader', 'background-color', 'cocobasic_preloader_background_color', '', '!important') .
        cocobasic_generate_css('body.ccb-css:before, .ccb-css .content-holder, .ccb-css .footer-content', 'background-color', 'cocobasic_body_background_color') .
        cocobasic_generate_css('body.ccb-css a:hover, .ccb-css .global-color, .ccb-css .site-title:hover, .ccb-css .current-num, .ccb-css .sm-clean a.current, .ccb-css .sm-clean a:hover, .ccb-css .sm-clean a:active, .ccb-css .sm-clean a.highlighted, .ccb-css .sm-clean ul a:hover, .ccb-css .sm-clean ul a:active, .ccb-css .sm-clean ul a.highlighted, .ccb-css .sm-clean li.current > a, .ccb-css .sm-clean a span.sub-arrow, .ccb-css .more-posts:hover, .ccb-css .tags-holder a:hover, .ccb-css .replay-at-author, .search.ccb-css .nav-links .current, .archive.ccb-css .nav-links .current, .ccb-css .more-posts-portfolio:hover', 'color', 'cocobasic_global_color') .
        cocobasic_generate_css('.ccb-css .global-background-color, .ccb-css .site-title:hover:before, body.ccb-css .tags-holder a, .ccb-css blockquote.wp-block-quote, .ccb-css .close-icon, .ccb-css .owl-theme .owl-dots .owl-dot.active span', 'background-color', 'cocobasic_global_color') .
        cocobasic_generate_css('body.ccb-css .tags-holder a', 'border-color', 'cocobasic_global_color') .
        cocobasic_generate_additional_css() .
        '</style>';
    }

}

/*
 * Generate CSS Class - Helper Method
 */

function cocobasic_generate_css($selector, $style, $mod_name, $prefix = '', $postfix = '', $rgba = '') {
    $return = '';
    $mod = get_option($mod_name);
    if (!empty($mod)) {
        if ($rgba === true) {
            $mod = '0px 0px 50px 0px ' . cardea_hex2rgba($mod, 0.65);
        }
        $return = sprintf('%s { %s:%s; }', $selector, $style, $prefix . $mod . $postfix
        );
    }
    return $return;
}

function cocobasic_generate_additional_css() {
    $allowed_html_array = cocobasic_allowed_html();
    $return = '';
    if (get_theme_mod('cocobasic_preloader_width') != ''):
        $return .= '.ccb-css .doc-loader img{width: ' . get_theme_mod('cocobasic_preloader_width') . ';}';
    endif;
    $return = wp_strip_all_tags($return);
    return $return;
}

function cocobasic_create_elementor_library_list() {

    $listArray = ['' => ''];

    global $post;

    $elementorLoop = new WP_Query(array(
        'post_type' => 'elementor_library',
        'post_status' => 'publish',
        'posts_per_page' => '-1'
    ));

    while ($elementorLoop->have_posts()) : $elementorLoop->the_post();
        $listArray += [ $post->ID => $post->post_name];
    endwhile;

    wp_reset_postdata();
    return $listArray;
}
?>