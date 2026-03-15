<?php
define('WP_USE_THEMES', false);
require_once('wp-load.php');

$french_id = 64;
$template_file = 'template-front-page-fr.php';

update_post_meta($french_id, '_wp_page_template', $template_file);

echo "Template '$template_file' applied to French page ID $french_id\n";

// Double check the result
echo "Current template: " . get_post_meta($french_id, '_wp_page_template', true) . "\n";
?>
