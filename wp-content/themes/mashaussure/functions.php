<?php
/**
 * Elena Theme Functions
 *
 * @package Elena
 * @version 1.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* ─────────────────────────────────────────────
 * Clean Language Management
 * ───────────────────────────────────────────── */

/**
 * Multilang-plugin detection — back off when xili-language or Polylang owns the language system.
 */
if ( ! function_exists( 'masha_is_multilang_plugin_active' ) ) {
    function masha_is_multilang_plugin_active() {
        return function_exists( 'xili_curlang' )
            || function_exists( 'the_curlang' )
            || function_exists( 'pll_current_language' )
            || defined( 'POLYLANG_VERSION' );
    }
}

/**
 * Early force lang=ar internally if the URL is Arabic but parameter is missing.
 */
add_action( 'init', 'masha_force_lang_internal', 1 );
function masha_force_lang_internal() {
    if ( masha_is_multilang_plugin_active() ) return;
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
        add_filter( 'locale', function() { return 'ar_AR'; }, 99 );
    }

    // Check cookie for persistence
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
add_filter( 'locale', 'masha_detect_and_force_locale', 20 );
function masha_detect_and_force_locale( $locale ) {
    // Defensive: never propagate a null/empty locale — WP >= 6.5 errors if set_locale() receives null.
    if ( ! is_string( $locale ) || $locale === '' ) {
        $locale = 'fr_FR';
    }

    if ( masha_is_multilang_plugin_active() ) return $locale;
    if ( is_admin() ) return $locale;

    if ( isset( $_GET['lang'] ) ) {
        $l = strtolower( sanitize_text_field( $_GET['lang'] ) );
        if ( strpos( $l, 'ar' ) === 0 ) return 'ar_AR';
        if ( strpos( $l, 'fr' ) === 0 ) return 'fr_FR';
    }

    $uri = $_SERVER['REQUEST_URI'];
    if ( strpos( $uri, '%D8' ) !== false || strpos( $uri, '%D9' ) !== false || preg_match( '/[\x{0600}-\x{06FF}]/u', urldecode( $uri ) ) ) {
        return 'ar_AR';
    }

    if ( isset( $_COOKIE['elena_lang'] ) ) {
        $cookie_lang = sanitize_text_field( $_COOKIE['elena_lang'] );
        if ( $cookie_lang === 'ar' ) return 'ar_AR';
        if ( $cookie_lang === 'fr' ) return 'fr_FR';
    }

    return $locale;
}


/**
 * Force WooCommerce Arabic translation
 */
add_action( 'init', 'masha_force_woocommerce_translation', 5 );
function masha_force_woocommerce_translation() {
    $loc = isset($_GET['lang']) ? $_GET['lang'] : get_locale();
    if (strpos($loc, 'ar') === 0 || $loc === 'ar_AR') {
        $mofile = WP_LANG_DIR . '/plugins/woocommerce-ar_AR.mo';
        if (file_exists($mofile)) {
            unload_textdomain('woocommerce');
            load_textdomain('woocommerce', $mofile);
        }
    }
}

/**
 * Force common WooCommerce strings to Arabic as a fallback
 */
add_filter( 'gettext', 'masha_force_arabic_strings', 20, 3 );
function masha_force_arabic_strings( $translated_text, $text, $domain ) {
    if ( $domain === 'woocommerce' ) {
        $loc = get_locale();
        if ( strpos($loc, 'ar') === 0 ) {
            $overrides = array(
                'Showing the single result' => 'عرض النتيجة الوحيدة',
                'Default sorting' => 'الترتيب الافتراضي',
                'Search products…' => 'البحث عن المنتجات...',
                'Add to cart' => 'أضف إلى السلة',
                'View cart' => 'عرض السلة',
                'Cart' => 'السلة',
            );
            if ( isset( $overrides[$text] ) ) {
                return $overrides[$text];
            }
        }
    }
    return $translated_text;
}

