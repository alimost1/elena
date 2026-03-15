<?php
define('WP_USE_THEMES', false);
require_once('wp-load.php');

if (!function_exists('wp_insert_term')) {
    echo "WP not loaded correctly.\n";
    exit;
}

$slug = 'fr_FR';
$name = 'Français';
$description = 'Français';
$taxonomy = 'language';

$term = get_term_by('slug', $slug, $taxonomy);

if (!$term) {
    echo "Inserting term $slug...\n";
    $result = wp_insert_term($name, $taxonomy, array(
        'slug' => $slug,
        'description' => $name
    ));
    if (is_wp_error($result)) {
        echo "Error inserting term: " . $result->get_error_message() . "\n";
        exit;
    }
    $term_id = $result['term_id'];
} else {
    echo "Term $slug already exists.\n";
    $term_id = $term->term_id;
}

// Add to xili group if needed
$group_taxonomy = 'languages_group';
$group_name = 'the-langs-group';
$group_term = get_term_by('slug', $group_name, $group_taxonomy);

if ($group_term) {
    wp_set_object_terms($term_id, $group_name, $group_taxonomy, true);
    echo "Added to $group_name.\n";
}

// Update settings
$settings = get_option('xili_language_settings');
if ($settings) {
    if (!isset($settings['available_langs'])) {
        $settings['available_langs'] = array();
    }
    
    if (!in_array($term_id, $settings['available_langs'])) {
        $settings['available_langs'][] = (string)$term_id;
        echo "Added to available_langs.\n";
    }
    
    if (!isset($settings['lang_features'][$slug])) {
        $settings['lang_features'][$slug] = array('charset' => '', 'hidden' => '');
        echo "Added to lang_features.\n";
    }
    
    update_option('xili_language_settings', $settings);
    echo "Settings updated successfully.\n";
    echo "New settings: " . print_r($settings, true) . "\n";
} else {
    echo "xili_language_settings not found in database.\n";
}
?>
