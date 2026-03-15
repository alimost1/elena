<?php
define('WP_USE_THEMES', false);
require_once('wp-load.php');

$front_page_id = get_option('page_on_front');
echo "FRONT_PAGE_ID: $front_page_id\n";

$pages = get_posts(array('post_type' => 'page', 'numberposts' => -1));
foreach ($pages as $p) {
    $template = get_post_meta($p->ID, '_wp_page_template', true);
    $xili_fr = get_post_meta($p->ID, 'lang-fr_FR', true);
    $xili_en = get_post_meta($p->ID, 'lang-en_US', true);
    echo "PAGE ID: {$p->ID} | Title: {$p->post_title} | Slug: {$p->post_name} | Template: $template | FR_LINK: $xili_fr | EN_LINK: $xili_en\n";
}
?>
