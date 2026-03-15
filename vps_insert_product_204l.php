<?php
/**
 * Remote insert script for "204L" product.
 */
require_once( 'wp-load.php' );

if ( ! function_exists( 'wp_insert_post' ) ) {
    die( 'WordPress not found.' );
}

echo "Starting remote product insertion for 204L...\n";

$product_name = '204L';
$regular_price = '199';
$sale_price = '149';
$short_description = 'Enter the 204L: an unexpected interpretation of 2000s running-inspired style...';
$description = 'Enter the 204L: an unexpected interpretation of 2000s running-inspired style. Sleek proportions, accented with arced lines across the overlay, make the 204L both unique and easy to wear.';

$product = new WC_Product_Simple();
$product->set_name( $product_name );
$product->set_status( 'publish' );
$product->set_description( $description );
$product->set_short_description( $short_description );
$product->set_regular_price( $regular_price );
$product->set_sale_price( $sale_price );
$product->set_sku( '204L-' . time() );

$product_id = $product->save();

if ( ! $product_id ) die( "Failed.\n" );

echo "Product created with ID: $product_id\n";

function sideload_from_url_204l( $url, $post_id ) {
    require_once( ABSPATH . 'wp-admin/includes/image.php' );
    require_once( ABSPATH . 'wp-admin/includes/file.php' );
    require_once( ABSPATH . 'wp-admin/includes/media.php' );

    $tmp = download_url( $url );
    if ( is_wp_error( $tmp ) ) return false;

    $file_array = array(
        'name'     => basename( $url ),
        'tmp_name' => $tmp
    );

    $id = media_handle_sideload( $file_array, $post_id );
    @unlink( $tmp );

    return $id;
}

$main_url = 'https://elena.ma/wp-content/uploads/2025/12/u204lswd_nb_02_i.webp';
$gallery_urls = [
    'https://elena.ma/wp-content/uploads/2025/12/u204lswa_nb_02_i.webp',
    'https://elena.ma/wp-content/uploads/2025/12/u204lswb_nb_02_i.webp'
];

$main_id = sideload_from_url_204l( $main_url, $product_id );
if ( $main_id ) {
    set_post_thumbnail( $product_id, $main_id );
    echo "Main image set.\n";
}

$gids = [];
foreach ( $gallery_urls as $url ) {
    $gid = sideload_from_url_204l( $url, $product_id );
    if ( $gid ) $gids[] = $gid;
}
if ( ! empty( $gids ) ) {
    update_post_meta( $product_id, '_product_image_gallery', implode( ',', $gids ) );
    echo "Gallery images set.\n";
}

echo "Success ID: $product_id\n";
