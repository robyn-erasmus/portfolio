<?php

$url = $settings['url']['url'] ? 'href=' . esc_url($settings['url']['url']) . '' : '';
$ext = $settings['url']['is_external'] ? 'target= _blank' : '';
$nofollow = $settings['url']['nofollow'] ? 'rel=nofollow' : '';
$link = $url . ' ' . $ext . ' ' . $nofollow;
$btn = $settings['title'] ? '<a class="service-link slow-scroll" ' . $link . '>' . $settings['title'] . '</a>' : '';

echo $btn;

