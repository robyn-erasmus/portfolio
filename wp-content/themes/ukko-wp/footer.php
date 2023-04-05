<footer class="footer center-relative">
    <div class="footer-content content-800">
        <div class="content-670">
            <?php get_sidebar(); ?>
            <?php
            if (get_theme_mod('cocobasic_select_footer') != '') :
                cocobasic_show_elementor_library_content(get_theme_mod('cocobasic_select_footer'));
            endif;
            ?>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>