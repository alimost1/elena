<?php
/**
 * Machaussure - WooCommerce Product Content (same as Elena / image style)
 *
 * @package Mashaussure
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( empty( $product ) || ! $product->is_visible() ) {
    return;
}

$sale_badge = '';
if ( $product->is_on_sale() && $product->get_regular_price() && (float) $product->get_regular_price() > 0 ) {
    $percent = round( ( ( (float) $product->get_regular_price() - (float) $product->get_sale_price() ) / (float) $product->get_regular_price() ) * 100 );
    $sale_badge = '-' . $percent . '%';
}

$is_new = false;
if ( has_term( 'new', 'product_tag', $product->get_id() ) || has_term( 'NEW', 'product_tag', $product->get_id() ) ) {
    $is_new = true;
} elseif ( ( time() - get_the_time( 'U', $product->get_id() ) ) < ( 30 * 24 * 60 * 60 ) ) {
    $is_new = true;
}

$size_attrs = array();
if ( $product->is_type( 'variable' ) ) {
    $attrs = $product->get_variation_attributes();
    if ( ! empty( $attrs ) ) {
        foreach ( $attrs as $name => $options ) {
            if ( stripos( $name, 'pointure' ) !== false || stripos( $name, 'size' ) !== false || stripos( $name, 'taille' ) !== false ) {
                $size_attrs = is_array( $options ) ? $options : array();
                break;
            }
        }
        if ( empty( $size_attrs ) && ! empty( $attrs ) ) {
            $first = reset( $attrs );
            $size_attrs = is_array( $first ) ? $first : array();
        }
    }
} else {
    foreach ( array( 'pa_taille', 'pa_pointure', 'taille', 'pointure', 'size' ) as $key ) {
        $val = $product->get_attribute( $key );
        if ( $val ) {
            $size_attrs = array_map( 'trim', explode( ',', $val ) );
            break;
        }
    }
}
?>
<li <?php wc_product_class( 'elena-product-card elena-product-card-masha masha-product-card', $product ); ?>>
    <div class="elena-product-card-inner">
        <a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="elena-product-link">
            <div class="elena-product-image">
                <?php echo $product->get_image( 'elena-product-thumb' ); ?>
                <?php if ( $sale_badge ) : ?>
                    <span class="elena-sale-badge elena-sale-badge-black"><?php echo esc_html( $sale_badge ); ?></span>
                <?php endif; ?>
            </div>
            <?php if ( $is_new ) : ?>
                <span class="elena-new-badge">NEW</span>
            <?php endif; ?>
        </a>
        <div class="elena-product-info">
            <?php if ( ! empty( $size_attrs ) ) : ?>
                <div class="elena-product-sizes">
                    <?php foreach ( $size_attrs as $size ) : ?>
                        <span class="elena-size-option"><?php echo esc_html( $size ); ?></span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <h3 class="elena-product-title">
                <a href="<?php echo esc_url( $product->get_permalink() ); ?>"><?php echo get_the_title(); ?></a>
            </h3>
            <div class="elena-product-price"><?php echo $product->get_price_html(); ?></div>
        </div>
        <div class="elena-product-actions"><?php woocommerce_template_loop_add_to_cart(); ?></div>
    </div>
</li>
