<?php
define('WP_USE_THEMES', false);
require_once('wp-load.php');

$front_page_id = get_option('page_on_front');
if (!$front_page_id) {
    echo "No static front page set.\n";
    // Check for latest posts or just get a random page
    $pages = get_pages(array('number' => 1));
    if ($pages) {
        $front_page_id = $pages[0]->ID;
        echo "Using first page found: ID $front_page_id\n";
    } else {
        echo "No pages found.\n";
        exit;
    }
} else {
    echo "Front page ID: $front_page_id\n";
}

$post = get_post($front_page_id);
echo "Title: " . $post->post_title . "\n";
echo "Content: " . $post->post_content . "\n";
?>
