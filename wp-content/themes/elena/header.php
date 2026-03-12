<?php
/**
 * Elena Theme Header
 *
 * @package Elena
 */

if ( ! defined( 'ABSPATH' ) ) exit;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php bloginfo( 'description' ); ?>">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="elena-site">

    <!-- Announcement Bar -->
    <?php if ( get_theme_mod( 'elena_announcement_show', true ) ) : ?>
    <div class="elena-announcement-bar">
        <div class="elena-container">
            <p><?php echo esc_html( get_theme_mod( 'elena_announcement_text', 'DELIVERY AVAILABLE ALL OVER MOROCCO' ) ); ?></p>
        </div>
    </div>
    <?php endif; ?>

    <!-- Header / Navigation -->
    <header id="elena-header" class="elena-header">
        <div class="elena-container elena-header-inner">
            <!-- Logo -->
            <div class="elena-logo">
                <?php
                $custom_logo_id = get_theme_mod( 'custom_logo' );
                if ( $custom_logo_id && wp_get_attachment_image_src( $custom_logo_id ) ) :
                    the_custom_logo();
                else :
                ?>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="elena-logo-text">
                        ELENA
                    </a>
                <?php endif; ?>
            </div>

            <!-- Navigation -->
            <nav class="elena-nav" id="elena-nav">
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'elena-nav-list',
                    'walker'         => new Elena_Nav_Walker(),
                    'fallback_cb'    => function() {
                        echo '<ul class="elena-nav-list">';
                        echo '<li><a href="' . esc_url( home_url( '/' ) ) . '" class="elena-nav-link active">Home</a></li>';
                        if ( function_exists( 'wc_get_page_permalink' ) ) {
                            echo '<li><a href="' . esc_url( wc_get_page_permalink( 'shop' ) ) . '" class="elena-nav-link">Shop</a></li>';
                        }
                        echo '<li><a href="#" class="elena-nav-link">About</a></li>';
                        echo '<li><a href="#" class="elena-nav-link">Contact</a></li>';
                        echo '</ul>';
                    },
                ) );
                ?>
            </nav>

            <!-- Header Actions -->
            <div class="elena-header-actions">
                <!-- Order Online Button -->
                <a href="<?php echo esc_url( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : '#' ); ?>" class="elena-btn elena-btn-order">
                    <?php esc_html_e( 'Order Online', 'elena' ); ?>
                </a>

                <?php if ( class_exists( 'WooCommerce' ) ) : ?>
                <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="elena-cart-btn" title="<?php esc_attr_e( 'View cart', 'elena' ); ?>">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <path d="M16 10a4 4 0 0 1-8 0"></path>
                    </svg>
                    <span class="elena-cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                </a>
                <?php endif; ?>

                <!-- Mobile Menu Toggle -->
                <button class="elena-mobile-toggle" id="elena-mobile-toggle" aria-label="<?php esc_attr_e( 'Toggle Menu', 'elena' ); ?>">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </div>
    </header>

    <main id="content" class="elena-main">
