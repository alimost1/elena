<?php
define('WP_USE_THEMES', false);
require('./wp-load.php');

echo "Locale: " . get_locale() . "\n";
if (function_exists('xili_language_get_current_language')) {
    echo "xili current language: " . xili_language_get_current_language() . "\n";
}

$locale = get_locale();
if ( strpos( $locale, 'fr' ) === 0 ) {
    echo "Should load French template.\n";
} else {
    echo "Should load English template.\n";
}

// Check if ?lang is set
if (isset($_GET['lang'])) {
    echo "Query param lang: " . $_GET['lang'] . "\n";
}
