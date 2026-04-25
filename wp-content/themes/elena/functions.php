<?php
/**
 * Elena Theme Functions
 *
 * @package Elena
 * @version 1.0.1
 */

// die('Functions.php is executed');

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


define( 'ELENA_VERSION', time() );
define( 'ELENA_DIR', get_template_directory() );
define( 'ELENA_URI', get_template_directory_uri() );

/* ─────────────────────────────────────────────
 * 1. Theme Setup
 * ───────────────────────────────────────────── */
function elena_setup() {
    // Load text domain
    load_theme_textdomain( 'elena', get_template_directory() . '/languages' );

    // Title tag
    add_theme_support( 'title-tag' );

    // Post thumbnails
    add_theme_support( 'post-thumbnails' );

    // Custom logo
    add_theme_support( 'custom-logo', array(
        'height'      => 80,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ) );

    // HTML5 support
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ) );

    // Custom image sizes
    add_image_size( 'elena-product-thumb', 400, 400, true );
    add_image_size( 'elena-hero', 1920, 900, true );

    // Register nav menus
    register_nav_menus( array(
        'primary'        => __( 'Primary Menu', 'elena' ),
        'primary_fr_fr'  => __( 'Primary Menu (French)', 'elena' ),
        'primary_en_us'  => __( 'Primary Menu (English)', 'elena' ),
        'primary_ar_ar'  => __( 'Primary Menu (Arabic)', 'elena' ),
        'footer'         => __( 'Footer Menu', 'elena' ),
    ) );

    // Content width
    if ( ! isset( $content_width ) ) {
        $content_width = 1200;
    }

    // WooCommerce Theme Support
    add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'elena_setup' );


/* ─────────────────────────────────────────────
 * 2. Enqueue Assets
 * ───────────────────────────────────────────── */
function elena_enqueue_assets() {
    // Google Fonts: Playfair Display (display/heading) + Inter (body/UI)
    wp_enqueue_style(
        'elena-google-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;700&display=swap',
        array(),
        null
    );

    // Main stylesheet
    wp_enqueue_style(
        'elena-main',
        ELENA_URI . '/assets/css/main.css',
        array( 'elena-google-fonts' ),
        ELENA_VERSION
    );

    // Theme stylesheet (WordPress requirement)
    wp_enqueue_style(
        'elena-style',
        get_stylesheet_uri(),
        array( 'elena-main' ),
        ELENA_VERSION
    );

    // Main JS
    wp_enqueue_script(
        'elena-main-js',
        ELENA_URI . '/assets/js/main.js',
        array(),
        ELENA_VERSION,
        true
    );

    if ( function_exists( 'is_product' ) && is_product() ) {
        wp_enqueue_style(
            'elena-single-product-premium',
            ELENA_URI . '/assets/css/single-product-premium.css',
            array( 'elena-main' ),
            ELENA_VERSION
        );

        wp_enqueue_script(
            'elena-single-product-premium',
            ELENA_URI . '/assets/js/single-product-premium.js',
            array( 'jquery', 'wc-add-to-cart-variation' ),
            ELENA_VERSION,
            true
        );
    }

    if ( is_front_page() ) {
        // Load the same homepage presentation layer used by machaussure.ma.
        wp_enqueue_style(
            'elena-masha-reference-main',
            content_url( '/themes/mashaussure/assets/css/main.css' ),
            array( 'elena-main' ),
            ELENA_VERSION
        );

        wp_enqueue_script(
            'elena-masha-reference-main-js',
            content_url( '/themes/mashaussure/assets/js/main.js' ),
            array(),
            ELENA_VERSION,
            true
        );
    }

    // Custom patches — enqueued LAST so overrides beat both elena-main and masha-reference.
    wp_enqueue_style(
        'elena-custom-patches',
        ELENA_URI . '/assets/css/custom-patches.css',
        array( 'elena-main' ),
        ELENA_VERSION
    );

    // Localize AJAX + cart data
    wp_localize_script( 'elena-main-js', 'elenaData', array(
        'ajaxUrl'  => admin_url( 'admin-ajax.php' ),
        'nonce'    => wp_create_nonce( 'elena_nonce' ),
        'cartUrl'  => function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : '',
        'shopUrl'  => function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : '',
    ) );
}
add_action( 'wp_enqueue_scripts', 'elena_enqueue_assets' );

if ( ! function_exists( 'masha_fp_get_sale_badge' ) ) {
    function masha_fp_get_sale_badge( $product ) {
        if ( ! $product || ! is_a( $product, 'WC_Product' ) || ! $product->is_on_sale() ) {
            return '';
        }
        $regular = (float) $product->get_regular_price();
        $sale    = (float) $product->get_sale_price();
        if ( $regular <= 0 || $sale <= 0 || $sale >= $regular ) {
            return '';
        }
        $percent = round( ( ( $regular - $sale ) / $regular ) * 100 );
        return '-' . $percent . '%';
    }
}

if ( ! function_exists( 'masha_fp_is_new_product' ) ) {
    function masha_fp_is_new_product( $product, $max_days = 30 ) {
        if ( ! $product || ! is_a( $product, 'WC_Product' ) ) {
            return false;
        }
        $product_id = $product->get_id();
        if ( has_term( array( 'new', 'NEW' ), 'product_tag', $product_id ) ) {
            return true;
        }
        $created = get_post_time( 'U', true, $product_id );
        if ( ! $created ) {
            return false;
        }
        return ( time() - $created ) < ( absint( $max_days ) * DAY_IN_SECONDS );
    }
}

if ( ! function_exists( 'masha_fp_get_size_attributes' ) ) {
    function masha_fp_get_size_attributes( $product ) {
        if ( ! $product || ! is_a( $product, 'WC_Product' ) || ! $product->is_type( 'variable' ) ) {
            return array();
        }
        $attrs = $product->get_variation_attributes();
        if ( empty( $attrs ) || ! is_array( $attrs ) ) {
            return array();
        }
        foreach ( $attrs as $name => $options ) {
            if ( stripos( $name, 'pointure' ) !== false || stripos( $name, 'size' ) !== false || stripos( $name, 'taille' ) !== false ) {
                return is_array( $options ) ? $options : array();
            }
        }
        $fallback = reset( $attrs );
        return is_array( $fallback ) ? $fallback : array();
    }
}

add_filter(
    'woocommerce_output_related_products_args',
    function ( $args ) {
        $args['posts_per_page'] = 4;
        $args['columns']        = 4;
        return $args;
    }
);


/* ─────────────────────────────────────────────
 * 2b. Simple-product size picker — persists selection into cart/order.
 * ───────────────────────────────────────────── */

// Block add-to-cart when no size chosen (simple products only).
add_filter( 'woocommerce_add_to_cart_validation', 'elena_validate_simple_size', 10, 3 );
function elena_validate_simple_size( $passed, $product_id, $quantity ) {
    $product = wc_get_product( $product_id );
    if ( ! $product || ! $product->is_type( 'simple' ) ) {
        return $passed;
    }
    if ( empty( $_POST['elena_size'] ) ) {
        wc_add_notice( __( 'Please select a size before adding to cart.', 'elena' ), 'error' );
        return false;
    }
    return $passed;
}

// Attach the size to the cart item so it doesn't merge with sizeless entries.
add_filter( 'woocommerce_add_cart_item_data', 'elena_add_size_to_cart_item', 10, 2 );
function elena_add_size_to_cart_item( $cart_item_data, $product_id ) {
    if ( ! empty( $_POST['elena_size'] ) ) {
        $cart_item_data['elena_size'] = sanitize_text_field( wp_unslash( $_POST['elena_size'] ) );
        $cart_item_data['unique_key']  = md5( microtime() . wp_rand() );
    }
    return $cart_item_data;
}

// Display the size on cart/checkout line items.
add_filter( 'woocommerce_get_item_data', 'elena_display_size_cart_item', 10, 2 );
function elena_display_size_cart_item( $item_data, $cart_item ) {
    if ( ! empty( $cart_item['elena_size'] ) ) {
        $item_data[] = array(
            'key'     => __( 'Size', 'elena' ),
            'value'   => wc_clean( $cart_item['elena_size'] ),
            'display' => '',
        );
    }
    return $item_data;
}

// Persist the size onto the order line item so it appears in admin + emails.
add_action( 'woocommerce_checkout_create_order_line_item', 'elena_save_size_to_order', 10, 4 );
function elena_save_size_to_order( $item, $cart_item_key, $values, $order ) {
    if ( ! empty( $values['elena_size'] ) ) {
        $item->add_meta_data( __( 'Size', 'elena' ), $values['elena_size'], true );
    }
}


