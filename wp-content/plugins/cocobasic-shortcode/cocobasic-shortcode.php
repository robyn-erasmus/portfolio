<?php

/*
 * Plugin Name: CocoBasic - Ukko WP
 * Description: User interface used in Ukko WP theme.
 * Version: 1.2
 * Author: CocoBasic
 * Author URI: https://www.cocobasic.com
 */


if (!defined('ABSPATH'))
    die("Can't load this file directly");

class cocobasic_shortcodes {

    function __construct() {
        add_action('init', array($this, 'myplugin_load_textdomain'));
        add_action('admin_init', array($this, 'cocobasic_admin_enqueue_script'));
    }

    function myplugin_load_textdomain() {
        load_plugin_textdomain('cocobasic-shortcode', false, dirname(plugin_basename(__FILE__)) . '/languages/');
    }

    function cocobasic_admin_enqueue_script() {
        wp_enqueue_style('admin-style', plugins_url('css/admin-style.css', __FILE__));
        wp_enqueue_script('cocobasic-admin-main-js', plugins_url('js/admin-main.js', __FILE__), array('jquery'), '', true);
    }

}

$cocobasic_shortcodes = new cocobasic_shortcodes();


add_theme_support('post-thumbnails', array('portfolio'));
add_action('init', 'cocobasic_allowed_plugin_html');
add_action('add_meta_boxes', 'cocobasic_add_page_custom_meta_box');
add_action('add_meta_boxes', 'cocobasic_add_portfolio_custom_meta_box');
add_action('wp_ajax_portfolio_ajax_content_load', 'cocobasic_portfolio_item_content_load');
add_action('wp_ajax_nopriv_portfolio_ajax_content_load', 'cocobasic_portfolio_item_content_load');
add_action('wp_ajax_portfolio_ajax_load_more', 'cocobasic_portfolio_load_more_item');
add_action('wp_ajax_nopriv_portfolio_ajax_load_more', 'cocobasic_portfolio_load_more_item');
add_action('save_post', 'cocobasic_save_page_custom_meta');
add_action('save_post', 'cocobasic_save_portfolio_custom_meta');
add_filter('body_class', 'cocobasic_browserBodyClass');
add_filter('single_template', 'cocobasic_custom_single_post');


// <editor-fold defaultstate="collapsed" desc="Include Custom Single Post Templates">
function cocobasic_custom_single_post($template) {
    global $post;

    $arr = array("portfolio");
    foreach ($arr as $value) {
        // Is this a "my-custom-post-type" post?
        if ($post->post_type == $value) {

            //Your plugin path 
            $plugin_path = plugin_dir_path(__FILE__);

            // The name of custom post type single template
            $template_name = 'single-' . $value . '.php';

            // A specific single template for my custom post type exists in theme folder?
            if ($template === get_stylesheet_directory() . '/' . $template_name) {

                //Then return "single.php" or "single-my-custom-post-type.php" from theme directory.
                return $template;
            }

            // If not, return my plugin custom post type template.
            return $plugin_path . 'templates/' . $template_name;
        }
    }

    //This is not my custom post type, do nothing with $template
    return $template;
}

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Load Portfolio More Items with Ajax">
function cocobasic_portfolio_load_more_item() {
    check_ajax_referer('ajax-cocobasic-portfolio-load-more', 'security');

    $args = array(
        'post_type' => 'portfolio',
        'post_status' => 'publish',
        'posts_per_page' => sanitize_text_field($_POST['portfolio_posts_per_page']),
        'paged' => sanitize_text_field($_POST['portfolio_page_number'])
    );

    $portfolio_load_more_query = new WP_Query($args);
    if (file_exists(get_stylesheet_directory() . '/load-more-portfolio.php')) {
        require (get_stylesheet_directory() . '/load-more-portfolio.php');
    } else {
        require ('templates/load-more-portfolio.php');
    }
    wp_die();
}

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Load Portfolio Item Content with Ajax">
function cocobasic_portfolio_item_content_load() {        
    check_ajax_referer('ajax-cocobasic-portfolio-content', 'security');    
    if (isset($_POST["action"]) && ($_POST["action"] === 'portfolio_ajax_content_load')) {                
        $args = array(
            'p' => sanitize_text_field($_POST['portfolio_id']),
            'post_type' => 'portfolio',
            'posts_per_page' => 1
        );

        $portfolio_query = new WP_Query($args);
        if (file_exists(get_stylesheet_directory() . '/single-portfolio.php')) {
            require (get_stylesheet_directory() . '/single-portfolio.php');
        } else {
            require ('templates/ajax-single-portfolio.php');
        }
        wp_die();
    }
}
// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Register custom 'Portfolio' post type">
function create_portfolio() {
    $portfolio_args = array(
        'label' => esc_html__('Portfolio', 'cocobasic-shortcode'),
        'singular_label' => esc_html__('Portfolio', 'cocobasic-shortcode'),
        'public' => true,
        'show_ui' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'rewrite' => true,
        'supports' => array('title', 'editor', 'comments', 'custom-fields', 'thumbnail'),
        'show_in_rest' => true
    );
    register_post_type('portfolio', $portfolio_args);
}

