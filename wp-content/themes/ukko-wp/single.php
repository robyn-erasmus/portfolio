<?php
get_header();
?>

<div id="content" class="site-content center-relative">
    <div <?php post_class('content-holder content-800'); ?> >      
        <div class="content-670">      
            <?php
            if (have_posts()) :
                while (have_posts()) : the_post();
                    ?>		

                    <article <?php post_class(); ?>>            
                        <div class="post-wrapper center-relative">                                                        
                            <div class="single-content-wrapper content-1170 center-relative">     
                                <h1 class="entry-title"><?php the_title(); ?></h1>   

                                <div>
                                    <ul class="entry-info">                
                                        <li class="author-nickname-holder">                                                            
                                            <div class="author-nickname">
                                                <?php the_author_posts_link(); ?>
                                            </div>                                                             
                                        </li>                                    
                                        <li class="entry-date-holder">                                                                                
                                            <div class="entry-date published">
                                                <?php echo get_the_date(); ?>   
                                            </div>                                                             
                                        </li>  
                                        <li class="cat-links-holder">                                                                                     
                                            <div class="cat-links-wrapper">
                                                <ul class="cat-links">
                                                    <?php
                                                    foreach ((get_the_category()) as $category) {
                                                        echo '<li><a class="global-color" href="' . get_category_link($category->term_id) . '">' . $category->name . '</a></li>';
                                                    }
                                                    ?>
                                                </ul>
                                            </div>                                                             
                                        </li>                                         
                                    </ul>    
                                </div>

                                <?php
                                if (has_post_thumbnail()):
                                    echo '<div class="extra-width">';
                                    the_post_thumbnail();

                                    if (get_post(get_post_thumbnail_id())->post_content != ''):
                                        echo '<p class="img-caption">' . get_post(get_post_thumbnail_id())->post_content . '</p>';
                                    endif;

                                    echo '</div>';
                                endif;
                                ?>

                                <div class="single-content-wrapper content-960 center-relative">

                                    <div class="entry-content"> 

                                        <?php
                                        the_content();
                                        ?>
                                        <div class="clear"></div>

                                        <?php
                                        $defaults = array(
                                            'before' => '<p class="wp-link-pages top-50">' . esc_html__('Pages:', 'ukko-wp'),
                                            'after' => '</p>',
                                            'link_before' => '<span class="page-link-number">',
                                            'link_after' => '</span>'
                                        );
                                        wp_link_pages($defaults);

                                        if (has_tag()):
                                            ?>	
                                            <div class="tags-holder">
                                                <?php the_tags('', ''); ?>
                                            </div>                              
                                            <?php
                                        endif;
                                        ?>                          
                                    </div>
                                    <div class="clear"></div>
                                </div>                                       
                            </div>                                       
                        </div>                
                    </article> 

                    <div class="nav-links content-750 center-relative">                
                        <?php
                        $prev_post = get_previous_post();
                        if (is_a($prev_post, 'WP_Post')):
                            ?>
                            <div class="nav-previous">                        
                                <p><?php echo esc_html__('PREVIOUS STORY', 'ukko-wp'); ?></p>                        
                                <?php previous_post_link('%link'); ?>                         
                                <div class="clear"></div>
                            </div>
                        <?php endif; ?>
                        <?php
                        $next_post = get_next_post();
                        if (is_a($next_post, 'WP_Post')):
                            ?>                
                            <div class="nav-next">
                                <p><?php echo esc_html__('NEXT STORY', 'ukko-wp'); ?></p>                        
                                <?php next_post_link('%link'); ?>                     
                                <div class="clear"></div>
                            </div>
                        <?php endif; ?>
                        <div class="clear"></div>
                    </div> 

                    <?php
                    comments_template();
                endwhile;
            endif;
            ?>    
            <div class="clear"></div>
        </div>
    </div>
</div>

<?php get_footer(); ?>  