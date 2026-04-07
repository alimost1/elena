<?php
/**
 * Single Product title
 *
 * @see        https://woocommerce.com/document/template-structure/
 * @package    WooCommerce\Templates
 * @version    1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;
echo '<h1 class="product_title entry-title">' . esc_html( $product->get_name() ) . '</h1>';
