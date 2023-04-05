<?php
global $post;
?>
<?php while (have_posts()) : the_post(); ?>    

    <article <?php post_class('blog-item-holder animate'); ?> >        
        <div class="entry-holder">

            <?php if (has_post_thumbnail($post->ID)): ?>        
                <div class="post-thumbnail extra-width">
                    <a href="<?php the_permalink($post->ID); ?>">
                        <?php echo get_the_post_thumbnail(); ?>
                    </a>
                </div>
            <?php endif; ?>

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

            <h2 class="entry-title">
                <a href="<?php the_permalink($post->ID); ?>">
                    <?php the_title(); ?>
                </a>
            </h2> 

        </div>      
    </article>   

<?php endwhile; ?>