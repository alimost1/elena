<?php
/**
 * Template Name: Checkout Page Arabic
 *
 * Wraps the WooCommerce checkout output in an RTL container with Arabic UI strings.
 *
 * @package Elena
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Prevent WooCommerce from redirecting away from this page when the cart is empty,
// and block any generic wp_redirect() calls that might send the user to the home page.
add_filter( 'woocommerce_checkout_redirect_empty_cart', '__return_false' );
add_filter( 'woocommerce_prevent_checkout_redirect_on_empty_cart', '__return_true' );

get_header();
?>
<div dir="rtl" lang="ar" class="masha-rtl-wrapper elena-checkout-page elena-ar-page elena-section">
    <div class="elena-container">

        <header class="elena-ar-page-hero">
            <h1 class="elena-ar-page-title">إتمام الطلب</h1>
            <p class="elena-ar-page-subtitle">أدخل بياناتك لإتمام عملية الشراء</p>
        </header>

        <div class="elena-ar-wc-wrap elena-ar-checkout-wrap">
            <?php
            // Render the page content if it has any (allows block-based checkout).
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

            // Fallback: render the checkout shortcode directly if the page had no usable content.
            if ( ! $has_rendered ) {
                if ( class_exists( 'WooCommerce' ) && function_exists( 'WC' ) ) {
                    echo do_shortcode( '[woocommerce_checkout]' );
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
/* ── Arabic Checkout base (shares vars with cart template) ────────── */
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

.elena-ar-wc-wrap {
    background: #fff;
    border: 1px solid var(--elena-border, #E7E0D8);
    border-radius: 6px;
    padding: 32px;
    direction: rtl;
    text-align: right;
}

/* ── Two-column checkout layout on desktop ────────────────────────── */
.elena-ar-checkout-wrap .woocommerce-checkout {
    display: grid;
    grid-template-columns: 1.5fr 1fr;
    grid-template-rows: auto 1fr;
    gap: 0 30px;
    align-items: start;
}
.elena-ar-checkout-wrap #customer_details {
    grid-column: 1;
    grid-row: 1 / span 2;
}
.elena-ar-checkout-wrap h3#order_review_heading {
    grid-column: 2;
    grid-row: 1;
    margin: 0 0 16px !important;
}
.elena-ar-checkout-wrap #order_review,
.elena-ar-checkout-wrap .woocommerce-checkout-review-order {
    grid-column: 2;
    grid-row: 2;
    align-self: start;
    position: sticky;
    top: 20px;
}

