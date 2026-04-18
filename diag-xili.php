<?php
require('wp-load.php');

echo "--- Xili-Language Diagnostic ---\n";

$xili_settings = get_option('xili_language_settings', array());
echo "Settings in DB:\n";
print_r($xili_settings);

if (class_exists('xili_language')) {
    global $xili_language;
    if ($xili_language) {
        echo "\nGlobal Instance properties:\n";
        echo "thetextdomain: " . $xili_language->thetextdomain . "\n";
        echo "ltd: " . ($xili_language->ltd ? 'true' : 'false') . "\n";
        echo "get_template_directory: " . $xili_language->get_template_directory . "\n";
    } else {
        echo "\nGlobal instance not found.\n";
    }
} else {
    echo "\nClass xili_language not found.\n";
}

echo "\nActive Theme:\n";
echo get_stylesheet() . "\n";

echo "\nChecking mashaussure/functions.php presence:\n";
$path = get_theme_root() . '/mashaussure/functions.php';
if (file_exists($path)) {
    echo "Found at: $path\n";
    $content = file_get_contents($path);
    if (strpos($content, 'load_theme_textdomain') !== false) {
        echo "String 'load_theme_textdomain' found in file.\n";
    } else {
        echo "String 'load_theme_textdomain' NOT found in file.\n";
    }
} else {
    echo "Mashaussure functions.php NOT found at $path\n";
}
