<?php
/**
 * Helper script to insert the "204L" product into WooCommerce.
 */

// Load WordPress
require_once( 'wp-load.php' );

if ( ! function_exists( 'wp_insert_post' ) ) {
    die( 'WordPress not found.' );
}

echo "Starting product insertion for 204L...\n";

// Product Data
$product_name = '204L';
$regular_price = '199';
$sale_price = '149';
$short_description = 'Enter the 204L: an unexpected interpretation of 2000s running-inspired style. This low-profile silhouette blends the slim structure of ’70s running shoes with tech-inspired texture of premium suede.';
$description = 'Enter the 204L: an unexpected interpretation of 2000s running-inspired style. This low-profile silhouette blends the slim structure of ’70s running shoes with tech-inspired texture of premium suede. Pulling design elements from past and present New Balance favorites, the 204L feels familiar, yet new. Its sleek proportions, accented with arced lines across the overlay, make the 204L both unique and easy to wear.';

// Create Simple Product
$product = new WC_Product_Simple();
$product->set_name( $product_name );
$product->set_status( 'publish' );
$product->set_catalog_visibility( 'visible' );
$product->set_description( $description );
$product->set_short_description( $short_description );
$product->set_regular_price( $regular_price );
$product->set_sale_price( $sale_price );
$product->set_sku( '204L-' . time() );

// Save Product to get an ID
$product_id = $product->save();

if ( ! $product_id ) {
    die( "Failed to create product.\n" );
}

echo "Product created with ID: $product_id\n";

// Function to sideload image
function sideload_product_image_204l( $file_path, $post_id, $desc = '' ) {
    require_once( ABSPATH . 'wp-admin/includes/image.php' );
    require_once( ABSPATH . 'wp-admin/includes/file.php' );
    require_once( ABSPATH . 'wp-admin/includes/media.php' );

    $filename = basename( $file_path );
    $upload_file = wp_upload_bits( $filename, null, file_get_contents( $file_path ) );

    if ( ! $upload_file['error'] ) {
        $wp_filetype = wp_check_filetype( $filename, null );
        $attachment = array(
            'post_mime_type' => $wp_filetype['type'],
            'post_parent'    => $post_id,
            'post_title'     => preg_replace( '/\.[^.]+$/', '', $filename ),
            'post_content'   => '',
            'post_status'    => 'inherit'
        );

        $attachment_id = wp_insert_attachment( $attachment, $upload_file['file'], $post_id );

        if ( ! is_wp_error( $attachment_id ) ) {
            $attachment_data = wp_generate_attachment_metadata( $attachment_id, $upload_file['file'] );
            wp_update_attachment_metadata( $attachment_id, $attachment_data );
            return $attachment_id;
        }
    }
    return false;
}

// Handle Images
$images_dir = 'wp-content/uploads/temp_imports_adidas/';
$main_image_path = $images_dir . '204l_main.webp';
$gallery_images = array(
    $images_dir . '204l_gallery1.webp',
    $images_dir . '204l_gallery2.webp'
);

$main_id = sideload_product_image_204l( $main_image_path, $product_id, 'Main Image' );
if ( $main_id ) {
    set_post_thumbnail( $product_id, $main_id );
    echo "Main image set.\n";
}

$gallery_ids = array();
foreach ( $gallery_images as $img_path ) {
    $gid = sideload_product_image_204l( $img_path, $product_id, 'Gallery Image' );
    if ( $gid ) {
        $gallery_ids[] = $gid;
    }
}

if ( ! empty( $gallery_ids ) ) {
    update_post_meta( $product_id, '_product_image_gallery', implode( ',', $gallery_ids ) );
    echo "Gallery images set.\n";
}

echo "Success! Product '204L' is now available.\n";
