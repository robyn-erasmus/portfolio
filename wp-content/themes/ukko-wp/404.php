<?php get_header(); ?> 
<div id="content" class="site-content center-relative">
    <div <?php post_class('content-holder content-800'); ?> >      
        <div class="content-670">      
            <p class="center-text error-text-help-first"><strong><?php echo esc_html__('Ooops!', 'ukko-wp'); ?></strong></p>            
            <p class="center-text error-text-help-second"><?php echo esc_html__('The page you were looking for could not be found.', 'ukko-wp'); ?></p>
            <p class="center-text error-text-404 global-color"><?php echo esc_html__('404', 'ukko-wp'); ?></p>        
            <p class="center-text error-text-home"><?php echo esc_html__('Try to start from', 'ukko-wp'); ?> <a class="global-color" href="<?php echo esc_url(home_url('/')); ?>"><?php echo esc_html__('Home', 'ukko-wp'); ?></a> <?php echo esc_html__('page.', 'ukko-wp'); ?></p>            
        </div>
    </div>
</div>
<?php get_footer(); ?>