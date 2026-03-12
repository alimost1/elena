<?php
/**
 * Elena - WooCommerce Product Content Override
 *
 * @package Elena
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( empty( $product ) || ! $product->is_visible() ) {
    return;
}
?>
<li <?php wc_product_class( 'elena-product-card', $product ); ?>>
    <a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="elena-product-link">
        <div class="elena-product-image">
            <?php echo $product->get_image( 'elena-product-thumb' ); ?>
            <?php if ( $product->is_on_sale() ) : ?>
                <span class="elena-sale-badge"><?php esc_html_e( 'Sale', 'elena' ); ?></span>
            <?php endif; ?>
        </div>
        <div class="elena-product-info">
            <h3 class="elena-product-title"><?php echo get_the_title(); ?></h3>
            <span class="elena-product-price"><?php echo $product->get_price_html(); ?></span>
        </div>
    </a>
    <div class="elena-product-actions">
        <?php woocommerce_template_loop_add_to_cart(); ?>
    </div>
</li>
