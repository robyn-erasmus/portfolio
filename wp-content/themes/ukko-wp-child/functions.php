<?php


function ukko_wp_child_enqueue_styles() {  
    wp_enqueue_style( 'ukko-main-theme-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'ukko-child-main-theme-style',get_stylesheet_directory_uri() . '/style.css' );
}

add_action( 'wp_enqueue_scripts', 'ukko_wp_child_enqueue_styles', 11);

function ukko_child_lang_setup() {
    load_child_theme_textdomain( 'ukko-wp', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'ukko_child_lang_setup' );

?>