<?php
require 'wp-load.php';

$product = wc_get_product( wc_get_products( array( 'limit' => 1, 'return' => 'ids' ) )[0] );
if ( ! $product ) {
    die("No product found");
}

global $post;
$post = get_post($product->get_id());
setup_postdata($post);

ob_start();
do_action('woocommerce_single_product_summary');
$output = ob_get_clean();

echo "--- SUMMARY HTML --- \n";
echo $output;
echo "\n--- END --- \n";
