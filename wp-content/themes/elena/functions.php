<?php
/**
 * Elena Theme Functions
 *
 * @package Elena
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'ELENA_VERSION', '1.0.0' );
define( 'ELENA_DIR', get_template_directory() );
define( 'ELENA_URI', get_template_directory_uri() );

/* ─────────────────────────────────────────────
 * 1. Theme Setup
 * ───────────────────────────────────────────── */
function elena_setup() {
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
add_action( 'after_setup_theme', 'elena_setup' );


/* ─────────────────────────────────────────────
 * 2. Enqueue Assets
 * ───────────────────────────────────────────── */
function elena_enqueue_assets() {
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

    // Localize AJAX + cart data
    wp_localize_script( 'elena-main-js', 'elenaData', array(
        'ajaxUrl'  => admin_url( 'admin-ajax.php' ),
        'nonce'    => wp_create_nonce( 'elena_nonce' ),
        'cartUrl'  => function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : '',
        'shopUrl'  => function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : '',
    ) );
}
add_action( 'wp_enqueue_scripts', 'elena_enqueue_assets' );


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
        echo '<p class="elena-no-products">No products found. Add some products to WooCommerce.</p>';
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
        'default'           => 'DELIVERY AVAILABLE ALL OVER MOROCCO',
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
