<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    require_once( dirname(__FILE__) . '/wp-load.php' );
    switch_theme( 'mashaussure' );
    echo "Theme switched to mashaussure successfully.\n";
} catch (\Throwable $e) {
    echo "Fatal Error: " . $e->getMessage() . " in " . $e->getFile() . " on line " . $e->getLine();
}
