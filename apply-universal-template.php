<?php
define('WP_USE_THEMES', false);
require_once('wp-load.php');

$english_id = 2;
$french_id = 64;
// We now use the standard front-page.php but as a selectable template named 'front-page.php' 
// Actually since it's the file name of a specialized template, we just use 'default' 
// OR if it has a Template Name, we use the filename.
$template_file = 'front-page.php';

update_post_meta($english_id, '_wp_page_template', $template_file);
update_post_meta($french_id, '_wp_page_template', $template_file);

echo "Template '$template_file' applied to both English (ID $english_id) and French (ID $french_id) pages.\n";
echo "English Template: " . get_post_meta($english_id, '_wp_page_template', true) . "\n";
echo "French Template: " . get_post_meta($french_id, '_wp_page_template', true) . "\n";
?>
