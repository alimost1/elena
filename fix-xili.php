<?php
require('wp-load.php');
$xili_settings = get_option('xili_language_settings', array());
if (is_array($xili_settings)) {
    $xili_settings['theme_domain'] = 'mashaussure';
    update_option('xili_language_settings', $xili_settings);
    echo "Successfully forced Xili-Language theme_domain to 'mashaussure'.";
} else {
    echo "Could not find xili settings in DB.";
}
