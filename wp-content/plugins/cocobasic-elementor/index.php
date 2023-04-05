<?php

/**
 * Plugin Name: CocoBasic - Ukko Elementor Widgets 
 * Description: Custom Elementor Widgets used in Ukko WordPress Theme.
 * Version: 1.4
 * Author: CocoBasic
 * Author URI: https://www.cocobasic.com
 * Text Domain: cocobasic-elementor
 */

namespace CocoBasicElements;

if (!defined('ABSPATH'))
    exit;

if (!class_exists('CocoBasicLandingAddons')) :

    final class CocoBasicLandingAddons {

        private static $instance;

        public static function instance() {

            load_plugin_textdomain('cocobasic-elementor', false, dirname(plugin_basename(__FILE__)) . '/languages/');

            if (!isset(self::$instance) && !(self::$instance instanceof CocoBasicLandingAddons)) {

                self::$instance = new CocoBasicLandingAddons;

                self::$instance->setup_constants();

                self::$instance->hooks();
            }
            return self::$instance;
        }

        private function setup_constants() {

            // Plugin Folder Path
            if (!defined('PM_PLUGIN_DIR')) {
                define('PM_PLUGIN_DIR', plugin_dir_path(__FILE__));
            }

            // Plugin Folder URL
            if (!defined('PM_PLUGIN_URL')) {
                define('PM_PLUGIN_URL', plugin_dir_url(__FILE__));
            }

            // Plugin Folder Path
            if (!defined('PM_ADDONS_DIR')) {
                define('PM_ADDONS_DIR', plugin_dir_path(__FILE__) . 'widgets/');
            }
        }

        private function hooks() {
            add_action('elementor/widgets/widgets_registered', array(self::$instance, 'include_widgets'));
            add_action('elementor/init', array($this, 'add_elementor_category'));
            add_action('elementor/preview/enqueue_styles', array($this, 'cocobasic_backend_preview_scripts'), 10);
            add_action('elementor/frontend/after_register_scripts', array($this, 'cocobasic_frontend_enqueue_script'));
        }

        public function cocobasic_backend_preview_scripts() {
            wp_enqueue_script('cocobasic-elementor-preview-main', PM_PLUGIN_URL . 'assets/js/main-backend.js', '', '', true);
            wp_enqueue_script('istope.pkgd', PM_PLUGIN_URL . 'assets/js/isotope.pkgd.js', '', '', true);
        }

        public function cocobasic_frontend_enqueue_script() {
            wp_enqueue_style('prettyPhoto', PM_PLUGIN_URL . 'assets/css/prettyPhoto.css');
            wp_enqueue_style('owl.theme.default', PM_PLUGIN_URL . 'assets/css/owl.theme.default.min.css');
            wp_enqueue_style('owl.carousel', PM_PLUGIN_URL . 'assets/css/owl.carousel.min.css');
            wp_enqueue_style('cocobasic-elementor-main-style', PM_PLUGIN_URL . 'assets/css/style.css');

            wp_enqueue_script('imagesloaded');
            wp_enqueue_script('jquery-prettyPhoto', PM_PLUGIN_URL . 'assets/js/jquery.prettyPhoto.js', '', '', true);
            wp_enqueue_script('owl.carousel', PM_PLUGIN_URL . 'assets/js/owl.carousel.min.js', '', '', true);
            wp_enqueue_script('jarallax', PM_PLUGIN_URL . 'assets/js/jarallax.js', '', '', true);
            wp_enqueue_script('jarallax-element', PM_PLUGIN_URL . 'assets/js/jarallax-element.min.js', '', '', true);
            wp_enqueue_script('istope.pkgd', PM_PLUGIN_URL . 'assets/js/isotope.pkgd.js', '', '', true);
            wp_enqueue_script('cocobasic-elementor-main-js', PM_PLUGIN_URL . 'assets/js/main.js', '', '', true);

            wp_localize_script('cocobasic-elementor-main-js', 'ajax_var_portfolio_content', array(
                'url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('ajax-cocobasic-portfolio-content')
            ));

            //Infinite Loading JS variables for portfolio
            $portfolio_count_posts = wp_count_posts('portfolio');
            $portfolio_count_posts = $portfolio_count_posts->publish;

            wp_localize_script('cocobasic-elementor-main-js', 'ajax_var_portfolio', array(
                'url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('ajax-cocobasic-portfolio-load-more'),
                'total' => $portfolio_count_posts
            ));
        }

        public function add_elementor_category() {
            \Elementor\Plugin::instance()->elements_manager->add_category(
                    'coco-element', array(
                'title' => esc_attr__('CocoBasic', 'cocobasic-elementor'),
                'icon' => 'fa fa-th',
                    ), 1);
        }

        public function include_widgets($widgets_manager) {
            require_once PM_ADDONS_DIR . 'home-section/index.php';
            require_once PM_ADDONS_DIR . 'portfolio/index.php';
            require_once PM_ADDONS_DIR . 'home-blog/index.php';
            require_once PM_ADDONS_DIR . 'imageslider/index.php';
            require_once PM_ADDONS_DIR . 'timeline/index.php';
            require_once PM_ADDONS_DIR . 'skills-lines/index.php';
            require_once PM_ADDONS_DIR . 'button/index.php';
        }

    }

    endif;

function RunCocoBasicElements() {
    return CocoBasicLandingAddons::instance();
}

RunCocoBasicElements();
?>