<?php
/**
 * Remote insert script for "2002DX" product.
 */
require_once( 'wp-load.php' );

echo "Starting remote product insertion...\n";

$product_name = '2002DX';
$regular_price = '199';
$sale_price = '149';
$short_description = 'The 9060 is a new expression of the refined style and innovation-led design of the classic 99X series...';
$description = 'Features premium materials and cushioning with an elevated design.';

$product = new WC_Product_Simple();
$product->set_name( $product_name );
$product->set_status( 'publish' );
$product->set_description( $description );
$product->set_short_description( $short_description );
$product->set_regular_price( $regular_price );
$product->set_sale_price( $sale_price );
$product->set_sku( '2002DX-' . time() );

$product_id = $product->save();

if ( ! $product_id ) die( "Failed.\n" );

function sideload_from_url( $url, $post_id ) {
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

$main_url = 'https://elena.ma/wp-content/uploads/2025/12/u2002dxb_nb_02_i.webp';
$gallery_urls = [
    'https://elena.ma/wp-content/uploads/2025/12/u2002dxa_nb_02_i.webp',
    'https://elena.ma/wp-content/uploads/2025/12/u2002dxc_nb_02_i.webp'
];

$main_id = sideload_from_url( $main_url, $product_id );
if ( $main_id ) set_post_thumbnail( $product_id, $main_id );

$gids = [];
foreach ( $gallery_urls as $url ) {
    $gid = sideload_from_url( $url, $product_id );
    if ( $gid ) $gids[] = $gid;
}
if ( ! empty( $gids ) ) update_post_meta( $product_id, '_product_image_gallery', implode( ',', $gids ) );

echo "Success ID: $product_id\n";
