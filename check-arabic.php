<?php
require_once('wp-load.php');
$slug = 'ar';
$taxonomy = 'language';
$term = get_term_by('slug', $slug, $taxonomy);
if ($term) {
    echo "Arabic term exists: " . $term->name . " (ID: " . $term->term_id . ")\n";
} else {
    echo "Arabic term does not exist.\n";
}

$settings = get_option('xili_language_settings');
if ($settings) {
    echo "Xili settings found.\n";
    if (isset($settings['available_langs'])) {
        echo "Available langs: " . implode(', ', $settings['available_langs']) . "\n";
    }
}
?>
