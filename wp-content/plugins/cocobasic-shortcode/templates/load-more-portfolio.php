<?php

global $post;
$allowed_html_array = cocobasic_allowed_plugin_html();
$return='';
if (isset($_POST["action"]) && ($_POST["action"] === 'portfolio_ajax_load_more')):
    if ($portfolio_load_more_query->have_posts()) :
        while ($portfolio_load_more_query->have_posts()) : $portfolio_load_more_query->the_post();

            if (has_post_thumbnail($post->ID)) {
                $portfolio_post_thumb = get_the_post_thumbnail();
            } else {
                $portfolio_post_thumb = '<img src = "' . PM_PLUGIN_URL . 'assets/images/no-photo.png" alt = "" />';
            }

            $p_thumb_text = get_post_meta($post->ID, "portfolio_hover_thumb_text", true);
            $p_size = get_post_meta($post->ID, "portfolio_thumb_image_size", true);

            if (get_post_meta($post->ID, "portfolio_hover_thumb_title", true) != ''):
                $p_thumb_title = get_post_meta($post->ID, "portfolio_hover_thumb_title", true);
            else:
                $p_thumb_title = get_the_title();
            endif;

            $link_thumb_to = get_post_meta($post->ID, "portfolio_link_item_to", true);

            switch ($link_thumb_to):
				case 'link_to_this_post_regular':                                        
					$return .= '<div class="grid-item element-item ' . $p_size . '"><a class="item-link" href="' . get_permalink() . '">';
                    break;			
                case 'link_to_image_url':
                    $image_popup = get_post_meta($post->ID, "portfolio_image_popup", true);
                    $return .= '<div class="grid-item element-item ' . $p_size . '"><a class="item-link" href="' . $image_popup . '" data-rel="prettyPhoto[portfolio1]">';
                    break;
                case 'link_to_video_url':
                    $video_popup = get_post_meta($post->ID, "portfolio_video_popup", true);
                    $return .= '<div class="grid-item element-item ' . $p_size . '"><a class="item-link" href="' . $video_popup . '" data-rel="prettyPhoto[portfolio1]">';
                    break;
                case 'link_to_extern_url':
                    $extern_site_url = get_post_meta($post->ID, "portfolio_extern_site_url", true);
                    $return .= '<div class="grid-item element-item ' . $p_size . '"><a class="item-link" href="' . $extern_site_url . '" target="_blank">';
                    break;

                default:
                    $return .= '<div id="p-item-' . $post->ID . '" class="grid-item element-item ' . $p_size . '"><a class="item-link ajax-portfolio" href="' . get_permalink() . '" data-id="' . $post->ID . '">';
            endswitch;

            $return .= $portfolio_post_thumb . '<div class="portfolio-text-holder"><div class="portfolio-text-wrapper"><p class="portfolio-text">' . $p_thumb_title . '</p><p class="portfolio-cat">' . $p_thumb_text . '</p></div></div></a></div>';

        endwhile;
    endif;
    echo wp_kses($return, $allowed_html_array);
endif;
?>