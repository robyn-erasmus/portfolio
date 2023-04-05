<?php get_header(); ?>
<div id="content" class="site-content center-relative">      
    <div <?php post_class('content-holder content-800'); ?> >   
        <div class="content-670">       
            <?php
				require ('ajax-single-portfolio.php');
            ?>
            <div class="clear"></div>
        </div>
    </div>
</div>
<?php get_footer(); ?>