add_action('init', 'create_portfolio');

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Add the Meta Box to 'Pages'"> 
function cocobasic_add_page_custom_meta_box() {
    add_meta_box(
            'cocobasic_page_custom_meta_box', // $id  
            esc_html__('Page Preference', 'cocobasic-shortcode'), // $title   
            'cocobasic_show_page_custom_meta_box', // $callback  
            'page', // $page  
            'normal', // $context  
            'high'); // $priority     
}

// Field Array Post Page 
$prefix = 'page_';
$page_custom_meta_fields = array(
    array(
        'label' => esc_html__('Show Page Title', 'cocobasic-shortcode'),
        'desc' => '',
        'id' => $prefix . 'show_title',
        'type' => 'select',
        'options' => array(
            'one' => array(
                'label' => esc_html__('Yes', 'cocobasic-shortcode'),
                'value' => 'yes'
            ),
            'two' => array(
                'label' => esc_html__('No', 'cocobasic-shortcode'),
                'value' => 'no'
            )
        )
    )
);

// The Callback  
function cocobasic_show_page_custom_meta_box() {
    global $page_custom_meta_fields, $post;
    $allowed_plugin_tags = cocobasic_allowed_plugin_html();
// Use nonce for verification  
    echo '<input type="hidden" name="custom_meta_box_nonce" value="' . esc_attr(wp_create_nonce(basename(__FILE__))) . '" />';
// Begin the field table and loop  
    echo '<table class="form-table">';
    foreach ($page_custom_meta_fields as $field) {
// get value of this field if it exists for this post  
        $meta = get_post_meta($post->ID, $field['id'], true);
// begin a table row with  
        echo '<tr class="' . $field['id'] . '"> 
                <th><label for="' . esc_attr($field['id']) . '">' . esc_attr($field['label']) . '</label></th> 
                <td>';
        switch ($field['type']) {
// case items will go here  
// select  
            case 'select':
                echo '<select name="' . esc_attr($field['id']) . '" id="' . esc_attr($field['id']) . '">';
                foreach ($field['options'] as $option) {
                    echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="' . esc_attr($option['value']) . '">' . esc_html($option['label']) . '</option>';
                }
                echo '</select><br /><span class="description">' . esc_html($field['desc']) . '</span>';
                break;
        } //end switch  
        echo '</td></tr>';
    } // end foreach  
    echo '</table>'; // end table  
}

// Save the Data  
function cocobasic_save_page_custom_meta($post_id) {
    global $page_custom_meta_fields;
    $allowed_plugin_tags = cocobasic_allowed_plugin_html();
// verify nonce  
    if (isset($_POST['custom_meta_box_nonce'])) {
        if (!wp_verify_nonce($_POST['custom_meta_box_nonce'], basename(__FILE__))) {
            return $post_id;
        }
    }
// check autosave  
// Stop WP from clearing custom fields on autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;
// Prevent quick edit from clearing custom fields
    if (defined('DOING_AJAX') && DOING_AJAX)
        return;
	
	if ('page' !== get_post_type()) {
        return $post_id;
    }
	
// check permissions  
    if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id))
            return $post_id;
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }
// loop through fields and save the data  
    foreach ($page_custom_meta_fields as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        $new = null;
        if (isset($_POST[$field['id']])) {
            $new = $_POST[$field['id']];
        }
        if ($new && $new != $old) {
            $new = wp_kses($new, $allowed_plugin_tags);
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    } // end foreach  
}

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Add the Meta Box to 'Portfolio' posts"> 
function cocobasic_add_portfolio_custom_meta_box() {
    add_meta_box(
            'cocobasic_portfolio_custom_meta_box', // $id  
            esc_html__('Portfolio Preference', 'cocobasic-shortcode'), // $title   
            'cocobasic_show_portfolio_custom_meta_box', // $callback  
            'portfolio', // $page  
            'normal', // $context  
            'high'); // $priority     
}

