<?php
require_once( dirname(__FILE__) . '/wp-load.php' );

// 1. Get the primary menu location
$locations = get_theme_mod( 'nav_menu_locations' );

if ( isset( $locations['primary'] ) ) {
    $menu_id = $locations['primary'];
    
    // Clear existing items in this menu
    $items = wp_get_nav_menu_items( $menu_id );
    if ( $items ) {
        foreach ( $items as $item ) {
            wp_delete_post( $item->ID, true );
        }
    }
    
    // Add new premium categories
    $shop_url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url('/shop/');
    
    $new_items = array(
        'Femmes' => $shop_url,
        'Hommes' => $shop_url,
        'Enfants' => $shop_url,
        'Nouveautés' => $shop_url,
        'Promotions' => $shop_url,
    );
    
    foreach ( $new_items as $title => $url ) {
        wp_update_nav_menu_item( $menu_id, 0, array(
            'menu-item-title'   => $title,
            'menu-item-url'     => $url,
            'menu-item-status'  => 'publish',
            'menu-item-type'    => 'custom',
        ));
    }
    echo "Primary menu updated.\n";
} else {
    // No menu assigned, creating one
    $menu_id = wp_create_nav_menu("Elena Navigation");
    $locations['primary'] = $menu_id;
    set_theme_mod( 'nav_menu_locations', $locations );
    
    $shop_url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url('/shop/');
    
    $new_items = array(
        'Femmes' => $shop_url,
        'Hommes' => $shop_url,
        'Enfants' => $shop_url,
        'Nouveautés' => $shop_url,
        'Promotions' => $shop_url,
    );
    
    foreach ( $new_items as $title => $url ) {
        wp_update_nav_menu_item( $menu_id, 0, array(
            'menu-item-title'   => $title,
            'menu-item-url'     => $url,
            'menu-item-status'  => 'publish',
            'menu-item-type'    => 'custom',
        ));
    }
    echo "Created and assigned primary menu.\n";
}