/* ─────────────────────────────────────────────
 * 3. WooCommerce Support
 * ───────────────────────────────────────────── */
function elena_woocommerce_support() {
    add_theme_support( 'woocommerce', array(
        'thumbnail_image_width' => 400,
        'gallery_thumbnail_image_width' => 150,
        'single_image_width' => 600,
        'product_grid' => array(
            'default_rows'    => 3,
            'min_rows'        => 1,
            'default_columns' => 4,
            'min_columns'     => 1,
            'max_columns'     => 6,
        ),
    ) );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'elena_woocommerce_support' );

// AJAX cart fragments
function elena_cart_count_fragment( $fragments ) {
    ob_start();
    ?>
    <span class="elena-cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
    <?php
    $fragments['.elena-cart-count'] = ob_get_clean();
    return $fragments;
}
if ( class_exists( 'WooCommerce' ) ) {
    add_filter( 'woocommerce_add_to_cart_fragments', 'elena_cart_count_fragment' );
}


/* ─────────────────────────────────────────────
 * 4. Elementor Pro Support
 * ───────────────────────────────────────────── */
function elena_register_elementor_locations( $elementor_theme_manager ) {
    $elementor_theme_manager->register_all_core_location();
}
add_action( 'elementor/theme/register_locations', 'elena_register_elementor_locations' );


/* ─────────────────────────────────────────────
 * 5. Widget Areas
 * ───────────────────────────────────────────── */
function elena_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Footer Column 1', 'elena' ),
        'id'            => 'footer-1',
        'before_widget' => '<div class="elena-footer-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="elena-footer-widget-title">',
        'after_title'   => '</h4>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Footer Column 2', 'elena' ),
        'id'            => 'footer-2',
        'before_widget' => '<div class="elena-footer-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="elena-footer-widget-title">',
        'after_title'   => '</h4>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Shop Sidebar', 'elena' ),
        'id'            => 'shop-sidebar',
        'before_widget' => '<div class="elena-shop-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="elena-shop-widget-title">',
        'after_title'   => '</h4>',
    ) );
}
add_action( 'widgets_init', 'elena_widgets_init' );


/* ─────────────────────────────────────────────
 * 6. Custom Shortcodes
 * ───────────────────────────────────────────── */

// [elena_best_sellers count="4"]
function elena_best_sellers_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'count' => 4,
    ), $atts, 'elena_best_sellers' );

    if ( ! class_exists( 'WooCommerce' ) ) {
        return '<p>WooCommerce is required for this feature.</p>';
    }

    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => intval( $atts['count'] ),
        'meta_key'       => 'total_sales',
        'orderby'        => 'meta_value_num',
        'order'          => 'DESC',
    );

    $products = new WP_Query( $args );
    ob_start();

    if ( $products->have_posts() ) {
        echo '<div class="elena-products-grid">';
        while ( $products->have_posts() ) {
            $products->the_post();
            global $product;
            ?>
            <div class="elena-product-card">
                <a href="<?php the_permalink(); ?>" class="elena-product-link">
                    <div class="elena-product-image">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <?php the_post_thumbnail( 'elena-product-thumb' ); ?>
                        <?php else : ?>
                            <div class="elena-product-placeholder">
                                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="m21 15-5-5L5 21"/></svg>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="elena-product-info">
                        <h3 class="elena-product-title"><?php the_title(); ?></h3>
                        <span class="elena-product-price"><?php echo $product->get_price_html(); ?></span>
                    </div>
                </a>
            </div>
            <?php
        }
        echo '</div>';
    } else {
        echo '<p class="elena-no-products">' . esc_html__( 'No products found. Add some products to WooCommerce.', 'elena' ) . '</p>';
    }

    wp_reset_postdata();
    return ob_get_clean();
}
add_shortcode( 'elena_best_sellers', 'elena_best_sellers_shortcode' );


/* ─────────────────────────────────────────────
 * 7. Custom Walker for Navigation
 * ───────────────────────────────────────────── */
class Elena_Nav_Walker extends Walker_Nav_Menu {
    public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        $output .= '<li' . $class_names . '>';

        $atts = array();
        $atts['href'] = ! empty( $item->url ) ? $item->url : '';
        $atts['class'] = 'elena-nav-link';

        if ( in_array( 'current-menu-item', $classes ) ) {
            $atts['class'] .= ' active';
        }

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $attributes .= ' ' . $attr . '="' . esc_attr( $value ) . '"';
            }
        }

        $title = apply_filters( 'the_title', $item->title, $item->ID );
        $output .= '<a' . $attributes . '>' . $title . '</a>';
    }
}


/* ─────────────────────────────────────────────
 * 8. Theme Customizer
 * ───────────────────────────────────────────── */
