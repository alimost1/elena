<?php
// No wp-load.php yet to avoid hanging.

$languages_dir = __DIR__ . '/wp-content/languages';
$plugins_dir = $languages_dir . '/plugins';

if (!is_dir($languages_dir)) {
    mkdir($languages_dir, 0755, true);
}
if (!is_dir($plugins_dir)) {
    mkdir($plugins_dir, 0755, true);
}

$files_to_download = [
    'https://translate.wordpress.org/projects/wp/dev/ar/default/export-translations/?format=mo' => $languages_dir . '/ar.mo',
    'https://translate.wordpress.org/projects/wp/dev/admin/ar/default/export-translations/?format=mo' => $languages_dir . '/admin-ar.mo',
    'https://translate.wordpress.org/projects/wp-plugins/woocommerce/stable/ar/default/export-translations/?format=mo' => $plugins_dir . '/woocommerce-ar.mo'
];

foreach ($files_to_download as $url => $path) {
    echo "Downloading $url to $path...\n";
    $content = @file_get_contents($url);
    if ($content !== false) {
        file_put_contents($path, $content);
        echo "Success.\n";
    } else {
        echo "Failed to download $url\n";
    }
}

// Now try to run setup-arabic.php functionality via wp-load.php
// I'll do this in a separate script or just at the end.
echo "Registration part...\n";
?>
<?php
// Separate block to isolate wp-load.php issues
require_once('wp-load.php');
// (Optional: define('WP_HTTP_BLOCK_EXTERNAL', true); if it hangs)

$slug = 'ar';
$name = 'العربية';
$taxonomy = 'language';

$term = get_term_by('slug', $slug, $taxonomy);
if (!$term) {
    echo "Inserting term $slug...\n";
    wp_insert_term($name, $taxonomy, array('slug' => $slug));
} else {
    echo "Term $slug already exists.\n";
}

// Update xili settings if plugin is active
$settings = get_option('xili_language_settings');
if ($settings) {
    $term = get_term_by('slug', $slug, $taxonomy);
    if ($term) {
        if (!in_array($term->term_id, $settings['available_langs'])) {
            $settings['available_langs'][] = (string)$term->term_id;
        }
        if (!isset($settings['lang_features'][$slug])) {
            $settings['lang_features'][$slug] = array('charset' => 'UTF-8', 'hidden' => '');
        }
        update_option('xili_language_settings', $settings);
        echo "Xili settings updated.\n";
    }
}

// Set site language to Arabic
update_option('WPLANG', 'ar');
echo "WPLANG updated to ar.\n";
?>
