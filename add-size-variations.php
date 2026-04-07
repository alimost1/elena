<?php
/**
 * Convert a simple product to a variable product and add size variations.
 * Run in WP context.
 */

require_once( 'wp-load.php' );

// Product slug
$slug = 'please-translate-in-fr_fr-new-balance-1000-retro-sneaker-pink-grey-lightweight-street-style-running-shoes';

$args = array(
    'name'           => $slug,
    'post_type'      => 'product',
    'post_status'    => 'any',
    'posts_per_page' => 1,
);

$posts = get_posts( $args );

if ( ! $posts ) {
    die( "PRODUCT NOT FOUND by slug: $slug\n" );
}

$product_id = $posts[0]->ID;
$product = wc_get_product( $product_id );

echo "Found Product ID: $product_id\n";
echo "Current Type: " . $product->get_type() . "\n";

// Get current price if it's a simple product
$current_price = $product->get_regular_price();
if ( empty( $current_price ) ) {
    $current_price = '0';
}
echo "Price: $current_price\n";

// Convert to Variable Product if it's not already
if ( $product->get_type() !== 'variable' ) {
    wp_set_object_terms( $product_id, 'variable', 'product_type' );
    echo "Converted to variable product type.\n";
    // We need to re-fetch the product to update its class in the standard WooCommerce way
    $product = new WC_Product_Variable( $product_id );
}

// Ensure the size attribute is added.
$sizes = array( '36', '37', '38', '39', '40', '41', '42', '43', '44', '45' );

$attribute = new WC_Product_Attribute();
$attribute->set_id( 0 ); // Use 0 for custom product attribute
$attribute->set_name( 'Size' );
$attribute->set_options( $sizes );
$attribute->set_visible( true );
$attribute->set_variation( true );

$product->set_attributes( array( $attribute ) );
$product->save();
echo "Added Size attributes.\n";

// Create variations for each size
foreach ( $sizes as $size ) {
    $variation = new WC_Product_Variation();
    $variation->set_parent_id( $product_id );
    $variation->set_attributes( array( 'size' => $size ) );
    $variation->set_regular_price( $current_price );
    $variation->set_status( 'publish' );
    $variation->set_manage_stock( false );
    $variation->set_stock_status( 'instock' );
    $variation->save();
    echo "Created variation for size $size.\n";
}

echo "DONE!\n";
