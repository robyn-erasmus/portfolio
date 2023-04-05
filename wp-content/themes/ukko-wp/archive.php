<?php get_header(); ?>
<div id="content" class="site-content center-relative">
    <div <?php post_class('content-holder content-800'); ?> >      
        <div class="content-670">      

            <div class="archive-title">
                <h1 class="entry-title"><?php echo esc_html(cocobasic_archive_title($title)); ?></h1>
            </div>

            <div class="blog-holder">          
                <?php
                if (have_posts()) :
                    while (have_posts()) : the_post();
                        ?>

                        <article <?php post_class('blog-item-holder animate'); ?> >        
                            <div class="entry-holder">
                                <h2 class="entry-title">
                                    <a href="<?php the_permalink($post->ID); ?>">
                                        <?php the_title(); ?>
                                    </a>
                                </h2>                                   
                            </div>      
                        </article>    

                        <?php
                    endwhile;
                    the_posts_pagination();
                else:
                    echo '<h2>' . esc_html__("No results", 'ukko-wp') . '</h2>';
                endif;
                ?>

            </div>    
        </div>
    </div>
</div>


<?php get_footer(); ?>