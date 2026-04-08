<?php
/**
 * Convert New Balance 1000 Pink/Grey to Variable Product on VPS.
 */
require_once( 'wp-load.php' );

// Correct slug on VPS
$slug = 'new-balance-1000-retro-sneaker-pink-grey-lightweight-street-style-running-shoes';

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

$current_price = $product->get_regular_price();
if ( empty( $current_price ) ) {
    $current_price = '220'; // Default from the site if missing
}
$sale_price = $product->get_sale_price();
if ( empty( $sale_price ) ) {
    $sale_price = '189';
}

echo "Price: $current_price (Sale: $sale_price)\n";

// Convert to Variable Product if it's not already
if ( $product->get_type() !== 'variable' ) {
    wp_set_object_terms( $product_id, 'variable', 'product_type' );
    echo "Converted to variable product type.\n";
    $product = new WC_Product_Variable( $product_id );
}

// Ensure the size attribute is added.
$sizes = array( '36', '37', '38', '39', '40', '41', '42' );

$attribute = new WC_Product_Attribute();
$attribute->set_id( 0 );
$attribute->set_name( 'Size' );
$attribute->set_options( $sizes );
$attribute->set_visible( true );
$attribute->set_variation( true );

$product->set_attributes( array( $attribute ) );
$product->save();
echo "Added Size attributes.\n";

// Clear existing variations first to avoid duplicates
$variations = $product->get_children();
foreach ( $variations as $variation_id ) {
    $v_product = wc_get_product( $variation_id );
    if ( $v_product ) {
        $v_product->delete( true );
    }
}
echo "Cleared old variations.\n";

// Create variations for each size
foreach ( $sizes as $size ) {
    $variation = new WC_Product_Variation();
    $variation->set_parent_id( $product_id );
    $variation->set_attributes( array( 'size' => $size ) );
    $variation->set_regular_price( $current_price );
    if ( ! empty( $sale_price ) ) {
        $variation->set_sale_price( $sale_price );
    }
    $variation->set_status( 'publish' );
    $variation->set_manage_stock( false );
    $variation->set_stock_status( 'instock' );
    $variation->save();
    echo "Created variation for size $size.\n";
}

// Clear product cache
wc_delete_product_transients( $product_id );

echo "DONE!\n";
