<?php
$homeText = $settings['home_text'];
$homeTextParallax = $settings['home_text_parallax'];
$imgParallax = $settings['img_parallax'];
$img = $settings['img']['id'] ? wp_get_attachment_image($settings['img']['id'], '', '', ["class" => "main-photo", "data-jarallax-element"=> $imgParallax]) : '';
$animationImg = $settings['animation_img']['id'] ? wp_get_attachment_image($settings['animation_img']['id']) : '';
$url = $settings['url']['url'];
$ext = $settings['url']['is_external'];
$nofollow = $settings['url']['nofollow'];
$url = ( isset($url) && $url ) ? 'href=' . esc_url($url) . '' : '';
$ext = ( isset($ext) && $ext ) ? 'target= _blank' : '';
$nofollow = ( isset($url) && $url ) ? 'rel=nofollow' : '';
$link = $url . ' ' . $ext . ' ' . $nofollow;
$out='';
?>

<div class="home-section extra-width">
    <h1 class="entry-title global-color" data-jarallax-element="<?php echo $homeTextParallax; ?>">
        <?php echo $homeText; ?>
    </h1>

    <?php echo $img; ?>

    <?php
    if ($animationImg != ''):
        if ($url != ''):
            $out .= '<a ' . $link . ' class="main-btn slow-scroll">' . $animationImg . '</a>';
        else:
            $out .= $animationImg;
        endif;
    endif;

    echo $out;
    ?>        
</div>