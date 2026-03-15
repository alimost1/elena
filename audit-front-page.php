<?php
define('WP_USE_THEMES', false);
require_once('wp-load.php');

$front_page_id = get_option('page_on_front');
$show_on_front = get_option('show_on_front');

echo "Show on front: $show_on_front\n";
echo "Front page ID: $front_page_id\n";

if ($front_page_id) {
    $post = get_post($front_page_id);
    echo "Front page title: " . $post->post_title . "\n";
    
    // Check xili-language links for this page
    $quetag = 'lang-'; // common xili tag
    $meta = get_post_meta($front_page_id);
    echo "Front page meta:\n";
    foreach ($meta as $key => $values) {
        if (strpos($key, $quetag) === 0) {
            echo "  $key: " . implode(', ', $values) . "\n";
        }
    }
    
    // Check if the French page is recognized as a translation of the front page
    $french_id = get_post_meta($front_page_id, 'lang-fr_FR', true);
    if ($french_id) {
        $fr_post = get_post($french_id);
        echo "Linked French page ID: $french_id, Title: " . $fr_post->post_title . "\n";
    }
}

// Check what template is being used for the French page
// (This is harder to check from here, but we can verify the post type)
$french_slug = 'page-dexemple';
$fr_page = get_page_by_path($french_slug);
if ($fr_page) {
    echo "Found French page ID: " . $fr_page->ID . "\n";
    echo "Post type: " . $fr_page->post_type . "\n";
    echo "Post status: " . $fr_page->post_status . "\n";
    echo "Post template: " . get_post_meta($fr_page->ID, '_wp_page_template', true) . "\n";
} else {
    echo "French page NOT found by slug '$french_slug'\n";
}

$all_pages = get_pages();
echo "Total pages: " . count($all_pages) . "\n";
foreach($all_pages as $p) {
    echo "Page: ID=" . $p->ID . ", Title='" . $p->post_title . "', Slug='" . $p->post_name . "'\n";
}
?>
