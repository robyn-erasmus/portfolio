<?php

$num = $settings['num'] ? $settings['num'] : '5';


global $post;
$args = array('post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => $num);
$loop = new WP_Query($args);

$return = '<ul class="home-blog-list">';
if ($loop->have_posts()) :
    while ($loop->have_posts()) : $loop->the_post();
        $catList = '';

        foreach ((get_the_category()) as $category) {
            $catList.= '<li><a class="global-color" href="' . get_category_link($category->term_id) . '">' . $category->name . '</a></li>';
        }

        $return .= '<li><h4 class="entry-title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></h4><div class="blog-list-info"><div class="entry-date published">' . get_the_date() . '</div><div class="cat-links-wrapper"><ul class="cat-links global-color">'.$catList.'</ul></div></div></li>';

    endwhile;

    $return .= '</ul>';
endif;
wp_reset_postdata();
echo $return;
?>                                                