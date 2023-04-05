<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>        
        <meta charset="<?php bloginfo('charset'); ?>" />        
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />        		
        <?php wp_head(); ?>        
    </head>    
    <body <?php body_class(); ?>>
	<?php wp_body_open(); ?>

        <div class="doc-loader">
            <?php if ((get_option('cocobasic_preloader') !== '') && (get_option('cocobasic_preloader') !== false)): ?>                
                <img src="<?php echo esc_url(get_option('cocobasic_preloader', get_template_directory_uri() . '/images/preloader.gif')); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" />
            <?php endif; ?>
        </div>  

        <div class="toggle-holder">
            <div id="toggle">
                <div class="menu-line"></div>
            </div>

            <?php if (get_theme_mod('cocobasic_show_section_num') === 'yes'): ?>                
                <div class="top-pagination mobile">
                    <div class="current-num">
                        <span>01</span>                                    
                    </div>
                    <div class="pagination-div">/</div>
                    <div class="total-pages-num"></div>
                </div>
            <?php endif; ?>

        </div>

        <div class="header-holder">                        
            <div class="header-wrapper">                     
                <header>
                    <?php if (get_theme_mod('cocobasic_show_section_num') === 'yes'): ?>                
                        <div class="top-pagination">
                            <div class="current-num">
                                <span>01</span>                                    
                            </div>
                            <div class="pagination-div">/</div>
                            <div class="total-pages-num"></div>
                        </div>
                    <?php endif; ?>

                    <?php if ((get_theme_mod('cocobasic_custom_sitetitle') !== '') && (get_theme_mod('cocobasic_custom_sitetitle') !== false)): ?>                
                        <div class="site-title"><?php echo esc_html(get_theme_mod('cocobasic_custom_sitetitle')); ?></div>                 
                    <?php else: ?>
                        <div class="site-title"><?php echo esc_html(get_bloginfo('name')); ?></div>                 
                    <?php endif; ?>

                    <div class="menu-holder">               
                        <div class="menu-wrapper relative">
                            <?php
                            if (has_nav_menu("custom_menu")) {
                                wp_nav_menu(
                                        array(
                                            "container" => "nav",
                                            "container_class" => "big-menu",
                                            "container_id" => "header-main-menu",
                                            "fallback_cb" => false,
                                            "menu_class" => "main-menu sm sm-clean",
                                            "theme_location" => "custom_menu",
                                            "items_wrap" => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                                            "walker" => new Cocobasic_Header_Menu()
                                        )
                                );
                            } else {
                                echo '<nav id="header-main-menu" class="big-menu default-menu"><ul>';
                                wp_list_pages(array("depth" => "3", 'title_li' => ''));
                                echo '</ul>';
                                echo '</nav>';
                            }
                            ?>       

                            <?php
                            $allowed_html_array = cocobasic_allowed_html();
                            if (get_theme_mod('cocobasic_menu_text') != ''):
                                echo '<div class="menu-social">';
                                echo do_shortcode(wp_kses(__(get_theme_mod('cocobasic_menu_text') ? get_theme_mod('cocobasic_menu_text') : 'Default Social Text', 'ukko-wp'), $allowed_html_array));
                                echo '</div>';
                            endif;
                            ?>  

                        </div>
                    </div>      
                </header>
            </div>                    
        </div>                    