<?php
define('WP_USE_THEMES', false);
require_once('wp-load.php');

$english_id = 2;
$french_id = 64;

// 1. Ensure English points to French
update_post_meta($english_id, 'lang-fr_FR', $french_id);

// 2. Ensure French points to English
update_post_meta($french_id, 'lang-en_US', $english_id);

// 3. Optional: Set a specific template if the theme doesn't automatically use front-page.php for translations
// But usually front-page.php is for page_on_front. 
// If xili-language doesn't swap page_on_front, we might need a custom template or more xili config.

echo "Mappings updated for $english_id <-> $french_id\n";

// Check the languages assigned to these posts
$taxonomy = 'language';
$en_lang = wp_get_object_terms($english_id, $taxonomy);
$fr_lang = wp_get_object_terms($french_id, $taxonomy);

echo "English Page Language: " . ($en_lang ? $en_lang[0]->slug : 'None') . "\n";
echo "French Page Language: " . ($fr_lang ? $fr_lang[0]->slug : 'None') . "\n";

// If French page doesn't have fr_FR language assigned, assign it
if (!$fr_lang || $fr_lang[0]->slug != 'fr_FR') {
    wp_set_object_terms($french_id, 'fr_FR', $taxonomy);
    echo "Assigned fr_FR language to ID $french_id\n";
}

// If English page doesn't have en_US language assigned, assign it
if (!$en_lang || $en_lang[0]->slug != 'en_US') {
    wp_set_object_terms($english_id, 'en_US', $taxonomy);
    echo "Assigned en_US language to ID $english_id\n";
}

?>
