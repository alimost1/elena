<?php
/**
 * Plugin Name: Xili Debugger
 * Description: Debug Xili Language state at the end of init.
 */

add_action('wp_footer', function() {
    if (isset($_GET['debug_xili'])) {
        global $xili_language;
        echo '<div id="xili-debug" style="background:#fff; color:#000; padding:20px; border:5px solid red; position:fixed; bottom:0; left:0; z-index:9999; max-height:50vh; overflow:auto;">';
        echo '<h3>Xili Debug</h3>';
        if ($xili_language) {
            echo 'Domain: ' . $xili_language->thetextdomain . '<br>';
            echo 'LTD: ' . ($xili_language->ltd ? 'true' : 'false') . '<br>';
            echo 'Settings Theme Domain: ' . $xili_language->xili_settings['theme_domain'] . '<br>';
        } else {
            echo 'No instance found.';
        }
        echo '</div>';
    }
});