define( 'masha_legacy_legacy_VERSION', time() );


define( 'masha_legacy_legacy_DIR', get_template_directory() );
define( 'masha_legacy_legacy_URI', get_template_directory_uri() );

$masha_front_page_helpers = masha_legacy_legacy_DIR . '/inc/front-page-helpers.php';
if ( file_exists( $masha_front_page_helpers ) ) {
    require_once $masha_front_page_helpers;
}

/* ─────────────────────────────────────────────
 * 1. Theme Setup
 * ───────────────────────────────────────────── */
function masha_legacy_legacy_setup() {
    error_log('Masha Legacy: setup function called.');
    // Load text domain
    $domain = 'mashaussure';
    $path = wp_normalize_path(__DIR__ . '/languages');
    error_log("Masha Legacy: loading textdomain '$domain' from path '$path'");
    load_theme_textdomain($domain, $path);
    load_theme_textdomain('elena', $path);

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
        'primary'  => __( 'Primary Menu', 'elena' ),
        'footer'   => __( 'Footer Menu', 'elena' ),
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
add_action( 'after_setup_theme', 'masha_legacy_legacy_setup' );


/* ─────────────────────────────────────────────
 * 2. Enqueue Assets
 * ───────────────────────────────────────────── */
function masha_legacy_legacy_enqueue_assets() {
    // Google Fonts: Yeseva One + Montserrat + Inter
    wp_enqueue_style(
        'elena-google-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Yeseva+One&family=Montserrat:wght@400;500;600;700&display=swap',
        array(),
        null
    );

    // Main stylesheet
    wp_enqueue_style(
        'elena-main',
        masha_legacy_legacy_URI . '/assets/css/main.css',
        array( 'elena-google-fonts' ),
        masha_legacy_legacy_VERSION
    );

    // Theme stylesheet (WordPress requirement)
    wp_enqueue_style(
        'elena-style',
        get_stylesheet_uri(),
        array( 'elena-main' ),
        masha_legacy_legacy_VERSION
    );

    // Custom patches (for mobile fixes)
    wp_enqueue_style(
        'elena-custom-patches',
        masha_legacy_legacy_URI . '/assets/css/custom-patches.css',
        array( 'elena-style' ),
        masha_legacy_legacy_VERSION
    );

    // Main JS
    wp_enqueue_script(
        'elena-main-js',
        masha_legacy_legacy_URI . '/assets/js/main.js',
        array(),
        masha_legacy_legacy_VERSION,
        true
    );

    // Localize AJAX + cart data
    wp_localize_script( 'elena-main-js', 'elenaData', array(
        'ajaxUrl'  => admin_url( 'admin-ajax.php' ),
        'nonce'    => wp_create_nonce( 'masha_legacy_legacy_nonce' ),
        'cartUrl'  => function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : '',
        'shopUrl'  => function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : '',
    ) );
}
add_action( 'wp_enqueue_scripts', 'masha_legacy_legacy_enqueue_assets' );


/* ─────────────────────────────────────────────
 * 3. WooCommerce Support
 * ───────────────────────────────────────────── */
function masha_legacy_legacy_woocommerce_support() {
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
add_action( 'after_setup_theme', 'masha_legacy_legacy_woocommerce_support' );

// AJAX cart fragments
function masha_legacy_legacy_cart_count_fragment( $fragments ) {
    ob_start();
    ?>
    <span class="elena-cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
    <?php
    $fragments['.elena-cart-count'] = ob_get_clean();
    return $fragments;
}
if ( class_exists( 'WooCommerce' ) ) {
    add_filter( 'woocommerce_add_to_cart_fragments', 'masha_legacy_legacy_cart_count_fragment' );
}


/* ─────────────────────────────────────────────
 * 4. Elementor Pro Support
 * ───────────────────────────────────────────── */
function masha_legacy_legacy_register_elementor_locations( $elementor_theme_manager ) {
    $elementor_theme_manager->register_all_core_location();
}
add_action( 'elementor/theme/register_locations', 'masha_legacy_legacy_register_elementor_locations' );


/* ─────────────────────────────────────────────
 * 5. Widget Areas
 * ───────────────────────────────────────────── */
function masha_legacy_legacy_widgets_init() {
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
add_action( 'widgets_init', 'masha_legacy_legacy_widgets_init' );


/* ─────────────────────────────────────────────
 * 6. Custom Shortcodes
 * ───────────────────────────────────────────── */

// [masha_legacy_legacy_best_sellers count="4"]
function masha_legacy_legacy_best_sellers_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'count' => 4,
    ), $atts, 'masha_legacy_legacy_best_sellers' );

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
add_shortcode( 'masha_legacy_legacy_best_sellers', 'masha_legacy_legacy_best_sellers_shortcode' );


/* ─────────────────────────────────────────────
 * 7. Custom Walker for Navigation
 * ───────────────────────────────────────────── */
class masha_legacy_legacy_Nav_Walker extends Walker_Nav_Menu {
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
function masha_legacy_legacy_customize_register( $wp_customize ) {
    // Announcement Bar
    $wp_customize->add_section( 'masha_legacy_legacy_announcement', array(
        'title'    => __( 'Announcement Bar', 'elena' ),
        'priority' => 25,
    ) );

    $wp_customize->add_setting( 'masha_legacy_legacy_announcement_text', array(
        'default'           => __( 'DELIVERY AVAILABLE ALL OVER MOROCCO', 'elena' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'masha_legacy_legacy_announcement_text', array(
        'label'   => __( 'Announcement Text', 'elena' ),
        'section' => 'masha_legacy_legacy_announcement',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'masha_legacy_legacy_announcement_show', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ) );

    $wp_customize->add_control( 'masha_legacy_legacy_announcement_show', array(
        'label'   => __( 'Show Announcement Bar', 'elena' ),
        'section' => 'masha_legacy_legacy_announcement',
        'type'    => 'checkbox',
    ) );

    // Hero Section
    $wp_customize->add_section( 'masha_legacy_legacy_hero', array(
        'title'    => __( 'Hero Section', 'elena' ),
        'priority' => 30,
    ) );

    $wp_customize->add_setting( 'masha_legacy_legacy_hero_title', array(
        'default'           => 'Step Into Performance',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'masha_legacy_legacy_hero_title', array(
        'label'   => __( 'Hero Title', 'elena' ),
        'section' => 'masha_legacy_legacy_hero',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'masha_legacy_legacy_hero_subtitle', array(
        'default'           => 'Modern athletic footwear built for real performance. Lightweight materials, durable construction, and ergonomic design.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ) );

    $wp_customize->add_control( 'masha_legacy_legacy_hero_subtitle', array(
        'label'   => __( 'Hero Subtitle', 'elena' ),
        'section' => 'masha_legacy_legacy_hero',
        'type'    => 'textarea',
    ) );

    $wp_customize->add_setting( 'masha_legacy_legacy_hero_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'masha_legacy_legacy_hero_image', array(
        'label'   => __( 'Hero Background Image', 'elena' ),
        'section' => 'masha_legacy_legacy_hero',
    ) ) );

    $wp_customize->add_setting( 'masha_legacy_legacy_hero_cta_text', array(
        'default'           => 'See More',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'masha_legacy_legacy_hero_cta_text', array(
        'label'   => __( 'CTA Button Text', 'elena' ),
        'section' => 'masha_legacy_legacy_hero',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'masha_legacy_legacy_hero_cta_url', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ) );

    $wp_customize->add_control( 'masha_legacy_legacy_hero_cta_url', array(
        'label'   => __( 'CTA Button URL', 'elena' ),
        'section' => 'masha_legacy_legacy_hero',
        'type'    => 'url',
    ) );

    // CTA Section Image (Bottom CTA)
    $wp_customize->add_setting( 'masha_legacy_legacy_cta_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'masha_legacy_legacy_cta_image', array(
        'label'       => __( 'Bottom CTA Section Image', 'elena' ),
        'description' => __( 'Image used in the "Buy Your Sneakers Today" section at the bottom of the front page.', 'elena' ),
        'section'     => 'masha_legacy_legacy_hero',
    ) ) );

    // Footer
    $wp_customize->add_section( 'masha_legacy_legacy_footer', array(
        'title'    => __( 'Footer Settings', 'elena' ),
        'priority' => 90,
    ) );

    $wp_customize->add_setting( 'masha_legacy_legacy_footer_phone', array(
        'default'           => '+212 600 000 000',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'masha_legacy_legacy_footer_phone', array(
        'label'   => __( 'Phone Number', 'elena' ),
        'section' => 'masha_legacy_legacy_footer',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'masha_legacy_legacy_footer_email', array(
        'default'           => 'contact@elena.ma',
        'sanitize_callback' => 'sanitize_email',
    ) );
    $wp_customize->add_control( 'masha_legacy_legacy_footer_email', array(
        'label'   => __( 'Email', 'elena' ),
        'section' => 'masha_legacy_legacy_footer',
        'type'    => 'email',
    ) );

    $wp_customize->add_setting( 'masha_legacy_legacy_footer_address', array(
        'default'           => 'Casablanca, Morocco',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'masha_legacy_legacy_footer_address', array(
        'label'   => __( 'Address', 'elena' ),
        'section' => 'masha_legacy_legacy_footer',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'masha_legacy_legacy_instagram', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( 'masha_legacy_legacy_instagram', array(
        'label'   => __( 'Instagram URL', 'elena' ),
        'section' => 'masha_legacy_legacy_footer',
        'type'    => 'url',
    ) );

    $wp_customize->add_setting( 'masha_legacy_legacy_facebook', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( 'masha_legacy_legacy_facebook', array(
        'label'   => __( 'Facebook URL', 'elena' ),
        'section' => 'masha_legacy_legacy_footer',
        'type'    => 'url',
    ) );

    /* Machaussure: Promo banner */
    $wp_customize->add_section( 'masha_legacy_legacy_promo', array(
        'title'    => __( 'Bannière promo (Machaussure)', 'mashaussure' ),
        'priority' => 28,
    ) );
    $wp_customize->add_setting( 'masha_legacy_legacy_promo_show', array( 'default' => false, 'sanitize_callback' => 'wp_validate_boolean' ) );
    $wp_customize->add_control( 'masha_legacy_legacy_promo_show', array( 'label' => __( 'Afficher la bannière promo', 'mashaussure' ), 'section' => 'masha_legacy_legacy_promo', 'type' => 'checkbox' ) );
    $wp_customize->add_setting( 'masha_legacy_legacy_promo_title', array( 'default' => 'رمضان كريم', 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'masha_legacy_legacy_promo_title', array( 'label' => __( 'Titre promo', 'mashaussure' ), 'section' => 'masha_legacy_legacy_promo', 'type' => 'text' ) );
    $wp_customize->add_setting( 'masha_legacy_legacy_promo_text', array( 'default' => 'Nouvelle Collection', 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'masha_legacy_legacy_promo_text', array( 'label' => __( 'Texte promo', 'mashaussure' ), 'section' => 'masha_legacy_legacy_promo', 'type' => 'text' ) );
    $wp_customize->add_setting( 'masha_legacy_legacy_promo_discount', array( 'default' => '-30%', 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'masha_legacy_legacy_promo_discount', array( 'label' => __( 'Réduction (ex: -30%)', 'mashaussure' ), 'section' => 'masha_legacy_legacy_promo', 'type' => 'text' ) );
    $wp_customize->add_setting( 'masha_legacy_legacy_promo_btn', array( 'default' => 'Découvrir', 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'masha_legacy_legacy_promo_btn', array( 'label' => __( 'Bouton', 'mashaussure' ), 'section' => 'masha_legacy_legacy_promo', 'type' => 'text' ) );
    $wp_customize->add_setting( 'masha_legacy_legacy_promo_url', array( 'default' => '', 'sanitize_callback' => 'esc_url_raw' ) );
    $wp_customize->add_control( 'masha_legacy_legacy_promo_url', array( 'label' => __( 'URL du bouton', 'mashaussure' ), 'section' => 'masha_legacy_legacy_promo', 'type' => 'url' ) );
    $wp_customize->add_setting( 'masha_legacy_legacy_promo_all_pages', array( 'default' => false, 'sanitize_callback' => 'wp_validate_boolean' ) );
    $wp_customize->add_control( 'masha_legacy_legacy_promo_all_pages', array( 'label' => __( 'Afficher sur toutes les pages', 'mashaussure' ), 'section' => 'masha_legacy_legacy_promo', 'type' => 'checkbox' ) );
}
add_action( 'customize_register', 'masha_legacy_legacy_customize_register' );


/* ─────────────────────────────────────────────
 * 9. Remove WooCommerce default styles selectively
 * ───────────────────────────────────────────── */
/* add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' ); */



/* ─────────────────────────────────────────────
 * 10. Admin: Theme requirements notice
 * ───────────────────────────────────────────── */
// Remove WooCommerce default sidebar on single product pages
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

function masha_legacy_legacy_admin_notice() {
    if ( ! class_exists( 'WooCommerce' ) ) {
        echo '<div class="notice notice-warning is-dismissible">';
        echo '<p><strong>Elena Theme:</strong> WooCommerce is recommended for the best experience. <a href="' . admin_url( 'plugin-install.php?s=woocommerce&tab=search&type=term' ) . '">Install WooCommerce</a></p>';
        echo '</div>';
    }
}
add_action( 'admin_notices', 'masha_legacy_legacy_admin_notice' );

/* ─────────────────────────────────────────────
 * 11. Product Page – Matching machaussure.ma reference
 * ───────────────────────────────────────────── */

// Change "Add to Cart" button text to "AJOUTER AU PANIER"
add_filter( 'woocommerce_product_single_add_to_cart_text', 'masha_legacy_legacy_custom_cart_button_text' );
function masha_legacy_legacy_custom_cart_button_text() {
    $loc = isset($_GET['lang']) ? $_GET['lang'] : get_locale();
    if (strpos($loc, 'ar') === 0 || $loc === 'ar_AR') {
        return 'أضف إلى السلة';
    }
    return 'AJOUTER AU PANIER';
}

// Also override for variable products
add_filter( 'woocommerce_product_add_to_cart_text', 'masha_legacy_legacy_custom_cart_button_text_archive' );
function masha_legacy_legacy_custom_cart_button_text_archive( $text ) {
    global $product;
    if ( $product && $product->is_type( 'variable' ) && is_product() ) {
        $loc = isset($_GET['lang']) ? $_GET['lang'] : get_locale();
        if (strpos($loc, 'ar') === 0 || $loc === 'ar_AR') {
            return 'أضف إلى السلة';
        }
        return 'AJOUTER AU PANIER';
    }
    return $text;
}

// Add Buy Now button after the cart form
add_action( 'woocommerce_after_add_to_cart_button', 'masha_final_legacy_add_buy_now_button' );
function masha_final_legacy_add_buy_now_button() {
    global $product;
    $loc = isset($_GET['lang']) ? $_GET['lang'] : get_locale();
    $text = (strpos($loc, 'ar') === 0) ? 'اشتري الآن' : 'BUY NOW';
    echo '<button type="submit" name="masha-buy-now" value="1" class="masha-buy-now-btn button alt">' . esc_html($text) . '</button>';
}

// Add wishlist & size guide links after add to cart form
add_action( 'woocommerce_after_add_to_cart_form', 'masha_legacy_legacy_add_extra_links', 5 );
function masha_legacy_legacy_add_extra_links() {
    $loc = isset($_GET['lang']) ? $_GET['lang'] : get_locale();
    $wishlist = (strpos($loc, 'ar') === 0) ? 'أضف إلى المفضلة' : 'Add to wishlist';
    $size = (strpos($loc, 'ar') === 0) ? 'دليل المقاسات' : 'Size guide';
    echo '<div class="masha-product-extras">';
    echo '<a href="#"><span>♡</span> ' . esc_html($wishlist) . '</a>';
    echo '<a href="#"><span>📏</span> ' . esc_html($size) . '</a>';
    echo '</div>';
}

// Show stock status before add to cart
add_action( 'woocommerce_before_add_to_cart_form', 'masha_legacy_legacy_show_stock_status', 10 );
function masha_legacy_legacy_show_stock_status() {
    global $product;
    $loc = isset($_GET['lang']) ? $_GET['lang'] : get_locale();
    if ( $product->is_in_stock() ) {
        $text = (strpos($loc, 'ar') === 0) ? 'مخزون متوفر' : 'En stock';
        echo '<p class="stock in-stock">' . esc_html($text) . '</p>';
    } else {
        $text = (strpos($loc, 'ar') === 0) ? 'غير متوفر' : 'Rupture de stock';
        echo '<p class="stock out-of-stock">' . esc_html($text) . '</p>';
    }
}

// Handle Buy Now redirect
add_filter( 'woocommerce_add_to_cart_redirect', 'masha_legacy_legacy_buy_now_redirect' );
function masha_legacy_legacy_buy_now_redirect( $url ) {
    if ( isset( $_POST['masha-buy-now'] ) ) {
        return wc_get_checkout_url();
    }
    return $url;
}

// Add quantity +/- buttons
add_action( 'woocommerce_before_quantity_input_field', 'masha_legacy_legacy_quantity_minus_btn' );
function masha_legacy_legacy_quantity_minus_btn() {
    echo '<button type="button" class="masha-qty-btn masha-qty-minus" aria-label="Decrease quantity">-</button>';
}

add_action( 'woocommerce_after_quantity_input_field', 'masha_legacy_legacy_quantity_plus_btn' );
function masha_legacy_legacy_quantity_plus_btn() {
    echo '<button type="button" class="masha-qty-btn masha-qty-plus" aria-label="Increase quantity">+</button>';
}

// Add "Livraison" tab to product tabs
add_filter( 'woocommerce_product_tabs', 'masha_legacy_legacy_add_livraison_tab' );
function masha_legacy_legacy_add_livraison_tab( $tabs ) {
    $loc = isset($_GET['lang']) ? $_GET['lang'] : get_locale();
    $tabs['livraison'] = array(
        'title'    => (strpos($loc, 'ar') === 0) ? 'التوصيل' : __( 'Livraison', 'mashaussure' ),
        'priority' => 40,
        'callback' => 'masha_legacy_legacy_livraison_tab_content',
    );
    return $tabs;
}

function masha_legacy_legacy_livraison_tab_content() {
    $loc = isset($_GET['lang']) ? $_GET['lang'] : get_locale();
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

// Remove default WooCommerce breadcrumbs (we handle them in the template)
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

/**
 * Add Language Selection to Categories and Product Categories
 */
add_action( 'init', 'masha_add_taxonomy_language_fields' );
function masha_add_taxonomy_language_fields() {
    $taxonomies = array( 'category', 'product_cat' );
    foreach ( $taxonomies as $taxonomy ) {
        add_action( $taxonomy . "_add_form_fields", 'masha_add_category_language_field', 10, 1 );
        add_action( $taxonomy . "_edit_form_fields", 'masha_edit_category_language_field', 10, 2 );
        add_action( "created_" . $taxonomy, 'masha_save_category_language_field', 10, 2 );
        add_action( "edited_" . $taxonomy, 'masha_save_category_language_field', 10, 2 );
    }
}

function masha_add_category_language_field( $taxonomy ) {
    ?>
    <div class="form-field term-language-wrap">
        <label for="category_language"><?php esc_html_e( 'Language', 'mashaussure' ); ?></label>
        <select name="category_language" id="category_language">
            <option value="all"><?php esc_html_e( 'All Languages', 'mashaussure' ); ?></option>
            <option value="ar">Arabic</option>
            <option value="fr">French</option>
            <option value="en">English</option>
        </select>
        <p><?php esc_html_e( 'Select the language this category applies to.', 'mashaussure' ); ?></p>
    </div>
    <?php
}

function masha_edit_category_language_field( $term, $taxonomy ) {
    $lang = get_term_meta( $term->term_id, 'category_language', true );
    if ( empty( $lang ) ) $lang = 'all';
    ?>
    <tr class="form-field term-language-wrap">
        <th scope="row"><label for="category_language"><?php esc_html_e( 'Language', 'mashaussure' ); ?></label></th>
        <td>
            <select name="category_language" id="category_language">
                <option value="all" <?php selected( $lang, 'all' ); ?>><?php esc_html_e( 'All Languages', 'mashaussure' ); ?></option>
                <option value="ar" <?php selected( $lang, 'ar' ); ?>>Arabic</option>
                <option value="fr" <?php selected( $lang, 'fr' ); ?>>French</option>
                <option value="en" <?php selected( $lang, 'en' ); ?>>English</option>
            </select>
            <p class="description"><?php esc_html_e( 'Select the language this category applies to.', 'mashaussure' ); ?></p>
        </td>
    </tr>
    <?php
}

function masha_save_category_language_field( $term_id, $tt_id ) {
    if ( isset( $_POST['category_language'] ) ) {
        update_term_meta( $term_id, 'category_language', sanitize_text_field( $_POST['category_language'] ) );
    }
}

/**
 * Clean up URLs: Redirect ?lang=ar_ar to clean URL if possible.
 */
add_action( 'template_redirect', 'masha_clean_language_urls', 1 );
function masha_clean_language_urls() {
    if ( masha_is_multilang_plugin_active() ) return;
    if ( is_admin() ) return;

    if ( isset( $_GET['lang'] ) && strpos( $_SERVER['QUERY_STRING'], 'lang=' ) !== false ) {
        $lang = strtolower( sanitize_text_field( $_GET['lang'] ) );
        
        if ( strpos( $lang, 'ar' ) === 0 ) {
            setcookie( 'elena_lang', 'ar', time() + ( 86400 * 30 ), '/' );
            $url = remove_query_arg( 'lang' );
            wp_redirect( $url, 301 );
            exit;
        } elseif ( strpos( $lang, 'fr' ) === 0 ) {
            setcookie( 'elena_lang', 'fr', time() + ( 86400 * 30 ), '/' );
            $url = remove_query_arg( 'lang' );
            wp_redirect( $url, 301 );
            exit;
        }
    }
}

/**
 * Adjust term links: Don't add ?lang=ar if the content is Arabic or cookie is set.
 */
add_filter( 'term_link', 'masha_adjust_category_link_language', 10, 3 );
function masha_adjust_category_link_language( $termlink, $term, $taxonomy ) {
    if ( masha_is_multilang_plugin_active() ) return $termlink;
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
add_filter( 'post_type_link', 'masha_adjust_product_link_language', 20, 2 );
function masha_adjust_product_link_language( $post_link, $post ) {
    if ( masha_is_multilang_plugin_active() ) return $post_link;
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
    
    if ( ! empty( $current_lang ) && $current_lang !== 'ar' ) {
        return add_query_arg( 'lang', $current_lang, $post_link );
    }
    
    return $post_link;
}
