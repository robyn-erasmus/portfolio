<?php get_header(); ?>
<div id="content" class="site-content center-relative">
    <div <?php post_class('content-holder content-800'); ?> >      
        <div class="content-670">      
            <?php
            global $post;

            $page = (get_query_var('paged')) ? get_query_var('paged') : 1;
            query_posts('post_type=post&paged=' . $page);

            if (have_posts()) :
                echo '<div class="blog-holder animate">';
                require get_parent_theme_file_path('loop-index.php');
                echo '</div>';
            endif;
            ?>       

            <div class="block more-posts-index-holder">
                <div class="more-posts-index-wrapper">
                    <span class="more-posts">
                        <?php echo esc_html__('LOAD MORE', 'ukko-wp'); ?>
                    </span>
                    <span class="more-posts-loading">
                        <?php echo esc_html__('LOADING', 'ukko-wp'); ?>
                    </span>
                    <span class="no-more-posts">
                        <?php echo esc_html__('NO MORE', 'ukko-wp') ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>