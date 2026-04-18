<?php
require('wp-load.php');

$xili_settings = get_option('xili_language_settings', array());
if (is_array($xili_settings)) {
    // Force the theme domain and ensure the languages folder is detected
    $xili_settings['theme_domain'] = 'mashaussure';
    $xili_settings['langs_folder'] = '/languages';
    $xili_settings['langs_in_root_theme'] = 'root';
    
    // Also ensure the domains array has woocommerce if not present
    if (!isset($xili_settings['domains']['woocommerce'])) {
        $xili_settings['domains']['woocommerce'] = 'enable';
    }
    
    update_option('xili_language_settings', $xili_settings);
    echo "Successfully forced Xili-Language theme_domain to 'mashaussure' and folder to '/languages'.\n";
    
    // Check if the file scan logic might be failing and try to trigger a refresh
    if (class_exists('xili_language')) {
        global $xili_language;
        if ($xili_language) {
            $xili_language->xili_settings = $xili_settings;
            echo "In-memory settings updated.\n";
        }
    }
} else {
    echo "Could not find xili settings in DB.\n";
}