// Field Array Post Page 
$prefix = 'portfolio_';
$portfolio_custom_meta_fields = array(
    array(
        'label' => esc_html__('Custom thumb title on mouse over', 'cocobasic-shortcode'),
        'desc' => esc_html__('by default is used item title', 'cocobasic-shortcode'),
        'id' => $prefix . 'hover_thumb_title',
        'type' => 'text'
    ),
    array(
        'label' => esc_html__('Thumb text on mouse over (second line)', 'cocobasic-shortcode'),
        'desc' => '',
        'id' => $prefix . 'hover_thumb_text',
        'type' => 'text'
    ),
    array(
        'label' => esc_html__('Thumb image size', 'cocobasic-shortcode'),
        'desc' => '',
        'id' => $prefix . 'thumb_image_size',
        'type' => 'select',
        'options' => array(
            'one' => array(
                'label' => '50%',
                'value' => 'p_one_half'
            ),
            'two' => array(
                'label' => '100%',
                'value' => 'p_one'
            )
        )
    ),
    array(
        'label' => esc_html__('Link thumb to', 'cocobasic-shortcode'),
        'desc' => '',
        'id' => $prefix . 'link_item_to',
        'type' => 'select',
        'options' => array(
            'one' => array(
                'label' => esc_html__('This post (ajax)', 'cocobasic-shortcode'),
                'value' => 'link_to_this_post'
            ),			
            'two' => array(
                'label' => esc_html__('Image', 'cocobasic-shortcode'),
                'value' => 'link_to_image_url'
            ),
            'three' => array(
                'label' => esc_html__('Video', 'cocobasic-shortcode'),
                'value' => 'link_to_video_url'
            ),
            'four' => array(
                'label' => esc_html__('External URL', 'cocobasic-shortcode'),
                'value' => 'link_to_extern_url'
            ),
            'five' => array(
                'label' => esc_html__('This post (regular)', 'cocobasic-shortcode'),
                'value' => 'link_to_this_post_regular'
            ),
        )
    ),
    array(
        'label' => esc_html__('Link thumb to Image:', 'cocobasic-shortcode'),
        'desc' => '',
        'id' => $prefix . 'image_popup',
        'type' => 'text'
    ),
    array(
        'label' => esc_html__('Link thumb to Video', 'cocobasic-shortcode'),
        'desc' => esc_html__('For example: http://vimeo.com/XXXXXX or http://www.youtube.com/watch?v=XXXXXX', 'cocobasic-shortcode'),
        'id' => $prefix . 'video_popup',
        'type' => 'text'
    ),
    array(
        'label' => esc_html__('Link thumb to External URL:', 'cocobasic-shortcode'),
        'desc' => esc_html__('Set URL to external site', 'cocobasic-shortcode'),
        'id' => $prefix . 'extern_site_url',
        'type' => 'text'
    )
);

// The Callback  
function cocobasic_show_portfolio_custom_meta_box() {
    global $portfolio_custom_meta_fields, $post;
    $allowed_plugin_tags = cocobasic_allowed_plugin_html();
// Use nonce for verification  
    echo '<input type="hidden" name="custom_meta_box_nonce" value="' . esc_attr(wp_create_nonce(basename(__FILE__))) . '" />';
// Begin the field table and loop  
    echo '<table class="form-table">';
    foreach ($portfolio_custom_meta_fields as $field) {
// get value of this field if it exists for this post  
        $meta = get_post_meta($post->ID, $field['id'], true);
// begin a table row with  
        echo '<tr> 
                <th><label for="' . esc_attr($field['id']) . '">' . esc_attr($field['label']) . '</label></th> 
                <td>';
        switch ($field['type']) {
// case items will go here  
// text  
            case 'text':

                if ($field['id'] == 'portfolio_image_popup') {
                    echo '<label for="upload_image">
				<input id="' . esc_attr($field['id']) . '" class="image-url-input" type="text" size="36" name="' . esc_attr($field['id']) . '" value="' . esc_attr($meta) . '" /> 
				<input id="upload_image_button" class="button" type="button" value="' . esc_attr__('Upload Image', 'cocobasic-shortcode') . '" />
                                <br /><span class="image-upload-desc">' . esc_html($field['desc']) . '</span>                                                                    
                                <span id="small-background-image-preview" class="has-background"></span>				
				</label>';
                } else {
                    echo '<input type="text" name="' . esc_attr($field['id']) . '" id="' . esc_attr($field['id']) . '" value="' . esc_attr($meta) . '" size="50" /> 
						<br /><span class="description">' . esc_html($field['desc']) . '</span>';
                }
                break;
// select  
            case 'select':
                echo '<select name="' . esc_attr($field['id']) . '" id="' . esc_attr($field['id']) . '">';
                foreach ($field['options'] as $option) {
                    echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="' . esc_attr($option['value']) . '">' . esc_html($option['label']) . '</option>';
                }
                echo '</select><br /><span class="description">' . esc_html($field['desc']) . '</span>';
                break;
// textarea  
            case 'textarea':
                echo '<textarea name="' . esc_attr($field['id']) . '" id="' . esc_attr($field['id']) . '" cols="60" rows="4">' . wp_kses($meta, $allowed_plugin_tags) . '</textarea> 
					<br /><span class="description">' . esc_html($field['desc']) . '</span>';
                break;
        } //end switch  
        echo '</td></tr>';
    } // end foreach  
    echo '</table>'; // end table  
}

