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

the_title( '<h1 class="product_title entry-title">', '</h1>' );
