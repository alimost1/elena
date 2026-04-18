<?php
require_once( dirname(__FILE__) . '/wp-load.php' );
switch_theme( 'mashaussure' );
echo "Active Theme is now: " . get_option('stylesheet') . "\n";