// Save the Data  
function cocobasic_save_portfolio_custom_meta($post_id) {
    global $portfolio_custom_meta_fields;
    $allowed_plugin_tags = cocobasic_allowed_plugin_html();
// verify nonce  
    if (isset($_POST['custom_meta_box_nonce'])) {
        if (!wp_verify_nonce($_POST['custom_meta_box_nonce'], basename(__FILE__))) {
            return $post_id;
        }
    }
// check autosave  
// Stop WP from clearing custom fields on autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;
// Prevent quick edit from clearing custom fields
    if (defined('DOING_AJAX') && DOING_AJAX)
        return;
	
	if ('portfolio' !== get_post_type()) {
        return $post_id;
    }
	
// check permissions  
    if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id))
            return $post_id;
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }
// loop through fields and save the data  
    foreach ($portfolio_custom_meta_fields as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        $new = null;
        if (isset($_POST[$field['id']])) {
            $new = $_POST[$field['id']];
        }
        if ($new && $new != $old) {
            $new = wp_kses($new, $allowed_plugin_tags);
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    } // end foreach  
}

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Allowed HTML Tags">
function cocobasic_allowed_plugin_html() {
    $allowed_tags = array(
        'a' => array(
            'class' => array(),
            'href' => array(),
            'rel' => array(),
            'title' => array(),
            'target' => array(),
            'data-rel' => array(),
            'data-id' => array(),
        ),
        'abbr' => array(
            'title' => array(),
        ),
        'b' => array(),
        'blockquote' => array(
            'cite' => array(),
        ),
        'cite' => array(
            'title' => array(),
        ),
        'code' => array(),
        'del' => array(
            'datetime' => array(),
            'title' => array(),
        ),
        'dd' => array(),
        'div' => array(
            'id' => array(),
            'class' => array(),
            'title' => array(),
            'style' => array(),
        ),
        'br' => array(),
        'dl' => array(),
        'dt' => array(),
        'em' => array(),
        'h1' => array(),
        'h2' => array(),
        'h3' => array(),
        'h4' => array(),
        'h5' => array(),
        'h6' => array(),
        'i' => array(),
        'img' => array(
            'alt' => array(),
            'class' => array(),
            'height' => array(),
            'src' => array(),
            'width' => array(),
        ),
        'li' => array(
            'id' => array(),
            'class' => array(),
        ),
        'ol' => array(
            'class' => array(),
        ),
        'p' => array(
            'class' => array(),
        ),
        'q' => array(
            'cite' => array(),
            'title' => array(),
        ),
        'span' => array(
            'class' => array(),
            'title' => array(),
            'style' => array(),
        ),
        'strike' => array(),
        'strong' => array(),
        'ul' => array(
            'class' => array(),
        ),
        'iframe' => array(
            'class' => array(),
            'src' => array(),
            'allowfullscreen' => array(),
            'width' => array(),
            'height' => array(),
        )
    );

    return $allowed_tags;
}

//</editor-fold>
// <editor-fold defaultstate="collapsed" desc="Browser Body Class">
function cocobasic_browserBodyClass($classes) {
    global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;
    if ($is_lynx)
        $classes[] = 'lynx';
    elseif ($is_gecko)
        $classes[] = 'gecko';
    elseif ($is_opera)
        $classes[] = 'opera';
    elseif ($is_NS4)
        $classes[] = 'ns4';
    elseif ($is_safari)
        $classes[] = 'safari';
    elseif ($is_chrome)
        $classes[] = 'chrome';
    elseif ($is_IE) {
        $classes[] = 'ie';
        if (preg_match('/MSIE ([0-9]+)([a-zA-Z0-9.]+)/', $_SERVER['HTTP_USER_AGENT'], $browser_version))
            $classes[] = 'ie' . $browser_version[1];
    } else
        $classes[] = 'unknown';
    if ($is_iphone)
        $classes[] = 'iphone';
    if (stristr($_SERVER['HTTP_USER_AGENT'], "mac")) {
        $classes[] = 'osx';
    } elseif (stristr($_SERVER['HTTP_USER_AGENT'], "linux")) {
        $classes[] = 'linux';
    } elseif (stristr($_SERVER['HTTP_USER_AGENT'], "windows")) {
        $classes[] = 'windows';
    }
    return $classes;
}

// </editor-fold> 
?>