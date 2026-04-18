<?php
require_once( dirname(__FILE__) . '/wp-load.php' );
wp_cache_flush();
echo "Cache flushed.\n";

$menus = wp_get_nav_menus();
echo "Menus found:\n";
foreach($menus as $menu) {
    echo "- " . $menu->name . " (ID: " . $menu->term_id . ")\n";
}

$locations = get_nav_menu_locations();
echo "Locations:\n";
print_r($locations);
