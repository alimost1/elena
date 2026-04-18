<?php
require_once( dirname(__FILE__) . '/wp-load.php' );
echo "Active Theme: " . get_option('stylesheet') . "\n";
echo "Template: " . get_option('template') . "\n";
