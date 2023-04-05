<?php get_header(); ?>

<div id="content" class="site-content center-relative">      
    <div <?php post_class('content-holder content-800'); ?> >   
        <div class="content-670">  
            <?php
            if (have_posts()) :
                while (have_posts()) : the_post();
                    if (get_post_meta($post->ID, "page_show_title", true) !== 'no'):
                        the_title('<h1 class="entry-title page-title">', '</h1>');
                    endif;

                    the_content();

                    echo '<div class="clear"></div>';

                    $defaults = array(
                        'before' => '<p class="clear"></p><p class="wp-link-pages top-50">' . esc_html__('Pages:', 'ukko-wp'),
                        'after' => '</p>',
                        'link_before' => '<span class="page-link-number">',
                        'link_after' => '</span>'
                    );
                    wp_link_pages($defaults);


                    comments_template();
                endwhile;
            endif;
            ?>    
            <div class="clear"></div>
        </div>    
    </div>    
</div>


<?php get_footer(); ?>