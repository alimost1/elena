<?php
require_once( dirname(__FILE__) . '/wp-load.php' );

$args = array(
    'post_type' => 'elementor_library',
    'posts_per_page' => -1,
);
$templates = get_posts($args);

echo "Elementor Templates:\n";
foreach ($templates as $template) {
    $type = get_post_meta($template->ID, '_elementor_template_type', true);
    $conditions = get_post_meta($template->ID, '_elementor_conditions', true);
    
    echo "- " . $template->post_title . " (Type: " . $type . ")\n";
    if ($conditions) {
        echo "  Conditions: " . print_r($conditions, true) . "\n";
    }
}
