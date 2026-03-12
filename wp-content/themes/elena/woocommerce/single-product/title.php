<?php
/**
 * Single Product title
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/title.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see        https://woocommerce.com/document/template-structure/
 * @package    WooCommerce\Templates
 * @version    1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $post, $product;

// Display categories above title
echo wc_get_product_category_list( $product->get_id(), ', ', '<div class="elena-single-product-cats">', '</div>' );
?>

<style>
.elena-single-product-cats { margin-bottom: 5px; }
.elena-single-product-cats a {
    color: var(--elena-orange);
    font-size: 1rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-family: 'Montserrat', sans-serif;
}
.elena-single-product-cats a:hover { text-decoration: underline; }
</style>

<?php
the_title( '<h1 class="product_title entry-title">', '</h1>' );