function elena_customize_register( $wp_customize ) {
    // Announcement Bar
    $wp_customize->add_section( 'elena_announcement', array(
        'title'    => __( 'Announcement Bar', 'elena' ),
        'priority' => 25,
    ) );

    $wp_customize->add_setting( 'elena_announcement_text', array(
        'default'           => 'Livraison 20 DH partout au Maroc',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'elena_announcement_text', array(
        'label'   => __( 'Announcement Text', 'elena' ),
        'section' => 'elena_announcement',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'elena_announcement_show', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ) );

    $wp_customize->add_control( 'elena_announcement_show', array(
        'label'   => __( 'Show Announcement Bar', 'elena' ),
        'section' => 'elena_announcement',
        'type'    => 'checkbox',
    ) );

    // Hero Section
    $wp_customize->add_section( 'elena_hero', array(
        'title'    => __( 'Hero Section', 'elena' ),
        'priority' => 30,
    ) );

    $wp_customize->add_setting( 'elena_hero_title', array(
        'default'           => 'Step Into Performance',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'elena_hero_title', array(
        'label'   => __( 'Hero Title', 'elena' ),
        'section' => 'elena_hero',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'elena_hero_subtitle', array(
        'default'           => 'Modern athletic footwear built for real performance. Lightweight materials, durable construction, and ergonomic design.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ) );

    $wp_customize->add_control( 'elena_hero_subtitle', array(
        'label'   => __( 'Hero Subtitle', 'elena' ),
        'section' => 'elena_hero',
        'type'    => 'textarea',
    ) );

    $wp_customize->add_setting( 'elena_hero_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'elena_hero_image', array(
        'label'   => __( 'Hero Background Image', 'elena' ),
        'section' => 'elena_hero',
    ) ) );

    $wp_customize->add_setting( 'elena_hero_cta_text', array(
        'default'           => 'See More',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'elena_hero_cta_text', array(
        'label'   => __( 'CTA Button Text', 'elena' ),
        'section' => 'elena_hero',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'elena_hero_cta_url', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ) );

    $wp_customize->add_control( 'elena_hero_cta_url', array(
        'label'   => __( 'CTA Button URL', 'elena' ),
        'section' => 'elena_hero',
        'type'    => 'url',
    ) );

    // Footer
    $wp_customize->add_section( 'elena_footer', array(
        'title'    => __( 'Footer Settings', 'elena' ),
        'priority' => 90,
    ) );

    $wp_customize->add_setting( 'elena_footer_phone', array(
        'default'           => '+212 600 000 000',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'elena_footer_phone', array(
        'label'   => __( 'Phone Number', 'elena' ),
        'section' => 'elena_footer',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'elena_footer_email', array(
        'default'           => 'contact@elena.ma',
        'sanitize_callback' => 'sanitize_email',
    ) );
    $wp_customize->add_control( 'elena_footer_email', array(
        'label'   => __( 'Email', 'elena' ),
        'section' => 'elena_footer',
        'type'    => 'email',
    ) );

    $wp_customize->add_setting( 'elena_footer_address', array(
        'default'           => 'Casablanca, Morocco',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'elena_footer_address', array(
        'label'   => __( 'Address', 'elena' ),
        'section' => 'elena_footer',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'elena_instagram', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( 'elena_instagram', array(
        'label'   => __( 'Instagram URL', 'elena' ),
        'section' => 'elena_footer',
        'type'    => 'url',
    ) );

    $wp_customize->add_setting( 'elena_facebook', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( 'elena_facebook', array(
        'label'   => __( 'Facebook URL', 'elena' ),
        'section' => 'elena_footer',
        'type'    => 'url',
    ) );

    // Promo banner (Machaussure style)
    $wp_customize->add_section( 'elena_promo', array(
        'title'    => __( 'Bannière promo', 'elena' ),
        'priority' => 28,
    ) );
    $wp_customize->add_setting( 'elena_promo_show', array( 'default' => true, 'sanitize_callback' => 'wp_validate_boolean' ) );
    $wp_customize->add_control( 'elena_promo_show', array( 'label' => __( 'Afficher la bannière promo', 'elena' ), 'section' => 'elena_promo', 'type' => 'checkbox' ) );
    $wp_customize->add_setting( 'elena_promo_title', array( 'default' => 'رمضان كريم', 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'elena_promo_title', array( 'label' => __( 'Titre promo', 'elena' ), 'section' => 'elena_promo', 'type' => 'text' ) );
    $wp_customize->add_setting( 'elena_promo_text', array( 'default' => 'Nouvelle Collection', 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'elena_promo_text', array( 'label' => __( 'Texte promo', 'elena' ), 'section' => 'elena_promo', 'type' => 'text' ) );
    $wp_customize->add_setting( 'elena_promo_discount', array( 'default' => '-30%', 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'elena_promo_discount', array( 'label' => __( 'Réduction (ex: -30%)', 'elena' ), 'section' => 'elena_promo', 'type' => 'text' ) );
    $wp_customize->add_setting( 'elena_promo_btn', array( 'default' => 'Découvrir', 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'elena_promo_btn', array( 'label' => __( 'Bouton', 'elena' ), 'section' => 'elena_promo', 'type' => 'text' ) );
    $wp_customize->add_setting( 'elena_promo_url', array( 'default' => '', 'sanitize_callback' => 'esc_url_raw' ) );
    $wp_customize->add_control( 'elena_promo_url', array( 'label' => __( 'URL du bouton', 'elena' ), 'section' => 'elena_promo', 'type' => 'url' ) );
    $wp_customize->add_setting( 'elena_promo_all_pages', array( 'default' => false, 'sanitize_callback' => 'wp_validate_boolean' ) );
    $wp_customize->add_control( 'elena_promo_all_pages', array( 'label' => __( 'Afficher sur toutes les pages', 'elena' ), 'section' => 'elena_promo', 'type' => 'checkbox' ) );
}
add_action( 'customize_register', 'elena_customize_register' );


/* ─────────────────────────────────────────────
 * 9. Remove WooCommerce default styles selectively
 * ───────────────────────────────────────────── */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );


/* ─────────────────────────────────────────────
 * 10. Admin: Theme requirements notice
 * ───────────────────────────────────────────── */
// Remove WooCommerce default sidebar on single product pages
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

function elena_admin_notice() {
    if ( ! class_exists( 'WooCommerce' ) ) {
        echo '<div class="notice notice-warning is-dismissible">';
        echo '<p><strong>Elena Theme:</strong> WooCommerce is recommended for the best experience. <a href="' . admin_url( 'plugin-install.php?s=woocommerce&tab=search&type=term' ) . '">Install WooCommerce</a></p>';
        echo '</div>';
    }
}
add_action( 'admin_notices', 'elena_admin_notice' );

/**
 * Language helpers (prefer xili-language / Polylang when available).
 */
function elena_is_xili_active() {
    return function_exists( 'xili_curlang' ) || function_exists( 'the_curlang' );
}

function elena_is_polylang_active() {
    return function_exists( 'pll_current_language' ) || defined( 'POLYLANG_VERSION' );
}

function elena_is_multilang_plugin_active() {
    return elena_is_xili_active() || elena_is_polylang_active();
}

function elena_current_lang_slug() {
    if ( isset( $_GET['lang'] ) ) {
        return strtolower( sanitize_text_field( wp_unslash( $_GET['lang'] ) ) );
    }
    if ( function_exists( 'pll_current_language' ) ) {
        $pll = pll_current_language( 'slug' );
        if ( ! empty( $pll ) ) {
            return strtolower( (string) $pll );
        }
    }
    if ( function_exists( 'xili_curlang' ) ) {
        return strtolower( (string) xili_curlang() );
    }
    if ( function_exists( 'the_curlang' ) ) {
        return strtolower( (string) the_curlang() );
    }
    return strtolower( (string) get_locale() );
}

function elena_is_arabic() {
    return strpos( elena_current_lang_slug(), 'ar' ) === 0;
}

/**
 * Arabic string map — applied via `gettext` filter for WooCommerce + WP core strings,
 * and callable directly as `elena_ar( 'Add to cart' )` for theme template strings.
 */
function elena_ar_map() {
    static $map = null;
    if ( $map !== null ) {
        return $map;
    }
    $map = array(
        // Shop page / product archive
        'Shop'                                 => 'المتجر',
        'Boutique'                             => 'المتجر',
        'Products'                             => 'المنتجات',
        'All products'                         => 'كل المنتجات',
        'Sale'                                 => 'تخفيضات',
        'New'                                  => 'جديد',
        'NEW'                                  => 'جديد',
        'On sale'                              => 'في التخفيض',

        // Sorting
        'Default sorting'                      => 'الترتيب الافتراضي',
        'Sort by popularity'                   => 'الترتيب حسب الشعبية',
        'Sort by average rating'               => 'الترتيب حسب التقييم',
        'Sort by latest'                       => 'الترتيب حسب الأحدث',
        'Sort by price: low to high'           => 'السعر: من الأقل إلى الأعلى',
        'Sort by price: high to low'           => 'السعر: من الأعلى إلى الأقل',
        'Shop order'                           => 'ترتيب المتجر',

        // Result count
        'Showing all %d result'                => 'عرض %d نتيجة',
        'Showing all %d results'               => 'عرض جميع %d نتائج',
        'Showing the single result'            => 'عرض النتيجة الوحيدة',
        'Showing %1$d&ndash;%2$d of %3$d results' => 'عرض %1$d–%2$d من أصل %3$d نتيجة',

        // Add to cart / product buttons
        'Add to cart'                          => 'أضف إلى السلة',
        'Add to basket'                        => 'أضف إلى السلة',
        'AJOUTER AU PANIER'                    => 'أضف إلى السلة',
        'Read more'                            => 'اقرأ المزيد',
        'Select options'                       => 'اختر الخيارات',
        'View cart'                            => 'عرض السلة',
        'Buy now'                              => 'اشتري الآن',
        'BUY NOW'                              => 'اشتري الآن',
        'View products'                        => 'عرض المنتجات',
        'In stock'                             => 'متوفر',
        'Out of stock'                         => 'غير متوفر',
        'En stock'                             => 'متوفر',
        'Rupture de stock'                     => 'غير متوفر',

        // Product page
        'Description'                          => 'الوصف',
        'Reviews'                              => 'التقييمات',
        'Additional information'               => 'معلومات إضافية',
        'Related products'                     => 'منتجات ذات صلة',
        'Size guide'                           => 'دليل المقاسات',
        'Add to wishlist'                      => 'أضف إلى المفضلة',
        'Size:'                                => 'المقاس:',
        'Color:'                               => 'اللون:',
        'Quantity'                             => 'الكمية',
        'Please select a size before adding to cart.' => 'يرجى اختيار مقاس قبل الإضافة إلى السلة.',

        // Cart / checkout snippets
        'Cart'                                 => 'السلة',
        'Checkout'                             => 'الدفع',
        'My account'                           => 'حسابي',
        'Login'                                => 'تسجيل الدخول',
        'Account'                              => 'الحساب',
        'Wishlist'                             => 'المفضلة',

        // Header topbar
        'Livraison 20 DH partout au Maroc'     => 'التوصيل 20 درهم في جميع أنحاء المغرب',
        'Contactez-Nous:'                      => 'اتصل بنا:',

        // Footer menu / generic
        'Search'                               => 'بحث',
        'Home'                                 => 'الرئيسية',
        'Menu'                                 => 'القائمة',
        'No products were found matching your selection.' => 'لم يتم العثور على منتجات تطابق اختيارك.',

        // Cart page
        'Product'                              => 'المنتج',
        'Price'                                => 'السعر',
        'Subtotal'                             => 'المجموع الفرعي',
        'Total'                                => 'الإجمالي',
        'Cart totals'                          => 'إجماليات السلة',
        'Update cart'                          => 'تحديث السلة',
        'Remove this item'                     => 'إزالة هذا المنتج',
        'Apply coupon'                         => 'تطبيق الكوبون',
        'Coupon code'                          => 'رمز الكوبون',
        'Coupon:'                              => 'الكوبون:',
        'Proceed to checkout'                  => 'المتابعة إلى الدفع',
        'Continue shopping'                    => 'متابعة التسوق',
        'Your cart is currently empty.'        => 'سلة التسوق فارغة حاليًا.',
        'Return to shop'                       => 'العودة إلى المتجر',
        'Calculate shipping'                   => 'احتساب الشحن',
        'Shipping'                             => 'الشحن',
        'Free shipping'                        => 'شحن مجاني',
        'Flat rate'                            => 'سعر ثابت',
        'Local pickup'                         => 'استلام محلي',
        'Free'                                 => 'مجاني',

        // Checkout page – sections
        'Checkout'                             => 'الدفع',
        'Billing details'                      => 'تفاصيل الفوترة',
        'Billing &amp; Shipping'               => 'الفوترة والشحن',
        'Shipping details'                     => 'تفاصيل الشحن',
        'Ship to a different address?'         => 'الشحن إلى عنوان مختلف؟',
        'Additional information'               => 'معلومات إضافية',
        'Your order'                           => 'طلبك',
        'Returning customer?'                  => 'عميل سابق؟',
        'Click here to login'                  => 'انقر هنا لتسجيل الدخول',
        'Have a coupon?'                       => 'هل لديك كوبون؟',
        'Click here to enter your code'        => 'انقر هنا لإدخال رمزك',
        'If you have shopped with us before, please enter your details below. If you are a new customer, please proceed to the Billing section.' => 'إذا سبق لك التسوق معنا، يرجى إدخال بياناتك أدناه. إذا كنت عميلًا جديدًا، يرجى المتابعة إلى قسم الفوترة.',
        'If you have a coupon code, please apply it below.' => 'إذا كان لديك رمز كوبون، يرجى تطبيقه أدناه.',

        // Checkout fields
        'First name'                           => 'الاسم الأول',
        'Last name'                            => 'اللقب',
        'Company name'                         => 'اسم الشركة',
        'Country / Region'                     => 'البلد / المنطقة',
        'Street address'                       => 'عنوان الشارع',
        'House number and street name'         => 'رقم المنزل واسم الشارع',
        'Apartment, suite, unit, etc. (optional)' => 'شقة، جناح، وحدة، إلخ. (اختياري)',
        'Town / City'                          => 'المدينة',
        'State / County'                       => 'الولاية / المقاطعة',
        'Postcode / ZIP'                       => 'الرمز البريدي',
        'Phone'                                => 'الهاتف',
        'Email address'                        => 'البريد الإلكتروني',
        'Order notes (optional)'               => 'ملاحظات الطلب (اختياري)',
        'Notes about your order, e.g. special notes for delivery.' => 'ملاحظات حول طلبك، مثل تعليمات خاصة للتسليم.',
        'Create an account?'                   => 'إنشاء حساب؟',
        'Create account password'              => 'كلمة مرور الحساب',
        'Username'                             => 'اسم المستخدم',
        'Password'                             => 'كلمة المرور',
        'Remember me'                          => 'تذكرني',
        'Log in'                               => 'تسجيل الدخول',
        'Lost your password?'                  => 'نسيت كلمة المرور؟',

        // Order summary
        'Subtotal:'                            => 'المجموع الفرعي:',
        'Shipping:'                            => 'الشحن:',
        'Total:'                               => 'الإجمالي:',
        'Product Subtotal:'                    => 'مجموع المنتج:',

        // Payment
        'Payment'                              => 'الدفع',
        'Payment method'                       => 'طريقة الدفع',
        'Direct bank transfer'                 => 'التحويل المصرفي المباشر',
        'Cash on delivery'                     => 'الدفع عند الاستلام',
        'Pay with cash upon delivery.'         => 'ادفع نقدًا عند الاستلام.',
        'Check payments'                       => 'الدفع بشيك',
        'Place order'                          => 'تأكيد الطلب',
        'I have read and agree to the website' => 'لقد قرأت وأوافق على',
        'terms and conditions'                 => 'الشروط والأحكام',
        'Your personal data will be used to process your order, support your experience throughout this website, and for other purposes described in our %s.' => 'ستُستخدم بياناتك الشخصية لمعالجة طلبك ودعم تجربتك عبر هذا الموقع وللأغراض الأخرى الموضحة في %s.',
        'privacy policy'                       => 'سياسة الخصوصية',

        // Order received / thank-you
        'Thank you. Your order has been received.' => 'شكرًا لك. لقد تم استلام طلبك.',
        'Order number:'                        => 'رقم الطلب:',
        'Date:'                                => 'التاريخ:',
        'Payment method:'                      => 'طريقة الدفع:',
        'Order details'                        => 'تفاصيل الطلب',
        'Billing address'                      => 'عنوان الفوترة',
        'Shipping address'                     => 'عنوان الشحن',
        'Order again'                          => 'إعادة الطلب',

        // Notices / validation
        'Please enter a valid email address.' => 'يرجى إدخال بريد إلكتروني صحيح.',
        'is a required field.'                => 'حقل مطلوب.',
        'Billing First name is a required field.' => 'الاسم الأول في الفوترة حقل مطلوب.',
        'Billing Last name is a required field.'  => 'اللقب في الفوترة حقل مطلوب.',
        'Billing Phone is a required field.'     => 'رقم الهاتف في الفوترة حقل مطلوب.',
        'Billing Email address is a required field.' => 'البريد الإلكتروني في الفوترة حقل مطلوب.',
        'Select a country / region&hellip;'    => 'اختر البلد / المنطقة…',
        'Select an option&hellip;'             => 'اختر خيارًا…',

        // My account
        'Dashboard'                            => 'لوحة التحكم',
        'Orders'                               => 'الطلبات',
        'Downloads'                            => 'التنزيلات',
        'Addresses'                            => 'العناوين',
        'Account details'                      => 'تفاصيل الحساب',
        'Logout'                               => 'تسجيل الخروج',
    );
    return $map;
}

function elena_ar( $text ) {
    if ( ! elena_is_arabic() ) {
        return $text;
    }
    $map = elena_ar_map();
    return isset( $map[ $text ] ) ? $map[ $text ] : $text;
}

add_filter( 'gettext', 'elena_ar_gettext_filter', 20, 3 );
add_filter( 'gettext_with_context', 'elena_ar_gettext_ctx_filter', 20, 4 );

function elena_ar_gettext_filter( $translated, $text, $domain ) {
    if ( is_admin() || ! elena_is_arabic() ) {
        return $translated;
    }
    $map = elena_ar_map();
    return isset( $map[ $text ] ) ? $map[ $text ] : $translated;
}

function elena_ar_gettext_ctx_filter( $translated, $text, $context, $domain ) {
    if ( is_admin() || ! elena_is_arabic() ) {
        return $translated;
    }
    $map = elena_ar_map();
    return isset( $map[ $text ] ) ? $map[ $text ] : $translated;
}

// Override the archive page title ("Shop") in Arabic.
add_filter( 'woocommerce_page_title', function( $title ) {
    if ( elena_is_arabic() ) {
        return elena_ar( $title );
    }
    return $title;
} );

/**
 * Render a list of language switcher links.
 * Prefers Polylang (pll_the_languages). Falls back to xili, then to hardcoded links.
 *
 * @param string $variant 'desktop' or 'mobile'. Controls the output class / label style.
 */
function elena_render_language_switcher( $variant = 'desktop' ) {
    $is_mobile = ( $variant === 'mobile' );
    $container_class = $is_mobile ? 'elena-mobile-lang-flags' : 'elena-header-lang-flags';

    // Polylang — preferred when active.
    if ( function_exists( 'pll_the_languages' ) ) {
        $languages = pll_the_languages( array(
            'raw'           => 1,
            'hide_if_empty' => 0,
            'display_names_as' => 'slug',
        ) );
        if ( ! empty( $languages ) ) {
            foreach ( $languages as $lang ) {
                $slug    = isset( $lang['slug'] ) ? $lang['slug'] : '';
                $locale  = isset( $lang['locale'] ) ? $lang['locale'] : $slug;
                $name    = isset( $lang['name'] ) ? $lang['name'] : strtoupper( $slug );
                $url     = isset( $lang['url'] ) ? $lang['url'] : home_url( '/' );
                $current = ! empty( $lang['current_lang'] );
                $classes = 'lang-' . strtolower( str_replace( '-', '_', $locale ) ) . ' lang-' . $slug;
                if ( $current ) $classes .= ' current-lang';
                printf(
                    '<a class="%1$s" href="%2$s" title="%3$s"><span>%4$s</span></a>',
                    esc_attr( $classes ),
                    esc_url( $url ),
                    esc_attr( $name ),
                    esc_html( strtoupper( $slug ) )
                );
            }
            return;
        }
    }

    // xili-language fallback.
    if ( ! $is_mobile && function_exists( 'xili_language_list' ) ) {
        xili_language_list();
        return;
    }

    // Hardcoded fallback (no multilang plugin).
    $base = home_url( '/' );
    $items = array(
        'fr_fr' => __( 'Français', 'elena' ),
        'en_us' => __( 'English', 'elena' ),
        'ar_ar' => __( 'Arabic', 'elena' ),
    );
    foreach ( $items as $code => $label ) {
        printf(
            '<a class="lang-%1$s" href="%2$s" title="%3$s"><span>%4$s</span></a>',
            esc_attr( $code ),
            esc_url( add_query_arg( 'lang', $code, $base ) ),
            esc_attr( $label ),
            esc_html( strtoupper( substr( $code, 0, 2 ) ) )
        );
    }
}


/* ─────────────────────────────────────────────
 * 11. Product Page – Matching machaussure.ma reference
 * ───────────────────────────────────────────── */

// Change "Add to Cart" button text to "AJOUTER AU PANIER"
add_filter( 'woocommerce_product_single_add_to_cart_text', 'elena_custom_cart_button_text' );
function elena_custom_cart_button_text() {
    $loc = elena_current_lang_slug();
    return (strpos($loc, 'ar') === 0) ? 'أضف إلى السلة' : __( 'AJOUTER AU PANIER', 'elena' );
}

// Add Buy Now button after the cart form
add_action( 'woocommerce_after_add_to_cart_button', 'masha_add_buy_now_button' );
function masha_add_buy_now_button() {
    global $product;
    $loc = elena_current_lang_slug();
    if ( strpos( $loc, 'ar' ) === 0 ) {
        $text = 'اشتري الآن';
    } elseif ( strpos( $loc, 'fr' ) === 0 ) {
        $text = 'ACHETER MAINTENANT';
    } else {
        $text = 'BUY NOW';
    }
    echo '<button type="submit" name="masha-buy-now" value="1" class="masha-buy-now-btn button alt">' . esc_html($text) . '</button>';
}

// Add wishlist & size guide links after add to cart form
add_action( 'woocommerce_after_add_to_cart_form', 'masha_add_extra_links', 5 );
function masha_add_extra_links() {
    $loc = elena_current_lang_slug();
    $wishlist = (strpos($loc, 'ar') === 0) ? 'أضف إلى المفضلة' : 'Add to wishlist';
    $size = (strpos($loc, 'ar') === 0) ? 'دليل المقاسات' : 'Size guide';
    echo '<div class="masha-product-extras">';
    echo '<a href="#"><span>♡</span> ' . esc_html($wishlist) . '</a>';
    echo '<a href="#"><span>📏</span> ' . esc_html($size) . '</a>';
    echo '</div>';
}

// Show stock status before add to cart
add_action( 'woocommerce_before_add_to_cart_form', 'masha_show_stock_status', 10 );
function masha_show_stock_status() {
    global $product;
    $loc = elena_current_lang_slug();
    if ( $product->is_in_stock() ) {
        $text = (strpos($loc, 'ar') === 0) ? 'مخزون متوفر' : 'En stock';
        echo '<p class="stock in-stock">' . esc_html($text) . '</p>';
    } else {
        $text = (strpos($loc, 'ar') === 0) ? 'غير متوفر' : 'Rupture de stock';
        echo '<p class="stock out-of-stock">' . esc_html($text) . '</p>';
    }
}

// Handle Buy Now redirect
add_filter( 'woocommerce_add_to_cart_redirect', 'masha_buy_now_redirect', 99 );
function masha_buy_now_redirect( $url ) {
    if ( isset( $_POST['masha-buy-now'] ) ) {
        return elena_checkout_url_for_current_lang();
    }
    return $url;
}

/**
 * Fallback: force Buy Now requests to checkout in case
 * another plugin/theme callback overrides add_to_cart redirect.
 */
add_action( 'template_redirect', 'masha_buy_now_checkout_fallback', 999 );
function masha_buy_now_checkout_fallback() {
    if ( is_admin() || wp_doing_ajax() || empty( $_REQUEST['masha-buy-now'] ) ) {
        return;
    }

    wp_safe_redirect( elena_checkout_url_for_current_lang() );
    exit;
}

/**
 * Return the checkout URL matching the current front-end language.
 * Falls back to wc_get_checkout_url() when no language-specific page exists.
 */
function elena_checkout_url_for_current_lang() {
    $loc = function_exists( 'elena_current_lang_slug' ) ? elena_current_lang_slug() : '';

    if ( strpos( $loc, 'ar' ) === 0 ) {
        // 1) Prefer the Polylang Arabic translation of the configured WC checkout page.
        if ( function_exists( 'pll_get_post' ) && function_exists( 'wc_get_page_id' ) ) {
            $base_id = wc_get_page_id( 'checkout' );
            if ( $base_id > 0 ) {
                $ar_id = pll_get_post( $base_id, 'ar' );
                if ( $ar_id && 'publish' === get_post_status( $ar_id ) ) {
                    return get_permalink( $ar_id );
                }
            }
        }

        // 2) Fallback: find any page using the Arabic checkout template,
        //    preferring the newest one whose slug isn't an auto-generated "sample-page".
        $ar_url = elena_find_page_by_template( 'template-checkout-ar.php' );
        if ( $ar_url ) {
            return $ar_url;
        }
    }

    return wc_get_checkout_url();
}

/**
 * Find the permalink of a published page that uses a given page template file.
 * Excludes WordPress's auto-generated "sample-page" stubs. Most recent wins.
 * Result is cached per-request.
 */
function elena_find_page_by_template( $template_slug ) {
    static $cache = array();
    if ( isset( $cache[ $template_slug ] ) ) {
        return $cache[ $template_slug ];
    }

    $pages = get_posts( array(
        'post_type'        => 'page',
        'post_status'      => 'publish',
        'posts_per_page'   => 20,
        'fields'           => 'ids',
        'orderby'          => 'date',
        'order'            => 'DESC',
        'meta_key'         => '_wp_page_template',
        'meta_value'       => $template_slug,
        'suppress_filters' => false,
    ) );

    $chosen = 0;
    foreach ( $pages as $pid ) {
        $slug = get_post_field( 'post_name', $pid );
        if ( 0 === strpos( $slug, 'sample-page' ) ) {
            continue; // skip WP's default test page even if it has the template
        }
        $chosen = $pid;
        break;
    }

    // If only sample-page matches were found, take the newest anyway.
    if ( ! $chosen && ! empty( $pages ) ) {
        $chosen = $pages[0];
    }

    $cache[ $template_slug ] = $chosen ? get_permalink( $chosen ) : '';
    return $cache[ $template_slug ];
}

// Add quantity +/- buttons
add_action( 'woocommerce_before_quantity_input_field', 'masha_quantity_minus_btn' );
function masha_quantity_minus_btn() {
    echo '<button type="button" class="masha-qty-btn masha-qty-minus" aria-label="Decrease quantity">-</button>';
}

add_action( 'woocommerce_after_quantity_input_field', 'masha_quantity_plus_btn' );
function masha_quantity_plus_btn() {
    echo '<button type="button" class="masha-qty-btn masha-qty-plus" aria-label="Increase quantity">+</button>';
}

// Add "Livraison" tab to product tabs
add_filter( 'woocommerce_product_tabs', 'masha_add_livraison_tab' );
function masha_add_livraison_tab( $tabs ) {
    $loc = elena_current_lang_slug();
    $tabs['livraison'] = array(
        'title'    => (strpos($loc, 'ar') === 0) ? 'التوصيل' : __( 'Livraison', 'elena' ),
        'priority' => 40,
        'callback' => 'masha_livraison_tab_content',
    );
    return $tabs;
}

function masha_livraison_tab_content() {
    $loc = elena_current_lang_slug();
    if ( strpos($loc, 'ar') === 0 ) {
        echo '<h2>التوصيل</h2>';
        echo '<p><strong>توصيل لجميع أنحاء المغرب</strong> – رسوم التوصيل: 20 درهم</p>';
        echo '<p>مدة التوصيل: من 24 إلى 48 ساعة حسب المدن.</p>';
        echo '<p>الدفع عند الاستلام متاح.</p>';
    } else {
        echo '<h2>Livraison</h2>';
        echo '<p><strong>Livraison partout au Maroc</strong> – Frais de livraison : 20 DH</p>';
        echo '<p>Délai de livraison : 24h à 48h selon les villes.</p>';
        echo '<p>Paiement à la livraison disponible.</p>';
    }
}

/**
 * Checkout translations (FR/AR) based on current language.
 */
add_filter( 'woocommerce_order_button_text', 'elena_checkout_order_button_text' );
function elena_checkout_order_button_text( $text ) {
    $loc = elena_current_lang_slug();
    if ( strpos( $loc, 'ar' ) === 0 ) {
        return 'تأكيد الطلب';
    }
    if ( strpos( $loc, 'fr' ) === 0 ) {
        return 'Valider la commande';
    }
    return $text;
}

add_filter( 'gettext', 'elena_translate_checkout_strings', 20, 3 );
function elena_translate_checkout_strings( $translated, $original, $domain ) {
    if ( ! function_exists( 'is_checkout' ) || ! is_checkout() ) {
        return $translated;
    }

    if ( 'woocommerce' !== $domain ) {
        return $translated;
    }

    $loc = elena_current_lang_slug();
    $map = array();

    if ( strpos( $loc, 'ar' ) === 0 ) {
        $map = array(
            'Checkout' => 'إتمام الطلب',
            'Billing details' => 'بيانات الفوترة',
            'Additional information' => 'معلومات إضافية',
            'Your order' => 'طلبك',
            'Place order' => 'تأكيد الطلب',
            'First name' => 'الاسم الشخصي',
            'Last name' => 'الاسم العائلي',
            'Company name (optional)' => 'اسم الشركة (اختياري)',
            'Country / Region' => 'الدولة / المنطقة',
            'Street address' => 'العنوان',
            'Town / City' => 'المدينة',
            'State / County' => 'الجهة / الإقليم',
            'Postcode / ZIP' => 'الرمز البريدي',
            'Phone' => 'الهاتف',
            'Email address' => 'البريد الإلكتروني',
            'Order notes (optional)' => 'ملاحظات الطلب (اختياري)',
        );
    } elseif ( strpos( $loc, 'fr' ) === 0 ) {
        $map = array(
            'Checkout' => 'Commander',
            'Billing details' => 'Détails de facturation',
            'Additional information' => 'Informations complémentaires',
            'Your order' => 'Votre commande',
            'Place order' => 'Valider la commande',
            'First name' => 'Prénom',
            'Last name' => 'Nom',
            'Company name (optional)' => 'Nom de société (optionnel)',
            'Country / Region' => 'Pays / Région',
            'Street address' => 'Adresse',
            'Town / City' => 'Ville',
            'State / County' => 'État / Province',
            'Postcode / ZIP' => 'Code postal',
            'Phone' => 'Téléphone',
            'Email address' => 'Adresse e-mail',
            'Order notes (optional)' => 'Notes de commande (optionnel)',
        );
    }

    if ( isset( $map[ $original ] ) ) {
        return $map[ $original ];
    }

    return $translated;
}

// Remove default WooCommerce breadcrumbs (we handle them in the template)
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

/**
 * Add Language Selection to Categories and Product Categories
 */
add_action( 'init', 'elena_add_taxonomy_language_fields' );
function elena_add_taxonomy_language_fields() {
$taxonomies = array( 'category', 'product_cat' );
foreach ( $taxonomies as $taxonomy ) {
    add_action( $taxonomy . "_add_form_fields", 'elena_add_category_language_field', 10, 1 );
    add_action( $taxonomy . "_edit_form_fields", 'elena_edit_category_language_field', 10, 2 );
    add_action( "created_" . $taxonomy, 'elena_save_category_language_field', 10, 2 );
    add_action( "edited_" . $taxonomy, 'elena_save_category_language_field', 10, 2 );
}
}

function elena_add_category_language_field( $taxonomy ) {
    ?>
    <div class="form-field term-language-wrap">
        <label for="category_language"><?php esc_html_e( 'Language', 'elena' ); ?></label>
        <select name="category_language" id="category_language">
            <option value="all"><?php esc_html_e( 'All Languages', 'elena' ); ?></option>
            <option value="ar">Arabic</option>
            <option value="fr">French</option>
            <option value="en">English</option>
        </select>
        <p><?php esc_html_e( 'Select the language this category applies to.', 'elena' ); ?></p>
    </div>
    <?php
}

function elena_edit_category_language_field( $term, $taxonomy ) {
    $lang = get_term_meta( $term->term_id, 'category_language', true );
    if ( empty( $lang ) ) $lang = 'all';
    ?>
    <tr class="form-field term-language-wrap">
        <th scope="row"><label for="category_language"><?php esc_html_e( 'Language', 'elena' ); ?></label></th>
        <td>
            <select name="category_language" id="category_language">
                <option value="all" <?php selected( $lang, 'all' ); ?>><?php esc_html_e( 'All Languages', 'elena' ); ?></option>
                <option value="ar" <?php selected( $lang, 'ar' ); ?>>Arabic</option>
                <option value="fr" <?php selected( $lang, 'fr' ); ?>>French</option>
                <option value="en" <?php selected( $lang, 'en' ); ?>>English</option>
            </select>
            <p class="description"><?php esc_html_e( 'Select the language this category applies to.', 'elena' ); ?></p>
        </td>
    </tr>
    <?php
}

function elena_save_category_language_field( $term_id, $tt_id ) {
    if ( isset( $_POST['category_language'] ) ) {
        update_term_meta( $term_id, 'category_language', sanitize_text_field( $_POST['category_language'] ) );
    }
}


/* ─────────────────────────────────────────────
 * 12. Clean Language Management
 * ───────────────────────────────────────────── */

/**
 * 12. Clean Language Management
 * ───────────────────────────────────────────── */

/**
 * Early force lang=ar internally if the URL is Arabic but parameter is missing.
 * We use both %D8/%D9 detection and UTF-8 regex for robustness.
 */
add_action( 'init', 'elena_force_lang_internal', 1 );
function elena_force_lang_internal() {
    if ( elena_is_multilang_plugin_active() ) return;
    if ( is_admin() ) return;
    
    $uri = $_SERVER['REQUEST_URI'];
    $is_arabic = ( strpos( $uri, '%D8' ) !== false || strpos( $uri, '%D9' ) !== false );
    
    if ( ! $is_arabic ) {
        $decoded_uri = urldecode( $uri );
        $is_arabic = preg_match( '/[\x{0600}-\x{06FF}]/u', $decoded_uri );
    }

    if ( $is_arabic ) {
        if ( ! isset( $_GET['lang'] ) ) {
            $_GET['lang'] = 'ar';
        }
        // Force the locale immediately
        add_filter( 'locale', function() { return 'ar_AR'; }, 99 );
    }

    // Check cookie for persistence if no param is set in the REAL query string
    if ( ! isset( $_GET['lang'] ) && isset( $_COOKIE['elena_lang'] ) ) {
        $cookie_lang = sanitize_text_field( $_COOKIE['elena_lang'] );
        if ( $cookie_lang === 'ar' ) {
            $_GET['lang'] = 'ar';
            add_filter( 'locale', function() { return 'ar_AR'; }, 99 );
        }
    }
}

/**
 * Detect and force locale based on URI or parameter or cookie.
 */
add_filter( 'locale', 'elena_detect_and_force_locale', 20 );
function elena_detect_and_force_locale( $locale ) {
    // Defensive: never propagate a null/empty locale — WP >= 6.5 errors if set_locale() receives null.
    // This can happen when Polylang is active but not yet configured (curlang->locale is null).
    if ( ! is_string( $locale ) || $locale === '' ) {
        $locale = 'fr_FR';
    }

    if ( elena_is_multilang_plugin_active() ) return $locale;
    if ( is_admin() ) return $locale;

    // 1. Explicit parameter takes priority
    if ( isset( $_GET['lang'] ) ) {
        $l = strtolower( sanitize_text_field( $_GET['lang'] ) );
        if ( strpos( $l, 'ar' ) === 0 ) return 'ar_AR';
        if ( strpos( $l, 'fr' ) === 0 ) return 'fr_FR';
    }

    // 2. Auto-detect from URI
    $uri = $_SERVER['REQUEST_URI'];
    if ( strpos( $uri, '%D8' ) !== false || strpos( $uri, '%D9' ) !== false || preg_match( '/[\x{0600}-\x{06FF}]/u', urldecode( $uri ) ) ) {
        return 'ar_AR';
    }

    // 3. Cookie persistence
    if ( isset( $_COOKIE['elena_lang'] ) ) {
        $cookie_lang = sanitize_text_field( $_COOKIE['elena_lang'] );
        if ( $cookie_lang === 'ar' ) return 'ar_AR';
        if ( $cookie_lang === 'fr' ) return 'fr_FR';
    }

    return $locale;
}

/**
 * Clean up URLs: Redirect ?lang=ar_ar to clean URL if possible.
 */
add_action( 'template_redirect', 'elena_clean_language_urls', 1 );
function elena_clean_language_urls() {
    if ( elena_is_multilang_plugin_active() ) return;
    if ( is_admin() ) return;

    // We check $_SERVER['QUERY_STRING'] to see if it was in the ACTUAL URL
    if ( isset( $_GET['lang'] ) && strpos( $_SERVER['QUERY_STRING'], 'lang=' ) !== false ) {
        $lang = strtolower( sanitize_text_field( $_GET['lang'] ) );
        
        if ( strpos( $lang, 'ar' ) === 0 ) {
            // Set cookie for persistence
            setcookie( 'elena_lang', 'ar', time() + ( 86400 * 30 ), '/' );
            
            // Redirect to clean URL
            $url = remove_query_arg( 'lang' );
            $current_url = ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            if ( $url && untrailingslashit( $url ) !== untrailingslashit( $current_url ) ) {
                wp_redirect( $url, 301 );
                exit;
            }
        } elseif ( strpos( $lang, 'fr' ) === 0 ) {
            setcookie( 'elena_lang', 'fr', time() + ( 86400 * 30 ), '/' );
            // Keep FR links stable to avoid redirect loops with URL language filters.
            return;
        }
    }
}

/**
 * Adjust term links: Don't add ?lang=ar if the content is Arabic or cookie is set.
 */
add_filter( 'term_link', 'elena_adjust_category_link_language', 10, 3 );
function elena_adjust_category_link_language( $termlink, $term, $taxonomy ) {
    if ( elena_is_multilang_plugin_active() ) return $termlink;
    if ( is_admin() ) return $termlink;
    
    if ( $taxonomy === 'product_cat' || $taxonomy === 'category' ) {
        $term_id = is_object( $term ) ? $term->term_id : $term;
        $lang = get_term_meta( $term_id, 'category_language', true );
        
        if ( ! empty( $lang ) && $lang !== 'all' ) {
            if ( $lang === 'ar' ) {
                return remove_query_arg( 'lang', $termlink );
            }
            return add_query_arg( 'lang', $lang, $termlink );
        }
        
        // If current language is Arabic (via cookie or param), keep links clean
        $current_lang = '';
        if ( isset( $_GET['lang'] ) ) $current_lang = $_GET['lang'];
        elseif ( isset( $_COOKIE['elena_lang'] ) ) $current_lang = $_COOKIE['elena_lang'];

        if ( strpos( $current_lang, 'ar' ) !== false ) {
             return remove_query_arg( 'lang', $termlink );
        }
        
        if ( ! empty( $current_lang ) ) {
            return add_query_arg( 'lang', $current_lang, $termlink );
        }
    }
    return $termlink;
}

/**
 * Adjust product links: Ensure Arabic products have clean URLs.
 */
add_filter( 'post_type_link', 'elena_adjust_product_link_language', 20, 2 );
function elena_adjust_product_link_language( $post_link, $post ) {
    if ( elena_is_multilang_plugin_active() ) return $post_link;
    if ( is_admin() || $post->post_type !== 'product' ) return $post_link;
    
    if ( preg_match( '/[\x{0600}-\x{06FF}]/u', urldecode( $post->post_name ) ) ) {
        return remove_query_arg( 'lang', $post_link );
    }
    
    $current_lang = '';
    if ( isset( $_GET['lang'] ) ) $current_lang = $_GET['lang'];
    elseif ( isset( $_COOKIE['elena_lang'] ) ) $current_lang = $_COOKIE['elena_lang'];

    if ( strpos( $current_lang, 'ar' ) !== false ) {
         return remove_query_arg( 'lang', $post_link );
    }
    
    if ( ! empty( $current_lang ) && strpos( $current_lang, 'fr' ) !== false ) {
        return add_query_arg( 'lang', $current_lang, $post_link );
    }
    
    return $post_link;
}

/**
 * Preserve language parameter for home URL and pages, except for Arabic.
 */
add_filter( 'home_url', 'elena_preserve_links_lang_conditional', 10, 2 );
add_filter( 'page_link', 'elena_preserve_links_lang_conditional', 10, 2 );
function elena_preserve_links_lang_conditional( $url, $path_or_id = 0 ) {
    if ( elena_is_multilang_plugin_active() ) return $url;
    if ( is_admin() ) return $url;
    
    $current_lang = '';
    if ( isset( $_GET['lang'] ) ) $current_lang = $_GET['lang'];
    elseif ( isset( $_COOKIE['elena_lang'] ) ) $current_lang = $_COOKIE['elena_lang'];

    if ( ! empty( $current_lang ) && strpos( $current_lang, 'ar' ) === false ) {
        return add_query_arg( 'lang', $current_lang, $url );
    }
    return $url;
}






/**
 * Ensure all nav menu items have the expected properties to avoid "Undefined property" warnings.
 * This covers cases where dummy or virtual items are injected by plugins.
 */
add_filter( 'wp_setup_nav_menu_item', 'elena_ensure_nav_menu_item_properties' );
function elena_ensure_nav_menu_item_properties( $item ) {
    if ( is_object( $item ) ) {
        if ( ! isset( $item->current ) ) {
            $item->current = false;
        }
        if ( ! isset( $item->current_item_ancestor ) ) {
            $item->current_item_ancestor = false;
        }
        if ( ! isset( $item->current_item_parent ) ) {
            $item->current_item_parent = false;
        }
    }
    return $item;
}

/**
 * Late-stage fix for missing properties in nav menu items.
 * Some items (like those from xili-language) may bypass the setup filter.
 */
add_filter( 'nav_menu_item_args', 'elena_fix_item_properties_late', 10, 3 );
function elena_fix_item_properties_late( $args, $item, $depth ) {
    if ( is_object( $item ) && ! isset( $item->current ) ) {
        $item->current = false;
    }
    return $args;
}

/**
 * Normalize language slugs for matching.
 */
function elena_normalize_lang_slug( $lang ) {
    $lang = strtolower( (string) $lang );
    $map = array(
        'fr'    => 'fr_fr',
        'fr-fr' => 'fr_fr',
        'en'    => 'en_us',
        'en-us' => 'en_us',
        'ar'    => 'ar_ar',
        'ar-ma' => 'ar_ar',
    );
    return isset( $map[ $lang ] ) ? $map[ $lang ] : str_replace( '-', '_', $lang );
}

/**
 * Render "menu language" option in Appearance > Menus.
 */
function elena_render_menu_language_setting_notice() {
    if ( ! is_admin() || ! current_user_can( 'edit_theme_options' ) ) {
        return;
    }
    $screen = get_current_screen();
    if ( ! $screen || 'nav-menus' !== $screen->id ) {
        return;
    }

    $menu_id = isset( $_GET['menu'] ) ? absint( $_GET['menu'] ) : 0;
    if ( ! $menu_id ) {
        return;
    }

    $menu = wp_get_nav_menu_object( $menu_id );
    if ( ! $menu || is_wp_error( $menu ) ) {
        return;
    }

    $current = get_term_meta( $menu_id, 'elena_menu_lang', true );
    $langs = array(
        'fr_fr' => 'French (fr_fr)',
        'en_us' => 'English (en_us)',
        'ar_ar' => 'Arabic (ar_ar)',
    );
    ?>
    <div class="notice notice-info" style="padding:12px 16px;">
        <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
            <?php wp_nonce_field( 'elena_save_menu_lang_' . $menu_id ); ?>
            <input type="hidden" name="action" value="elena_save_menu_lang" />
            <input type="hidden" name="menu_id" value="<?php echo esc_attr( $menu_id ); ?>" />
            <strong><?php esc_html_e( 'Menu language', 'elena' ); ?>:</strong>
            <select name="elena_menu_lang">
                <option value=""><?php esc_html_e( 'Not specified', 'elena' ); ?></option>
                <?php foreach ( $langs as $slug => $label ) : ?>
                    <option value="<?php echo esc_attr( $slug ); ?>" <?php selected( $current, $slug ); ?>><?php echo esc_html( $label ); ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="button button-primary"><?php esc_html_e( 'Save menu language', 'elena' ); ?></button>
        </form>
    </div>
    <?php
}
add_action( 'admin_notices', 'elena_render_menu_language_setting_notice' );

/**
 * Save menu language value.
 */
function elena_save_menu_language_setting() {
    if ( ! current_user_can( 'edit_theme_options' ) ) {
        wp_die( esc_html__( 'You are not allowed to do this.', 'elena' ) );
    }

    $menu_id = isset( $_POST['menu_id'] ) ? absint( $_POST['menu_id'] ) : 0;
    if ( ! $menu_id ) {
        wp_safe_redirect( admin_url( 'nav-menus.php' ) );
        exit;
    }

    check_admin_referer( 'elena_save_menu_lang_' . $menu_id );

    $lang = isset( $_POST['elena_menu_lang'] ) ? sanitize_text_field( wp_unslash( $_POST['elena_menu_lang'] ) ) : '';
    if ( '' === $lang ) {
        delete_term_meta( $menu_id, 'elena_menu_lang' );
    } else {
        update_term_meta( $menu_id, 'elena_menu_lang', elena_normalize_lang_slug( $lang ) );
    }

    wp_safe_redirect( admin_url( 'nav-menus.php?action=edit&menu=' . $menu_id . '&elena_menu_lang_saved=1' ) );
    exit;
}
add_action( 'admin_post_elena_save_menu_lang', 'elena_save_menu_language_setting' );

/**
 * Find menu assigned to a specific language via menu meta.
 */
function elena_get_menu_id_by_lang( $lang ) {
    $lang = elena_normalize_lang_slug( $lang );
    if ( ! $lang ) {
        return 0;
    }

    $menus = wp_get_nav_menus();
    if ( empty( $menus ) || is_wp_error( $menus ) ) {
        return 0;
    }

    foreach ( $menus as $menu ) {
        $assigned = get_term_meta( $menu->term_id, 'elena_menu_lang', true );
        if ( $assigned && elena_normalize_lang_slug( $assigned ) === $lang ) {
            return (int) $menu->term_id;
        }
    }

    return 0;
}

/**
 * Prevent plugin/WooCommerce redirects on the Arabic Cart and Checkout page templates.
 * WooCommerce redirects empty-cart visitors away from the checkout, and some Polylang
 * setups redirect unlinked translations — both would make these pages vanish to home.
 */
add_action( 'template_redirect', 'elena_stop_ar_wc_redirects', 1 );
function elena_stop_ar_wc_redirects() {
    if ( ! is_page() ) {
        return;
    }

    $template = get_page_template_slug( get_queried_object_id() );
    if ( 'template-checkout-ar.php' !== $template && 'template-cart-ar.php' !== $template ) {
        return;
    }

    // Stop WooCommerce from redirecting the checkout to cart when the cart is empty.
    add_filter( 'woocommerce_checkout_redirect_empty_cart', '__return_false', 99 );

    // Stop the Polylang "no-translation" redirect (if active).
    add_filter( 'pll_check_canonical_url', '__return_false', 99 );

    // Safeguard: prevent any wp_redirect() that would leave this URL during the render.
    add_filter( 'wp_redirect', 'elena_block_selfpage_redirect', 99, 2 );
}

function elena_block_selfpage_redirect( $location, $status ) {
    // Allow redirects to WooCommerce order-received / order-pay endpoints (legitimate checkout flow).
    if ( strpos( $location, 'order-received' ) !== false || strpos( $location, 'order-pay' ) !== false ) {
        return $location;
    }
    // Block anything else leaving the page during render.
    return false;
}

/**
 * Force Arabic WooCommerce strings on the Arabic cart/checkout templates,
 * regardless of the site's active locale. Keeps the rest of the site unaffected.
 */
function elena_is_ar_wc_template() {
    // Cache once per request, but only after the main query is ready so is_page() works.
    static $active = null;
    if ( null !== $active ) {
        return $active;
    }
    if ( ! did_action( 'wp' ) || ! is_page() ) {
        return false; // don't cache — main query not ready yet
    }
    $tpl = get_page_template_slug( get_queried_object_id() );
    $active = in_array( $tpl, array( 'template-checkout-ar.php', 'template-cart-ar.php' ), true );
    return $active;
}

add_filter( 'gettext', 'elena_ar_wc_strings', 20, 3 );
add_filter( 'gettext_with_context', 'elena_ar_wc_strings_ctx', 20, 4 );

function elena_ar_wc_strings( $translation, $text, $domain ) {
    if ( 'woocommerce' !== $domain ) {
        return $translation;
    }
    if ( ! elena_is_ar_wc_template() ) {
        return $translation;
    }
    $map = elena_ar_wc_string_map();
    return isset( $map[ $text ] ) ? $map[ $text ] : $translation;
}

function elena_ar_wc_strings_ctx( $translation, $text, $context, $domain ) {
    return elena_ar_wc_strings( $translation, $text, $domain );
}

function elena_ar_wc_string_map() {
    return array(
        // Checkout buttons / sections
        'Place order'                       => 'تأكيد الطلب',
        'Your order'                        => 'طلبك',
        'Billing details'                   => 'بيانات الفوترة',
        'Billing &amp; Shipping'            => 'الفوترة والشحن',
        'Additional information'            => 'معلومات إضافية',
        'Order notes'                       => 'ملاحظات الطلب',
        'Order notes (optional)'            => 'ملاحظات الطلب (اختياري)',
        'Notes about your order, e.g. special notes for delivery.' => 'ملاحظات حول طلبك، مثل تعليمات خاصة للتسليم.',

        // Order review table
        'Product'                           => 'المنتج',
        'Subtotal'                          => 'المجموع الفرعي',
        'Total'                             => 'المجموع الكلي',
        'Quantity'                          => 'الكمية',
        'Price'                             => 'السعر',
        'Shipping'                          => 'الشحن',

        // Payment / terms
        'Cash on delivery'                  => 'الدفع عند الاستلام',
        'Pay with cash upon delivery.'      => 'ادفع نقداً عند الاستلام.',
        'Direct bank transfer'              => 'تحويل بنكي مباشر',
        'Check payments'                    => 'الدفع بشيك',
        'I have read and agree to the website %s' => 'لقد قرأت وأوافق على %s الخاصة بالموقع',
        'terms and conditions'              => 'الشروط والأحكام',

        'Your personal data will be used to process your order, support your experience throughout this website, and for other purposes described in our %s.'
            => 'سيتم استخدام بياناتك الشخصية لمعالجة طلبك ودعم تجربتك عبر هذا الموقع، ولأغراض أخرى موضحة في %s.',
        'privacy policy'                    => 'سياسة الخصوصية',

        // Cart
        'Your cart is currently empty.'     => 'سلة التسوق فارغة حالياً.',
        'Return to shop'                    => 'العودة إلى المتجر',
        'Update cart'                       => 'تحديث السلة',
        'Proceed to checkout'               => 'متابعة عملية الشراء',
        'Apply coupon'                      => 'تطبيق الكوبون',
        'Coupon code'                       => 'رمز الكوبون',
        'Have a coupon?'                    => 'هل لديك كوبون؟',
        'Click here to enter your code'     => 'انقر هنا لإدخال رمزك',
        'Cart totals'                       => 'مجاميع السلة',
        'Remove this item'                  => 'إزالة هذا المنتج',

        // Address / fields (when WC fallbacks slip through)
        'First name'                        => 'الاسم الشخصي',
        'Last name'                         => 'الاسم العائلي',
        'Country / Region'                  => 'الدولة / المنطقة',
        'Street address'                    => 'العنوان',
        'Town / City'                       => 'المدينة',
        'State / County'                    => 'الجهة / الإقليم',
        'Postcode / ZIP'                    => 'الرمز البريدي',
        'Phone'                             => 'الهاتف',
        'Email address'                     => 'البريد الإلكتروني',
        'House number and street name'      => 'رقم المنزل واسم الشارع',
        'Apartment, suite, unit, etc. (optional)' => 'شقة، جناح، وحدة، إلخ. (اختياري)',

        // Generic "(optional)" label appended to field names
        '(optional)'                        => '(اختياري)',
    );
}

/**
 * Force the "(optional)" inside compound labels like "Phone (optional)" to render in Arabic.
 * WooCommerce builds those with sprintf + '%s (optional)', so we intercept the final label.
 */
add_filter( 'woocommerce_form_field_args', 'elena_ar_form_field_labels', 10, 3 );
function elena_ar_form_field_labels( $args, $key, $value ) {
    if ( ! elena_is_ar_wc_template() ) {
        return $args;
    }
    if ( ! empty( $args['label'] ) ) {
        $args['label'] = str_replace( '(optional)', '(اختياري)', $args['label'] );
    }
    if ( ! empty( $args['placeholder'] ) ) {
        $args['placeholder'] = str_replace( '(optional)', '(اختياري)', $args['placeholder'] );
    }
    return $args;
}

