<?php
/**
 * Template Name: Cart Page Arabic
 *
 * Wraps the WooCommerce cart output in an RTL container with Arabic UI strings.
 *
 * @package Elena
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>
<div dir="rtl" lang="ar" class="masha-rtl-wrapper elena-cart-page elena-ar-page elena-section">
    <div class="elena-container">

        <header class="elena-ar-page-hero">
            <h1 class="elena-ar-page-title">سلة التسوق</h1>
            <p class="elena-ar-page-subtitle">راجع منتجاتك قبل إتمام الطلب</p>
        </header>

        <div class="elena-ar-wc-wrap">
            <?php
            $has_rendered = false;
            if ( have_posts() ) {
                while ( have_posts() ) :
                    the_post();
                    $raw_content = get_the_content();
                    if ( trim( wp_strip_all_tags( $raw_content ) ) !== '' ) {
                        the_content();
                        $has_rendered = true;
                    }
                endwhile;
            }

            if ( ! $has_rendered ) {
                if ( class_exists( 'WooCommerce' ) && function_exists( 'WC' ) ) {
                    echo do_shortcode( '[woocommerce_cart]' );
                } else {
                    echo '<p style="padding:20px;background:#fff3cd;border:1px solid #ffeeba;border-radius:4px;color:#856404;text-align:center;">';
                    echo 'WooCommerce غير مثبت أو غير مفعل.';
                    echo '</p>';
                }
            }
            ?>
        </div>

    </div>
</div>

<style>
/* ── Arabic Cart / Checkout shared base ───────────────────────────── */
.elena-ar-page { padding: 50px 0 90px; background: var(--elena-bg, #FAF8F5); }
.elena-ar-page-hero { text-align: center; max-width: 680px; margin: 0 auto 40px; }
.elena-ar-page-title {
    font-family: var(--elena-font-display, 'Playfair Display', serif);
    font-size: clamp(2rem, 4vw, 3rem);
    margin: 0 0 10px;
    color: var(--elena-text, #1C1917);
}
.elena-ar-page-subtitle {
    color: var(--elena-text-muted, #78716C);
    font-size: 1rem;
    margin: 0;
}

/* Container for the WooCommerce output */
.elena-ar-wc-wrap {
    background: #fff;
    border: 1px solid var(--elena-border, #E7E0D8);
    border-radius: 6px;
    padding: 32px;
    direction: rtl;
    text-align: right;
}

/* ── RTL overrides for WooCommerce cart table ─────────────────────── */
.elena-ar-wc-wrap table,
.elena-ar-wc-wrap .shop_table {
    direction: rtl !important;
    text-align: right !important;
    width: 100%;
    border-collapse: collapse;
}
.elena-ar-wc-wrap .shop_table th,
.elena-ar-wc-wrap .shop_table td {
    text-align: right !important;
    padding: 14px 12px !important;
    border-bottom: 1px solid var(--elena-border-light, #F0EBE4) !important;
}

.elena-ar-wc-wrap .product-remove { text-align: center !important; width: 40px; }
.elena-ar-wc-wrap .product-thumbnail img {
    max-width: 70px;
    height: auto;
    border-radius: 4px;
}

.elena-ar-wc-wrap .quantity input.qty {
    width: 64px;
    text-align: center;
    padding: 8px;
    border: 1px solid var(--elena-border, #E7E0D8);
    border-radius: 4px;
    background: #fff;
}

.elena-ar-wc-wrap .cart_totals,
.elena-ar-wc-wrap .cart-collaterals {
    margin-top: 30px;
    direction: rtl !important;
    text-align: right !important;
}
.elena-ar-wc-wrap .cart_totals h2,
.elena-ar-wc-wrap .wc-block-components-title {
    font-family: var(--elena-font-display, 'Playfair Display', serif);
    font-size: 1.4rem;
    margin-bottom: 16px;
}

/* Coupon + update row */
.elena-ar-wc-wrap .coupon label { display: none; }
.elena-ar-wc-wrap #coupon_code {
    padding: 11px 14px;
    border: 1px solid var(--elena-border, #E7E0D8);
    border-radius: 4px;
    background: #FAF8F5;
    text-align: right;
    min-width: 180px;
    margin-left: 8px;
}

/* ── Buttons (match theme) ───────────────────────────────────────── */
.elena-ar-wc-wrap .button,
.elena-ar-wc-wrap button.button,
.elena-ar-wc-wrap input[type="submit"].button,
.elena-ar-wc-wrap .wc-proceed-to-checkout .checkout-button,
.elena-ar-wc-wrap .wc-block-components-button {
    background: var(--elena-orange, #8B2E3B) !important;
    color: #fff !important;
    border: 0 !important;
    padding: 12px 28px !important;
    font-weight: 600 !important;
    letter-spacing: 0.04em !important;
    border-radius: 4px !important;
    text-transform: uppercase !important;
    cursor: pointer;
    transition: background 0.2s ease !important;
    font-size: 0.9rem !important;
}
.elena-ar-wc-wrap .button:hover,
.elena-ar-wc-wrap button.button:hover,
.elena-ar-wc-wrap input[type="submit"].button:hover,
.elena-ar-wc-wrap .wc-proceed-to-checkout .checkout-button:hover {
    background: var(--elena-orange-hover, #722433) !important;
}

/* Empty cart state */
.elena-ar-wc-wrap .cart-empty,
.elena-ar-wc-wrap .wc-empty-cart-message {
    text-align: center;
    padding: 40px 20px;
    font-size: 1.05rem;
    color: var(--elena-text-muted, #78716C);
}
.elena-ar-wc-wrap .return-to-shop {
    text-align: center;
    margin-top: 20px;
}

/* WooCommerce notices */
.elena-ar-wc-wrap .woocommerce-message,
.elena-ar-wc-wrap .woocommerce-info,
.elena-ar-wc-wrap .woocommerce-error {
    direction: rtl !important;
    text-align: right !important;
    padding: 14px 18px !important;
    border-radius: 4px !important;
    border-right: 3px solid var(--elena-orange, #8B2E3B) !important;
    border-left: 0 !important;
    background: var(--elena-bg-alt, #F3EDE6) !important;
}

/* Mobile tweaks */
@media (max-width: 768px) {
    .elena-ar-wc-wrap { padding: 18px 14px; }
    .elena-ar-wc-wrap .shop_table th,
    .elena-ar-wc-wrap .shop_table td { padding: 10px 6px !important; font-size: 0.9rem; }
    .elena-ar-wc-wrap .product-thumbnail img { max-width: 50px; }
}
</style>

<?php
get_footer();