/* ── Form fields (labels + inputs) ─────────────────────────────── */
.elena-ar-checkout-wrap .form-row {
    margin-bottom: 18px;
    display: block;
}
.elena-ar-checkout-wrap label {
    display: block;
    margin-bottom: 6px;
    font-weight: 600;
    color: var(--elena-text, #1C1917);
    font-size: 0.92rem;
}
.elena-ar-checkout-wrap input[type="text"],
.elena-ar-checkout-wrap input[type="email"],
.elena-ar-checkout-wrap input[type="tel"],
.elena-ar-checkout-wrap input[type="password"],
.elena-ar-checkout-wrap input[type="number"],
.elena-ar-checkout-wrap textarea,
.elena-ar-checkout-wrap select,
.elena-ar-checkout-wrap .select2-selection {
    width: 100% !important;
    padding: 12px 14px !important;
    border: 1px solid var(--elena-border, #E7E0D8) !important;
    background: #FAF8F5 !important;
    border-radius: 4px !important;
    font-family: inherit;
    font-size: 0.98rem;
    color: var(--elena-text, #1C1917);
    text-align: right !important;
    direction: rtl !important;
    line-height: 1.4 !important;
}
.elena-ar-checkout-wrap textarea { min-height: 110px; resize: vertical; }
.elena-ar-checkout-wrap input:focus,
.elena-ar-checkout-wrap textarea:focus,
.elena-ar-checkout-wrap select:focus {
    outline: none !important;
    border-color: var(--elena-orange, #8B2E3B) !important;
    background: #fff !important;
}

/* Select2 RTL tweaks */
.elena-ar-checkout-wrap .select2-container--default .select2-selection--single {
    height: 44px !important;
    line-height: 44px !important;
    padding-right: 14px !important;
    padding-left: 28px !important;
}
.elena-ar-checkout-wrap .select2-container--default .select2-selection--single .select2-selection__arrow {
    left: 8px;
    right: auto;
}

/* Section headings */
.elena-ar-checkout-wrap h3,
.elena-ar-checkout-wrap #order_review_heading {
    font-family: var(--elena-font-display, 'Playfair Display', serif);
    font-size: 1.4rem;
    margin: 0 0 20px;
    padding-bottom: 10px;
    border-bottom: 1px solid var(--elena-border-light, #F0EBE4);
    color: var(--elena-text, #1C1917);
}

/* Order review box */
.elena-ar-checkout-wrap #order_review {
    background: var(--elena-bg, #FAF8F5);
    border: 1px solid var(--elena-border, #E7E0D8);
    border-radius: 6px;
    padding: 22px;
}
.elena-ar-checkout-wrap .shop_table,
.elena-ar-checkout-wrap .woocommerce-checkout-review-order-table {
    direction: rtl !important;
    text-align: right !important;
    width: 100%;
}
.elena-ar-checkout-wrap .shop_table th,
.elena-ar-checkout-wrap .shop_table td {
    text-align: right !important;
    padding: 12px 10px !important;
    border-bottom: 1px solid var(--elena-border-light, #F0EBE4) !important;
}
.elena-ar-checkout-wrap .shop_table tfoot .order-total {
    font-weight: 700;
    font-size: 1.1rem;
}
.elena-ar-checkout-wrap .shop_table tfoot .order-total .amount {
    color: var(--elena-orange, #8B2E3B);
}

/* Payment methods */
.elena-ar-checkout-wrap #payment {
    background: transparent !important;
    margin-top: 20px;
}
.elena-ar-checkout-wrap #payment ul.payment_methods {
    list-style: none;
    padding: 0;
    margin: 0 0 18px;
    border-bottom: 0;
}
.elena-ar-checkout-wrap #payment ul.payment_methods li {
    background: #fff;
    border: 1px solid var(--elena-border, #E7E0D8);
    border-radius: 4px;
    padding: 14px 16px;
    margin-bottom: 10px;
}
.elena-ar-checkout-wrap #payment ul.payment_methods li label {
    display: inline-block;
    font-weight: 600;
    margin-right: 6px;
    margin-bottom: 0;
}
.elena-ar-checkout-wrap #payment div.payment_box {
    background: var(--elena-bg, #FAF8F5) !important;
    color: var(--elena-text, #1C1917) !important;
    border-radius: 4px !important;
    padding: 14px 16px !important;
    margin-top: 10px !important;
    font-size: 0.9rem;
}
.elena-ar-checkout-wrap #payment div.payment_box::before { display: none; }

/* Place order button */
.elena-ar-checkout-wrap #place_order,
.elena-ar-checkout-wrap .button,
.elena-ar-checkout-wrap button.button,
.elena-ar-checkout-wrap input[type="submit"].button,
.elena-ar-checkout-wrap .wc-block-components-button {
    background: var(--elena-orange, #8B2E3B) !important;
    color: #fff !important;
    border: 0 !important;
    padding: 14px 36px !important;
    font-weight: 600 !important;
    letter-spacing: 0.04em !important;
    border-radius: 4px !important;
    cursor: pointer;
    transition: background 0.2s ease !important;
    font-size: 0.95rem !important;
    width: 100%;
    margin-top: 16px;
    text-transform: uppercase;
}
.elena-ar-checkout-wrap #place_order:hover,
.elena-ar-checkout-wrap .button:hover {
    background: var(--elena-orange-hover, #722433) !important;
}

/* Coupon toggle + login toggle */
.elena-ar-checkout-wrap .woocommerce-form-login-toggle,
.elena-ar-checkout-wrap .woocommerce-form-coupon-toggle {
    direction: rtl !important;
    text-align: right !important;
}
.elena-ar-checkout-wrap .woocommerce-info {
    direction: rtl !important;
    text-align: right !important;
    background: var(--elena-bg-alt, #F3EDE6) !important;
    border-right: 3px solid var(--elena-orange, #8B2E3B) !important;
    border-left: 0 !important;
    padding: 14px 18px !important;
    border-radius: 4px !important;
}

/* Terms + required indicator */
.elena-ar-checkout-wrap .woocommerce-terms-and-conditions-wrapper { margin-top: 14px; }
.elena-ar-checkout-wrap .required {
    color: var(--elena-sale, #DC2626);
    margin-right: 4px;
    text-decoration: none;
}

/* Notices */
.elena-ar-checkout-wrap .woocommerce-message,
.elena-ar-checkout-wrap .woocommerce-error {
    direction: rtl !important;
    text-align: right !important;
    padding: 14px 18px !important;
    border-radius: 4px !important;
    border-right: 3px solid var(--elena-orange, #8B2E3B) !important;
    border-left: 0 !important;
    background: var(--elena-bg-alt, #F3EDE6) !important;
}

/* Mobile: single column + tighter spacing */
@media (max-width: 860px) {
    .elena-ar-checkout-wrap .woocommerce-checkout {
        grid-template-columns: 1fr;
        gap: 24px;
    }
    .elena-ar-checkout-wrap #customer_details,
    .elena-ar-checkout-wrap .woocommerce-checkout-review-order,
    .elena-ar-checkout-wrap #order_review,
    .elena-ar-checkout-wrap h3#order_review_heading {
        grid-column: 1;
    }
    .elena-ar-wc-wrap { padding: 18px 14px; }
}
</style>

<?php
get_footer();
